<?php

use common\helpers\DateTimeHelper as DT;

date_default_timezone_set('Asia/Almaty');

return [
    // hanging apples
    'red hanging' => [
        'color_id' => 1,
        'status_id' => 1,
        'appear_at' => DT::fromNow('4 hour 35 min ago'),
        'fall_at' => null,
        'eaten_percent' => 0,
    ],
    'green hanging' => [
        'color_id' => 3,
        'status_id' => 1,
        'appear_at' => DT::fromNow('3 hours 56 min ago'),
        'fall_at' => null,
        'eaten_percent' => 0,
    ],

    // fallen apples
    'red fallen holistic' => [
        'color_id' => 1,
        'status_id' => 2,
        'appear_at' => DT::fromNow('3 hours 59 min ago'),
        'fall_at' => DT::fromNow('18 min ago'),
        'eaten_percent' => 0,
    ],
    'green fallen holistic' => [
        'color_id' => 3,
        'status_id' => 2,
        'appear_at' => DT::fromNow('9 hours 49 min ago'),
        'fall_at' => DT::fromNow('28 min ago'),
        'eaten_percent' => 0,
    ],
    'red fallen bitten' => [
        'color_id' => 1,
        'status_id' => 2,
        'appear_at' => DT::fromNow('1 hours 47 min ago'),
        'fall_at' => DT::fromNow('1 hours 37 min ago'),
        'eaten_percent' => 5,
    ],
    'yellow fallen bitten' => [
        'color_id' => 2,
        'status_id' => 2,
        'appear_at' => DT::fromNow('8 hours 23 min ago'),
        'fall_at' => DT::fromNow('2 hours 47 min ago'),
        'eaten_percent' => 10,
    ],

    // rotten apples, not handled yet (still "fallen")
    'green rotten holistic' => [
        'color_id' => 3,
        'status_id' => 2,
        'appear_at' => DT::fromNow('5 hours 4 min ago'),
        'fall_at' => DT::fromNow('5 hours 1 min ago'),
        'eaten_percent' => 0,
    ],
    'green rotten bitten' => [
        'color_id' => 3,
        'status_id' => 2,
        'appear_at' => DT::fromNow('8 hours 34 min ago'),
        'fall_at' => DT::fromNow('6 hours 24 min ago'),
        'eaten_percent' => 77,
    ],
];
