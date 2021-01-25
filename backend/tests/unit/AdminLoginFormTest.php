<?php

namespace backend\tests\unit;

use backend\tests\UnitTester;
use Codeception\Test\Unit;
use common\fixtures\UserFixture;
use common\models\LoginForm;
use Yii;

class AdminLoginFormTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'admin.php'
            ]
        ];
    }

    public function testEmptyForm()
    {
        $form = new LoginForm();
        $this->assertFalse($form->login(), 'an empty form should fail to login');
        $this->assertTrue(Yii::$app->user->isGuest, 'system user should remain guest');
    }

    public function testNonAdmin()
    {
        $form = new LoginForm([
            'username' => 'user',
            'password' => 'pass',
        ]);
        $this->assertFalse($form->login(), 'a non-admin should fail to login');
        $this->assertTrue(Yii::$app->user->isGuest, 'system user should remain guest');
    }

    public function testAdminWrongPassword()
    {
        $form = new LoginForm([
            'username' => 'admin',
            'password' => 'qwer1234',
        ]);
        $this->assertFalse($form->login(), 'an admin with wrong password should fail to login');
        $this->assertTrue(Yii::$app->user->isGuest, 'system user should remain guest');
    }

    public function testAdminCorrectPassword()
    {
        $form = new LoginForm([
            'username' => 'admin',
            'password' => 'Qwer1234',
        ]);
        $this->assertTrue($form->login(), 'an admin with correct password should succeed to login');
        $this->assertFalse(Yii::$app->user->isGuest, 'system user should be authenticated');
        $this->assertEquals('admin', Yii::$app->user->identity['username'], 'authenticated user should be admin');
    }
}
