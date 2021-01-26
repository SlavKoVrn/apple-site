<?php

namespace common\fixtures;

use common\models\Color;
use yii\test\ActiveFixture;

class ColorFixture extends ActiveFixture
{
    public $modelClass = Color::class;

    public $dataFile = '@common/tests/_data/color.php';
}
