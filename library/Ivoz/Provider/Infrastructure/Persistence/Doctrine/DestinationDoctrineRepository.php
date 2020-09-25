<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NativeQuery;
use Ivoz\Core\Infrastructure\Domain\Service\DoctrineQueryRunner;
use Ivoz\Provider\Domain\Model\Destination\Destination;
use Ivoz\Provider\Domain\Model\Destination\DestinationRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * DestinationDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DestinationDoctrineRepository extends ServiceEntityRepository implements DestinationRepository
{
    protected $queryRunner;

    public function __construct(
        ManagerRegistry $registry,
        DoctrineQueryRunner $queryRunner
    ) {
        parent::__construct($registry, Destination::class);
        $this->queryRunner = $queryRunner;
    }

    /**
     * @param array $destinations
     * @return int affected rows
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function insertIgnoreFromArray(array $destinations)
    {
        $destinationInsert =
            'INSERT IGNORE INTO Destinations (prefix, name_en, name_es, name_ca, name_it, brandId) VALUES '
            . implode(",", $destinations);

        $nativeQuery = new NativeQuery($this->_em);
        $nativeQuery->setSQL($destinationInsert);

        return $this->queryRunner->execute(
            Destination::class,
            $nativeQuery
        );
    }

    /**
     * Returns ['prefix' => id] array
     *
     * @param int $brandId
     * @return array
     */
    public function getPrefixArrayByBrandId(int $brandId): array
    {
        $qb = $this
            ->createQueryBuilder('self');

        $query = $qb
            ->select('self.id, self.prefix')
            ->where(
                $qb->expr()->eq('self.brand', $brandId)
            );

        $items = $query
            ->getQuery()
            ->getScalarResult();

        $response = [];
        foreach ($items as $item) {
            $response[$item['prefix']] = $item['id'];
        }

        return $response;
    }
}
