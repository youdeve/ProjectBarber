<?php

namespace FrontBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ServiceList;

class PrestationController extends Controller
{

  /**
    * @Route("user/prestation", name="front_prestation")
    * @Security("has_role('ROLE_FRONT_ACCESS') ")
  **/
  public function PrestationAction(Request $request)
  {

    $user = $this->getUser();
    if($user === null)
      throw new \Exception("L'utilisateur n'existe pas");

      $serviceLists = $this->getDoctrine()->getManager()->getRepository(ServiceList::class)->findByAffectedCustomer($user);

      if(!$serviceLists)
        throw new \Exception("Service n'existe pas");

      return $this->render('@Front/Prestation/prestation.html.twig',[
              'serviceLists' => $serviceLists
      ]);
  }
}
