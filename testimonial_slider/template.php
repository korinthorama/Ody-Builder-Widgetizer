<?php
/*
 * Widgetizer — Testimonial Slider Widget — template.php
 * Prefix: tesl
 * Refactored: Pure PHP output, flat CSS, fade transition
 * No base64 — uses [nl] for line breaks
 */
defined('CMS') or die("This file cannot run this way!");

// ── Base assets ───────────────────────────────────────────────────────────────
$_wdg_assets = 'admin/builder_widget_assets/';
$_wdg_css    = $_wdg_assets . 'base.css';
$_wdg_js     = $_wdg_assets . 'scripts.js';
$_tesl_js    = $_wdg_assets . 'testimonial-slider.js';

// Base CSS
$_base_css_exists = false;
foreach ($document->loadedFiles as $_f) {
    if (strpos($_f, 'base.css') !== false) { $_base_css_exists = true; break; }
}
if (!$_base_css_exists) {
    echo '<link href="' . $_wdg_css . '" rel="stylesheet" type="text/css">' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_css;
}

// scripts.js
$_scripts_js_exists = false;
foreach ($document->loadedFiles as $_f) {
    if (strpos($_f, 'scripts.js') !== false) { $_scripts_js_exists = true; break; }
}
if (!$_scripts_js_exists) {
    echo '<script src="' . $_wdg_js . '"></script>' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_js;
}

// testimonial-slider.js (DOM check)
echo '<script>
(function(){
    var jsHref = "' . $_tesl_js . '";
    var scripts = document.querySelectorAll("script[src]");
    var loaded = false;
    for (var i = 0; i < scripts.length; i++) {
        if (scripts[i].getAttribute("src") === jsHref) { loaded = true; break; }
    }
    if (!loaded) { var s = document.createElement("script"); s.src = jsHref; document.head.appendChild(s); }
})();
</script>' . PHP_EOL;

// ── Params ────────────────────────────────────────────────────────────────────
$_widget_id      = 'widget_' . $blockID;
$_show_header    = ($wdg_params['show_header']    ?? '0') === '1';
$_eyebrow        = htmlspecialchars($wdg_params['eyebrow']        ?? '');
$_title          = htmlspecialchars($wdg_params['title']          ?? '');
$_title_size     = htmlspecialchars($wdg_params['title_size']     ?? 't-2xl');

// ── Description: NO base64, only [nl] to \n ───────────────────────────────────
$_description_raw = $wdg_params['description'] ?? '';
$_description_with_nl = str_replace('[nl]', "\n", $_description_raw);
$_description = nl2br(htmlspecialchars($_description_with_nl));

$_header_align   = $wdg_params['header_align'] ?? 'center';
$_autoplay       = ($wdg_params['autoplay'] ?? '0') === '1' ? 'true' : 'false';
$_autoplay_speed = (int)($wdg_params['autoplay_speed'] ?? 5000);
$_color          = htmlspecialchars($wdg_params['color_scheme']   ?? 'color-scheme-standard-primary');
$_testimonials   = $wdg_params['testimonials'] ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_header_align_style = ($_header_align === 'start') ? 'start' : 'center';
$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-type-testimonial-slider widget-<?php echo $_widget_id; ?> <?php echo $_color; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="testimonial-slider"
    data-autoplay="<?php echo $_autoplay; ?>"
    data-autoplay-speed="<?php echo $_autoplay_speed; ?>"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?> .widget-header {
    text-align: <?php echo $_header_align_style; ?>;
    margin-bottom: var(--space-2xl);
}
.widget-<?php echo $_widget_id; ?> .testimonial-slider-track {
    position: relative;
    min-height: 300px;
}
.widget-<?php echo $_widget_id; ?> .testimonial-slider-slide {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.5s ease-in-out, visibility 0.5s ease-in-out;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: var(--space-xl);
    padding: var(--space-2xl) var(--space-3xl);
}
.widget-<?php echo $_widget_id; ?> .testimonial-slider-slide.is-active {
    opacity: 1;
    visibility: visible;
    position: relative;
}
.widget-<?php echo $_widget_id; ?> .testimonial-slider-rating {
    display: flex;
    justify-content: center;
    gap: var(--space-2xs);
}
.widget-<?php echo $_widget_id; ?> .testimonial-slider-star {
    color: var(--rating-star-color);
    font-size: var(--font-size-xl);
}
.widget-<?php echo $_widget_id; ?> .testimonial-slider-quote {
    max-width: 760px;
    margin: 0 auto;
    text-align: center;
}
.widget-<?php echo $_widget_id; ?> .testimonial-slider-author {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--space-md);
}
.widget-<?php echo $_widget_id; ?> .testimonial-slider-avatar {
    width: 60px !important;
    height: 60px;
    aspect-ratio: 1 / 1;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}
