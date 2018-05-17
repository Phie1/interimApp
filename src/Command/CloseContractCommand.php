<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 16/05/2018
 * Time: 10:32
 */


namespace App\Command;

use App\Enum\ContractStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Contract;
use App\Repository\ContractRepository;

class CloseContractCommand extends Command
{
    private $em;

    public function __construct(?string $name = null, EntityManagerInterface $em) {
        parent::__construct($name);

        $this->em = $em;
    }

    protected function configure()
    {
        $this->setName('app:close-contract')
            ->setDescription('Clôture les contrats dont la date de fin a été atteinte.');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $expiredContracts = $this->em->getRepository(Contract::class)->findAfterDateEnd(date("Y-m-d H:i:s"));
        foreach ($expiredContracts as $contract) {
            $contract->setStatus(ContractStatusEnum::STATUS_FINISHED);

            $this->em->persist($contract);
            $this->em->flush();

            $output->writeln('Contrat n°' . $contract->getId() .' clôturé');
        }
    }
}