<?php
declare(strict_types = 1);

namespace Ivoz\Provider\Domain\Model\FixedCost;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use \Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\Brand\BrandInterface;
use Ivoz\Provider\Domain\Model\Brand\Brand;

/**
* FixedCostAbstract
* @codeCoverageIgnore
*/
abstract class FixedCostAbstract
{
    use ChangelogTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string | null
     */
    protected $description;

    /**
     * @var float | null
     */
    protected $cost;

    /**
     * @var BrandInterface
     */
    protected $brand;

    /**
     * Constructor
     */
    protected function __construct(
        $name
    ) {
        $this->setName($name);
    }

    abstract public function getId();

    public function __toString()
    {
        return sprintf(
            "%s#%s",
            "FixedCost",
            $this->getId()
        );
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function sanitizeValues()
    {
    }

    /**
     * @param mixed $id
     * @return FixedCostDto
     */
    public static function createDto($id = null)
    {
        return new FixedCostDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param FixedCostInterface|null $entity
     * @param int $depth
     * @return FixedCostDto|null
     */
    public static function entityToDto(EntityInterface $entity = null, $depth = 0)
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, FixedCostInterface::class);

        if ($depth < 1) {
            return static::createDto($entity->getId());
        }

        if ($entity instanceof \Doctrine\ORM\Proxy\Proxy && !$entity->__isInitialized()) {
            return static::createDto($entity->getId());
        }

        /** @var FixedCostDto $dto */
        $dto = $entity->toDto($depth-1);

        return $dto;
    }

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param FixedCostDto $dto
     * @return self
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, FixedCostDto::class);

        $self = new static(
            $dto->getName()
        );

        $self
            ->setDescription($dto->getDescription())
            ->setCost($dto->getCost())
            ->setBrand($fkTransformer->transform($dto->getBrand()));

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param FixedCostDto $dto
     * @return self
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, FixedCostDto::class);

        $this
            ->setName($dto->getName())
            ->setDescription($dto->getDescription())
            ->setCost($dto->getCost())
            ->setBrand($fkTransformer->transform($dto->getBrand()));

        return $this;
    }

    /**
     * @internal use EntityTools instead
     * @param int $depth
     * @return FixedCostDto
     */
    public function toDto($depth = 0)
    {
        return self::createDto()
            ->setName(self::getName())
            ->setDescription(self::getDescription())
            ->setCost(self::getCost())
            ->setBrand(Brand::entityToDto(self::getBrand(), $depth));
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return [
            'name' => self::getName(),
            'description' => self::getDescription(),
            'cost' => self::getCost(),
            'brandId' => self::getBrand()->getId()
        ];
    }

    protected function setName(string $name): static
    {
        Assertion::maxLength($name, 255, 'name value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    protected function setDescription(?string $description = null): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    protected function setCost(?float $cost = null): static
    {
        if (!is_null($cost)) {
            $cost = (float) $cost;
        }

        $this->cost = $cost;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    protected function setBrand(BrandInterface $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getBrand(): BrandInterface
    {
        return $this->brand;
    }

}
