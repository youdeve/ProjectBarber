<?php

namespace FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PurchaseController extends Controller
{

  /**
    * @Route("/user/purchase", name="front_credit_purchase")
    * @Security("has_role('ROLE_FRONT_ACCESS') ")
   **/
  public function PurchaseAction(Request $request)
  {
    $this->getUser()->getAffected
    $Credit = $this->getDoctrines()->getRepository(Credit::class)->findByAffectedAdmin('')
    return $this->render('@Front/CreditPurchase/credit-purchase.html.twig', [

    ]);
  }
}
