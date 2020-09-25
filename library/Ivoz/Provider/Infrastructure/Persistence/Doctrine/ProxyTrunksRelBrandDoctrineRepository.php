<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\Administrator\AdministratorInterface;
use Ivoz\Provider\Domain\Model\ProxyTrunksRelBrand\ProxyTrunksRelBrand;
use Ivoz\Provider\Domain\Model\ProxyTrunksRelBrand\ProxyTrunksRelBrandRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * ProxyTrunksRelBrandDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProxyTrunksRelBrandDoctrineRepository extends ServiceEntityRepository implements ProxyTrunksRelBrandRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProxyTrunksRelBrand::class);
    }

    /**
     * @param AdministratorInterface $admin
     * @return int[]
     */
    public function getTrunkIdsByBrandAdmin(AdministratorInterface $admin): array
    {
        if (!$admin->isBrandAdmin()) {
            throw new \DomainException('User must be brand admin');
        }

        $qb = $this->createQueryBuilder('self');
        $expression = $qb->expr();

        $qb
            ->select(
                'IDENTITY(self.proxyTrunk) as proxyTrunk'
            )
            ->where(
                $expression->eq(
                    'self.brand',
                    $admin->getBrand()->getId()
                )
            );

        $results = $qb->getQuery()->getArrayResult();

        $response = [];
        foreach ($results as $result) {
            $response[] = (int) $result['proxyTrunk'];
        }

        return $response;
    }
}
