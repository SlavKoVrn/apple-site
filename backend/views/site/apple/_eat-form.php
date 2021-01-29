<?php

/* @var $this yii\web\View */
/* @var $apple common\models\apple\Apple */
/* @var $model backend\models\forms\AppleEatingForm */
/* @var $form ActiveForm */

use backend\models\forms\AppleEatingForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$model = new AppleEatingForm($apple->id);
?>

<?php $form = ActiveForm::begin([
    'action' => ['apple/eat', 'id' => $apple->id],
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>

<?= $form->field($model, 'eatenPercent', [
    'options' => [
        'class' => [
            'pull-left',
        ],
    ],
])->input('number', [
    'min' => 0,
    'max' => 100,
]) ?>

<?= Html::submitButton('Eat', [
    'class' => [
        'btn',
        'btn-success',
        'pull-right',
    ],
]) ?>

<div class="clearfix"></div>

<?php ActiveForm::end(); ?>
