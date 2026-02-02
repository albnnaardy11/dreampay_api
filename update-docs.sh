#!/bin/bash

# Update Documentation Script
# This script automates the process of generating OpenAPI specs and Docusaurus docs.

echo "🚀 Starting Documentation Update..."

# 1. Generate OpenAPI Spec from Laravel
echo "📂 Generating OpenAPI spec from Laravel..."
php artisan l5-swagger:generate

# 2. Sync Spec to docs-site (if needed, though Docusaurus is configured to read from storage)
# cp storage/api-docs/api-docs.json docs-site/static/openapi.json

# 3. Generate Docusaurus Markdown from OpenAPI
echo "📝 Generating Docusaurus API docs..."
cd docs-site
npm run clean-api-docs
npm run gen-api-docs

# 4. Build Docusaurus
echo "🏗️ Building Docusaurus site..."
npm run build

echo "✅ Documentation update complete locally!"

# 5. Git Sync (Optional)
read -p "Do you want to commit and push changes to GitHub? (y/n): " confirm
if [[ $confirm == [yY] || $confirm == [yY][eE][sS] ]]; then
    echo "📤 Syncing with GitHub..."
    cd ..
    git add .
    git commit -m "docs: auto-update api documentation"
    git push origin main
    echo "🚀 Changes pushed! GitHub Actions will now deploy the site."
else
    echo "💡 Skip GitHub sync. Don't forget to push manually later."
fi
