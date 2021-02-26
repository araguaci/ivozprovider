<?php

namespace Ivoz\Provider\Domain\Model\PublicEntity;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;

/**
* PublicEntityInterface
*/
interface PublicEntityInterface extends LoggableEntityInterface
{
    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getChangeSet();

    public function getIden(): string;

    public function getFqdn(): ?string;

    public function getPlatform(): bool;

    public function getBrand(): bool;

    public function getClient(): bool;

    public function getName(): Name;

    /**
     * @return bool
     */
    public function isInitialized(): bool;

}
