<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Core\Infrastructure\Domain\Service\DoctrineQueryRunner;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\Model\Helper\CriteriaHelper;
use Ivoz\Provider\Domain\Model\Administrator\AdministratorInterface;
use Ivoz\Provider\Domain\Model\AdministratorRelPublicEntity\AdministratorRelPublicEntity;
use Ivoz\Provider\Domain\Model\AdministratorRelPublicEntity\AdministratorRelPublicEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * AdministratorRelPublicEntityDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdministratorRelPublicEntityDoctrineRepository extends ServiceEntityRepository implements AdministratorRelPublicEntityRepository
{
    protected $queryRunner;

    public function __construct(
        ManagerRegistry $registry,
        DoctrineQueryRunner $queryRunner
    ) {
        parent::__construct($registry, AdministratorRelPublicEntity::class);
        $this->queryRunner = $queryRunner;
    }

    public function setWritePermissions(
        AdministratorInterface $administrator
    ): int {

        $qb = $this
            ->prepareUpdateQuery(
                true,
                true
            )
            ->where('self.administrator = :id')
            ->setParameter(':id', $administrator->getId());

        return $this->queryRunner->execute(
            $this->getEntityName(),
            $qb->getQuery()
        );
    }

    /**
     * @param int[] $ids
     */
    public function setWritePermissionsByIds(
        array $ids
    ): int {

        $qb = $this
            ->prepareUpdateQuery(
                true,
                true
            )
            ->where('self.id in (:ids)')
            ->setParameter(':ids', $ids);

        return $this->queryRunner->execute(
            $this->getEntityName(),
            $qb->getQuery()
        );
    }

    public function setReadOnlyPermissions(
        AdministratorInterface $administrator
    ): int {
        $qb = $this
            ->prepareUpdateQuery(
                true,
                false
            )
            ->where('self.administrator = :id')
            ->setParameter(':id', $administrator->getId());

        return $this->queryRunner->execute(
            $this->getEntityName(),
            $qb->getQuery()
        );
    }

    /**
     * @param int[] $ids
     */
    public function setReadOnlyPermissionsByIds(
        array $ids
    ): int {

        $qb = $this
            ->prepareUpdateQuery(
                true,
                false
            )
            ->where('self.id in (:ids)')
            ->setParameter(':ids', $ids);

        return $this->queryRunner->execute(
            $this->getEntityName(),
            $qb->getQuery()
        );
    }


    /**
     * @param int[] $ids
     */
    public function revokePermissionsByIds(
        array $ids
    ): int {

        $qb = $this
            ->prepareUpdateQuery(
                false,
                false
            )
            ->where('self.id in (:ids)')
            ->setParameter(':ids', $ids);

        return $this->queryRunner->execute(
            $this->getEntityName(),
            $qb->getQuery()
        );
    }

    public function removeByAdministratorId(int $id): int
    {
        $qb = $this
            ->createQueryBuilder('self');

        $criteria = CriteriaHelper::fromArray([
            ['administrator', 'eq', $id]
        ]);

        $qb
            ->delete(
                $this->getEntityName(),
                'self'
            )
            ->addCriteria($criteria);

        return $this->queryRunner->execute(
            $this->getEntityName(),
            $qb->getQuery()
        );
    }

    private function prepareUpdateQuery(bool $read, bool $write)
    {
        return $this
            ->createQueryBuilder('self')
            ->update($this->_entityName, 'self')
            ->set('self.create', ':writeValue')
            ->set('self.read', ':readValue')
            ->set('self.update', ':writeValue')
            ->set('self.delete', ':writeValue')
            ->setParameter(':writeValue', $write)
            ->setParameter(':readValue', $read);
    }
}
