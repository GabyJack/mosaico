<?php
/**
 * Template Narrow - Override para módulo mod_menu
 * Menú de navegación con diseño personalizado
 * 
 * @package     Tpl_Narrow
 * @copyright   Copyright (C) 2026. Todos los derechos reservados.
 * @license     GNU General Public License versión 2 o posterior
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;

/**
 * Nota: Este override asume que se está usando un menú tipo "list" o "horizontal"
 * Para menús más complejos, adaptar según las necesidades
 */

$id = '';

if ($tagId = $params->get('tag_id', '')) {
    $id = ' id="' . $tagId . '"';
}

// Determinar si es menú móvil o desktop
$isMobileMenu = strpos($module->position, 'mobile') !== false || isset($mobileMenu);

?>
<ul<?php echo $id; ?> class="nav-menu<?php echo $class_sfx; ?>" style="list-style: none; margin: 0; padding: 0; <?php echo $isMobileMenu ? '' : 'display: flex; gap: 0.25rem;'; ?>">

<?php foreach ($list as $i => &$item) {
    $itemParams = $item->getParams();
    $class      = ['nav-item'];
    $linkClass  = ['nav-link'];
    
    // Clases activas
    if ($item->id == $default_id) {
        $class[] = 'default';
    }
    
    if ($item->id == $active_id || ($item->type === 'alias' && $itemParams->get('aliasoptions') == $active_id)) {
        $class[] = 'current';
        $linkClass[] = 'active';
    }

    if (in_array($item->id, $path)) {
        $class[] = 'active';
        $linkClass[] = 'active';
    }

    if ($item->deeper) {
        $class[] = 'deeper';
        $class[] = 'parent';
    }

    echo '<li class="' . implode(' ', $class) . '">';

    // Construir atributos del enlace
    $attributes = [];
    
    if (!empty($item->title)) {
        $attributes[] = 'title="' . htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8') . '"';
    }
    
    if ($item->target) {
        $attributes[] = 'target="' . $item->target . '"';
        
        if ($item->target === '_blank') {
            $attributes[] = 'rel="noopener noreferrer"';
        }
    }

    $linkAttributes = implode(' ', $attributes);
    
    // Determinar si es separador o enlace
    if ($item->type === 'separator') {
        echo '<span class="nav-separator" style="color: var(--clr-text-secondary); font-size: 0.85rem; padding: 0.4rem 0.9rem;">' 
           . htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8') 
           . '</span>';
    } else {
        // Enlace normal
        $linkClassStr = implode(' ', $linkClass);
        
        echo '<a href="' . htmlspecialchars($item->flink, ENT_QUOTES, 'UTF-8') . '" '
           . 'class="' . $linkClassStr . '" '
           . $linkAttributes . '>'
           . htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8');
        
        // Indicador de submenú
        if ($item->deeper) {
            echo ' <svg width="12" height="12" viewBox="0 0 12 12" fill="none" style="vertical-align: middle; margin-left: 0.25rem;">'
               . '<path d="M4 2l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>'
               . '</svg>';
        }
        
        echo '</a>';
    }

    // Submenú
    if ($item->deeper) {
        echo '<ul class="nav-child unstyled" style="list-style: none; margin: 0.5rem 0 0 1rem; padding: 0; border-left: 2px solid var(--clr-border);">';
    } elseif ($item->deeper) {
        echo '</li>';
    } else {
        echo '</li>';
    }
}

?></ul>

<!-- Estilos adicionales para el menú -->
<style>
.nav-menu .nav-link {
    color: var(--clr-text-secondary);
    font-size: 0.85rem;
    font-weight: 500;
    padding: 0.4rem 0.9rem;
    border-radius: 6px;
    transition: all 0.2s;
    display: inline-block;
    text-decoration: none;
}

.nav-menu .nav-link:hover,
.nav-menu .nav-link.active {
    color: var(--clr-text-primary);
    background: var(--clr-glass);
}

.nav-menu .nav-item.deeper > .nav-link {
    cursor: pointer;
}

/* Submenús */
.nav-menu .nav-child {
    display: none;
    animation: fadeIn 0.2s ease;
}

.nav-menu .nav-item.parent:hover > .nav-child {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Accesibilidad */
.nav-menu .nav-link:focus-visible {
    outline: 2px solid var(--clr-accent);
    outline-offset: 2px;
}

/* Responsive */
@media (max-width: 767px) {
    .nav-menu:not(.mobile-menu) {
        flex-direction: column !important;
        gap: 0.25rem !important;
    }
    
    .nav-menu .nav-link {
        width: 100%;
        display: block;
    }
    
    .nav-menu .nav-child {
        margin-left: 0.75rem !important;
    }
}
</style>
