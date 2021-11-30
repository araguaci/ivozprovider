<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\ConditionalRoutesConditionsRelCalendar\ConditionalRoutesConditionsRelCalendar;
use Ivoz\Provider\Domain\Model\ConditionalRoutesConditionsRelCalendar\ConditionalRoutesConditionsRelCalendarRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * ConditionalRoutesConditionsRelMatchListDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 *
 * @template-extends ServiceEntityRepository<ConditionalRoutesConditionsRelCalendar>
 */
class ConditionalRoutesConditionsRelCalendarDoctrineRepository extends ServiceEntityRepository implements ConditionalRoutesConditionsRelCalendarRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConditionalRoutesConditionsRelCalendar::class);
    }
}
