#!/usr/bin/env bash
set -e

echo "==================================================="
echo "    Starting PojokKampus Marketplace (Docker)"
echo "==================================================="
echo ""

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo "[ERROR] Docker is not installed or not in PATH!"
    echo "Please install Docker Desktop or Docker Engine."
    exit 1
fi

# Ensure .env exists
if [ ! -f .env ]; then
    echo "[INFO] Creating .env from .env.docker..."
    cp .env.docker .env
fi

# Build and start containers
echo "[INFO] Building and starting Docker containers..."
if docker compose version &> /dev/null; then
    docker compose up -d --build
else
    docker-compose up -d --build
fi

echo ""
echo "==================================================="
echo "    PojokKampus is running successfully!"
echo "==================================================="
echo ""
echo "  * Main Application : http://localhost:8000"
echo "  * phpMyAdmin       : http://localhost:8080"
echo "  * Mailhog (Emails) : http://localhost:8025"
echo ""
echo "  Default Credentials:"
echo "  --------------------"
echo "  Admin  : admin@admin.com / admin123"
echo "  Seller : seller@test.com / seller123"
echo ""
echo "==================================================="
echo ""

# Try opening in browser if supported
if command -v xdg-open &> /dev/null; then
    xdg-open http://localhost:8000 &> /dev/null || true
elif command -v open &> /dev/null; then
    open http://localhost:8000 &> /dev/null || true
fi