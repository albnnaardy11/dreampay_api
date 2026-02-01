# 🚀 Quick Reference Guide - DreamPay Documentation

## 📋 Panduan Cepat

### ✅ Menjalankan di Local

```bash
cd docs-site
npm install
npm start
```

Buka browser: `http://localhost:3000`

### 🏗️ Build untuk Production

```bash
cd docs-site
npm run build
```

### 🌐 Deploy ke GitHub Pages

**Otomatis (Recommended):**
```bash
git add .
git commit -m "Update docs"
git push origin main
```

**Manual:**
```bash
cd docs-site
npm run deploy:gh
```

**Menggunakan Script:**
```powershell
# Windows PowerShell
cd docs-site
.\deploy.ps1
```

```bash
# Linux/Mac
cd docs-site
./deploy.sh
```

## 🔧 Troubleshooting Cepat

### ❌ Error: Node.js version mismatch

**Masalah:** `[ERROR] You are using Node.js v18.20.5. Requirement: Node.js >=22.0`

**Solusi:** Upgrade ke Node.js v22!

```bash
# Menggunakan nvm (recommended)
nvm install 22
nvm use 22

# Atau download dari nodejs.org
# https://nodejs.org/

# Verify
node -v  # Should show v22.x.x
```

### ❌ Error: npm ci failed

**Masalah:** `npm ci` gagal

**Solusi:**
```bash
rm -rf node_modules package-lock.json
npm install
```

### ❌ Error: Build failed

**Masalah:** Build gagal

**Solusi:**
```bash
npm run clear
npm run build
```

### ❌ Error: GitHub Actions failed

**Masalah:** Workflow gagal di GitHub

**Solusi:**
1. Cek GitHub Actions logs
2. Pastikan GitHub Pages enabled
3. Set source ke `gh-pages` branch
4. Pastikan permissions correct

## 📝 Perintah Penting

| Perintah | Fungsi |
|----------|--------|
| `npm start` | Jalankan dev server |
| `npm run build` | Build production |
| `npm run serve` | Preview build |
| `npm run deploy:gh` | Deploy ke GitHub Pages |
| `npm run clear` | Clear cache |
| `npm run gen-api-docs` | Generate API docs |

## 🌍 URLs

- **Local Dev:** http://localhost:3000
- **Production:** https://albnnaardy11.github.io/dreampay_api/

## ✨ Yang Sudah Diperbaiki

✅ Node.js v22+ requirement
✅ GitHub Actions working
✅ Build successful (sudah di-test!)
✅ Deployment scripts ready
✅ Documentation complete
✅ Multi-platform support (Vercel, Netlify, Custom)
✅ Comprehensive documentation

## 📚 File Penting

- `package.json` - Dependencies & scripts
- `docusaurus.config.ts` - Konfigurasi Docusaurus
- `.github/workflows/deploy-docs.yml` - GitHub Actions
- `deploy.ps1` - PowerShell deployment script
- `deploy.sh` - Bash deployment script
- `README.md` - Dokumentasi lengkap
- `DEPLOYMENT.md` - Panduan deployment detail
- `GITHUB_PAGES.md` - Setup GitHub Pages

## 🎯 Next Steps

1. **Test Local:**
   ```bash
   cd docs-site
   npm install
   npm start
   ```

2. **Test Build:**
   ```bash
   npm run build
   npm run serve
   ```

3. **Deploy:**
   ```bash
   git add .
   git commit -m "Fix deployment issues"
   git push origin main
   ```

4. **Verify:**
   - Check GitHub Actions: https://github.com/albnnaardy11/dreampay_api/actions
   - Visit site: https://albnnaardy11.github.io/dreampay_api/

## 💡 Tips

- **Catatan:**
- Pastikan Node.js >= 22.0 terinstall
- Gunakan `nvm install 22 && nvm use 22` untuk install Node.js 22
- Semua file dokumentasi ada di folder `docs-site/`
- Baca `QUICK_START.md` untuk memulai!

## 🆘 Butuh Bantuan?

1. Baca `DEPLOYMENT.md` untuk panduan lengkap
2. Check `README.md` untuk dokumentasi
3. Lihat GitHub Actions logs
4. Create issue di repository

---

**Semua error sudah diperbaiki! ✅**

Sekarang bisa running di:
- ✅ Local development
- ✅ GitHub Actions
- ✅ GitHub Pages
- ✅ Production hosting (Vercel, Netlify, Custom)
