# DreamPay API - Quick Start Guide

## 🚀 Project Overview

DreamPay adalah financial API berkualitas enterprise untuk ekosistem Market Day Santri. Project ini mencakup:
- **Backend API** (Laravel 10 + Sanctum)
- **Interactive Documentation** (Docusaurus + OpenAPI)
- **Automated Testing** (PHPUnit)
- **CI/CD Pipeline** (GitHub Actions)

---

## 📁 Struktur Project

```
dreampay_api/
├── app/                        # Laravel Application
│   ├── Http/Controllers/       # API Controllers dengan OpenAPI annotations
│   └── Models/                 # Eloquent Models
├── docs-site/                  # Docusaurus Documentation
│   ├── docs/                   # Manual documentation
│   │   ├── intro.md
│   │   ├── auth.md
│   │   ├── merchant.md
│   │   ├── santri.md
│   │   ├── admin.md
│   │   ├── security.md
│   │   └── deployment.md
│   └── static/                 # Static assets
├── storage/api-docs/           # Auto-generated OpenAPI spec
├── .github/workflows/          # GitHub Actions
├── deploy.sh                   # Production deployment script
└── README.md
```

---

## 🛠️ Local Development

### Backend API

```bash
# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Generate Swagger docs
php artisan l5-swagger:generate

# Start server
php artisan serve
```

**API Documentation**: http://localhost/api/documentation

### Documentation Site

```bash
cd docs-site

# Install dependencies
npm install

# Copy latest API spec
cp ../storage/api-docs/api-docs.json static/

# Generate API docs
npm run gen-api-docs

# Start dev server
npm start
```

**Docs Site**: http://localhost:3000

---

## 📝 Workflow Development

### 1. Update API Endpoints

Tambahkan OpenAPI annotations di controller:

```php
/**
 * @OA\Post(
 *     path="/endpoint",
 *     summary="Description",
 *     tags={"Tag Name"},
 *     @OA\RequestBody(...),
 *     @OA\Response(...)
 * )
 */
public function method(Request $request) { ... }
```

### 2. Generate Swagger JSON

```bash
php artisan l5-swagger:generate
```

### 3. Update Documentation

```bash
cd docs-site
cp ../storage/api-docs/api-docs.json static/
npm run gen-api-docs
npm run build
```

---

## 🚢 Deployment

### GitHub Pages (Automatic)

1. Push ke repository:
```bash
git add .
git commit -m "feat: update API"
git push origin main
```

2. GitHub Actions akan otomatis:
   - Build documentation
   - Deploy ke GitHub Pages
   - Available di: https://albnnaardy11.github.io/dreampay_api/

### Production Server

```bash
chmod +x deploy.sh
./deploy.sh
```

---

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/DreamPaySystemTest.php

# With coverage
php artisan test --coverage
```

---

## 📚 Documentation URLs

- **Local API Docs**: http://localhost/api/documentation
- **Local Guide**: http://localhost:3000
- **Production Docs**: https://albnnaardy11.github.io/dreampay_api/
- **GitHub Repo**: https://github.com/albnnaardy11/dreampay_api

---

## 🔐 Security Features

✅ PIN Hashing (bcrypt)  
✅ Database Locking (lockForUpdate)  
✅ Rate Limiting  
✅ Input Validation  
✅ CSRF Protection  
✅ Mass Assignment Protection  
✅ Sanctum Authentication  

---

## 🎯 Next Steps

1. ✅ Setup GitHub repository
2. ✅ Configure GitHub Pages
3. ⏳ Add more OpenAPI annotations to controllers
4. ⏳ Write integration tests
5. ⏳ Setup production server
6. ⏳ Configure SSL/HTTPS
7. ⏳ Setup monitoring

---

## 📞 Support

- **Issues**: https://github.com/albnnaardy11/dreampay_api/issues
- **Security**: security@dreampay.id

---

**Built with ❤️ for Santri Market Day**
