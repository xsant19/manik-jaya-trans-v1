#!/bin/bash

# ==========================================
# Local Deployment Test Script
# ==========================================
# Script ini untuk test deployment di local
# sebelum push ke GitHub untuk deploy real
# ==========================================

echo "🚀 Starting Local Deployment Test..."
echo ""

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# 1. Check PHP version
echo "📌 Checking PHP version..."
php_version=$(php -v | head -n 1 | cut -d " " -f 2 | cut -d "." -f 1,2)
if (( $(echo "$php_version >= 8.3" | bc -l) )); then
    echo -e "${GREEN}✓ PHP version: $php_version (OK)${NC}"
else
    echo -e "${RED}✗ PHP version: $php_version (Required: 8.3+)${NC}"
    exit 1
fi

# 2. Install Composer dependencies
echo ""
echo "📦 Installing Composer dependencies..."
if composer install --prefer-dist --no-dev --no-scripts --optimize-autoloader; then
    echo -e "${GREEN}✓ Composer dependencies installed${NC}"
else
    echo -e "${RED}✗ Composer install failed${NC}"
    exit 1
fi

# 3. Install NPM dependencies
echo ""
echo "📦 Installing NPM dependencies..."
if npm ci; then
    echo -e "${GREEN}✓ NPM dependencies installed${NC}"
else
    echo -e "${RED}✗ NPM install failed${NC}"
    exit 1
fi

# 4. Build assets
echo ""
echo "🏗️  Building production assets..."
if npm run build; then
    echo -e "${GREEN}✓ Assets built successfully${NC}"
else
    echo -e "${RED}✗ Asset build failed${NC}"
    exit 1
fi

# 5. Check .env file
echo ""
echo "🔍 Checking .env file..."
if [ -f .env ]; then
    echo -e "${GREEN}✓ .env file exists${NC}"

    # Check APP_KEY
    if grep -q "APP_KEY=base64:" .env; then
        echo -e "${GREEN}✓ APP_KEY is set${NC}"
    else
        echo -e "${YELLOW}⚠ APP_KEY not set, generating...${NC}"
        php artisan key:generate
    fi
else
    echo -e "${RED}✗ .env file not found${NC}"
    echo -e "${YELLOW}Creating .env from .env.example...${NC}"
    cp .env.example .env
    php artisan key:generate
fi

# 6. Test Laravel installation
echo ""
echo "🧪 Testing Laravel installation..."
if php artisan --version; then
    echo -e "${GREEN}✓ Laravel is working${NC}"
else
    echo -e "${RED}✗ Laravel test failed${NC}"
    exit 1
fi

# 7. Check folder permissions
echo ""
echo "🔐 Checking folder permissions..."
if [ -w "storage" ] && [ -w "bootstrap/cache" ]; then
    echo -e "${GREEN}✓ Storage and bootstrap/cache are writable${NC}"
else
    echo -e "${YELLOW}⚠ Setting permissions...${NC}"
    chmod -R 755 storage bootstrap/cache
    echo -e "${GREEN}✓ Permissions set${NC}"
fi

# 8. Clear cache
echo ""
echo "🧹 Clearing cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo -e "${GREEN}✓ Cache cleared${NC}"

# 9. Create deployment summary
echo ""
echo "=========================================="
echo "📊 Deployment Test Summary"
echo "=========================================="
echo -e "${GREEN}✓ PHP Version: $php_version${NC}"
echo -e "${GREEN}✓ Composer Dependencies: Installed${NC}"
echo -e "${GREEN}✓ NPM Dependencies: Installed${NC}"
echo -e "${GREEN}✓ Production Assets: Built${NC}"
echo -e "${GREEN}✓ Laravel: Working${NC}"
echo -e "${GREEN}✓ Permissions: Set${NC}"
echo -e "${GREEN}✓ Cache: Cleared${NC}"
echo ""
echo -e "${GREEN}🎉 Local deployment test completed successfully!${NC}"
echo ""
echo "Next steps:"
echo "1. Test the application locally: php artisan serve"
echo "2. If everything works, commit and push to GitHub"
echo "3. GitHub Actions will automatically deploy to Rumahweb"
echo ""
