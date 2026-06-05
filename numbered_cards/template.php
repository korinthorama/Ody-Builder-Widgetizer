<?php
/*
 * Widgetizer — Numbered Cards Widget — template.php
 * Prefix: numc
 */
defined('CMS') or die("This file cannot run this way!");

// ── Base assets ───────────────────────────────────────────────────────────────
$_wdg_assets   = 'admin/builder_widget_assets/';
$_wdg_css      = $_wdg_assets . 'base.css';
$_wdg_js       = $_wdg_assets . 'scripts.js';
$_wdg_carousel = $_wdg_assets . 'carousel.js';

if (!in_array($_wdg_css, $document->loadedFiles)) {
    echo '<link href="' . $_wdg_css . '" rel="stylesheet" type="text/css">' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_css;
}
if (!in_array($_wdg_js, $document->loadedFiles)) {
    echo '<script src="' . $_wdg_js . '" defer></script>' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_js;
}

// ── Params ────────────────────────────────────────────────────────────────────
$_widget_id        = 'widget_' . $blockID;
$_eyebrow          = htmlspecialchars($wdg_params['eyebrow']          ?? '');
$_title            = htmlspecialchars($wdg_params['title']            ?? '');
$_description      = htmlspecialchars($wdg_params['description']      ?? '');
$_color            = htmlspecialchars($wdg_params['color_scheme']     ?? 'color-scheme-standard-primary');
$_header_alignment = $wdg_params['header_alignment']                  ?? 'center';
$_layout           = $wdg_params['layout']                            ?? 'grid';
$_card_layout      = $wdg_params['card_layout']                       ?? 'box';
$_carousel_cols    = (int)($wdg_params['carousel_cols']               ?? 4);
$_item_alignment   = $wdg_params['item_alignment']                    ?? 'center';
$_numc_items       = $wdg_params['items']                             ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_layout_class    = ($_card_layout === 'flat') ? ' card-layout-flat' : '';
$_alignment_class = ($_header_alignment === 'center') ? 'widget-header--align-center' : 'widget-header--align-start';
$_align_class     = 'widget-content-align-' . $_item_alignment;

$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

// carousel.js — φόρτωση μόνο αν carousel
if ($_layout === 'carousel' && !in_array($_wdg_carousel, $document->loadedFiles)) {
    echo '<script src="' . $_wdg_carousel . '" defer></script>' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_carousel;
}
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-numbered-cards widget-<?php echo $_widget_id; ?> <?php echo $_color . $_layout_class; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="numbered-cards"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?> .widget-card-number {
    font-size: calc(var(--font-size-5xl) * var(--heading-scale));
    line-height: 1;
    margin: 0;
    margin-block-end: var(--space-md);
    color: var(--text-muted);
    text-align: center;
    inline-size: 100%;
}
.widget-<?php echo $_widget_id; ?>:not(.card-layout-flat).color-scheme-standard-secondary .widget-card,
.widget-<?php echo $_widget_id; ?>:not(.card-layout-flat).color-scheme-highlight-secondary .widget-card {
    background-color: var(--bg-secondary);
}
.widget-<?php echo $_widget_id; ?>:not(.card-layout-flat).color-scheme-standard-secondary .widget-card,
.widget-<?php echo $_widget_id; ?>:not(.card-layout-flat).color-scheme-highlight-primary .widget-card,
.widget-<?php echo $_widget_id; ?>:not(.card-layout-flat).color-scheme-highlight-secondary .widget-card {
    border: var(--border-width-thin) solid var(--border-color);
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
            <div class="carousel-container reveal reveal-up">
                <button type="button" class="carousel-btn carousel-btn-prev" aria-label="Previous">
                    <svg class="carousel-btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M15 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <button type="button" class="carousel-btn carousel-btn-next" aria-label="Next">
                    <svg class="carousel-btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 18l6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <ul class="widget-card-grid carousel-track" style="--carousel-cols: <?php echo $_carousel_cols; ?>">
                    <?php foreach ($_numc_items as $i => $_item):
                        $_ititle = htmlspecialchars($_item['title']       ?? '');
                        $_idesc  = htmlspecialchars($_item['description'] ?? '');
                        $_blk_id = $_widget_id . '_card' . $i;
                        $_num    = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
                    ?>
                    <li class="widget-card carousel-item" data-block-id="<?php echo $_blk_id; ?>">
                        <div class="widget-card-number"><?php echo $_num; ?></div>
                        <div class="widget-card-content <?php echo $_align_class; ?>">
                            <?php if ($_ititle): ?>
                            <h3 class="w-title t-xl"><?php echo $_ititle; ?></h3>
                            <?php endif; ?>
                            <?php if ($_idesc): ?>
                            <div class="w-body w-rte t-sm"><p><?php echo nl2br($_idesc); ?></p></div>
                            <?php endif; ?>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php else: ?>
            <ul class="widget-card-grid widget-grid" style="--grid-cols-desktop: <?php echo $_carousel_cols; ?>">
                <?php foreach ($_numc_items as $i => $_item):
                    $_ititle = htmlspecialchars($_item['title']       ?? '');
                    $_idesc  = htmlspecialchars($_item['description'] ?? '');
                    $_blk_id = $_widget_id . '_card' . $i;
                    $_num    = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
                ?>
                <li class="widget-card reveal reveal-up" style="--reveal-delay: <?php echo $i; ?>" data-block-id="<?php echo $_blk_id; ?>">
                    <div class="widget-card-number"><?php echo $_num; ?></div>
                    <div class="widget-card-content <?php echo $_align_class; ?>">
                        <?php if ($_ititle): ?>
                        <h3 class="w-title t-xl"><?php echo $_ititle; ?></h3>
                        <?php endif; ?>
                        <?php if ($_idesc): ?>
                        <div class="w-body w-rte t-sm"><p><?php echo nl2br($_idesc); ?></p></div>
                        <?php endif; ?>
                    </div>
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
(function(){
    function run() {
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
                nextBtn.addEventListener('click', function() { track.scrollBy({ left:  getScrollAmount(), behavior: 'smooth' }); });
                track.addEventListener('scroll', updateButtons, { passive: true });
                new ResizeObserver(updateButtons).observe(track);
                updateButtons();
            }
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
endif;
?>
