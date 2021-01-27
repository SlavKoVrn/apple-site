<?php

namespace common\queries;

use common\models\apple\Apple as AppleModel;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[common\models\apple\Apple]].
 *
 * @see AppleModel
 */
class Apple extends ActiveQuery
{
    /**
     * Consider existing apples only with a non-future date of appearance
     * @return static
     */
    public function present()
    {
        return $this->andWhere('appear_at <= NOW()');
    }

    /**
     * {@inheritdoc}
     * @return AppleModel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AppleModel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
