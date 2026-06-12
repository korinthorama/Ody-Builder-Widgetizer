<?php
/*
 * Widgetizer — Map Widget — template.php
 * Prefix: map
 */
defined('CMS') or die("This file cannot run this way!");

// ── Base assets ───────────────────────────────────────────────────────────────
$_wdg_assets = 'admin/builder_widget_assets/';
$_wdg_css    = $_wdg_assets . 'base.css';
$_wdg_js     = $_wdg_assets . 'scripts.js';
if (!in_array($_wdg_css, $document->loadedFiles)) {
    echo '<link href="' . $_wdg_css . '" rel="stylesheet" type="text/css">' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_css;
}
if (!in_array($_wdg_js, $document->loadedFiles)) {
    echo '<script src="' . $_wdg_js . '" defer></script>' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_js;
}

// ── Params ────────────────────────────────────────────────────────────────────
$_widget_id     = 'widget_' . $blockID;
$_eyebrow       = htmlspecialchars($wdg_params['eyebrow']      ?? '');
$_title         = htmlspecialchars($wdg_params['title']        ?? '');
$_description   = htmlspecialchars($wdg_params['description']  ?? '');
$_color         = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');
$_alignment     = $wdg_params['alignment']                     ?? 'left';
$_map_position  = $wdg_params['map_position']                  ?? 'right';
$_map_height    = $wdg_params['map_height']                    ?? 'medium';
$_embed_url     = $wdg_params['embed_url']                     ?? '';
$_address       = htmlspecialchars($wdg_params['address']      ?? '');
$_directions    = $wdg_params['directions_url']                ?? '';
$_sidebar_items = $wdg_params['sidebar_items']                 ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

// ── Αν δοθεί ολόκληρο iframe tag, εξάγουμε το src ────────────────────────────
if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/', $_embed_url, $_iframe_m)) {
    $_embed_url = $_iframe_m[1];
}

// ── Auto-convert URLs to embed ────────────────────────────────────────────────
if ($_embed_url && strpos($_embed_url, 'output=embed') === false && strpos($_embed_url, 'maps/embed') === false) {
    if (preg_match('/@(-?\d+\.?\d*),(-?\d+\.?\d*)/', $_embed_url, $_m)) {
        $_embed_url = 'https://maps.google.com/maps?q=' . $_m[1] . ',' . $_m[2] . '&output=embed&iwloc=&';
    } elseif (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_\-]+)/', $_embed_url, $_m)) {
        $_embed_url = 'https://www.youtube.com/embed/' . $_m[1];
    } elseif (preg_match('/vimeo\.com\/(\d+)/', $_embed_url, $_m)) {
        $_embed_url = 'https://player.vimeo.com/video/' . $_m[1];
    } elseif (preg_match('/dailymotion\.com\/video\/([a-zA-Z0-9]+)/', $_embed_url, $_m)) {
        $_embed_url = 'https://www.dailymotion.com/embed/video/' . $_m[1];
    }
}

$_alignment_class = ($_alignment === 'center') ? 'widget-header--align-center' : 'widget-header--align-start';
$_extra_class     = ($_map_position === 'right') ? ' layout-reverse' : '';
$_section_style   = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

