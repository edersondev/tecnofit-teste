#!/bin/bash
set -e

SITE_CONF=/etc/apache2/sites-available/000-default.conf
PATH_ROOT=/var/www/html

if [ -n "$SERVER_NAME" ]; then
	sed -i 's#$SERVER_NAME#'$SERVER_NAME'#g' $SITE_CONF
else
	sed -i 's#$SERVER_NAME#localhost#g' $SITE_CONF
fi

if [ -n "$DOCUMENT_ROOT" ]; then
	NEW_PATH="${PATH_ROOT}/${DOCUMENT_ROOT}"
	sed -i 's#$DOCUMENT_ROOT#'$NEW_PATH'#g' $SITE_CONF
else
	sed -i 's#$DOCUMENT_ROOT#'$PATH_ROOT'#g' $SITE_CONF
fi

cd $PATH_ROOT

if [ -f "$PATH_ROOT/composer.json" ]; then
	composer update
	if [ ! -d "$PATH_ROOT/vendor" ];then
		composer install
	fi
fi

if [ ! -f "$PATH_ROOT/.env" ]; then
    if [ -f "$PATH_ROOT/.env.example" ]; then
        cp .env.example .env
        php artisan key:generate
    fi
fi

if [ -f "$PATH_ROOT/.env" ]; then
    php artisan migrate
    php artisan db:seed
    chown www-data.www-data -R bootstrap/ storage/
    touch database/database.sqlite
fi

exec "$@"
