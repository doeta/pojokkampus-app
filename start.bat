@echo off
setlocal enabledelayedexpansion

echo ===================================================
echo     Starting PojokKampus Marketplace (Docker)
echo ===================================================
echo.

:: Check if Docker is installed
where docker >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] Docker is not installed or not in PATH!
    echo Please install Docker Desktop from https://www.docker.com/products/docker-desktop
    echo.
    pause
    exit /b 1
)

:: Check if Docker daemon is running
docker info >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERROR] Docker daemon is not running!
    echo Please start Docker Desktop and try running this script again.
    echo.
    pause
    exit /b 1
)

:: Ensure .env exists
if not exist .env (
    echo [INFO] Creating .env from .env.docker...
    copy .env.docker .env >nul
)

:: Build and start containers
echo [INFO] Building and starting Docker containers...
docker compose up -d --build
if %errorlevel% neq 0 (
    echo [WARNING] Trying legacy docker-compose command...
    docker-compose up -d --build
)

echo.
echo ===================================================
echo     PojokKampus is running successfully!
echo ===================================================
echo.
echo   * Main Application : http://localhost:8000
echo   * phpMyAdmin       : http://localhost:8080
echo   * Mailhog (Emails) : http://localhost:8025
echo.
echo   Default Credentials:
echo   --------------------
echo   Admin  : admin@admin.com / admin123
echo   Seller : seller@test.com / seller123
echo.
echo ===================================================
echo.

:: Open browser automatically
start http://localhost:8000

echo Press any key to exit this window (containers will keep running in background)...
pause >nul
