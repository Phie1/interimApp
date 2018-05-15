<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\Interim;
use App\Enum\ContractStatusEnum;
use App\Form\ContractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContractController extends Controller
{
    /**
     * @Route("/contract", name="contract")
     */
    public function index()
    {
        /*$entityManager = $this->getDoctrine()->getManager();
        $contract = new Contract();
        $contract->setInterimId(4);
        $contract->setDateStart(new \DateTime('2018-05-15'));
        $contract->setDateEnd(new \DateTime('2018-05-20'));
        $contract->setStatus(ContractStatusEnum::STATUS_WAITING);
        $contract->setInterim($entityManager->find(Interim::class, 4));

        $entityManager->persist($contract);
        $entityManager->flush();*/

        $contracts = $this->getDoctrine()->getRepository(Contract::class)->findAll();

        return $this->render('contract/index.html.twig', [
            'contracts' => $contracts,
            'controller_name' => 'ContractController'
        ]);
    }

    /**
     * @Route("/contract/new", name="new")
     */
    public function new(Request $request)
    {
        $contract = new Contract();

        $form = $this->createForm(ContractType::class, $contract);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contract = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($contract);
            $em->flush();
            return $this->redirectToRoute('contract');
        }

        return $this->render('contract/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
