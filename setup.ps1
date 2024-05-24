# Set variables
$APP_ENV = "local"
$DB_HOST = "127.0.0.1"
$DB_PORT = "3306"
$DB_DATABASE = "app_analysis"
$DB_USERNAME = "root"
$DB_PASSWORD = ""

# Update system (requires administrator privileges)
# Install necessary packages using Chocolatey (ensure Chocolatey is installed)
Set-ExecutionPolicy Bypass -Scope Process -Force
if (-Not (Get-Command choco -ErrorAction SilentlyContinue)) {
    Set-ExecutionPolicy AllSigned
    Set-ExecutionPolicy RemoteSigned
    iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))
}

# Install PHP, Composer, Node.js
choco install php -y
choco install composer -y
choco install nodejs -y

# Ensure PHP is in PATH
$env:Path += ";C:\tools\php"

# Copy .env.example to .env and update environment variables
if (-Not (Test-Path -Path ".env")) {
    Copy-Item -Path ".env.example" -Destination ".env"
    (Get-Content -Path ".env") -replace "DB_HOST=.*", "DB_HOST=$DB_HOST" |
                               -replace "DB_PORT=.*", "DB_PORT=$DB_PORT" |
                               -replace "DB_DATABASE=.*", "DB_DATABASE=$DB_DATABASE" |
                               -replace "DB_USERNAME=.*", "DB_USERNAME=$DB_USERNAME" |
                               -replace "DB_PASSWORD=.*", "DB_PASSWORD=$DB_PASSWORD" |
                               Set-Content -Path ".env"
}

# Install PHP dependencies
composer install

# Generate application key
php artisan key:generate

# Run migrations and seed the database
php artisan migrate --seed

# Install JavaScript dependencies
npm install

# Build assets
npm run build

# Set permissions for storage and cache
# Not typically needed on Windows, but ensure directories exist
if (-Not (Test-Path -Path "storage")) {
    New-Item -ItemType Directory -Path "storage"
}

if (-Not (Test-Path -Path "bootstrap/cache")) {
    New-Item -ItemType Directory -Path "bootstrap/cache"
}

Write-Output "Laravel setup is complete!"