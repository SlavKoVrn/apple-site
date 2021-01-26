<?php

namespace common\helpers;

use common\models\Color;

/**
 * Class ColorRandomizer
 * @package common\helpers
 *
 * Random color generator
 */
class ColorRandomizer implements IRandomizer
{
    /**
     * @inheritDoc
     * Fetch random color from DB
     * @return int color ID
     */
    public function nextRandom()
    {
        return (int) Color::find()
            ->select('id')
            ->orderBy('RAND()')
            ->scalar();
    }
}
