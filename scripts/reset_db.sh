#/bin/sh
if [ "$1" == "" ]; then
    echo "usage reset_db.sh database_name"
    exit 1;
fi

composer dump-autoload
mysql -u root -e "drop database $1; create database $1;"
php artisan migrate
php artisan -v db:seed
