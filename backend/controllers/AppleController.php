<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\{
    Controller,
    Response
};

class AppleController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['generate', 'purge'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Generate new apples
     * @param int|null $count number of apples to generate (by default random)
     * @return Response
     */
    public function actionGenerate($count = null)
    {
        return $this->redirect('/site/index');
    }

    /**
     * Purge all existing apples
     * @return Response
     */
    public function actionPurge()
    {
        return $this->redirect('/site/index');
    }
}
