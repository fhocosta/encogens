<?php

namespace ApiBundle\Handler;

use ApiBundle\Entity\Nota;
use ApiBundle\Form\NotaType;
use ApiBundle\Exception\InvalidFormException;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;

class NotaRESTHandler
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
        $nota = $this->createNota();

        return $this->processForm($nota, $parameters, 'POST');
    }

    public function put(Nota $nota, array $parameters)
    {
        return $this->processForm($nota, $parameters, 'PUT');
    }

    public function patch(Nota $nota, array $parameters)
    {
        return $this->processForm($nota, $parameters, 'PATCH');
    }

    public function delete(Nota $nota)
    {
        try {
            $this->om->remove($nota);
            $this->om->flush();

            return null;
        } catch (\Exception $e) {
            throw new \RuntimeException();
        }
    }

    private function processForm(Nota $nota, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new NotaType(), $nota, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {
            $nota = $form->getData();
            $this->om->persist($nota);
            $this->om->flush($nota);

            return $nota;
        }
        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createNota()
    {
        return new $this->entityClass();
    }

}