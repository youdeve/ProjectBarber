<?php

/**
* ManageCredit.php
* @copyright 2018-2019 Barber 2.0
* @author  SEKHARI Youssouf <you.sekhari@gmail.com
*/

namespace AppBundle\Utils;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\User;
use AppBundle\Entity\Credit;
use AppBundle\Doctrine\DBAL\Types\JsonType;

use Doctrine\Bundle\DoctrineBundle\Registry;

use Psr\Log\LoggerInterface;

/**
* App Analytics service
*/
class ManageCredit
{

  protected $doctrine;
  protected $logger;
  /**
  * AppSettings constructor.
  * @param Registry $doctrine
  */
  public function __construct(Registry $doctrine, LoggerInterface $logger)
  {
    $this->doctrine = $doctrine;
    $this->logger = $logger;
  }

  /**
  * Get doctrine
  * @return Registry
  * @ignore
  */
  private function getDoctrines()
  {
    return $this->doctrine;
  }

  public function createCredit($credit, $price, $title, $currentAdmin, $flush = false)
  {
    $this->logger->info('Service 00000000000000000000000000000000000000000000000000000000000000',[$credit, $price, $title, $currentAdmin]);
    // if (!$currentAdmin->hasRole('ROLE_ADMIN')) return new JsonResponse("Vous n'avez pas les droits, accés refusé", Response::HTTP_FORBIDDEN);
    // if(!$credit || !$price || !$title) return new JsonResponse("Les champs sont vide", Response::HTTP_OK);
    $newcredit = new Credit;
    $newcredit->setCredit($credit)->setPrice($price)
              ->setAffetedAdmin($currentAdmin)
              ->setTitle($title);
    $em = $this->getDoctrines()->getManager();
    $em->persist($newcredit);
    // $em->flush();
    if ($flush === true) $em->flush();
  }
}
