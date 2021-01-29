<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class AppleAsset
 * @package backend\assets
 *
 * An asset bundle for apples
 */
class AppleAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/dist';

    public $css = [
        'css/apple.css',
    ];

    public $depends = [
        AppAsset::class,
    ];

    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
}
