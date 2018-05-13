<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContractController extends Controller
{
    /**
     * @Route("/contract", name="contract")
     */
    public function index()
    {
        return $this->render('contract/index.html.twig', [
            'controller_name' => 'ContractController',
        ]);
    }
}
