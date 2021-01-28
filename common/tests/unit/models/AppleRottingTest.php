<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\fixtures\AppleFixture;
use common\helpers\DateTimeHelper;
use common\models\apple\Apple;
use common\tests\UnitTester;

class AppleRottingTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    public function _fixtures()
    {
        return [
            'apple' => [
                'class' => AppleFixture::class,
                'dataFile' => '@common/tests/_data/apple-rotting.php',
            ],
        ];
    }

    public function testNewApple()
    {
        $this->tester->amGoingTo('check that a newly created apple rots');

        $apple = new Apple();
        $apple->appear_at = DateTimeHelper::nowSql();
        $this->assertEquals(1, $apple->status_id);

        $this->tester->amGoingTo('wait for rotting of a hanging apple');
        sleep(1);
        $this->tester->expectTo('the apple is not rotten');
        $apple->validate();
        $this->assertNotEquals(3, $apple->status_id);

        $this->tester->amGoingTo('drop apple');
        $apple->fall();
        $this->assertEquals(2, $apple->status_id);

        $this->tester->expectTo('the apple is not rotten');
        $apple->validate();
        $this->assertNotEquals(3, $apple->status_id);

        $this->tester->amGoingTo('wait for rotting of a fallen apple');
        sleep(1);
        $this->tester->expectTo('the apple is rotten');
        $apple->validate();
        $this->assertEquals(3, $apple->status_id);
    }

    public function testPresentApples()
    {
        $this->tester->amGoingTo('check that present apples rot');

        $this->tester->expectTo('there is no rotten apples in DB');
        $this->tester->dontSeeRecord(Apple::class, ['status_id' => 3]);

        $this->tester->amGoingTo('fetch factually rotten apples from DB');
        /** @var Apple $rottenApple1 */
        $rottenApple1 = $this->tester->grabFixture('apple', 'green rotten holistic');
        /** @var Apple $rottenApple2 */
        $rottenApple2 = $this->tester->grabFixture('apple', 'green rotten bitten');
        $this->tester->expectTo('these apples are rotten');
        $this->assertEquals(3, $rottenApple1->status_id);
        $this->assertEquals(3, $rottenApple2->status_id);

        $this->tester->amGoingTo('store these apples into DB');
        $rottenApple1->save();
        $rottenApple2->save();
        $this->tester->expectTo('there are two rotten apples in DB');
        $this->tester->seeRecord(Apple::class, ['status_id' => 3, 'id' => $rottenApple1->id]);
        $this->tester->seeRecord(Apple::class, ['status_id' => 3, 'id' => $rottenApple2->id]);
    }
}
