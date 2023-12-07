<?php

namespace App\Repository\Rate;

use App\Entity\Currency\Currency;
use App\Entity\Rate\Rate;
use App\Enum\TypeEnum;
use App\Help\PeriodInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rate>
 *
 * @method Rate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rate[]    findAll()
 * @method Rate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rate::class);
    }

    public function save(Rate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findMinMax(Currency $currency, PeriodInterface $period, TypeEnum $typeEnum): float
    {
        $qb = $this->createQueryBuilder('rate');

        $qb
            ->select(sprintf('%s(rate.mid)', $typeEnum->value))
            ->leftJoin('rate.currency', 'currency')
            ->andWhere($qb->expr()->eq('rate.currency', ':currencyId'))
            ->andWhere($qb->expr()->between('rate.date', ':dateStart', ':dateEnd'))
            ->setParameter('currencyId', $currency->getId())
            ->setParameter('dateStart', $period->getDateStart()->format('Y-m-d'))
            ->setParameter('dateEnd', $period->getDateEnd()->format('Y-m-d'));

        return $qb->getQuery()->getSingleScalarResult();
    }
}
