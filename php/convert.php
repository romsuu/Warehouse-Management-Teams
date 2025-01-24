<?php
// Set the directory containing PHP files (Update if needed)
$directory = $_SERVER['DOCUMENT_ROOT'] . '/a2/php';  // Adjusted for your server setup

// Set the output file name
$outputFile = $_SERVER['DOCUMENT_ROOT'] . '/a2/combined.txt'; // Saves in /a2/

// Open the output file for writing
$outputHandle = fopen($outputFile, 'w');

if ($outputHandle === false) {
    die('❌ Failed to open output file for writing.');
}

// Read all PHP files from the directory
$files = glob($directory . '/*.php');

if (empty($files)) {
    die('⚠ No PHP files found in the specified directory.');
}

foreach ($files as $file) {
    // Get the file name
    $fileName = basename($file);

    // Read the content of each PHP file
    $content = file_get_contents($file);

    if ($content === false) {
        echo "⚠ Failed to read file: $file\n";
        continue;
    }

    // Write a separator header for clarity
    fwrite($outputHandle, "====================\n");
    fwrite($outputHandle, "FILE: $fileName\n");
    fwrite($outputHandle, "====================\n\n");
    
    // Write the content to the output file
    fwrite($outputHandle, $content . "\n\n");
}

// Close the output file
fclose($outputHandle);

echo "✅ All PHP files have been combined into: $outputFile\n";
?>
