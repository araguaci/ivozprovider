<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\Model\Helper\CriteriaHelper;
use Ivoz\Provider\Domain\Model\BalanceNotification\BalanceNotificationRepository;
use Ivoz\Provider\Domain\Model\BalanceNotification\BalanceNotification;
use Ivoz\Provider\Domain\Model\Company\CompanyInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * BalanceNotificationDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BalanceNotificationDoctrineRepository extends ServiceEntityRepository implements BalanceNotificationRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BalanceNotification::class);
    }
    /**
     * @inheritdoc
     * @see BalanceNotificationRepository::findBrokenThresholdsByCompany
     */
    public function findBrokenThresholdsByCompany(CompanyInterface $company, $prevValue, $currentValue)
    {
        $qb = $this->createQueryBuilder('self');

        $qb
            ->select('self')
            ->addCriteria(
                CriteriaHelper::fromArray([
                    ['company', 'eq', $company->getId()],
                    ['threshold', 'lte', $prevValue],
                    ['threshold', 'gt', $currentValue],
                ])
            );

        return $qb->getQuery()->getResult();
    }
}
