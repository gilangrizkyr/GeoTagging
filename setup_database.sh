#!/bin/bash

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${GREEN}Starting Database Setup for GeoTagging App...${NC}"

# Check if PostgreSQL is running
if ! systemctl is-active --quiet postgresql; then
    echo -e "${RED}PostgreSQL is not running. Attempting to start...${NC}"
    sudo systemctl start postgresql
    if [ $? -ne 0 ]; then
        echo -e "${RED}Failed to start PostgreSQL. Please check your installation.${NC}"
        exit 1
    fi
fi

# Reset Password for 'postgres' user to 'postgres'
echo -e "${GREEN}Resetting PostgreSQL password for user 'postgres' to 'postgres'...${NC}"
echo "You may be asked for your sudo password."
sudo -u postgres psql -c "ALTER USER postgres PASSWORD 'postgres';"
if [ $? -eq 0 ]; then
    echo -e "${GREEN}Password reset successfully.${NC}"
else
    echo -e "${RED}Failed to reset password. Ensure you have sudo rights.${NC}"
    exit 1
fi

# Create Database and Extensions
echo -e "${GREEN}Creating database 'geotagging_db' and enabling PostGIS...${NC}"
sudo -u postgres psql -c "CREATE DATABASE geotagging_db;" 2>/dev/null
sudo -u postgres psql -d geotagging_db -c "CREATE EXTENSION IF NOT EXISTS postgis;"

# Run Migrations
echo -e "${GREEN}Running CodeIgniter Migrations...${NC}"
php spark migrate

# Run Seeds
echo -e "${GREEN}Seeding Admin User...${NC}"
php spark db:seed AdminSeeder

echo -e "${GREEN}Setup Complete! You can now run 'php spark serve'.${NC}"