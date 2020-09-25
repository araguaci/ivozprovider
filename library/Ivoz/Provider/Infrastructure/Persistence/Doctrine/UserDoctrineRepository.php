<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\Administrator\AdministratorInterface;
use Ivoz\Provider\Domain\Model\Company\Company;
use Ivoz\Provider\Domain\Model\User\User;
use Ivoz\Provider\Domain\Model\User\UserInterface;
use Ivoz\Provider\Domain\Model\User\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * UserDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserDoctrineRepository extends ServiceEntityRepository implements UserRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string | int $id
     * @return UserInterface[]
     */
    public function findByBossAssistantId($id)
    {
        return $this->findBy([
            'bossAssistant' => $id
        ]);
    }

    /**
     * Used by client API access controls
     * @param AdministratorInterface $admin
     * @return array
     */
    public function getSupervisedUserIdsByAdmin(AdministratorInterface $admin)
    {
        $companyIds = $admin->isBrandAdmin()
            ? $this->getCompanyIdsByBrandAdmin($admin)
            : [ $admin->getCompany()->getId() ];

        $qb = $this->createQueryBuilder('self');
        $expression = $qb->expr();

        $qb
            ->select('self.id')
            ->where(
                $expression->in('self.company', $companyIds)
            );

        $result = $qb->getQuery()->getScalarResult();

        return array_column($result, 'id');
    }

    /**
     * @param UserInterface $user
     * @return UserInterface[]
     */
    public function getUserAssistantCandidates(UserInterface $user) :array
    {
        $company = $user->getCompany();

        $qb = $this->createQueryBuilder('self');
        $expression = $qb->expr();

        $query = $qb
            ->where(
                $expression->eq('self.company', $company->getid())
            )->andWhere(
                $expression->neq('self.id', $user->getid())
            )->andWhere(
                $expression->eq('self.isBoss', 0)
            )->getQuery();

        return $query->getResult();
    }

    /**
     * @param UserInterface $user
     * @return UserInterface[]
     */
    public function getAvailableVoicemails(UserInterface $user) :array
    {
        $company = $user->getCompany();

        $qb = $this->createQueryBuilder('self');
        $expression = $qb->expr();

        $query = $qb
            ->where(
                $expression->eq('self.company', $company->getid())
            )->andWhere(
                $expression->eq('self.voicemailEnabled', true)
            )->getQuery();

        return $query->getResult();
    }


    public function getBrandUsersIdsOrderByTerminalExpireDate(int $brandId, string $order = 'DESC')
    {
        $query = $this->getBrandUsersIdsOrderByTerminalExpireDateQuery(
            $brandId,
            $order,
            'LEFT'
        );

        $connection = $this
            ->getEntityManager()
            ->getConnection();

        $results = $connection->fetchAll($query);

        return array_column(
            $results,
            'userId'
        );
    }

    private function getBrandUsersIdsOrderByTerminalExpireDateQuery(
        int $brandId,
        string $order,
        string $join = 'INNER'
    ): string {
        $query =
            'SELECT U.id as userId, U.companyId, T.id as terminalId, D.domain, K.domain, K.expires FROM Users U'
            . " %s JOIN Terminals T ON U.terminalId = T.id"
            . ' %s JOIN Domains D ON T.domainId = D.id'
            . ' %s JOIN kam_users_location K ON K.username = T.name AND K.domain = D.domain'
            . ' WHERE U.companyId IN (SELECT id FROM Companies WHERE brandId = %d) '
            . ' ORDER BY expires %s';

        return sprintf(
            $query,
            $join,
            $join,
            $join,
            $brandId,
            $order
        );
    }

    /**
     * @param AdministratorInterface $admin
     * @return array
     */
    protected function getCompanyIdsByBrandAdmin(AdministratorInterface $admin): array
    {
        $qb = $this->_em
            ->createQueryBuilder()
            ->select('self.id')
            ->from(Company::class, 'self');
        $expression = $qb->expr();

        $qb->where(
            $expression->eq('self.brand', $admin->getBrand()->getId())
        );
        $result = $qb->getQuery()->getScalarResult();

        return array_column($result, 'id');
    }
}
