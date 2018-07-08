<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
      if($this->getUser()->hasGroup('GROUP_ADMIN'))
        return $this->render('BackBundle:Default:index-admin.html.twig');
      else
        return $this->redirecToRoute('front_homepage');
    }
}
