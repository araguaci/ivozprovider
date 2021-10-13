<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\OutgoingDdiRule;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\Company\CompanyInterface;
use Ivoz\Provider\Domain\Model\Ddi\DdiInterface;
use Ivoz\Provider\Domain\Model\Company\Company;
use Ivoz\Provider\Domain\Model\Ddi\Ddi;

/**
* OutgoingDdiRuleAbstract
* @codeCoverageIgnore
*/
abstract class OutgoingDdiRuleAbstract
{
    use ChangelogTrait;

    protected $name;

    /**
     * comment: enum:keep|force
     */
    protected $defaultAction;

    /**
     * @var CompanyInterface
     */
    protected $company;

    /**
     * @var DdiInterface | null
     */
    protected $forcedDdi;

    /**
     * Constructor
     */
    protected function __construct(
        string $name,
        string $defaultAction
    ) {
        $this->setName($name);
        $this->setDefaultAction($defaultAction);
    }

    abstract public function getId();

    public function __toString()
    {
        return sprintf(
            "%s#%s",
            "OutgoingDdiRule",
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
     */
    public static function createDto($id = null): OutgoingDdiRuleDto
    {
        return new OutgoingDdiRuleDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param OutgoingDdiRuleInterface|null $entity
     * @param int $depth
     * @return OutgoingDdiRuleDto|null
     */
    public static function entityToDto(EntityInterface $entity = null, $depth = 0)
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, OutgoingDdiRuleInterface::class);

        if ($depth < 1) {
            return static::createDto($entity->getId());
        }

        if ($entity instanceof \Doctrine\ORM\Proxy\Proxy && !$entity->__isInitialized()) {
            return static::createDto($entity->getId());
        }

        /** @var OutgoingDdiRuleDto $dto */
        $dto = $entity->toDto($depth - 1);

        return $dto;
    }

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param OutgoingDdiRuleDto $dto
     * @return self
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, OutgoingDdiRuleDto::class);

        $self = new static(
            $dto->getName(),
            $dto->getDefaultAction()
        );

        $self
            ->setCompany($fkTransformer->transform($dto->getCompany()))
            ->setForcedDdi($fkTransformer->transform($dto->getForcedDdi()));

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param OutgoingDdiRuleDto $dto
     * @return self
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, OutgoingDdiRuleDto::class);

        $this
            ->setName($dto->getName())
            ->setDefaultAction($dto->getDefaultAction())
            ->setCompany($fkTransformer->transform($dto->getCompany()))
            ->setForcedDdi($fkTransformer->transform($dto->getForcedDdi()));

        return $this;
    }

    /**
     * @internal use EntityTools instead
     * @param int $depth
     */
    public function toDto($depth = 0): OutgoingDdiRuleDto
    {
        return self::createDto()
            ->setName(self::getName())
            ->setDefaultAction(self::getDefaultAction())
            ->setCompany(Company::entityToDto(self::getCompany(), $depth))
            ->setForcedDdi(Ddi::entityToDto(self::getForcedDdi(), $depth));
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return [
            'name' => self::getName(),
            'defaultAction' => self::getDefaultAction(),
            'companyId' => self::getCompany()->getId(),
            'forcedDdiId' => self::getForcedDdi() ? self::getForcedDdi()->getId() : null
        ];
    }

    protected function setName(string $name): static
    {
        Assertion::maxLength($name, 50, 'name value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    protected function setDefaultAction(string $defaultAction): static
    {
        Assertion::maxLength($defaultAction, 10, 'defaultAction value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        Assertion::choice(
            $defaultAction,
            [
                OutgoingDdiRuleInterface::DEFAULTACTION_KEEP,
                OutgoingDdiRuleInterface::DEFAULTACTION_FORCE,
            ],
            'defaultActionvalue "%s" is not an element of the valid values: %s'
        );

        $this->defaultAction = $defaultAction;

        return $this;
    }

    public function getDefaultAction(): string
    {
        return $this->defaultAction;
    }

    protected function setCompany(CompanyInterface $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getCompany(): CompanyInterface
    {
        return $this->company;
    }

    protected function setForcedDdi(?DdiInterface $forcedDdi = null): static
    {
        $this->forcedDdi = $forcedDdi;

        return $this;
    }

    public function getForcedDdi(): ?DdiInterface
    {
        return $this->forcedDdi;
    }
}
