<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\Country;

use Assert\Assertion;

/**
* Zone
* @codeCoverageIgnore
*/
final class Zone
{
    /**
     * column: zone_en
     */
    private $en = '';

    /**
     * column: zone_es
     */
    private $es = '';

    /**
     * column: zone_ca
     */
    private $ca = '';

    /**
     * column: zone_it
     */
    private $it = '';

    /**
     * Constructor
     */
    public function __construct(
        string $en,
        string $es,
        string $ca,
        string $it
    ) {
        $this->setEn($en);
        $this->setEs($es);
        $this->setCa($ca);
        $this->setIt($it);
    }

    /**
     * Equals
     */
    public function equals(self $zone)
    {
        if ($this->getEn() !== $zone->getEn()) {
            return false;
        }
        if ($this->getEs() !== $zone->getEs()) {
            return false;
        }
        if ($this->getCa() !== $zone->getCa()) {
            return false;
        }
        return $this->getIt() === $zone->getIt();
    }

    protected function setEn(string $en): static
    {
        Assertion::maxLength($en, 55, 'en value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->en = $en;

        return $this;
    }

    public function getEn(): string
    {
        return $this->en;
    }

    protected function setEs(string $es): static
    {
        Assertion::maxLength($es, 55, 'es value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->es = $es;

        return $this;
    }

    public function getEs(): string
    {
        return $this->es;
    }

    protected function setCa(string $ca): static
    {
        Assertion::maxLength($ca, 55, 'ca value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->ca = $ca;

        return $this;
    }

    public function getCa(): string
    {
        return $this->ca;
    }

    protected function setIt(string $it): static
    {
        Assertion::maxLength($it, 55, 'it value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->it = $it;

        return $this;
    }

    public function getIt(): string
    {
        return $this->it;
    }
}
