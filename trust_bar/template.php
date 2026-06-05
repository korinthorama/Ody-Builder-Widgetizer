<?php
/*
 * Widgetizer — Trust Bar Widget — template.php
 * Prefix: trbr
 * Refactored: Pure PHP output, flat CSS, no DOMDocument
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

// ── Font Awesome (DOM check loader) ──────────────────────────────────────────
$_wdg_asset_html .= '<script>
(function(){
    var cssHref = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css";
    var links = document.querySelectorAll("link[rel=stylesheet]");
    var loaded = false;
    for (var i = 0; i < links.length; i++) {
        if (links[i].getAttribute("href") === cssHref) { loaded = true; break; }
    }
    if (!loaded) { var l = document.createElement("link"); l.rel = "stylesheet"; l.type = "text/css"; l.href = cssHref; document.head.appendChild(l); }
})();
</script>' . PHP_EOL;

// ── Parameters ────────────────────────────────────────────────────────────────
$_widget_id        = 'widget_' . $blockID;
$_widget_class     = 'widget_' . $blockID;
$_icon_style       = htmlspecialchars($wdg_params['icon_style']     ?? 'w-icon-plain');
$_icon_size        = htmlspecialchars($wdg_params['icon_size']      ?? 'w-icon-lg');
$_icon_shape       = htmlspecialchars($wdg_params['icon_shape']     ?? 'w-icon-circle');
$_alignment        = htmlspecialchars($wdg_params['alignment']      ?? 'center');
$_show_dividers    = ($wdg_params['show_dividers'] ?? '1') !== '0';
$_color            = htmlspecialchars($wdg_params['color_scheme']   ?? 'color-scheme-standard-primary');
$_items            = $wdg_params['items'] ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map = ['full'=>null,'xl'=>'1420px','lg'=>'1200px','md'=>'960px','sm'=>'760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_icon_span_cls = trim($_icon_style . ' ' . $_icon_size . ' ' . $_icon_shape . ' trust-bar-icon-wrapper');

$_icon_font_size_map = [
    'w-icon-sm' => '18px',
    'w-icon-md' => '24px',
    'w-icon-lg' => '32px',
    'w-icon-xl' => '48px',
];
$_icon_font_size = $_icon_font_size_map[$_icon_size] ?? '32px';

// ── Alignment class ──────────────────────────────────────────────────────────
$_align_class = ($_alignment === 'center') ? 'trust-bar-list--center' : 'trust-bar-list--start';

// ── Section style ─────────────────────────────────────────────────────────────
$_sec_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_sec_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

// ── Build items HTML ──────────────────────────────────────────────────────────
$_items_html = '';
$_item_index = 0;

foreach ($_items as $_item) {
    $_icon_class = htmlspecialchars($_item['icon_class'] ?? '');
    $_title      = htmlspecialchars($_item['title']      ?? '');
    $_text       = htmlspecialchars($_item['text']       ?? '');

    $_icon_html = '';
    if ($_icon_class) {
        $_icon_html = '<span class="' . $_icon_span_cls . '"><i class="fa ' . $_icon_class . ' w-icon" style="font-size:' . $_icon_font_size . ';"></i></span>';
    }

    $_items_html .= '<li class="trust-bar-item reveal reveal-up" style="--reveal-delay: ' . $_item_index . '" data-block-id="trbr_' . $blockID . '_' . $_item_index . '">';
    $_items_html .= $_icon_html;
    $_items_html .= '<div class="trust-bar-content">';
    if ($_title) {
        $_items_html .= '<span class="w-title t-heading-font">' . $_title . '</span>';
    }
    if ($_text) {
        $_items_html .= '<span class="trust-bar-text w-body t-sm">' . $_text . '</span>';
    }
    $_items_html .= '</div></li>';

    $_item_index++;
}

// ── Dividers inline style (if disabled) ───────────────────────────────────────
$_divider_style = '';
if (!$_show_dividers) {
    $_divider_style = '<style>.widget-' . $_widget_class . ' .trust-bar-item { border-inline-start: none !important; }</style>';
}

?>
<?php echo $_wdg_asset_html . $_divider_style; ?>
<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-trust-bar widget-<?php echo $_widget_class; ?> <?php echo $_color; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="trust-bar"
    style="<?php echo $_sec_style; ?>"
>
    <style>
        /* Flat CSS — no nesting */
        .widget-<?php echo $_widget_class; ?> .trust-bar-list {
            display: flex;
            flex-direction: column;
            gap: var(--space-lg);
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .widget-<?php echo $_widget_class; ?> .trust-bar-item {
            display: flex;
            align-items: center;
            gap: var(--space-md);
        }
        .widget-<?php echo $_widget_class; ?> .trust-bar-icon-wrapper {
            flex-shrink: 0;
        }
        .widget-<?php echo $_widget_class; ?> .trust-bar-content {
            display: flex;
            flex-direction: column;
            gap: var(--space-xs);
            flex: 1;
        }
        .widget-<?php echo $_widget_class; ?> .trust-bar-list--center {
            justify-content: center;
        }
        .widget-<?php echo $_widget_class; ?> .trust-bar-list--center .trust-bar-item {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .widget-<?php echo $_widget_class; ?> .trust-bar-list--center .trust-bar-content {
            flex: unset;
        }
        .widget-<?php echo $_widget_class; ?> .trust-bar-list--start {
            justify-content: flex-start;
        }
        @media (min-width: 750px) {
            .widget-<?php echo $_widget_class; ?> .trust-bar-list {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
                gap: 0;
            }
            .widget-<?php echo $_widget_class; ?> .trust-bar-item {
                flex: 1;
                min-width: 0;
                padding-block: var(--space-sm);
                padding-inline: var(--space-lg);
                border-inline-start: var(--border-width-thin) solid var(--border-color);
            }
            .widget-<?php echo $_widget_class; ?> .trust-bar-item:first-child {
                border-inline-start: none;
                padding-inline-start: 0;
            }
            .widget-<?php echo $_widget_class; ?> .trust-bar-item:last-child {
                padding-inline-end: 0;
            }
        }
        @media (min-width: 990px) {
            .widget-<?php echo $_widget_class; ?> .trust-bar-list {
                flex-wrap: nowrap;
            }
        }
    </style>

    <div class="widget-container widget-container-padded">
        <ul class="trust-bar-list <?php echo $_align_class; ?>">
            <?php echo $_items_html; ?>
        </ul>
    </div>
</section>