<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\View\ViewHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;



class ApiServiceListController extends FOSRestController
{

  /**
   * @Rest\Get("/prestations/{id}")
   * @ParamConverter("serviceList", options={"id" = "id"})
   * @param Request $request
   * @return Response
   */
  public function getPrestationAction(Request $request, $id)
  {
    try {
      $user = $this->getUser();
      $prestation = $this->getDoctrine()->getRepository("AppBundle:ServiceList")->findById($id);

      $view = View::create($prestation);
      $view->setFormat('json');
       if($view == null)
       return new JsonResponse(['message' => 'La prestation n\'existes pas'], Response::HTTP_UNPROCESSABLE_ENTITY);

       return $view;

    } catch (\Exception $e) {
      return new View([$e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }

}
