<?php

namespace Ivoz\Cgr\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Cgr\Domain\Model\TpRate\TpRateRepository;
use Ivoz\Cgr\Domain\Model\TpRate\TpRate;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * TpRateDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TpRateDoctrineRepository extends ServiceEntityRepository implements TpRateRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TpRate::class);
    }
}
