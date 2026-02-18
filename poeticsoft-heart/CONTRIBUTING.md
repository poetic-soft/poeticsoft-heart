# Guía de Contribución

¡Gracias por tu interés en contribuir a Poeticsoft Heart!

## Cómo Contribuir

### Reportar Bugs

Si encuentras un bug, por favor crea un issue incluyendo:

- Descripción detallada del problema
- Pasos para reproducir
- Comportamiento esperado vs actual
- Versión de PHP, WordPress y del plugin
- Logs relevantes (si aplica)

### Proponer Features

Para proponer nuevas características:

1. Abre un issue describiendo la funcionalidad
2. Explica el caso de uso y beneficios
3. Si es posible, incluye ejemplos de código
4. Espera feedback antes de comenzar a desarrollar

### Pull Requests

#### Proceso

1. **Fork** el repositorio
2. **Crea una rama** desde `main` con un nombre descriptivo:
   - `feature/nombre-feature` para nuevas características
   - `fix/descripcion-bug` para correcciones
   - `docs/descripcion` para documentación
3. **Escribe código** siguiendo nuestros estándares
4. **Añade tests** para tu código
5. **Actualiza documentación** si es necesario
6. **Commit** con mensajes descriptivos
7. **Push** a tu fork
8. **Abre un Pull Request** hacia `main`

#### Estándares de Código

##### PHP

- Seguir [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)
- PSR-4 para autoloading
- PHPDoc completo para todas las clases y métodos públicos
- Type hints cuando sea posible (PHP 7.4+)
- Usar namespaces apropiadamente

**Ejemplo:**

```php
<?php

namespace Poeticsoft\Heart;

/**
 * Descripción de la clase
 *
 * @package Poeticsoft\Heart
 * @since 0.0.0
 */
class MiClase {

    /**
     * Descripción del método
     *
     * @param string $param1 Descripción del parámetro
     * @param int $param2 Descripción del parámetro
     * @return bool Descripción del retorno
     */
    public function mi_metodo($param1, $param2) {
        // Código aquí
    }
}
```

##### Seguridad

- **SIEMPRE** sanitizar inputs con `sanitize_*()` functions
- **SIEMPRE** escapar outputs con `esc_*()` functions
- Usar nonces para formularios y acciones AJAX
- Validar permisos con `current_user_can()`
- Nunca confiar en datos del usuario

##### Internacionalización

- Usar funciones de traducción: `__()`, `_e()`, `_n()`, `_x()`
- Text domain: `poeticsoft-heart`
- Strings traducibles: todos los mensajes visibles al usuario

**Ejemplo:**

```php
echo esc_html__('Mensaje traducible', 'poeticsoft-heart');
```

#### Testing

- **Todos** los PRs deben incluir tests
- Tests deben pasar antes de merge
- Mantener cobertura de código > 80%

**Ejecutar tests:**

```bash
composer test
# o
./vendor/bin/phpunit
```

**Escribir tests:**

```php
public function test_mi_funcionalidad() {
    // Arrange
    $esperado = 'valor';

    // Act
    $resultado = mi_funcion();

    // Assert
    $this->assertEquals($esperado, $resultado);
}
```

#### Commits

Usar mensajes de commit descriptivos:

```
tipo(scope): descripción corta

Descripción más detallada si es necesario.

Fixes #123
```

**Tipos:**
- `feat`: Nueva característica
- `fix`: Corrección de bug
- `docs`: Cambios en documentación
- `style`: Formateo, puntos y comas, etc.
- `refactor`: Refactorización de código
- `test`: Añadir o modificar tests
- `chore`: Cambios en build, dependencias, etc.

**Ejemplos:**

```
feat(engine): añadir método para desregistrar módulos

Permite eliminar módulos registrados dinámicamente.

Closes #45
```

```
fix(logging): corregir rotación de logs en Windows

La función rename() fallaba en Windows cuando el archivo
estaba en uso. Añadido manejo especial para Windows.

Fixes #78
```

## Estilo de Código

### Indentación

- Usar **2 espacios** para indentación (no tabs)
- Llaves en línea nueva para funciones y clases
- Espacios alrededor de operadores

### Nombres

- **Clases**: `PascalCase`
- **Métodos/Funciones**: `snake_case`
- **Constantes**: `SCREAMING_SNAKE_CASE`
- **Variables**: `$snake_case`

### Documentación

- Todas las clases deben tener DocBlock
- Todos los métodos públicos deben tener DocBlock
- Incluir `@param`, `@return`, `@throws` cuando aplique
- Describir el propósito, no el cómo

## Proceso de Review

1. **Automated checks**: CI ejecutará tests automáticamente
2. **Code review**: Un mantenedor revisará tu código
3. **Feedback**: Puede haber comentarios o solicitudes de cambios
4. **Iteración**: Realiza los cambios solicitados
5. **Aprobación**: Una vez aprobado, se hará merge

## Preguntas

Si tienes preguntas sobre cómo contribuir:

- Abre un issue con la etiqueta `question`
- Contacta por email: alberto@poeticsoft.com
- Revisa issues existentes - puede que ya esté respondida

## Código de Conducta

### Nuestro Compromiso

Nos comprometemos a hacer de la participación en este proyecto una experiencia libre de acoso para todos.

### Comportamiento Esperado

- Usar lenguaje acogedor e inclusivo
- Respetar puntos de vista y experiencias diferentes
- Aceptar críticas constructivas con gracia
- Enfocarse en lo que es mejor para la comunidad
- Mostrar empatía hacia otros miembros

### Comportamiento Inaceptable

- Lenguaje o imágenes sexualizadas
- Trolling, comentarios insultantes o ataques personales
- Acoso público o privado
- Publicar información privada de otros sin permiso
- Conducta no profesional o inapropiada

### Reportar

Incidentes pueden reportarse a alberto@poeticsoft.com. Todos los reportes serán revisados e investigados.

## Licencia

Al contribuir, aceptas que tus contribuciones serán licenciadas bajo la misma licencia MIT del proyecto.

---

¡Gracias por contribuir a Poeticsoft Heart! 💙
