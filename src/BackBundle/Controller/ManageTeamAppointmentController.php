<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Appointement;
use AppBundle\Form\Type\UserType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ManageTeamAppointmentController extends Controller
{
    /**
     * @Route("/admin/manage/appointment", name="back_manage_appointment")
     * @Security("has_role('ROLE_MANAGE_CLIENT')")
     */
    public function ManageTeamAppointmentAction(Request $request)
    {
        $user = $this->getUser();
        $appointments = $this->getDoctrine()->getManager()->getRepository(Appointement::class)->findByBarber($user);
        // $this->get('logger')->info('0000000000000000000000000000000000000000000000000000000000', [$users]);
        return $this->render('@Back/ManageAppointment/manage-team-appointment.html.twig' , [
          'appointments' => $appointments,
        ]);

    }

}
