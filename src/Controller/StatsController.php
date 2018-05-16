<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\Interim;
use App\Form\InterimType;
use App\Form\StatsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatsController extends Controller
{
    /**
     * @Route("/stats", name="stats")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(StatsType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $repository = $this->getDoctrine()->getRepository(Contract::class);
            $contracts = $repository->findByDate($data['dateStart'], $data['dateEnd']);

            $response = new StreamedResponse();
            $response->setCallback(function() use ($contracts) {
                setlocale (LC_TIME, 'fr_FR.utf8','fra');
                $handle = fopen('php://output', 'w+');

                fputcsv($handle, array('Intérimaire', 'Date de début', 'Date de fin','Statut'), ';');


                //die(dump($contracts));
                foreach ($contracts as $contract) {
                    $frenchDateStart = strftime("%d %B %Y", strtotime($contract->getDateStart()->format("d-M-Y")));
                    $frenchDateEnd = strftime("%d %B %Y", strtotime($contract->getDateEnd()->format("d-M-Y")));

                    fputcsv(
                        $handle,
                        array($contract->getInterim(), $frenchDateStart, $frenchDateEnd, $contract->getStatus()),
                        ';'
                    );
                }

                fclose($handle);
            });

            $filename = "export_contracts_".date("d_m_Y").".csv";

            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'text/csv; charset=utf-8', 'application/force-download');
            $response->headers->set('Content-Disposition','attachment; filename='.$filename);


            //die(dump($response));
            return $response;

            //return $this->redirectToRoute('stats');
        }

        return $this->render('stats.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
