<?php

/**
 * DefaultController.php
 * @copyright 2018-2019 Barber
 * @author  Youssouf SEKHARI <You.sekhari@gmail.com>
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /**
    * @Route("/", name="homepage")
    */
    public function indexAction()
    {
      $user = $this->getUser();
        if(!$user){
          return $this->redirect($this->generateUrl('fos_user_security_login'));
        }elseif($user->hasRole('ROLE_CLIENT')){
          return $this->redirect($this->generateUrl('front_homepage'));
        }elseif($user->hasRole('ROLE_ADMIN')){
          return $this->redirect($this->generateUrl('back_homepage'));
        }elseif($user->hasRole('ROLE_TEAM')){
          return $this->redirect($this->generateUrl('back_homepage'));
        } else {
          throw new AccessDeniedHttpException();
        }
    }

}
