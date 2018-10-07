<?php
/**
*
* @author Youssouf sekhari [you.sekhari@gmail.com]
* 30/09/2018
*/


namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ControlCenterController extends Controller
{
  /**
  * [ControlCenterAction show statistique]
  * @param Request $request [description]
  * @Route("/admin/statistics", name="back_control_center")
  * @Security("has_role('ROLE_SUPER_ADMIN')")
  */
  public function statisticsAction(Request $request)
  {
    // try {
    // $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();

    $nbUsersNow = $this->get('app.analytics')->getActiveSince("now");
    // $this->get('logger')->info('0000000000000000000000000000000000000000000000000000000000', [$users]);
    return $this->render('@Back/ControlCenter/control-center.html.twig',[
      "nbUsersNow" => $nbUsersNow
    ]);

    // } catch (\Exception $e) {
    //   echo 'Exception reçue : ',  $e->getMessage(), "\n";
    // }

  }
}
