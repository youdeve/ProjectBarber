<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\View\View;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;


/**
 * Class ApiAddManagerController
 * @package ApiBundle\Controller
 */
class ApiAddManagerController extends FosRestController
{

  /**
   * @Post("/teams/new")
   * @Security("has_role('ROLE_ADD_ADMIN')")
   * @param Request $request
   * @return Response
   */
  public function postCreatePersonalTeamAction(Request $request)
  {
    try {
      $email = $request->get('appbundle_user_Email');
      $enabled = $request->get('appbundle_user_Enabled') == true;
      $plainPasswordF = $request->get('appbundle_user_plainPassword_first');
      $plainPasswordR = $request->get('appbundle_user_plainPassword_second');

      if(!$email && !$plainPasswordF && !$plainPasswordR)
        return new View('Les champs ne doivent pas être vide', Response::HTTP_NO_CONTENT);

        $user = $this->getDoctrine()->getRepository('Appbundle:User')->findAll();

        if($plainPasswordF === $plainPasswordR) {
          $user->setEmail($email)->setEnabled($enabled)->setPassword($plainPasswordF);
        }else{
          return new View('Les mots de passe ne sont pas identiques');
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

      return new Response('Le contact à bien été créer !', Response::HTTP_OK);
    } catch (\Exception $e) {
      return new View([$e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }

}
