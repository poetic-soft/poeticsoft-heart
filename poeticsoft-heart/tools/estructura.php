<?php

// phpcs:ignoreFile

/**
 * Script Universal para generar el árbol de estructura del Plugin.
 * El archivo de salida se guarda en tools/ con el nombre del plugin.
 */

// Seguridad: Solo permitir ejecución desde la terminal
if (php_sapi_name() !== 'cli') {
    die("Este script solo puede ejecutarse desde la terminal.\n");
}

function listFolder($dir, $prefix = '')
{
    $excludeNames = [
        'vendor',
        '.git',
        'node_modules',
        'storage',
        '.idea',
        '.vscode',
        'LICENSE',
        'languages',
        'block',
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
    
    $output = "";
    if (!is_dir($dir)) {
        return "";
    }

    $items = scandir($dir);
    $filtered = array_values(
        array_filter(
            $items, 
            function ($file) use ($excludeNames, $excludeExtensions) {
                if ($file === '.' || $file === '..') {
                    return false;
                }
                
                // Excluir carpetas/archivos prohibidos y archivos de texto generados
                if (in_array($file, $excludeNames) || pathinfo($file, PATHINFO_EXTENSION) === 'txt') {
                    return false;
                }
                
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if (in_array($ext, $excludeExtensions)) {
                    return false;
                }
                
                return true;
            }
        )
    );

    foreach ($filtered as $index => $file) {
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        $isLast = ($index === count($filtered) - 1);
        
        $line = $prefix . ($isLast ? '└── ' : '├── ') . $file . PHP_EOL;
        $output .= $line;

        if (is_dir($path)) {
            $output .= listFolder(
                $path, 
                $prefix . ($isLast ? '    ' : '│   ')
            );
        }
    }
    return $output;
}

// 1. Configuración de rutas y nombres dinámicos
$toolsDir   = __DIR__;
$pluginRoot = dirname($toolsDir);
$pluginName = basename($pluginRoot);

$header = "========================================\n";
$header .= "ESTRUCTURA DEL PROYECTO: " . strtoupper($pluginName) . "\n";
$header .= "Generado el: " . date('Y-m-d H:i:s') . "\n";
$header .= "========================================\n\n";

// 2. Generar el contenido
$body = listFolder($pluginRoot);
$fullContent = $header . $body;

// 3. Mostrarlo en la terminal
echo $fullContent;

// 4. Guardarlo en /tools/nombre-del-plugin-estructura.txt
$outputFile = $toolsDir . DIRECTORY_SEPARATOR . $pluginName . '-estructura.txt';
file_put_contents($outputFile, $fullContent);

echo "\n[OK] Archivo generado: tools/" . $pluginName . "-estructura.txt\n";