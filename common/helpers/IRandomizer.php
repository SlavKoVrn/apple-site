<?php

namespace common\helpers;

/**
 * Interface IRandomizer
 * @package common\helpers
 *
 * Random value generator interface
 */
interface IRandomizer
{
    /**
     * Generate a random value
     * @return mixed
     */
    function nextRandom();
}
