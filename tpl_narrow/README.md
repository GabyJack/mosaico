# Template Narrow para Joomla 6

## Descripción

**tpl_narrow** es una plantilla base moderna, responsive y totalmente compatible con **Joomla 6**, diseñada con un layout estrecho (narrow) que prioriza la legibilidad y la experiencia de usuario.

### Características Principales

- ✅ **Compatible con Joomla 6** - Utiliza las últimas APIs y Web Asset Manager
- ✅ **Diseño Responsive** - Mobile-first con breakpoints optimizados
- ✅ **Accesibilidad WCAG 2.1** - Navegación por teclado, contraste adecuado, ARIA labels
- ✅ **Web Asset Manager** - Carga moderna de CSS y JS con dependencias
- ✅ **Bootstrap 5.3** - Integración opcional vía CDN o local
- ✅ **CSS Variables** - Personalización fácil de colores y estilos
- ✅ **Dark Theme** - Diseño oscuro moderno por defecto
- ✅ **Slider Carrusel** - Para artículos destacados
- ✅ **Overrides Incluidos** - com_content y mod_menu personalizados

---

## Estructura de Carpetas

```
tpl_narrow/
├── css/
│   └── template.css          # Estilos principales
├── js/
│   ├── template.js           # JavaScript principal
│   └── carousel.js           # Funcionalidades del carrusel
├── html/
│   ├── com_content/
│   │   └── article/
│   │       └── default.php   # Override de artículo
│   └── mod_menu/
│       └── default.php       # Override de menú
├── images/                    # Imágenes del template
├── index.php                  # Punto de entrada principal
├── templateDetails.xml        # Manifiesto del template
├── joomla.asset.json          # Registro de assets
├── template_params.ini        # Parámetros por defecto
└── error.php                  # Página de error personalizada
```

---

## Instalación Manual

### Método 1: Subida Directa

1. **Copiar la carpeta** `tpl_narrow` al directorio:
   ```
   /templates/tpl_narrow
   ```

2. **Acceder al Administrador** de Joomla
3. Ir a **Sistema → Plantillas → Plantillas del Sitio**
4. Buscar **Narrow** en la lista
5. Hacer clic en la estrella ⭐ para establecer como predeterminada

### Método 2: Empaquetado ZIP

1. **Comprimir la carpeta** `tpl_narrow`:
   ```bash
   cd /workspace
   zip -r tpl_narrow.zip tpl_narrow/
   ```

2. **En el Administrador de Joomla**:
   - Ir a **Sistema → Instalar → Extensiones**
   - Subir el archivo `tpl_narrow.zip`
   - O arrastrar y soltar el ZIP

3. **Activar el template**:
   - Ir a **Sistema → Plantillas → Plantillas del Sitio**
   - Seleccionar **Narrow**
   - Clic en **Predeterminado**

---

## Configuración del Template

### Parámetros Disponibles

#### Básicos

| Parámetro | Tipo | Descripción | Valor por Defecto |
|-----------|------|-------------|-------------------|
| Título del Sitio | Texto | Nombre mostrado en el header | MiSitio |
| Logo | Media | Archivo de logo personalizado | - |
| Color de Acento | Color | Color principal del tema | #6c63ff |
| Activar Slider | Sí/No | Mostrar carrusel de destacados | Sí |
| Intervalo del Slider | Número | Duración entre slides (ms) | 4000 |

#### Avanzados

| Parámetro | Tipo | Opciones | Descripción |
|-----------|------|----------|-------------|
| Carga de Bootstrap | Lista | Local, CDN, Ninguno | Fuente de Bootstrap |
| Google Fonts | Sí/No | - | Cargar fuente Inter |
| CSS Personalizado | Textarea | - | CSS adicional inline |

### Acceder a la Configuración

1. **Administrador de Joomla**
2. **Sistema → Plantillas → Plantillas del Sitio**
3. Clic en **Narrow** (nombre del template)
4. Pestaña **Opciones**

