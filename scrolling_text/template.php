<?php
/*
 * Widgetizer — Scrolling Text Widget — template.php
 * Prefix: scrt
 * Refactored: Pure PHP output, flat CSS, single section, no DOMDocument
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
$_items = $wdg_params['items'] ?? [];
if (empty($_items)) {
    echo '<!-- Widgetizer Scrolling Text: no items -->';
    return;
}

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;
$_keyframe_name = 'scroll-x-' . $_widget_class;

// ── Build strips HTML ─────────────────────────────────────────────────────────
$_strips_html = '';
foreach ($_items as $_si => $_strip_data) {
    $_text            = htmlspecialchars($_strip_data['text']            ?? '');
    $_separator       = htmlspecialchars($_strip_data['separator']       ?? '★');
    $_strip_bg        = str_replace('[id]', '#', $_strip_data['strip_bg']        ?? '#1e3a8a');
    $_strip_color     = str_replace('[id]', '#', $_strip_data['strip_color']     ?? '#ffffff');
    $_strip_rotate    = htmlspecialchars($_strip_data['strip_rotate']    ?? '0deg');
    $_scroll_duration = htmlspecialchars($_strip_data['scroll_duration'] ?? '65');
    $_strip_font_size = htmlspecialchars($_strip_data['strip_font_size'] ?? 'var(--font-size-xl)');
    $_padding         = intval($_strip_data['padding'] ?? 60);
    if ($_padding < 0)   $_padding = 0;
    if ($_padding > 100) $_padding = 100;
    
    if (!preg_match('/^#[0-9a-fA-F]{3,8}$/', $_strip_bg))    $_strip_bg    = '#1e3a8a';
    if (!preg_match('/^#[0-9a-fA-F]{3,8}$/', $_strip_color)) $_strip_color = '#ffffff';
    
    $_strip_style = '--strip-bg: ' . $_strip_bg . '; ' .
                    '--strip-color: ' . $_strip_color . '; ' .
                    '--strip-rotate: ' . $_strip_rotate . '; ' .
                    '--strip-font-size: ' . $_strip_font_size . '; ' .
                    '--strip-padding: ' . $_padding . 'px;';
    
    $_track_style = '--scroll-duration: ' . $_scroll_duration . 's;';
    
    // Build track with 20 repeats (like original)
    $_track_html = '';
    for ($_i = 0; $_i < 20; $_i++) {
        $_track_html .= '<span class="scrolling-item">' . $_text . '</span>';
        $_track_html .= '<span class="scrolling-separator">' . $_separator . '</span>';
    }
    
    $_strips_html .= '
    <div class="scrolling-strip-wrapper" style="' . $_strip_style . '">
        <div class="scrolling-strip" aria-label="' . $_text . '">
            <div class="scrolling-track-inner" style="' . $_track_style . '" aria-hidden="true">
                <div class="scrolling-track">
                    ' . $_track_html . '
                </div>
            </div>
        </div>
    </div>';
}

// ── Section style ─────────────────────────────────────────────────────────────
$_sec_style = 'padding-bottom: 20px;';

?>
<?php echo $_wdg_asset_html; ?>
<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-scrolling-text widget-<?php echo $_widget_class; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="scrolling-text"
    style="<?php echo $_sec_style; ?>"
>
    <style>
        /* Flat CSS — no nesting */
        @keyframes <?php echo $_keyframe_name; ?> {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }
        
        .widget-<?php echo $_widget_class; ?> {
            padding-inline: 0;
            padding-block: 0;
            margin-block: 0;
        }
        
        .widget-<?php echo $_widget_class; ?> .scrolling-wrapper {
            overflow: hidden;
            padding-block: var(--strip-padding, 60px);
        }
        
        .widget-<?php echo $_widget_class; ?> .scrolling-strip {
            background: var(--strip-bg);
            transform: rotate(var(--strip-rotate, 0deg));
            padding-block: var(--space-lg);
            overflow: hidden;
            width: 200%;
            margin-inline: -50%;
        }

        .widget-<?php echo $_widget_class; ?> .scrolling-track-inner {
            width: max-content;
            animation: <?php echo $_keyframe_name; ?> var(--scroll-duration, 30s) linear infinite;
            transform: translate3d(0, 0, 0);
            will-change: transform;
        }
        
        .widget-<?php echo $_widget_class; ?> .scrolling-track {
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }
        
        .widget-<?php echo $_widget_class; ?> .scrolling-item {
            white-space: nowrap;
            padding-inline: var(--space-xl);
            color: var(--strip-color);
            font-size: var(--strip-font-size);
            font-weight: 600;
            font-family: var(--font-heading, inherit);
            letter-spacing: 0.01em;
        }
        
        .widget-<?php echo $_widget_class; ?> .scrolling-separator {
            white-space: nowrap;
            color: var(--strip-color);
            font-size: var(--strip-font-size);
            opacity: 0.6;
            flex-shrink: 0;
        }
        
        .widget-<?php echo $_widget_class; ?> .scrolling-strip-wrapper {
            margin-block: 0;
        }
        
        .widget-<?php echo $_widget_class; ?> .scrolling-strip-wrapper + .scrolling-strip-wrapper {
            margin-block-start: 0;
        }
    </style>

    <div class="scrolling-wrapper">
        <?php echo $_strips_html; ?>
    </div>
</section>

<?php
// ── Inline JS for cloning each strip ─────────────────────────────────────────
$_js = <<<JSEOF
<script>
(function() {
    var widget = document.getElementById("{$_widget_id}");
    if (!widget || widget.dataset.scrtInit) return;
    widget.dataset.scrtInit = "true";
    
    var strips = widget.querySelectorAll(".scrolling-strip");
    for (var s = 0; s < strips.length; s++) {
        var strip = strips[s];
        var inner = strip.querySelector(".scrolling-track-inner");
        var track = strip.querySelector(".scrolling-track");
        if (!inner || !track) continue;
        
        var clone = track.cloneNode(true);
        clone.setAttribute("aria-hidden", "true");
        inner.appendChild(clone);
    }
})();
</script>
JSEOF;

echo $_js;