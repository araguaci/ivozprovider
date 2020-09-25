<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\RouteLock\RouteLock;
use Ivoz\Provider\Domain\Model\RouteLock\RouteLockRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * RouteLockDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RouteLockDoctrineRepository extends ServiceEntityRepository implements RouteLockRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RouteLock::class);
    }
}
