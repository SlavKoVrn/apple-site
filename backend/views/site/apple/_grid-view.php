<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\{
    ActionColumn,
    GridView,
    SerialColumn
};

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => SerialColumn::class],

        'id',
        'color_id',
        'status_id',
        'appear_at',
        'fall_at',
        'eaten_percent',

        ['class' => ActionColumn::class],
    ],
]);
