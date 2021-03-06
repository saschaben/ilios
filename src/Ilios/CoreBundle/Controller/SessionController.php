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
use Ilios\CoreBundle\Handler\SessionHandler;
use Ilios\CoreBundle\Entity\SessionInterface;

/**
 * Class SessionController
 * @package Ilios\CoreBundle\Controller
 * @RouteResource("Sessions")
 */
class SessionController extends FOSRestController
{
    /**
     * Get a Session
     *
     * @ApiDoc(
     *   section = "Session",
     *   description = "Get a Session.",
     *   resource = true,
     *   requirements={
     *     {
     *        "name"="id",
     *        "dataType"="integer",
     *        "requirement"="\d+",
     *        "description"="Session identifier."
     *     }
     *   },
     *   output="Ilios\CoreBundle\Entity\Session",
     *   statusCodes={
     *     200 = "Session.",
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
        $answer['sessions'][] = $this->getOr404($id);

        return $answer;
    }

    /**
     * Get all Session.
     *
     * @ApiDoc(
     *   section = "Session",
     *   description = "Get all Session.",
     *   resource = true,
     *   output="Ilios\CoreBundle\Entity\Session",
     *   statusCodes = {
     *     200 = "List of all Session",
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

        $result = $this->getSessionHandler()
            ->findSessionsBy(
                $criteria,
                $orderBy,
                $limit,
                $offset
            );

        //If there are no matches return an empty array
        $answer['sessions'] =
            $result ? $result : new ArrayCollection([]);

        return $answer;
    }

    /**
     * Create a Session.
     *
     * @ApiDoc(
     *   section = "Session",
     *   description = "Create a Session.",
     *   resource = true,
     *   input="Ilios\CoreBundle\Form\Type\SessionType",
     *   output="Ilios\CoreBundle\Entity\Session",
     *   statusCodes={
     *     201 = "Created Session.",
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
            $new  =  $this->getSessionHandler()
                ->post($this->getPostData($request));
            $answer['sessions'] = [$new];

            $view = $this->view($answer, Codes::HTTP_CREATED);

            return $this->handleView($view);
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Update a Session.
     *
     * @ApiDoc(
     *   section = "Session",
     *   description = "Update a Session entity.",
     *   resource = true,
     *   input="Ilios\CoreBundle\Form\Type\SessionType",
     *   output="Ilios\CoreBundle\Entity\Session",
     *   statusCodes={
     *     200 = "Updated Session.",
     *     201 = "Created Session.",
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
            $session = $this->getSessionHandler()
                ->findSessionBy(['id'=> $id]);
            if ($session) {
                $code = Codes::HTTP_OK;
            } else {
                $session = $this->getSessionHandler()
                    ->createSession();
                $code = Codes::HTTP_CREATED;
            }

            $answer['session'] =
                $this->getSessionHandler()->put(
                    $session,
                    $this->getPostData($request)
                );
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
        }

        $view = $this->view($answer, $code);

        return $this->handleView($view);
    }

    /**
     * Partial Update to a Session.
     *
     * @ApiDoc(
     *   section = "Session",
     *   description = "Partial Update to a Session.",
     *   resource = true,
     *   input="Ilios\CoreBundle\Form\Type\SessionType",
     *   output="Ilios\CoreBundle\Entity\Session",
     *   requirements={
     *     {
     *         "name"="id",
     *         "dataType"="integer",
     *         "requirement"="\d+",
     *         "description"="Session identifier."
     *     }
     *   },
     *   statusCodes={
     *     200 = "Updated Session.",
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
        $answer['session'] =
            $this->getSessionHandler()->patch(
                $this->getOr404($id),
                $this->getPostData($request)
            );

        return $answer;
    }

    /**
     * Delete a Session.
     *
     * @ApiDoc(
     *   section = "Session",
     *   description = "Delete a Session entity.",
     *   resource = true,
     *   requirements={
     *     {
     *         "name" = "id",
     *         "dataType" = "integer",
     *         "requirement" = "\d+",
     *         "description" = "Session identifier"
     *     }
     *   },
     *   statusCodes={
     *     204 = "No content. Successfully deleted Session.",
     *     400 = "Bad Request.",
     *     404 = "Not found."
     *   }
     * )
     *
     * @Rest\View(statusCode=204)
     *
     * @param $id
     * @internal SessionInterface $session
     *
     * @return Response
     */
    public function deleteAction($id)
    {
        $session = $this->getOr404($id);

        try {
            $this->getSessionHandler()
                ->deleteSession($session);

            return new Response('', Codes::HTTP_NO_CONTENT);
        } catch (\Exception $exception) {
            throw new \RuntimeException("Deletion not allowed");
        }
    }

    /**
     * Get a entity or throw a exception
     *
     * @param $id
     * @return SessionInterface $session
     */
    protected function getOr404($id)
    {
        $session = $this->getSessionHandler()
            ->findSessionBy(['id' => $id]);
        if (!$session) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $session;
    }

    /**
     * Parse the request for the form data
     *
     * @param Request $request
     * @return array
     */
    protected function getPostData(Request $request)
    {
        $data = $request->request->get('session');

        if (empty($data)) {
            $data = $request->request->all();
        }

        return $data;
    }

    /**
     * @return SessionHandler
     */
    protected function getSessionHandler()
    {
        return $this->container->get('ilioscore.session.handler');
    }
}
