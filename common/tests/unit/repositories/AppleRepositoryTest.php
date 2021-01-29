<?php

namespace common\tests\unit\repositories;

use Codeception\Test\Unit;
use common\components\AppleException;
use common\fixtures\AppleFixture;
use common\models\apple\Apple;
use common\repositories\AppleRepository;
use common\tests\UnitTester;
use Exception;

class AppleRepositoryTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /** @var AppleRepository */
    protected $repo;

    public function _fixtures()
    {
        return [
            'apple' => AppleFixture::class,
        ];
    }

    public function _before()
    {
        $this->repo = new AppleRepository();
    }

    public function testGenerate()
    {
        $this->tester->dontSeeRecord(Apple::class, ['id' => 12]);

        $this->tester->amGoingTo('generate 1 new apple');
        $generated = $this->repo->produce();
        $this->assertCount(1, $generated);

        $this->tester->expect('1 new record in DB');
        try {
            $this->tester->seeRecord(Apple::class, ['id' => 12]);
        } catch (Exception $e) {
            $this->tester->expect('new apple may appear in future');
            $this->assertInstanceOf(AppleException::class, $e);
        }
        $this->tester->dontSeeRecord(Apple::class, ['id' => 13]);

        $this->tester->amGoingTo('generate 4 new apples');
        $generated = $this->repo->produce(4);
        $this->assertCount(4, $generated);

        $this->tester->expect('4 new records in DB');
        try {
            $this->tester->seeRecord(Apple::class, ['id' => range(13, 16)]);
        } catch (Exception $e) {
            $this->tester->expect('new apples may appear in future');
            $this->assertInstanceOf(AppleException::class, $e);
        }
        $this->tester->dontSeeRecord(Apple::class, ['id' => 17]);
    }

    public function testPurge()
    {
        $this->tester->seeRecord(Apple::class);
        $this->repo->purge();
        $this->tester->dontSeeRecord(Apple::class);
    }
}
