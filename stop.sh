#!/usr/bin/env bash
echo "Stopping PojokKampus Docker containers..."
if docker compose version &> /dev/null; then
    docker compose down
else
    docker-compose down
fi
echo "PojokKampus stopped."