#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}

if [ "$role" = "app" ]; then
    php-fpm8.0 --nodaemonize;
elif [ "$role" = "queue" ]; then
    echo "Running the supervisor..."
    supervisord
elif [ "$role" = "websocket" ]; then
    echo "Running the websocket..."
#    /usr/bin/php8.0 /var/www/html/artisan websockets:serve
    supervisord
elif [ "$role" = "cron" ]; then
    cron -f -l 8 && tail -f /var/log/cron.log;
else

    echo "Could not match the container role \"$role\""
    exit 1

fi
