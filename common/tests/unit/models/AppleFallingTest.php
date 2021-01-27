<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\components\AppleException;
use common\fixtures\AppleFixture;
use common\helpers\DateTimeHelper;
use common\models\apple\Apple;
use common\tests\UnitTester;
use yii\base\Exception;

class AppleFallingTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;
    
    public function _fixtures()
    {
        return [
            'apple' => AppleFixture::class,
        ];
    }

    public function testFallenApple()
    {
        $this->tester->amGoingTo('Check falling of fallen apple');
        $this->tester->expect('thrown exception');

        try {
            /** @var Apple $fallen */
            $fallen = $this->tester->grabFixture('apple', 'red fallen holistic');
            $fallen->fall();
        } catch (Exception $e) {
            $this->assertInstanceOf(AppleException::class, $e);
            return;
        }

        $this->fail('should catch an exception');
    }

    public function testRottenApple()
    {
        $this->tester->amGoingTo('Check falling of rotten apple');
        $this->tester->expect('thrown exception');

        try {
            /** @var Apple $rotten */
            $rotten = $this->tester->grabFixture('apple', 'green rotten holistic');
            $rotten->fall();
        } catch (Exception $e) {
            $this->assertInstanceOf(AppleException::class, $e);
            return;
        }

        $this->fail('should catch an exception');
    }

    public function testHangingApple()
    {
        $this->tester->amGoingTo('Check falling of hanging apple');
        $this->tester->expectTo('fall successfully');

        /** @var Apple $hanging */
        $hanging = $this->tester->grabFixture('apple', 'red hanging');

        try {
            $fell = $hanging->fall();
            $this->assertTrue($fell);
        } catch (Exception $e) {
            $this->fail('should not throw an exception');
        }

        $this->assertEquals(DateTimeHelper::nowSql(), $hanging->fall_at);
        $this->assertEquals(2, $hanging->status_id);
    }
}
