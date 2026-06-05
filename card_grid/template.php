<?php
/*
 * Widgetizer — Card Grid Widget — template.php
 * Prefix: icg
 *
 * Pure PHP string output — χωρίς DOMDocument, χωρίς html_markup.
 * Μόνο images — χωρίς icons.
 */

// ── Assets ────────────────────────────────────────────────────────────────────
$_wdg_assets     = 'admin/builder_widget_assets/';
$_wdg_css        = $_wdg_assets . 'base.css';
$_wdg_js         = $_wdg_assets . 'scripts.js';
$_wdg_asset_html = '';
if (!in_array($_wdg_css, $document->loadedFiles)) {
    $_wdg_asset_html .= '<link href="' . $_wdg_css . '" rel="stylesheet" type="text/css">' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_css;
}
if (!in_array($_wdg_js, $document->loadedFiles)) {
    $_wdg_asset_html .= '<script src="' . $_wdg_js . '"></script>' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_js;
}

// ── Παράμετροι ────────────────────────────────────────────────────────────────
$_eyebrow     = htmlspecialchars($wdg_params['eyebrow']      ?? '');
$_title       = htmlspecialchars($wdg_params['title']        ?? '');
$_description = htmlspecialchars($wdg_params['description']  ?? '');
$_color       = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');
$_cols        = (int)($wdg_params['columns']                 ?? 4);
$_card_layout = $wdg_params['card_layout']                   ?? 'box';
$_btn_style   = htmlspecialchars($wdg_params['btn_style']    ?? 'widget-button-secondary');
$_items       = $wdg_params['items'] ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;
$_layout_class = ($_card_layout === 'flat') ? ' card-layout-flat' : '';

$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';

// ── Widget header ─────────────────────────────────────────────────────────────
$_header_html = '';
if ($_eyebrow !== '') $_header_html .= '<span class="w-eyebrow" data-setting="eyebrow">' . $_eyebrow . '</span>' . PHP_EOL;
if ($_title !== '')   $_header_html .= '<h2 class="w-headline" data-setting="title">' . $_title . '</h2>' . PHP_EOL;
if ($_description !== '') $_header_html .= '<p class="w-description" data-setting="description">' . $_description . '</p>' . PHP_EOL;

// ── Cards HTML ────────────────────────────────────────────────────────────────
$_cards_html = '';
foreach ($_items as $_ci => $_card) {
    $_c_subtitle = htmlspecialchars($_card['subtitle']    ?? '');
    $_c_title    = htmlspecialchars($_card['title']       ?? '');
    $_c_desc     = htmlspecialchars($_card['description'] ?? '');
    $_c_btn_lbl  = htmlspecialchars($_card['btn_label']   ?? '');
    $_c_btn_url  = htmlspecialchars(wdg_parse_links($_card['btn_url'] ?? '#'));
    $_c_new_tab  = ($_card['btn_new_tab'] ?? '0') === '1' ? ' target="_blank" rel="noopener noreferrer"' : ' target="_self"';
    $_card_image = str_replace(['"', "'"], '', $_card['image'] ?? '');
    $_block_id   = $_widget_id . '_card' . $_ci;

    $_cards_html .= '<li class="widget-card reveal reveal-up" style="--reveal-delay: ' . $_ci . '" data-block-id="' . $_block_id . '">';
    $_cards_html .= '<div class="widget-card-content">';

    if ($_card_image) {
        $_cards_html .= '<img src="' . $_card_image . '" alt="" class="widget-card-image" loading="lazy">';
    }
    if ($_c_subtitle) $_cards_html .= '<span class="w-eyebrow" data-setting="subtitle">' . $_c_subtitle . '</span>';
    if ($_c_title)    $_cards_html .= '<h2 class="w-title t-xl" data-setting="title">' . $_c_title . '</h2>';
    if ($_c_desc)     $_cards_html .= '<div class="w-body w-rte t-sm" data-setting="description"><p>' . $_c_desc . '</p></div>';

    if ($_c_btn_lbl) {
        $_cards_html .= '<div class="widget-card-footer">';
        $_cards_html .= '<a href="' . $_c_btn_url . '" class="widget-button ' . $_btn_style . '" data-setting="button_link"' . $_c_new_tab . '>' . $_c_btn_lbl . '</a>';
        $_cards_html .= '</div>';
    }

    $_cards_html .= '</div></li>' . PHP_EOL;
}

// ── Output ────────────────────────────────────────────────────────────────────
echo $_wdg_asset_html;
?>
<section
  id="<?php echo $_widget_id; ?>"
  class="widget widget-type-card-grid widget-<?php echo $_widget_class; ?> <?php echo $_color . $_layout_class; ?>"
  style="<?php echo $_section_style; ?>"
  data-widget-id="<?php echo $_widget_id; ?>"
  data-widget-type="card-grid"
>
  <style>
    .widget-<?php echo $_widget_class; ?>:not(.card-layout-flat).color-scheme-standard-secondary .widget-card,
    .widget-<?php echo $_widget_class; ?>:not(.card-layout-flat).color-scheme-highlight-secondary .widget-card {
      background-color: var(--bg-secondary);
    }

    .widget-<?php echo $_widget_class; ?>:not(.card-layout-flat).color-scheme-standard-secondary .widget-card,
    .widget-<?php echo $_widget_class; ?>:not(.card-layout-flat).color-scheme-highlight-primary .widget-card,
    .widget-<?php echo $_widget_class; ?>:not(.card-layout-flat).color-scheme-highlight-secondary .widget-card {
      border: var(--border-width-thin) solid var(--border-color);
    }
  </style>

  <div class="widget-container">
    <?php if ($_header_html): ?>
    <div class="widget-header">
      <?php echo $_header_html; ?>
    </div>
    <?php endif; ?>

    <div class="widget-content">
      <ul class="widget-card-grid widget-grid" style="--grid-cols-desktop: <?php echo $_cols; ?>">
        <?php echo $_cards_html; ?>
      </ul>
    </div>
  </div>
</section>
