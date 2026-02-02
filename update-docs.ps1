# Update Documentation Script (PowerShell)
# This script automates the process of generating OpenAPI specs and Docusaurus docs.

Write-Host "🚀 Starting Documentation Update..." -ForegroundColor Cyan

# 1. Generate OpenAPI Spec from Laravel
Write-Host "📂 Generating OpenAPI spec from Laravel..." -ForegroundColor Yellow
php artisan l5-swagger:generate

# 2. Generate Docusaurus Markdown from OpenAPI
Write-Host "📝 Generating Docusaurus API docs..." -ForegroundColor Yellow
Set-Location docs-site
npm run clean-api-docs
npm run gen-api-docs

# 3. Build Docusaurus
Write-Host "🏗️ Building Docusaurus site..." -ForegroundColor Yellow
npm run build

Set-Location ..

Write-Host "✅ Documentation update complete locally!" -ForegroundColor Green

# 4. Git Sync (Optional)
$confirm = Read-Host "Do you want to commit and push changes to GitHub? (y/n)"
if ($confirm -eq 'y' -or $confirm -eq 'yes') {
    Write-Host "📤 Syncing with GitHub..." -ForegroundColor Cyan
    git add .
    git commit -m "docs: auto-update api documentation"
    git push origin main
    Write-Host "🚀 Changes pushed! GitHub Actions will now deploy the site." -ForegroundColor Green
} else {
    Write-Host "💡 Skip GitHub sync. Don't forget to push manually later." -ForegroundColor Gray
}
