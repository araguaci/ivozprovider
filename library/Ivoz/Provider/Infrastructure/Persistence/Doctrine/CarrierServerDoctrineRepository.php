<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\CarrierServer\CarrierServer;
use Ivoz\Provider\Domain\Model\CarrierServer\CarrierServerRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * CarrierServerDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 *
 * @template-extends ServiceEntityRepository<CarrierServer>
 */
class CarrierServerDoctrineRepository extends ServiceEntityRepository implements CarrierServerRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarrierServer::class);
    }
}
