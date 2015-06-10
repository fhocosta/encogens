<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Item;
use ApiBundle\Form\ItemType;
use ApiBundle\Exception\InvalidFormException;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View as FOSView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Item controller.
 * @RouteResource("Item")
 */
class ItemRESTController extends FOSRestController
{
  /**
    * Get a Item entity
    *
    * @ApiDoc(
    *   resource = true,
    *   description = "Get a Item entity.",
    *   statusCodes = {
    *     200 = "Item's object.",
    *     404 = "Not Found."
    *   }
    * )
    * @View(serializerEnableMaxDepthChecks=true)
    *
    * @return Response
    */
    public function getAction($id)
    {
        $answer['item'] = $this->getOr404($id);
        return $answer;
    }
  /**
    * Get all Item entities.
    *
    * @ApiDoc(
    *   resource = true,
    *   description = "Get all Item entities.",
    *   statusCodes = {
    *     200 = "List of Item",
    *     204 = "No content. Nothing to list."
    *   }
    * )
    * @View(serializerEnableMaxDepthChecks=true)
    *
    * @param ParamFetcherInterface $paramFetcher
    *
    * @return Response
    *
    * @QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing notes.")
    * @QueryParam(name="limit", requirements="\d+", default="20", description="How many notes to return.")
    * @QueryParam(name="order_by", nullable=true, array=true, description="Order by fields. Must be an array ie. &order_by[name]=ASC&order_by[description]=DESC")
    * @QueryParam(name="filters", nullable=true, array=true, description="Filter by fields. Must be an array ie. &filters[id]=3")
    */
    public function cgetAction(ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');
        $order_by = $paramFetcher->get('order_by');
        $filters = !is_null($paramFetcher->get('filters')) ? $paramFetcher->get('filters') : array();

        $answer['item'] =  $this->container->get('api.item.handler')->getAll($filters, $order_by, $limit, $offset);
        if ($answer['item']) {
            return $answer;
        }
        return null;
    }
  /**
    * Create a Item entity.
    *
    * @ApiDoc(
    *   resource = true,
    *   description = "Create a Item entity.",
    *   statusCodes = {
    *     201 = "Created object.",
    *     400 = "Bad Request. Verify your params.",
    *     404 = "Not Found."
    *   }
    * )
    * @View(statusCode=201, serializerEnableMaxDepthChecks=true)
    *
    * @param Request $request
    *
    * @return Response
    */
    public function postAction(Request $request)
    {
        try {
            $new  =  $this->container->get('api.item.handler')->post($request->request->all());
            $answer['item'] = $new;

            return $answer;
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }
  /**
    * Update a Item entity.
    *
    * @ApiDoc(
    *   resource = true,
    *   description = "Update a Item entity.",
    *   statusCodes = {
    *     200 = "Updated object.",
    *     201 = "Created object.",
    *     400 = "Bad Request. Verify your params.",
    *     404 = "Not Found."
    *   }
    * )
    * @View(serializerEnableMaxDepthChecks=true)
    *
    * @param Request $request
    * @param $entity
    *
    * @return Response
    */
    public function putAction(Request $request, $id)
    {
        try {
            if ($item = $this->container->get('api.item.handler')->get($id)) {
                $answer['item']= $this->container->get('api.item.handler')->put($item, $request->request->all());
                $code = Codes::HTTP_OK;
            } else {
                $answer['item'] = $this->container->get('api.item.handler')->post($request->request->all());
                $code = Codes::HTTP_CREATED;
            }
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }

        $view = $this->view($answer, $code);
        return $this->handleView($view);
    }
  /**
    * Partial Update to a Item entity.
    *
    * @ApiDoc(
    *   resource = true,
    *   description = "Partial Update to a Item entity.",
    *   statusCodes = {
    *     200 = "Updated object.",
    *     400 = "Bad Request. Verify your params.",
    *     404 = "Not Found."
    *   }
    * )
    * @View(serializerEnableMaxDepthChecks=true)
    *
    * @param Request $request
    * @param $entity
    *
    * @return Response
    */
    public function patchAction(Request $request, $id)
    {
        $answer['item'] = $this->container->get('api.item.handler')->patch($this->getOr404($id), $request->request->all());
        return $answer;
    }
  /**
    * Delete a Item entity.
    *
    * @ApiDoc(
    *   resource = true,
    *   description = "Delete a Item entity.",
    *   statusCodes = {
    *     204 = "No content. Successfully excluded.",
    *     404 = "Not found."
    *   }
    * )
    * @View(statusCode=204)
    *
    * @param Request $request
    * @param $entity
    * @internal param $id
    *
    * @return Response
    */
    public function deleteAction($id)
    {
        $item = $this->getOr404($id);
        try {
            return $this->container->get('api.item.handler')->delete($item);
        } catch (\Exception $exception) {
            throw new \RuntimeException("Exclusion not allowed");
        }
    }

    protected function getOr404($id)
    {
        if (!($entity = $this->container->get('api.item.handler')->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        return $entity;
    }

}
