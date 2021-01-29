<?php

namespace common\helpers;

use Exception;
use Throwable;
use Yii;

/**
 * Class AppleErrorHandler
 * @package common\helpers
 *
 * An error handler for operations with apples
 */
class AppleErrorHandler
{
    const LOG_CATEGORY = 'apple';

    /**
     * Alert about an error both server and client side
     * @param Exception|Throwable $e an error object
     * @param string|null $clientMessage an optional explicit message for client side that overrides the error details
     */
    public static function alertError($e, string $clientMessage = null)
    {
        static::logError($e);
        Yii::$app->session->addFlash('error', $clientMessage ?: $e->getMessage());
    }

    /**
     * Log an error
     * @param Exception|Throwable $e an error object
     */
    public static function logError($e)
    {
        Yii::error($e, self::LOG_CATEGORY);
    }
}
