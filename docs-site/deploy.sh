#!/bin/bash

# DreamPay Documentation Deployment Script
# This script helps deploy documentation to various platforms

set -e  # Exit on error

echo "🚀 DreamPay Documentation Deployment"
echo "===================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_info() {
    echo -e "${YELLOW}ℹ $1${NC}"
}

# Check Node.js version
check_node_version() {
    print_info "Checking Node.js version..."
    NODE_VERSION=$(node -v | cut -d'v' -f2 | cut -d'.' -f1)
    
    if [ "$NODE_VERSION" -lt 22 ]; then
        print_error "Node.js version must be >= 22.0"
        print_info "Current version: $(node -v)"
        print_info "Please upgrade Node.js to v22 or higher"
        print_info "Run: nvm install 22 && nvm use 22"
        exit 1
    fi
    
    print_success "Node.js version OK: $(node -v)"
}

# Clean build
clean_build() {
    print_info "Cleaning previous build..."
    npm run clear || true
    rm -rf build node_modules/.cache
    print_success "Clean completed"
}

# Install dependencies
install_deps() {
    print_info "Installing dependencies..."
    npm install
    print_success "Dependencies installed"
}

# Build documentation
build_docs() {
    print_info "Building documentation..."
    npm run build
    print_success "Build completed"
}

# Test build locally
test_build() {
    print_info "Testing build locally..."
    print_info "Starting local server on http://localhost:3000"
    npm run serve
}

# Deploy to GitHub Pages
deploy_github() {
    print_info "Deploying to GitHub Pages..."
    npm run deploy:gh
    print_success "Deployed to GitHub Pages"
    print_info "Visit: https://albnnaardy11.github.io/dreampay_api/"
}

# Main menu
show_menu() {
    echo ""
    echo "Select deployment option:"
    echo "1) Clean build"
    echo "2) Install dependencies"
    echo "3) Build documentation"
    echo "4) Test build locally"
    echo "5) Deploy to GitHub Pages"
    echo "6) Full deployment (clean + install + build + deploy)"
    echo "7) Exit"
    echo ""
    read -p "Enter option [1-7]: " option
    
    case $option in
        1)
            clean_build
            show_menu
            ;;
        2)
            install_deps
            show_menu
            ;;
        3)
            build_docs
            show_menu
            ;;
        4)
            test_build
            ;;
        5)
            deploy_github
            show_menu
            ;;
        6)
            check_node_version
            clean_build
            install_deps
            build_docs
            deploy_github
            print_success "Full deployment completed!"
            ;;
        7)
            print_info "Goodbye!"
            exit 0
            ;;
        *)
            print_error "Invalid option"
            show_menu
            ;;
    esac
}

# Run
check_node_version
show_menu
