#!/bin/bash

echo "Please select an option:"
echo "1. Create Table"
echo "2. Modify Table"
echo "3. Delete Table"

read -p "Enter your choice: " option

read -p "Enter table name: " table

case $option in
1)
    sh ./scripts/create/migration/create_table.sh $table
    ;;
2)
    sh ./scripts/create/migration/modify_table.sh $table
    ;;
3)
    sh ./scripts/create/migration/delete_table.sh $table
    ;;
*)
    echo "Invalid option. Please enter a number between 1 and 3."
    ;;
esac