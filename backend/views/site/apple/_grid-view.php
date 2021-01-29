<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\dictionaries\AppleStatus;
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
            'contentOptions' => function (Apple $model, $key, $index, $column) {
                switch ($model->status_id) {
                    case AppleStatus::TREE:
                        $alignment = 'left';
                        break;
                    case AppleStatus::GROUND:
                        $alignment = 'center';
                        break;
                    case AppleStatus::ROTTEN:
                        $alignment = 'right';
                        break;
                    default:
                        $alignment = 'justify';
                }
                return ['style' => "text-align: {$alignment}"];
            },
        ],
        'appear_at',
        'fall_at',
        [
            'attribute' => 'eaten_percent',
            'label' => 'Size',
            'value' => 'size',
        ],

        [
            'class' => ActionColumn::class,
            'buttons' => [
                'fall' => function ($url, Apple $model, $key) {
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
        [
            'label' => 'Eat',
            'content' => function (Apple $model, $key, $index, $column) {
                return $this->render('_eat-form', [
                    'apple' => $model,
                ]);
            },
        ],
    ],
]);
