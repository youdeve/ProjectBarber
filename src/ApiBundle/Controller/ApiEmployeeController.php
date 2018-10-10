<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;

use AppBundle\Entity\User;


class ApiEmployeeController extends FOSRestController
{

  /**
   * @Rest\Get("/employees")
   * @Security("has_role('ROLE_ADD_ADMIN')")
   * @param Request $request
   * @return Response
   */
  public function getEmployeesAction(Request $request)
  {
    try {
        // $employees = $this->getDoctrine()->getRepository("AppBundle:User")->findBy(['roles'=> 'ROLE_TEAM']);
        $employees = $this->getDoctrine()->getRepository("AppBundle:User")->findAll();
        // $employees = $this->getDoctrine()->getRepository(User::class)->findOneByEmail("Team@kabolt.fr");
        $this->get('logger')->info('0000000000000000000000000000000000000000000000000000000000', [  $employees]);

        $view = View::create($employees);
         $view->setFormat('json');
         if($view == null)
         return new JsonResponse(['message' => 'Les utilisateurs n\'existes pas'], Response::HTTP_UNPROCESSABLE_ENTITY);

       return $view;

    } catch (\Exception $e) {
      return new JsonResponse([$e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }

}
