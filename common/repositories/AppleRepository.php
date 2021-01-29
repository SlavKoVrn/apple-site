<?php

namespace common\repositories;

use common\helpers\AppleErrorHandler;
use common\models\apple\Apple;
use Yii;
use yii\db\Exception;

/**
 * Class AppleRepository
 * @package common\repositories
 *
 * A repository for DB operations with apples
 */
class AppleRepository
{
    /**
     * Create new apples in DB
     * @param int $count number of apples to create (by default one apple will be created)
     * @return Apple[] an array of newly created apples
     */
    public function produce(int $count = 1)
    {
        $produced = [];
        for ($i = 0; $i < $count; $i++) {
            $apple = new Apple();
            if ($apple->save()) {
                $produced[] = $apple;
            }
        }
        return $produced;
    }

    /**
     * Purge all apples from DB
     */
    public function purge()
    {
        try {
            Yii::$app->db
                ->createCommand()
                ->truncateTable(Apple::tableName())
                ->execute();
        } catch (Exception $e) {
            AppleErrorHandler::alertError($e, 'Failed to purge apples');
        }
    }
}
