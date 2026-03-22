const fs = require('fs');
const path = require('path');

// CONFIGURACIÓN
const directorioRaiz = './src'; // Directorio a leer
const archivoSalida = 'src-code.txt'; // Nombre del archivo resultante
const carpetasIgnoradas = ['scss', 'node_modules', '.git', 'dist', 'build']; // Carpetas que no queremos leer

// Limpiar el archivo de salida si ya existe
if (fs.existsSync(archivoSalida)) {
    fs.unlinkSync(archivoSalida);
}

function recorrerDirectorio(dirActual) {
    const archivos = fs.readdirSync(dirActual);

    archivos.forEach((archivo) => {
        const rutaCompleta = path.join(dirActual, archivo);
        const stats = fs.statSync(rutaCompleta);

        // 1. Si es una carpeta y no está en la lista negra, entrar en ella
        if (stats.isDirectory()) {
            if (!carpetasIgnoradas.includes(archivo)) {
                recorrerDirectorio(rutaCompleta);
            }
        }
        // 2. Si es un archivo, leerlo y escribirlo (evitando el archivo de salida)
        else if (archivo !== archivoSalida) {
            console.log(`Procesando: ${rutaCompleta}`);

            const contenido = fs.readFileSync(rutaCompleta, 'utf8');

            // Estructura visual en el archivo de texto
            const separador = `\n\n--- INICIO DE ARCHIVO: ${rutaCompleta} ---\n`;
            const finSeparador = `\n--- FIN DE ARCHIVO: ${rutaCompleta} ---\n`;

            fs.appendFileSync(
                archivoSalida,
                separador + contenido + finSeparador
            );
        }
    });
}

console.log('--- Iniciando consolidación de código ---');
recorrerDirectorio(directorioRaiz);
console.log(`\n¡Listo! Todo el código se ha volcado en: ${archivoSalida}`);
