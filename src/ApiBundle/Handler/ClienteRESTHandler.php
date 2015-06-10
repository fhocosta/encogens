<?php

namespace ApiBundle\Handler;

use ApiBundle\Entity\Cliente;
use ApiBundle\Form\ClienteType;
use ApiBundle\Exception\InvalidFormException;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;

class ClienteRESTHandler
{
    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
    }

    public function get($id)
    {
        return $this->repository->find($id);
    }

    public function getAll($filters = array(), $order_by = null, $limit = null, $offset = null)
    {
        return $this->repository->findBy($filters, $order_by, $limit, $offset);
    }

    public function post($parameters)
    {
        $cliente = $this->createCliente();

        return $this->processForm($cliente, $parameters, 'POST');
    }

    public function put(Cliente $cliente, array $parameters)
    {
        return $this->processForm($cliente, $parameters, 'PUT');
    }

    public function patch(Cliente $cliente, array $parameters)
    {
        return $this->processForm($cliente, $parameters, 'PATCH');
    }

    public function delete(Cliente $cliente)
    {
        try {
            $this->om->remove($cliente);
            $this->om->flush();

            return null;
        } catch (\Exception $e) {
            throw new \RuntimeException();
        }
    }

    private function processForm(Cliente $cliente, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new ClienteType(), $cliente, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {
            $cliente = $form->getData();
            $this->om->persist($cliente);
            $this->om->flush($cliente);

            return $cliente;
        }
        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createCliente()
    {
        return new $this->entityClass();
    }

}