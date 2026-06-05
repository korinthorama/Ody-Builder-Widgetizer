<?php
/*
 * Widgetizer — Banner Widget — template.php
 * Prefix: bn
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
$_eyebrow        = htmlspecialchars($wdg_params['eyebrow']        ?? '');
$_headline       = htmlspecialchars($wdg_params['headline']       ?? '');
$_body           = $wdg_params['body'] ?? '';
$_btn1_label     = htmlspecialchars($wdg_params['btn1_label']     ?? '');
$_btn1_url       = htmlspecialchars(wdg_parse_links($wdg_params['btn1_url'] ?? '#'));
$_btn1_style     = htmlspecialchars($wdg_params['btn1_style']     ?? 'widget-button-primary');
$_btn1_new_tab   = ($wdg_params['btn1_new_tab'] ?? '0') === '1' ? ' target="_blank" rel="noopener noreferrer"' : '';
$_btn2_label     = htmlspecialchars($wdg_params['btn2_label']     ?? '');
$_btn2_url       = htmlspecialchars(wdg_parse_links($wdg_params['btn2_url'] ?? '#'));
$_btn2_style     = htmlspecialchars($wdg_params['btn2_style']     ?? 'widget-button-secondary');
$_btn2_new_tab   = ($wdg_params['btn2_new_tab'] ?? '0') === '1' ? ' target="_blank" rel="noopener noreferrer"' : '';
$_bg_image       = str_replace(['"', "'"], '', $wdg_params['bg_image'] ?? '');
$_overlay_color  = str_replace('[id]', '#', $wdg_params['overlay_color'] ?? '#000000');
$_overlay_opacity= (float)($wdg_params['overlay_opacity'] ?? '0.4');
$_height         = htmlspecialchars($wdg_params['height']         ?? 'medium');
$_content_align  = htmlspecialchars($wdg_params['content_align']  ?? 'center');
$_content_valign = htmlspecialchars($wdg_params['content_valign'] ?? 'center');
$_color          = htmlspecialchars($wdg_params['color_scheme']   ?? 'color-scheme-highlight-primary');

$_container_width = $wdg_params['container_width'] ?? 'full';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? null;
$_full_width = ($_container_width === 'full');

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;

// ── Helper: hex → rgba ────────────────────────────────────────────────────────
if (!function_exists('_wdg_bn_hex_to_rgba')) {
    function _wdg_bn_hex_to_rgba(string $hex, float $opacity): string {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        return 'rgba(' . hexdec(substr($hex,0,2)) . ',' . hexdec(substr($hex,2,2)) . ',' . hexdec(substr($hex,4,2)) . ',' . $opacity . ')';
    }
}
$_overlay_rgba = _wdg_bn_hex_to_rgba($_overlay_color, $_overlay_opacity);

// ── Classes ───────────────────────────────────────────────────────────────────
$_height_map   = ['auto' => 'widget-height-auto', 'small' => 'widget-height-small', 'medium' => 'widget-height-medium', 'large' => 'widget-height-large'];
$_height_class = $_height_map[$_height] ?? 'widget-height-medium';

$_align_map  = ['start' => 'widget-content-align-start', 'center' => 'widget-content-align-center'];
$_align_class = $_align_map[$_content_align] ?? 'widget-content-align-center';

$_valign_map = ['top' => 'flex-start', 'center' => 'center', 'bottom' => 'flex-end'];
$_valign_css = $_valign_map[$_content_valign] ?? 'center';

$_section_classes = 'widget widget-banner widget-' . $_widget_class . ' ' . $_color . ' ' . $_height_class;
if ($_bg_image)   $_section_classes .= ' has-bg-image has-overlay';
if ($_full_width) $_section_classes .= ' widget-full-width';

// ── Section inline style ──────────────────────────────────────────────────────
$_section_style = '--widget-overlay-color: ' . $_overlay_rgba . '; --widget-overlay-opacity: 1;';
if ($_bg_image) $_section_style = 'background-image: url(\'' . $_bg_image . '\'); ' . $_section_style;
if (!$_full_width && $_max_width) $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';

// ── Content blocks ────────────────────────────────────────────────────────────
$_content_html = '';
if ($_eyebrow !== '') {
    $_content_html .= '<div class="w-body w-rte t-sm reveal reveal-up" style="--reveal-delay: 0" data-setting="text"><p>' . $_eyebrow . '</p></div>' . PHP_EOL;
}
if ($_headline !== '') {
    $_content_html .= '<h1 class="w-headline t-5xl reveal reveal-up" style="--reveal-delay: 1" data-setting="text">' . $_headline . '</h1>' . PHP_EOL;
}
if ($_body !== '') {
    $_content_html .= '<div class="w-body w-rte t-lg reveal reveal-up" style="--reveal-delay: 2" data-setting="text"><p>' . htmlspecialchars($_body) . '</p></div>' . PHP_EOL;
}

// ── Buttons ───────────────────────────────────────────────────────────────────
$_buttons_html = '';
if ($_btn1_label !== '') {
    $_buttons_html .= '<a href="' . $_btn1_url . '" class="widget-button widget-button-medium ' . $_btn1_style . '" data-setting="link"' . $_btn1_new_tab . '>' . $_btn1_label . '</a>' . PHP_EOL;
}
if ($_btn2_label !== '') {
    $_buttons_html .= '<a href="' . $_btn2_url . '" class="widget-button widget-button-medium ' . $_btn2_style . '" data-setting="link_2"' . $_btn2_new_tab . '>' . $_btn2_label . '</a>' . PHP_EOL;
}

// ── Output ────────────────────────────────────────────────────────────────────
echo $_wdg_asset_html;
?>
<section
  id="<?php echo $_widget_id; ?>"
  class="<?php echo $_section_classes; ?>"
  style="<?php echo $_section_style; ?>"
  data-widget-id="<?php echo $_widget_id; ?>"
  data-widget-type="banner"
>
  <style>
    .widget-<?php echo $_widget_class; ?> {
      margin-block: 0;
      padding-inline: var(--space-xl);
      display: flex;
      flex-direction: column;
    }

    .widget-<?php echo $_widget_class; ?> .widget-container {
      display: flex;
      flex-direction: column;
      justify-content: <?php echo $_valign_css; ?>;
      flex: 1;
    }

    .widget-<?php echo $_widget_class; ?> .widget-icon-block-center {
      display: flex;
      justify-content: center;
    }

    @media (max-width: 749px) {
      .widget-<?php echo $_widget_class; ?> {
        padding-inline: var(--space-md);
      }
    }
  </style>

  <div class="widget-container<?php echo $_full_width ? '' : ' widget-container-padded'; ?>">
    <div class="widget-content content-flow widget-content-lg <?php echo $_align_class; ?>">
      <?php echo $_content_html; ?>
      <?php if ($_buttons_html !== ''): ?>
      <div class="widget-actions reveal reveal-up" style="--reveal-delay: 3; gap: var(--space-md)">
        <?php echo $_buttons_html; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
