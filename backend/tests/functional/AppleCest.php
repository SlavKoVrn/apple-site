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
        $I->dontSeeElement('tr[data-key="6"] .glyphicon-hand-down');

        $I->amGoingTo('drop a hanging apple');
        $I->click('[title="Fall"]', 'tr[data-key="2"]');
        $I->expectTo('see no button to drop an apple after falling in grid view');
        $I->dontSeeElement('tr[data-key="2"] .glyphicon-hand-down');
    }

    public function testCanEat(FunctionalTester $I)
    {
        $I->expectTo('see no form to eat a hanging apple in grid view');
        $I->dontSee('Eat', 'tr[data-key="2"] form .btn');

        $I->expectTo('see no form to eat a rotten apple in grid view');
        $I->dontSee('Eat', 'tr[data-key="8"] form .btn');

        $I->expectTo('see a form to eat a fallen apple in grid view');
        $I->see('Eat', 'tr[data-key="6"] form .btn');
    }

    public function testEat(FunctionalTester $I)
    {
        $I->amGoingTo('eat a fallen apple');
        $I->fillField('tr[data-key="6"] [name="AppleEatingForm[eatenPercent]"]', 32);
        $I->click('Eat', 'tr[data-key="6"]');
        $I->expectTo('see an alert with successful result');
        $I->see('31% left', '.alert.alert-success');

        $I->expectTo('see a form to eat a fallen apple in grid view');
        $I->see('Eat', 'tr[data-key="6"] form .btn');
    }

    public function testEatUp(FunctionalTester $I)
    {
        $I->amGoingTo('eat up a fallen apple');
        $I->fillField('tr[data-key="6"] [name="AppleEatingForm[eatenPercent]"]', 64);
        $I->click('Eat', 'tr[data-key="6"]');
        $I->expectTo('see an alert with successful result');
        $I->see('The apple was eaten whole', '.alert.alert-success');

        $I->expectTo('see no form to eat a fallen apple in grid view');
        $I->dontSee('Eat', 'tr[data-key="6"] form .btn');
    }
}
