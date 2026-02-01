# Authentication

DreamPay uses **Laravel Sanctum** for token-based authentication. All protected routes require a `Bearer` token in the `Authorization` header.

## Endpoints

### 1. Register
**POST** `/register`

Register a new santri account.

**Request Body:**
```json
{
  "name": "Full Name",
  "email": "email@example.com",
  "password": "strongpassword",
  "pin": "123456"
}
```

### 2. Login
**POST** `/login`

**Request Body:**
```json
{
  "email": "email@example.com",
  "password": "strongpassword"
}
```

**Response:**
```json
{
  "user": { ... },
  "access_token": "your-token-here",
  "token_type": "Bearer"
}
```

### 3. Logout
**POST** `/logout` (Protected)

Revoke the current access token.
