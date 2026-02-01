# 📚 DreamPay API Documentation

[![Deploy Documentation](https://github.com/albnnaardy11/dreampay_api/actions/workflows/deploy-docs.yml/badge.svg)](https://github.com/albnnaardy11/dreampay_api/actions/workflows/deploy-docs.yml)
[![Node.js Version](https://img.shields.io/badge/node-%3E%3D22.0-brightgreen)](https://nodejs.org/)
[![Docusaurus](https://img.shields.io/badge/Docusaurus-3.9.2-blue)](https://docusaurus.io/)

Professional API documentation for DreamPay built with [Docusaurus](https://docusaurus.io/) and OpenAPI.

🌐 **Live Documentation:** [https://albnnaardy11.github.io/dreampay_api/](https://albnnaardy11.github.io/dreampay_api/)

## ✨ Features

- 📖 **Interactive API Documentation** - Auto-generated from OpenAPI spec
- 🎨 **Modern UI** - Beautiful dark mode support
- 🔍 **Full-text Search** - Find what you need quickly
- 📱 **Responsive Design** - Works on all devices
- 🚀 **Fast Performance** - Static site generation
- 🔄 **Auto Deployment** - GitHub Actions integration

## 🚀 Quick Start

### Prerequisites

- **Node.js** >= 22.0 (Recommended: 22.x LTS)
- **npm** or **yarn**

### Installation

```bash
# Navigate to docs directory
cd docs-site

# Install dependencies
npm install
```

### Local Development

```bash
# Start development server
npm start
```

This command starts a local development server at `http://localhost:3000` and opens up a browser window. Most changes are reflected live without having to restart the server.

## 🏗️ Build & Deployment

### Build for Production

```bash
# Build static files
npm run build

# Preview production build
npm run serve
```

The build output will be in the `build/` directory.

### Deploy to GitHub Pages

#### Automatic Deployment (Recommended)

Push to `main` branch to automatically trigger deployment via GitHub Actions:

```bash
git add .
git commit -m "Update documentation"
git push origin main
```

#### Manual Deployment

```bash
# Build and deploy in one command
npm run deploy:gh

# Or use the deployment script
# For Windows (PowerShell)
.\deploy.ps1

# For Linux/Mac (Bash)
./deploy.sh
```

## 📁 Project Structure

```
docs-site/
├── docs/                      # Documentation content
│   ├── intro.md              # Introduction page
│   ├── auth.md               # Authentication guide
│   ├── merchant.md           # Merchant endpoints
│   ├── santri.md             # Santri endpoints
│   ├── admin.md              # Admin endpoints
│   ├── security.md           # Security best practices
│   ├── deployment.md         # Deployment guide
│   └── api/                  # Auto-generated API docs
├── src/                      # Custom React components
│   ├── components/           # Reusable components
│   ├── css/                  # Custom styles
│   └── pages/                # Custom pages
├── static/                   # Static assets
│   ├── img/                  # Images
│   └── api-docs.json         # OpenAPI specification
├── .github/
│   └── workflows/
│       └── deploy-docs.yml   # GitHub Actions workflow
├── docusaurus.config.ts      # Docusaurus configuration
├── sidebars.ts               # Sidebar configuration
├── package.json              # Dependencies & scripts
├── deploy.sh                 # Bash deployment script
├── deploy.ps1                # PowerShell deployment script
└── DEPLOYMENT.md             # Detailed deployment guide
```

## 🛠️ Available Scripts

| Script | Description |
|--------|-------------|
| `npm start` | Start development server |
| `npm run build` | Build for production |
| `npm run build:prod` | Build with production optimizations |
| `npm run serve` | Preview production build locally |
| `npm run deploy` | Deploy to configured hosting |
| `npm run deploy:gh` | Build and deploy to GitHub Pages |
| `npm run clear` | Clear Docusaurus cache |
| `npm run gen-api-docs` | Generate API docs from OpenAPI spec |
| `npm run clean-api-docs` | Clean generated API docs |
| `npm run typecheck` | Run TypeScript type checking |

## 📝 Generate API Documentation

The API documentation is automatically generated from the OpenAPI/Swagger specification:

```bash
# Make sure Laravel API spec is up to date
cd ..
php artisan l5-swagger:generate

# Return to docs-site
cd docs-site

# Generate API documentation
npm run gen-api-docs

# If you need to regenerate
npm run clean-api-docs
npm run gen-api-docs
```

## 🌐 Deployment Options

### GitHub Pages (Current)

Automatically deployed via GitHub Actions when pushing to `main` branch.

**URL:** https://albnnaardy11.github.io/dreampay_api/

### Vercel

```bash
# Install Vercel CLI
npm i -g vercel

# Deploy
vercel
```

Configuration is already set in `vercel.json`.

### Netlify

```bash
# Build command
npm run build

# Publish directory
build
```

Configuration is already set in `netlify.toml`.

### Custom Server

```bash
# Build static files
npm run build

# Upload the 'build' folder to your web server
# Configure your web server to serve static files
```

## 🔧 Configuration

### GitHub Pages Setup

1. Go to repository **Settings** → **Pages**
2. Set **Source** to `gh-pages` branch
3. Set **folder** to `/ (root)`
4. Save changes

The site will be available at: `https://albnnaardy11.github.io/dreampay_api/`

### Custom Domain (Optional)

To use a custom domain:

1. Add `CNAME` file to `static/` folder with your domain
2. Update `url` and `baseUrl` in `docusaurus.config.ts`
3. Configure DNS settings at your domain provider

## 🐛 Troubleshooting

### Node.js Version Error

**Error:** `You are using Node.js v18.20.5. Requirement: Node.js >=22.0`

**Solution:**
```bash
# Upgrade to Node.js 22 or higher
nvm install 22
nvm use 22
node -v
```

### Build Fails

**Solution:**
```bash
# Clear cache and rebuild
npm run clear
rm -rf node_modules package-lock.json
npm install
npm run build
```

### Missing OpenAPI Spec

**Error:** Cannot find `../storage/api-docs/api-docs.json`

**Solution:**
```bash
# Generate from Laravel
cd ..
php artisan l5-swagger:generate
cd docs-site
```

### GitHub Actions Fails

**Solution:**
1. Check workflow logs in GitHub Actions tab
2. Ensure `GITHUB_TOKEN` has write permissions
3. Verify GitHub Pages is enabled in repository settings
4. Check that `gh-pages` branch exists

For more troubleshooting, see [DEPLOYMENT.md](./DEPLOYMENT.md)

## 📖 Documentation

- [Deployment Guide](./DEPLOYMENT.md) - Detailed deployment instructions
- [Docusaurus Documentation](https://docusaurus.io/docs)
- [OpenAPI Plugin](https://github.com/PaloAltoNetworks/docusaurus-openapi-docs)

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

Copyright © 2026 DreamPay. All rights reserved.

## 🆘 Support

If you encounter any issues:

1. Check [DEPLOYMENT.md](./DEPLOYMENT.md) for detailed guides
2. Review [Docusaurus Documentation](https://docusaurus.io/docs)
3. Create an issue in the repository
4. Contact the development team

---

Built with ❤️ using [Docusaurus](https://docusaurus.io/)
