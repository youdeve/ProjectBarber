<?php

/**
 * DefaultController.php
 * @copyright 2017-2018 Barber
 * @author  Youssouf SEKHARI <You.sekhari@gmail.com>
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        if($this->getUser()->hasGroup('GROUP_ADMIN'))
          return $this->render('BackBundle:Default:index-admin.html.twig');
        else if($this->getUser()->hasGroup('GROUP_CLIENT'))
          return $this->render('FrontBundle:Default:index-client.html.twig');
        else
          return $this->redirect($this->generateUrl('fos_user_security_login'));

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
