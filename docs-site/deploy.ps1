# DreamPay Documentation Deployment Script (PowerShell)
# This script helps deploy documentation to various platforms

$ErrorActionPreference = "Stop"

Write-Host "🚀 DreamPay Documentation Deployment" -ForegroundColor Cyan
Write-Host "====================================" -ForegroundColor Cyan
Write-Host ""

# Function to print colored output
function Write-Success {
    param([string]$Message)
    Write-Host "✓ $Message" -ForegroundColor Green
}

function Write-ErrorMessage {
    param([string]$Message)
    Write-Host "✗ $Message" -ForegroundColor Red
}

function Write-Info {
    param([string]$Message)
    Write-Host "ℹ $Message" -ForegroundColor Yellow
}

# Check Node.js version
function Test-NodeVersion {
    Write-Info "Checking Node.js version..."
    
    try {
        $nodeVersion = node -v
        $versionNumber = [int]($nodeVersion -replace 'v(\d+)\..*', '$1')
        
        if ($versionNumber -lt 22) {
            Write-ErrorMessage "Node.js version must be >= 22.0"
            Write-Info "Current version: $nodeVersion"
            Write-Info "Please upgrade Node.js to v22 or higher"
            Write-Info "Download from: https://nodejs.org/"
            Write-Info "Or run: nvm install 22 && nvm use 22"
            exit 1
        }
        
        Write-Success "Node.js version OK: $nodeVersion"
    }
    catch {
        Write-ErrorMessage "Node.js not found. Please install Node.js >= 22.0"
        Write-Info "Download from: https://nodejs.org/"
        exit 1
    }
}

# Clear build
function Clear-BuildCache {
    Write-Info "Cleaning previous build..."
    
    try {
        npm run clear
    }
    catch {
        Write-Info "Clear command not available, skipping..."
    }
    
    if (Test-Path "build") {
        Remove-Item -Recurse -Force "build"
    }
    
    if (Test-Path "node_modules\.cache") {
        Remove-Item -Recurse -Force "node_modules\.cache"
    }
    
    Write-Success "Clean completed"
}

# Install dependencies
function Install-Dependencies {
    Write-Info "Installing dependencies..."
    npm install
    Write-Success "Dependencies installed"
}

# Build documentation
function Build-Documentation {
    Write-Info "Building documentation..."
    npm run build
    Write-Success "Build completed"
}

# Test build locally
function Test-BuildLocally {
    Write-Info "Testing build locally..."
    Write-Info "Starting local server on http://localhost:3000"
    npm run serve
}

# Deploy to GitHub Pages
function Invoke-GitHubDeploy {
    Write-Info "Deploying to GitHub Pages..."
    npm run deploy:gh
    Write-Success "Deployed to GitHub Pages"
    Write-Info "Visit: https://albnnaardy11.github.io/dreampay_api/"
}

# Full deployment
function Start-FullDeployment {
    Test-NodeVersion
    Clear-BuildCache
    Install-Dependencies
    Build-Documentation
    Invoke-GitHubDeploy
    Write-Success "Full deployment completed!"
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
            Clear-BuildCache
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
            Test-BuildLocally
        }
        "5" {
            Invoke-GitHubDeploy
            Show-Menu
        }
        "6" {
            Start-FullDeployment
        }
        "7" {
            Write-Info "Goodbye!"
            exit 0
        }
        default {
            Write-ErrorMessage "Invalid option"
            Show-Menu
        }
    }
}

# Run
Test-NodeVersion
Show-Menu
