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
        $I->amGoingTo('generate some random apples');
        $I->click('Generate');

        $I->expectTo('see an alert with successful result');
        $I->see('apple(-s) grew on the tree', '.alert.alert-info');
        $I->see('apple(-s) will grow soon', '.alert.alert-info');

        $I->expectTo('see records in grid view');
        $I->seeElement('tr[data-key]');
    }

    public function testPurge(FunctionalTester $I)
    {
        $I->amGoingTo('remove all apples');
        $I->click('Start from scratch');

        $I->expectTo('see an alert with successful result');
        $I->see('All apples were removed', '.alert.alert-warning');

        $I->expectTo('see no records in grid view');
        $I->dontSeeElement('tr[data-key]');
    }

    public function testFall(FunctionalTester $I)
    {
        $I->expectTo('see a button to drop a hanging apple in grid view');
        $I->seeElement('tr[data-key="1"] .glyphicon-hand-down');

        $I->expectTo('see no button to drop a fallen apple in grid view');
        $I->dontSeeElement('tr[data-key="3"] .glyphicon-hand-down');

        $I->amGoingTo('drop a hanging apple');
        $I->click('[title="Fall"]', 'tr[data-key="2"]');
        $I->expectTo('see no button to drop an apple after falling in grid view');
        $I->dontSeeElement('tr[data-key="2"] .glyphicon-hand-down');
    }
}
