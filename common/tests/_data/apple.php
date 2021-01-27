<?php

date_default_timezone_set('Asia/Almaty');

/**
 * Get DateTime value from the current date modified by the given parameter
 * @param $modify
 * @see DateTime::modify
 * @return string
 */
function getDateTime($modify)
{
    return (new DateTime())
        ->modify($modify)
        ->format('Y-m-d H:i:s');
}

return [
    // hanging apples
    'red hanging' => [
        'color_id' => 1,
        'status_id' => 1,
        'appear_at' => getDateTime('4 hour 35 min ago'),
        'fall_at' => null,
        'eaten_percent' => 0,
    ],
    'green hanging' => [
        'color_id' => 3,
        'status_id' => 1,
        'appear_at' => getDateTime('3 hours 56 min ago'),
        'fall_at' => null,
        'eaten_percent' => 0,
    ],

    // fallen apples
    'red fallen holistic' => [
        'color_id' => 1,
        'status_id' => 2,
        'appear_at' => getDateTime('3 hours 59 min ago'),
        'fall_at' => getDateTime('18 min ago'),
        'eaten_percent' => 0,
    ],
    'green fallen holistic' => [
        'color_id' => 3,
        'status_id' => 2,
        'appear_at' => getDateTime('9 hours 49 min ago'),
        'fall_at' => getDateTime('28 min ago'),
        'eaten_percent' => 0,
    ],
    'red fallen bitten' => [
        'color_id' => 1,
        'status_id' => 2,
        'appear_at' => getDateTime('1 hours 47 min ago'),
        'fall_at' => getDateTime('1 hours 37 min ago'),
        'eaten_percent' => 5,
    ],
    'yellow fallen bitten' => [
        'color_id' => 2,
        'status_id' => 2,
        'appear_at' => getDateTime('8 hours 23 min ago'),
        'fall_at' => getDateTime('2 hours 47 min ago'),
        'eaten_percent' => 10,
    ],

    // rotten apples
    'green rotten holistic' => [
        'color_id' => 3,
        'status_id' => 3,
        'appear_at' => getDateTime('5 hours 4 min ago'),
        'fall_at' => getDateTime('5 hours 1 min ago'),
        'eaten_percent' => 0,
    ],
    'green rotten bitten' => [
        'color_id' => 3,
        'status_id' => 3,
        'appear_at' => getDateTime('8 hours 34 min ago'),
        'fall_at' => getDateTime('6 hours 24 min ago'),
        'eaten_percent' => 77,
    ],

    // future apples
    'green future' => [
        'color_id' => 3,
        'status_id' => 1,
        'appear_at' => getDateTime('+6 hours 47 min'),
        'fall_at' => null,
        'eaten_percent' => 0,
    ],
    'yellow future' => [
        'color_id' => 2,
        'status_id' => 1,
        'appear_at' => getDateTime('+5 hours 26 min'),
        'fall_at' => null,
        'eaten_percent' => 0,
    ],
];
