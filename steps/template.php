<?php
/*
 * Widgetizer — Steps Widget — template.php
 * Prefix: stp
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
$_eyebrow        = htmlspecialchars($wdg_params['eyebrow']        ?? '');
$_title          = htmlspecialchars($wdg_params['title']          ?? '');
$_title_size     = htmlspecialchars($wdg_params['title_size']     ?? 't-2xl');

// ── Description: NO base64, only [nl] to \n ───────────────────────────────────
$_description_raw = $wdg_params['description'] ?? '';
$_description_with_nl = str_replace('[nl]', "\n", $_description_raw);
$_description = nl2br(htmlspecialchars($_description_with_nl));

$_header_align   = htmlspecialchars($wdg_params['header_align']   ?? 'center');
$_color          = htmlspecialchars($wdg_params['color_scheme']   ?? 'color-scheme-standard-primary');
$_steps          = $wdg_params['steps'] ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map = ['full'=>null,'xl'=>'1420px','lg'=>'1200px','md'=>'960px','sm'=>'760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;

// ── Header alignment class ────────────────────────────────────────────────────
$_header_align_class = '';
if ($_header_align === 'start') {
    $_header_align_class = ' widget-heading-align-left';
}

// ── Section style ─────────────────────────────────────────────────────────────
$_sec_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_sec_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

// ── Header HTML ───────────────────────────────────────────────────────────────
$_header_html = '';
if ($_eyebrow || $_title || $_description) {
    $_header_html = '<div class="widget-header' . $_header_align_class . '">';
    if ($_eyebrow) {
        $_header_html .= '<span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0">' . $_eyebrow . '</span>';
    }
    if ($_title) {
        $_header_html .= '<h2 class="w-headline ' . $_title_size . ' reveal reveal-up" style="--reveal-delay: 1">' . $_title . '</h2>';
    }
    if ($_description) {
        $_header_html .= '<div class="w-description reveal reveal-up" style="--reveal-delay: 2">' . $_description . '</div>';
    }
    $_header_html .= '</div>';
}

// ── Steps HTML ────────────────────────────────────────────────────────────────
$_steps_html = '';
$_step_index = 0;

foreach ($_steps as $_step) {
    $_s_image       = htmlspecialchars($_step['image']           ?? '');
    $_s_title       = htmlspecialchars($_step['title']           ?? '');
    $_s_title_size  = htmlspecialchars($_step['step_title_size'] ?? 't-3xl');
    
    // ── Step body: NO base64, only [nl] to \n ─────────────────────────────────
    $_s_body_raw    = $_step['body'] ?? '';
    $_s_body_with_nl = str_replace('[nl]', "\n", $_s_body_raw);
    $_s_body        = $_s_body_with_nl;
    
    $_s_btn_label   = htmlspecialchars($_step['btn_label']       ?? '');
    $_s_btn_url     = $_step['btn_url'] ?? '';
    if (function_exists('wdg_parse_links')) {
        $_s_btn_url = wdg_parse_links($_s_btn_url);
    }
    $_s_btn_url_esc = htmlspecialchars($_s_btn_url);
    $_s_btn_new_tab = ($_step['btn_new_tab'] ?? '') === '1';
    $_s_btn_style   = htmlspecialchars($_step['btn_style']       ?? 'widget-button-secondary');
    $_s_num         = $_step_index + 1;
    $_s_delay       = $_step_index;

    // Image
    $_img_html = '';
    if ($_s_image) {
        $_img_html = '<img src="' . $_s_image . '" alt="" loading="lazy" style="width:100%;height:auto;display:block;">';
    }

    // Body paragraphs with preserved line breaks
    $_body_html = '';
    if ($_s_body !== '' && $_s_body !== null) {
        $_paragraphs = preg_split('/\n\s*\n/', $_s_body);
        foreach ($_paragraphs as $_para) {
            $_para = trim($_para);
            if ($_para === '') continue;
            $_para_escaped = htmlspecialchars($_para);
            $_para_with_br = nl2br($_para_escaped);
            $_body_html .= '<p>' . $_para_with_br . '</p>';
        }
    }

    // Button
    $_btn_html = '';
    if ($_s_btn_label && $_s_btn_url_esc) {
        $_btn_target = $_s_btn_new_tab ? ' target="_blank" rel="noopener"' : '';
        $_btn_html = '<div><a href="' . $_s_btn_url_esc . '" class="widget-button ' . $_s_btn_style . '"' . $_btn_target . '>' . $_s_btn_label . '</a></div>';
    }

    $_steps_html .= '<div class="steps-item reveal reveal-up" style="--reveal-delay: ' . $_s_delay . '">';
    $_steps_html .= '<div class="steps-image">' . $_img_html . '</div>';
    $_steps_html .= '<div class="steps-badge-col"><div class="steps-badge" aria-hidden="true">' . $_s_num . '</div></div>';
    $_steps_html .= '<div class="steps-content">';
    if ($_s_title) {
        $_steps_html .= '<h3 class="w-title ' . $_s_title_size . '">' . $_s_title . '</h3>';
    }
    if ($_body_html) {
        $_steps_html .= '<div class="w-body w-rte">' . $_body_html . '</div>';
    }
    $_steps_html .= $_btn_html;
    $_steps_html .= '</div></div>';

    $_step_index++;
}

?>
<?php echo $_wdg_asset_html; ?>
<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-type-steps widget-<?php echo $_widget_class; ?> <?php echo $_color; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="steps"
    style="<?php echo $_sec_style; ?>"
>
    <style>
        /* Flat CSS — no nesting */
        .widget-<?php echo $_widget_class; ?> .steps-list {
            display: flex;
            flex-direction: column;
        }
        .widget-<?php echo $_widget_class; ?> .steps-item {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: var(--space-2xl);
            align-items: start;
            padding-block: var(--space-2xl);
        }
        .widget-<?php echo $_widget_class; ?> .steps-item:first-child {
            padding-block-start: 0;
        }
        .widget-<?php echo $_widget_class; ?> .steps-item:last-child {
            padding-block-end: 0;
        }
        .widget-<?php echo $_widget_class; ?> .steps-image {
            border-radius: var(--radius-lg);
            overflow: hidden;
        }
        .widget-<?php echo $_widget_class; ?> .steps-image img {
            width: 100%;
            height: auto;
            display: block;
        }
        .widget-<?php echo $_widget_class; ?> .steps-badge-col {
            align-self: stretch;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        .widget-<?php echo $_widget_class; ?> .steps-badge-col::before {
            content: "";
            position: absolute;
            top: calc(-1 * var(--space-2xl));
            bottom: calc(-1 * var(--space-2xl));
            left: 50%;
            width: var(--border-width-medium);
            background-color: var(--border-color);
            transform: translateX(-50%);
        }
        .widget-<?php echo $_widget_class; ?> .steps-item:first-child .steps-badge-col::before {
            top: 24px;
        }
        .widget-<?php echo $_widget_class; ?> .steps-item:last-child .steps-badge-col::before {
            bottom: calc(100% - 24px);
        }
        .widget-<?php echo $_widget_class; ?> .steps-badge {
            position: relative;
            z-index: 1;
            width: 48px;
            height: 48px;
            border-radius: var(--radius-marker);
            background-color: var(--accent);
            color: var(--accent-text);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: var(--font-size-lg);
            font-weight: 600;
            flex-shrink: 0;
        }
        .widget-<?php echo $_widget_class; ?> .steps-content {
            display: flex;
            flex-direction: column;
            gap: var(--space-md);
        }
        .widget-<?php echo $_widget_class; ?> .steps-content .w-title {
            margin: 0;
        }
        .widget-<?php echo $_widget_class; ?> .steps-content .w-body {
            margin: 0;
        }
        @media (min-width: 750px) {
            .widget-<?php echo $_widget_class; ?> .steps-item:nth-child(even) .steps-image {
                order: 3;
            }
            .widget-<?php echo $_widget_class; ?> .steps-item:nth-child(even) .steps-badge-col {
                order: 2;
            }
            .widget-<?php echo $_widget_class; ?> .steps-item:nth-child(even) .steps-content {
                order: 1;
                text-align: end;
                align-items: flex-end;
            }
        }
        @media (max-width: 749px) {
            .widget-<?php echo $_widget_class; ?> .steps-item {
                grid-template-columns: 1fr;
                gap: var(--space-lg);
                text-align: center;
            }
            .widget-<?php echo $_widget_class; ?> .steps-badge-col {
                margin-inline: auto;
                align-self: auto;
            }
            .widget-<?php echo $_widget_class; ?> .steps-badge-col::before {
                display: none;
            }
            .widget-<?php echo $_widget_class; ?> .steps-item .steps-image {
                order: 2;
            }
            .widget-<?php echo $_widget_class; ?> .steps-item .steps-badge-col {
                order: 1;
            }
            .widget-<?php echo $_widget_class; ?> .steps-item .steps-content {
                order: 3;
                align-items: center;
            }
        }
    </style>

    <div class="widget-container widget-container-padded">
        <?php echo $_header_html; ?>

        <div class="widget-content">
            <div class="steps-list">
                <?php echo $_steps_html; ?>
            </div>
        </div>
    </div>
</section>