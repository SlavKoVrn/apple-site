<?php

namespace common\models\apple;

use common\components\{
    AppleException,
    NonPresentAppleException
};
use common\dictionaries\AppleStatus;
use common\helpers\{
    AppleEmergenceRandomizer,
    AppleErrorHandler,
    ColorRandomizer,
    DateTimeHelper
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
 *
 * @property float $size from 0 to 1
 */
class Apple extends ActiveRecord
{
    /** @var string coverage of apple emergence range (relative to the current date) */
    const EMERGENCE_RANGE = '10 hours';

    /** @var int the number of seconds from falling until the apple rots */
    const ROT_TIMEOUT_SECONDS = YII_ENV_TEST ? 2 : 5 * 60 * 60;

    /**
     * Ensure apple is present
     * @throws NonPresentAppleException
     */
    protected function ensurePresence()
    {
        if (!$this->isPresent()) {
            Yii::$app->session->addFlash('error', 'The apple has not appeared yet');
        }
    }

    /**
     * Handle apple rotting
     * @param bool $refreshDb refresh model in DB and repopulate relation from DB
     */
    protected function handleRotting(bool $refreshDb = false)
    {
        if (!$this->isFallen()) {
            return;
        }

        if ($this->fall_at > DateTimeHelper::fromNow(static::ROT_TIMEOUT_SECONDS . ' sec ago')) {
            return;
        }

        $this->status_id = AppleStatus::ROTTEN;

        if ($refreshDb) {
            $this->updateAttributes(['status_id']);
            $this->populateRelation('status', Status::findOne($this->status_id));
        }
    }

    /**
     * Initialize attribute values after creating the apple
     */
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
            [['fall_at'], 'compare', 'compareAttribute' => 'appear_at', 'operator' => '>='],
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
            'color_id' => 'Color',
            'status_id' => 'Status',
            'appear_at' => 'Appeared at',
            'fall_at' => 'Fell at',
            'eaten_percent' => 'Eaten',
        ];
    }

    /**
     * @inheritDoc
     * @throws NonPresentAppleException
     */
    public function afterFind()
    {
        // prevent fetching the apple if it is non-present (future)
        $this->ensurePresence();

        // refresh the apple if it is factually rotten but not refreshed in DB
        $this->handleRotting(true);

        parent::afterFind();
    }

    /**
     * @inheritDoc
     */
    public function beforeSave($insert)
    {
        $this->handleRotting();
        return parent::beforeSave($insert);
    }

    /**
     * @inheritDoc
     */
    public function beforeValidate()
    {
        $this->handleRotting();
        return parent::beforeValidate();
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

    public function isFallen(): bool
    {
        return (int) $this->status_id === AppleStatus::GROUND;
    }

    public function isHanging(): bool
    {
        return (int) $this->status_id === AppleStatus::TREE;
    }

    public function isRotten(): bool
    {
        return (int) $this->status_id === AppleStatus::ROTTEN;
    }

    /**
     * Detect whether the apple is present (not future)
     * @return bool
     */
    public function isPresent(): bool
    {
        return $this->appear_at <= DateTimeHelper::nowSql();
    }

    /**
     * Eat a percent of the apple
     * @param float $percent
     * @return bool whether one can eat the apple more
     * @throws AppleException if the apple is not fallen
     */
    public function eat(float $percent): bool
    {
        if (!$this->isFallen()) {
            throw new AppleException('The apple is not fallen, so it cannot be eaten');
        }

        $eatenPercent = $this->eaten_percent + $percent;

        try {
            if ($eatenPercent >= 100) {
                $errMsg = 'Failed to delete the apple after eat operation';
                $this->delete();
                return false;
            }

            $this->eaten_percent = $eatenPercent;
            $errMsg = 'Failed to save the apple after eat operation';
            $this->update();

            return true;
        } catch (\Exception $e) {
            AppleErrorHandler::alertError($e, $errMsg);
        } catch (\Throwable $e) {
            AppleErrorHandler::alertError($e, $errMsg);
        }

        return false;
    }

    /**
     * Falling of the apple
     * @return static
     * @throws AppleException if the apple is not hanging
     */
    public function fall()
    {
        if (!$this->isHanging()) {
            throw new AppleException('The apple is not hanging, so it cannot fall');
        }

        $this->fall_at = DateTimeHelper::nowSql();
        $this->status_id = AppleStatus::GROUND;

        try {
            $errMsg = 'Failed to save the apple after fall operation';
            $this->update();
        } catch (\Exception $e) {
            AppleErrorHandler::alertError($e, $errMsg);
        } catch (\Throwable $e) {
            AppleErrorHandler::alertError($e, $errMsg);
        }

        return $this;
    }

    /**
     * Get the apple size from 0 to 1
     * @return float
     */
    public function getSize(): float
    {
        return 1 - $this->eaten_percent / 100;
    }
}
