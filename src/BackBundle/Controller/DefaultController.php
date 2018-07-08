<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class DefaultController extends Controller
{
    /**
     * @Route("/admin", name="back_homepage")
     * @Security("has_role('ROLE_BACK_ACCESS')")
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
      if($user->hasRole('ROLE_ADMIN')){
        return $this->render('BackBundle:default:index.html.twig', [
          'user'=> $user,
        ]);
      }else{
        return $this->redirect($this->generateUrl('fos_user_security_login'));
      }
    }

}
