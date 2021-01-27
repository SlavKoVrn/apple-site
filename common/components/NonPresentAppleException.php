<?php

namespace common\components;

/**
 * Class NonPresentAppleException
 * @package common\components
 *
 * An exception for operations with non-present apples (which date of appearance is future)
 */
class NonPresentAppleException extends AppleException
{
    protected $message = 'The apple has not appeared yet';
}
