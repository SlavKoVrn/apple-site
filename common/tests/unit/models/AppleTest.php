<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\fixtures\AppleFixture;
use common\models\apple\Apple;
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
            'apple' => AppleFixture::class,
        ];
    }

    public function testNewApple()
    {
        $model = new Apple();

        $this->assertNotNull($model->color_id);
        $this->assertEquals(1, $model->status_id);
        $this->assertNotNull($model->appear_at);
        $this->assertNull($model->fall_at);
        $this->assertEquals(0, $model->eaten_percent);

        $this->tester->expect('new apple cannot be saved into DB if it fell');
        $model->fall();
        $this->tester->dontSeeRecord(Apple::class, ['id' => 12]);

        $this->tester->expect('new apple cannot be saved into DB if it was bitten');
        $model->eat(4);
        $this->tester->dontSeeRecord(Apple::class, ['id' => 12]);
    }
}
