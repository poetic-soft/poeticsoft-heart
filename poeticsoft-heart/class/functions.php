<?php

namespace Poeticsoft;

/**
 * Funciones helper globales del ecosistema Poeticsoft.
 *
 * @package Poeticsoft
 * @since 0.0.0
 */

/**
 * Obtiene la instancia única del motor principal.
 *
 * @return \Poeticsoft\Heart\Engine
 */
function Heart()
{
    return \Poeticsoft\Heart\Engine::instance();
}

/**
 * Registra un mensaje en el log personalizado del ecosistema.
 *
 * @param mixed  $mensaje Contenido a loguear (string, array u objeto).
 * @param string $nivel   Nivel de criticidad (INFO, WARNING, ERROR, DEBUG).
 * @param string $forge   Identificador del módulo que genera el log.
 * @return bool           True si se escribió correctamente.
 */
function log($mensaje, $nivel = 'INFO', $forge = 'HEART')
{
    return Heart()->log($mensaje, $nivel, $forge);
}

/**
 * Facilita la conexión con el servidor de actualizaciones externas.
 *
 * @param string $file       Ruta al archivo principal del plugin.
 * @param string $slug       Slug único del plugin.
 * @param string $server_url URL del JSON de info (opcional).
 * @return void
 */
function enable_updates($file, $slug, $server_url = '')
{
    if (!is_admin()) {
        return;
    }

    \Poeticsoft\Heart\Updater::init($file, $slug, $server_url);
}
