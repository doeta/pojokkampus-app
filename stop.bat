@echo off
echo Stopping PojokKampus Docker containers...
docker compose down
if %errorlevel% neq 0 (
    docker-compose down
)
echo PojokKampus stopped.
pause