<?php

function zip_current_folder($zipFileName = 'archive.zip')
{
    $zip = new ZipArchive();

    if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        // Get all files in the current directory
        $files = glob('*');

        // Add each file to the zip
        foreach ($files as $file) {
            if (is_file($file) && $file != $zipFileName && $file != basename(__FILE__)) {
                $zip->addFile($file, $file);
            }
        }

        $zip->close();
        echo "ZIP file created successfully!\n";
    } else {
        echo "Failed to create ZIP file.\n";
    }
}

zip_current_folder('autoservis-wp-plugin.zip'); // Run the function
