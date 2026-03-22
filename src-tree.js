const fs = require('fs');
const path = require('path');

// CONFIGURACIÓN
const directorioRaiz = './src';
const archivoSalida = 'src-tree.txt';
const carpetasIgnoradas = [
    'scss',
    'node_modules',
    '.git',
    'dist',
    'build',
    '.vscode'
];

let acumuladorArbol = `ESTRUCTURA DE: ${path.resolve(directorioRaiz)}\n.\n`;

function generarArbolTexto(ruta, prefijo = '') {
    let contenido = [];
    try {
        // Leemos el directorio y filtramos los ignorados
        contenido = fs
            .readdirSync(ruta)
            .filter((item) => !carpetasIgnoradas.includes(item));
    } catch (e) {
        return;
    }

    contenido.forEach((archivo, indice) => {
        const rutaCompleta = path.join(ruta, archivo);
        const esElUltimo = indice === contenido.length - 1;

        // Determinar el símbolo de la rama
        const rama = esElUltimo ? '└── ' : '├── ';

        // Añadir la línea al acumulador
        acumuladorArbol += `${prefijo}${rama}${archivo}\n`;

        // Si es un directorio, bajar un nivel (recursividad)
        if (fs.statSync(rutaCompleta).isDirectory()) {
            const nuevoPrefijo = prefijo + (esElUltimo ? '    ' : '│   ');
            generarArbolTexto(rutaCompleta, nuevoPrefijo);
        }
    });
}

// Ejecutar la función
console.log('Generando mapa del proyecto...');
generarArbolTexto(directorioRaiz);

// Guardar el resultado en el archivo
try {
    fs.writeFileSync(archivoSalida, acumuladorArbol, 'utf8');
    console.log(`\n✅ ¡Éxito! El árbol se ha guardado en: ${archivoSalida}`);
} catch (error) {
    console.error('Error al escribir el archivo:', error);
}
