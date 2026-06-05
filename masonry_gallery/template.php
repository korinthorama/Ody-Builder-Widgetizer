<?php
/*
 * Widgetizer — Masonry Gallery Widget — template.php
 * Prefix: mgal
 */
defined('CMS') or die("This file cannot run this way!");

// ── Base assets ───────────────────────────────────────────────────────────────
$_wdg_assets     = 'admin/builder_widget_assets/';
$_wdg_css        = $_wdg_assets . 'base.css';
$_wdg_js         = $_wdg_assets . 'scripts.js';
$_wdg_masonry_js = $_wdg_assets . 'masonry.js';
$_wdg_glb_css    = 'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css';
$_wdg_glb_js     = 'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js';

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
    var masonryJs = "<?php echo $_wdg_masonry_js; ?>";
    var glbCss    = "<?php echo $_wdg_glb_css; ?>";
    var glbJs     = "<?php echo $_wdg_glb_js; ?>";

    var scripts = document.querySelectorAll("script[src]");
    var masonryLoaded = false;
    for (var i = 0; i < scripts.length; i++) { if (scripts[i].getAttribute("src") === masonryJs) { masonryLoaded = true; break; } }
    if (!masonryLoaded) { var ms = document.createElement("script"); ms.src = masonryJs; document.head.appendChild(ms); }

    var links = document.querySelectorAll("link[rel=stylesheet]");
    var glbCssLoaded = false;
    for (var j = 0; j < links.length; j++) { if (links[j].getAttribute("href") === glbCss) { glbCssLoaded = true; break; } }
    if (!glbCssLoaded) { var gl = document.createElement("link"); gl.rel = "stylesheet"; gl.href = glbCss; document.head.appendChild(gl); }

    var scripts2 = document.querySelectorAll("script[src]");
    var glbLoaded = false;
    for (var k = 0; k < scripts2.length; k++) { if (scripts2[k].getAttribute("src") === glbJs) { glbLoaded = true; break; } }
    if (!glbLoaded) {
        var gs = document.createElement("script");
        gs.src = glbJs;
        gs.onload = function() { document.dispatchEvent(new CustomEvent("glightbox:ready")); };
        document.head.appendChild(gs);
    } else {
        document.dispatchEvent(new CustomEvent("glightbox:ready"));
    }
})();
</script>
<?php

// ── Params ────────────────────────────────────────────────────────────────────
$_widget_id        = 'widget_' . $blockID;
$_eyebrow          = htmlspecialchars($wdg_params['eyebrow']          ?? '');
$_title            = htmlspecialchars($wdg_params['title']            ?? '');
$_description      = htmlspecialchars($wdg_params['description']      ?? '');
$_color            = htmlspecialchars($wdg_params['color_scheme']     ?? 'color-scheme-standard-primary');
$_header_alignment = $wdg_params['header_alignment']                  ?? 'left';
$_columns          = (int)($wdg_params['columns']                     ?? 4);
$_spacing          = $wdg_params['spacing']                           ?? 'small';
$_item_alignment   = $wdg_params['item_alignment']                    ?? 'center';
$_mgal_items       = $wdg_params['items']                             ?? [];
$_show_border      = ($wdg_params['show_border'] ?? '0') === '1';

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_alignment_class = ($_header_alignment === 'center') ? 'widget-header--align-center' : 'widget-header--align-start';
$_align_class     = 'widget-content-align-' . $_item_alignment;
$_border_css      = $_show_border
    ? '.widget-' . $_widget_id . ' .widget-card { border: var(--card-border) !important; }'
    : '.widget-' . $_widget_id . ' .widget-card { border: none !important; }';
$_gallery_id      = 'gallery-' . $blockID;

