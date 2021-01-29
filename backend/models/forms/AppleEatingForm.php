<?php

namespace backend\models\forms;

use common\components\AppleException;
use common\models\apple\Apple;
use common\queries\Apple as AppleQuery;
use yii\base\Model;

/**
 * Class AppleEatingForm
 * @package backend\models\forms
 *
 * A form for eating an apple
 */
class AppleEatingForm extends Model
{
    /** @var int */
    public $appleId;

    /** @var float percentage of apple eaten */
    public $eatenPercent;

    /**
     * @inheritDoc
     * @param int $appleId
     */
    public function __construct(int $appleId, $config = [])
    {
        parent::__construct($config);
        $this->appleId = $appleId;
    }

    /**
     * @inheritDoc
     */
    public function scenarios()
    {
        $scenarios = [
            self::SCENARIO_DEFAULT => ['!appleId', 'eatenPercent'],
        ];

        return array_merge(parent::scenarios(), $scenarios);
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['appleId', 'eatenPercent'], 'required'],
            [['appleId'], 'integer'],
            [['eatenPercent'], 'number', 'min' => 0, 'max' => 100],
            [
                ['appleId'], 'exist', 'targetClass' => Apple::class, 'targetAttribute' => 'id',
                'filter' => function (AppleQuery $query) {
                    $query->present();
                },
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'appleId' => 'Apple ID',
            'eatenPercent' => 'Percentage',
        ];
    }

    /**
     * Eat a piece of apple
     * @return bool whether an apple was successfully eaten
     * @throws AppleException
     */
    public function eat()
    {
        if ($this->validate()) {
            return Apple::findOne($this->appleId)->eat($this->eatenPercent);
        }

        return false;
    }
}
