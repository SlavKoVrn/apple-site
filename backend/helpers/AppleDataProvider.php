<?php

namespace backend\helpers;

use common\models\apple\Apple;
use yii\data\ActiveDataProvider;

/**
 * Class AppleDataProvider
 * @package backend\helpers
 *
 * A data provider implementation for [[common\models\apple\Apple]].
 */
class AppleDataProvider extends ActiveDataProvider
{
    /**
     * Initialize query object
     */
    protected function initQuery()
    {
        $this->query = Apple::find()->actual();
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->initQuery();
    }
}
