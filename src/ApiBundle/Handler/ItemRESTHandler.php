<?php

namespace ApiBundle\Handler;

use ApiBundle\Entity\Item;
use ApiBundle\Form\ItemType;
use ApiBundle\Exception\InvalidFormException;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;

class ItemRESTHandler
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
        $item = $this->createItem();

        return $this->processForm($item, $parameters, 'POST');
    }

    public function put(Item $item, array $parameters)
    {
        return $this->processForm($item, $parameters, 'PUT');
    }

    public function patch(Item $item, array $parameters)
    {
        return $this->processForm($item, $parameters, 'PATCH');
    }

    public function delete(Item $item)
    {
        try {
            $this->om->remove($item);
            $this->om->flush();

            return null;
        } catch (\Exception $e) {
            throw new \RuntimeException();
        }
    }

    private function processForm(Item $item, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new ItemType(), $item, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {
            $item = $form->getData();
            $this->om->persist($item);
            $this->om->flush($item);

            return $item;
        }
        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createItem()
    {
        return new $this->entityClass();
    }

}