<?php

namespace Ivoz\Ast\Domain\Model\PsEndpoint;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;
use Ivoz\Provider\Domain\Model\Terminal\TerminalInterface;
use Ivoz\Provider\Domain\Model\Friend\FriendInterface;
use Ivoz\Provider\Domain\Model\ResidentialDevice\ResidentialDeviceInterface;
use Ivoz\Provider\Domain\Model\RetailAccount\RetailAccountInterface;

/**
* PsEndpointInterface
*/
interface PsEndpointInterface extends LoggableEntityInterface
{
    public const DIRECTMEDIAMETHOD_UPDATE = 'update';

    public const DIRECTMEDIAMETHOD_INVITE = 'invite';

    public const DIRECTMEDIAMETHOD_REINVITE = 'reinvite';

    public const T38UDPTL_YES = 'yes';

    public const T38UDPTL_NO = 'no';

    public const T38UDPTLEC_NONE = 'none';

    public const T38UDPTLEC_FEC = 'fec';

    public const T38UDPTLEC_REDUNDANCY = 'redundancy';

    public const T38UDPTLNAT_YES = 'yes';

    public const T38UDPTLNAT_NO = 'no';

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getChangeSet(): array;

    public function getSorceryId(): string;

    public function getFromDomain(): ?string;

    public function getAors(): ?string;

    public function getCallerid(): ?string;

    public function getContext(): string;

    public function getDisallow(): string;

    public function getAllow(): string;

    public function getDirectMedia(): ?string;

    public function getDirectMediaMethod(): ?string;

    public function getMailboxes(): ?string;

    public function getNamedPickupGroup(): ?string;

    public function getSendDiversion(): ?string;

    public function getSendPai(): ?string;

    public function getOneHundredRel(): string;

    public function getOutboundProxy(): ?string;

    public function getTrustIdInbound(): ?string;

    public function getT38Udptl(): string;

    public function getT38UdptlEc(): string;

    public function getT38UdptlMaxdatagram(): int;

    public function getT38UdptlNat(): string;

    public function setTerminal(?TerminalInterface $terminal = null): static;

    public function getTerminal(): ?TerminalInterface;

    public function setFriend(?FriendInterface $friend = null): static;

    public function getFriend(): ?FriendInterface;

    public function setResidentialDevice(?ResidentialDeviceInterface $residentialDevice = null): static;

    public function getResidentialDevice(): ?ResidentialDeviceInterface;

    public function setRetailAccount(?RetailAccountInterface $retailAccount = null): static;

    public function getRetailAccount(): ?RetailAccountInterface;

    public function isInitialized(): bool;
}
