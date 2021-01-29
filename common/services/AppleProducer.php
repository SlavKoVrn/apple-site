<?php

namespace common\services;

use common\helpers\NumberRandomizer;
use common\models\apple\Apple;
use common\repositories\AppleRepository;

/**
 * Class AppleProducer
 * @package common\services
 *
 * A service to produce random number of new apples
 */
class AppleProducer
{
    /** @var int minimum range limit (inclusive) */
    const RANDOM_MIN = 1;

    /** @var int maximum range limit (inclusive) */
    const RANDOM_MAX = 10;

    /** @var int number of apples to produce */
    protected $count;

    /** @var Apple[] produced apples */
    protected $apples = [];

    /**
     * AppleProducer constructor.
     * @param int|null $min minimum number of apples to produce
     * @param int|null $max maximum number of apples to produce
     */
    public function __construct(int $min = null, int $max = null)
    {
        $from = max($min, self::RANDOM_MIN);
        $to = $max > 0 ? $max : self::RANDOM_MAX;
        $this->count = (new NumberRandomizer($from, $to))->nextRandom();
    }

    /**
     * Get all produced apples
     * @return Apple[]
     */
    public function allApples(): array
    {
        return $this->apples;
    }

    /**
     * Get non-present apples from produced ones
     * @return Apple[]
     */
    public function nonPresentApples(): array
    {
        return array_filter($this->apples, function ($apple) {
            return !$apple->isPresent();
        });
    }

    /**
     * Get present apples from produced ones
     * @return Apple[]
     */
    public function presentApples(): array
    {
        return array_filter($this->apples, function ($apple) {
            return $apple->isPresent();
        });
    }

    /**
     * Produce new apples
     * @return static
     */
    public function produce()
    {
        $this->apples = (new AppleRepository())->produce($this->count);
        return $this;
    }
}
