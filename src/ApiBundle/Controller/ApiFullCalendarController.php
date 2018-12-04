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
use AppBundle\Entity\ServiceCatalog;
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

      $start = $request->get('start');
      $end = $request->get('end');
      $selectedPrestation = $request->get('prestation');
      $selectedPrestationId = $request->get('idPrestation');

      //TODO verification sil existe dans la base de donnée

      $this->get('logger')->info('00000000000000000000000000000000000000000000
      00000000000000000000000000000000000000000 ',[$request->get('selectedBarber')]);
      $dateStart = new \DateTime($start);
      $dateEnd = new \DateTime($end);

      if(!$selectedPrestation && !$dateStart && !$dateEnd)
        return new JsonResponse('Le champ prestation ou une date n\'est pas defini', Response::HTTP_NO_CONTENT);

      // // insertion du serviceList
      $service = new ServiceList;
      $service->setHaircut($selectedPrestation)
      ->setDateHaircut($dateStart)
      ->setPrice($selectedPrestationId)
      ->setAffectedCustomer($customer);

      $appointment = new Appointement;
      $appointment->setTitle($selectedPrestation)
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
        //get aleatoirement un coiffeur
        $barber = $teamUsers[array_rand($teamUsers)];
        $barberAffected = $customer->setAffectedAgentBarber($barber);

      } else {

        $barber = $this->getDoctrine()->getRepository(User::class)->find($request->get('selectedBarber'));
        $barberAffected = $customer->setAffectedAgentBarber($barber);
      }


      $em = $this->getDoctrine()->getManager();
      $em->persist($barberAffected);
      $em->persist($appointment);
      $em->persist($service);
      $em->flush();

      //get du coiffeur referent pour indiquer dans le toast
      $barber = $customer->getAffectedAgentBarber();

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
      // $barberAffected = $this->getUser()->getAffectedAgentBarber();
      $em = $this->getDoctrine()->getManager();

      $users = $this->getDoctrine()->getRepository(User::class)->findAll();
      $teamUsers = [];
      foreach ($users as $user) {
        if($user->hasRole("ROLE_TEAM")){
          $teamUsers[] = $user;
        }
      }
      $barber = $teamUsers[array_rand($teamUsers)];
      $this->get('logger')->info('0000000000000000000000000000000000000000000
      000000000000000000000000000000000000000000 TEST',[$barber]);
      $appointments = $em->getRepository(Appointement::class)->findAll();

      $this->get('logger')->info('0000000000000000000000000000000000000000000
      000000000000000000000000000000000000000000 ',[$appointments]);

      $view = View::create($appointments);
      $view->setFormat('json');
      return $view;

    } catch (\Exception $e) {
      return new JsonResponse([$e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }

}
