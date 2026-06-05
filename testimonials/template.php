<?php
/*
 * Widgetizer — Testimonials Widget — template.php
 * Prefix: tmls
 * Refactored: Pure PHP output, flat CSS, no DOMDocument
 * No base64 — uses [nl] for line breaks
 */

// ── Assets ────────────────────────────────────────────────────────────────────
$_wdg_assets     = 'admin/builder_widget_assets/';
$_wdg_css        = $_wdg_assets . 'base.css';
$_wdg_js         = $_wdg_assets . 'scripts.js';
$_wdg_asset_html = '';

$_base_css_exists = false;
foreach ($document->loadedFiles as $_f) {
    if (strpos($_f, 'base.css') !== false) { $_base_css_exists = true; break; }
}
if (!$_base_css_exists) {
    $_wdg_asset_html .= '<link href="' . $_wdg_css . '" rel="stylesheet" type="text/css">' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_css;
}

$_scripts_js_exists = false;
foreach ($document->loadedFiles as $_f) {
    if (strpos($_f, 'scripts.js') !== false) { $_scripts_js_exists = true; break; }
}
if (!$_scripts_js_exists) {
    $_wdg_asset_html .= '<script src="' . $_wdg_js . '"></script>' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_js;
}

// ── Parameters ────────────────────────────────────────────────────────────────
$_widget_id        = 'widget_' . $blockID;
$_widget_class     = 'widget_' . $blockID;
$_show_header      = ($wdg_params['show_header'] ?? '0') === '1';
$_eyebrow          = htmlspecialchars($wdg_params['eyebrow']          ?? '');
$_title            = htmlspecialchars($wdg_params['title']            ?? '');
$_title_size       = htmlspecialchars($wdg_params['title_size']       ?? 't-2xl');
$_description      = htmlspecialchars($wdg_params['description']      ?? '');
$_header_align     = $wdg_params['header_alignment'] ?? 'left';
$_layout           = $wdg_params['layout']           ?? 'grid';
$_columns          = (int)($wdg_params['columns']    ?? 4);
$_color            = htmlspecialchars($wdg_params['color_scheme']     ?? 'color-scheme-standard-primary');
$_items            = $wdg_params['items']            ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full'=>null,'xl'=>'1420px','lg'=>'1200px','md'=>'960px','sm'=>'760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

// ── Header alignment class ────────────────────────────────────────────────────
$_header_align_class = ($_header_align === 'center') ? 'widget-header--align-center' : 'widget-header--align-start';

// ── Section style ─────────────────────────────────────────────────────────────
$_sec_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_sec_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

// ── Header HTML ───────────────────────────────────────────────────────────────
$_header_html = '';
if ($_show_header && ($_eyebrow || $_title || $_description)) {
    $_header_html = '<div class="widget-header ' . $_header_align_class . '">';
    if ($_eyebrow) {
        $_header_html .= '<span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0">' . $_eyebrow . '</span>';
    }
    if ($_title) {
        $_header_html .= '<h2 class="w-headline ' . $_title_size . ' reveal reveal-up" style="--reveal-delay: 1">' . $_title . '</h2>';
    }
    if ($_description) {
        $_header_html .= '<p class="w-description reveal reveal-up" style="--reveal-delay: 2">' . $_description . '</p>';
    }
    $_header_html .= '</div>';
}

// ── Build items HTML ──────────────────────────────────────────────────────────
$_items_html = '';
$_item_index = 0;

foreach ($_items as $_item) {
    // ── Quote: NO base64, only [nl] to \n ─────────────────────────────────────
    $_t_quote_raw = $_item['quote'] ?? '';
    $_t_quote_with_nl = str_replace('[nl]', "\n", $_t_quote_raw);
    $_t_quote = nl2br(htmlspecialchars($_t_quote_with_nl));
    
    $_t_rating    = (int)($_item['rating'] ?? 5);
    $_t_avatar    = htmlspecialchars($_item['avatar'] ?? '');
    $_t_name      = htmlspecialchars($_item['name']   ?? '');
    $_t_role      = htmlspecialchars($_item['role']   ?? '');

    // Stars
    $_stars = '<span class="stars" aria-hidden="true">';
    for ($_s = 1; $_s <= 5; $_s++) {
        $_star_class = ($_s <= $_t_rating) ? 'testimonial-star' : 'testimonial-star empty';
        $_stars .= '<span class="' . $_star_class . '">★</span>';
    }
    $_stars .= '</span><span class="visually-hidden">Rated ' . $_t_rating . ' out of 5</span>';

    // Avatar + author
    $_has_avatar   = !empty($_t_avatar);
    $_author_class = $_has_avatar ? 'testimonial-author' : 'testimonial-author testimonial-author-no-avatar';
    $_avatar_html  = $_has_avatar
        ? '<img src="' . $_t_avatar . '" alt="" class="testimonial-avatar" loading="lazy">'
        : '';

    $_li_class = 'widget-card widget-card-flat reveal reveal-up';
    if ($_layout === 'carousel') $_li_class .= ' carousel-item';

    $_items_html .= '<li class="' . $_li_class . '" style="--reveal-delay: ' . $_item_index . '" data-block-id="tmls_' . $blockID . '_' . $_item_index . '">';
    $_items_html .= '<div class="testimonial-rating">' . $_stars . '</div>';
    if ($_t_quote) {
        $_items_html .= '<div class="testimonial-quote w-body">' . $_t_quote . '</div>';
    }
    $_items_html .= '<div class="' . $_author_class . '">';
    $_items_html .= $_avatar_html;
    $_items_html .= '<div class="testimonial-info">';
    if ($_t_name) {
        $_items_html .= '<p class="testimonial-name w-body t-semibold t-heading">' . $_t_name . '</p>';
    }
    if ($_t_role) {
        $_items_html .= '<p class="testimonial-title w-meta t-sm">' . $_t_role . '</p>';
    }
    $_items_html .= '</div></div></li>';

    $_item_index++;
}

