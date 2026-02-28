# Poeticsoft Heart 💖

[![Version](https://img.shields.io/badge/version-1.0.0-e91e63.svg)](https://github.com/poetic-soft/heart)
[![PHP](https://img.shields.io/badge/php-%3E%3D7.4-8892bf.svg)](https://php.net)
[![Framework](https://img.shields.io/badge/framework-custom-lightgrey.svg)]()

**Poeticsoft Heart** es el núcleo inteligente y motor de ejecución para WordPress diseñado por Poeticsoft. Proporciona una infraestructura robusta para la gestión de módulos independientes (Forges), inyección de dependencias y diagnósticos de salud del sistema.

## 🌟 Características Principales 

- **Service Container**: Gestión centralizada de utilidades mediante inversión de control.
- **Forge Engine**: Registro dinámico y orquestación de plugins secundarios.
- **Diagnostic Inspector**: Sistema de monitoreo de salud del entorno.
- **Unified Logger**: Sistema de registro de eventos con tipado por módulo.

## 🛠️ Estructura del Núcleo



El núcleo se divide en componentes especializados:
- `Engine`: Orquestador principal (Singleton).
- `Inspector`: Verificación de requisitos y estabilidad.
- `ForgeInterface`: El contrato legal para la extensibilidad.

## 🚀 Instalación y Uso

Este plugin es el **requisito previo** para todos los demás productos Poeticsoft.

1. Instala el plugin en `wp-content/plugins/poeticsoft-heart`.
2. Ejecuta la instalación de dependencias:
   ```bash
   composer install --no-dev