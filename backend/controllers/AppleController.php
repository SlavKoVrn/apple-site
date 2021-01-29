<?php

namespace backend\controllers;

use common\components\AppleException;
use common\models\apple\Apple;
use common\repositories\AppleRepository;
use common\services\AppleProducer;
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
                        'actions' => ['generate', 'fall', 'purge'],
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
        $producer = !is_null($count)
            ? new AppleProducer($count, $count)
            : new AppleProducer();
        $producer->produce();

        $infoMsg = count($producer->presentApples()) . ' apple(-s) grew on the tree and '
            . count($producer->nonPresentApples()) . ' apple(-s) will grow soon';
        Yii::$app->session->addFlash('info', $infoMsg);

        return $this->redirect('/site/index');
    }

    /**
     * Make an apple fall
     * @param int $id apple ID
     * @return Response
     */
    public function actionFall($id)
    {
        try {
            Apple::findOne($id)->fall();
        } catch (AppleException $e) {
            Yii::$app->session->addFlash('error', $e->getMessage());
        }

        return $this->redirect('/site/index');
    }

    /**
     * Purge all existing apples
     * @return Response
     */
    public function actionPurge()
    {
        (new AppleRepository())->purge();
        Yii::$app->session->addFlash('warning', 'All apples were removed');

        return $this->redirect('/site/index');
    }
}
