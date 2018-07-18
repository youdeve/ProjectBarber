<?php

namespace FrontBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PrestationController extends Controller
{

  /**
    * @Route("user/prestation", name="front_prestation")
    * @Security("has_role('ROLE_FRONT_ACCESS') ")
  **/
  public function PrestationAction(Request $request)
  {
      return $this->render('@Front/Prestation/prestation.html.twig');
  }
}
