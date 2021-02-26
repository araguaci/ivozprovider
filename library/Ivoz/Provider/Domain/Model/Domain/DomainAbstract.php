<?php
declare(strict_types = 1);

namespace Ivoz\Provider\Domain\Model\Domain;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use \Ivoz\Core\Application\ForeignKeyTransformerInterface;

/**
* DomainAbstract
* @codeCoverageIgnore
*/
abstract class DomainAbstract
{
    use ChangelogTrait;

    /**
     * @var string
     */
    protected $domain;

    /**
     * @var string
     */
    protected $pointsTo = 'proxyusers';

    /**
     * @var string | null
     */
    protected $description;

    /**
     * Constructor
     */
    protected function __construct(
        $domain,
        $pointsTo
    ) {
        $this->setDomain($domain);
        $this->setPointsTo($pointsTo);
    }

    abstract public function getId();

    public function __toString()
    {
        return sprintf(
            "%s#%s",
            "Domain",
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
     * @return DomainDto
     */
    public static function createDto($id = null)
    {
        return new DomainDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param DomainInterface|null $entity
     * @param int $depth
     * @return DomainDto|null
     */
    public static function entityToDto(EntityInterface $entity = null, $depth = 0)
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, DomainInterface::class);

        if ($depth < 1) {
            return static::createDto($entity->getId());
        }

        if ($entity instanceof \Doctrine\ORM\Proxy\Proxy && !$entity->__isInitialized()) {
            return static::createDto($entity->getId());
        }

        /** @var DomainDto $dto */
        $dto = $entity->toDto($depth-1);

        return $dto;
    }

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param DomainDto $dto
     * @return self
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, DomainDto::class);

        $self = new static(
            $dto->getDomain(),
            $dto->getPointsTo()
        );

        $self
            ->setDescription($dto->getDescription());

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param DomainDto $dto
     * @return self
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, DomainDto::class);

        $this
            ->setDomain($dto->getDomain())
            ->setPointsTo($dto->getPointsTo())
            ->setDescription($dto->getDescription());

        return $this;
    }

    /**
     * @internal use EntityTools instead
     * @param int $depth
     * @return DomainDto
     */
    public function toDto($depth = 0)
    {
        return self::createDto()
            ->setDomain(self::getDomain())
            ->setPointsTo(self::getPointsTo())
            ->setDescription(self::getDescription());
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return [
            'domain' => self::getDomain(),
            'pointsTo' => self::getPointsTo(),
            'description' => self::getDescription()
        ];
    }

    protected function setDomain(string $domain): static
    {
        Assertion::maxLength($domain, 190, 'domain value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->domain = $domain;

        return $this;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    protected function setPointsTo(string $pointsTo): static
    {
        $this->pointsTo = $pointsTo;

        return $this;
    }

    public function getPointsTo(): string
    {
        return $this->pointsTo;
    }

    protected function setDescription(?string $description = null): static
    {
        if (!is_null($description)) {
            Assertion::maxLength($description, 500, 'description value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

}
