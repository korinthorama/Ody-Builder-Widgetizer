<?php
/*
 * Widgetizer — Countdown Timer Widget — template.php
 * Prefix: cd
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
$_eyebrow        = htmlspecialchars($wdg_params['eyebrow']         ?? '');
$_title          = htmlspecialchars($wdg_params['title']           ?? '');
$_description    = htmlspecialchars($wdg_params['description']     ?? '');
$_header_align   = htmlspecialchars($wdg_params['header_align']    ?? 'center');
$_target         = htmlspecialchars($wdg_params['target']          ?? '2030-01-01 00:00');
$_expired_msg    = htmlspecialchars($wdg_params['expired_message'] ?? '');
$_show_seconds   = ($wdg_params['show_seconds'] ?? '1') !== '0';
$_style          = htmlspecialchars($wdg_params['style']           ?? 'cards');
$_countdown_text = htmlspecialchars($wdg_params['countdown_text']  ?? '');
$_btn_label      = htmlspecialchars($wdg_params['btn_label']       ?? '');
$_btn_url        = htmlspecialchars(wdg_parse_links($wdg_params['btn_url'] ?? '#'));
$_btn_new_tab    = ($wdg_params['btn_new_tab'] ?? '0') === '1' ? ' target="_blank" rel="noopener noreferrer"' : ' target="_self"';
$_color          = htmlspecialchars($wdg_params['color_scheme']    ?? 'color-scheme-standard-primary');

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;
$_align_class  = ($_header_align === 'left') ? ' widget-heading-align-left' : '';

$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';

// ── Widget header ─────────────────────────────────────────────────────────────
$_header_html = '';
if ($_eyebrow !== '')    $_header_html .= '<span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0" data-setting="eyebrow">' . $_eyebrow . '</span>' . PHP_EOL;
if ($_title !== '')      $_header_html .= '<h2 class="w-headline reveal reveal-up" style="--reveal-delay: 1" data-setting="title">' . $_title . '</h2>' . PHP_EOL;
if ($_description !== '') $_header_html .= '<p class="w-description reveal reveal-up" style="--reveal-delay: 2" data-setting="description">' . $_description . '</p>' . PHP_EOL;

// ── Countdown units ───────────────────────────────────────────────────────────
$_units = [
    'days'    => 'Μέρες',
    'hours'   => 'Ώρες',
    'minutes' => 'Λεπτά',
];
if ($_show_seconds) $_units['seconds'] = 'Δευτερόλεπτα';

$_units_html = '';
foreach ($_units as $_unit => $_label) {
    $_units_html .= '<div class="countdown-unit">';
    $_units_html .= '<span class="countdown-number" data-unit="' . $_unit . '">00</span>';
    $_units_html .= '<span class="countdown-label w-meta t-sm">' . $_label . '</span>';
    $_units_html .= '</div>';
}

// ── Script ───────────────────────────────────────────────────────────────────
$_script = <<<JSEOF
<script>
document.addEventListener("DOMContentLoaded", function () {
  var widget = document.getElementById("{$_widget_id}");
  if (!widget || widget.dataset.cdInit) return;
  widget.dataset.cdInit = "true";

  var timer = widget.querySelector(".countdown-timer");
  if (!timer) return;

  var targetDate   = new Date(timer.dataset.target).getTime();
  var expiredMsg   = timer.dataset.expiredMessage || "";

  function update() {
    var now      = Date.now();
    var distance = targetDate - now;
    if (distance < 0) {
      timer.innerHTML = '<div class="countdown-expired w-body t-2xl t-accent">' + expiredMsg + '</div>';
      return;
    }
    var days    = Math.floor(distance / 86400000);
    var hours   = Math.floor((distance % 86400000) / 3600000);
    var minutes = Math.floor((distance % 3600000) / 60000);
    var seconds = Math.floor((distance % 60000) / 1000);
    var daysEl    = timer.querySelector('[data-unit="days"]');
    var hoursEl   = timer.querySelector('[data-unit="hours"]');
    var minutesEl = timer.querySelector('[data-unit="minutes"]');
    var secondsEl = timer.querySelector('[data-unit="seconds"]');
    if (daysEl)    daysEl.textContent    = String(days).padStart(2, "0");
    if (hoursEl)   hoursEl.textContent   = String(hours).padStart(2, "0");
    if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, "0");
    if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, "0");
  }

  update();
  setInterval(update, 1000);
});
</script>
JSEOF;

// ── Output ────────────────────────────────────────────────────────────────────
echo $_wdg_asset_html;
?>
<section
  id="<?php echo $_widget_id; ?>"
  class="widget widget-countdown widget-<?php echo $_widget_class; ?> <?php echo $_color . $_align_class; ?>"
  style="<?php echo $_section_style; ?>"
  data-widget-id="<?php echo $_widget_id; ?>"
  data-widget-type="countdown"
>
  <style>
    .widget-<?php echo $_widget_class; ?> .countdown-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .widget-<?php echo $_widget_class; ?> .countdown-unit { min-width: 80px; }

    .widget-<?php echo $_widget_class; ?> .style-cards .countdown-unit {
      background: var(--bg-primary);
      border: var(--border-width-thin) solid var(--border-color);
      border-radius: var(--radius-lg);
      padding: var(--space-lg);
    }

    .widget-<?php echo $_widget_class; ?>.color-scheme-standard-secondary .style-cards .countdown-unit,
    .widget-<?php echo $_widget_class; ?>.color-scheme-highlight-secondary .style-cards .countdown-unit {
      background: var(--bg-secondary);
    }

    .widget-<?php echo $_widget_class; ?> .style-minimal .countdown-number {
      font-size: calc(var(--font-size-5xl) * var(--heading-scale));
    }

    .widget-<?php echo $_widget_class; ?> .style-minimal .countdown-separator { padding-block-start: var(--space-md); }
    .widget-<?php echo $_widget_class; ?> .countdown-text { margin-block-start: var(--space-lg); }
    .widget-<?php echo $_widget_class; ?> .countdown-button { margin-block-start: var(--space-md); }

    .widget-<?php echo $_widget_class; ?>.widget-heading-align-left .countdown-container { align-items: flex-start; text-align: start; }
    .widget-<?php echo $_widget_class; ?>.widget-heading-align-left.style-minimal .countdown-separator { align-self: center; }

    @media (max-width: 749px) {
      .widget-<?php echo $_widget_class; ?> .countdown-unit { min-width: 60px; }
      .widget-<?php echo $_widget_class; ?> .style-cards .countdown-unit { padding: var(--space-md); }
      .widget-<?php echo $_widget_class; ?> .style-minimal .countdown-number { font-size: calc(var(--font-size-3xl) * var(--heading-scale)); }
    }

    @media (max-width: 550px) {
      .widget-<?php echo $_widget_class; ?> .countdown-timer { scale: .7; }
    }
  </style>

  <div class="widget-container">
    <?php if ($_header_html): ?>
    <div class="widget-header">
      <?php echo $_header_html; ?>
    </div>
    <?php endif; ?>

    <div class="widget-content style-<?php echo $_style; ?>">
      <div class="countdown-container">
        <div class="countdown-timer reveal reveal-scale"
             data-target="<?php echo $_target; ?>"
             data-expired-message="<?php echo $_expired_msg; ?>"
             data-show-seconds="<?php echo $_show_seconds ? 'true' : 'false'; ?>"
             data-style="<?php echo $_style; ?>">
          <?php echo $_units_html; ?>
        </div>

        <?php if ($_countdown_text !== ''): ?>
        <div class="countdown-text w-body w-rte t-base reveal reveal-up">
          <p><?php echo $_countdown_text; ?></p>
        </div>
        <?php endif; ?>

        <?php if ($_btn_label !== ''): ?>
        <div class="countdown-button">
          <a href="<?php echo $_btn_url; ?>" class="widget-button" data-setting="button"<?php echo $_btn_new_tab; ?>><?php echo $_btn_label; ?></a>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <?php echo $_script; ?>
</section>
