#!/bin/bash

seeder_directory="./database/seeders/"

# Check if a path was provided as an argument
if [ -z "$1" ]; then
  echo "Please provide the full path or filename."
  exit 1
fi

# Get the full file path or filename provided by the user
full_path="${seeder_directory}${1}.php"

# Extract the directory and filename from the provided path
directory=$(dirname "$full_path")
filename=$(basename "$full_path" .php)

# Get the current date and time in the format YYYYMMDDHHMMSS (without dashes or underscores)
datetime=$(date +"%Y%m%d%H%M%S")

# If no directory is provided (i.e., directory is "."), default to the current directory
if [ "$directory" = "." ]; then
  directory=$(pwd)  # Use the current working directory
fi

# Construct the new filename by prepending the date and time to the original filename
new_filename="${datetime}_create_${filename}_seeder.php"

# Create the file with the new filename in the specified or current directory
cat <<EOL > "$directory/$new_filename"
<?php

require_once "util/database/DbSeeder.php";

\$seeder = new DbSeeder('$filename');

\$$filename = [
    // Attributes here...
];

echo \$seeder->seed(\$$filename);
EOL

# Output a message to confirm file creation
printf "\nSeeder file '$directory/$new_filename' has been created."
