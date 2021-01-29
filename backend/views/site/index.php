<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use backend\assets\AppleAsset;
use yii\helpers\Html;

AppleAsset::register($this);

$generateButtonCaption = count($dataProvider->getModels()) > 0 ? 'Generate more apples' : 'Generate apples';
?>
<div class="site-index">

    <div class="apple-generation">
        <?= Html::a($generateButtonCaption, ['apple/generate'], [
            'class' => [
                'btn',
                'btn-info',
                'pull-left',
            ],
        ]) ?>

        <?= Html::a('Start from scratch', ['apple/purge'], [
            'class' => [
                'btn',
                'btn-warning',
                'pull-right',
            ],
        ]) ?>

        <div class="clearfix"></div>
    </div>

    <div class="apple-grid-view">
        <?= $this->render('apple/_grid-view', [
            'dataProvider' => $dataProvider,
        ]) ?>
    </div>

</div>
