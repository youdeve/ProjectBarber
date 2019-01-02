<?php
/**
 *
 * @author Youssouf sekhari [ you.sekhari@gmail.com ]
 * 30/09/2018
 */


namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use FOS\UserBundle\Form\Type\RegistrationFormType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ManageClientController extends Controller
{
    /**
     * @Route("/admin/manage/clients", name="back_manage_client")
     * @Security("has_role('ROLE_MANAGE_CLIENT')")
     */
    public function ManageClientAction(Request $request)
    {
        $user = $this->getUser();
        // $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findByAffectedAgentBarber($user);
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();

        $user = new User();
        $formCustomer = $this->createForm(RegistrationFormType::class, $user);

        if( $request->isMethod('POST') && $formCustomer->handleRequest($request)->isValid()) {

          $user->setEnabled(true);
          $user->setRoles(["ROLE_TEAM"]);


          $em = $this->getDoctrine()->getManager();
          $em->persist($user);
          $em->flush();
          $request->getSession()->getFlashBag()->add('success', 'L\'utilisateur a bien été ajouté');
          return  $this->redirectToRoute('back_team');
        }

        // $this->get('logger')->info('0000000000000000000000000000000000000000000000000000000000', [$users]);
        return $this->render('@Back/ManageClient/manage-client.html.twig' , [
          'users' => $users,
          'form' => $formCustomer->createView(),
        ]);

    }

}
