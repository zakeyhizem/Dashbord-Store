# API Documentation

## Overview

The Dashboard Store API is a RESTful API built with Laravel 10. All responses are in JSON format.

## Base URL

```
http://localhost/api
```

## Authentication

API authentication is handled using Laravel Sanctum. Include the authentication token in the header:

```
Authorization: Bearer {token}
```

## Response Format

### Success Response

```json
{
    "data": {},
    "message": "Success"
}
```

### Error Response

```json
{
    "error": "Error message",
    "message": "Detailed error description"
}
```

## Products API

### List Products

```http
GET /api/products
```

**Query Parameters:**
- `page` (optional) - Page number for pagination
- `per_page` (optional) - Items per page (default: 15)

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "name": "Product Name",
            "description": "Product description",
            "price": "99.99",
            "stock": 100,
            "sku": "PROD-001",
            "image": "product.jpg",
            "category_id": 1,
            "status": "active",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ],
    "links": {},
    "meta": {}
}
```

### Create Product

```http
POST /api/products
```

**Request Body:**
```json
{
    "name": "Product Name",
    "description": "Product description",
    "price": 99.99,
    "stock": 100,
    "sku": "PROD-001",
    "image": "product.jpg",
    "category_id": 1,
    "status": "active"
}
```

### Get Product

```http
GET /api/products/{id}
```

### Update Product

```http
PUT /api/products/{id}
```

### Delete Product

```http
DELETE /api/products/{id}
```

## Orders API

### List Orders

```http
GET /api/orders
```

### Create Order

```http
POST /api/orders
```

**Request Body:**
```json
{
    "user_id": 1,
    "products": [
        {
            "id": 1,
            "quantity": 2
        }
    ],
    "payment_method": "stripe",
    "shipping_address": {
        "street": "123 Main St",
        "city": "New York",
        "state": "NY",
        "zip": "10001",
        "country": "US"
    },
    "billing_address": {
        "street": "123 Main St",
        "city": "New York",
        "state": "NY",
        "zip": "10001",
        "country": "US"
    }
}
```

### Get Order

```http
GET /api/orders/{id}
```

### Update Order

```http
PUT /api/orders/{id}
```

**Request Body:**
```json
{
    "status": "completed",
    "payment_status": "paid"
}
```

## Payments API

### List Payments

```http
GET /api/payments
```

### Get Payment

```http
GET /api/payments/{id}
```

### Create Stripe Payment

```http
POST /api/payments/stripe
```

**Request Body:**
```json
{
    "order_id": 1,
    "amount": 99.99,
    "currency": "usd"
}
```

**Response:**
```json
{
    "payment": {
        "id": 1,
        "order_id": 1,
        "transaction_id": "pi_xxx",
        "payment_gateway": "stripe",
        "amount": "99.99",
        "currency": "usd",
        "status": "pending"
    },
    "client_secret": "pi_xxx_secret_xxx"
}
```

### Create PayPal Payment

```http
POST /api/payments/paypal
```

**Request Body:**
```json
{
    "order_id": 1,
    "amount": 99.99,
    "currency": "USD",
    "return_url": "http://example.com/success",
    "cancel_url": "http://example.com/cancel"
}
```

**Response:**
```json
{
    "payment_id": "PAYID-xxx",
    "approval_url": "https://www.paypal.com/checkoutnow?token=xxx"
}
```

## Notifications API

### Send to Single Device

```http
POST /api/notifications/send-to-device
```

**Request Body:**
```json
{
    "token": "device_token",
    "title": "Notification Title",
    "body": "Notification body",
    "data": {
        "key": "value"
    }
}
```

### Send to Multiple Devices

```http
POST /api/notifications/send-to-multiple-devices
```

**Request Body:**
```json
{
    "tokens": ["token1", "token2"],
    "title": "Notification Title",
    "body": "Notification body",
    "data": {
        "key": "value"
    }
}
```

### Send to Topic

```http
POST /api/notifications/send-to-topic
```

**Request Body:**
```json
{
    "topic": "all_users",
    "title": "Notification Title",
    "body": "Notification body",
    "data": {
        "key": "value"
    }
}
```

## Export API

### Export Orders to Excel

```http
GET /api/exports/orders/excel
```

**Response:**
```json
{
    "message": "Orders exported successfully",
    "filename": "orders_2024-01-01_120000.xlsx"
}
```

### Export Products to Excel

```http
GET /api/exports/products/excel
```

### Export Orders to PDF

```http
GET /api/exports/orders/pdf
```

### Upload to S3

```http
POST /api/exports/s3/upload
```

**Request Body (multipart/form-data):**
- `file` - File to upload
- `path` (optional) - S3 path

**Response:**
```json
{
    "message": "File uploaded successfully",
    "url": "https://s3.amazonaws.com/bucket/path/file.jpg"
}
```

## Status Codes

- `200` - Success
- `201` - Created
- `204` - No Content (successful deletion)
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Internal Server Error

## Error Codes

### Validation Errors (422)

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "field_name": [
            "Error message"
        ]
    }
}
```

## Rate Limiting

API requests are limited to 60 requests per minute per IP address.

## Pagination

List endpoints support pagination with the following parameters:
- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 15, max: 100)

Pagination metadata is included in the response:
```json
{
    "data": [],
    "links": {
        "first": "http://localhost/api/products?page=1",
        "last": "http://localhost/api/products?page=10",
        "prev": null,
        "next": "http://localhost/api/products?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 10,
        "per_page": 15,
        "to": 15,
        "total": 150
    }
}
```
