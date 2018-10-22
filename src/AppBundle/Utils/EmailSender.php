<?php

/**
* EmailSender.php
* @copyright 2018-2019 Barber 2.0
* @author  SEKHARI Youssouf <you.sekhari@gmail.com
*/

namespace AppBundle\Utils;

use AppBundle\Doctrine\DBAL\Types\JsonType;
use Doctrine\Bundle\DoctrineBundle\Registry;
use AppBundle\Entity\User;

/**
* App Analytics service
*/
class EmailSender
{

  protected $doctrine;
  protected $mailer;


  /**
   * [__construct description]
   * @param Registry     $doctrine [description]
   * @param Swift_Mailer $mailer   [description]
   */
  public function __construct(Registry $doctrine, \Swift_Mailer $mailer)
  {
    $this->doctrine = $doctrine;
    $this->mailer = $mailer;
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

  public function sendConfirmation(User $newUser)
  {
    $message = (new \Swift_Message('Hello Email'))
        ->setFrom('norepond@barber.com')
        ->setTo($newUser->getEmail())
        ->setBody($this->renderView(
                // templates/emails/registration.html.twig
                'emails/registration.html.twig', [
                  'newUser' => $newUser
              ]), 'text/html'
        );
      $this->mailer->send($message);
  }

}
