<?php

/**
* EmailSender.php
* @copyright 2018-2019 Barber 2.0
* @author  SEKHARI Youssouf <you.sekhari@gmail.com
*/

namespace AppBundle\Utils;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Doctrine\Bundle\DoctrineBundle\Registry;

use AppBundle\Entity\User;

/**
* App email sender service
*/
class EmailSender
{

  protected $doctrine;
  protected $mailer;
  protected $defaultFromEmail;
  protected $logger;
  protected $templating;



  /**
   * [__construct description]
   * @param Registry     $doctrine         [description]
   * @param Swift_Mailer $mailer           [description]
   * @param [type]       $defaultFromEmail [description]
   * @param TwigEngine   $templating       [description]
   */
  public function __construct(Registry $doctrine, \Swift_Mailer $mailer, TwigEngine $templating, $logger, $defaultFromEmail)
  {
    $this->doctrine = $doctrine;
    $this->mailer = $mailer;
    $this->templating = $templating;
    $this->logger = $logger;
    $this->defaultFromEmail = $defaultFromEmail;
  }

  /**
  * Get doctrine
  * @return Registry
  * @ignore
  */
  private function getDoctrine()
  {
    return $this->doctrine;
  }


  public function sendConfirmationChangePassword(User $newUser)
  {
    $message = (new \Swift_Message('Hello Email'))
        ->setFrom($this->defaultFromEmail)
        ->setTo($newUser->getEmail())
        ->setBody($this->templating->render(
                // templates/emails/registration.html.twig
                'email/registration.email.twig', [
                  'newUser' => $newUser
              ]), 'text/html'
        );
    $this->logger->error('------------------------------------------000000', [$message]);
      $this->mailer->send($message);
  }

}
