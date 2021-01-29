<?php

namespace common\helpers;

/**
 * Class NumberRandomizer
 * @package common\helpers
 *
 * Random number generator within a range
 */
class NumberRandomizer implements IRandomizer
{
    /** @var int minimum range limit (inclusive) */
    protected $min;

    /** @var int maximum range limit (inclusive) */
    protected $max;

    /**
     * NumberRandomizer constructor.
     * @param int $from
     * @param int $to
     */
    public function __construct($from, $to)
    {
        $this->min = min($from, $to);
        $this->max = max($from, $to);
    }

    /**
     * @inheritDoc
     * @return int
     */
    function nextRandom()
    {
        return mt_rand($this->min, $this->max);
    }
}
