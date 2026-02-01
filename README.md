# DreamPay Project

A complete financial ecosystem for Santri Market Day events.

## Project Structure

```
dreampay_api/
├── app/                    # Laravel Backend API
├── docs-site/              # Docusaurus Documentation
├── deploy.sh               # Production Deployment Script
└── README.md               # This file
```

## Quick Start

### Backend API
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

### Documentation Site
```bash
cd docs-site
npm install
npm start
```

## Features
- **Deterministic Transaction Logic**: Database-level locking prevents race conditions
- **Role-Based Access Control**: Santri, Merchant, and Admin roles
- **QR-First Architecture**: Fast merchant-side scanning
- **Split Bill Engine**: Social finance for shared expenses
- **Interactive API Docs**: Swagger/OpenAPI with "Try It Out" functionality

## Documentation
- **API Reference**: http://localhost/api/documentation
- **Developer Docs**: http://localhost:3000 (Docusaurus)

## Security
- All balance modifications use `DB::transaction` with `lockForUpdate`
- PIN verification via `Hash::check`
- Rate limiting on all critical endpoints
- Sanctum token-based authentication

## Testing
```bash
php artisan test
```

## Deployment
```bash
chmod +x deploy.sh
./deploy.sh
```

## License
MIT

---
*Built with high standards for the next generation of Santri FinTech.*
