<?php

/**
 * DefaultController.php
 * @copyright 2017-2018 Barber
 * @author  Youssouf SEKHARI <You.sekhari@gmail.com>
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return RedirectResponse|Response
     */
    public function indexAction(Request $request)
    {
      $isUrmet = $request->query->get('urmet');
      $isUrmet = isset($isUrmet) ? true : false;
        // replace this example code with whatever you need
        if($this->getUser() == null)
          return $this->redirect($this->generateUrl('fos_user_security_login'));
        else{
          return $this->render('FrontBundle/Default/index-client.html.twig');
        }
    }

    /**
     * @Route("/user/test", name="testRolesUser")
     */
    public function testRolesUsersAction(Request $request) {

      $this->denyAccessUnlessGranted('ROLE_USER');
      return $this->render('Exemple_Roles/hello-world-admin.html.twig');
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
