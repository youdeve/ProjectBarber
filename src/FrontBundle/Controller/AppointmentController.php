<?php

namespace FrontBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AppointmentController extends Controller
{

  /**
    * @Route("user/appointment", name="front_appointment")
    * @Security("has_role('ROLE_FRONT_ACCESS') ")
  **/
  public function AppointmentAction(Request $request)
  {
      return $this->render('@Front/Appointment/appointment.html.twig');
  }
}
