<?php

namespace Ilios\CoreBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Ilios\CoreBundle\Exception\InvalidFormException;
use Ilios\CoreBundle\Handler\RecurringEventHandler;
use Ilios\CoreBundle\Entity\RecurringEventInterface;

/**
 * Class RecurringEventController
 * @package Ilios\CoreBundle\Controller
 * @RouteResource("RecurringEvents")
 */
class RecurringEventController extends FOSRestController
{
    /**
     * Get a RecurringEvent
     *
     * @ApiDoc(
     *   section = "RecurringEvent",
     *   description = "Get a RecurringEvent.",
     *   resource = true,
     *   requirements={
     *     {
     *        "name"="id",
     *        "dataType"="integer",
     *        "requirement"="\d+",
     *        "description"="RecurringEvent identifier."
     *     }
     *   },
     *   output="Ilios\CoreBundle\Entity\RecurringEvent",
     *   statusCodes={
     *     200 = "RecurringEvent.",
     *     404 = "Not Found."
     *   }
     * )
     *
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     *
     * @param $id
     *
     * @return Response
     */
    public function getAction($id)
    {
        $answer['recurringEvents'][] = $this->getOr404($id);

        return $answer;
    }

    /**
     * Get all RecurringEvent.
     *
     * @ApiDoc(
     *   section = "RecurringEvent",
     *   description = "Get all RecurringEvent.",
     *   resource = true,
     *   output="Ilios\CoreBundle\Entity\RecurringEvent",
     *   statusCodes = {
     *     200 = "List of all RecurringEvent",
     *     204 = "No content. Nothing to list."
     *   }
     * )
     *
     * @QueryParam(
     *   name="offset",
     *   requirements="\d+",
     *   nullable=true,
     *   description="Offset from which to start listing notes."
     * )
     * @QueryParam(
     *   name="limit",
     *   requirements="\d+",
     *   default="20",
     *   description="How many notes to return."
     * )
     * @QueryParam(
     *   name="order_by",
     *   nullable=true,
     *   array=true,
     *   description="Order by fields. Must be an array ie. &order_by[name]=ASC&order_by[description]=DESC"
     * )
     * @QueryParam(
     *   name="filters",
     *   nullable=true,
     *   array=true,
     *   description="Filter by fields. Must be an array ie. &filters[id]=3"
     * )
     *
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return Response
     */
    public function cgetAction(ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');
        $orderBy = $paramFetcher->get('order_by');
        $criteria = !is_null($paramFetcher->get('filters')) ? $paramFetcher->get('filters') : [];
        $criteria = array_map(function ($item) {
            $item = $item == 'null' ? null : $item;
            $item = $item == 'false' ? false : $item;
            $item = $item == 'true' ? true : $item;

            return $item;
        }, $criteria);

        $result = $this->getRecurringEventHandler()
            ->findRecurringEventsBy(
                $criteria,
                $orderBy,
                $limit,
                $offset
            );

        //If there are no matches return an empty array
        $answer['recurringEvents'] =
            $result ? $result : new ArrayCollection([]);

        return $answer;
    }

