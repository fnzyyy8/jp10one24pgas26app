#!/bin/sh

set -e

echo "====================================="
echo "Dashboard Jargas"
echo "====================================="

echo "Waiting for database..."

until php -r "
try {
    \$pdo = new PDO(
        'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT'),
        getenv('DB_USERNAME'),
        getenv('DB_PASSWORD')
    );
    echo 'Database ready';
} catch (Exception \$e) {
    exit(1);
}
"; do
    sleep 2
done

echo ""
echo "Database connected."

# Generate application key if empty
if ! grep -q "^APP_KEY=.\+" .env; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

echo "Running migrations..."

php artisan migrate --force

echo "Starting Laravel..."

exec php artisan serve \
    --host=0.0.0.0 \
    --port=8000
