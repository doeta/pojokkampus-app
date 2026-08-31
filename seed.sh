#!/usr/bin/env bash
echo "Resetting and seeding PojokKampus database..."
if docker compose version &> /dev/null; then
    docker compose exec app php artisan migrate:fresh --seed
else
    docker-compose exec app php artisan migrate:fresh --seed
fi
echo ""
echo "Database refreshed and seeded successfully!"