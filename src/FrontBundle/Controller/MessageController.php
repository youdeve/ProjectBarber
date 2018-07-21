<?php

namespace FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends Controller
{

    /**
     * @Route("/user/messages", name="front_message")
     * @Security("has_role('ROLE_FRONT_ACCESS' ) ")
     */
    public function MessageAction(Request $request)
    {
      return $this->render('@Front/Messages/messages.html.twig');
    }

}
