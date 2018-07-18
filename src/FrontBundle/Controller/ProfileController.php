<?php

namespace FrontBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller
{

  /**
    * @Route("user/profile", name="front_profile")
    * @Security("has_role('ROLE_FRONT_ACCESS') ")
  **/
  public function profileAction(Request $request)
  {
      return $this->render('@Front/Profile/profile.html.twig');
  }

}
