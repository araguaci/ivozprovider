<?php

namespace Ivoz\Provider\Domain\Service\Administrator;

use Ivoz\Core\Domain\Assert\Assertion;
use Ivoz\Core\Domain\Service\LifecycleServiceCollectionInterface;
use Ivoz\Core\Domain\Service\LifecycleServiceCollectionTrait;

/**
 * @codeCoverageIgnore
 */
class AdministratorLifecycleServiceCollection implements LifecycleServiceCollectionInterface
{
    use LifecycleServiceCollectionTrait;

    public static $bindedBaseServices = [
        "post_persist" =>
        [
            \Ivoz\Provider\Domain\Service\AdministratorRelPublicEntity\CreateAcls::class => 200,
            \Ivoz\Provider\Domain\Service\AdministratorRelPublicEntity\RemoveAcls::class => 200,
        ],
    ];

    protected function addService(string $event, $service): void
    {
        Assertion::isInstanceOf($service, AdministratorLifecycleEventHandlerInterface::class);
        $this->services[$event][] = $service;
    }
}