// ── Grid or Carousel wrapper ──────────────────────────────────────────────────
$_content_html = '';
if ($_layout === 'carousel') {
    $_content_html = '<div class="carousel-container reveal reveal-up">';
    $_content_html .= '<button type="button" class="carousel-btn carousel-btn-prev" aria-label="Previous">';
    $_content_html .= '<svg class="carousel-btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M15 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    $_content_html .= '</button>';
    $_content_html .= '<button type="button" class="carousel-btn carousel-btn-next" aria-label="Next">';
    $_content_html .= '<svg class="carousel-btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 18l6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    $_content_html .= '</button>';
    $_content_html .= '<ul class="widget-card-grid carousel-track" style="--carousel-cols: ' . $_columns . '">';
    $_content_html .= $_items_html;
    $_content_html .= '</ul></div>';
} else {
    $_content_html = '<ul class="widget-card-grid widget-grid" style="--grid-cols-desktop: ' . $_columns . '">' . $_items_html . '</ul>';
}

?>
<?php echo $_wdg_asset_html; ?>
<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-type-testimonials widget-<?php echo $_widget_class; ?> <?php echo $_color; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="testimonials"
    style="<?php echo $_sec_style; ?>"
>
    <style>
        /* Flat CSS — no nesting */
        .widget-<?php echo $_widget_class; ?> .testimonial-quote {
            margin: 0 0 var(--space-lg) 0;
            position: relative;
        }
        .widget-<?php echo $_widget_class; ?> .testimonial-rating {
            display: flex;
            gap: 2px;
            margin-block-end: var(--space-md);
        }
        .widget-<?php echo $_widget_class; ?> .testimonial-star {
            color: var(--rating-star-color);
            font-size: var(--font-size-lg);
            line-height: 1;
        }
        .widget-<?php echo $_widget_class; ?> .testimonial-star.empty {
            color: var(--border-color);
        }
        .widget-<?php echo $_widget_class; ?> .testimonial-author {
            display: flex;
            align-items: center;
            gap: var(--space-md);
            margin-block-start: auto;
        }
        .widget-<?php echo $_widget_class; ?> .testimonial-author-no-avatar {
            gap: 0;
        }
        .widget-<?php echo $_widget_class; ?> .testimonial-avatar {
            width: 48px !important;
            height: 48px;
            aspect-ratio: 1 / 1;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            margin: 0 !important;
        }
        .widget-<?php echo $_widget_class; ?> .testimonial-info {
            display: flex;
            flex-direction: column;
            gap: var(--space-2xs);
        }
        .widget-<?php echo $_widget_class; ?>:not(.card-layout-flat).color-scheme-standard-secondary .widget-card,
        .widget-<?php echo $_widget_class; ?>:not(.card-layout-flat).color-scheme-highlight-secondary .widget-card {
            background-color: var(--bg-secondary);
        }
        .widget-<?php echo $_widget_class; ?>:not(.card-layout-flat).color-scheme-standard-primary .widget-card,
        .widget-<?php echo $_widget_class; ?>:not(.card-layout-flat).color-scheme-standard-secondary .widget-card,
        .widget-<?php echo $_widget_class; ?>:not(.card-layout-flat).color-scheme-highlight-primary .widget-card,
        .widget-<?php echo $_widget_class; ?>:not(.card-layout-flat).color-scheme-highlight-secondary .widget-card {
            border: var(--border-width-thin) solid var(--border-color);
        }
    </style>

    <div class="widget-container widget-container-padded">
        <?php echo $_header_html; ?>
        <div class="widget-content">
            <?php echo $_content_html; ?>
        </div>
    </div>
</section>

<?php
// ── Carousel JS init (only if layout is carousel) ─────────────────────────────
if ($_layout === 'carousel') {
    $_init_script = <<<JS
<script>
(function(){
    function run() {
        var section = document.getElementById('{$_widget_id}');
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
JS;
    echo $_init_script;
}