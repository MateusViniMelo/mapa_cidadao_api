#!/bin/bash
set -e

# Esperar o PostgreSQL ficar disponível
until pg_isready -U "$POSTGRES_USER" -d "$POSTGRES_DB"; do
  echo "Aguardando o PostgreSQL iniciar..."
  sleep 2
done

# Criar o banco de testes, se ainda não existir
export PGPASSWORD="$POSTGRES_PASSWORD"

psql -U "$POSTGRES_USER" -d postgres -c "SELECT 1 FROM pg_database WHERE datname = 'laravel_test'" | grep -q 1 || \
psql -U "$POSTGRES_USER" -d postgres -c "CREATE DATABASE laravel_test"

# Ativar a extensão PostGIS no banco de testes
psql -U "$POSTGRES_USER" -d laravel_test -c "CREATE EXTENSION IF NOT EXISTS postgis"
