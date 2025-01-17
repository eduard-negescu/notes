#!/bin/bash

# Load environment variables from .env file
if [ -f .env ]; then
    export $(grep -v '^#' .env | xargs)
else
    echo ".env file not found. Please create it with the necessary variables."
    exit 1
fi

echo "Are you using Docker or Podman to manage your containers? (Enter 'docker' or 'podman')"
read -r CONTAINER_TOOL

echo "Setting up the database in Docker container '$DB_CONTAINER_NAME'..."
$CONTAINER_TOOL exec -i notes_db_postgres psql -U $DB_USER -d $DB_NAME <<EOF

CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(10) DEFAULT 'user' CHECK (role IN ('user', 'admin'))
);

CREATE TABLE IF NOT EXISTS notes (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    priority INT DEFAULT 1 CHECK (priority BETWEEN 1 AND 5)
);

-- Add an admin user
CREATE EXTENSION IF NOT EXISTS pgcrypto;

DO \$\$
BEGIN
    IF NOT EXISTS (SELECT 1 FROM users WHERE email = '${ADMIN_EMAIL}') THEN
        INSERT INTO users (email, password, role)
        VALUES (
            '${ADMIN_EMAIL}',
            crypt('${ADMIN_PASSWORD}', gen_salt('bf')),
            'admin'
        );
    END IF;
END \$\$;
EOF