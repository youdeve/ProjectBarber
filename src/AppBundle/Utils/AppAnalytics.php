<?php

/**
* AppAnalytics.php
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
class AppAnalytics
{

  protected $doctrine;
  /**
  * AppSettings constructor.
  * @param Registry $doctrine
  */
  public function __construct(Registry $doctrine)
  {
    $this->doctrine = $doctrine;
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

  public function getActiveSince($periodName = null)
  {
    $period = new \DateTime();
    switch ($periodName) {
      case 'now':
      $period->setTimestamp(strtotime('5 minutes ago'));
      break;
      case 'week':
      $period->setTimestamp(strtotime('1 week ago'));
      break;
      case 'month':
      $period->setTimestamp(strtotime('1 month ago'));
      break;
      case 'year':
      $period->setTimestamp(strtotime('1 year ago'));
      break;
      default:
      $period->setTimestamp(strtotime('5 minutes ago'));
      break;
    }
    $users = $this->getDoctrine()->getRepository(User::class)->getUserSince($period);
    // return $users;
    return count($users);

  }

}
