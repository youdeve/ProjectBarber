<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;

use AppBundle\Entity\Appointement;



class ApiFullCalendarController extends FOSRestController
{

  /**
   * @Rest\Post("/appoitment/new")
   * @Security("has_role('ROLE_USER')")
   * @param Request $request
   * @return Response
   */
  public function postAppointementAction(Request $request)
  {
    try {
        $barberAffected = $this->getUser()->getAffectedAgentBarber();
        $title = $request->get('title');
        $start = $request->get('start');
        $end = $request->get('end');
        
        if(!$title && !$start && !$end)
          return new View('Le champ prestation ou une date n\'est pas defini', Response::HTTP_NO_CONTENT);

        if(!$barberAffected)
           return new JsonResponse('l\'utilisateur barber affecté n\'existe pas',Response::HTTP_UNPROCESSABLE_ENTITY);
        $appointement = $this->getDoctrine()->getRepository(Appointement::class);

        $appointement->setTitle($title)->setStartAppointement($start)
        ->setEndAppointement($end)->setUser($barberAffected);
        $this->get('logger')->info('0000000000000000000000000000000000000000000000000000000000',
        [$appointement]);

        $em = $this->getDoctrine()->getManager();
        $em->persist($appointement);
        $em->flush();

        $this->get('logger')->info('00000000000000000000000000000000000000000000000000000000002',
        [$appointement]);

       $view = View::create($appointement);
       $view->setFormat('json');
       return $view;
       // return new View('Mise à jour des événements effectuée', Response::HTTP_OK);

    } catch (\Exception $e) {
      return new View([$e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }

}
