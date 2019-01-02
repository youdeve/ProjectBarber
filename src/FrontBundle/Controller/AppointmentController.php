<?php

namespace FrontBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use AppBundle\Entity\User;
use AppBundle\Entity\ServiceCatalog;
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
    $users = $this->getDoctrine()->getRepository(User::class)->findAll();
    $teamUsers = [];
    foreach ($users as $user) {
        if($user->hasRole('ROLE_TEAM')) {
            $teamUsers[] = $user;
        }
    }
    $currentUser = $this->getUser();
    $soldeCredit = $currentUser->getSoldeCredit();
    $prestations = $this->getDoctrine()->getRepository(ServiceCatalog::class)->findAll();
    return $this->render('@Front/Appointment/appointment.html.twig', [
      'teamUsers' => $teamUsers,
      'currentUser' => $currentUser,
      'prestations' => $prestations,
      'soldeCredit' => $soldeCredit
    ]);
  }
}
