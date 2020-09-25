<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\Codec\Codec;
use Ivoz\Provider\Domain\Model\Codec\CodecRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * CodecDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CodecDoctrineRepository extends ServiceEntityRepository implements CodecRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Codec::class);
    }
}
