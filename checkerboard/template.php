<?php
/*
 * Widgetizer — Checkerboard Widget — template.php
 * Prefix: chkb
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

// ── Παράμετροι ────────────────────────────────────────────────────────────────
$_eyebrow     = htmlspecialchars($wdg_params['eyebrow']      ?? '');
$_title       = htmlspecialchars($wdg_params['title']        ?? '');
$_description = htmlspecialchars($wdg_params['description']  ?? '');
$_columns     = (int)($wdg_params['columns']                 ?? 4);
$_color       = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');
$_items       = $wdg_params['items'] ?? [];

$_container_width = $wdg_params['container_width'] ?? 'full';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? null;
$_full_width = ($_container_width === 'full');

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;

$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';

// ── Widget header ─────────────────────────────────────────────────────────────
$_header_html = '';
if ($_eyebrow !== '')     $_header_html .= '<span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0" data-setting="eyebrow">' . $_eyebrow . '</span>' . PHP_EOL;
if ($_title !== '')       $_header_html .= '<h2 class="w-headline reveal reveal-up" style="--reveal-delay: 1" data-setting="title">' . $_title . '</h2>' . PHP_EOL;
if ($_description !== '') $_header_html .= '<p class="w-description reveal reveal-up" style="--reveal-delay: 2" data-setting="description">' . $_description . '</p>' . PHP_EOL;

// ── Items HTML ────────────────────────────────────────────────────────────────
$_items_html = '';
foreach ($_items as $_i => $_item) {
    $_type = $_item['type'] ?? 'content';

    if ($_type === 'content') {
        $_item_title  = htmlspecialchars($_item['title']        ?? '');
        $_item_desc   = htmlspecialchars($_item['description']  ?? '');
        $_btn_label   = htmlspecialchars($_item['button_label'] ?? '');
        $_btn_url     = htmlspecialchars(wdg_parse_links($_item['button_url'] ?? '#'));
        $_open_new    = ($_item['open_new'] ?? '_self') === '_blank';
        $_btn_target  = $_open_new ? ' target="_blank" rel="noopener noreferrer"' : ' target="_self"';

        $_items_html .= '<li class="checkerboard-item is-content reveal reveal-up" style="--reveal-delay: ' . $_i . '" data-block-id="' . $_widget_id . '_item_' . $_i . '">';
        $_items_html .= '<div class="checkerboard-item-content">';
        if ($_item_title !== '') $_items_html .= '<h2 class="w-title t-2xl" data-setting="title">' . $_item_title . '</h2>';
        if ($_item_desc !== '')  $_items_html .= '<div class="w-body w-rte t-sm" data-setting="description"><p>' . $_item_desc . '</p></div>';
        if ($_btn_label !== '')  $_items_html .= '<a href="' . $_btn_url . '" class="widget-button widget-button-secondary" data-setting="button_link"' . $_btn_target . '>' . $_btn_label . '</a>';
        $_items_html .= '</div></li>' . PHP_EOL;

    } else {
        $_image = str_replace(['"', "'"], '', $_item['image'] ?? '');
        $_items_html .= '<li class="checkerboard-item is-image reveal reveal-up" style="--reveal-delay: ' . $_i . '" data-block-id="' . $_widget_id . '_item_' . $_i . '">';
        $_items_html .= '<div class="checkerboard-item-image"><img src="' . $_image . '" alt="" loading="lazy"></div>';
        $_items_html .= '</li>' . PHP_EOL;
    }
}

// ── Output ────────────────────────────────────────────────────────────────────
echo $_wdg_asset_html;
?>
<section
  id="<?php echo $_widget_id; ?>"
  class="widget widget-type-checkerboard widget-<?php echo $_widget_class; ?> <?php echo $_color; ?>"
  style="<?php echo $_section_style; ?>"
  data-widget-id="<?php echo $_widget_id; ?>"
  data-widget-type="checkerboard"
>
  <style>
    .widget-<?php echo $_widget_class; ?> .checkerboard-grid {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .widget-<?php echo $_widget_class; ?> .checkerboard-item {
      position: relative;
      border-radius: var(--radius-lg);
      overflow: hidden;
      border: var(--card-border);
    }

    .widget-<?php echo $_widget_class; ?> .checkerboard-item.is-image {
      aspect-ratio: 1 / 1;
    }

    .widget-<?php echo $_widget_class; ?> .checkerboard-item.is-content {
      display: flex;
      flex-direction: column;
      min-height: 300px;
    }

    .widget-<?php echo $_widget_class; ?> .checkerboard-item-content {
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      flex: 1;
      padding: var(--space-xl);
      background-color: var(--bg-primary);
    }

    .widget-<?php echo $_widget_class; ?> .checkerboard-item-image {
      width: 100%;
      height: 100%;
    }

    .widget-<?php echo $_widget_class; ?> .checkerboard-item-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .widget-<?php echo $_widget_class; ?> .checkerboard-item-content .w-title {
      margin-block-end: var(--space-md);
    }

    .widget-<?php echo $_widget_class; ?> .checkerboard-item-content .w-body {
      margin-block-end: var(--space-md);
    }

    .widget-<?php echo $_widget_class; ?> .checkerboard-item-content .widget-button {
      align-self: flex-start;
    }

    .widget-<?php echo $_widget_class; ?>.color-scheme-standard-secondary .checkerboard-item-content,
    .widget-<?php echo $_widget_class; ?>.color-scheme-highlight-secondary .checkerboard-item-content {
      background-color: var(--bg-secondary);
    }

    .widget-<?php echo $_widget_class; ?>.color-scheme-standard-secondary .checkerboard-item,
    .widget-<?php echo $_widget_class; ?>.color-scheme-highlight-primary .checkerboard-item,
    .widget-<?php echo $_widget_class; ?>.color-scheme-highlight-secondary .checkerboard-item {
      border: var(--border-width-thin) solid var(--border-color);
    }

    @media (max-width: 749px) {
      .widget-<?php echo $_widget_class; ?> .checkerboard-item-content {
        padding: var(--space-lg);
      }
    }
  </style>

  <div class="widget-container">
    <?php if ($_header_html): ?>
    <div class="widget-header">
      <?php echo $_header_html; ?>
    </div>
    <?php endif; ?>

    <div class="widget-content">
      <ul class="checkerboard-grid widget-grid" style="--grid-cols-desktop: <?php echo $_columns; ?>">
        <?php echo $_items_html; ?>
      </ul>
    </div>
  </div>
</section>
