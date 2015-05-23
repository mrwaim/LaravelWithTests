<?php

namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class HtmlHelper extends \Codeception\Module {

    static $I;

    public function saveI($I) {
        self::$I = $I;
    }

    
    public function clickLinkInRow($elemText) {
        $I = HtmlHelper::$I;
        $text = $I->grabTextFrom("//tr[td[.=\"$elemText\"]]/td/a");
        $I->click($text);
    }
}
