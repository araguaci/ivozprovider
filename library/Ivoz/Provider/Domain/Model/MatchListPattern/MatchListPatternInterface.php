<?php

namespace Ivoz\Provider\Domain\Model\MatchListPattern;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;
use Ivoz\Provider\Domain\Model\MatchList\MatchListInterface;
use Ivoz\Provider\Domain\Model\Country\CountryInterface;

/**
* MatchListPatternInterface
*/
interface MatchListPatternInterface extends LoggableEntityInterface
{
    const TYPE_NUMBER = 'number';

    const TYPE_REGEXP = 'regexp';

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getChangeSet();

    /**
     * Get Number value in E.164 format
     * @return string
     */
    public function getNumberE164();

    public function getDescription(): ?string;

    public function getType(): string;

    public function getRegexp(): ?string;

    public function getNumbervalue(): ?string;

    public function setMatchList(MatchListInterface $matchList): static;

    public function getMatchList(): MatchListInterface;

    public function getNumberCountry(): ?CountryInterface;

    /**
     * @return bool
     */
    public function isInitialized(): bool;

}
