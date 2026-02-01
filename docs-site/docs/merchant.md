# Merchant API

Merchant endpoints are restricted to users with the `merchant` role. These allow stands to accept payments by scanning santri QR codes.

## Endpoints

### 1. Scan and Pay
**POST** `/merchant/scan-pay` (Merchant Only)

The primary endpoint for Market Day sales.

**Request Body:**
```json
{
  "qr_code": "DP-XXXXXXXX",
  "amount": 5000,
  "description": "Nasi Bakar Ayam"
}
```

### 2. Product Management
- **GET** `/merchant/products`: List all products in your stand.
- **POST** `/merchant/products`: Add a new product.
- **DELETE** `/merchant/products/{id}`: Remove a product.

### 3. Sales History
**GET** `/merchant/sales`

Get a detailed log of all payments received.
