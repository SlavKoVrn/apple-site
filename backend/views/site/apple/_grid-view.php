<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\models\apple\Apple;
use yii\bootstrap\Html;
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
        [
            'attribute' => 'color_id',
            'value' => 'color.name',
            'contentOptions' => function (Apple $model, $key, $index, $column) {
                return [
                    'class' => [
                        'apple',
                        "apple-{$model->color->code_name}",
                    ],
                ];
            },
        ],
        [
            'attribute' => 'status_id',
            'value' => 'status.name',
        ],
        'appear_at',
        'fall_at',
        'eaten_percent',

        [
            'class' => ActionColumn::class,
            'buttons' => [
                'fall' => function ($url, $model, $key) {
                    return Html::a(
                        Html::icon('hand-down'),
                        ['apple/fall', 'id' => $model->id],
                        ['title' => 'Fall']
                    );
                },
            ],
            'header' => 'Fall',
            'template' => '{fall}',
        ],
    ],
]);
