<?php

namespace common\tests\unit;

use backend\helpers\AppleDataProvider;
use Codeception\Test\Unit;
use common\fixtures\AppleFixture;
use common\tests\UnitTester;

class AppleTest extends Unit
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

    public function testFetchActualApples()
    {
        $this->tester->amGoingTo('check count of actual apples');

        $dataProvider = new AppleDataProvider();
        $actualApples = $dataProvider->getModels();

        $this->assertCount(8, $actualApples);
    }
}
