
<?php
date_default_timezone_set("UTC");
$I = new AcceptanceTester($scenario);
$I->wantTo("ensure that frontpage works");
$I->amOnPage("/");
$I->see("Laravel");
?>

