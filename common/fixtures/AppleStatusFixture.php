<?php

namespace common\fixtures;

use common\models\apple\Status;
use yii\test\ActiveFixture;

class AppleStatusFixture extends ActiveFixture
{
    public $modelClass = Status::class;

    public $dataFile = '@common/tests/_data/status.php';
}
