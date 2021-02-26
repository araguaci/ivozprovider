<?php

namespace Ivoz\Provider\Domain\Service\Domain;

use Ivoz\Core\Domain\Assert\Assertion;
use Ivoz\Core\Domain\Service\LifecycleServiceCollectionInterface;
use Ivoz\Core\Domain\Service\LifecycleServiceCollectionTrait;

/**
 * @codeCoverageIgnore
 */
class DomainLifecycleServiceCollection implements LifecycleServiceCollectionInterface
{
    use LifecycleServiceCollectionTrait;

    public static $bindedBaseServices = [
        "post_persist" =>
        [
            \Ivoz\Ast\Domain\Service\PsEndpoint\UpdateByDomain::class => 10,
        ],
        "on_commit" =>
        [
            \Ivoz\Provider\Domain\Service\Domain\SendUsersDomainReloadRequest::class => 200,
        ],
    ];

    protected function addService(string $event, $service): void
    {
        Assertion::isInstanceOf($service, DomainLifecycleEventHandlerInterface::class);
        $this->services[$event][] = $service;
    }
}
