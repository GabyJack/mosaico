<?php
/**
 * Template Narrow - Override para artículos de com_content
 * Vista de artículo individual con diseño personalizado
 * 
 * @package     Tpl_Narrow
 * @copyright   Copyright (C) 2026. Todos los derechos reservados.
 * @license     GNU General Public License versión 2 o posterior
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

/**
 * Obtener configuración del template
 */
$wa = $this->document->getWebAssetManager();
$params = Factory::getApplication()->getTemplate(true)->params;
$accentColor = $params->get('accentColor', '#6c63ff');

?>
<article class="narrow-article" itemscope itemtype="https://schema.org/Article">
    
    <!-- Encabezado del artículo -->
    <header class="article-header" style="margin-bottom: 2rem;">
        <?php if ($this->item->state == 0): ?>
        <span class="badge bg-warning text-dark mb-2">
            <?php echo Text::_('JUNPUBLISHED'); ?>
        </span>
        <?php endif; ?>
        
        <?php if ($this->params->get('show_title')): ?>
        <h1 class="article-title" itemprop="headline" style="font-size: 2rem; font-weight: 700; margin-bottom: 1rem; line-height: 1.3;">
            <?php echo htmlspecialchars($this->item->title, ENT_QUOTES, 'UTF-8'); ?>
        </h1>
        <?php endif; ?>

        <!-- Meta información -->
        <?php if ($this->params->get('show_author') || $this->params->get('show_create_date')): ?>
        <div class="article-meta" style="display: flex; gap: 1.5rem; color: var(--clr-text-secondary); font-size: 0.85rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
            <?php if ($this->params->get('show_author') && !empty($this->item->author)): ?>
            <span class="article-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="vertical-align: middle; margin-right: 0.25rem; opacity: 0.7;">
                    <path d="M8 8a3 3 0 100-6 3 3 0 000 6z" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M12 14a4 4 0 10-8 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <span itemprop="name"><?php echo htmlspecialchars($this->item->author, ENT_QUOTES, 'UTF-8'); ?></span>
            </span>
            <?php endif; ?>
            
            <?php if ($this->params->get('show_create_date')): ?>
            <time class="article-date" datetime="<?php echo HTMLHelper::_('date', $this->item->created, 'c'); ?>" itemprop="dateCreated">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="vertical-align: middle; margin-right: 0.25rem; opacity: 0.7;">
                    <rect x="2" y="3" width="12" height="11" rx="2" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M5 1v2M11 1v2M3 7h10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <?php echo HTMLHelper::_('date', $this->item->created, Text::_('DATE_FORMAT_LC3')); ?>
            </time>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </header>

    <!-- Imagen principal (intro image) -->
    <?php if (!empty($this->item->images['image_intro'])): ?>
    <figure class="article-intro-image" style="margin: 0 0 2rem 0; border-radius: 12px; overflow: hidden;">
        <img src="<?php echo htmlspecialchars($this->item->images['image_intro'], ENT_QUOTES, 'UTF-8'); ?>" 
             alt="<?php echo htmlspecialchars($this->item->images['image_intro_alt'], ENT_QUOTES, 'UTF-8') ?: htmlspecialchars($this->item->title, ENT_QUOTES, 'UTF-8'); ?>"
             itemprop="image"
             style="width: 100%; height: auto; display: block;"
             loading="lazy">
        <?php if (!empty($this->item->images['image_intro_caption'])): ?>
        <figcaption style="padding: 0.75rem; background: var(--clr-bg-card); color: var(--clr-text-secondary); font-size: 0.8rem; text-align: center;">
            <?php echo htmlspecialchars($this->item->images['image_intro_caption'], ENT_QUOTES, 'UTF-8'); ?>
        </figcaption>
        <?php endif; ?>
    </figure>
    <?php endif; ?>

    <!-- Contenido principal -->
    <div class="article-content" itemprop="articleBody" style="line-height: 1.8; color: var(--clr-text-primary);">
        <?php echo $this->item->text; ?>
    </div>

    <!-- Etiquetas / Tags -->
    <?php if (!empty($this->item->tags->itemTags)): ?>
    <footer class="article-footer" style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--clr-border);">
        <div class="article-tags" style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <span style="color: var(--clr-text-secondary); font-size: 0.85rem; display: flex; align-items: center; gap: 0.25rem;">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M14 10l-4 4-8-8V2h4l8 8v4z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="9" cy="5" r="1.5" fill="currentColor"/>
                </svg>
                <?php echo Text::_('JTAG'); ?>:
            </span>
            <?php foreach ($this->item->tags->itemTags as $tag): ?>
            <a href="<?php echo Route::_('index.php?option=com_tags&view=tag&id=' . $tag->id); ?>" 
               class="article-tag"
               style="background: rgba(108, 99, 255, 0.15); color: <?php echo $accentColor; ?>; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.75rem; text-decoration: none; transition: all 0.2s;"
               onmouseover="this.style.background='<?php echo $accentColor; ?>'; this.style.color='white'"
               onmouseout="this.style.background='rgba(108, 99, 255, 0.15)'; this.style.color='<?php echo $accentColor; ?>'">
                <?php echo htmlspecialchars($tag->title, ENT_QUOTES, 'UTF-8'); ?>
            </a>
            <?php endforeach; ?>
        </div>
    </footer>
    <?php endif; ?>

</article>

<!-- Estilos específicos para el artículo -->
<style>
.narrow-article {
    animation: fadeInUp 0.5s ease both;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.article-title {
    background: linear-gradient(135deg, var(--clr-accent), #a78bfa);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.article-content a {
    color: <?php echo $accentColor; ?>;
    text-decoration: underline;
    text-underline-offset: 2px;
}

.article-content a:hover {
    color: #a78bfa;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}

.article-content blockquote {
    border-left: 4px solid <?php echo $accentColor; ?>;
    padding-left: 1.5rem;
    margin: 1.5rem 0;
    color: var(--clr-text-secondary);
    font-style: italic;
}

.article-content code {
    background: var(--clr-bg-card);
    padding: 0.2rem 0.4rem;
    border-radius: 4px;
    font-size: 0.9em;
    color: #f472b6;
}

@media (max-width: 575px) {
    .article-title {
        font-size: 1.5rem !important;
    }
    
    .article-meta {
        flex-direction: column;
        gap: 0.5rem !important;
    }
}
</style>
