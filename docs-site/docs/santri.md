# Santri Features

Santri can manage their own wallets, perform transfers, and settle split bills.

## Endpoints

### 1. Wallet Balance
**GET** `/user`

Returns the current profile, including `balance`, `points`, and `tier`.

### 2. Peer-to-Peer Transfer
**POST** `/transfer`

**Request Body:**
```json
{
  "recipient_email": "friend@example.com",
  "amount": 1000,
  "pin": "123456"
}
```

### 3. Split Bill
- **POST** `/split-bill`: Create a new patungan.
- **POST** `/split-bill/pay/{memberId}`: Pay your share of a bill.
- **GET** `/my-split-bills`: Bills you created.
- **GET** `/incoming-split-bills`: Bills you need to pay.

### 4. Transaction History
**GET** `/my-transactions`

List all movements in your account.
