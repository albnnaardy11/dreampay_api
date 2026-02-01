# Admin API

Restricted to users with the `admin` role.

## Endpoints

### 1. Manual Topup
**POST** `/admin/topup`

Admin can topup any user's balance.

**Request Body:**
```json
{
  "user_id": 1,
  "amount": 50000
}
```

### 2. User Listing
**GET** `/admin/users`

Monitor all registrations and account balances.
