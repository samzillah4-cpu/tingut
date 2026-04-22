#!/bin/bash
# TingUt.no Production Deployment Script
# Run this script on your production server after uploading files

echo "🚀 Starting TingUt.no Production Deployment..."

# Install PHP dependencies
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# Install Node.js dependencies and build assets
echo "🔨 Installing Node.js dependencies..."
npm install

echo "🏗️ Building production assets..."
npm run build

# Set proper permissions
echo "🔐 Setting proper permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache

# Run database migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Seed the database (optional - only if fresh install)
echo "🌱 Seeding database..."
php artisan db:seed --force

# Clear and cache config
echo "⚡ Optimizing Laravel for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage symlink
echo "🔗 Creating storage symlink..."
php artisan storage:link

# Set application key if not set
if ! grep -q "APP_KEY=" .env && [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate
fi

# Clear all caches
echo "🧹 Clearing all caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "✅ Deployment completed successfully!"
echo "🌐 Your application is ready at: https://tingut.no"
echo ""
echo "📋 Next steps:"
echo "1. Configure your domain DNS to point to the server"
echo "2. Set up SSL certificate in FastPanel"
echo "3. Test all functionality"
echo "4. Set up backup schedules"