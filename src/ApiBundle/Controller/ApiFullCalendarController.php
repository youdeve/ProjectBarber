<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Validator\Constraints\DateTime;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;

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

        $barberAffected = $this->getUser()->getAffectedAgentBarber();
        $title = $request->get('title');
        $start = $request->get('start');
        $end = $request->get('end');
        $this->get('logger')->info('0000000000000000000000000000000000000000000000000000000000000000000000000000000000000 ',[$start]);

        $dateStart = new \DateTime($start);
        $this->get('logger')->info('0000000000000000000000000000000000000000000000000000000000000000000000000000000000000 ',[$barberAffected]);

        $dateEnd = new \DateTime($end);
        if(!$title && !$dateStart && !$dateEnd)
          return new JsonResponse('Le champ prestation ou une date n\'est pas defini', Response::HTTP_NO_CONTENT);
        if(!$barberAffected)
           return new JsonResponse('l\'utilisateur barber affecté n\'existe pas',Response::HTTP_UNPROCESSABLE_ENTITY);

        $appointment = new Appointement;
        $appointment->setTitle($title)->setStartAppointement($dateStart)
        ->setEndAppointement($dateEnd)->setBarber($barberAffected)->setCustomer($customer);

        $barber =$appointment->getBarber();
        $em = $this->getDoctrine()->getManager();
        $em->persist($appointment);
        $em->flush();
        // $this->get('logger')->info('00000000000000000000000000000000000000000000000000000000002',[$appointment]);
       return new JsonResponse('Le rendez-vous avec ' .$barber. ' à bien été ajouté', Response::HTTP_OK);
       // return new View(['message' => ''], Response::HTTP_OK);
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
