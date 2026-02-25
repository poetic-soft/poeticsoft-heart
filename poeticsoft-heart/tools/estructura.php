<?php

// phpcs:ignoreFile

/**
 * Script Universal para generar el árbol de estructura del Plugin.
 */

if (php_sapi_name() !== 'cli') {
    die("Este script solo puede ejecutarse desde la terminal.\n");
}

function listFolder($dir, $basePath, $prefix = '')
{
    $excludePatterns = [
        'vendor',
        '.git',
        'node_modules',
        'storage',
        '.idea',
        '.vscode',
        'LICENSE',
        'languages',
        'tools'
    ];

    $excludeExtensions = [
        'log',
        'tmp',
        'cache',
        'md',
        'lock',
        'xml'
    ];

    if (!is_dir($dir)) {
        return "";
    }

    $items = scandir($dir);
    
    $filtered = array_values(
        array_filter(
            $items, 
            function ($file) use ($dir, $basePath, $excludePatterns, $excludeExtensions) {
                if ($file === '.' || $file === '..') {
                    return false;
                }

                $fullPath = $dir . DIRECTORY_SEPARATOR . $file;
                // Normalizamos a barras de Unix para comparar rutas
                $relativePath = str_replace([$basePath, DIRECTORY_SEPARATOR], ['', '/'], $fullPath);
                $relativePath = ltrim($relativePath, '/');

                // 1. Filtrar por extensión simple
                if (in_array(pathinfo($file, PATHINFO_EXTENSION), $excludeExtensions)) {
                    return false;
                }

                // 2. Comprobación de Patrones con soporte para subcarpetas (estilo .gitignore)
                foreach ($excludePatterns as $pattern) {
                    // Convertimos el patrón de usuario en una expresión regular
                    // Ej: "build/*.css" se convierte en algo que busca "build/CUALQUIER_COSA.css"
                    $regexPattern = str_replace(['/', '*'], ['\/', '[^\/]*'], $pattern);
                    
                    // Si coincide con el nombre exacto del archivo o carpeta
                    if ($file === $pattern) {
                        return false;
                    }

                    // Si la ruta relativa termina con el patrón indicado (ej: .../build/editor.css)
                    if (preg_match('/' . $regexPattern . '$/', $relativePath)) {
                        return false;
                    }
                }

                return true;
            }
        )
    );

    $output = "";
    foreach ($filtered as $index => $file) {
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        $isLast = ($index === count($filtered) - 1);
        
        $line = $prefix . ($isLast ? '└── ' : '├── ') . $file . PHP_EOL;
        $output .= $line;

        if (is_dir($path)) {
            $output .= listFolder(
                $path, 
                $basePath,
                $prefix . ($isLast ? '    ' : '│   ')
            );
        }
    }
    return $output;
}

// Configuración de rutas
$toolsDir   = __DIR__;
$pluginRoot = realpath(dirname($toolsDir));
$pluginName = basename($pluginRoot);

$header = "========================================\n";
$header .= "ESTRUCTURA DEL PROYECTO: " . strtoupper($pluginName) . "\n";
$header .= "Generado el: " . date('Y-m-d H:i:s') . "\n";
$header .= "========================================\n\n";

$body = listFolder($pluginRoot, $pluginRoot);
$fullContent = $header . $body;

echo $fullContent;

$outputFile = $toolsDir . DIRECTORY_SEPARATOR . $pluginName . '-estructura.txt';
file_put_contents($outputFile, $fullContent);

echo "\n[OK] Archivo generado: tools/" . $pluginName . "-estructura.txt\n";