<?php

namespace FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/user", name="front_homepage")
     * @Security("has_role('ROLE_FRONT_ACCESS')")
     */
    public function indexAction(Request $request)
    {

      if($this->getUser()->hasGroup('ROLE_CLIENT'))
          return $this->render('FrontBundle:Default:index-client.html.twig');
      else
        return $this->redirect($this->generateUrl('homepage'));
    }


    /**
     * @Route("/user/test", name="testRolesUser")
     */
    public function testRolesUsersAction(Request $request) {

      $this->denyAccessUnlessGranted('ROLE_USER');
      return $this->render('Exemple_Roles/admin-login.html.twig');
    }

    /**
     * @Route("/admin/test", name="testRolesAdmin")
     */
    public function testRolesAdminAction(Request $request) {

      $user = $this->getUser()->setEmail('Youssouf@orange.fr');

      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();

      $this->denyAccessUnlessGranted('ROLE_ADMIN');
      return $this->render('Exemple_Roles/admin-login.html.twig');
    }
}
