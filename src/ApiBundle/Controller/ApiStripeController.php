<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Credit;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\View\ViewHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;



class ApiStripeController extends FOSRestController
{

  /**
   * @Rest\Post("/stripe/customer/new")
   * @param Request $request
   * @return Response
   */
  public function CreateCustomerAction(Request $request)
  {
    try {
        // if(\Stripe\Stripe::setApiKey() != $this->getParameter('stripe_public_key')) return new JsonResponse("Accés non autorisé", Response::HTTP_UNAUTHORIZED);
        $idOffer = $request->get('idOffer');
        $idToken = $request->get('tokenId');
        $currentUserEmail = $this->getUser()->getEmail();

        $credit = $this->getDoctrine()->getRepository(Credit::Class)->find($idOffer);
        $priceCreditSelected = $credit->getPrice();
        //create Customer
        // \Stripe\Customer::create([
        //   "description" => 'Customer for barberTEST.com',
        //   "source" => $idToken,
        //   "email" => $currentUserEmail,
        // ]);
        // //payment
        // $payment = \Stripe\Charge::create([
        //   "amount" => $priceCreditSelected.'00',
        //   "currency" => "eur",
        //   "source" => $idToken, // obtained with Stripe.js
        //   "description" => "Payment"
        // ]);

        $user = $this->getDoctrine()->getRepository(User::class)->find($this->getUser());
        $user->setTokenCardStripeId($idToken);
        // $this->get('logger')->info('00000000000000000000000000000000000 =>' [$payment]);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        // return new JsonResponse("test", Response::HTTP_OK);
        // $view = View::create($payment);
        // $view->setFormat('json');
        // return $view;
         // return $this->redirectToRoute('front_credit_purchase');
        return new Response("Ajout de la carte", Response::HTTP_OK);
    } catch (\Exception $e) {
      return new View([$e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }

}
