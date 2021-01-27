<?php

namespace common\tests\unit\helpers;

use Codeception\Test\Unit;
use common\fixtures\ColorFixture;
use common\helpers\{
    AppleEmergenceRandomizer,
    ColorRandomizer,
    DateTimeHelper,
    IRandomizer
};
use common\tests\UnitTester;
use DateTime;

class RandomizerTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    public function _fixtures()
    {
        return [
            ColorFixture::class,
        ];
    }

    private function testValuesForRandomness(IRandomizer $randomizer, int $maxAttempts = 1)
    {
        $totalAttempts = $maxAttempts;
        $initValue = $randomizer->nextRandom();

        while ($totalAttempts--) {
            $newValue = $randomizer->nextRandom();
            if ($initValue !== $newValue) {
                return;
            }
        }
        $this->fail("values are not random after {$maxAttempts} attempts: {$initValue}, {$newValue}");
    }

    public function testColorRandomness()
    {
        $this->testValuesForRandomness(new ColorRandomizer(), 8);
    }

    public function testAppleEmergenceCorrectness()
    {
        $testRanges = [
            ['1 sec ago', '1 sec'],
            ['1 min ago', '1 min'],
            ['1 hour ago', '1 hour'],
            ['1 day ago', '1 day'],
        ];

        foreach ($testRanges as $range) {
            $minDt = (new DateTime())->modify($range[0])->format(DateTimeHelper::FORMAT_SQL);
            $maxDt = (new DateTime())->modify($range[1])->format(DateTimeHelper::FORMAT_SQL);
            $randomDt = (new AppleEmergenceRandomizer($range[0], $range[1]))->nextRandom();

            $this->assertGreaterThanOrEqual($minDt, $randomDt);
            $this->assertLessThanOrEqual($maxDt, $randomDt);
        }
    }

    public function testAppleEmergenceRandomness()
    {
        $testRanges = [
            ['1 sec ago', '1 sec'],
            ['1 min ago', '1 min'],
            ['1 hour ago', '1 hour'],
            ['1 day ago', '1 day'],
        ];

        foreach ($testRanges as $index => $range) {
            $randomizer = new AppleEmergenceRandomizer($range[0], $range[1]);
            $attempts = $index > 0 ? 1 : 8;
            $this->testValuesForRandomness($randomizer, $attempts);
        }
    }
}
