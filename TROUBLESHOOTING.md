# Troubleshooting Guide

## Common Issues and Solutions

### 1. Node.js Version Error

**Error:**
```
Error: Minimum Node.js version not met :(
[INFO] You are using Node.js v18.20.5, Requirement: Node.js >=20.0.
```

**Solution:**

#### Option A: Upgrade Node.js (Recommended)
1. Download Node.js v20 LTS from https://nodejs.org/
2. Install and restart your terminal
3. Verify: `node --version` (should show v20.x.x)
4. Reinstall dependencies:
   ```bash
   cd docs-site
   rm -rf node_modules package-lock.json
   npm install
   ```

#### Option B: Use NVM (Node Version Manager)
```bash
# Windows: Download from https://github.com/coreybutler/nvm-windows
# Mac/Linux: curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash

nvm install 20
nvm use 20
node --version
```

#### Option C: Temporary Workaround
If you cannot upgrade Node.js immediately, the `package.json` has been modified to allow Node.js 18. However, this is **not recommended** for production.

---

### 2. Build Failures

**Error:** Build fails with various errors

**Solution:**
```bash
# Clear all caches
cd docs-site
npm run clear
rm -rf node_modules package-lock.json .docusaurus build

# Reinstall
npm install

# Rebuild
npm run build
```

---

### 3. API Documentation Not Generating

**Error:** API docs folder is empty

**Solution:**
```bash
# 1. Ensure Swagger JSON is up to date
php artisan l5-swagger:generate

# 2. Copy to Docusaurus
cp storage/api-docs/api-docs.json docs-site/static/

# 3. Generate API docs
cd docs-site
npm run gen-api-docs

# 4. Build
npm run build
```

---

### 4. GitHub Actions Deployment Fails

**Error:** Workflow fails on GitHub

**Solutions:**

#### Check Node.js Version
Ensure `.github/workflows/deploy-docs.yml` uses Node.js 20:
```yaml
- name: Setup Node.js
  uses: actions/setup-node@v3
  with:
    node-version: '20'  # Must be 20 or higher
```

#### Enable GitHub Pages
1. Go to repository Settings
2. Navigate to Pages
3. Source: Select `gh-pages` branch
4. Save

#### Check Permissions
Ensure GitHub Actions has write permissions:
1. Settings → Actions → General
2. Workflow permissions → Read and write permissions

---

### 5. CORS Errors in Production

**Error:** API requests blocked by CORS

**Solution:**

Add to `config/cors.php`:
```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_origins' => [
    'https://albnnaardy11.github.io',
    'http://localhost:3000',
],
```

---

### 6. Database Migration Errors

**Error:** Migration fails

**Solution:**
```bash
# Reset database (WARNING: This will delete all data)
php artisan migrate:fresh

# Or rollback and re-run
php artisan migrate:rollback
php artisan migrate
```

---

### 7. Swagger UI Not Loading

**Error:** `/api/documentation` shows blank page

**Solution:**
```bash
# Regenerate Swagger docs
php artisan l5-swagger:generate

# Clear cache
php artisan config:clear
php artisan route:clear
php artisan cache:clear

# Check config
php artisan config:cache
```

---

### 8. Rate Limiting Issues

**Error:** Too many requests (429)

**Solution:**

Adjust rate limits in `routes/api.php`:
```php
// Increase limits for development
Route::middleware('throttle:100,1')->group(function () {
    // Your routes
});
```

---

### 9. PIN Verification Fails

**Error:** Invalid PIN even with correct PIN

**Cause:** PIN hashing mutator is applied during creation

**Solution:**
Ensure you're using `Hash::check()` for verification:
```php
if (!\Hash::check($request->pin, $user->pin)) {
    return response()->json(['message' => 'Invalid PIN'], 403);
}
```

---

### 10. Tests Failing

**Error:** Tests fail unexpectedly

**Solution:**
```bash
# Use testing database
cp .env .env.backup
cp .env.testing .env

# Run migrations for testing
php artisan migrate --env=testing

# Run tests
php artisan test

# Restore original .env
mv .env.backup .env
```

---

## Getting Help

If you encounter issues not covered here:

1. **Check Logs:**
   - Laravel: `storage/logs/laravel.log`
   - Docusaurus: Terminal output
   - GitHub Actions: Actions tab in repository

2. **Search Issues:**
   - https://github.com/albnnaardy11/dreampay_api/issues

3. **Create New Issue:**
   - Include error message
   - Steps to reproduce
   - Environment details (OS, Node version, PHP version)

4. **Contact:**
   - Email: support@dreampay.id
   - Security issues: security@dreampay.id

---

## Useful Commands

### Laravel
```bash
# Clear all caches
php artisan optimize:clear

# View routes
php artisan route:list

# Check application status
php artisan about

# Run tests
php artisan test --coverage
```

### Docusaurus
```bash
# Start dev server
npm start

# Build for production
npm run build

# Serve production build locally
npm run serve

# Clear cache
npm run clear
```

### Git
```bash
# Check status
git status

# View commit history
git log --oneline

# Undo last commit (keep changes)
git reset --soft HEAD~1
```

---

**Last Updated:** 2026-02-01
