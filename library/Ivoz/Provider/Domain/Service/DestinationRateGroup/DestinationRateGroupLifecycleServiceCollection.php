<?php

namespace Ivoz\Provider\Domain\Service\DestinationRateGroup;

use Ivoz\Core\Domain\Assert\Assertion;
use Ivoz\Core\Domain\Service\LifecycleServiceCollectionInterface;
use Ivoz\Core\Domain\Service\LifecycleServiceCollectionTrait;

/**
 * @codeCoverageIgnore
 */
class DestinationRateGroupLifecycleServiceCollection implements LifecycleServiceCollectionInterface
{
    use LifecycleServiceCollectionTrait;

    public static $bindedBaseServices = [
        "on_commit" =>
        [
            \Ivoz\Provider\Domain\Service\DestinationRateGroup\SendImporterOrder::class => 10,
            \Ivoz\Provider\Domain\Service\DestinationRateGroup\UpdatedDestinationRateGroupNotificator::class => 200,
        ],
    ];

    protected function addService(string $event, $service): void
    {
        Assertion::isInstanceOf($service, DestinationRateGroupLifecycleEventHandlerInterface::class);
        $this->services[$event][] = $service;
    }
}
