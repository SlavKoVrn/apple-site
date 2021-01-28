<?php

namespace common\helpers;

use DateTime;

class DateTimeHelper
{
    const FORMAT_SQL = 'Y-m-d H:i:s';

    public static function nowSql(): string
    {
        return date(static::FORMAT_SQL);
    }

    /**
     * Get DateTime value from the current date modified by the given parameter
     * @param string $modify
     * @see DateTime::modify
     * @return string
     */
    public static function fromNow(string $modify): string
    {
        return (new DateTime())
            ->modify($modify)
            ->format(static::FORMAT_SQL);
    }
}
