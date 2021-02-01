<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\dictionaries\AppleStatus;
use common\models\apple\Apple;
use yii\bootstrap\{
    Html,
    Progress
};
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
            'content' => function (Apple $model, $key, $index, $column) {
                return Progress::widget([
                    'percent' => $model->size * 100,
                    'barOptions' => [
                        'class' => [
                            'progress-bar-info',
                            'progress-bar-striped',
                        ],
                    ],
                    'label' => Yii::$app->formatter->asPercent($model->size),
                ]);
            },
            'contentOptions' => function (Apple $model, $key, $index, $column) {
                return [
                    'style' => 'min-width: 16rem;',
                    'title' => Yii::$app->formatter->asPercent($model->size) . ' left',
                ];
            },
        ],

        [
            'class' => ActionColumn::class,
            'buttons' => [
                'fall' => function ($url, Apple $model, $key) {
                    return !$model->isHanging()
                        ? null
                        : Html::a(
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
                return !$model->isFallen()
                    ? null
                    : $this->render('_eat-form', [
                        'apple' => $model,
                    ]);
            },
        ],
    ],
]);
