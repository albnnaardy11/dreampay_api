# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-02-01

### Added
- Initial release of DreamPay API
- User authentication with Laravel Sanctum
- Role-based access control (Admin, Santri, Merchant)
- QR code generation for each user
- Merchant scan-and-pay functionality
- P2P transfer system with PIN verification
- Split bill feature for group expenses
- Admin topup functionality
- Transaction history tracking
- Points and tier system
- Database locking for transaction safety
- Rate limiting on critical endpoints
- Comprehensive test suite
- OpenAPI/Swagger documentation
- Docusaurus documentation site
- Automated deployment script
- GitHub Actions for CI/CD

### Security
- PIN hashing with bcrypt
- Database-level locking to prevent race conditions
- Input validation on all endpoints
- CSRF protection
- Rate limiting to prevent brute force attacks
- Mass assignment protection

## [Unreleased]

### Planned
- Voucher/promo system
- Category-based spending limits
- Enhanced reporting for merchants
- Webhook support for external integrations
- Mobile app SDK
- Multi-currency support
