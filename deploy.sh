#!/bin/bash
set -e

# --- CONFIGURATION ---
REPO_URL="YOUR_REPO_URL"
PROJECT_DIR="/var/www/dreampay_api"
BRANCH="main"

echo "🚀 Starting Deployment for DreamPay API..."

# 1. Pull latest code
if [ -d "$PROJECT_DIR" ]; then
    echo "📥 Pulling latest changes from $BRANCH..."
    cd $PROJECT_DIR
    git fetch --all
    git reset --hard origin/$BRANCH
else
    echo "📂 Cloning repository..."
    git clone -b $BRANCH $REPO_URL $PROJECT_DIR
    cd $PROJECT_DIR
fi

# 2. Permissions
echo "🔐 Setting permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 3. Dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# 4. Maintenance Mode
echo "🚧 Entering maintenance mode..."
php artisan down || true

# 5. Database
echo "🗄️ Running migrations..."
php artisan migrate --force

# 6. Optimization
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache # Standard even for API to avoid overhead

# 7. Resume Application
echo "✅ Deployment successful! Waking up..."
php artisan up

echo "--------------------------------------------------"
echo "DreamPay API is now live."
echo "--------------------------------------------------"
