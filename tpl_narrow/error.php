<?php
/**
 * Template Narrow - Página de error personalizada
 * Manejo elegante de errores 404 y otros errores HTTP
 * 
 * @package     Tpl_Narrow
 * @copyright   Copyright (C) 2026. Todos los derechos reservados.
 * @license     GNU General Public License versión 2 o posterior
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/**
 * Obtener datos del error y configuración
 */
$app = Factory::getApplication();
$wa  = $this->getWebAssetManager();

$this->setHtmlAttribute('lang', $this->language);

// Registrar assets mínimos para la página de error
$wa->registerAndUseStyle(
    'template.narrow.style',
    'templates/' . $this->template . '/css/template.css',
    [],
    ['version' => '1.0.0']
);

// Estilos específicos para página de error
$errorStyles = "
.error-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--clr-bg-dark);
    color: var(--clr-text-primary);
    font-family: var(--font-main);
}

.error-container {
    text-align: center;
    padding: 3rem;
    max-width: 600px;
}

.error-code {
    font-size: 8rem;
    font-weight: 900;
    line-height: 1;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--clr-accent), #a78bfa);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.error-message {
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    color: var(--clr-text-primary);
}

.error-description {
    color: var(--clr-text-secondary);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.error-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.error-btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.error-btn-primary {
    background: var(--clr-accent);
    color: white;
    border: 2px solid var(--clr-accent);
}

.error-btn-primary:hover {
    background: var(--clr-accent-hover);
    border-color: var(--clr-accent-hover);
}

.error-btn-secondary {
    background: transparent;
    color: var(--clr-text-primary);
    border: 2px solid var(--clr-border);
}

.error-btn-secondary:hover {
    border-color: var(--clr-accent);
    background: var(--clr-glass);
}

@media (max-width: 575px) {
    .error-code {
        font-size: 5rem;
    }
    
    .error-container {
        padding: 1.5rem;
    }
}
";

$this->addStyleDeclaration($errorStyles);

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($this->error->getCode(), ENT_QUOTES, 'UTF-8'); ?> - <?php echo Text::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></title>
    <jdoc:include type="styles" />
</head>
<body class="error-page">

    <div class="error-container">
        <!-- Código de error -->
        <div class="error-code">
            <?php echo htmlspecialchars($this->error->getCode(), ENT_QUOTES, 'UTF-8'); ?>
        </div>

        <!-- Mensaje principal -->
        <h1 class="error-message">
            <?php if ($this->error->getCode() == 404): ?>
                <?php echo Text::_('TPL_NARROW_ERROR_404_TITLE'); ?>
            <?php else: ?>
                <?php echo Text::_('TPL_NARROW_ERROR_TITLE'); ?>
            <?php endif; ?>
        </h1>

        <!-- Descripción del error -->
        <p class="error-description">
            <?php if ($this->error->getCode() == 404): ?>
                <?php echo Text::_('TPL_NARROW_ERROR_404_DESCRIPTION'); ?>
            <?php else: ?>
                <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?>
            <?php endif; ?>
        </p>

        <!-- Botones de acción -->
        <div class="error-actions">
            <a href="<?php echo Uri::root(); ?>" class="error-btn error-btn-primary">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M3 10h14M10 3l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <?php echo Text::_('TPL_NARROW_GO_HOME'); ?>
            </a>
            
            <a href="javascript:history.back()" class="error-btn error-btn-secondary">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M17 10H3M10 3l-7 7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <?php echo Text::_('TPL_NARROW_GO_BACK'); ?>
            </a>
        </div>

        <!-- Información técnica (solo en modo debug) -->
        <?php if ($app->get('debug')): ?>
        <div style="margin-top: 3rem; padding: 1.5rem; background: var(--clr-bg-card); border-radius: 8px; border: 1px solid var(--clr-border); text-align: left;">
            <h3 style="font-size: 1rem; margin-bottom: 1rem; color: var(--clr-text-secondary);">
                <?php echo Text::_('TPL_NARROW_DEBUG_INFO'); ?>
            </h3>
            <pre style="font-size: 0.75rem; color: var(--clr-text-secondary); overflow-x: auto;">
<?php echo htmlspecialchars($this->error->getFile(), ENT_QUOTES, 'UTF-8'); ?>:<?php echo $this->error->getLine(); ?>

<?php echo nl2br(htmlspecialchars($this->error->getTraceAsString(), ENT_QUOTES, 'UTF-8')); ?>
            </pre>
        </div>
        <?php endif; ?>
    </div>

</body>
</html>
