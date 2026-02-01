# 📚 DreamPay API Documentation

Dokumentasi API profesional untuk DreamPay menggunakan Docusaurus dan OpenAPI.

## 🚀 Quick Start

### Prerequisites

- Node.js >= 22.0 (Recommended: 22.x LTS)
- npm atau yarn

### Local Development

```bash
# Install dependencies
cd docs-site
npm install

# Start development server
npm start
```

Server akan berjalan di `http://localhost:3000`

## 🏗️ Build & Deployment

### Build untuk Production

```bash
# Build production-ready static files
npm run build

# Preview production build locally
npm run serve
```

### Deploy ke GitHub Pages

#### Otomatis via GitHub Actions

Push ke branch `main` akan otomatis trigger deployment ke GitHub Pages.

```bash
git add .
git commit -m "Update documentation"
git push origin main
```

#### Manual Deployment

```bash
# Deploy langsung ke GitHub Pages
npm run deploy:gh
```

## 🔧 Troubleshooting

### Error: Node.js version mismatch

**Problem:** `[ERROR] You are using Node.js v18.20.5. Requirement: Node.js >=22.0`

**Solution:**
```bash
# Gunakan Node.js 22 atau lebih tinggi
nvm use 22
# atau
nvm install 22
nvm use 22
```

### Error: Package installation failed

**Problem:** `npm ci` gagal atau dependency conflict

**Solution:**
```bash
# Hapus node_modules dan package-lock.json
rm -rf node_modules package-lock.json

# Install ulang
npm install
```

### Error: Build failed

**Problem:** Build gagal saat `npm run build`

**Solution:**
```bash
# Clear Docusaurus cache
npm run clear

# Rebuild
npm run build
```

### Error: GitHub Actions deployment failed

**Problem:** Workflow gagal di GitHub Actions

**Solution:**
1. Pastikan GitHub Pages enabled di repository settings
2. Set source ke `gh-pages` branch
3. Pastikan `GITHUB_TOKEN` memiliki write permissions
4. Check workflow logs untuk error spesifik

## 📁 Project Structure

```
docs-site/
├── docs/               # Dokumentasi markdown
│   ├── intro.md       # Introduction page
│   └── api/           # Auto-generated API docs
├── src/               # Custom React components
│   ├── components/    # Reusable components
│   ├── css/          # Custom CSS
│   └── pages/        # Custom pages
├── static/           # Static assets
├── docusaurus.config.ts  # Docusaurus configuration
├── sidebars.ts       # Sidebar configuration
└── package.json      # Dependencies & scripts
```

## 🛠️ Available Scripts

| Script | Description |
|--------|-------------|
| `npm start` | Start development server |
| `npm run build` | Build for production |
| `npm run build:prod` | Build with production optimizations |
| `npm run serve` | Preview production build |
| `npm run deploy` | Deploy to GitHub Pages |
| `npm run deploy:gh` | Build and deploy to GitHub Pages |
| `npm run clear` | Clear Docusaurus cache |
| `npm run gen-api-docs` | Generate API docs from OpenAPI spec |
| `npm run clean-api-docs` | Clean generated API docs |

## 🌐 Deployment URLs

- **Development:** http://localhost:3000
- **Production:** https://albnnaardy11.github.io/dreampay_api/

## 📝 Configuration

### GitHub Pages Setup

1. Go to repository Settings → Pages
2. Set Source to `gh-pages` branch
3. Save changes

### Environment Variables

Tidak ada environment variables yang diperlukan untuk deployment dasar.

## 🔄 Update API Documentation

```bash
# Generate API docs dari OpenAPI spec
npm run gen-api-docs

# Clean dan regenerate
npm run clean-api-docs
npm run gen-api-docs
```

## 📦 Production Hosting

### Vercel

```bash
# Install Vercel CLI
npm i -g vercel

# Deploy
cd docs-site
vercel
```

### Netlify

```bash
# Build command
npm run build

# Publish directory
build
```

### Custom Server

```bash
# Build static files
npm run build

# Upload folder 'build' ke web server
# Configure web server untuk serve static files
```

## 🐛 Common Issues

### Issue: Missing OpenAPI spec file

**Error:** Cannot find `../storage/api-docs/api-docs.json`

**Solution:**
1. Generate OpenAPI spec dari Laravel:
   ```bash
   cd ..
   php artisan l5-swagger:generate
   ```
2. Verify file exists di `storage/api-docs/api-docs.json`

### Issue: Broken links in production

**Error:** Links tidak bekerja di GitHub Pages

**Solution:**
- Pastikan `baseUrl` di `docusaurus.config.ts` sesuai:
  ```typescript
  baseUrl: '/dreampay_api/',
  ```
- Gunakan relative links di markdown

## 📞 Support

Jika ada masalah atau pertanyaan:
1. Check [Docusaurus Documentation](https://docusaurus.io/docs)
2. Check [OpenAPI Plugin Docs](https://github.com/PaloAltoNetworks/docusaurus-openapi-docs)
3. Create issue di repository

## 📄 License

Copyright © 2026 DreamPay. All rights reserved.
