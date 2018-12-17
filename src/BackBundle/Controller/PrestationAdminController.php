<?php

namespace BackBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PrestationAdminController extends Controller
{

  /**
    * @Route("/admin/prestation", name="back_edit_Prestation")
    * @Security("has_role('ROLE_ADMIN') ")
   **/
  public function PrestationAdminAction(Request $request)
  {
    return $this->render('@Back/PrestationAdmin/prestation-admin.html.twig');
  }
}
