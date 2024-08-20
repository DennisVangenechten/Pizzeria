<?php
spl_autoload_register(function ($className) {
    // Converteer de klassenaam naar het bestandspad
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    // Zoek het bestand en laad het als het bestaat
    $file = __DIR__ . '/' . $className . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
