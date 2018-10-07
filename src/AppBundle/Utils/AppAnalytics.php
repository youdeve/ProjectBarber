<?php

/**
* AppAnalytics.php
* @copyright 2018-2019 Barber 2.0
* @author  SEKHARI Youssouf <you.sekhari@gmail.com
*/

namespace AppBundle\Utils;


/**
* App Analytics service
*/
class AppAnalytics
{

  protected $doctrine;

  /**
  * AppAnalytics constructor.
  * @param Registry $doctrine
  */
  public function __construct(Registry $doctrine)
  {
    $this->doctrine = $doctrine;
  }

  public function getActiveSince($periodName = null){

    $period = new \DateTime();

    switch ($periodName) {
      case 'now':
        $period->setTimestamp(strtotime("5 minutes ago"));
      break;
      case 'month':
        $period->setTimestamp(strtotime("1 month ago"));
      break;
      case 'year':
        $period->setTimestamp(strtotime("1 year ago"));
      break;
      case 'week':
        $period->setTimestamp(strtotime("1 week ago"));
      break;
      default:
        $period->setTimestamp(strtotime("5 minutes ago"));
      break;
    }
    $users = $this->getDoctrine()->getRepository(User::class)->getUsersSince($period);
    return count($users);
  }

}