    /**
     * Create a RecurringEvent.
     *
     * @ApiDoc(
     *   section = "RecurringEvent",
     *   description = "Create a RecurringEvent.",
     *   resource = true,
     *   input="Ilios\CoreBundle\Form\Type\RecurringEventType",
     *   output="Ilios\CoreBundle\Entity\RecurringEvent",
     *   statusCodes={
     *     201 = "Created RecurringEvent.",
     *     400 = "Bad Request.",
     *     404 = "Not Found."
     *   }
     * )
     *
     * @Rest\View(statusCode=201, serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postAction(Request $request)
    {
        try {
            $new  =  $this->getRecurringEventHandler()
                ->post($this->getPostData($request));
            $answer['recurringEvents'] = [$new];

            $view = $this->view($answer, Codes::HTTP_CREATED);

            return $this->handleView($view);
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Update a RecurringEvent.
     *
     * @ApiDoc(
     *   section = "RecurringEvent",
     *   description = "Update a RecurringEvent entity.",
     *   resource = true,
     *   input="Ilios\CoreBundle\Form\Type\RecurringEventType",
     *   output="Ilios\CoreBundle\Entity\RecurringEvent",
     *   statusCodes={
     *     200 = "Updated RecurringEvent.",
     *     201 = "Created RecurringEvent.",
     *     400 = "Bad Request.",
     *     404 = "Not Found."
     *   }
     * )
     *
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $id
     *
     * @return Response
     */
    public function putAction(Request $request, $id)
    {
        try {
            $recurringEvent = $this->getRecurringEventHandler()
                ->findRecurringEventBy(['id'=> $id]);
            if ($recurringEvent) {
                $code = Codes::HTTP_OK;
            } else {
                $recurringEvent = $this->getRecurringEventHandler()
                    ->createRecurringEvent();
                $code = Codes::HTTP_CREATED;
            }

            $answer['recurringEvent'] =
                $this->getRecurringEventHandler()->put(
                    $recurringEvent,
                    $this->getPostData($request)
                );
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }

        $view = $this->view($answer, $code);

        return $this->handleView($view);
    }

    /**
     * Partial Update to a RecurringEvent.
     *
     * @ApiDoc(
     *   section = "RecurringEvent",
     *   description = "Partial Update to a RecurringEvent.",
     *   resource = true,
     *   input="Ilios\CoreBundle\Form\Type\RecurringEventType",
     *   output="Ilios\CoreBundle\Entity\RecurringEvent",
     *   requirements={
     *     {
     *         "name"="id",
     *         "dataType"="integer",
     *         "requirement"="\d+",
     *         "description"="RecurringEvent identifier."
     *     }
     *   },
     *   statusCodes={
     *     200 = "Updated RecurringEvent.",
     *     400 = "Bad Request.",
     *     404 = "Not Found."
     *   }
     * )
     *
     * @Rest\View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $id
     *
     * @return Response
     */
    public function patchAction(Request $request, $id)
    {
        $answer['recurringEvent'] =
            $this->getRecurringEventHandler()->patch(
                $this->getOr404($id),
                $this->getPostData($request)
            );

        return $answer;
    }

    /**
     * Delete a RecurringEvent.
     *
     * @ApiDoc(
     *   section = "RecurringEvent",
     *   description = "Delete a RecurringEvent entity.",
     *   resource = true,
     *   requirements={
     *     {
     *         "name" = "id",
     *         "dataType" = "integer",
     *         "requirement" = "\d+",
     *         "description" = "RecurringEvent identifier"
     *     }
     *   },
     *   statusCodes={
     *     204 = "No content. Successfully deleted RecurringEvent.",
     *     400 = "Bad Request.",
     *     404 = "Not found."
     *   }
     * )
     *
     * @Rest\View(statusCode=204)
     *
     * @param $id
     * @internal RecurringEventInterface $recurringEvent
     *
     * @return Response
     */
    public function deleteAction($id)
    {
        $recurringEvent = $this->getOr404($id);

        try {
            $this->getRecurringEventHandler()
                ->deleteRecurringEvent($recurringEvent);

            return new Response('', Codes::HTTP_NO_CONTENT);
        } catch (\Exception $exception) {
            throw new \RuntimeException("Deletion not allowed");
        }
    }

    /**
     * Get a entity or throw a exception
     *
     * @param $id
     * @return RecurringEventInterface $recurringEvent
     */
    protected function getOr404($id)
    {
        $recurringEvent = $this->getRecurringEventHandler()
            ->findRecurringEventBy(['id' => $id]);
        if (!$recurringEvent) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $recurringEvent;
    }

    /**
     * Parse the request for the form data
     *
     * @param Request $request
     * @return array
     */
    protected function getPostData(Request $request)
    {
        $data = $request->request->get('recurringEvent');

        if (empty($data)) {
            $data = $request->request->all();
        }

        return $data;
    }

    /**
     * @return RecurringEventHandler
     */
    protected function getRecurringEventHandler()
    {
        return $this->container->get('ilioscore.recurringevent.handler');
    }
}