---

## Posiciones de Módulos

El template incluye las siguientes posiciones:

| Posición | Descripción | Ubicación |
|----------|-------------|-----------|
| `header` | Contenido adicional en cabecera | Top |
| `logo` | Logo alternativo | Header izquierda |
| `menu` | Menú de navegación principal | Header derecha |
| `search` | Módulo de búsqueda | Header |
| `left-top` | Columna izquierda superior (35%) | Left |
| `left-bottom` | Columna izquierda inferior (60%) | Left - Slider |
| `right-top-l` | Columna derecha superior izquierda | Right |
| `right-top-r` | Columna derecha superior derecha | Right |
| `right-bottom-l` | Columna derecha inferior izquierda | Right |
| `right-bottom-r` | Columna derecha inferior derecha | Right |
| `footer` | Pie de página | Bottom |
| `debug` | Debug (solo modo debug) | Bottom |

---

## Personalización

### Cambiar Colores

```css
/* En Parámetros del Template → CSS Personalizado */
:root {
    --clr-accent: #tu-color;
    --clr-bg-dark: #tu-fondo;
}
```

### Añadir Fuentes Personalizadas

```php
// En index.php, después de cargar fuentes
$wa->registerAndUseStyle(
    'mi.fuente',
    'https://fonts.googleapis.com/css2?family=Roboto'
);
```

### Modificar Layout

Editar `index.php` para cambiar la estructura HTML según necesidades.

---

## Overrides Incluidos

### com_content/article

- Visualización moderna de artículos
- Metadatos con iconos SVG
- Imagen introductoria optimizada
- Etiquetas con hover effect
- Schema.org markup para SEO

### mod_menu

- Estilo coherente con el diseño dark
- Submenús desplegables
- Accesibilidad mejorada
- Responsive automático

---

## Buenas Prácticas Implementadas

### Rendimiento

- ✅ Critical CSS inline para evitar FOUC
- ✅ Lazy loading de imágenes
- ✅ Scripts con atributo `defer`
- ✅ Preconnect a dominios externos
- ✅ Minimización de reflows

### Accesibilidad (WCAG 2.1)

- ✅ Skip link para saltar al contenido
- ✅ ARIA labels en navegación
- ✅ Focus visible en todos los elementos
- ✅ Contraste de color adecuado (ratio > 4.5:1)
- ✅ Soporte para `prefers-reduced-motion`

### SEO

- ✅ Meta tags completos
- ✅ Schema.org Article markup
- ✅ URLs semánticas
- ✅ Títulos jerárquicos (H1, H2, H3)
- ✅ Alt text en imágenes

---

## Requisitos del Sistema

- **Joomla**: 6.0 o superior
- **PHP**: 8.1 o superior
- **Navegadores**: 
  - Chrome/Edge (últimas 2 versiones)
  - Firefox (últimas 2 versiones)
  - Safari (últimas 2 versiones)

---

## Soporte y Actualizaciones

### Documentación Adicional

- [Documentación Oficial de Joomla 6](https://docs.joomla.org/)
- [Web Asset Manager](https://docs.joomla.org/J4.x:Web_Asset_Manager)
- [Creación de Templates](https://docs.joomla.org/J4.x:Creating_a_Template)

### Licencia

GPL-2.0-or-later - GNU General Public License versión 2 o posterior

### Autor

Desarrollado por: Desarrollador Senior Joomla  
Copyright © 2026 - Todos los derechos reservados

---

## Changelog

### Versión 1.0.0 (2026-01-15)

- 🎉 Lanzamiento inicial
- ✨ Diseño narrow layout responsive
- 🔧 Web Asset Manager integrado
- ♿ Accesibilidad WCAG 2.1
- 📱 Mobile-first design
- 🎨 Dark theme moderno
- 🔄 Slider carrusel Bootstrap 5
- 📄 Overrides com_content y mod_menu
