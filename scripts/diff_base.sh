#!/bin/sh
echo $1
pattern="./vendor\|./resources\|./nbproject\|./database/migrations\|\./\.\|$1/\.\|./_ide_helper\.php\|./app/Http/Controllers\|./database/seeds\|./public\|./tests/_output\|./tests/acceptance\|User.php\|Registrar.php\|./storage/"
mytemp=$(mktemp -t diff)
#echo $mytemp
diff -r --brief . $1 > $mytemp
cat $mytemp | grep differ | grep -v './vendor\|./resources\|./nbproject\|./database/migrations\|\./\.\|./_ide_helper\.php\|./app/Http/Controllers\|./database/seeds\|./public\|./tests/_output\|./tests/acceptance\|User.php\|Registrar.php'
cat $mytemp | grep 'Only in' | grep $1 | grep -v $pattern
