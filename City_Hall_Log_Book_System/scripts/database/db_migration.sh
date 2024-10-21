#!/bin/bash

DIRECTORY="./database/migrations"

for file in "$DIRECTORY"/*.php; do
    if [ -f "$file" ]; then
        php "$file"
    fi
done
