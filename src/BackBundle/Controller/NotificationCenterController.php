<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class NotificationCenterController extends Controller
{
    /**
     * @Route("/admin/notifications", name="back_notification")
     * @Security("has_role('ROLE_BACK_ACCESS')")
     */
    public function indexAction(Request $request)
    {
        return $this->render('@Back/Notification/notification-center.html.twig');
    }

}
