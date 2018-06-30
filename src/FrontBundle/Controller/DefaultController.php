<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {

      if($this->getUser() == null)
        return $this->redirect($this->generateUrl('fos_user_security_login'));
      else{
        return $this->render('FrontBundle/Default/index.html.twig');
      }
    }


    /**
     * @Route("/user", name="testRolesUser")
     */
    public function testRolesUsersAction(Request $request) {

      $this->denyAccessUnlessGranted('ROLE_USER');
      return $this->render('');
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
