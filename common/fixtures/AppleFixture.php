<?php

namespace common\fixtures;

use common\models\apple\Apple;
use yii\test\ActiveFixture;

class AppleFixture extends ActiveFixture
{
    public $modelClass = Apple::class;

    public $dataFile = '@common/tests/_data/apple.php';

    public $depends = [
        ColorFixture::class,
        AppleStatusFixture::class,
    ];
}
