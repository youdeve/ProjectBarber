<?php

namespace FrontBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use AppBundle\Entity\User;
use FOS\UserBundle\Form\Type\ChangePasswordFormType;

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
    $user = new User();
    $formChangePassword = $this->createForm(ChangePasswordFormType::class, $user);

      return $this->render('@Front/Profile/profile.html.twig',[
          "form" => $formChangePassword->createView()
      ]);
  }

}
