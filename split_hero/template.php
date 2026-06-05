<?php
/*
 * Widgetizer — Split Hero Widget — template.php
 * Prefix: sph
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
$_eyebrow         = htmlspecialchars($wdg_params['eyebrow']         ?? '');
$_eyebrow_muted   = ($wdg_params['eyebrow_muted'] ?? '') === '1';
$_title           = htmlspecialchars($wdg_params['title']           ?? '');
$_title_size      = htmlspecialchars($wdg_params['title_size']      ?? 't-2xl');

// ── Description: NO base64, only [nl] to \n ───────────────────────────────────
$_description_raw = $wdg_params['description'] ?? '';
$_description_with_nl = str_replace('[nl]', "\n", $_description_raw);
$_description     = $_description_with_nl;

$_desc_size       = htmlspecialchars($wdg_params['desc_size']       ?? 't-base');
$_btn1_label      = htmlspecialchars($wdg_params['btn1_label']      ?? '');
$_btn1_url        = $wdg_params['btn1_url'] ?? '';
$_btn1_new_tab    = ($wdg_params['btn1_new_tab'] ?? '') === '1';
$_btn1_style      = htmlspecialchars($wdg_params['btn1_style']      ?? 'widget-button-primary');
$_btn2_label      = htmlspecialchars($wdg_params['btn2_label']      ?? '');
$_btn2_url        = $wdg_params['btn2_url'] ?? '';
$_btn2_new_tab    = ($wdg_params['btn2_new_tab'] ?? '') === '1';
$_btn2_style      = htmlspecialchars($wdg_params['btn2_style']      ?? 'widget-button-secondary');
$_bg_image        = str_replace(['"', "'"], '', $wdg_params['bg_image'] ?? '');
$_overlay_color   = str_replace('[id]', '#', $wdg_params['overlay_color'] ?? '#000000');
$_overlay_opacity = floatval($wdg_params['overlay_opacity'] ?? 0.4);
$_image_position  = htmlspecialchars($wdg_params['image_position']  ?? 'start');
$_color           = htmlspecialchars($wdg_params['color_scheme']    ?? 'color-scheme-standard-primary');

// Parse links
if (function_exists('wdg_parse_links')) {
    $_btn1_url = wdg_parse_links($_btn1_url);
    $_btn2_url = wdg_parse_links($_btn2_url);
}
$_btn1_url_esc = htmlspecialchars($_btn1_url);
$_btn2_url_esc = htmlspecialchars($_btn2_url);

$_btn1_target = $_btn1_new_tab ? ' target="_blank" rel="noopener"' : '';
$_btn2_target = $_btn2_new_tab ? ' target="_blank" rel="noopener"' : '';

// ── Computed classes ──────────────────────────────────────────────────────────
$_eyebrow_classes = 'w-body w-rte t-sm reveal reveal-up';
if ($_eyebrow_muted) $_eyebrow_classes .= ' t-muted';
$_title_classes   = 'w-headline ' . $_title_size . ' reveal reveal-up';
$_desc_classes    = 'w-body w-rte ' . $_desc_size . ' reveal reveal-up';

// ── Overlay RGB ───────────────────────────────────────────────────────────────
$_hex = ltrim($_overlay_color, '#');
if (strlen($_hex) === 3) $_hex = $_hex[0].$_hex[0].$_hex[1].$_hex[1].$_hex[2].$_hex[2];
$_r = hexdec(substr($_hex, 0, 2));
$_g = hexdec(substr($_hex, 2, 2));
$_b = hexdec(substr($_hex, 4, 2));
$_overlay_rgba = 'rgba(' . $_r . ',' . $_g . ',' . $_b . ',' . $_overlay_opacity . ')';

// ── Widget IDs ────────────────────────────────────────────────────────────────
$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;
$_image_pos_class = ($_image_position === 'end') ? ' layout-image-end' : '';

// ── Section style ─────────────────────────────────────────────────────────────
$_sec_style = 'padding-bottom: 20px;';

// ── Buttons HTML ─────────────────────────────────────────────────────────────
$_buttons_html = '';
if ($_btn1_label && $_btn1_url_esc) {
    $_buttons_html .= '<a href="' . $_btn1_url_esc . '" class="widget-button ' . $_btn1_style . '"' . $_btn1_target . '>' . $_btn1_label . '</a>';
}
if ($_btn2_label && $_btn2_url_esc) {
    $_buttons_html .= '<a href="' . $_btn2_url_esc . '" class="widget-button ' . $_btn2_style . '"' . $_btn2_target . '>' . $_btn2_label . '</a>';
}

// ── Description HTML (preserve line breaks) ───────────────────────────────────
$_desc_html = '';
if ($_description !== '' && $_description !== null) {
    // Split by empty lines to create paragraphs
    $_paragraphs = preg_split('/\n\s*\n/', $_description);
    foreach ($_paragraphs as $_para) {
        $_para = trim($_para);
        if ($_para === '') continue;
        
        // Preserve line breaks within paragraph using nl2br
        // First escape HTML special characters, then convert newlines to <br>
        $_para_escaped = htmlspecialchars($_para);
        $_para_with_br = nl2br($_para_escaped);
        
        $_desc_html .= '<p>' . $_para_with_br . '</p>';
    }
}

?>
<?php echo $_wdg_asset_html; ?>
<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-split-hero widget-<?php echo $_widget_class; ?> <?php echo $_color . $_image_pos_class; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="split-hero"
    style="<?php echo $_sec_style; ?>"
>
    <style>
        /* Flat CSS — no nesting */
        .widget-<?php echo $_widget_class; ?> {
            margin-block: 0;
            padding-inline: 0;
            position: relative;
            width: 100%;
            margin-inline: 0;
            max-width: none;
        }
        .widget-<?php echo $_widget_class; ?>.has-highlight-background {
            --widget-bg-color: var(--bg-primary);
        }
        .widget-<?php echo $_widget_class; ?> .widget-container {
            max-width: none;
            margin-inline: 0;
        }
        .widget-<?php echo $_widget_class; ?> .split-hero-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 500px;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .widget-<?php echo $_widget_class; ?> .split-hero-image {
            width: 100%;
            min-height: 300px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            margin: 0;
            padding: 0;
        }
        .widget-<?php echo $_widget_class; ?> .split-hero-overlay {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
        }
        .widget-<?php echo $_widget_class; ?> .split-hero-content {
            width: 100%;
            padding: var(--space-xl) var(--space-md);
            box-sizing: border-box;
        }
        @media (min-width: 990px) {
            .widget-<?php echo $_widget_class; ?> .split-hero-wrapper {
                flex-direction: row;
                min-height: 600px;
            }
            .widget-<?php echo $_widget_class; ?> .split-hero-image {
                width: 50%;
                min-height: 600px;
                flex-shrink: 0;
            }
            .widget-<?php echo $_widget_class; ?> .split-hero-content {
                width: 50%;
                padding: var(--space-4xl) var(--space-3xl);
                display: flex;
                align-items: center;
                flex-shrink: 0;
                box-sizing: border-box;
            }
            .widget-<?php echo $_widget_class; ?> .split-hero-content .widget-content {
                max-width: var(--content-width-md);
                width: 100%;
            }
            .widget-<?php echo $_widget_class; ?>.layout-image-end .split-hero-wrapper {
                flex-direction: row-reverse;
            }
            .widget-<?php echo $_widget_class; ?>.layout-image-end .split-hero-content {
                padding-left: var(--space-3xl);
            }
        }
    </style>

    <div class="widget-container">
        <div class="split-hero-wrapper">

            <div class="split-hero-image reveal reveal-fade" style="background-image: url('<?php echo $_bg_image; ?>');">
                <div class="split-hero-overlay" style="background-color: <?php echo $_overlay_rgba; ?>;"></div>
            </div>

            <div class="split-hero-content">
                <div class="widget-content content-flow widget-content-align-start">

                    <?php if ($_eyebrow): ?>
                    <div class="<?php echo $_eyebrow_classes; ?>" style="--reveal-delay: 0" data-setting="text"><?php echo $_eyebrow; ?></div>
                    <?php endif; ?>

                    <?php if ($_title): ?>
                    <h1 class="<?php echo $_title_classes; ?>" style="--reveal-delay: 1" data-setting="text"><?php echo $_title; ?></h1>
                    <?php endif; ?>

                    <?php if ($_desc_html): ?>
                    <div class="<?php echo $_desc_classes; ?>" style="--reveal-delay: 2" data-setting="text"><?php echo $_desc_html; ?></div>
                    <?php endif; ?>

                    <?php if ($_buttons_html): ?>
                    <div class="widget-actions reveal reveal-up" style="--reveal-delay: 3">
                        <?php echo $_buttons_html; ?>
                    </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</section>