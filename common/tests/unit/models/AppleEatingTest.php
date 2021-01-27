<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\components\AppleException;
use common\fixtures\AppleFixture;
use common\models\apple\Apple;
use common\tests\UnitTester;
use yii\base\Exception;

class AppleEatingTest extends Unit
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

    public function testHangingApple()
    {
        $this->tester->amGoingTo('Check eating of hanging apple');
        $this->tester->expect('thrown exception');

        /** @var Apple $hanging */
        $hanging = $this->tester->grabFixture('apple', 'green hanging');
        $this->assertEquals(1, $hanging->status_id);

        try {
            $hanging->eat(50);
        } catch (Exception $e) {
            $this->assertInstanceOf(AppleException::class, $e);
            return;
        }

        $this->fail('should catch an exception');
    }

    public function testRottenApple()
    {
        $this->tester->amGoingTo('Check eating of rotten apple');
        $this->tester->expect('thrown exception');

        /** @var Apple $rotten */
        $rotten = $this->tester->grabFixture('apple', 'green rotten bitten');
        $this->assertEquals(3, $rotten->status_id);

        try {
            $rotten->eat(50);
        } catch (Exception $e) {
            $this->assertInstanceOf(AppleException::class, $e);
            return;
        }

        $this->fail('should catch an exception');
    }

    public function testFallenApple()
    {
        $this->tester->amGoingTo('Check eating of fallen apple');
        $this->tester->expectTo('eat successfully');

        /** @var Apple $fallen */
        $fallen = $this->tester->grabFixture('apple', 'green fallen holistic');
        $this->assertEquals(2, $fallen->status_id);

        try {
            $fallen->eat(50);
        } catch (Exception $e) {
            $this->fail('should not throw an exception');
        }
    }

    public function testEatenPercent()
    {
        /** @var Apple $apple */
        $apple = $this->tester->grabFixture('apple', 'yellow fallen bitten');
        $this->assertEquals(10, $apple->eaten_percent);

        try {
            $canEatMore = $apple->eat(20);
            $this->assertTrue($canEatMore);
            $this->assertEquals(30, $apple->eaten_percent);
            $this->tester->seeRecord(Apple::class, $apple->attributes);

            $canEatMore = $apple->eat(40);
            $this->assertTrue($canEatMore);
            $this->assertEquals(70, $apple->eaten_percent);
            $this->tester->seeRecord(Apple::class, $apple->attributes);

            $this->tester->expectTo('eat up the apple and remove it entirely');
            $canEatMore = $apple->eat(60);
            $this->assertFalse($canEatMore);
            $this->tester->dontSeeRecord(Apple::class, $apple->attributes);
        } catch (Exception $e) {
            $this->fail('should not throw an exception');
        }
    }
}
