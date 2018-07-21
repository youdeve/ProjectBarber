<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class SettingController extends Controller
{
    /**
     * @Route("/admin/setting", name="back_setting")
     * @Security("has_role('ROLE_BACK_ACCESS')")
     */
    public function indexAction(Request $request)
    {
        return $this->render('@Back/Setting/manage-setting.html.twig');
    }

}
