<?php

namespace App\Controller;

use App\Entity\Interim;
use App\Form\InterimType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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

    /**     *
     * @Route("/interim/search", name="interim_search")
     * @Method("POST")
     */
    public function search(Request $request)
    {
        $string = $request->get('input');

        $interims = $this->getDoctrine()
            ->getRepository(Interim::class)
            ->findByLetters($string);

        $interimList = '<ul id="matchList">';
        foreach ($interims as $interim) {
            $matchStringBold = preg_replace('/('.$string.')/i', '<strong>$1</strong>', $interim->getName()." ".$interim->getSurname()); // Replace text field input by bold one
            $interimList .= '<li id="'.$interim->getName()." ".$interim->getSurname().'">'.$matchStringBold.'</li>'; // Create the matching list - we put maching name in the ID too
        }
        $interimList .= '</ul>';

        $response = new JsonResponse();
        $response->setData(array('interimList' => $interimList));

        return $response;
    }
}
