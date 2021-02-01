<?php

namespace backend\tests\unit;

use backend\models\forms\AppleEatingForm;
use backend\tests\UnitTester;
use Codeception\Test\Unit;
use common\components\AppleException;
use common\fixtures\AppleFixture;
use yii\base\Exception;

class AppleEatingFormTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    public function _fixtures()
    {
        return [
            AppleFixture::class,
        ];
    }

    public function testEatingNonFallenApple()
    {
        $attributes = ['eatenPercent' => 22];

        $hanging = new AppleEatingForm(1, $attributes);
        try {
            $hanging->eat();
            $this->fail('cannot eat a hanging apple');
        } catch (Exception $e) {
            $this->assertInstanceOf(AppleException::class, $e);
        }

        $rotten = new AppleEatingForm(9, $attributes);
        try {
            $rotten->eat();
            $this->fail('cannot eat a rotten apple');
        } catch (Exception $e) {
            $this->assertInstanceOf(AppleException::class, $e);
        }

        $future = new AppleEatingForm(11, $attributes);
        try {
            $eaten = $future->eat();
            $this->assertFalse($eaten);
            $this->assertTrue($future->hasErrors('appleId'));
        } catch (Exception $e) {
            $this->fail('would not pass validation rather than fail');
        }
    }

    public function testEatingFallenApple()
    {
        $apple = new AppleEatingForm(6, ['eatenPercent' => 22]);

        try {
            $eaten = $apple->eat();
            $this->assertTrue($eaten);
            $this->assertFalse($apple->hasErrors());
            $this->assertEquals(59, $apple->apple->eaten_percent);

            $eaten = $apple->eat();
            $this->assertTrue($eaten);
            $this->assertFalse($apple->hasErrors());
            $this->assertEquals(81, $apple->apple->eaten_percent);

            $eaten = $apple->eat();
            $this->assertFalse($eaten);
            $this->assertFalse($apple->hasErrors());
            $this->assertNull($apple->apple);
        } catch (AppleException $e) {
            $this->fail('would not throw an exception');
        }
    }
}
