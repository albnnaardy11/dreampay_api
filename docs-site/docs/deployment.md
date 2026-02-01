# Backend Deployment Guide

## Prerequisites
- Ubuntu 20.04+ / Debian 11+
- PHP 8.1+
- MySQL 8.0+ / PostgreSQL 13+
- Composer
- Git

## Initial Setup

### 1. Clone Repository
```bash
git clone https://github.com/your-username/dreampay_api.git
cd dreampay_api
```

### 2. Install Dependencies
```bash
composer install --no-dev --optimize-autoloader
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://api.yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dreampay
DB_USERNAME=your_db_user
DB_PASSWORD=your_secure_password
```

### 4. Database Migration
```bash
php artisan migrate --force
```

### 5. Permissions
```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### 6. Optimize
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Automated Deployment

Use the provided `deploy.sh` script:

```bash
chmod +x deploy.sh
./deploy.sh
```

## Nginx Configuration

```nginx
server {
    listen 80;
    server_name api.yourdomain.com;
    root /var/www/dreampay_api/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## SSL with Let's Encrypt

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d api.yourdomain.com
```

## Monitoring

### Check Application Status
```bash
php artisan about
```

### View Logs
```bash
tail -f storage/logs/laravel.log
```

## Troubleshooting

### Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Permission Issues
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```
