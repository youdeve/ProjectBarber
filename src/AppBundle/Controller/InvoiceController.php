<?php

/**
 * DefaultController.php
 * @copyright 2018-2019 Barber
 * @author  Youssouf SEKHARI <You.sekhari@gmail.com>
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use AppBundle\Entity\Invoice;

class InvoiceController extends Controller
{
    /**
    * @Route("/invoice/new/{id}", name="invoicePage")
    */
    public function InvoiceAction($id)
    {
      $invoice = $this->getDoctrine()->getRepository(Invoice::class)->findByServiceListId($id);
      return $this->render("@Back/Invoice/invoice.html.twig", [
        'invoice' => $invoice
      ]);
    }

}