.widget-<?php echo $_widget_id; ?> .testimonial-slider-info {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--space-2xs);
}
.widget-<?php echo $_widget_id; ?> .testimonial-slider-pagination {
    display: flex;
    justify-content: center;
    gap: var(--space-sm);
    padding-block-start: var(--space-xl);
}
.widget-<?php echo $_widget_id; ?> .testimonial-slider-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: var(--text-content);
    opacity: 0.3;
    border: none;
    cursor: pointer;
    transition: opacity 0.3s, transform 0.3s;
    padding: 0;
}
.widget-<?php echo $_widget_id; ?> .testimonial-slider-dot:hover,
.widget-<?php echo $_widget_id; ?> .testimonial-slider-dot.is-active {
    opacity: 1;
}
.widget-<?php echo $_widget_id; ?> .testimonial-slider-dot.is-active {
    transform: scale(1.2);
    background-color: var(--accent);
}
@media (max-width: 749px) {
    .widget-<?php echo $_widget_id; ?> .testimonial-slider-slide {
        padding: var(--space-lg) var(--space-md);
    }
    .widget-<?php echo $_widget_id; ?> .testimonial-slider-avatar {
        width: 48px;
        height: 48px;
    }
}
</style>

    <div class="widget-container widget-container-padded">
        <div class="widget-content">

            <?php if ($_show_header && ($_eyebrow || $_title || $_description)): ?>
            <div class="widget-header" style="text-align: <?php echo $_header_align_style; ?>; margin-bottom: var(--space-2xl);">
                <?php if ($_eyebrow): ?><span class="w-eyebrow"><?php echo $_eyebrow; ?></span><?php endif; ?>
                <?php if ($_title): ?><h2 class="w-headline <?php echo $_title_size; ?>"><?php echo $_title; ?></h2><?php endif; ?>
                <?php if ($_description): ?><div class="w-description"><?php echo $_description; ?></div><?php endif; ?>
            </div>
            <?php endif; ?>

            <div class="testimonial-slider-track">
                <?php foreach ($_testimonials as $i => $_t):
                    // ── Quote: NO base64, only [nl] to \n ────────────────────────
                    $_t_quote_raw = $_t['quote'] ?? '';
                    $_t_quote_with_nl = str_replace('[nl]', "\n", $_t_quote_raw);
                    $_t_quote = nl2br(htmlspecialchars($_t_quote_with_nl));
                    
                    $_t_rating    = (int)($_t['rating'] ?? 5);
                    $_t_avatar    = htmlspecialchars($_t['avatar'] ?? '');
                    $_t_name      = htmlspecialchars($_t['name']   ?? '');
                    $_t_role      = htmlspecialchars($_t['role']   ?? '');
                    $_is_first    = ($i === 0);
                    $_blk_id      = $_widget_id . '_' . $i;
                ?>
                <div
                    class="testimonial-slider-slide<?php echo $_is_first ? ' is-active' : ''; ?>"
                    data-block-id="tesl_<?php echo $_blk_id; ?>"
                    aria-hidden="<?php echo $_is_first ? 'false' : 'true'; ?>"
                >
                    <div class="testimonial-slider-rating">
                        <span class="stars" aria-hidden="true">
                            <?php for ($s = 0; $s < $_t_rating; $s++): ?>
                            <span class="testimonial-slider-star">★</span>
                            <?php endfor; ?>
                        </span>
                        <span class="visually-hidden">Rated <?php echo $_t_rating; ?> out of 5</span>
                    </div>
                    <?php if ($_t_quote): ?>
                    <blockquote class="testimonial-slider-quote w-body t-xl"><?php echo $_t_quote; ?></blockquote>
                    <?php endif; ?>
                    <div class="testimonial-slider-author">
                        <?php if ($_t_avatar): ?>
                        <img src="<?php echo $_t_avatar; ?>" alt="" class="testimonial-slider-avatar" loading="lazy">
                        <?php endif; ?>
                        <div class="testimonial-slider-info">
                            <?php if ($_t_name): ?><p class="w-body t-semibold t-heading"><?php echo $_t_name; ?></p><?php endif; ?>
                            <?php if ($_t_role): ?><p class="w-meta t-sm"><?php echo $_t_role; ?></p><?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="testimonial-slider-pagination">
                <?php foreach ($_testimonials as $i => $_t): ?>
                <button type="button" class="testimonial-slider-dot<?php echo $i === 0 ? ' is-active' : ''; ?>" data-index="<?php echo $i; ?>" aria-label="Go to testimonial <?php echo $i + 1; ?>"></button>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>