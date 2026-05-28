<?php
require 'vendor/autoload.php';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('src'));
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        require_once $file->getPathname();
    }
}
echo 'All files loaded successfully.';
