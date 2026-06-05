<?php
/*
 * Widgetizer — Slideshow Widget — template.php
 * Prefix: slds
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

// ── Slideshow CSS + JS (DOM-check loader) ────────────────────────────────────
$_slds_css = 'admin/builder_widget_assets/slideshow.css';
$_slds_js  = 'admin/builder_widget_assets/slideshow.js';
$_wdg_asset_html .= '<script>
(function(){
    var cssHref = "' . $_slds_css . '";
    var jsHref  = "' . $_slds_js . '";
    var links = document.querySelectorAll("link[rel=stylesheet]");
    var cssLoaded = false;
    for (var i = 0; i < links.length; i++) { if (links[i].getAttribute("href") === cssHref) { cssLoaded = true; break; } }
    if (!cssLoaded) { var l = document.createElement("link"); l.rel = "stylesheet"; l.type = "text/css"; l.href = cssHref; document.head.appendChild(l); }
    var scripts = document.querySelectorAll("script[src]");
    var jsLoaded = false;
    for (var j = 0; j < scripts.length; j++) { if (scripts[j].getAttribute("src") === jsHref) { jsLoaded = true; break; } }
    if (!jsLoaded) { var s = document.createElement("script"); s.src = jsHref; document.head.appendChild(s); }
})();
</script>' . PHP_EOL;

// ── Parameters ────────────────────────────────────────────────────────────────
$_autoplay       = ($wdg_params['autoplay'] ?? '1') === '1' ? 'true' : 'false';
$_autoplay_speed = htmlspecialchars($wdg_params['autoplay_speed'] ?? '5000');
$_height_global  = htmlspecialchars($wdg_params['height'] ?? 'widget-height-medium');
$_color_scheme   = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');
$_slides         = $wdg_params['slides'] ?? [];

if (empty($_slides)) {
    echo '<!-- Widgetizer Slideshow: no slides -->';
    return;
}

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;

// ── Build slides HTML ─────────────────────────────────────────────────────────
$_slides_html = '';
$_dot_html = '';
$_slide_index = 0;

foreach ($_slides as $_si => $_slide) {
    $_img         = htmlspecialchars($_slide['image']          ?? '');
    $_cs          = htmlspecialchars($_slide['color_scheme']   ?? 'color-scheme-highlight-primary');
    $_ov_color    = str_replace('[id]', '#', $_slide['overlay_color'] ?? '#000000');
    $_ov_opacity  = floatval($_slide['overlay_opacity'] ?? 40) / 100;
    $_valign      = htmlspecialchars($_slide['valign']         ?? 'center');
    $_align       = htmlspecialchars($_slide['align']          ?? 'left');
    $_height      = $_height_global;
    $_heading     = htmlspecialchars($_slide['heading']        ?? '');
    $_hsize       = htmlspecialchars($_slide['heading_size']   ?? 't-5xl');
    
    // ── Description: NO base64, only [nl] to \n then nl2br ────────────────────
    $_content_raw = $_slide['description'] ?? '';
    $_content_with_nl = str_replace('[nl]', "\n", $_content_raw);
    $_content     = nl2br(htmlspecialchars($_content_with_nl));
    
    $_tsize       = htmlspecialchars($_slide['text_size']      ?? 't-lg');
    $_muted       = ($_slide['muted_text'] ?? '0') === '1' ? ' t-muted' : '';
    $_btn_label   = htmlspecialchars($_slide['btn_label']      ?? '');
    $_btn_url     = $_slide['btn_url'] ?? '';
    if (function_exists('wdg_parse_links')) $_btn_url = wdg_parse_links($_btn_url);
    $_btn_url_esc = htmlspecialchars($_btn_url);
    $_btn_style   = htmlspecialchars($_slide['btn_style']      ?? 'widget-button-primary');
    $_btn_size    = htmlspecialchars($_slide['btn_size']       ?? '');
    $_btn_size_class = $_btn_size ? ' ' . $_btn_size : '';
    $_btn_tab     = ($_slide['btn_new_tab'] ?? '0') === '1' ? ' target="_blank" rel="noopener"' : '';
    
    // Sanitize overlay color
    if (!preg_match('/^#[0-9a-fA-F]{3,8}$/', $_ov_color)) $_ov_color = '#000000';
    
    $_slide_class = 'slideshow-slide widget ' . $_height . ' has-overlay ' . $_cs;
    if (!empty($_img)) $_slide_class .= ' has-bg-image';
    if ($_si === 0)    $_slide_class .= ' is-active';
    
    $_slide_style = '--widget-overlay-color: ' . $_ov_color . '; --widget-overlay-opacity: ' . $_ov_opacity . ';';
    if (!empty($_img)) $_slide_style = 'background-image: url(\'' . $_img . '\'); ' . $_slide_style;
    
    $_align_class = 'widget-content-align-' . $_align;
    
    $_slide_html = '<div class="' . $_slide_class . '" style="' . $_slide_style . '" data-block-id="slds_' . $blockID . '_' . $_si . '">';
    $_slide_html .= '<div class="widget-container" style="justify-content: ' . $_valign . '">';
    $_slide_html .= '<div class="widget-content widget-content-lg ' . $_align_class . '">';
    
    if ($_heading) {
        $_slide_html .= '<h2 class="w-headline ' . $_hsize . '">' . $_heading . '</h2>';
    }
    if ($_content) {
        $_slide_html .= '<p class="w-body ' . $_tsize . $_muted . '">' . $_content . '</p>';
    }
    if ($_btn_label && $_btn_url_esc) {
        $_slide_html .= '<div class="widget-actions">';
        $_slide_html .= '<a href="' . $_btn_url_esc . '" class="widget-button' . $_btn_size_class . ' ' . $_btn_style . '"' . $_btn_tab . '>' . $_btn_label . '</a>';
        $_slide_html .= '</div>';
    }
    
    $_slide_html .= '</div></div></div>';
    
    $_slides_html .= $_slide_html;
    
    // Pagination dots
    $_active_class = ($_si === 0) ? ' is-active' : '';
    $_dot_html .= '<button type="button" class="slideshow-dot' . $_active_class . '" data-index="' . $_si . '" aria-label="Go to slide ' . ($_si + 1) . '"></button>';
}

// ── Navigation buttons ────────────────────────────────────────────────────────
$_prev_html = '<button type="button" class="slideshow-nav slideshow-prev" aria-label="Previous slide"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg></button>';
$_next_html = '<button type="button" class="slideshow-nav slideshow-next" aria-label="Next slide"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/></svg></button>';
$_pause_html = '<button class="slideshow-toggle visually-hidden" type="button" aria-pressed="false" aria-label="Pause autoplay">Pause</button>';
$_pagination_html = '<div class="slideshow-pagination">' . $_dot_html . '</div>';

// ── Section style ─────────────────────────────────────────────────────────────
$_sec_style = 'padding-bottom: 20px;';

?>
<?php echo $_wdg_asset_html; ?>
<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-slideshow widget-<?php echo $_widget_class; ?> <?php echo $_color_scheme; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="slideshow"
    data-autoplay="<?php echo $_autoplay; ?>"
    data-autoplay-speed="<?php echo $_autoplay_speed; ?>"
    style="<?php echo $_sec_style; ?>"
>
    <style>
        /* Flat CSS — no nesting */
        .widget-<?php echo $_widget_class; ?> .slideshow-track {
            position: relative;
            overflow: hidden;
        }

        .widget-<?php echo $_widget_class; ?> .slideshow-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.5);
            border: none;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            cursor: pointer;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .widget-<?php echo $_widget_class; ?> .slideshow-prev {
            left: 16px;
        }

        .widget-<?php echo $_widget_class; ?> .slideshow-next {
            right: 16px;
        }

        .widget-<?php echo $_widget_class; ?> .slideshow-pagination {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 10;
        }

        .widget-<?php echo $_widget_class; ?> .slideshow-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255,255,255,0.5);
            border: none;
            cursor: pointer;
            padding: 0;
        }

        .widget-<?php echo $_widget_class; ?> .slideshow-dot.is-active {
            background: white;
        }

        .widget-<?php echo $_widget_class; ?> .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0,0,0,0);
            border: 0;
        }
    </style>
    
    <div class="slideshow-track reveal reveal-fade">
        <?php echo $_slides_html; ?>
        <?php echo $_prev_html; ?>
        <?php echo $_next_html; ?>
        <?php echo $_pause_html; ?>
        <?php echo $_pagination_html; ?>
    </div>
</section>