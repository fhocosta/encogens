<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Tipo;
use ApiBundle\Form\TipoType;
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
 * Tipo controller.
 * @RouteResource("Tipo")
 */
class TipoRESTController extends FOSRestController
{
  /**
    * Get a Tipo entity
    *
    * @ApiDoc(
    *   resource = true,
    *   description = "Get a Tipo entity.",
    *   statusCodes = {
    *     200 = "Tipo's object.",
    *     404 = "Not Found."
    *   }
    * )
    * @View(serializerEnableMaxDepthChecks=true)
    *
    * @return Response
    */
    public function getAction($id)
    {
        $answer['tipo'] = $this->getOr404($id);
        return $answer;
    }
  /**
    * Get all Tipo entities.
    *
    * @ApiDoc(
    *   resource = true,
    *   description = "Get all Tipo entities.",
    *   statusCodes = {
    *     200 = "List of Tipo",
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

        $answer['tipo'] =  $this->container->get('api.tipo.handler')->getAll($filters, $order_by, $limit, $offset);
        if ($answer['tipo']) {
            return $answer;
        }
        return null;
    }
  /**
    * Create a Tipo entity.
    *
    * @ApiDoc(
    *   resource = true,
    *   description = "Create a Tipo entity.",
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
            $new  =  $this->container->get('api.tipo.handler')->post($request->request->all());
            $answer['tipo'] = $new;

            return $answer;
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }
  /**
    * Update a Tipo entity.
    *
    * @ApiDoc(
    *   resource = true,
    *   description = "Update a Tipo entity.",
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
            if ($tipo = $this->container->get('api.tipo.handler')->get($id)) {
                $answer['tipo']= $this->container->get('api.tipo.handler')->put($tipo, $request->request->all());
                $code = Codes::HTTP_OK;
            } else {
                $answer['tipo'] = $this->container->get('api.tipo.handler')->post($request->request->all());
                $code = Codes::HTTP_CREATED;
            }
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }

        $view = $this->view($answer, $code);
        return $this->handleView($view);
    }
  /**
    * Partial Update to a Tipo entity.
    *
    * @ApiDoc(
    *   resource = true,
    *   description = "Partial Update to a Tipo entity.",
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
        $answer['tipo'] = $this->container->get('api.tipo.handler')->patch($this->getOr404($id), $request->request->all());
        return $answer;
    }
  /**
    * Delete a Tipo entity.
    *
    * @ApiDoc(
    *   resource = true,
    *   description = "Delete a Tipo entity.",
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
        $tipo = $this->getOr404($id);
        try {
            return $this->container->get('api.tipo.handler')->delete($tipo);
        } catch (\Exception $exception) {
            throw new \RuntimeException("Exclusion not allowed");
        }
    }

    protected function getOr404($id)
    {
        if (!($entity = $this->container->get('api.tipo.handler')->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        return $entity;
    }

}
