<?php

namespace common\dictionaries;

/**
 * Class AppleStatus
 * @package common\dictionaries
 *
 * Состояния яблок
 */
class AppleStatus
{
    /** @var int висит на дереве */
    const TREE = 1;

    /** @var int упало, лежит на земле */
    const GROUND = 2;

    /** @var int гнилое */
    const ROTTEN = 3;
}
