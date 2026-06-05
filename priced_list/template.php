<?php
/*
 * Widgetizer — Priced List Widget — template.php
 * Prefix: prl
 */
defined('CMS') or die("This file cannot run this way!");

// ── Base assets ───────────────────────────────────────────────────────────────
$_wdg_assets  = 'admin/builder_widget_assets/';
$_wdg_css     = $_wdg_assets . 'base.css';
$_wdg_js      = $_wdg_assets . 'scripts.js';
$_wdg_glb_css = 'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css';
$_wdg_glb_js  = 'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js';

if (!in_array($_wdg_css, $document->loadedFiles)) {
    echo '<link href="' . $_wdg_css . '" rel="stylesheet" type="text/css">' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_css;
}
if (!in_array($_wdg_js, $document->loadedFiles)) {
    echo '<script src="' . $_wdg_js . '" defer></script>' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_js;
}
?>
<script>
(function(){
    var glbCss = "<?php echo $_wdg_glb_css; ?>";
    var glbJs  = "<?php echo $_wdg_glb_js; ?>";
    var links = document.querySelectorAll("link[rel=stylesheet]");
    var cssLoaded = false;
    for (var i = 0; i < links.length; i++) { if (links[i].getAttribute("href") === glbCss) { cssLoaded = true; break; } }
    if (!cssLoaded) { var l = document.createElement("link"); l.rel = "stylesheet"; l.href = glbCss; document.head.appendChild(l); }
    var scripts = document.querySelectorAll("script[src]");
    var jsLoaded = false;
    for (var j = 0; j < scripts.length; j++) { if (scripts[j].getAttribute("src") === glbJs) { jsLoaded = true; break; } }
    if (!jsLoaded) {
        var s = document.createElement("script");
        s.src = glbJs;
        s.onload = function() { document.dispatchEvent(new CustomEvent("glightbox:ready")); };
        document.head.appendChild(s);
    } else {
        document.dispatchEvent(new CustomEvent("glightbox:ready"));
    }
})();
</script>
<?php

