<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Validator\Constraints\DateTime;

use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\User;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;

use AppBundle\Entity\ServiceList;
use AppBundle\Entity\Appointement;



class ApiFullCalendarController extends FosRestController
{

  /**
   * @Rest\Post("/appoitment/new")
   * @Security("has_role('ROLE_CLIENT')")
   * @param Request $request
   * @return Response
   */
  public function postAppointementAction(Request $request)
  {
    try {
        $customer = $this->getUser();

        $title = $request->get('title');
        $start = $request->get('start');
        $end = $request->get('end');

        // $this->get('logger')->info('0000000000000000000000000000000000000000000000000000000000000000000000000000000000000 ',[$barberAffeted]);

        $dateStart = new \DateTime($start);
        // $this->get('logger')->info('0000000000000000000000000000000000000000000000000000000000000000000000000000000000000 ',[$barberAffected]);

        $dateEnd = new \DateTime($end);
        if(!$title && !$dateStart && !$dateEnd)
          return new JsonResponse('Le champ prestation ou une date n\'est pas defini', Response::HTTP_NO_CONTENT);
        // if(!$barberAffected)
        //    return new JsonResponse('l\'utilisateur barber affecté n\'existe pas',Response::HTTP_UNPROCESSABLE_ENTITY);

        //insertion du serviceList
        $service = new ServiceList;
        $service->setHaircut($title)
                ->setDateHaircut($dateStart)
                ->setPrice(5)
                ->setAffectedCustomer($customer);

        $this->get('logger')->info('00000000000000000000000000000000000000000000
        00000000000000000000000000000000000000000 toto',[$service]);


        $appointment = new Appointement;
        $appointment->setTitle($title)
        ->setStartAppointement($dateStart)
        ->setEndAppointement($dateEnd)
        ->setCustomer($customer);

        // SI premier rdv
        if(!$this->getUser()->getAffectedAgentBarber()) {
          // get coiffeur referent
          $users = $this->getDoctrine()->getRepository(User::class)->findAll();
          $teamUsers = [];
          foreach ($users as $user) {
              if($user->hasRole('ROLE_TEAM')) {
                  $teamUsers[] = $user;
              }
          }
          $this->get('logger')->info('0000000000000000000000000000000000000000000000000000000000000000000000000000000000000 ',[$teamUsers]);

          //get aleatoirement un coiffeur
          $barber = $teamUsers[array_rand($teamUsers)];
          $this->get('logger')->info('0000000000000000000000000000000000000000000000000000000000000000000000000000000000000 ',[$barber]);
          $barberAffected = $customer->setAffectedAgentBarber($barber);
          $barber = $appointment->setBarber($barber);
        } else {
          $barber = $this->getDoctrine()->getRepository(User::class)->find($request->get('selectedBarber'));
          $appointment->setBarber($barber);
        }

        //get du coiffeur referent pour indiquer dans le toast
        $barber = $appointment->getBarber();

        $em = $this->getDoctrine()->getManager();
        $em->persist($appointment);
        $em->persist($service);
        $em->flush();
       return new JsonResponse('Le rendez-vous avec ' .$barber. ' à bien été ajouté', Response::HTTP_OK);
       // return new View(['message'], Response::HTTP_OK);
    } catch (\Exception $e) {
      return new JsonResponse([$e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }

  /**
   * @Get("/appointments")
   * @Security("has_role('ROLE_CLIENT')")
   * @param Request $request
   * @return Response
   */
  public function getAppointementAction()
  {
    try {
        if(!$this->getUser()->hasRole("ROLE_CLIENT"))
          return new JsonResponse('Permission invalide', Response::HTTP_FORBIDDEN);
        // $user = $this->getUser();
        $barberAffected = $this->getUser()->getAffectedAgentBarber();
        $em = $this->getDoctrine()->getManager();
        $appointment = $em->getRepository(Appointement::class)->findByBarber($barberAffected);
        // $test[] = $appointment[1]->getTitle();
       // return new JsonResponse($appointment, Response::HTTP_OK);
       // return new View($appointment Response::HTTP_OK);

       $view = View::create($appointment);
       $view->setFormat('json');
       return $view;
       // return new View($view, Response::HTTP_OK);

    } catch (\Exception $e) {
      return new JsonResponse([$e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }

}
