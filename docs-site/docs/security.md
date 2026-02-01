# Security Best Practices

## Authentication & Authorization

### Token Management
- **Never** expose tokens in URLs or logs
- Store tokens securely on client side (encrypted storage)
- Implement token rotation for long-lived sessions
- Set appropriate token expiration times

### PIN Security
- PINs are hashed using bcrypt (cost factor 10)
- Never log or display PINs in plain text
- Implement rate limiting on PIN verification (max 3 attempts)
- Consider implementing PIN lockout after failed attempts

## Transaction Safety

### Database Locking
All financial operations use `lockForUpdate()` to prevent race conditions:

```php
DB::transaction(function () {
    $user = User::where('id', $userId)->lockForUpdate()->first();
    // Perform balance operations
});
```

### Atomic Operations
- All balance modifications happen within database transactions
- Failed transactions are automatically rolled back
- No partial state changes are possible

## Rate Limiting

Current limits:
- **Authentication**: 10 requests/minute
- **Protected Routes**: 60 requests/minute
- **Merchant Scan**: Inherits protected route limit

Customize in `routes/api.php`:
```php
Route::middleware('throttle:10,1')->post('/login', ...);
```

## Input Validation

### Always Validate
- Email format and uniqueness
- Amount ranges (min: 1, max: based on business rules)
- PIN format (6 digits)
- QR code existence

### Sanitization
- Use Laravel's built-in validation
- Never trust client input
- Validate on both client and server

## Production Checklist

- [ ] Set `APP_DEBUG=false`
- [ ] Use HTTPS only
- [ ] Configure CORS properly
- [ ] Enable database query logging for auditing
- [ ] Set up monitoring and alerting
- [ ] Regular security audits
- [ ] Keep dependencies updated
- [ ] Implement backup strategy
- [ ] Use environment-specific credentials
- [ ] Enable Laravel's maintenance mode during deployments

## Common Vulnerabilities Addressed

### OWASP API Security Top 10

1. **Broken Object Level Authorization**: ✅ Prevented via middleware and ownership checks
2. **Broken Authentication**: ✅ Sanctum with proper token management
3. **Excessive Data Exposure**: ✅ Hidden fields in models
4. **Lack of Resources & Rate Limiting**: ✅ Throttle middleware
5. **Broken Function Level Authorization**: ✅ Gates for admin/merchant routes
6. **Mass Assignment**: ✅ Fillable arrays and role protection
7. **Security Misconfiguration**: ✅ Production-ready defaults
8. **Injection**: ✅ Eloquent ORM prevents SQL injection
9. **Improper Assets Management**: ✅ API versioning ready
10. **Insufficient Logging & Monitoring**: ✅ Laravel logging enabled

## Reporting Security Issues

If you discover a security vulnerability, please email:
**security@dreampay.id**

Do not create public GitHub issues for security vulnerabilities.
