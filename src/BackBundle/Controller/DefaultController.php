<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

use Symfony\Component\HttpFoundation\Response;
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

      if($this->getUser()->hasRole('ROLE_ADMIN') || $this->getUser()->hasRole('ROLE_TEAM'))
          return $this->render('@Back/default/index.html.twig');
      else
       throw new AccessDeniedHttpException('Vous n\'avez pas les droits pour accédé à cette page ');


    }



}
