# DreamPay Documentation Deployment Script (PowerShell)
# This script helps deploy documentation to various platforms

$ErrorActionPreference = "Stop"

Write-Host "🚀 DreamPay Documentation Deployment" -ForegroundColor Cyan
Write-Host "====================================" -ForegroundColor Cyan
Write-Host ""

# Function to print colored output
function Print-Success {
    param([string]$Message)
    Write-Host "✓ $Message" -ForegroundColor Green
}

function Print-Error {
    param([string]$Message)
    Write-Host "✗ $Message" -ForegroundColor Red
}

function Print-Info {
    param([string]$Message)
    Write-Host "ℹ $Message" -ForegroundColor Yellow
}

# Check Node.js version
function Check-NodeVersion {
    Print-Info "Checking Node.js version..."
    
    try {
        $nodeVersion = node -v
        $versionNumber = [int]($nodeVersion -replace 'v(\d+)\..*', '$1')
        
        if ($versionNumber -lt 22) {
            Print-Error "Node.js version must be >= 22.0"
            Print-Info "Current version: $nodeVersion"
            Print-Info "Please upgrade Node.js to v22 or higher"
            Print-Info "Download from: https://nodejs.org/"
            Print-Info "Or run: nvm install 22 && nvm use 22"
            exit 1
        }
        
        Print-Success "Node.js version OK: $nodeVersion"
    }
    catch {
        Print-Error "Node.js not found. Please install Node.js >= 22.0"
        Print-Info "Download from: https://nodejs.org/"
        exit 1
    }
}

# Clean build
function Clean-Build {
    Print-Info "Cleaning previous build..."
    
    try {
        npm run clear
    }
    catch {
        Print-Info "Clear command not available, skipping..."
    }
    
    if (Test-Path "build") {
        Remove-Item -Recurse -Force "build"
    }
    
    if (Test-Path "node_modules\.cache") {
        Remove-Item -Recurse -Force "node_modules\.cache"
    }
    
    Print-Success "Clean completed"
}

# Install dependencies
function Install-Dependencies {
    Print-Info "Installing dependencies..."
    npm install
    Print-Success "Dependencies installed"
}

# Build documentation
function Build-Documentation {
    Print-Info "Building documentation..."
    npm run build
    Print-Success "Build completed"
}

# Test build locally
function Test-Build {
    Print-Info "Testing build locally..."
    Print-Info "Starting local server on http://localhost:3000"
    npm run serve
}

# Deploy to GitHub Pages
function Deploy-GitHub {
    Print-Info "Deploying to GitHub Pages..."
    npm run deploy:gh
    Print-Success "Deployed to GitHub Pages"
    Print-Info "Visit: https://albnnaardy11.github.io/dreampay_api/"
}

# Full deployment
function Full-Deployment {
    Check-NodeVersion
    Clean-Build
    Install-Dependencies
    Build-Documentation
    Deploy-GitHub
    Print-Success "Full deployment completed!"
}

# Main menu
function Show-Menu {
    Write-Host ""
    Write-Host "Select deployment option:" -ForegroundColor Cyan
    Write-Host "1) Clean build"
    Write-Host "2) Install dependencies"
    Write-Host "3) Build documentation"
    Write-Host "4) Test build locally"
    Write-Host "5) Deploy to GitHub Pages"
    Write-Host "6) Full deployment (clean + install + build + deploy)"
    Write-Host "7) Exit"
    Write-Host ""
    
    $option = Read-Host "Enter option [1-7]"
    
    switch ($option) {
        "1" {
            Clean-Build
            Show-Menu
        }
        "2" {
            Install-Dependencies
            Show-Menu
        }
        "3" {
            Build-Documentation
            Show-Menu
        }
        "4" {
            Test-Build
        }
        "5" {
            Deploy-GitHub
            Show-Menu
        }
        "6" {
            Full-Deployment
        }
        "7" {
            Print-Info "Goodbye!"
            exit 0
        }
        default {
            Print-Error "Invalid option"
            Show-Menu
        }
    }
}

# Run
Check-NodeVersion
Show-Menu
