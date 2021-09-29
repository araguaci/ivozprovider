<?php

namespace Ivoz\Cgr\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NativeQuery;
use Ivoz\Cgr\Domain\Model\TpDestination\TpDestination;
use Ivoz\Cgr\Domain\Model\TpDestination\TpDestinationInterface;
use Ivoz\Cgr\Domain\Model\TpDestination\TpDestinationRepository;
use Ivoz\Core\Infrastructure\Domain\Service\DoctrineQueryRunner;
use Doctrine\Persistence\ManagerRegistry;

/**
 * TpDestinationDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TpDestinationDoctrineRepository extends ServiceEntityRepository implements TpDestinationRepository
{
    protected $queryRunner;

    public function __construct(
        ManagerRegistry $registry,
        DoctrineQueryRunner $queryRunner
    ) {
        parent::__construct($registry, TpDestination::class);
        $this->queryRunner = $queryRunner;
    }

    /**
     * @return int affected rows
     */
    public function syncWithBusiness($brandId)
    {
        $tpDestinationInsert =
            'INSERT IGNORE INTO tp_destinations (tpid, tag, prefix, destinationId)'
            . " SELECT CONCAT('b', brandId), CONCAT('b', brandId, 'dst', id), prefix, id FROM Destinations WHERE brandId='$brandId'";

        $nativeQuery = new NativeQuery(
            $this->_em
        );
        $nativeQuery->setSQL($tpDestinationInsert);

        return $this->queryRunner->execute(
            TpDestination::class,
            $nativeQuery
        );
    }


    /**
     * @inheritdoc
     * @see TpDestinationRepository::findOneByTag
     */
    public function findOneByTag($destinationTag)
    {
        /** @var TpDestinationInterface $response */
        $response = $this->findOneBy([
            'tag' => $destinationTag
        ]);

        return $response;
    }
}
