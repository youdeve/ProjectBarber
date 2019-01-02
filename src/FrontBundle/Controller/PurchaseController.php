<?php

namespace FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\StripeType;
use AppBundle\Entity\Stripe;
use AppBundle\Entity\Credit;

class PurchaseController extends Controller
{

  /**
    * @Route("/user/purchase", name="front_credit_purchase")
    * @Security("has_role('ROLE_FRONT_ACCESS') ")
   **/
  public function PurchaseAction(Request $request)
  {
    $stripe = new Stripe();
    $formStripe = $this->createForm(StripeType::class, $stripe);;
    $currentUserEmail = $this->getUser()->getEmail();

    if( $request->isMethod('POST') && $formStripe->handleRequest($request)->isValid()) {

      //create Customer
      \Stripe\Stripe::setApiKey("pk_test_iGX1WWt4cmBmvG86JCZTknAy");
      // \Stripe\Customer::create([
      //   "description" => 'Customer for barberTEST.com',
      //   "source" => $formStripe->getData()
      // ]);
      //payment
      $payment = \Stripe\Charge::create([
        "amount" => 2000,
        "currency" => "eur",
        "source" => $formStripe->getData(), // obtained with Stripe.js
        "description" => "Payment"
      ]);
      $em = $this->getDoctrine()->getManager();
      $em->persist($stripe);
      $em->flush();
      $request->getSession()->getFlashBag()->add('success', 'L\'utilisateur a bien été ajouté');
      // return  $this->redirectToRoute('');
    }
    $userAdminOrganization = $this->getUser()->getAffectedAgentBarber()->getAffectedBarberByAdmin();
    $credits = $this->getDoctrine()->getRepository(Credit::class)->findByAffetedAdmin($userAdminOrganization);
    return $this->render('@Front/CreditPurchase/credit-purchase.html.twig', [
      'credits' => $credits,
      'form' => $formStripe->createView(),
      'stripe_public_key' => $this->getParameter('stripe_public_key')
    ]);
  }
}
