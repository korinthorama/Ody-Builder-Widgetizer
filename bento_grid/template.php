<?php
/*
 * Widgetizer — Bento Grid Widget — template.php
 * Prefix: bg
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

// ── Helper: hex + opacity → rgba ─────────────────────────────────────────────
if (!function_exists('_wdg_bg_hex_to_rgba')) {
    function _wdg_bg_hex_to_rgba(string $hex, float $opacity): string {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        return 'rgba(' . hexdec(substr($hex,0,2)) . ',' . hexdec(substr($hex,2,2)) . ',' . hexdec(substr($hex,4,2)) . ',' . $opacity . ')';
    }
}

// ── Παράμετροι ────────────────────────────────────────────────────────────────
$_eyebrow     = htmlspecialchars($wdg_params['eyebrow']      ?? '');
$_title       = htmlspecialchars($wdg_params['title']        ?? '');
$_description = htmlspecialchars($wdg_params['description']  ?? '');
$_color       = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');
$_items       = $wdg_params['items'] ?? [];

$_container_width = $wdg_params['container_width'] ?? 'full';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? null;
$_full_width = ($_container_width === 'full');

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;

$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

// ── Grid spans CSS ────────────────────────────────────────────────────────────
$_grid_spans_css = '';
foreach ($_items as $_i => $_item) {
    $_item_block_id = $_widget_id . '_item_' . $_i;
    $_col = max(1, min(4, (int)($_item['col_span'] ?? 1)));
    $_row = max(1, min(3, (int)($_item['row_span'] ?? 1)));
    $_grid_spans_css .= '
      .widget-' . $_widget_class . ' [data-block-id="' . $_item_block_id . '"] {
        grid-column: span ' . $_col . ';
        grid-row: span ' . $_row . ';
      }';
}

// ── Widget header ─────────────────────────────────────────────────────────────
$_header_html = '';
if ($_eyebrow !== '') {
    $_header_html .= '<span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0" data-setting="eyebrow">' . $_eyebrow . '</span>' . PHP_EOL;
}
if ($_title !== '') {
    $_header_html .= '<h2 class="w-headline reveal reveal-up" style="--reveal-delay: 1" data-setting="title">' . $_title . '</h2>' . PHP_EOL;
}
if ($_description !== '') {
    $_header_html .= '<p class="w-description reveal reveal-up" style="--reveal-delay: 2" data-setting="description">' . $_description . '</p>' . PHP_EOL;
}

// ── Bento items HTML ──────────────────────────────────────────────────────────
$_items_html = '';
foreach ($_items as $_i => $_item) {
    $_item_block_id    = $_widget_id . '_item_' . $_i;
    $_item_title       = htmlspecialchars($_item['title']           ?? '');
    $_item_text        = htmlspecialchars($_item['text']            ?? '');
    $_item_bg          = str_replace(['"', "'"], '', $_item['bg_image'] ?? '');
    $_item_overlay_hex = str_replace('[id]', '#', $_item['overlay_color'] ?? '[id]000000');
    $_item_opacity     = (float)($_item['overlay_opacity']          ?? 0.4);
    $_item_overlay     = _wdg_bg_hex_to_rgba($_item_overlay_hex, $_item_opacity);
    $_item_align       = htmlspecialchars($_item['align']           ?? 'align-start');
    $_item_color       = htmlspecialchars($_item['color_scheme']    ?? 'color-scheme-standard-primary');
    
    // ── Link parameters ───────────────────────────────────────────────────────
    $_item_link_url    = $_item['link_url'] ?? '';
    $_item_link_newtab = ($_item['link_newtab'] ?? '0') === '1';
    $_has_link         = !empty($_item_link_url);
    
    // Χρήση της global wdg_parse_links() όπως στο checkerboard
    if ($_has_link) {
        $_item_link_url = htmlspecialchars(wdg_parse_links($_item_link_url));
    }
    
    $_link_target = $_item_link_newtab ? ' target="_blank" rel="noopener noreferrer"' : '';
    $_link_attrs  = $_has_link ? ' href="' . $_item_link_url . '"' . $_link_target : '';

    $_item_classes = 'bento-item block-item ' . $_item_align . ' reveal reveal-scale';
    if ($_item_bg) $_item_classes .= ' has-bg-image has-overlay';

    $_item_style = '--reveal-delay: ' . $_i . ';';
    if ($_item_bg)      $_item_style .= ' --bento-bg-image: url(\'' . $_item_bg . '\');';
    if ($_item_overlay) $_item_style .= ' --widget-overlay-color: ' . $_item_overlay . ';';

    // Build item HTML (with or without <a> wrapper)
    $_item_inner_html = '
            <div class="bento-content">';

    if ($_item_title !== '') {
        $_item_inner_html .= '<h2 class="w-headline t-lg" data-setting="title">' . $_item_title . '</h2>';
    }
    if ($_item_text !== '') {
        $_item_inner_html .= '<p class="w-body t-sm" data-setting="text">' . $_item_text . '</p>';
    }

    $_item_inner_html .= '
            </div>';

    // Wrap with <a> if link exists
    if ($_has_link) {
        $_items_html .= '
          <a class="' . $_item_classes . ' ' . $_item_color . '"
               style="' . $_item_style . '"
               data-block-id="' . $_item_block_id . '"' . $_link_attrs . '>' .
               $_item_inner_html . '
          </a>';
    } else {
        $_items_html .= '
          <div class="' . $_item_classes . ' ' . $_item_color . '"
               style="' . $_item_style . '"
               data-block-id="' . $_item_block_id . '">' .
               $_item_inner_html . '
          </div>';
    }
}

// ── Output ────────────────────────────────────────────────────────────────────
echo $_wdg_asset_html;
?>
<section
  id="<?php echo $_widget_id; ?>"
  class="widget widget-bento-grid widget-<?php echo $_widget_class; ?> <?php echo $_color; ?>"
  style="<?php echo $_section_style; ?>"
  data-widget-id="<?php echo $_widget_id; ?>"
  data-widget-type="bento-grid"
>
  <style>
    .widget-<?php echo $_widget_class; ?> .bento-grid-container {
      display: grid;
      grid-template-columns: repeat(1, 1fr);
      gap: var(--space-md);
      min-height: unset !important;
        float: none !important;
    }

    .widget-<?php echo $_widget_class; ?> .bento-item {
      display: flex;
      flex-direction: column;
      padding: var(--space-xl);
      border-radius: var(--radius-lg);
      overflow: hidden;
      border: var(--border-width-thin) solid var(--border-color);
      position: relative;
      text-decoration: none;
      transition: border-color 0.3s ease;
      min-height: 200px;
      justify-content: flex-end;
    }

    /* Link styling - inherit colors and remove default link underline */
    .widget-<?php echo $_widget_class; ?> a.bento-item {
      color: inherit;
      text-decoration: none;
    }

    .widget-<?php echo $_widget_class; ?> a.bento-item:hover {
      border-color: var(--border-color);
    }

    .widget-<?php echo $_widget_class; ?> .bento-item.has-bg-color,
    .widget-<?php echo $_widget_class; ?> .bento-item.has-bg-image {
      border: none;
      background: none;
    }

    .widget-<?php echo $_widget_class; ?> .bento-item.align-center { align-items: center; text-align: center; }
    .widget-<?php echo $_widget_class; ?> .bento-item.align-start  { align-items: flex-start; text-align: start; }

    .widget-<?php echo $_widget_class; ?> .bento-item:hover { border-color: var(--border-color); }

    .widget-<?php echo $_widget_class; ?> .bento-item.has-bg-image::before,
    .widget-<?php echo $_widget_class; ?> .bento-item.has-bg-color::before {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: inherit;
      z-index: 1;
      transform: scale(1);
      transition: transform 0.3s ease;
    }

    .widget-<?php echo $_widget_class; ?> .bento-item.has-bg-image::before {
      background-image: var(--bento-bg-image);
      background-size: cover;
      background-position: center;
    }

    .widget-<?php echo $_widget_class; ?> .bento-item.has-bg-color::before {
      background-color: var(--bento-bg-color);
    }

    .widget-<?php echo $_widget_class; ?> .bento-item.has-overlay::after {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: inherit;
      background-color: var(--widget-overlay-color, rgba(0,0,0,0.4));
      opacity: 1;
      z-index: 2;
    }

    .widget-<?php echo $_widget_class; ?> .bento-item.has-bg-image:hover::before,
    .widget-<?php echo $_widget_class; ?> .bento-item.has-bg-color:hover::before {
      transform: scale(1.05);
    }

    .widget-<?php echo $_widget_class; ?> .bento-content {
      position: relative;
      z-index: 3;
      display: flex;
      flex-direction: column;
      gap: var(--space-xs);
      width: 100%;
    }

    @media (min-width: 600px) and (max-width: 989px) {
      .widget-<?php echo $_widget_class; ?> .bento-grid-container {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (min-width: 990px) {
      .widget-<?php echo $_widget_class; ?> .bento-grid-container {
        grid-template-columns: repeat(4, 1fr);
      }
      <?php echo $_grid_spans_css; ?>
    }
  </style>

  <div class="widget-container">
    <?php if ($_header_html): ?>
    <div class="widget-header">
      <?php echo $_header_html; ?>
    </div>
    <?php endif; ?>

    <div class="widget-content">
      <div class="bento-grid-container">
        <?php echo $_items_html; ?>
      </div>
    </div>
  </div>
</section>