<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 16/05/2018
 * Time: 10:32
 */


namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Swift_Mailer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Contract;

class SendMailContractCommand extends Command
{
    private $em;

    public function __construct(?string $name = null, EntityManagerInterface $em) {
        parent::__construct($name);

        $this->em = $em;
    }

    protected function configure()
    {
        $this->setName('app:send-mail-contract')
            ->setDescription('Envoi un mail aux intérimaires dont le contrat débute dans 1 jour');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $today = date("Y-m-d H:i:s");
        $yesterday = (new \DateTime())->modify('-24 hours');
        // On récupère les contrats qui commencent dans moins de 24 heures
        $contracts = $this->em->getRepository(Contract::class)->findBetweenDates($yesterday, $today);

        foreach ($contracts as $contract) {
            $message = (new \Swift_Message("Votre contrat d'intérim débute dans 1 jour"))
                ->setFrom('interim@app.com')
                ->setTo($contract->getInterim()->getMail())
                ->setBody(
                    $this->renderView(
                        'mails/contract_start.html.twig',
                        array(
                            'name' => $contract->getName() + " " + $contract->getSurname(),
                            'dateStart' => $contract->getDateStart(),
                        )
                    ),
                    'text/html'
                )
            ;

            $this->em->getContainer()->get('mailer')->send($message);

            $output->writeln('Mail de début de contrat envoyé à ' . $contract->getInterim()->getMail());
        }
    }
}