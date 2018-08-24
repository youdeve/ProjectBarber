<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ManageClientController extends Controller
{
    /**
     * @Route("/admin/manage/clients", name="back_manage_client")
     * @Security("has_role('ROLE_BACK_ACCESS')")
     */
    public function ManageClientAction(Request $request)
    {
        $user = $this->getUser();
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findByAffectedAgentBarber($user);
        // $this->get('logger')->info('0000000000000000000000000000000000000000000000000000000000', [$users]);
        return $this->render('@Back/ManageClient/manage-client.html.twig' , [
          'users' => $users,
        ]);

    }

}
