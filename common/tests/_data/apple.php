<?php

date_default_timezone_set('Asia/Almaty');

return [
    // hanging apples
    'red hanging' => [
        'color_id' => 1,
        'status_id' => 1,
        'appear_at' => (new DateTime())->modify('4 hour 35 min ago')->format('Y-m-d H:i:s'),
        'fall_at' => null,
        'eaten_percent' => 0,
    ],
    'green hanging' => [
        'color_id' => 3,
        'status_id' => 1,
        'appear_at' => (new DateTime())->modify('3 hours 56 min ago')->format('Y-m-d H:i:s'),
        'fall_at' => null,
        'eaten_percent' => 0,
    ],

    // fallen apples
    'red fallen holistic' => [
        'color_id' => 1,
        'status_id' => 2,
        'appear_at' => (new DateTime())->modify('3 hours 59 min ago')->format('Y-m-d H:i:s'),
        'fall_at' => (new DateTime())->modify('18 min ago')->format('Y-m-d H:i:s'),
        'eaten_percent' => 0,
    ],
    'green fallen holistic' => [
        'color_id' => 3,
        'status_id' => 2,
        'appear_at' => (new DateTime())->modify('9 hours 49 min ago')->format('Y-m-d H:i:s'),
        'fall_at' => (new DateTime())->modify('28 min ago')->format('Y-m-d H:i:s'),
        'eaten_percent' => 0,
    ],
    'red fallen bitten' => [
        'color_id' => 1,
        'status_id' => 2,
        'appear_at' => (new DateTime())->modify('1 hours 47 min ago')->format('Y-m-d H:i:s'),
        'fall_at' => (new DateTime())->modify('1 hours 37 min ago')->format('Y-m-d H:i:s'),
        'eaten_percent' => 5,
    ],
    'yellow fallen bitten' => [
        'color_id' => 2,
        'status_id' => 2,
        'appear_at' => (new DateTime())->modify('8 hours 23 min ago')->format('Y-m-d H:i:s'),
        'fall_at' => (new DateTime())->modify('2 hours 47 min ago')->format('Y-m-d H:i:s'),
        'eaten_percent' => 10,
    ],

    // rotten apples
    'green rotten holistic' => [
        'color_id' => 3,
        'status_id' => 3,
        'appear_at' => (new DateTime())->modify('5 hours 4 min ago')->format('Y-m-d H:i:s'),
        'fall_at' => (new DateTime())->modify('5 hours 1 min ago')->format('Y-m-d H:i:s'),
        'eaten_percent' => 0,
    ],
    'green rotten bitten' => [
        'color_id' => 3,
        'status_id' => 3,
        'appear_at' => (new DateTime())->modify('8 hours 34 min ago')->format('Y-m-d H:i:s'),
        'fall_at' => (new DateTime())->modify('6 hours 24 min ago')->format('Y-m-d H:i:s'),
        'eaten_percent' => 77,
    ],

    // future apples
    'green future' => [
        'color_id' => 3,
        'status_id' => 1,
        'appear_at' => (new DateTime())->modify('+6 hours 47 min')->format('Y-m-d H:i:s'),
        'fall_at' => null,
        'eaten_percent' => 0,
    ],
    'yellow future' => [
        'color_id' => 2,
        'status_id' => 1,
        'appear_at' => (new DateTime())->modify('+5 hours 26 min')->format('Y-m-d H:i:s'),
        'fall_at' => null,
        'eaten_percent' => 0,
    ],
];
