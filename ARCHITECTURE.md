# Architecture Overview

## Modular Design

The Dashboard Store application follows a modular architecture that allows for easy extension and maintenance.

### Core Modules

1. **Products Module** (`app/Modules/Products/`)
   - Product CRUD operations
   - Inventory management
   - Category management
   - Product search and filtering

2. **Orders Module** (`app/Modules/Orders/`)
   - Order creation and management
   - Order status tracking
   - Order history

3. **Customers Module** (`app/Modules/Customers/`)
   - Customer profiles
   - Customer orders
   - Customer notifications

4. **Payments Module** (`app/Modules/Payments/`)
   - Payment gateway integrations
   - Transaction processing
   - Payment history and reporting

5. **Reports Module** (`app/Modules/Reports/`)
   - Sales reports
   - Analytics dashboard
   - Export functionality

6. **Notifications Module** (`app/Modules/Notifications/`)
   - Firebase Cloud Messaging
   - Email notifications
   - Push notification management

## Service Layer

The application uses a service layer pattern to separate business logic from controllers:

- `StripePaymentService` - Stripe payment processing
- `PayPalPaymentService` - PayPal payment processing
- `FirebaseNotificationService` - Push notifications
- `ExportService` - Data export functionality

## Database Design

### Tables

- `users` - User accounts and authentication
- `categories` - Product categories (hierarchical)
- `products` - Product catalog
- `orders` - Customer orders
- `order_items` - Order line items
- `payments` - Payment transactions

### Relationships

- Users have many Orders
- Orders have many Products (through order_items)
- Products belong to Categories
- Orders have one Payment
- Categories can have child Categories

## API Design

RESTful API design following Laravel conventions:
- Resource controllers for CRUD operations
- JSON responses
- Proper HTTP status codes
- Validation middleware

## Configuration

All module and service configurations are centralized in the `config/` directory:
- `payment.php` - Payment gateway configuration
- `firebase.php` - Firebase services configuration
- `filesystems.php` - Storage configuration
- `modules.php` - Module management

## Extensibility

### Adding New Payment Gateways

1. Create a new service class in `app/Services/`
2. Implement payment methods (create, execute, refund)
3. Add configuration in `config/payment.php`
4. Update PaymentController to support new gateway

### Adding New Modules

1. Create module directory in `app/Modules/`
2. Create module class extending base module
3. Add module to `config/modules.php`
4. Implement module-specific functionality

## Security Features

- Laravel Sanctum for API authentication
- Spatie Permission for role-based access control
- Input validation on all endpoints
- CSRF protection
- SQL injection prevention
- XSS protection
