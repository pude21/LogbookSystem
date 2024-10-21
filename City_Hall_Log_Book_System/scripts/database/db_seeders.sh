#!/bin/bash

DIRECTORY="./database/seeders"

for file in "$DIRECTORY"/*.php; do
    if [ -f "$file" ]; then
        php "$file"
    fi
done
