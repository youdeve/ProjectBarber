<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ManageTeamController extends Controller
{
    /**
     * @Route("/admin/teams", name="back_team")
     * @Security("has_role('ROLE_BACK_ACCESS')")
     */
    public function ManageTeamAction(Request $request)
    {
        return $this->render('@Back/ManageTeam/manage-team.html.twig');
    }

}
