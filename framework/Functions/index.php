<?php
function getPhpFiles($dir) {
    $files = [];

    // Busca los archivos directamente en el directorio actual
    foreach (glob($dir . '/*.php') as $file) {
        $files[] = $file;
    }

    // Busca subdirectorios y llama recursivamente a esta función
    foreach (glob($dir . '/*', GLOB_ONLYDIR) as $subdir) {
        $files = array_merge($files, getPhpFiles($subdir));
    }

    return $files;
}