$_has_sidebar = !empty(array_filter($_sidebar_items, function($i){ return !empty($i['title']) || !empty($i['text']); }));
$_wrapper_class = 'map-content-wrapper' . ($_map_position === 'fullwidth' || !$_has_sidebar ? ' no-sidebar' : '');
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-map widget-<?php echo $_widget_id; ?> <?php echo $_color . $_extra_class; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="map"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?> .map-container {
    width: 100%;
    overflow: hidden;
}
.widget-<?php echo $_widget_id; ?> .map-iframe {
    width: 100%;
    border: 0;
    display: block;
}
.widget-<?php echo $_widget_id; ?> .map-iframe.height-small { height: 300px; }
.widget-<?php echo $_widget_id; ?> .map-iframe.height-medium { height: 450px; }
.widget-<?php echo $_widget_id; ?> .map-iframe.height-large { height: 600px; }
.widget-<?php echo $_widget_id; ?> .map-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    align-content: center;
    margin-block-start: var(--space-lg);
    flex-wrap: wrap;
    gap: var(--space-md);
}
.widget-<?php echo $_widget_id; ?> .map-info > .map-address,
.widget-<?php echo $_widget_id; ?> .map-info > .map-directions {
    align-self: center;
}
.widget-<?php echo $_widget_id; ?> .map-address {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
    min-width: 0;
}
.widget-<?php echo $_widget_id; ?> .map-address-icon {
    flex-shrink: 0;
    display: inline-flex;
    margin-block-start: 0.2em;
    color: var(--text-muted);
}
.widget-<?php echo $_widget_id; ?> .map-address-icon .w-icon-plain { display: flex; }
.widget-<?php echo $_widget_id; ?> .map-address-text {
    margin: 0;
    line-height: var(--line-height-relaxed);
}
.widget-<?php echo $_widget_id; ?> .map-directions {
    display: inline-flex;
    align-items: center;
    align-self: center;
    gap: var(--space-xs);
    line-height: var(--line-height-relaxed);
    text-decoration: none;
}
.widget-<?php echo $_widget_id; ?> .map-directions:hover { text-decoration: underline; }
.widget-<?php echo $_widget_id; ?> .map-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: var(--surface-secondary);
    text-align: center;
    padding: var(--space-xl);
}
.widget-<?php echo $_widget_id; ?> .map-placeholder.height-small { height: 300px; }
.widget-<?php echo $_widget_id; ?> .map-placeholder.height-medium { height: 450px; }
.widget-<?php echo $_widget_id; ?> .map-placeholder.height-large { height: 600px; }
.widget-<?php echo $_widget_id; ?> .map-content-wrapper {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-lg);
}
.widget-<?php echo $_widget_id; ?> .map-sidebar {
    display: flex;
    flex-direction: column;
    gap: var(--space-xl);
}
.widget-<?php echo $_widget_id; ?> .map-sidebar-info-block {
    display: flex;
    flex-direction: column;
    gap: var(--space-sm);
}
@media (min-width: 750px) {
    .widget-<?php echo $_widget_id; ?> .map-content-wrapper:not(.no-sidebar) {
        grid-template-columns: 7fr 3fr;
        gap: var(--space-3xl);
    }
    .widget-<?php echo $_widget_id; ?>.layout-reverse .map-content-wrapper:not(.no-sidebar) {
        grid-template-columns: 3fr 7fr;
    }
    .widget-<?php echo $_widget_id; ?>.layout-reverse .map-main { order: 2; }
    .widget-<?php echo $_widget_id; ?>.layout-reverse .map-sidebar { order: 1; }
}
</style>

    <div class="widget-container">

        <?php if ($_eyebrow || $_title || $_description): ?>
        <div class="widget-header <?php echo $_alignment_class; ?>">
            <?php if ($_eyebrow): ?>
            <span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0"><?php echo $_eyebrow; ?></span>
            <?php endif; ?>
            <?php if ($_title): ?>
            <h2 class="w-headline reveal reveal-up" style="--reveal-delay: 1"><?php echo $_title; ?></h2>
            <?php endif; ?>
            <?php if ($_description): ?>
            <p class="w-description reveal reveal-up" style="--reveal-delay: 2"><?php echo $_description; ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="widget-content">
            <div class="<?php echo $_wrapper_class; ?>">

                <div class="map-main">
                    <div class="map-container reveal reveal-fade">
                        <?php if ($_embed_url): ?>
                        <iframe
                            class="map-iframe height-<?php echo htmlspecialchars($_map_height); ?>"
                            src="<?php echo htmlspecialchars($_embed_url); ?>"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Map"
                        ></iframe>
                        <?php else: ?>
                        <div class="map-placeholder height-<?php echo htmlspecialchars($_map_height); ?>">
                            <p>Εισάγετε το Google Maps Embed URL</p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($_address || $_directions): ?>
                    <div class="map-info">
                        <?php if ($_address): ?>
                        <div class="map-address w-body t-sm t-muted">
                            <span class="map-address-icon" aria-hidden="true">
                                <span class="w-icon-plain w-icon-sm">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 7l6 -3l6 3l6 -3v13l-6 3l-6 -3l-6 3v-13" />
                                        <path d="M9 4v13" />
                                        <path d="M15 7v13" />
                                    </svg>
                                </span>
                            </span>
                            <p class="map-address-text"><?php echo $_address; ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if ($_directions): ?>
                        <a href="<?php echo htmlspecialchars($_directions); ?>" class="map-directions w-body t-sm t-accent" target="_blank" rel="noopener">
                            Get Directions →
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if ($_map_position !== 'fullwidth' && $_has_sidebar): ?>
                <div class="map-sidebar">
                    <?php foreach ($_sidebar_items as $i => $_sitem):
                        $_stitle = htmlspecialchars($_sitem['title'] ?? '');
                        $_stext  = nl2br(htmlspecialchars($_sitem['text'] ?? ''));
                        if (!$_stitle && !$_stext) continue;
                        $_blk_id = $_widget_id . '_sidebar' . $i;
                    ?>
                    <div class="map-sidebar-info-block" data-block-id="<?php echo $_blk_id; ?>">
                        <?php if ($_stitle): ?>
                        <h3 class="map-sidebar-title w-title t-xl"><?php echo $_stitle; ?></h3>
                        <?php endif; ?>
                        <?php if ($_stext): ?>
                        <div class="map-sidebar-text w-body w-rte"><p><?php echo $_stext; ?></p></div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
