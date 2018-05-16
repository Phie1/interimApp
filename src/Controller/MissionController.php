<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Enum\MissionStatusEnum;
use App\Form\MissionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MissionController extends Controller
{
    /**
     * @Route("/mission", name="mission")
     */
    public function index()
    {
        $missions = $this->getDoctrine()->getRepository(Mission::class)->findAll();

        return $this->render('mission/index.html.twig', [
            'missions' => $missions,
            'controller_name' => 'MissionController'
        ]);
    }

    /**
     * @Route("/mission/new", name="mission/new")
     */
    public function new(Request $request)
    {
        $mission = new Mission();
        $form = $this->createForm(MissionType::class, $mission);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mission = $form->getData();
            $em = $this->getDoctrine()->getManager();

            // On récupère les anciennes missions actives de cet intérimaire
            $activeMissions = $em->getRepository(Mission::class)->findBy(
                ['interim' => $mission->getInterim(),
                 'status' => MissionStatusEnum::STATUS_ACTIVE
                ]
            );

            // Ses anciennes missions d'interim passent en statut "Supprimé"
            foreach ($activeMissions as $key=>$myMission) {
                $myMission->setStatus(MissionStatusEnum::STATUS_DELETED);
            }

            // La nouvelle mission créée devient la seule dont le suivi est "Actif"
            $mission->setStatus(MissionStatusEnum::STATUS_ACTIVE);
            $em->persist($mission);
            $em->flush();

            return $this->redirectToRoute('mission');
        }

        return $this->render('mission/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/mission/update/{mission}", name="mission/update")
     * @param Request $request
     * @param $mission
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, $mission)
    {
        $em = $this->getDoctrine()->getManager();
        $mission = $em->getRepository(Mission::class)->find($mission);
        $form = $this->createForm(MissionType::class, $mission);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mission = $form->getData();


            $em->persist($mission);
            $em->flush();
            return $this->redirectToRoute('mission');
        }

        return $this->render('mission/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/mission/delete/{mission}", name="mission/delete")
     * @param $mission
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function delete($mission)
    {
        $em = $this->getDoctrine()->getManager();
        $mission = $em->getRepository(Mission::class)->find($mission);
        $em->remove($mission);
        $em->flush();

        return $this->redirectToRoute('mission');
    }
}
