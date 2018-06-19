<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
      $isUrmet = $request->query->get('urmet');
      $isUrmet = isset($isUrmet) ? true : false;
        // replace this example code with whatever you need
        if($this->getUser() == null)
          return $this->redirect($this->generateUrl('fos_user_security_login'));
        else{
            return $this->forward('FrontBundle:Default:index', ['isUrmet' => $isUrmet]);
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
