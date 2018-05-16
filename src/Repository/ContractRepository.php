<?php

namespace App\Repository;

use App\Entity\Contract;
use App\Enum\ContractStatusEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Contract|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contract|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contract[]    findAll()
 * @method Contract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contract::class);
    }

    /**
     * @param $dateStart
     * @param $dateEnd
     * @return array
     * Récupère les contrats dont la date de début est comprise entre les dates en paramètre
     */
    public function findBetweenDates($dateStart, $dateEnd): array
    {
        $qb = $this->createQueryBuilder('c')
            ->andWhere('c.dateStart >= :dateStart')
            ->setParameter('dateStart', $dateStart)
            ->andWhere('c.dateStart <= :dateEnd')
            ->setParameter('dateEnd', $dateEnd)
            ->orderBy('c.dateStart', 'ASC')
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param $dateEnd
     * @return array
     * Récupère les contrats non terminés dont la date de fin a été dépassée
     */
    public function findAfterDateEnd($dateEnd): array
    {
        $qb = $this->createQueryBuilder('c')
            ->andWhere('c.dateEnd < :dateEnd')
            ->setParameter('dateEnd', $dateEnd)
            ->andWhere('c.status != :status')
            ->setParameter('status', ContractStatusEnum::STATUS_FINISHED)
            ->getQuery();

        return $qb->execute();
    }

//    /**
//     * @return Contract[] Returns an array of Contract objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contract
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
