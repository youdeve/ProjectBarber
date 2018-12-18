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
  * @Rest\Post("/credit/new")
  * @Security("has_role('ROLE_CLIENT')")
  * @param Request $request
  * @return Response
  */
  public function postCreditAction(Request $request)
  {
    try {
      $nameOffre = $resuqest->get('');
      $price = $resuqest->get('');
      $ = $resuqest->get('');
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
      // $this->get('logger')->info('0000000000000000000000000000000000000000000
      // 000000000000000000000000000000000000000000 TEST',[$barber]);
      $appointments = $em->getRepository(Appointement::class)->findAll();
      $view = View::create($appointments);
      $view->setFormat('json');
      return $view;

    } catch (\Exception $e) {
      return new JsonResponse([$e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }

}
