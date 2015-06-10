<?php

namespace ApiBundle\Handler;

use ApiBundle\Entity\Pacote;
use ApiBundle\Form\PacoteType;
use ApiBundle\Exception\InvalidFormException;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;

class PacoteRESTHandler
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
        $pacote = $this->createPacote();

        return $this->processForm($pacote, $parameters, 'POST');
    }

    public function put(Pacote $pacote, array $parameters)
    {
        return $this->processForm($pacote, $parameters, 'PUT');
    }

    public function patch(Pacote $pacote, array $parameters)
    {
        return $this->processForm($pacote, $parameters, 'PATCH');
    }

    public function delete(Pacote $pacote)
    {
        try {
            $this->om->remove($pacote);
            $this->om->flush();

            return null;
        } catch (\Exception $e) {
            throw new \RuntimeException();
        }
    }

    private function processForm(Pacote $pacote, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new PacoteType(), $pacote, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {
            $pacote = $form->getData();
            $this->om->persist($pacote);
            $this->om->flush($pacote);

            return $pacote;
        }
        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createPacote()
    {
        return new $this->entityClass();
    }

}