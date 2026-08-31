@echo off
echo Resetting and seeding PojokKampus database...
docker compose exec app php artisan migrate:fresh --seed
if %errorlevel% neq 0 (
    docker-compose exec app php artisan migrate:fresh --seed
)
echo.
echo Database refreshed and seeded successfully!
pause