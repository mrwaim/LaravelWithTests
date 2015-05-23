#!/bin/sh
echo $1
diff -r --brief . $1 | grep differ | grep -v './vendor\|./resources\|./nbproject\|./database/migrations\|\./\.\|./_ide_helper\.php\|./app/Http/Controllers\|./database/seeds\|./public\|./tests/_output\|./tests/acceptance\|User.php\|Registrar.php'
