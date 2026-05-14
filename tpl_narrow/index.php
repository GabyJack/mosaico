<?php
/**
 * Template Narrow para Joomla 6
 * Plantilla base moderna, responsive y totalmente compatible con Joomla 6
 * 
 * @package     Tpl_Narrow
 * @copyright   Copyright (C) 2026. Todos los derechos reservados.
 * @license     GNU General Public License versión 2 o posterior
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/**
 * Obtener instancia de la aplicación y documento
 */
$app = Factory::getApplication();
$doc = $this->getDocument();
$wa  = $this->getWebAssetManager();

/**
 * Configuración del template
 */
$siteTitle      = $this->params->get('siteTitle', 'MiSitio');
$logoFile       = $this->params->get('logoFile', '');
$accentColor    = $this->params->get('accentColor', '#6c63ff');
$enableSlider   = $this->params->get('enableSlider', 1);
$sliderInterval = $this->params->get('sliderInterval', 4000);
$bootstrapLoad  = $this->params->get('bootstrapLoad', 'cdn');
$googleFonts    = $this->params->get('googleFonts', 1);
$customCss      = $this->params->get('customCss', '');

/**
 * Registro de assets usando Web Asset Manager de Joomla 6
 */

// Registrar y cargar fuentes (Inter)
if ($googleFonts) {
    $wa->registerAndUseStyle(
        'template.narrow.fonts',
        'https://cdn.jsdelivr.net/npm/@fontsource/inter@5.1.0/index.css',
        [],
        ['version' => '5.1.0']
    );
}

// Registrar y cargar Bootstrap según configuración
if ($bootstrapLoad === 'cdn') {
    $wa->registerAndUseStyle(
        'template.narrow.bootstrap.style',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        [],
        ['version' => '5.3.3']
    );
    
    $wa->registerAndUseScript(
        'bootstrap.bundle',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        [],
        ['defer' => true],
        ['version' => '5.3.3']
    );
} elseif ($bootstrapLoad === 'local') {
    // Usar Bootstrap local si está disponible en Joomla
    $wa->usePreset('bootstrap.css');
    $wa->usePreset('bootstrap.bundle');
}

// Registrar y cargar estilos del template
$wa->registerAndUseStyle(
    'template.narrow.style',
    'templates/' . $this->template . '/css/template.css',
    [],
    ['version' => '1.0.0']
);

// Registrar y cargar scripts del template
$wa->registerAndUseScript(
    'template.narrow.script',
    'templates/' . $this->template . '/js/template.js',
    ['bootstrap.bundle'],
    ['defer' => true],
    ['version' => '1.0.0']
);

/**
 * Añadir variables CSS personalizadas desde parámetros
 */
$customStyles = ":root { --clr-accent: {$accentColor}; }";

if (!empty($customCss)) {
    $customStyles .= "\n" . $customCss;
}

$doc->addStyleDeclaration($customStyles);

/**
 * Metadatos SEO y accesibilidad
 */
$doc->setHtmlAttribute('lang', $this->language);
$doc->setMetaData('viewport', 'width=device-width, initial-scale=1.0');
$doc->setMetaData('charset', 'UTF-8');

/**
 * Incluir script inline para configuración dinámica del slider
 */
