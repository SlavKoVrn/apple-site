<?php

namespace common\models\apple;

use Yii;
use yii\db\{
    ActiveQuery,
    ActiveRecord
};

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $name Наименование
 *
 * @property Apple[] $apples
 */
class Status extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'trim'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 63],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
        ];
    }

    /**
     * Gets query for [[Apples]].
     *
     * @return ActiveQuery
     */
    public function getApples()
    {
        return $this->hasMany(Apple::class, ['status_id' => 'id']);
    }
}