$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-type-masonry-gallery widget-<?php echo $_widget_id; ?> <?php echo $_color; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="masonry-gallery"
    data-masonry-cols="<?php echo $_columns; ?>"
    data-masonry-gap="<?php echo htmlspecialchars($_spacing); ?>"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?> .masonry-grid {
    position: relative;
}
.widget-<?php echo $_widget_id; ?> .widget-card {
    position: absolute;
    padding: 0;
    overflow: hidden;
    box-sizing: border-box;
    visibility: hidden;
    cursor: pointer;
}
.widget-<?php echo $_widget_id; ?> .widget-card:hover .widget-card-image {
    opacity: 0.9;
}
.widget-<?php echo $_widget_id; ?> .widget-card.is-positioned {
    visibility: visible;
}
.widget-<?php echo $_widget_id; ?> .widget-card-image {
    width: 100%;
    height: auto;
    aspect-ratio: auto;
    object-fit: unset;
    display: block;
    transition: opacity 0.3s;
    margin-block-end: 0;
    border-radius: 0;
}
.widget-<?php echo $_widget_id; ?> .widget-card-content {
    padding: var(--space-md);
}
.widget-<?php echo $_widget_id; ?> .widget-card-category {
    margin: 0;
}
.widget-<?php echo $_widget_id; ?>.color-scheme-standard-secondary .widget-card,
.widget-<?php echo $_widget_id; ?>.color-scheme-highlight-secondary .widget-card {
    background-color: var(--bg-secondary);
}
.widget-<?php echo $_widget_id; ?>.color-scheme-standard-secondary .widget-card,
.widget-<?php echo $_widget_id; ?>.color-scheme-highlight-primary .widget-card,
.widget-<?php echo $_widget_id; ?>.color-scheme-highlight-secondary .widget-card {
    border: var(--border-width-thin) solid var(--border-color);
}
<?php echo $_border_css; ?>
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
            <div class="masonry-grid">
                <?php foreach ($_mgal_items as $i => $_item):
                    $_img     = htmlspecialchars($_item['image']    ?? '');
                    $_heading = htmlspecialchars($_item['heading']  ?? '');
                    $_cat     = htmlspecialchars($_item['category'] ?? '');
                    $_blk_id  = $_widget_id . '_img' . $i;
                    if (!$_img) continue;
                    $_has_content = ($_heading !== '' || $_cat !== '');
                    $_caption_val = $_heading ?: $_cat;
                ?>
                <div
                    class="widget-card reveal reveal-fade"
                    style="--reveal-delay: <?php echo $i; ?>"
                    data-block-id="<?php echo $_blk_id; ?>"
                    data-caption="<?php echo $_caption_val; ?>"
                >
                    <a href="<?php echo $_img; ?>"
                       class="glightbox"
                       data-gallery="<?php echo $_gallery_id; ?>"
                       <?php if ($_caption_val): ?>data-glightbox="description: <?php echo htmlspecialchars($_caption_val); ?>"<?php endif; ?>
                    >
                        <img src="<?php echo $_img; ?>" alt="<?php echo $_caption_val; ?>" class="widget-card-image" width="400" height="300" loading="lazy">
                    </a>
                    <?php if ($_has_content): ?>
                    <div class="widget-card-content <?php echo $_align_class; ?>">
                        <?php if ($_heading): ?>
                        <h3 class="w-title t-xl"><?php echo $_heading; ?></h3>
                        <?php endif; ?>
                        <?php if ($_cat): ?>
                        <p class="widget-card-category w-meta t-sm"><?php echo $_cat; ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php
$_widget_id_js = 'widget_' . $blockID;
$_gallery_id_js = 'gallery-' . $blockID;
$_script = <<<JSEOF
<script>
(function(){
    var sectionId = '{$_widget_id_js}';
    var galleryId = '{$_gallery_id_js}';

    function run() {
        var section = document.getElementById(sectionId);
        if (!section) return;
        if (typeof GLightbox !== 'undefined') {
            GLightbox({ selector: '.glightbox[data-gallery="' + galleryId + '"]', touchNavigation: true, loop: true });
        } else {
            document.addEventListener('glightbox:ready', function() {
                GLightbox({ selector: '.glightbox[data-gallery="' + galleryId + '"]', touchNavigation: true, loop: true });
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
