<?php

namespace common\tests\unit\helpers;

use Codeception\Test\Unit;
use common\fixtures\ColorFixture;
use common\helpers\{
    ColorRandomizer,
    IRandomizer
};
use common\tests\UnitTester;

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
            if ($initValue !== $randomizer->nextRandom()) {
                return;
            }
        }
        $this->fail("values are not random after {$maxAttempts} attempts");
    }

    public function testColor()
    {
        $this->testValuesForRandomness(new ColorRandomizer(), 4);
    }
}
