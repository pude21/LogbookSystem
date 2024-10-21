# User Guide: start.sh Script

## Introduction

---

The `start.sh` script is a Bash script that provides a menu-driven interface for managing database operations. This user guide explains how to use the script to perform various database tasks.

## Prerequisites

---

- The script assumes that you have Bash installed on your system.
- The script uses PHP to drop the database, so you need to have PHP installed and configured on your system.
- The script uses shell scripts (`create/migration.sh`, `create/seeder.sh`, `database/db_migration.sh`, and `database/db_seeders.sh`) to perform database migration, seeding, and creation, respectively. These scripts should be located in the `scripts` directory.

## Usage

---

### 1. Open a terminal or git bash

### 2. Run the script by typing the following command.

    sh start.sh

### 3. The script will display a menu with the following options:

    Please select an option:
    1. Create Database Migration
    2. Create Database Seeder
    3. Create Both Database Migration and Seeder
    4. Database Drop
    5. Database Migration
    6. Database Seed
    7. Database Migration w/ Database Drop
    8. Database Migration w/ Database Seed
    9. Database Migration w/ Database Drop and Database Seed

### 4. Enter the number of your chosen option and press Enter.

### 5. Depending on the option chosen, the script may prompt you to:

- Enter a table name for database migration or seeding creation.
- Confirm your selection before proceeding with database drop, migration, or seeding.

## Options

---

### 1. Create Database Migration

- This option creates a new database migration file using the `create/migration.sh` script.
- The script will prompt you to select an option:
  ```bash
    Please select an option:
    1. Create Table
    2. Modify Table
    3. Delete Table
  ```

- The script will then prompt you to enter a table name.

### 2. Create Database Seeder

- This option creates a new database seeder file using the `create/seeder.sh` script.
- The script will prompt you to enter a table name.

### 3. Create Both Database Migration and Seeder

- This option creates both a new database migration file and a new database seeder file using the `./scripts/create/migration/create_table.sh` and `create/seeder.sh` scripts, respectively.
- The script will prompt you to enter a table name.

### 4. Database Drop

- This option drops the database using the `drop.php` script.
- The script will prompt you to confirm before proceeding.

### 5. Database Migration

- This option migrates the database using the `database/db_migration.sh` script.
- The script will prompt you to confirm before proceeding.

### 6. Database Seed

- This option seeds the database using the `database/db_seeders.sh` script.
- The script will prompt you to confirm before proceeding.

### 7. Database Migration w/ Database Drop

- This option drops the database using the `drop.php` script and then migrates the database using the `database/db_migration.sh` script.
- The script will prompt you to confirm before proceeding.

### 8. Database Migration w/ Database Seed

- This option migrates the database using the `database/db_migration.sh` script and then seeds the database using the `database/db_seeders.sh` script.
- The script will prompt you to confirm before proceeding.

### 9. Database Migration w/ Database Drop and Database Seed

- This option drops the database using the `drop.php` script, migrates the database using the `database/db_migration.sh` script, and then seeds the database using the `database/db_seeders.sh` script.
- The script will prompt you to confirm before proceeding.

## Troubleshooting

---

- If you encounter any issues while running the script, check the script's output for error messages.
- Make sure that the `create/migration.sh`, `create/seeder.sh`, `database/db_migration.sh`, and `database/db_seeders.sh` scripts are located in the `scripts` directory.
- Make sure that PHP is installed and configured correctly on your system.
