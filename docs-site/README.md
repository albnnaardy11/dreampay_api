# DreamPay Documentation

This documentation site is built using [Docusaurus](https://docusaurus.io/), a modern static website generator.

## Installation

```bash
npm install
```

## Local Development

```bash
npm start
```

This command starts a local development server and opens up a browser window. Most changes are reflected live without having to restart the server.

## Build

```bash
npm run build
```

This command generates static content into the `build` directory and can be served using any static contents hosting service.

## Generate API Documentation

The API documentation is automatically generated from the OpenAPI/Swagger spec:

```bash
# Copy latest API spec from Laravel
cp ../storage/api-docs/api-docs.json static/

# Generate API docs
npm run gen-api-docs
```

## Deployment

The documentation is automatically deployed to GitHub Pages when you push to the `main` branch via GitHub Actions.

Manual deployment:
```bash
npm run deploy
```

## Project Structure

```
docs-site/
├── docs/               # Manual documentation
│   ├── intro.md
│   ├── auth.md
│   ├── merchant.md
│   ├── santri.md
│   ├── admin.md
│   ├── security.md
│   └── deployment.md
├── static/             # Static assets
│   └── api-docs.json   # OpenAPI spec from Laravel
├── src/                # React components
└── docusaurus.config.ts
```
