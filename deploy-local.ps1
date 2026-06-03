# ==========================================
# Local Deployment Test Script (Windows)
# ==========================================
# Script ini untuk test deployment di local
# sebelum push ke GitHub untuk deploy real
# ==========================================

Write-Host "🚀 Starting Local Deployment Test..." -ForegroundColor Cyan
Write-Host ""

# 1. Check PHP version
Write-Host "📌 Checking PHP version..." -ForegroundColor Yellow
$phpVersion = php -v 2>&1 | Select-String -Pattern "PHP (\d+\.\d+)" | ForEach-Object { $_.Matches.Groups[1].Value }
if ($phpVersion -ge 8.3) {
    Write-Host "✓ PHP version: $phpVersion (OK)" -ForegroundColor Green
} else {
    Write-Host "✗ PHP version: $phpVersion (Required: 8.3+)" -ForegroundColor Red
    exit 1
}

# 2. Install Composer dependencies
Write-Host ""
Write-Host "📦 Installing Composer dependencies..." -ForegroundColor Yellow
composer install --prefer-dist --no-dev --no-scripts --optimize-autoloader
if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ Composer dependencies installed" -ForegroundColor Green
} else {
    Write-Host "✗ Composer install failed" -ForegroundColor Red
    exit 1
}

# 3. Install NPM dependencies
Write-Host ""
Write-Host "📦 Installing NPM dependencies..." -ForegroundColor Yellow
npm ci
if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ NPM dependencies installed" -ForegroundColor Green
} else {
    Write-Host "✗ NPM install failed" -ForegroundColor Red
    exit 1
}

# 4. Build assets
Write-Host ""
Write-Host "🏗️  Building production assets..." -ForegroundColor Yellow
npm run build
if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ Assets built successfully" -ForegroundColor Green
} else {
    Write-Host "✗ Asset build failed" -ForegroundColor Red
    exit 1
}

# 5. Check .env file
Write-Host ""
Write-Host "🔍 Checking .env file..." -ForegroundColor Yellow
if (Test-Path .env) {
    Write-Host "✓ .env file exists" -ForegroundColor Green

    # Check APP_KEY
    $envContent = Get-Content .env -Raw
    if ($envContent -match "APP_KEY=base64:") {
        Write-Host "✓ APP_KEY is set" -ForegroundColor Green
    } else {
        Write-Host "⚠ APP_KEY not set, generating..." -ForegroundColor Yellow
        php artisan key:generate
    }
} else {
    Write-Host "✗ .env file not found" -ForegroundColor Red
    Write-Host "Creating .env from .env.example..." -ForegroundColor Yellow
    Copy-Item .env.example .env
    php artisan key:generate
}

# 6. Test Laravel installation
Write-Host ""
Write-Host "🧪 Testing Laravel installation..." -ForegroundColor Yellow
php artisan --version
if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ Laravel is working" -ForegroundColor Green
} else {
    Write-Host "✗ Laravel test failed" -ForegroundColor Red
    exit 1
}

# 7. Clear cache
Write-Host ""
Write-Host "🧹 Clearing cache..." -ForegroundColor Yellow
php artisan config:clear
php artisan route:clear
php artisan view:clear
Write-Host "✓ Cache cleared" -ForegroundColor Green

# 8. Create deployment summary
Write-Host ""
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "📊 Deployment Test Summary" -ForegroundColor Cyan
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "✓ PHP Version: $phpVersion" -ForegroundColor Green
Write-Host "✓ Composer Dependencies: Installed" -ForegroundColor Green
Write-Host "✓ NPM Dependencies: Installed" -ForegroundColor Green
Write-Host "✓ Production Assets: Built" -ForegroundColor Green
Write-Host "✓ Laravel: Working" -ForegroundColor Green
Write-Host "✓ Cache: Cleared" -ForegroundColor Green
Write-Host ""
Write-Host "🎉 Local deployment test completed successfully!" -ForegroundColor Green
Write-Host ""
Write-Host "Next steps:" -ForegroundColor Yellow
Write-Host "1. Test the application locally: php artisan serve"
Write-Host "2. If everything works, commit and push to GitHub"
Write-Host "3. GitHub Actions will automatically deploy to Rumahweb"
Write-Host ""
