<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;



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
      return new View([$e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }

}
