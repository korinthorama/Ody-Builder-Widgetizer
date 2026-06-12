<?php
/*
 * Widgetizer — Action Bar Widget — template.php
 * Prefix: ab
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
$_headline     = htmlspecialchars($wdg_params['headline']    ?? '');
$_body         = $wdg_params['body'] ?? '';
$_btn1_label   = htmlspecialchars($wdg_params['btn1_label'] ?? '');
$_btn1_url     = htmlspecialchars(wdg_parse_links($wdg_params['btn1_url'] ?? '#'));
$_btn1_style   = htmlspecialchars($wdg_params['btn1_style'] ?? 'widget-button-primary');
$_btn1_new_tab = ($wdg_params['btn1_new_tab'] ?? '0') === '1' ? ' target="_blank" rel="noopener noreferrer"' : '';
$_btn2_label   = htmlspecialchars($wdg_params['btn2_label'] ?? '');
$_btn2_url     = htmlspecialchars(wdg_parse_links($wdg_params['btn2_url'] ?? '#'));
$_btn2_style   = htmlspecialchars($wdg_params['btn2_style'] ?? 'widget-button-secondary');
$_btn2_new_tab = ($wdg_params['btn2_new_tab'] ?? '0') === '1' ? ' target="_blank" rel="noopener noreferrer"' : '';
$_color        = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-highlight-primary');

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

// ── Background image & overlay ────────────────────────────────────────────────
$_bg_image       = $wdg_params['bg_image'] ?? '';
$_overlay_color  = $wdg_params['overlay_color'] ?? '';
$_overlay_opacity = $wdg_params['overlay_opacity'] ?? '0.4';

// Επεξεργασία overlay color (αντίστροφη διαδικασία από [id] → #)
if ($_overlay_color && strpos($_overlay_color, '[id]') !== false) {
    $_overlay_color = str_replace('[id]', '#', $_overlay_color);
}

// Υπολογισμός overlay value με opacity (μορφή rgba)
$_overlay_rgba = '';
if ($_overlay_color && preg_match('/^#([A-Fa-f0-9]{6})$/', $_overlay_color, $matches)) {
    $r = hexdec(substr($matches[1], 0, 2));
    $g = hexdec(substr($matches[1], 2, 2));
    $b = hexdec(substr($matches[1], 4, 2));
    $_overlay_rgba = "rgba($r, $g, $b, " . floatval($_overlay_opacity) . ")";
}

// CSS classes και inline styles για background image
$_has_bg_image = !empty($_bg_image);
$_has_overlay  = ($_overlay_color && $_overlay_opacity > 0);
$_extra_classes = '';
$_inline_style = '';

if ($_has_bg_image) {
    $_extra_classes .= ' has-bg-image';
    $_inline_style .= ' background-image: url(\'' . htmlspecialchars($_bg_image) . '\');';
}

if ($_has_overlay) {
    $_extra_classes .= ' has-overlay';
    $_inline_style .= ' --widget-overlay-color: ' . $_overlay_rgba . ';';
    $_inline_style .= ' --widget-overlay-opacity: ' . floatval($_overlay_opacity) . ';';
}

$_container_style = '';
if (!$_full_width) {
    $_container_style = ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

// ── Buttons HTML ──────────────────────────────────────────────────────────────
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
  class="widget widget-action-bar widget-<?php echo $_widget_class; ?> <?php echo $_color; ?><?php echo $_extra_classes; ?>"
  style="<?php echo $_inline_style; ?>"
  data-widget-id="<?php echo $_widget_id; ?>"
  data-widget-type="action-bar"
>
  <style>
    .widget-<?php echo $_widget_class; ?> .action-bar-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: var(--space-xl);
    }

    .widget-<?php echo $_widget_class; ?> .action-bar-content {
      display: flex;
      flex-direction: column;
      gap: var(--space-2xs);
      flex: 1;
      min-width: 0;
    }

    .widget-<?php echo $_widget_class; ?> .action-bar-actions {
      display: flex;
      flex-shrink: 0;
    }
    
    /* Background image & overlay styling */
    .widget-<?php echo $_widget_class; ?>.has-bg-image {
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      position: relative;
    }
    
    .widget-<?php echo $_widget_class; ?>.has-overlay::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: var(--widget-overlay-color, rgba(0,0,0,0.4));
      pointer-events: none;
      z-index: 0;
    }
    
    .widget-<?php echo $_widget_class; ?>.has-overlay .widget-container {
      position: relative;
      z-index: 1;
    }

    @media (max-width: 749px) {
      .widget-<?php echo $_widget_class; ?> .action-bar-inner {
        flex-direction: column;
        text-align: center;
      }

      .widget-<?php echo $_widget_class; ?> .action-bar-actions {
        justify-content: center;
      }
    }
  </style>

  <div class="widget-container widget-container-padded" style="<?php echo $_container_style; ?>">
    <div class="action-bar-inner">
      <div class="action-bar-content">
        <?php if ($_headline !== ''): ?>
        <h2 class="w-headline t-2xl" data-setting="text"><?php echo $_headline; ?></h2>
        <?php endif; ?>
        <?php if ($_body !== ''): ?>
        <div class="w-body w-rte t-base t-muted" data-setting="text"><p><?php echo nl2br(htmlspecialchars($_body)); ?></p></div>
        <?php endif; ?>
      </div>
      <?php if ($_buttons_html !== ''): ?>
      <div class="widget-actions action-bar-actions" style="gap: var(--space-md)">
        <?php echo $_buttons_html; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>