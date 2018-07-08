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
         * @Security("has_role('ROLE_FRONT_ACCESS' ) ")
         */
        public function indexAction(Request $request)
        {
          $user = $this->getUser();
            if($this->getUser()->hasRole('ROLE_CLIENT')){
              return $this->render('FrontBundle::index-client.html.twig');
            }else{
              return $this->redirect($this->generateUrl('fos_user_security_login'));
            }

        }



}
