<?php

namespace App\Controller;

use App\Entity\Interim;
use App\Form\InterimType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InterimController extends Controller
{
    /**
     * @Route("/interim", name="interim")
     */
    public function index()
    {
        $interims = $this->getDoctrine()->getRepository(Interim::class)->findAll();

        return $this->render('interim/index.html.twig', [
            'interims' => $interims,
            'controller_name' => 'InterimController'
        ]);
    }

    /**
     * @Route("/interim/new", name="interim/new")
     */
    public function new(Request $request)
    {
        $interim = new Interim();

        $form = $this->createForm(InterimType::class, $interim);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $interim = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($interim);
            $em->flush();
            return $this->redirectToRoute('interim');
        }

        return $this->render('interim/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
