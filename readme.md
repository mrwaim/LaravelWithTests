Below is my installation of laravel, that includes the ide helper, codeception, and a simple script to syntax check php

As I pick up new tools using laravel, I'll expand this.


# Install composer

```
mkdir ~/Projects
cd ~/Projects
mkdir ~/Projects/myproject
brew install composer --ignore-dependencies
composer create-project laravel/laravel --prefer-dist LaravelWithExtras
cd LaravelWithExtras
```

# Set up git

```
git init
git add .
git commit -m "init"
```

# Set up database

```
cp .env .env.local

vi .env.local
DB_DATABASE=db1
DB_USERNAME=user1
DB_PASSWORD=password1

mysql -u root "CREATE USER 'user1'@'localhost' IDENTIFIED BY 'password1';"
mysql -u root -e "grant all privileges on *.* to 'user1'@'localhost' identified by 'password1'"
mysql -u root -e "create database db1"

cp .env.local .env

git add .
git commit -m "env"
```

# ide helper

```
composer require barryvdh/laravel-ide-helper
echo "'Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider'," | pbcopy
vi config/app.php

//Append to providers
ls _ide_helper.php >> .gitignore 

echo '"php artisan ide-helper:generate",' | pbcopy

git commit -m "ide helper"
```

# Install codeception

```
composer require "codeception/codeception:*"

git add .
git commit -m 'install codeception'

vendor/bin/codecept help bootstrap

git add .
git commit -m 'bootstrap codeception'

vendor/bin/codecept generate:cept acceptance Welcome

echo '
<?php
date_default_timezone_set("UTC");
$I = new AcceptanceTester($scenario);
$I->wantTo("ensure that frontpage works");
$I->amOnPage("/");
$I->see("Laravel");
?>
' >  tests/acceptance/WelcomeCept.php 

Replace `url: 'http://localhost:8000/'` in

vi tests/acceptance.suite.yml 

```
# Try out the test

```
php artisan serve

vendor/bin/codecept run
```

# Extra scripts

Added two scripts, for build checking

```
ls build/
check_app_syntax	run_all_tests
```
