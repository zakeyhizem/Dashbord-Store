# Dashboard Store

Admin dashboard for a modular e-commerce store built with Laravel 10 (PHP 8.1). Supports multiple payment gateways, Firebase notifications, Excel/PDF exports, S3 storage, and extensible modules.

## Features

### 🚀 Core Features
- **Laravel 10** framework with PHP 8.1 support
- **Modular Architecture** - Easily extend functionality with custom modules
- **RESTful API** - Complete API endpoints for all operations
- **Authentication & Authorization** - Role-based access control using Spatie Permission

### 💳 Payment Gateways
- **Stripe Integration** - Full payment processing with Stripe
- **PayPal Integration** - Complete PayPal payment gateway support
- Extensible payment architecture for adding more gateways

### 🔔 Notifications
- **Firebase Cloud Messaging (FCM)** - Push notifications to mobile devices
- Support for device-specific, multi-device, and topic-based notifications
- Configurable notification channels

### 📊 Export & Reporting
- **Excel Export** - Export data to Excel using Maatwebsite/Laravel-Excel
- **PDF Export** - Generate PDF reports using DomPDF
- Custom report generation capabilities

### ☁️ Storage
- **AWS S3 Integration** - Cloud storage support
- Local and public disk storage options
- File upload and management API

### 🧩 Modular System
Pre-built modules:
- Products Module - Product management and inventory
- Orders Module - Order processing and tracking
- Customers Module - Customer management
- Payments Module - Payment gateway integrations
- Reports Module - Analytics and reporting
- Notifications Module - Multi-channel notifications

## Requirements

- PHP >= 8.1
- Composer
- MySQL >= 5.7 or PostgreSQL >= 10
- Node.js >= 16.x (for frontend assets)

## Installation

1. **Clone the repository**
```bash
git clone https://github.com/zakeyhizem/Dashbord-Store.git
cd Dashbord-Store
```

2. **Install dependencies**
```bash
composer install
```

3. **Configure environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Update database configuration in .env**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dashboard_store
DB_USERNAME=root
DB_PASSWORD=
```

5. **Run migrations**
```bash
php artisan migrate
```

6. **Configure payment gateways (optional)**

For Stripe:
```env
STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret
STRIPE_WEBHOOK_SECRET=your_webhook_secret
```

For PayPal:
```env
PAYPAL_MODE=sandbox
PAYPAL_CLIENT_ID=your_client_id
PAYPAL_SECRET=your_secret
```

7. **Configure Firebase (optional)**
```env
FIREBASE_CREDENTIALS=/path/to/firebase-credentials.json
FIREBASE_DATABASE_URL=https://your-project.firebaseio.com
FIREBASE_PROJECT_ID=your-project-id
```

8. **Configure AWS S3 (optional)**
```env
AWS_ACCESS_KEY_ID=your_access_key
AWS_SECRET_ACCESS_KEY=your_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket_name
```

## API Endpoints

### Products
- `GET /api/products` - List all products
- `POST /api/products` - Create a new product
- `GET /api/products/{id}` - Get product details
- `PUT /api/products/{id}` - Update a product
- `DELETE /api/products/{id}` - Delete a product

### Orders
- `GET /api/orders` - List all orders
- `POST /api/orders` - Create a new order
- `GET /api/orders/{id}` - Get order details
- `PUT /api/orders/{id}` - Update an order
- `DELETE /api/orders/{id}` - Delete an order

### Payments
- `GET /api/payments` - List all payments
- `GET /api/payments/{id}` - Get payment details
- `POST /api/payments/stripe` - Create Stripe payment
- `POST /api/payments/paypal` - Create PayPal payment

### Notifications
- `POST /api/notifications/send-to-device` - Send to single device
- `POST /api/notifications/send-to-multiple-devices` - Send to multiple devices
- `POST /api/notifications/send-to-topic` - Send to topic

### Exports
- `GET /api/exports/orders/excel` - Export orders to Excel
- `GET /api/exports/products/excel` - Export products to Excel
- `GET /api/exports/orders/pdf` - Export orders to PDF
- `POST /api/exports/s3/upload` - Upload file to S3

## Module Structure

Modules are located in `app/Modules/` directory. Each module contains:
- Module class definition
- Controllers
- Models
- Routes
- Views (if needed)

### Creating a New Module

1. Create module directory: `app/Modules/YourModule/`
2. Create module class extending base module
3. Register module in `config/modules.php`
4. Implement module-specific functionality

## Configuration Files

- `config/payment.php` - Payment gateway settings
- `config/firebase.php` - Firebase configuration
- `config/filesystems.php` - Storage configuration
- `config/modules.php` - Module management

## Database Schema

### Users
- User authentication and profile management
- Firebase token storage for push notifications

### Products
- Product information and inventory
- Category relationships
- Stock management

### Orders
- Order processing and tracking
- Multiple product support
- Shipping and billing addresses

### Payments
- Payment transaction records
- Multi-gateway support
- Transaction metadata

## Security

- Laravel Sanctum for API authentication
- Spatie Permission for role-based access control
- CSRF protection
- SQL injection prevention
- XSS protection

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For issues and questions, please use the [GitHub issue tracker](https://github.com/zakeyhizem/Dashbord-Store/issues).
