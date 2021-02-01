<?php

namespace backend\tests;

use common\fixtures\UserFixture;
use Yii;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;
   /**
    * Define custom actions here
    */

    public function login()
    {
        if (!Yii::$app->user->isGuest) {
            return;
        }

        $this->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'admin.php'
            ],
        ]);

        $this->amGoingTo('log in');
        $this->amOnRoute('/site/login');

        $this->dontSee('Logout (admin)');

        $this->submitForm('#login-form', [
            'LoginForm' => [
                'username' => 'admin',
                'password' => 'Qwer1234',
            ],
        ]);

        $this->see('Logout (admin)');
        $this->dontSeeElement('#login-form');
    }
}
