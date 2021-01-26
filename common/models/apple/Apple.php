<?php

namespace common\models\apple;

use common\dictionaries\AppleStatus;
use common\helpers\{
    AppleEmergenceRandomizer,
    ColorRandomizer
};
use common\models\Color;
use common\queries\Apple as AppleQuery;
use yii\db\{
    ActiveQuery,
    ActiveRecord
};

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property int $color_id ID цвета
 * @property int $status_id ID состояния
 * @property string $appear_at Дата появления
 * @property string|null $fall_at Дата падения
 * @property float $eaten_percent Процент съеденного
 *
 * @property Color $color
 * @property Status $status
 */
class Apple extends ActiveRecord
{
    /** @var string coverage of apple emergence range (relative to the current date) */
    const EMERGENCE_RANGE = '10 hours';

    protected function initAttributeValues()
    {
        $this->color_id = (new ColorRandomizer())->nextRandom();
        $this->status_id = AppleStatus::TREE;
        $this->appear_at = (new AppleEmergenceRandomizer(self::EMERGENCE_RANGE . ' ago', self::EMERGENCE_RANGE))
            ->nextRandom();
        $this->eaten_percent = 0;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple';
    }

    /**
     * @inheritDoc
     */
    public function scenarios()
    {
        $scenarios = [
            // should NOT be massively assigned
            self::SCENARIO_DEFAULT => ['!color_id', '!status_id', '!appear_at', '!fall_at', '!eaten_percent'],
        ];

        return array_merge(parent::scenarios(), $scenarios);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color_id', 'status_id', 'appear_at'], 'required'],
            [['color_id', 'status_id'], 'integer'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetRelation' => 'color'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetRelation' => 'status'],
            [['fall_at'], 'default', 'value' => null],
            [['eaten_percent'], 'number', 'min' => 0, 'max' => 100],
            [['eaten_percent'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color_id' => 'ID цвета',
            'status_id' => 'ID состояния',
            'appear_at' => 'Дата появления',
            'fall_at' => 'Дата падения',
            'eaten_percent' => 'Процент съеденного',
        ];
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->initAttributeValues();
    }

    /**
     * Gets query for [[Color]].
     *
     * @return ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Color::class, ['id' => 'color_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * {@inheritdoc}
     * @return AppleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppleQuery(get_called_class());
    }
}
