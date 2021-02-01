<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\AppleFixture;

class AppleCest
{
    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'apple' => AppleFixture::class,
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $I->login();
        $I->amOnRoute('/site/index');
        $I->dontSeeElement('.alert');
        $I->seeElement('tr[data-key]');
    }

    public function testGenerate(FunctionalTester $I)
    {
        $I->click('Generate');
        $I->see('apple(-s) grew on the tree', '.alert.alert-info');
        $I->see('apple(-s) will grow soon', '.alert.alert-info');
        $I->seeElement('tr[data-key]');
    }

    public function testPurge(FunctionalTester $I)
    {
        $I->click('Start from scratch');
        $I->see('All apples were removed', '.alert.alert-warning');
        $I->dontSeeElement('tr[data-key]');
    }
}
