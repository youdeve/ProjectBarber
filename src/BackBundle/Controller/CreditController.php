<?php

namespace BackBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CreditController extends Controller
{

  /**
    * @Route("/admin/credit", name="back_credit")
    * @Security("has_role('ROLE_ADMIN') ")
   **/
  public function creditAction(Request $request)
  {
    return $this->render('@Back/Credit/credit.html.twig');
  }
}
