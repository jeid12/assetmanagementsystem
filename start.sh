#!/bin/sh

# Wait for database to be ready
echo "Waiting for PostgreSQL to be ready..."
until nc -z -v -w30 "$DB_HOST" "$DB_PORT"
do
  echo "Waiting for database connection..."
  sleep 5
done

# Laravel setup
php artisan config:cache
php artisan migrate --force

# Start Supervisor (will start PHP-FPM and NGINX)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
