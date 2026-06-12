<?php
/*
 * Widgetizer — Event List Widget — template.php
 * Prefix: el
 *
 * Pure PHP string output — χωρίς DOMDocument, χωρίς html_markup.
 */
// ── Assets ────────────────────────────────────────────────────────────────────
$_wdg_assets = 'admin/builder_widget_assets/';
$_wdg_css = $_wdg_assets . 'base.css';
$_wdg_js = $_wdg_assets . 'scripts.js';
$_wdg_asset_html = '';
if(!in_array($_wdg_css, $document->loadedFiles)) {
    $_wdg_asset_html .= '<link href="' . $_wdg_css . '" rel="stylesheet" type="text/css">' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_css;
}
if(!in_array($_wdg_js, $document->loadedFiles)) {
    $_wdg_asset_html .= '<script src="' . $_wdg_js . '"></script>' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_js;
}
// ── Παράμετροι ────────────────────────────────────────────────────────────────
$_eyebrow = htmlspecialchars($wdg_params['eyebrow'] ?? '');
$_title = htmlspecialchars($wdg_params['title'] ?? '');
$_description = htmlspecialchars($wdg_params['description'] ?? '');
$_header_align = htmlspecialchars($wdg_params['header_align'] ?? 'start');
$_color = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');
$_items = $wdg_params['items'] ?? [];
$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');
$_widget_id = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;
$_section_style = 'padding-bottom: 20px;';
if(!$_full_width && $_max_width) $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
// ── Widget header ─────────────────────────────────────────────────────────────
$_header_html = '';
if($_eyebrow !== '') $_header_html .= '<span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0" data-setting="eyebrow">' . $_eyebrow . '</span>' . PHP_EOL;
if($_title !== '') $_header_html .= '<h2 class="w-headline reveal reveal-up" style="--reveal-delay: 1" data-setting="title">' . $_title . '</h2>' . PHP_EOL;
if($_description !== '') $_header_html .= '<p class="w-description reveal reveal-up" style="--reveal-delay: 2" data-setting="description">' . $_description . '</p>' . PHP_EOL;
// ── Events HTML ───────────────────────────────────────────────────────────────
$_events_html = '';
foreach($_items as $_ei => $_item) {
    $_day = htmlspecialchars($_item['day'] ?? '');
    $_month = htmlspecialchars($_item['month'] ?? '');
    $_ev_title = htmlspecialchars($_item['title'] ?? '');
    $_location = htmlspecialchars($_item['location'] ?? '');
    $_desc = htmlspecialchars($_item['description'] ?? '');
    $_btn_label = htmlspecialchars($_item['btn_label'] ?? '');
    $_btn_url = htmlspecialchars(wdg_parse_links($_item['btn_url'] ?? '#'));
    $_btn_new_tab = ($_item['btn_new_tab'] ?? '0') === '1' ? ' target="_blank" rel="noopener noreferrer"' : '';
    $_btn_style = htmlspecialchars($_item['btn_style'] ?? 'widget-button-secondary');
    $_block_id = $_widget_id . '_event_' . $_ei;
    $_events_html .= '<li class="widget-card reveal reveal-up" style="--reveal-delay: ' . $_ei . '" data-block-id="' . $_block_id . '">';
    $_events_html .= '<div class="event-date">';
    $_events_html .= '<span class="event-date-day t-4xl t-body-bold t-heading" data-setting="day">' . $_day . '</span>';
    $_events_html .= '<span class="event-date-month w-meta t-sm" data-setting="month">' . $_month . '</span>';
    $_events_html .= '</div>';
    $_events_html .= '<div class="widget-card-content">';
    if($_ev_title) $_events_html .= '<h3 class="w-title t-2xl" data-setting="title">' . $_ev_title . '</h3>';
    if($_location) $_events_html .= '<p class="w-meta" data-setting="location">' . $_location . '</p>';
    if($_desc) $_events_html .= '<div class="w-body w-rte t-sm" data-setting="description"><p>' . $_desc . '</p></div>';
    if($_btn_label) {
        $_events_html .= '<div class="widget-card-footer">';
        $_events_html .= '<a href="' . $_btn_url . '" class="widget-button ' . $_btn_style . '" data-setting="button_link"' . $_btn_new_tab . '>' . $_btn_label . '</a>';
        $_events_html .= '</div>';
    }
    $_events_html .= '</div></li>' . PHP_EOL;
}
// ── Output ────────────────────────────────────────────────────────────────────
echo $_wdg_asset_html;
?>
<section
        id="<?php echo $_widget_id; ?>"
        class="widget widget-type-event-list widget-<?php echo $_widget_class; ?> <?php echo $_color; ?>"
        style="<?php echo $_section_style; ?>"
        data-widget-id="<?php echo $_widget_id; ?>"
        data-widget-type="event-list"
>
    <style>
        .widget-<?php echo $_widget_class; ?> .widget-container {
            padding-top: 30px;
        }

        .widget-<?php echo $_widget_class; ?> .event-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: var(--space-xl);
        }

        .widget-<?php echo $_widget_class; ?> .widget-card {
            gap: var(--space-lg);
        }

        .widget-<?php echo $_widget_class; ?> .event-date {
            flex-shrink: 0;
            width: 80px;
            height: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: var(--border-width-medium) solid var(--border-color);
            border-radius: var(--radius-sm);
            text-align: center;
            align-self: flex-start;
        }

        .widget-<?php echo $_widget_class; ?> .event-date-month {
            margin-block-start: var(--space-xs);
        }

        .widget-<?php echo $_widget_class; ?>.color-scheme-standard-secondary .widget-card,
        .widget-<?php echo $_widget_class; ?>.color-scheme-highlight-secondary .widget-card {
            background-color: var(--bg-secondary);
        }

        .widget-<?php echo $_widget_class; ?>.color-scheme-standard-secondary .widget-card,
        .widget-<?php echo $_widget_class; ?>.color-scheme-highlight-primary .widget-card,
        .widget-<?php echo $_widget_class; ?>.color-scheme-highlight-secondary .widget-card {
            border: var(--border-width-thin) solid var(--border-color);
        }

        @media (min-width: 750px) {
            .widget-<?php echo $_widget_class; ?> .widget-card {
                flex-direction: row;
                gap: var(--space-2xl);
                padding: var(--space-2xl);
            }

            .widget-<?php echo $_widget_class; ?> .event-date {
                width: 100px;
                height: 100px;
            }
        }
    </style>
    <div class="widget-container">
        <?php if($_header_html): ?>
            <div class="widget-header widget-header--align-<?php echo $_header_align; ?>">
                <?php echo $_header_html; ?>
            </div>
        <?php endif; ?>
        <div class="widget-content">
            <ul class="event-list">
                <?php echo $_events_html; ?>
            </ul>
        </div>
    </div>
</section>
