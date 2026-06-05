<?php
/*
 * Widgetizer — Embed Widget — template.php
 * Prefix: emb
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
if (!function_exists('_wdg_emb_hex_to_rgba')) {
    function _wdg_emb_hex_to_rgba(string $hex, float $opacity): string {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        return 'rgba(' . hexdec(substr($hex,0,2)) . ',' . hexdec(substr($hex,2,2)) . ',' . hexdec(substr($hex,4,2)) . ',' . $opacity . ')';
    }
}

// ── Παράμετροι ────────────────────────────────────────────────────────────────
$_eyebrow        = htmlspecialchars($wdg_params['eyebrow']         ?? '');
$_title          = htmlspecialchars($wdg_params['title']           ?? '');
$_description    = htmlspecialchars($wdg_params['description']     ?? '');
$_header_align   = htmlspecialchars($wdg_params['header_align']    ?? 'start');
$_embed_code     = $wdg_params['embed_code']                       ?? '';
$_bg_image       = str_replace(['"', "'"], '', $wdg_params['bg_image'] ?? '');
$_overlay_color  = $wdg_params['overlay_color']                    ?? '#000000';
$_overlay_opacity= (float)($wdg_params['overlay_opacity']          ?? 0.4);
$_overlay_rgba   = _wdg_emb_hex_to_rgba($_overlay_color, $_overlay_opacity);
$_color          = htmlspecialchars($wdg_params['color_scheme']    ?? 'color-scheme-standard-primary');

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;

$_section_classes = 'widget widget-type-embed widget-' . $_widget_class . ' ' . $_color;
if ($_bg_image) $_section_classes .= ' has-bg-image has-overlay';

$_section_style = 'padding-bottom: 20px; --widget-overlay-color: ' . $_overlay_rgba . '; --widget-overlay-opacity: 1;';
if ($_bg_image) $_section_style = 'background-image: url(\'' . $_bg_image . '\'); ' . $_section_style;
if (!$_full_width && $_max_width) $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';

// ── Widget header ─────────────────────────────────────────────────────────────
$_header_html = '';
if ($_eyebrow !== '')    $_header_html .= '<span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0" data-setting="eyebrow">' . $_eyebrow . '</span>' . PHP_EOL;
if ($_title !== '')      $_header_html .= '<h2 class="w-headline reveal reveal-up" style="--reveal-delay: 1" data-setting="title">' . $_title . '</h2>' . PHP_EOL;
if ($_description !== '') $_header_html .= '<p class="w-description reveal reveal-up" style="--reveal-delay: 2" data-setting="description">' . $_description . '</p>' . PHP_EOL;

// ── Output ────────────────────────────────────────────────────────────────────
echo $_wdg_asset_html;
?>
<section
  id="<?php echo $_widget_id; ?>"
  class="<?php echo $_section_classes; ?>"
  style="<?php echo $_section_style; ?>"
  data-widget-id="<?php echo $_widget_id; ?>"
  data-widget-type="embed"
>
  <style>
    .widget-<?php echo $_widget_class; ?> .embed-container {
      display: flex;
      flex-direction: column;
      gap: var(--space-xl);
      max-width: var(--content-width-md);
      margin-inline: auto;
    }

    .widget-<?php echo $_widget_class; ?> .embed-code-wrapper {
      width: 100%;
    }

    .widget-<?php echo $_widget_class; ?> .embed-code-wrapper iframe {
      max-width: 100%;
    }
  </style>

  <div class="widget-container widget-container-padded">
    <div class="widget-content">
      <?php if ($_header_html): ?>
      <div class="widget-header widget-header--align-<?php echo $_header_align; ?>">
        <?php echo $_header_html; ?>
      </div>
      <?php endif; ?>

      <div class="embed-container">
        <div class="embed-code-wrapper reveal reveal-fade" role="region" aria-label="Embedded content">
          <?php echo $_embed_code; ?>
        </div>
      </div>
    </div>
  </div>
</section>
