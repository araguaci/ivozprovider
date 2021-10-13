<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\DdiProviderAddress;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Kam\Domain\Model\TrunksAddress\TrunksAddressInterface;

/**
* @codeCoverageIgnore
*/
trait DdiProviderAddressTrait
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var TrunksAddressInterface
     * mappedBy ddiProviderAddress
     */
    protected $trunksAddress;

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct(...func_get_args());
    }

    abstract protected function sanitizeValues();

    /**
     * Factory method
     * @internal use EntityTools instead
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        /** @var static $self */
        $self = parent::fromDto($dto, $fkTransformer);
        if (!is_null($dto->getTrunksAddress())) {
            $self->setTrunksAddress(
                $fkTransformer->transform(
                    $dto->getTrunksAddress()
                )
            );
        }

        $self->sanitizeValues();
        if ($dto->getId()) {
            $self->id = $dto->getId();
            $self->initChangelog();
        }

        return $self;
    }

    /**
     * @internal use EntityTools instead
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        parent::updateFromDto($dto, $fkTransformer);
        if (!is_null($dto->getTrunksAddress())) {
            $this->setTrunksAddress(
                $fkTransformer->transform(
                    $dto->getTrunksAddress()
                )
            );
        }
        $this->sanitizeValues();

        return $this;
    }

    /**
     * @internal use EntityTools instead
     * @param int $depth
     */
    public function toDto($depth = 0): DdiProviderAddressDto
    {
        $dto = parent::toDto($depth);
        return $dto
            ->setId($this->getId());
    }

    protected function __toArray(): array
    {
        return parent::__toArray() + [
            'id' => self::getId()
        ];
    }

    public function setTrunksAddress(TrunksAddressInterface $trunksAddress): static
    {
        $this->trunksAddress = $trunksAddress;

        /** @var  $this */
        return $this;
    }

    public function getTrunksAddress(): ?TrunksAddressInterface
    {
        return $this->trunksAddress;
    }
}
