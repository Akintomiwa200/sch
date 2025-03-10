<?php
// Function to load environment variables from a .env file
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        throw new Exception('Environment file not found!');
    }

    // Read the file
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Parse the file into an associative array
    $env = [];
    foreach ($lines as $line) {
        // Ignore comments (lines starting with #)
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Split the line into key-value pairs
        list($key, $value) = explode('=', $line, 2);

        // Trim spaces and remove any surrounding quotes
        $env[trim($key)] = trim($value, ' "');
    }

    return $env;
}

// Load environment variables from the .env file
$env = loadEnv(__DIR__ . '/.env');

// Now you can access the environment variables like so:
$dbHost = $env['DB_HOST'];
$dbUsername = $env['DB_USERNAME'];
$dbPassword = $env['DB_PASSWORD'];
$dbDatabase = $env['DB_DATABASE'];

// Connect to the database using mysqli
$link = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbDatabase);

// Check the connection
if (!$link) {
    // Output the error and terminate if the connection fails
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully!";
