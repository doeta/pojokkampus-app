#!/bin/bash
set -e

echo "Starting PojokKampus Application..."

# Wait for MySQL to be ready (docker-compose handles basic health, but we need connection)
echo "Waiting for MySQL connection..."
MAX_TRIES=30
COUNT=0
while [ $COUNT -lt $MAX_TRIES ]; do
    if php -r "new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));" 2>/dev/null; then
        echo "MySQL is ready!"
        break
    fi
    echo "MySQL is unavailable - sleeping (attempt $((COUNT+1))/$MAX_TRIES)..."
    sleep 2
    COUNT=$((COUNT+1))
done

if [ $COUNT -eq $MAX_TRIES ]; then
    echo "Warning: Could not connect to MySQL, continuing anyway..."
fi

# Create storage directories if they don't exist
mkdir -p /var/www/html/storage/framework/{sessions,views,cache}
mkdir -p /var/www/html/storage/app/public/product-images
mkdir -p /var/www/html/storage/app/public/ktp-files
mkdir -p /var/www/html/storage/logs
mkdir -p /var/log/supervisor

# Set permissions
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Clear and cache config
echo "Clearing caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan route:clear || true

# Create storage link
echo "Creating storage link..."
php artisan storage:link --force 2>/dev/null || true

# Auto-seed essential test data if database is fresh
echo "Checking database status..."
NEED_SEED=$(php -r "
    try {
        require '/var/www/html/vendor/autoload.php';
        \$app = require_once '/var/www/html/bootstrap/app.php';
        \$kernel = \$app->make(Illuminate\Contracts\Console\Kernel::class);
        \$kernel->bootstrap();
        echo \App\Models\Category::count() == 0 ? 'yes' : 'no';
    } catch (\Throwable \$e) {
        echo 'no';
    }
" 2>/dev/null || echo "no")

if [ "$NEED_SEED" = "yes" ]; then
    echo "Fresh database detected. Auto-seeding initial data..."
    php artisan db:seed --class=AdminSeeder --force || true
    php artisan db:seed --class=PlatformUserSeeder --force || true
    php artisan db:seed --class=CategorySeeder --force || true
    php artisan db:seed --class=TestSellerSeeder --force || true
    php artisan db:seed --class=ProductSeeder --force || true
    echo "Initial data seeded successfully!"
fi

# Cache config for production
if [ "$APP_ENV" = "production" ]; then
    echo "Caching configuration for production..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

echo "PojokKampus is ready!"

# Execute the main command
exec "$@"
