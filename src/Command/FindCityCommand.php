<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 16/05/2018
 * Time: 10:32
 */


namespace App\Command;

use App\Entity\Interim;
use App\Enum\ContractStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Contract;
use Unirest;

class FindCityCommand extends Command
{
    private $em;

    public function __construct(?string $name = null, EntityManagerInterface $em) {
        parent::__construct($name);

        $this->em = $em;
    }

    protected function configure()
    {
        $this->setName('app:find-city')
            ->setDescription("Renseigne le champ 'Ville' des intérimaires quand celui-ci est vide, à partir du code postal");
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $interims = $this->em->getRepository(Interim::class)->findBy(
            array('city' => null)
        );

        foreach ($interims as $interim) {
            $zipCode = $interim->getZipCode();
            Unirest\Request::verifyPeer(false);

            //https://ourcodeworld.com/articles/read/211/unirest-for-php-ssl-certificate-problem-unable-to-get-local-issuer-certificate
            $url = 'https://geo.api.gouv.fr/communes?codePostal='.$zipCode;
            $response = Unirest\Request::get($url);
            $city = $response->body;
            $city_name = null;
            if(!empty($city)) {
                $city_name = $city[0]->nom; // On prend la première ville récupérée
            }

            $interim->setCity($city_name);

            $this->em->persist($interim);
            $this->em->flush();

            $output->writeln($zipCode." associé à ".$city_name);
        }
    }
}