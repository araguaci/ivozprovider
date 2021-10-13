<?php

namespace Ivoz\Provider\Domain\Model\CallForwardSetting;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;
use Ivoz\Provider\Domain\Model\User\UserInterface;
use Ivoz\Provider\Domain\Model\Extension\ExtensionInterface;
use Ivoz\Provider\Domain\Model\Country\CountryInterface;
use Ivoz\Provider\Domain\Model\ResidentialDevice\ResidentialDeviceInterface;
use Ivoz\Provider\Domain\Model\RetailAccount\RetailAccountInterface;
use Ivoz\Provider\Domain\Model\Ddi\DdiInterface;

/**
* CallForwardSettingInterface
*/
interface CallForwardSettingInterface extends LoggableEntityInterface
{
    public const CALLTYPEFILTER_INTERNAL = 'internal';

    public const CALLTYPEFILTER_EXTERNAL = 'external';

    public const CALLTYPEFILTER_BOTH = 'both';

    public const CALLFORWARDTYPE_INCONDITIONAL = 'inconditional';

    public const CALLFORWARDTYPE_NOANSWER = 'noAnswer';

    public const CALLFORWARDTYPE_BUSY = 'busy';

    public const CALLFORWARDTYPE_USERNOTREGISTERED = 'userNotRegistered';

    public const TARGETTYPE_NUMBER = 'number';

    public const TARGETTYPE_EXTENSION = 'extension';

    public const TARGETTYPE_VOICEMAIL = 'voicemail';

    public const TARGETTYPE_RETAIL = 'retail';

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getChangeSet(): array;

    /**
     * {@inheritDoc}
     *
     * @throws \InvalidArgumentException
     */
    public function setNumberValue(?string $numberValue = null): static;

    public function toArrayPortal();

    /**
     * Get the numberValue in E.164 format when routing to 'number'
     *
     * @return string
     */
    public function getNumberValueE164();

    /**
     * Alias for getTargetType
     *
     * @todo rename tagetType field to routeType
     */
    public function getRouteType(): ?string;

    public function getCallForwardTarget();

    public function getCallTypeFilter(): string;

    public function getCallForwardType(): string;

    public function getTargetType(): ?string;

    public function getNumberValue(): ?string;

    public function getNoAnswerTimeout(): int;

    public function getEnabled(): bool;

    public function setUser(?UserInterface $user = null): static;

    public function getUser(): ?UserInterface;

    public function getExtension(): ?ExtensionInterface;

    public function getVoiceMailUser(): ?UserInterface;

    public function getNumberCountry(): ?CountryInterface;

    public function setResidentialDevice(?ResidentialDeviceInterface $residentialDevice = null): static;

    public function getResidentialDevice(): ?ResidentialDeviceInterface;

    public function setRetailAccount(?RetailAccountInterface $retailAccount = null): static;

    public function getRetailAccount(): ?RetailAccountInterface;

    public function getCfwToRetailAccount(): ?RetailAccountInterface;

    public function getDdi(): ?DdiInterface;

    public function isInitialized(): bool;

    /**
     * @param string $prefix
     * @return null|string
     */
    public function getTarget(string $prefix = '');
}
