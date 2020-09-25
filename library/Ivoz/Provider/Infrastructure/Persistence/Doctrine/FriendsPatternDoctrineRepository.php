<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\FriendsPattern\FriendsPattern;
use Ivoz\Provider\Domain\Model\FriendsPattern\FriendsPatternRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * FriendsPatternDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FriendsPatternDoctrineRepository extends ServiceEntityRepository implements FriendsPatternRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FriendsPattern::class);
    }
}
