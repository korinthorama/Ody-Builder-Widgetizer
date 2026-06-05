<?php
/*
 * Widgetizer — Features Split Widget — template.php
 * Prefix: fs
 *
 * Pure PHP string output — χωρίς DOMDocument, χωρίς html_markup.
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

// ── Font Awesome ──────────────────────────────────────────────────────────────
$_fa_css = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css';
$_fa_loaded = false;
foreach ($document->loadedFiles as $_f) {
    if (strpos($_f, 'font-awesome') !== false) { $_fa_loaded = true; break; }
}
if (!$_fa_loaded) {
    $_wdg_asset_html .= '<link rel="stylesheet" href="' . $_fa_css . '">' . PHP_EOL;
    $document->loadedFiles[] = $_fa_css;
}

// ── Παράμετροι ────────────────────────────────────────────────────────────────
$_eyebrow      = htmlspecialchars($wdg_params['eyebrow']      ?? '');
$_title        = htmlspecialchars($wdg_params['title']        ?? '');
$_description  = htmlspecialchars($wdg_params['description']  ?? '');
$_header_align = htmlspecialchars($wdg_params['header_align'] ?? 'start');
$_icon_style   = htmlspecialchars($wdg_params['icon_style']   ?? 'w-icon-filled');
$_icon_size    = htmlspecialchars($wdg_params['icon_size']    ?? 'w-icon-lg');
$_icon_shape   = htmlspecialchars($wdg_params['icon_shape']   ?? 'w-icon-circle');
$_color        = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');
$_items        = $wdg_params['items'] ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;

$_icon_span_cls = trim($_icon_style . ' ' . $_icon_shape . ' ' . $_icon_size);
$_icon_font_size_map = ['w-icon-sm' => '18px', 'w-icon-md' => '24px', 'w-icon-lg' => '32px', 'w-icon-xl' => '39px'];
$_icon_line_height_map = ['w-icon-sm' => '23px', 'w-icon-md' => '29px', 'w-icon-lg' => '39px', 'w-icon-xl' => '48px'];
$_icon_font_size = $_icon_font_size_map[$_icon_size] ?? '39px';
$_icon_line_height = $_icon_line_height_map[$_icon_size] ?? '48px';

$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';

// ── Widget header ─────────────────────────────────────────────────────────────
$_header_html = '';
if ($_eyebrow !== '')    $_header_html .= '<span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0" data-setting="eyebrow">' . $_eyebrow . '</span>' . PHP_EOL;
if ($_title !== '')      $_header_html .= '<h2 class="w-headline reveal reveal-up" style="--reveal-delay: 1" data-setting="title">' . $_title . '</h2>' . PHP_EOL;
if ($_description !== '') $_header_html .= '<p class="w-description reveal reveal-up" style="--reveal-delay: 2" data-setting="description">' . $_description . '</p>' . PHP_EOL;

// ── Features HTML ─────────────────────────────────────────────────────────────
$_features_html = '';
foreach ($_items as $_fi => $_item) {
    $_icon_class = htmlspecialchars($_item['icon_class'] ?? '');
    $_f_title    = htmlspecialchars($_item['title']      ?? '');
    $_f_desc     = htmlspecialchars($_item['description'] ?? '');
    $_block_id   = $_widget_id . '_feature_' . $_fi;

    $_features_html .= '<li class="features-split-item reveal reveal-up" style="--reveal-delay: ' . $_fi . '" data-block-id="' . $_block_id . '">';
    if ($_icon_class) {
        $_features_html .= '<span class="' . $_icon_span_cls . '"><i class="fa ' . $_icon_class . ' w-icon" style="font-size:' . $_icon_font_size . '; line-height:' . $_icon_line_height . ';"></i></span>';
    }
    $_features_html .= '<div class="features-split-item-content">';
    if ($_f_title) $_features_html .= '<h3 class="features-split-item-title w-title t-2xl" data-setting="title">' . $_f_title . '</h3>';
    if ($_f_desc)  $_features_html .= '<div class="features-split-item-description w-body w-rte t-sm" data-setting="description"><p>' . $_f_desc . '</p></div>';
    $_features_html .= '</div></li>' . PHP_EOL;
}

// ── Output ────────────────────────────────────────────────────────────────────
echo $_wdg_asset_html;
?>
<section
  id="<?php echo $_widget_id; ?>"
  class="widget widget-features-split widget-<?php echo $_widget_class; ?> <?php echo $_color; ?>"
  style="<?php echo $_section_style; ?>"
  data-widget-id="<?php echo $_widget_id; ?>"
  data-widget-type="features-split"
>
  <style>
    .widget-<?php echo $_widget_class; ?> .features-split-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: var(--space-2xl);
    }

    .widget-<?php echo $_widget_class; ?> .features-split-content {
      display: flex;
      flex-direction: column;
      gap: var(--space-sm);
    }

    .widget-<?php echo $_widget_class; ?> .features-split-content > * { margin-block: 0; }

    .widget-<?php echo $_widget_class; ?> .features-split-list {
      display: flex;
      flex-direction: column;
      gap: var(--space-xl);
      list-style: none;
      padding: 0;
      margin: 0;
      padding-inline-start: var(--space-xl);
      border-inline-start: var(--border-width-thin) solid var(--border-color);
    }

    .widget-<?php echo $_widget_class; ?> .features-split-item {
      display: flex;
      gap: var(--space-md);
    }

    .widget-<?php echo $_widget_class; ?> .features-split-item-content {
      display: flex;
      flex-direction: column;
      gap: var(--space-xs);
    }

    .widget-<?php echo $_widget_class; ?> .features-split-item-description { margin: 0; }

    @media (min-width: 750px) {
      .widget-<?php echo $_widget_class; ?> .features-split-grid { grid-template-columns: 1fr 1fr; gap: var(--space-3xl); align-items: start; }
    }

    @media (min-width: 990px) {
      .widget-<?php echo $_widget_class; ?> .features-split-grid { gap: var(--space-4xl); }
    }
  </style>

  <div class="widget-container">
    <div class="features-split-grid">
      <div class="features-split-content">
        <?php if ($_header_html): ?>
        <div class="widget-header widget-header--align-<?php echo $_header_align; ?>">
          <?php echo $_header_html; ?>
        </div>
        <?php endif; ?>
      </div>

      <div class="features-split-features">
        <ul class="features-split-list">
          <?php echo $_features_html; ?>
        </ul>
      </div>
    </div>
  </div>
</section>
