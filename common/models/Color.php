<?php

namespace common\models;

use common\models\apple\Apple;
use Yii;
use yii\db\{
    ActiveQuery,
    ActiveRecord
};

/**
 * This is the model class for table "color".
 *
 * @property int $id
 * @property string $name Наименование
 * @property string $code_name Кодовое название
 * @property string $value Значение
 *
 * @property Apple[] $apples
 */
class Color extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'color';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code_name', 'value'], 'trim'],
            [['name', 'code_name', 'value'], 'required'],
            [['name'], 'string', 'max' => 63],
            [['code_name', 'value'], 'string', 'max' => 31],
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
            'code_name' => 'Кодовое название',
            'value' => 'Значение',
        ];
    }

    /**
     * Gets query for [[Apples]].
     *
     * @return ActiveQuery
     */
    public function getApples()
    {
        return $this->hasMany(Apple::class, ['color_id' => 'id']);
    }
}
