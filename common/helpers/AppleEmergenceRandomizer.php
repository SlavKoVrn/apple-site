<?php

namespace common\helpers;

use DateTime;

/**
 * Class AppleEmergenceRandomizer
 * @package common\helpers
 *
 * Apple emergence date generator
 */
class AppleEmergenceRandomizer extends NumberRandomizer
{
    /**
     * Obtain a timestamp value from the current date modified by the given parameter
     * @param string $modify
     * @see DateTime::modify
     * @return int
     */
    protected function obtainTimestamp(string $modify): int
    {
        return (new DateTime())
            ->modify($modify)
            ->getTimestamp();
    }

    /**
     * AppleEmergenceRandomizer constructor.
     * @param string $from DateTime modification string (relative to the current date)
     * @param string $to DateTime modification string (relative to the current date)
     * @see DateTime::modify
     */
    public function __construct($from, $to)
    {
        parent::__construct($this->obtainTimestamp($from), $this->obtainTimestamp($to));
    }

    /**
     * @inheritDoc
     * @return string
     */
    public function nextRandom()
    {
        return date(DateTimeHelper::FORMAT_SQL, parent::nextRandom());
    }
}