// ── Params ────────────────────────────────────────────────────────────────────
$_widget_id   = 'widget_' . $blockID;
$_gallery_id  = 'prl-' . $blockID;
$_eyebrow     = htmlspecialchars($wdg_params['eyebrow']      ?? '');
$_title       = htmlspecialchars($wdg_params['title']        ?? '');
$_description = htmlspecialchars($wdg_params['description']  ?? '');
$_color       = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');
$_alignment   = $wdg_params['alignment']                     ?? 'center';
$_layout      = $wdg_params['layout']                        ?? 'two-column';
$_prl_items   = $wdg_params['items']                         ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_alignment_class = ($_alignment === 'center') ? 'widget-header--align-center' : 'widget-header--align-start';
$_section_style   = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-type-priced-list widget-<?php echo $_widget_id; ?> <?php echo $_color; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="priced-list"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?> .priced-list {
    display: flex;
    flex-direction: column;
    gap: 0;
}
.widget-<?php echo $_widget_id; ?> .priced-list.priced-list--two-column {
    display: flex;
    flex-direction: column;
}
.widget-<?php echo $_widget_id; ?> .priced-row {
    display: grid;
    grid-template-columns: 1fr;
    border-block-end: var(--border-width-thin) solid var(--border-color);
}
.widget-<?php echo $_widget_id; ?> .priced-row:first-child {
    border-block-start: var(--border-width-thin) solid var(--border-color);
}
.widget-<?php echo $_widget_id; ?> .priced-row-cell {
    display: flex;
}
.widget-<?php echo $_widget_id; ?> .priced-list--two-column .priced-row-cell + .priced-row-cell {
    border-block-start: var(--border-width-thin) solid var(--border-color);
}
.widget-<?php echo $_widget_id; ?> .priced-list--two-column .priced-item {
    width: 100%;
    height: 100%;
    border: 0;
}
.widget-<?php echo $_widget_id; ?> .priced-list--two-column .priced-item:first-child {
    border-block-start: 0;
}
.widget-<?php echo $_widget_id; ?> .priced-item {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: var(--space-md);
    padding: var(--space-lg) 0;
    border-block-end: var(--border-width-thin) solid var(--border-color);
    align-items: start;
}
.widget-<?php echo $_widget_id; ?> .priced-item:first-child {
    border-block-start: var(--border-width-thin) solid var(--border-color);
}
.widget-<?php echo $_widget_id; ?> .priced-item-content {
    display: flex;
    flex-direction: column;
    gap: var(--space-xs);
}
.widget-<?php echo $_widget_id; ?> .priced-item-description {
    max-width: 60ch;
}
.widget-<?php echo $_widget_id; ?> .priced-item-price {
    white-space: nowrap;
}
.widget-<?php echo $_widget_id; ?> .priced-item-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: var(--radius-sm);
    margin-inline-start: var(--space-md);
}
.widget-<?php echo $_widget_id; ?> .priced-item-right {
    display: flex;
    align-items: center;
    gap: var(--space-md);
}
@media (min-width: 750px) {
    .widget-<?php echo $_widget_id; ?> .priced-list--two-column .priced-row {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    .widget-<?php echo $_widget_id; ?> .priced-list--two-column .priced-row-cell:first-child {
        padding-inline-end: var(--space-xl);
    }
    .widget-<?php echo $_widget_id; ?> .priced-list--two-column .priced-row-cell + .priced-row-cell {
        padding-inline-start: var(--space-xl);
        border-block-start: 0;
        border-inline-start: var(--border-width-thin) solid var(--border-color);
    }
}
@media (max-width: 749px) {
    .widget-<?php echo $_widget_id; ?> .priced-item {
        grid-template-columns: 1fr;
    }
    .widget-<?php echo $_widget_id; ?> .priced-item-right {
        justify-content: space-between;
        margin-block-start: var(--space-sm);
    }
    .widget-<?php echo $_widget_id; ?> .priced-item-image {
        width: 60px;
        height: 60px;
    }
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
            <?php if ($_layout === 'two-column'):
                $_chunks = array_chunk($_prl_items, 2);
                $_idx = 0;
            ?>
            <div class="priced-list priced-list--two-column">
                <?php foreach ($_chunks as $_chunk): ?>
                <div class="priced-row">
                    <?php foreach ($_chunk as $_item):
                        $_iname  = htmlspecialchars($_item['name']        ?? '');
                        $_idesc  = htmlspecialchars($_item['description'] ?? '');
                        $_iprice = htmlspecialchars($_item['price']       ?? '');
                        $_iimg   = htmlspecialchars($_item['image']       ?? '');
                        $_iimg_full = htmlspecialchars($_item['image_full'] ?? $_item['image'] ?? '');
                        $_blk_id = $_widget_id . '_prl' . $_idx;
                    ?>
                    <div class="priced-row-cell">
                        <div class="priced-item reveal reveal-up" style="--reveal-delay: <?php echo $_idx; ?>" data-block-id="<?php echo $_blk_id; ?>">
                            <div class="priced-item-content">
                                <h3 class="priced-item-name w-title t-xl"><?php echo $_iname; ?></h3>
                                <?php if ($_idesc): ?>
                                <div class="priced-item-description w-body w-rte t-sm"><p><?php echo nl2br($_idesc); ?></p></div>
                                <?php endif; ?>
                            </div>
                            <div class="priced-item-right">
                                <span class="priced-item-price w-body t-lg t-heading"><?php echo $_iprice; ?></span>
                                <?php if ($_iimg): ?>
                                <a href="<?php echo $_iimg_full; ?>" class="glightbox" data-gallery="<?php echo $_gallery_id; ?>">
                                    <img src="<?php echo $_iimg; ?>" alt="<?php echo $_iname; ?>" class="priced-item-image" width="80" height="80" loading="lazy" style="width:80px !important;height:80px !important;">
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php $_idx++; endforeach; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="priced-list">
                <?php foreach ($_prl_items as $i => $_item):
                    $_iname  = htmlspecialchars($_item['name']        ?? '');
                    $_idesc  = htmlspecialchars($_item['description'] ?? '');
                    $_iprice = htmlspecialchars($_item['price']       ?? '');
                    $_iimg   = htmlspecialchars($_item['image']       ?? '');
                    $_iimg_full = htmlspecialchars($_item['image_full'] ?? $_item['image'] ?? '');
                    $_blk_id = $_widget_id . '_prl' . $i;
                ?>
                <div class="priced-item reveal reveal-up" style="--reveal-delay: <?php echo $i; ?>" data-block-id="<?php echo $_blk_id; ?>">
                    <div class="priced-item-content">
                        <h3 class="priced-item-name w-title t-xl"><?php echo $_iname; ?></h3>
                        <?php if ($_idesc): ?>
                        <div class="priced-item-description w-body w-rte t-sm"><p><?php echo nl2br($_idesc); ?></p></div>
                        <?php endif; ?>
                    </div>
                    <div class="priced-item-right">
                        <span class="priced-item-price w-body t-lg t-heading"><?php echo $_iprice; ?></span>
                        <?php if ($_iimg): ?>
                        <a href="<?php echo $_iimg_full; ?>" class="glightbox" data-gallery="<?php echo $_gallery_id; ?>">
                            <img src="<?php echo $_iimg; ?>" alt="<?php echo $_iname; ?>" class="priced-item-image" width="80" height="80" loading="lazy" style="width:80px !important;height:80px !important;">
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php
$_widget_id_js  = 'widget_' . $blockID;
$_gallery_id_js = 'prl-' . $blockID;
$_script = <<<JSEOF
<script>
(function(){
    function run() {
        if (typeof GLightbox !== 'undefined') {
            GLightbox({ selector: '.glightbox[data-gallery="{$_gallery_id_js}"]', touchNavigation: true, loop: true });
        } else {
            document.addEventListener('glightbox:ready', function() {
                GLightbox({ selector: '.glightbox[data-gallery="{$_gallery_id_js}"]', touchNavigation: true, loop: true });
            }, { once: true });
        }
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run);
    } else {
        requestAnimationFrame(function() { requestAnimationFrame(run); });
    }
})();
</script>
JSEOF;
echo $_script;
?>
