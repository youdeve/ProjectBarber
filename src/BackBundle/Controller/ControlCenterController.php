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

use Symfony\Component\HttpFoundation\JsonResponse;
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
    $nbUsersY = $this->get('app.analytics')->getActiveSince('year');
    $nbUsersM = $this->get('app.analytics')->getActiveSince('month');
    $nbUsersW = $this->get('app.analytics')->getActiveSince('week');
    $nbUsersN = $this->get('app.analytics')->getActiveSince('now');

    // $nbUsersNow = $this->get('app.analytics')->getActiveSince("now");
    $this->get('logger')->info('0000000000000000000000000000000000000000000000000000000000', [$nbUsersY]);
    return $this->render('@Back/ControlCenter/control-center.html.twig',[
      "nbUsersY" => $nbUsersY,
      "nbUsersM" => $nbUsersM,
      "nbUsersW" => $nbUsersW,
      "nbUsersN" => $nbUsersN
    ]);

    // } catch (\Exception $e) {
    //   $this->get('logger')->error('Erreur =>', [$e]);
    //   return new JsonResponse("Exception reçue " . $e, 422);
    // }

  }
}
