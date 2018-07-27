<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ManageTeamController extends Controller
{
    /**
     * @Route("/admin/teams/", name="back_team")
     * @Security("has_role('ROLE_BACK_ACCESS')")
     */
    public function ManageTeamAction(Request $request)
    {
        $user = new User();
        $formTeam = $this->createForm(UserType::class, $user);

        if( $request->isMethod('POST') && $formTeam->handleRequest($request)->isValid()) {

          $user->setEnabled(true);
          $user->setRoles(["ROLE_TEAM"]);


          $em = $this->getDoctrine()->getManager();
          $em->persist($user);
          $em->flush();
          $request->getSession()->getFlashBag()->add('success', 'L\'utilisateur a bien été ajouté');
          return  $this->redirectToRoute('back_team');
        }

        return $this->render('@Back/ManageTeam/manage-team.html.twig' , [
          'users' => $user,
          'form' => $formTeam->createView(),
        ]);

    }



}
