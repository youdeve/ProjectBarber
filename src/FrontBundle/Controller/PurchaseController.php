<?php

namespace FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Credit;

class PurchaseController extends Controller
{

  /**
    * @Route("/user/purchase", name="front_credit_purchase")
    * @Security("has_role('ROLE_FRONT_ACCESS') ")
   **/
  public function PurchaseAction(Request $request)
  {
    $userAdminOrganization = $this->getUser()->getAffectedAgentBarber()->getAffectedBarberByAdmin();
    $credits = $this->getDoctrine()->getRepository(Credit::class)->findByAffetedAdmin($userAdminOrganization);
    return $this->render('@Front/CreditPurchase/credit-purchase.html.twig', [
      'credits' => $credits
    ]);
  }
}
