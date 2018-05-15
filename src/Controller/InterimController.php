<?php

namespace App\Controller;

use App\Entity\Interim;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InterimController extends Controller
{
    /**
     * @Route("/interim", name="interim")
     */
    public function index()
    {
        /* = $this->getDoctrine()->getManager();
        $interim = new Interim();
        $interim->setName("John");
        $interim->setSurname("Doe");
        $interim->setMail("john.doe@mail.com");
        $interim->setZipCode("38000");

        $entityManager->persist($interim);
        $entityManager->flush();*/

        $interims = $this->getDoctrine()->getRepository(Interim::class)->findAll();

        return $this->render('interim/index.html.twig', [
            'interims' => $interims,
            'controller_name' => 'InterimController'
        ]);
    }
}
