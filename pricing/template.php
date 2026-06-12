<?php
/*
 * Widgetizer — Pricing Widget — template.php
 * Prefix: prng
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
$_widget_id        = 'widget_' . $blockID;
$_eyebrow          = htmlspecialchars($wdg_params['eyebrow']          ?? '');
$_title            = htmlspecialchars($wdg_params['title']            ?? '');
$_description      = htmlspecialchars($wdg_params['description']      ?? '');
$_color            = htmlspecialchars($wdg_params['color_scheme']     ?? 'color-scheme-standard-primary');
$_header_alignment = $wdg_params['header_alignment']                  ?? 'center';
$_layout           = $wdg_params['layout']                            ?? 'grid';
$_columns          = (int)($wdg_params['columns']                     ?? 3);
$_prng_items       = $wdg_params['items']                             ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_alignment_class = ($_header_alignment === 'center') ? 'widget-header--align-center' : 'widget-header--align-start';
$_section_style   = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

$_check_svg = '<svg class="icon feature-icon-svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5l10 -10"/></svg>';
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-type-pricing widget-<?php echo $_widget_id; ?> <?php echo $_color; ?> no_collapse"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="pricing"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?> .widget-card.is-featured {
    border-color: var(--accent);
    border-width: var(--border-width-medium);
}
.widget-<?php echo $_widget_id; ?> .widget-card-header {
    text-align: center;
}
.widget-<?php echo $_widget_id; ?> .pricing-price {
    font-size: calc(var(--font-size-5xl) * var(--heading-scale));
    font-weight: var(--font-weight-bold);
    line-height: var(--line-height-tight);
    color: var(--text-heading);
    margin: 0;
    margin-block-start: var(--space-sm);
}
.widget-<?php echo $_widget_id; ?> .pricing-features {
    list-style: none;
    padding: 0;
    margin: 0;
    flex: 1;
}
.widget-<?php echo $_widget_id; ?> .pricing-feature {
    padding: var(--space-md) 0;
    border-block-end: var(--border-width-thin) solid var(--border-color);
    display: flex;
    gap: var(--space-sm);
    align-items: center;
}
.widget-<?php echo $_widget_id; ?> .pricing-feature:first-child {
    border-block-start: var(--border-width-thin) solid var(--border-color);
}
.widget-<?php echo $_widget_id; ?> .pricing-feature:last-child {
    border-block-end: none;
    padding-block-end: var(--space-lg);
}
.widget-<?php echo $_widget_id; ?> .feature-icon {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    width: 13px;
    height: 13px;
    color: var(--accent);
}
.widget-<?php echo $_widget_id; ?>.color-scheme-standard-secondary .widget-card,
.widget-<?php echo $_widget_id; ?>.color-scheme-highlight-secondary .widget-card {
    background-color: var(--bg-secondary);
}
.widget-<?php echo $_widget_id; ?>.color-scheme-standard-secondary .widget-card:not(.is-featured),
.widget-<?php echo $_widget_id; ?>.color-scheme-highlight-primary .widget-card:not(.is-featured),
.widget-<?php echo $_widget_id; ?>.color-scheme-highlight-secondary .widget-card:not(.is-featured) {
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
                <ul class="widget-card-grid carousel-track" style="--carousel-cols: <?php echo $_columns; ?>">
                    <?php foreach ($_prng_items as $i => $_item):
                        $_ititle    = htmlspecialchars($_item['title']       ?? '');
                        $_iprice    = htmlspecialchars($_item['price']       ?? '');
                        $_iperiod   = htmlspecialchars($_item['period']      ?? '');
                        $_ifeatures = $_item['features']                    ?? '';
                        $_ibtn_text = htmlspecialchars($_item['button_text'] ?? '');
                        $_ibtn_url  = htmlspecialchars(wdg_parse_links($_item['button_url'] ?? ''));
                        $_ibtn_tab  = ($_item['button_new_tab'] ?? '0') === '1';
                        $_featured  = ($_item['is_featured']    ?? '0') === '1';
                        $_blk_id    = $_widget_id . '_plan' . $i;
                        $_feat_list = $_ifeatures ? array_filter(array_map('trim', explode('|||', $_ifeatures))) : [];
                    ?>
                    <li class="widget-card carousel-item<?php echo $_featured ? ' is-featured' : ''; ?>" style="--reveal-delay: <?php echo $i; ?>" data-block-id="<?php echo $_blk_id; ?>">
                        <div class="widget-card-header">
                            <h3 class="w-title t-xl"><?php echo $_ititle; ?></h3>
                            <div class="pricing-price"><?php echo $_iprice; ?></div>
                            <?php if ($_iperiod): ?><div class="w-meta"><?php echo $_iperiod; ?></div><?php endif; ?>
                        </div>
                        <div class="widget-card-content">
                            <ul class="pricing-features">
                                <?php foreach ($_feat_list as $_feat): ?>
                                <li class="pricing-feature w-body t-base">
                                    <span class="feature-icon"><?php echo $_check_svg; ?></span>
                                    <span><?php echo htmlspecialchars($_feat); ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="widget-card-footer">
                            <?php if ($_ibtn_url || $_ibtn_text): ?>
                            <a href="<?php echo $_ibtn_url ?: '#'; ?>" class="widget-button widget-button-full" <?php echo $_ibtn_tab ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>><?php echo $_ibtn_text ?: 'Get Started'; ?></a>
                            <?php endif; ?>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php else: ?>
            <ul class="widget-card-grid widget-grid" style="--grid-cols-desktop: <?php echo $_columns; ?>">
                <?php foreach ($_prng_items as $i => $_item):
                    $_ititle    = htmlspecialchars($_item['title']       ?? '');
                    $_iprice    = htmlspecialchars($_item['price']       ?? '');
                    $_iperiod   = htmlspecialchars($_item['period']      ?? '');
                    $_ifeatures = $_item['features']                    ?? '';
                    $_ibtn_text = htmlspecialchars($_item['button_text'] ?? '');
                    $_ibtn_url  = htmlspecialchars(wdg_parse_links($_item['button_url'] ?? ''));
                    $_ibtn_tab  = ($_item['button_new_tab'] ?? '0') === '1';
                    $_featured  = ($_item['is_featured']    ?? '0') === '1';
                    $_blk_id    = $_widget_id . '_plan' . $i;
                    $_feat_list = $_ifeatures ? array_filter(array_map('trim', explode('|||', $_ifeatures))) : [];
                ?>
                <li class="widget-card reveal reveal-up<?php echo $_featured ? ' is-featured' : ''; ?>" style="--reveal-delay: <?php echo $i; ?>" data-block-id="<?php echo $_blk_id; ?>">
                    <div class="widget-card-header">
                        <h3 class="w-title t-xl"><?php echo $_ititle; ?></h3>
                        <div class="pricing-price"><?php echo $_iprice; ?></div>
                        <?php if ($_iperiod): ?><div class="w-meta"><?php echo $_iperiod; ?></div><?php endif; ?>
                    </div>
                    <div class="widget-card-content">
                        <ul class="pricing-features">
                            <?php foreach ($_feat_list as $_feat): ?>
                            <li class="pricing-feature w-body t-base">
                                <span class="feature-icon"><?php echo $_check_svg; ?></span>
                                <span><?php echo htmlspecialchars($_feat); ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="widget-card-footer">
                        <?php if ($_ibtn_url || $_ibtn_text): ?>
                        <a href="<?php echo $_ibtn_url ?: '#'; ?>" class="widget-button widget-button-full" <?php echo $_ibtn_tab ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>><?php echo $_ibtn_text ?: 'Get Started'; ?></a>
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
        var cc = section.querySelector('.carousel-container');
        if (cc && !cc.dataset.carouselInit) {
            cc.dataset.carouselInit = 'true';
            var track = cc.querySelector('.carousel-track');
            var prev  = cc.querySelector('.carousel-btn-prev');
            var next  = cc.querySelector('.carousel-btn-next');
            if (track && prev && next) {
                var upd = function() {
                    prev.disabled = track.scrollLeft <= 0;
                    next.disabled = track.scrollLeft + track.clientWidth >= track.scrollWidth - 1;
                };
                var amt = function() {
                    var item = track.querySelector('.carousel-item');
                    if (!item) return track.clientWidth;
                    return item.offsetWidth + (parseFloat(getComputedStyle(track).gap) || 0);
                };
                prev.addEventListener('click', function() { track.scrollBy({ left: -amt(), behavior: 'smooth' }); });
                next.addEventListener('click', function() { track.scrollBy({ left:  amt(), behavior: 'smooth' }); });
                track.addEventListener('scroll', upd, { passive: true });
                new ResizeObserver(function() { requestAnimationFrame(upd); }).observe(cc);
                upd();
            }
        }
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', run);
    else requestAnimationFrame(function() { requestAnimationFrame(run); });
})();
</script>
JSEOF;
echo $_script;
endif;
?>
