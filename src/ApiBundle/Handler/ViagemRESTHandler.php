<?php

namespace ApiBundle\Handler;

use ApiBundle\Entity\Viagem;
use ApiBundle\Form\ViagemType;
use ApiBundle\Exception\InvalidFormException;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;

class ViagemRESTHandler
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
        $viagem = $this->createViagem();

        return $this->processForm($viagem, $parameters, 'POST');
    }

    public function put(Viagem $viagem, array $parameters)
    {
        return $this->processForm($viagem, $parameters, 'PUT');
    }

    public function patch(Viagem $viagem, array $parameters)
    {
        return $this->processForm($viagem, $parameters, 'PATCH');
    }

    public function delete(Viagem $viagem)
    {
        try {
            $this->om->remove($viagem);
            $this->om->flush();

            return null;
        } catch (\Exception $e) {
            throw new \RuntimeException();
        }
    }

    private function processForm(Viagem $viagem, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new ViagemType(), $viagem, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {
            $viagem = $form->getData();
            $this->om->persist($viagem);
            $this->om->flush($viagem);

            return $viagem;
        }
        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createViagem()
    {
        return new $this->entityClass();
    }

}