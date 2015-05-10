#/bin/sh
if [ "$1" == "" ]; then
    echo "usage reset_db.sh database_name"
    exit 1;
fi

user="root"
p=""

if [ -z "$2" ]; then
	echo "using $user"
else
	user=$2
	p=" -p "
	echo "using $user"
fi

composer dump-autoload
command="mysql -u $user $p -e \"drop database $1; create database $1;\""
echo $command
if ! eval $command; then
    echo "mysql failed" >&2
    exit 1
fi

php artisan migrate
php artisan -v db:seed
