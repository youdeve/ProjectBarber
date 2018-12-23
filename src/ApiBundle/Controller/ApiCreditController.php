<?php
namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Delete;

use AppBundle\Entity\Credit;
use AppBundle\Entity\User;



class ApiCreditController extends FosRestController
{

  /**
  * @Rest\Post("/credit/new")
  * @Security("has_role('ROLE_ADMIN')")
  * @param Request $request
  * @return Response
  */
  public function postCreditAction(Request $request)
  {
    try {
      if( !$this->getUser()->hasRole('ROLE_ADMIN'))
         return new JsonResponse('Permission invalide', Response::HTTP_FORBIDDEN);
      $title = $request->get('titleCredit');
      $price = $request->get('priceCredit');
      $credit = $request->get('credit');
      $currentAdmin = $this->getUser();
      // $this->get('logger')->info('000000000000000000000000000000000000', [$title, $price, $credit]);
      $this->get('app.manage_credit')->createCredit($credit, $price, $title, $currentAdmin, true);
      return new JsonResponse("L'offre à bien été ajouté", Response::HTTP_OK);
    } catch (\Exception $e) {
      return new JsonResponse([$e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }

  /**
  * @Get("/credits")
  * @Security("has_role('ROLE_ADMIN')")
  * @param Request $request
  * @return Response
  */
  public function getCreditAction()
  {
    try {
        if (!$this->getUser()->hasRole('ROLE_ADMIN')) return new JsonResponse('Permission invalide', Response::HTTP_FORBIDDEN);
        $admin = $this->getUser();
        $credit = $this->getDoctrine()->getRepository(Credit::class)->findByAffetedAdmin($admin);
        $view = View::create($credit);
        $view->setFormat('json');
        return $view;
    } catch (\Exception $e) {
      return new JsonResponse([$e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }

  /**
  * @Delete("/delete/{id}")
  * @Security("has_role('ROLE_ADMIN')")
  * @param Request $request
  * @return Response
  */
  public function deleteCreditAction($id)
  {
    try {
        $credit = $this->getDoctrine()->getRepository(Credit::class)->find($id);
        if (null === $credit) return new JsonResponse("L'offre n'existe pas ou plus", Response::HTTP_UNPROCESSABLE_ENTITY);
        $em = $this->getDoctrine()->getManager();
        $em->remove($credit);
        $em->flush();
        return new JsonResponse("L'offre à bien été supprimer", Response::HTTP_OK);
    } catch (\Exception $e) {
      return new JsonResponse([$e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }

}
