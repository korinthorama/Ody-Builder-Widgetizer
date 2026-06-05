<?php
/*
 * Widgetizer — Logo Cloud Widget — template.php
 * Prefix: lcld
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
$_eyebrow       = htmlspecialchars($wdg_params['eyebrow']       ?? '');
$_title         = htmlspecialchars($wdg_params['title']         ?? '');
$_description   = htmlspecialchars($wdg_params['description']   ?? '');
$_layout        = $wdg_params['layout']                         ?? 'grid';
$_alignment     = htmlspecialchars($wdg_params['alignment']     ?? 'left');
$_aspect_ratio  = $wdg_params['aspect_ratio']                   ?? 'auto';
$_card_layout   = htmlspecialchars($wdg_params['card_layout']   ?? 'flat');
$_carousel_cols = (int)($wdg_params['carousel_cols']            ?? 5);
$_color         = htmlspecialchars($wdg_params['color_scheme']  ?? 'color-scheme-standard-primary');
$_items         = $wdg_params['items'] ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_layout_class    = ($_card_layout === 'flat') ? 'card-layout-flat' : 'card-layout-card';
$_alignment_class = ($_alignment === 'center') ? 'widget-header--align-center' : 'widget-header--align-start';
$_ar_val          = ($_aspect_ratio === 'auto') ? 'auto' : $_aspect_ratio;

$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-type-logo-cloud widget-<?php echo $_widget_id; ?> <?php echo $_color . ' ' . $_layout_class; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="logo-cloud"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?> .logo-grid {
    list-style: none;
    padding: 0;
    margin: 0;
    align-items: center;
    justify-items: center;
}
.widget-<?php echo $_widget_id; ?> .logo-item {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: var(--space-sm);
    background-color: var(--bg-primary);
    border: var(--border-width-thin) solid var(--border-color);
    border-radius: var(--radius-sm);
    min-height: 110px;
    overflow: hidden;
    aspect-ratio: <?php echo $_ar_val; ?>;
}
.widget-<?php echo $_widget_id; ?>.card-layout-flat .logo-item {
    background-color: transparent;
    border: none;
    border-radius: 0;
    padding: 10px 0;
    min-height: auto;
}
.widget-<?php echo $_widget_id; ?> .logo-link,
.widget-<?php echo $_widget_id; ?> .logo-frame {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.widget-<?php echo $_widget_id; ?> .logo-image {
    width: 100%;
    height: 100%;
    max-width: 100%;
    object-fit: contain;
    object-position: center;
    filter: grayscale(100%);
    opacity: 0.6;
    transition: opacity 0.3s, filter 0.3s;
    display: block;
}
.widget-<?php echo $_widget_id; ?> .logo-image:hover {
    opacity: 1;
    filter: grayscale(0%);
}
@media (min-width: 750px) {
    .widget-<?php echo $_widget_id; ?>:not(.card-layout-flat) .logo-item {
        min-height: 120px;
    }
}
@media (min-width: 990px) {
    .widget-<?php echo $_widget_id; ?>:not(.card-layout-flat) .logo-item {
        min-height: 130px;
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
            <?php if ($_layout === 'carousel'): ?>
            <div class="carousel-container">
                <button type="button" class="carousel-btn carousel-btn-prev" aria-label="Previous">
                    <svg class="carousel-btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M15 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <button type="button" class="carousel-btn carousel-btn-next" aria-label="Next">
                    <svg class="carousel-btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 18l6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <ul class="logo-grid carousel-track" style="--carousel-cols: <?php echo $_carousel_cols; ?>">
                    <?php foreach ($_items as $i => $_item):
                        $_img     = htmlspecialchars($_item['image']   ?? '');
                        $_alt     = htmlspecialchars($_item['alt']     ?? '');
                        $_url     = htmlspecialchars(wdg_parse_links($_item['url'] ?? ''));
                        $_new_tab = ($_item['new_tab'] ?? '0') === '1';
                        $_blk_id  = $_widget_id . '_logo' . $i;
                        if (!$_img) continue;
                    ?>
                    <li class="logo-item carousel-item" data-block-id="<?php echo $_blk_id; ?>">
                        <?php if ($_url): ?>
                        <a href="<?php echo $_url; ?>" class="logo-link" <?php echo $_new_tab ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                            <img src="<?php echo $_img; ?>" alt="<?php echo $_alt; ?>" class="logo-image" width="160" height="40" loading="lazy">
                        </a>
                        <?php else: ?>
                        <div class="logo-frame has-image">
                            <img src="<?php echo $_img; ?>" alt="<?php echo $_alt; ?>" class="logo-image" width="160" height="40" loading="lazy">
                        </div>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php else: ?>
            <ul class="logo-grid widget-grid" style="--grid-cols-desktop: <?php echo $_carousel_cols; ?>">
                <?php foreach ($_items as $i => $_item):
                    $_img     = htmlspecialchars($_item['image']   ?? '');
                    $_alt     = htmlspecialchars($_item['alt']     ?? '');
                    $_url     = htmlspecialchars(wdg_parse_links($_item['url'] ?? ''));
                    $_new_tab = ($_item['new_tab'] ?? '0') === '1';
                    $_blk_id  = $_widget_id . '_logo' . $i;
                    if (!$_img) continue;
                ?>
                <li class="logo-item reveal reveal-fade" style="--reveal-delay: <?php echo $i; ?>" data-block-id="<?php echo $_blk_id; ?>">
                    <?php if ($_url): ?>
                    <a href="<?php echo $_url; ?>" class="logo-link" <?php echo $_new_tab ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                        <img src="<?php echo $_img; ?>" alt="<?php echo $_alt; ?>" class="logo-image" width="160" height="40" loading="lazy">
                    </a>
                    <?php else: ?>
                    <div class="logo-frame has-image">
                        <img src="<?php echo $_img; ?>" alt="<?php echo $_alt; ?>" class="logo-image" width="160" height="40" loading="lazy">
                    </div>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php if ($_layout === 'carousel'):
$_widget_id_js = 'widget_' . $blockID;
$_script = <<<JSEOF
<script>
(function () {
    requestAnimationFrame(function () {
        requestAnimationFrame(function () {
            var section = document.getElementById('{$_widget_id_js}');
            if (!section) return;
            var carouselContainer = section.querySelector('.carousel-container');
            if (carouselContainer && !carouselContainer.dataset.carouselInit) {
                carouselContainer.dataset.carouselInit = 'true';
                var track   = carouselContainer.querySelector('.carousel-track');
                var prevBtn = carouselContainer.querySelector('.carousel-btn-prev');
                var nextBtn = carouselContainer.querySelector('.carousel-btn-next');
                if (track && prevBtn && nextBtn) {
                    var updateButtons = function() {
                        prevBtn.disabled = track.scrollLeft <= 1;
                        nextBtn.disabled = track.scrollLeft + track.clientWidth >= track.scrollWidth - 1;
                    };
                    var getScrollAmount = function() {
                        var item = track.querySelector('.carousel-item');
                        if (!item) return track.clientWidth;
                        var gap = parseFloat(getComputedStyle(track).gap) || 0;
                        return item.offsetWidth + gap;
                    };
                    prevBtn.addEventListener('click', function() { track.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' }); });
                    nextBtn.addEventListener('click', function() { track.scrollBy({ left: getScrollAmount(), behavior: 'smooth' }); });
                    track.addEventListener('scroll', updateButtons, { passive: true });
                    new ResizeObserver(updateButtons).observe(track);
                    updateButtons();
                }
            }
        });
    });
})();
</script>
JSEOF;
echo $_script;
endif;
?>