$sliderConfig = "
window.templateNarrowConfig = {
    sliderEnabled: " . ($enableSlider ? 'true' : 'false') . ",
    sliderInterval: {$sliderInterval},
    bootstrapLoaded: '" . ($bootstrapLoad !== 'none' ? 'true' : 'false') . "'
};
";
$doc->addScriptDeclaration($sliderConfig);

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo Uri::root(); ?>favicon.ico" type="image/x-icon">
    
    <!-- Preload de fuentes críticas -->
    <?php if ($googleFonts): ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php endif; ?>
    
    <!-- Estilos críticos inline para evitar FOUC -->
    <style>
        /* Critical CSS mínimo para renderizado inicial */
        body{margin:0;background-color:#0f1117;color:#e8e9ed;font-family:'Inter',sans-serif;}
        .template-header{background:#1a1d27;border-bottom:1px solid rgba(255,255,255,0.08);}
        .narrow-wrapper{max-width:1140px;margin:0 auto;padding:1.5rem;}
    </style>
</head>
<body class="site <?php echo $this->option; ?>-<?php echo htmlspecialchars($this->view, ENT_COMPAT, 'UTF-8'); ?>">

    <!-- Enlace de salto para accesibilidad -->
    <a href="#main-content" class="skip-link">
        <?php echo Text::_('TPL_NARROW_SKIP_TO_CONTENT'); ?>
    </a>

    <!-- HEADER / CABECERA -->
    <header class="template-header" role="banner">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                
                <!-- Marca / Logo -->
                <div class="header-brand">
                    <?php if ($logoFile): ?>
                        <img src="<?php echo htmlspecialchars($logoFile, ENT_QUOTES, 'UTF-8'); ?>" 
                             alt="<?php echo htmlspecialchars($siteTitle, ENT_QUOTES, 'UTF-8'); ?>"
                             width="32" height="32">
                    <?php else: ?>
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" aria-hidden="true">
                            <rect width="32" height="32" rx="8" fill="url(#logo-gradient)"/>
                            <path d="M10 16L14 20L22 12" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <defs>
                                <linearGradient id="logo-gradient" x1="0" y1="0" x2="32" y2="32">
                                    <stop stop-color="<?php echo $accentColor; ?>"/>
                                    <stop offset="1" stop-color="#a78bfa"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    <?php endif; ?>
                    
                    <h1><?php echo htmlspecialchars($siteTitle, ENT_QUOTES, 'UTF-8'); ?></h1>
                </div>

                <!-- Navegación principal (desktop) -->
                <?php if ($this->countModules('menu')): ?>
                <nav class="header-nav d-none d-md-flex gap-1" role="navigation" aria-label="<?php echo Text::_('TPL_NARROW_MAIN_NAVIGATION'); ?>">
                    <jdoc:include type="modules" name="menu" style="none" />
                </nav>
                <?php endif; ?>

                <!-- Botón menú móvil -->
                <button class="menu-toggle-btn d-md-none" 
                        id="menuToggle" 
                        type="button"
                        aria-expanded="false"
                        aria-controls="mobileMenu"
                        aria-label="<?php echo Text::_('TPL_NARROW_TOGGLE_MENU'); ?>">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                        <path d="M3 5h14M3 10h14M3 15h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- MENÚ MÓVIL -->
    <?php if ($this->countModules('menu')): ?>
    <div class="mobile-menu d-md-none" 
         id="mobileMenu" 
         style="display:none;"
         role="navigation"
         aria-hidden="true"
         aria-label="<?php echo Text::_('TPL_NARROW_MOBILE_NAVIGATION'); ?>">
        <div class="d-flex flex-column gap-1">
            <jdoc:include type="modules" name="menu" style="none" />
        </div>
    </div>
    <?php endif; ?>

    <!-- WRAPPER PRINCIPAL DE CONTENIDO -->
    <div class="narrow-wrapper">
        
        <!-- Mensajes del sistema (alertas, errores, etc.) -->
        <jdoc:include type="message" />

        <!-- GRID DE CONTENIDO PRINCIPAL -->
        <div class="content-grid">

            <!-- COLUMNA IZQUIERDA (40%) -->
            <aside class="left-column" role="complementary">

                <!-- LEFT TOP: Logo o módulo personalizado -->
                <?php if ($this->countModules('left-top')): ?>
                <div class="left-top">
                    <jdoc:include type="modules" name="left-top" style="none" />
                </div>
                <?php else: ?>
                <div class="left-top">
                    <div class="logo-container">
                        <?php if ($logoFile): ?>
                            <img src="<?php echo htmlspecialchars($logoFile, ENT_QUOTES, 'UTF-8'); ?>" 
                                 alt="<?php echo htmlspecialchars($siteTitle, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php else: ?>
                            <div class="logo-text"><?php echo htmlspecialchars($siteTitle, ENT_QUOTES, 'UTF-8'); ?></div>
                            <div style="font-size:0.7rem;color:var(--clr-text-secondary);margin-top:0.25rem;letter-spacing:0.05em;">
                                Joomla 6 Template
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- LEFT BOTTOM: Slider de artículos destacados -->
                <?php if ($enableSlider && $this->countModules('left-bottom')): ?>
                <div class="left-bottom">
                    <jdoc:include type="modules" name="left-bottom" style="none" />
                </div>
                <?php elseif ($enableSlider): ?>
                <!-- Slider por defecto (placeholder) -->
                <div class="left-bottom">
                    <div id="featuredSlider" class="carousel slide slider-carousel" 
                         data-bs-ride="carousel" 
                         data-bs-interval="<?php echo $sliderInterval; ?>">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="article-bg" style="background-image: url('https://picsum.photos/seed/slide1/600/800');"></div>
                                <div class="slider-caption-box">
                                    <a href="#" title="Artículo Destacado">
                                        <span class="article-category"><?php echo Text::_('TPL_NARROW_FEATURED'); ?></span><br>
                                        <?php echo Text::_('TPL_NARROW_WELCOME_MESSAGE'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Indicadores -->
                        <div class="slider-indicators">
                            <button type="button" data-bs-target="#featuredSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        </div>

                        <!-- Navegación -->
                        <button class="slider-nav-btn prev" type="button" data-bs-target="#featuredSlider" data-bs-slide="prev" aria-label="<?php echo Text::_('TPL_NARROW_PREVIOUS'); ?>">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M10 2L4 8L10 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button class="slider-nav-btn next" type="button" data-bs-target="#featuredSlider" data-bs-slide="next" aria-label="<?php echo Text::_('TPL_NARROW_NEXT'); ?>">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M6 2L12 8L6 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                </div>
                <?php endif; ?>

            </aside>

            <!-- COLUMNA DERECHA (60%) -->
            <main class="right-column" id="main-content" role="main">

                <!-- COLUMN L (50% de right) -->
                <div class="right-col-L">

                    <!-- Top: Módulo de video o contenido multimedia -->
                    <?php if ($this->countModules('right-top-l')): ?>
                    <div class="right-top-section">
                        <jdoc:include type="modules" name="right-top-l" style="none" />
                    </div>
                    <?php endif; ?>

                    <!-- Bottom: Artículos o módulos de contenido -->
                    <?php if ($this->countModules('right-bottom-l')): ?>
                    <div class="right-bottom-section">
                        <jdoc:include type="modules" name="right-bottom-l" style="none" />
                    </div>
                    <?php endif; ?>

                </div>

                <!-- COLUMN R (50% de right) -->
                <div class="right-col-R">

                    <!-- Top: Módulo personalizado o espacio vacío -->
                    <?php if ($this->countModules('right-top-r')): ?>
                    <div class="right-top-section">
                        <jdoc:include type="modules" name="right-top-r" style="none" />
                    </div>
                    <?php else: ?>
                    <div class="right-top-section">
                        <div class="right-top-empty">
                            <div style="text-align:center;">
                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" style="margin:0 auto 0.5rem;display:block;opacity:0.3;">
                                    <rect x="4" y="4" width="28" height="28" rx="6" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4 4"/>
                                    <path d="M13 18h10M18 13v10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                <span><?php echo Text::_('TPL_NARROW_MODULE_POSITION_AVAILABLE'); ?><br>
                                    <small style="opacity:0.5;"><?php echo Text::_('TPL_NARROW_CUSTOM_MODULE'); ?></small>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Bottom: Más artículos o módulos -->
                    <?php if ($this->countModules('right-bottom-r')): ?>
                    <div class="right-bottom-section">
                        <jdoc:include type="modules" name="right-bottom-r" style="none" />
                    </div>
                    <?php endif; ?>

                </div>

            </main>

        </div>

        <!-- Componente principal (cuando se visualiza un artículo o vista específica) -->
        <?php if ($this->countModules('breadcrumb') || $app->input->get('view') !== 'featured'): ?>
        <div class="component-area" style="margin-top: 2rem;">
            <jdoc:include type="component" />
        </div>
        <?php endif; ?>

    </div>

    <!-- FOOTER / PIE DE PÁGINA -->
    <footer class="template-footer" role="contentinfo">
        <div class="narrow-wrapper" style="padding-top:0;padding-bottom:0;">
            
            <!-- Módulos del footer -->
            <?php if ($this->countModules('footer')): ?>
            <div class="position-footer">
                <jdoc:include type="modules" name="footer" style="none" />
            </div>
            <?php endif; ?>

            <!-- Copyright y créditos -->
            <p style="margin:0;">
                &copy; <?php echo date('Y'); ?> 
                <?php echo htmlspecialchars($siteTitle, ENT_QUOTES, 'UTF-8'); ?> · 
                <?php echo Text::_('TPL_NARROW_POWERED_BY_JOOMLA'); ?>
            </p>
        </div>
    </footer>

    <!-- Debug position (solo en modo debug) -->
    <?php if ($this->debug): ?>
    <div class="position-debug">
        <jdoc:include type="modules" name="debug" style="none" />
    </div>
    <?php endif; ?>

    <!-- Inclusión de cuerpo final de Joomla -->
    <jdoc:include type="modules" name="debug" style="none" />

</body>
</html>
