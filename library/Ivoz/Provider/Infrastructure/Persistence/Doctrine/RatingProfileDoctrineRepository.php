<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\RatingProfile\RatingProfile;
use Ivoz\Provider\Domain\Model\RatingProfile\RatingProfileRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * RatingProfileDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RatingProfileDoctrineRepository extends ServiceEntityRepository implements RatingProfileRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RatingProfile::class);
    }
}
