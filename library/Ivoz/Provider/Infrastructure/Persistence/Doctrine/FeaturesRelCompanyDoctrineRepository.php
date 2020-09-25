<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\FeaturesRelCompany\FeaturesRelCompany;
use Ivoz\Provider\Domain\Model\FeaturesRelCompany\FeaturesRelCompanyRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * FeaturesRelCompanyDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FeaturesRelCompanyDoctrineRepository extends ServiceEntityRepository implements FeaturesRelCompanyRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FeaturesRelCompany::class);
    }
}
