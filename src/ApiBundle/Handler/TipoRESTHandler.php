<?php

namespace ApiBundle\Handler;

use ApiBundle\Entity\Tipo;
use ApiBundle\Form\TipoType;
use ApiBundle\Exception\InvalidFormException;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;

class TipoRESTHandler
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
        $tipo = $this->createTipo();

        return $this->processForm($tipo, $parameters, 'POST');
    }

    public function put(Tipo $tipo, array $parameters)
    {
        return $this->processForm($tipo, $parameters, 'PUT');
    }

    public function patch(Tipo $tipo, array $parameters)
    {
        return $this->processForm($tipo, $parameters, 'PATCH');
    }

    public function delete(Tipo $tipo)
    {
        try {
            $this->om->remove($tipo);
            $this->om->flush();

            return null;
        } catch (\Exception $e) {
            throw new \RuntimeException();
        }
    }

    private function processForm(Tipo $tipo, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new TipoType(), $tipo, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {
            $tipo = $form->getData();
            $this->om->persist($tipo);
            $this->om->flush($tipo);

            return $tipo;
        }
        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createTipo()
    {
        return new $this->entityClass();
    }

}