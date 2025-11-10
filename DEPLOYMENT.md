# Deployment Guide

## Prerequisites

- PHP >= 8.1
- Composer
- MySQL >= 5.7 or PostgreSQL >= 10
- Web server (Apache/Nginx)
- Node.js >= 16.x (optional, for frontend)

## Server Requirements

### PHP Extensions

Ensure the following PHP extensions are installed:
- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML

## Deployment Steps

### 1. Clone Repository

```bash
git clone https://github.com/zakeyhizem/Dashbord-Store.git
cd Dashbord-Store
```

### 2. Install Dependencies

```bash
composer install --optimize-autoloader --no-dev
```

### 3. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your production settings:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-database-username
DB_PASSWORD=your-database-password
```

### 4. Configure Payment Gateways

#### Stripe
```env
STRIPE_KEY=pk_live_xxx
STRIPE_SECRET=sk_live_xxx
STRIPE_WEBHOOK_SECRET=whsec_xxx
```

#### PayPal
```env
PAYPAL_MODE=live
PAYPAL_CLIENT_ID=your_live_client_id
PAYPAL_SECRET=your_live_secret
```

### 5. Configure Firebase

1. Download Firebase credentials JSON file
2. Place it in a secure location on your server
3. Update `.env`:

```env
FIREBASE_CREDENTIALS=/path/to/firebase-credentials.json
FIREBASE_DATABASE_URL=https://your-project.firebaseio.com
FIREBASE_PROJECT_ID=your-project-id
```

### 6. Configure AWS S3

```env
AWS_ACCESS_KEY_ID=your_access_key
AWS_SECRET_ACCESS_KEY=your_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket_name
FILESYSTEM_DISK=s3
```

### 7. Database Migration

```bash
php artisan migrate --force
```

### 8. Optimize Application

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 9. Set Permissions

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 10. Configure Web Server

#### Apache

Create a virtual host configuration:

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /path/to/Dashbord-Store/public

    <Directory /path/to/Dashbord-Store/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/dashboard-error.log
    CustomLog ${APACHE_LOG_DIR}/dashboard-access.log combined
</VirtualHost>
```

#### Nginx

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/Dashbord-Store/public;

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

### 11. SSL Certificate (Recommended)

Install Let's Encrypt certificate:

```bash
sudo certbot --nginx -d yourdomain.com
```

## Queue Configuration

For production, use a queue driver like Redis:

```env
QUEUE_CONNECTION=redis
```

Set up queue worker as a systemd service:

```bash
sudo nano /etc/systemd/system/dashboard-worker.service
```

```ini
[Unit]
Description=Dashboard Store Queue Worker

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /path/to/Dashbord-Store/artisan queue:work --sleep=3 --tries=3

[Install]
WantedBy=multi-user.target
```

Start the service:

```bash
sudo systemctl enable dashboard-worker
sudo systemctl start dashboard-worker
```

## Task Scheduler

Add to crontab:

```bash
* * * * * cd /path/to/Dashbord-Store && php artisan schedule:run >> /dev/null 2>&1
```

## Monitoring

### Log Files

Monitor logs at:
- `storage/logs/laravel.log`

### Queue Monitoring

```bash
php artisan queue:monitor
```

## Backup

### Database Backup

```bash
mysqldump -u username -p database_name > backup.sql
```

### File Backup

```bash
tar -czf backup.tar.gz /path/to/Dashbord-Store
```

## Updating

```bash
git pull origin main
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Troubleshooting

### Permission Issues

```bash
chmod -R 775 storage bootstrap/cache
```

### Cache Issues

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Database Connection Issues

Verify database credentials in `.env` and test connection:

```bash
php artisan tinker
DB::connection()->getPdo();
```

## Security Checklist

- [ ] Set `APP_DEBUG=false` in production
- [ ] Use HTTPS
- [ ] Keep dependencies updated
- [ ] Regular database backups
- [ ] Monitor error logs
- [ ] Use strong database passwords
- [ ] Restrict database access
- [ ] Configure firewall
- [ ] Keep server software updated
- [ ] Use environment variables for secrets

## Performance Optimization

1. Enable OPcache
2. Use Redis for caching and sessions
3. Enable Gzip compression
4. Use CDN for static assets
5. Optimize database queries
6. Use queue for long-running tasks
7. Monitor application performance
