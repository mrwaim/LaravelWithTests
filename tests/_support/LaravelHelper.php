<?php

namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class LaravelHelper extends \Codeception\Module {

    public static $currentUser;

    // HOOK: before scenario
    public function  _before(\Codeception\TestCase $test)
    {
        self::$currentUser = null;
    }
    
    public function loginAs($email) {
        $I = HtmlHelper::$I;

        if (is_array($email)) {
            $email = $email['email'];
        }

        if (self::$currentUser == $email) {
            return;
        }

        if (self::$currentUser) {
            $I->logOut();
        }

        self::$currentUser = $email;

        $I->amOnPage("/");
        $I->see("Sign In");
        $I->fillField('email', $email);
        $I->fillField('password', 'raniagold');
        $I->click('Login');
        $I->seeResponseCodeIs(200);
        $I->see('Dashboard');
    }

    public function logOut() {
        $I = HtmlHelper::$I;
        $I->amOnPage("/auth/logout");
        $I->seeResponseCodeIs(200);
        $I->see("Sign in");
        $I->seeElement("input[name=email]");
        $I->seeElement("input[name=password]");
        self::$currentUser = null;
    }
}
