<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Entity\Appointement;
use AppBundle\Form\Type\UserType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ProfilClientController extends Controller
{
  /**
  * @Route("/admin/user/{id}", name="back_profil_user")
  * @Security("has_role('ROLE_BACK_ACCESS')")
  * @param $id PictureCategory identifier
  * @return Response
  */
  public function getUserProfilAction($id)
  {
    try {
      $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneById($id);
      $appointements = $this->getDoctrine()->getManager()->getRepository(Appointement::class)->findOneById($id);
      // $this->get('logger')->info('0000000000000000000000000000000000000000000000000000000000', [$users]);

      return $this->render('@Back/ProfilClient/profil-client.html.twig',[
        'user' => $users,
        'appointements' => $appointements
      ]);

    } catch (\Exception $e) {
      echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
  }

}
