#!/bin/bash

echo "Please select an option:"
echo "1. Create Database Migration"
echo "2. Create Database Seeder"
echo "3. Create Both Database Migration and Seeder"
echo "4. Database Drop"
echo "5. Database Migration"
echo "6. Database Seed"
echo "7. Database Migration w/ Database Drop"
echo "8. Database Migration w/ Database Seed"
echo "9. Database Migration w/ Database Drop and Database Seed"

read -p "Enter your choice: " option

case $option in
1)
    sh ./scripts/create/migration.sh
    ;;
2)
    read -p "Enter table name: " table
    sh ./scripts/create/seeder.sh $table
    ;;
3)
    read -p "Enter table name: " table
    sh ./scripts/create/migration/create_table.sh $table
    sh ./scripts/create/seeder.sh $table
    ;;
4)
    read -p "Are you sure you want to drop the database? (y/n) " -n 1 -r
    echo    # (optional) move to a new line
    if [[ $REPLY =~ ^[Yy]$ ]]
    then
        echo "Dropping the Database";
        php ./database/drop.php
    else
        echo "Drop cancelled."
    fi
    ;;
5)
    read -p "Are you sure you want to migrate the database? (y/n) " -n 1 -r
    echo    # (optional) move to a new line
    if [[ $REPLY =~ ^[Yy]$ ]]
    then
        echo "Migrating Database";
        sh ./scripts/database/db_migration.sh
        echo "Database Migration Complete";
    else
        echo "Migration cancelled."
    fi
    ;;
6)
    read -p "Are you sure you want to seed the database? (y/n) " -n 1 -r
    echo    # (optional) move to a new line
    if [[ $REPLY =~ ^[Yy]$ ]]
    then
        echo "Seeding Database";
        sh ./scripts/database/db_seeders.sh
        echo "Database Seeding Complete";
    else
        echo "Seeding cancelled."
    fi
    ;;
7)
    read -p "Are you sure you want to migrate the database with drop? (y/n) " -n 1 -r
    echo    # (optional) move to a new line
    if [[ $REPLY =~ ^[Yy]$ ]]
    then
        echo "Dropping the Database";
        php ./database/drop.php
        echo "";
        echo "Migrating Database";
        sh ./scripts/database/db_migration.sh
        echo "Database Migration Complete";
    else
        echo "Migration with drop cancelled."
    fi
    ;;
8)
    read -p "Are you sure you want to migrate the database with seed? (y/n) " -n 1 -r
    echo    # (optional) move to a new line
    if [[ $REPLY =~ ^[Yy]$ ]]
    then
        echo "Migrating Database";
        sh ./scripts/database/db_migration.sh
        echo "Database Migration Complete";
        echo "";
        echo "Seeding Database";
        sh ./scripts/database/db_seeders.sh
        echo "Database Seeding Complete";
    else
        echo "Migration with seed cancelled."
    fi
    ;;
9)
    read -p "Are you sure you want to migrate the database with drop and seed? (y/n) " -n 1 -r
    echo    # (optional) move to a new line
    if [[ $REPLY =~ ^[Yy]$ ]]
    then
        echo "Dropping the Database";
        php ./database/drop.php
        echo "";
        echo "Migrating Database";
        sh ./scripts/database/db_migration.sh
        echo "Database Migration Complete";
        echo "";
        echo "Seeding Database";
        sh ./scripts/database/db_seeders.sh
        echo "Database Seeding Complete";
    else
        echo "Migration with drop and seed cancelled."
    fi
    ;;
*)
    echo "Invalid option. Please enter a number between 1 and 9."
    ;;
esac