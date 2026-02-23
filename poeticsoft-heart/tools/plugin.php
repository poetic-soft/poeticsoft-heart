<?php

// phpcs:ignoreFile

/**
 * Script Universal para mapear el código del Plugin.
 * El archivo de salida tendrá el nombre de la carpeta del plugin.
 */

if (php_sapi_name() !== 'cli') {
    die("Este script solo puede ejecutarse desde la terminal.\n");
}

function getFileContent($path, $pluginRoot)
{
    $relativePath = str_replace($pluginRoot . DIRECTORY_SEPARATOR, '', $path);
    
    $output = $relativePath . PHP_EOL;
    $output .= str_repeat('-', 46) . PHP_EOL;
    $output .= "Archivo: " . $relativePath . PHP_EOL;
    $output .= str_repeat('-', 46) . PHP_EOL . PHP_EOL;
    
    $output .= file_get_contents($path) . PHP_EOL;
    $output .= PHP_EOL . str_repeat('=', 60) . PHP_EOL . PHP_EOL;
    
    return $output;
}

function scanMap($dir, $pluginRoot)
{
    $output = "";
    $items = scandir($dir);

    foreach ($items as $item) {
        if (in_array($item, ['.', '..', 'vendor', 'tools', 'node_modules', 'assets', 'build'])) {
            continue;
        }

        $path = $dir . DIRECTORY_SEPARATOR . $item;

        if (is_dir($path)) {
            if ($dir !== $pluginRoot || $item === 'class') {
                $output .= scanMap($path, $pluginRoot);
            }
        } else {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $fileName = basename($path);

            if ($ext === 'php' || $fileName === 'composer.json') {
                // Evitar mapear archivos de texto de salida anteriores
                if ($ext === 'php' && $fileName !== 'forge-map.php') {
                    $output .= getFileContent($path, $pluginRoot);
                }
            }
        }
    }
    return $output;
}

// 1. Configuración de rutas y nombres
$toolsDir   = __DIR__;
$pluginRoot = dirname($toolsDir);
$pluginName = basename($pluginRoot); // Extrae el nombre de la carpeta del plugin

$header = "============================================================\n";
$header .= "CÓDIGO INTEGRAL DEL PLUGIN: " . strtoupper($pluginName) . "\n";
$header .= "Generado el: " . date('Y-m-d H:i:s') . "\n";
$header .= "============================================================\n\n";

// 2. Generar el contenido
$body = scanMap($pluginRoot, $pluginRoot);
$fullContent = $header . $body;

// 3. Guardar con el nombre del plugin (ej: poeticsoft-forge-base.txt)
$outputFile = $toolsDir . DIRECTORY_SEPARATOR . $pluginName . '.txt';
file_put_contents($outputFile, $fullContent);

echo $header;
echo "[OK] Archivo generado: tools/" . $pluginName . ".txt\n";