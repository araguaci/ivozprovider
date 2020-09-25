<?php

namespace Ivoz\Kam\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Kam\Domain\Model\Dispatcher\Dispatcher;
use Ivoz\Kam\Domain\Model\Dispatcher\DispatcherInterface;
use Ivoz\Kam\Domain\Model\Dispatcher\DispatcherRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * DispatcherDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DispatcherDoctrineRepository extends ServiceEntityRepository implements DispatcherRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dispatcher::class);
    }

    /**
     * @param int $id
     * @return null|DispatcherInterface
     */
    public function findOneByApplicationServerId($id)
    {
        /** @var DispatcherInterface $response */
        $response = $this->findOneBy([
            'applicationServer' => $id
        ]);

        return $response;
    }
}
