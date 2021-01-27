<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\components\NonPresentAppleException;
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

    public function testPresentApples()
    {
        $this->tester->amGoingTo('Check obtaining of present apples');
        $this->tester->expectTo('obtain successfully');

        /** @var Apple $hanging */
        $hanging = $this->tester->grabFixture('apple', 'green hanging');
        $this->assertEquals(1, $hanging->status_id);

        /** @var Apple $rotten */
        $rotten = $this->tester->grabFixture('apple', 'green rotten bitten');
        $this->assertEquals(3, $rotten->status_id);

        /** @var Apple $fallen */
        $fallen = $this->tester->grabFixture('apple', 'red fallen bitten');
        $this->assertEquals(2, $fallen->status_id);
    }

    public function testFutureApple()
    {
        $this->tester->amGoingTo('Check obtaining of future apple');
        $this->tester->expect('thrown exception');

        try {
            $this->tester->grabFixture('apple', 'yellow future');
        } catch (Exception $e) {
            $this->assertInstanceOf(NonPresentAppleException::class, $e);
            return;
        }

        $this->fail('should catch an exception');
    }
}
