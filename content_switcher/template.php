<?php
/*
 * Widgetizer — Content Switcher Widget — template.php
 * Prefix: csw
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
$_eyebrow      = htmlspecialchars($wdg_params['eyebrow']       ?? '');
$_title        = htmlspecialchars($wdg_params['title']         ?? '');
$_description  = htmlspecialchars($wdg_params['description']   ?? '');
$_header_align = htmlspecialchars($wdg_params['header_align']  ?? 'center');
$_cols         = (int)($wdg_params['cols']                     ?? 3);
$_image_ratio  = htmlspecialchars($wdg_params['image_ratio']   ?? '4 / 3');
$_color        = htmlspecialchars($wdg_params['color_scheme']  ?? 'color-scheme-standard-primary');
$_tabs         = $wdg_params['tabs'] ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;
$_align_class  = ($_header_align === 'left') ? ' widget-heading-align-left' : '';

$_section_style = 'padding-bottom: 20px; --card-image-ratio: ' . $_image_ratio . ';';
if (!$_full_width && $_max_width) $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';

// ── Widget header ─────────────────────────────────────────────────────────────
$_header_html = '';
if ($_eyebrow !== '')    $_header_html .= '<span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0" data-setting="eyebrow">' . $_eyebrow . '</span>' . PHP_EOL;
if ($_title !== '')      $_header_html .= '<h2 class="w-headline reveal reveal-up" style="--reveal-delay: 1" data-setting="title">' . $_title . '</h2>' . PHP_EOL;
if ($_description !== '') $_header_html .= '<p class="w-description reveal reveal-up" style="--reveal-delay: 2" data-setting="description">' . $_description . '</p>' . PHP_EOL;

// ── Toggle buttons ────────────────────────────────────────────────────────────
$_toggle_html = '';
foreach ($_tabs as $_ti => $_tab) {
    $_tab_label = htmlspecialchars($_tab['label'] ?? ('Tab ' . ($_ti + 1)));
    $_tab_num   = $_ti + 1;
    $_tab_id    = 'switcher-tab-' . $_widget_id . '-' . $_tab_num;
    $_panel_id  = 'switcher-panel-' . $_widget_id . '-' . $_tab_num;
    $_is_active = $_ti === 0;
    $_toggle_html .= '<button type="button" id="' . $_tab_id . '" class="switcher-btn' . ($_is_active ? ' is-active' : '') . '" data-target="' . $_tab_num . '" role="tab" aria-selected="' . ($_is_active ? 'true' : 'false') . '" aria-controls="' . $_panel_id . '" tabindex="' . ($_is_active ? '0' : '-1') . '">' . $_tab_label . '</button>';
}

// ── Panels ────────────────────────────────────────────────────────────────────
$_panels_html = '';
foreach ($_tabs as $_ti => $_tab) {
    $_tab_num   = $_ti + 1;
    $_tab_id    = 'switcher-tab-' . $_widget_id . '-' . $_tab_num;
    $_panel_id  = 'switcher-panel-' . $_widget_id . '-' . $_tab_num;
    $_is_active = $_ti === 0;
    $_cards     = $_tab['cards'] ?? [];

    $_panels_html .= '<div id="' . $_panel_id . '" class="switcher-content-group' . ($_is_active ? ' is-active' : '') . '" data-option="' . $_tab_num . '" role="tabpanel" aria-labelledby="' . $_tab_id . '" aria-hidden="' . ($_is_active ? 'false' : 'true') . '">';
    $_panels_html .= '<ul class="widget-card-grid widget-grid" style="--grid-cols-desktop: ' . $_cols . '">';

    foreach ($_cards as $_ci => $_card) {
        $_card_title  = htmlspecialchars($_card['title']     ?? '');
        $_card_price  = htmlspecialchars($_card['price']     ?? '');
        $_card_text   = htmlspecialchars($_card['text']      ?? '');
        $_card_image  = str_replace(['"', "'"], '', $_card['image'] ?? '');
        $_btn_label   = htmlspecialchars($_card['btn_label'] ?? '');
        $_btn_url     = htmlspecialchars(wdg_parse_links($_card['btn_url'] ?? '#'));
        $_btn_new_tab = ($_card['btn_new_tab'] ?? '0') === '1' ? ' target="_blank" rel="noopener noreferrer"' : ' target="_self"';
        $_btn_style   = htmlspecialchars($_card['btn_style'] ?? 'widget-button-secondary');
        $_block_id    = $_widget_id . '_tab' . $_ti . '_card' . $_ci;

        $_panels_html .= '<li class="widget-card" data-block-id="' . $_block_id . '">';
        if ($_card_image) $_panels_html .= '<img src="' . $_card_image . '" alt="" class="widget-card-image" loading="lazy">';
        $_panels_html .= '<div class="widget-card-content">';
        if ($_card_title) $_panels_html .= '<h2 class="w-title t-xl" data-setting="title">' . $_card_title . '</h2>';
        if ($_card_price) $_panels_html .= '<div class="switcher-item-price" data-setting="price">' . $_card_price . '</div>';
        if ($_card_text)  $_panels_html .= '<div class="w-body w-rte t-sm" data-setting="text"><p>' . $_card_text . '</p></div>';
        $_panels_html .= '</div>';
        if ($_btn_label) {
            $_panels_html .= '<div class="widget-card-footer"><a href="' . $_btn_url . '" class="widget-button ' . $_btn_style . '"' . $_btn_new_tab . '>' . $_btn_label . '</a></div>';
        }
        $_panels_html .= '</li>';
    }

    $_panels_html .= '</ul></div>';
}

// ── Script ───────────────────────────────────────────────────────────────────
$_script = <<<JSEOF
<script>
document.addEventListener("DOMContentLoaded", function () {
  var widget = document.getElementById("{$_widget_id}");
  if (!widget || widget.dataset.cswInit) return;
  widget.dataset.cswInit = "true";

  var buttons = Array.from(widget.querySelectorAll(".switcher-btn"));
  var groups  = widget.querySelectorAll(".switcher-content-group");

  var activateTab = function (button) {
    var target = button.getAttribute("data-target");
    buttons.forEach(function (b) {
      b.classList.remove("is-active");
      b.setAttribute("aria-selected", "false");
      b.setAttribute("tabindex", "-1");
    });
    button.classList.add("is-active");
    button.setAttribute("aria-selected", "true");
    button.setAttribute("tabindex", "0");
    groups.forEach(function (group) {
      var isActive = group.getAttribute("data-option") === target;
      group.classList.toggle("is-active", isActive);
      group.setAttribute("aria-hidden", isActive ? "false" : "true");
    });
  };

  buttons.forEach(function (btn) {
    btn.addEventListener("click", function () { activateTab(this); });
    btn.addEventListener("keydown", function (event) {
      var currentIndex = buttons.indexOf(btn);
      var nextIndex = null;
      switch (event.key) {
        case "ArrowRight": nextIndex = (currentIndex + 1) % buttons.length; break;
        case "ArrowLeft":  nextIndex = (currentIndex - 1 + buttons.length) % buttons.length; break;
        case "Home": nextIndex = 0; break;
        case "End":  nextIndex = buttons.length - 1; break;
        default: return;
      }
      event.preventDefault();
      var nextButton = buttons[nextIndex];
      nextButton.focus();
      activateTab(nextButton);
    });
  });
});
</script>
JSEOF;

// ── Output ────────────────────────────────────────────────────────────────────
echo $_wdg_asset_html;
?>
<section
  id="<?php echo $_widget_id; ?>"
  class="widget widget-content-switcher widget-<?php echo $_widget_class; ?> <?php echo $_color . $_align_class; ?>"
  style="<?php echo $_section_style; ?>"
  data-widget-id="<?php echo $_widget_id; ?>"
  data-widget-type="content-switcher"
>
  <style>
    .widget-<?php echo $_widget_class; ?> .switcher-ui-wrapper {
      display: flex;
      justify-content: center;
      margin-block-end: var(--space-2xl);
    }

    .widget-<?php echo $_widget_class; ?> .switcher-toggle {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: var(--space-md);
      padding: 0;
    }

    .widget-<?php echo $_widget_class; ?> .switcher-btn {
      padding: var(--space-sm) var(--space-lg);
      font-family: inherit;
      font-size: calc(var(--font-size-sm) * var(--body-scale));
      line-height: var(--line-height-relaxed);
      margin: 0;
      color: var(--text-content);
      background-color: var(--bg-primary);
      border: var(--border-width-thin) solid var(--border-color);
      border-radius: var(--radius-button);
      cursor: pointer;
      transition: background-color 0.3s, color 0.3s, border-color 0.3s;
    }

    .widget-<?php echo $_widget_class; ?> .switcher-btn.is-active,
    .widget-<?php echo $_widget_class; ?> .switcher-btn:hover {
      background-color: var(--text-heading);
      color: var(--bg-primary);
      border-color: var(--text-heading);
    }

    .widget-<?php echo $_widget_class; ?> .switcher-btn:focus { outline: var(--border-width-medium) solid var(--border-color); outline-offset: 2px; }

    .widget-<?php echo $_widget_class; ?> .switcher-content-group { display: none; animation: switcherFadeIn-<?php echo $blockID; ?> 0.3s ease-out; }
    .widget-<?php echo $_widget_class; ?> .switcher-content-group.is-active { display: block; }

    .widget-<?php echo $_widget_class; ?>.widget-heading-align-left .switcher-ui-wrapper { justify-content: flex-start; }
    .widget-<?php echo $_widget_class; ?>.widget-heading-align-left .switcher-toggle { justify-content: flex-start; }

    .widget-<?php echo $_widget_class; ?> .widget-card { text-align: center; align-items: center; }

    .widget-<?php echo $_widget_class; ?>.color-scheme-standard-secondary .widget-card,
    .widget-<?php echo $_widget_class; ?>.color-scheme-highlight-secondary .widget-card { background-color: var(--bg-secondary); }

    .widget-<?php echo $_widget_class; ?>.color-scheme-standard-secondary .widget-card,
    .widget-<?php echo $_widget_class; ?>.color-scheme-highlight-primary .widget-card,
    .widget-<?php echo $_widget_class; ?>.color-scheme-highlight-secondary .widget-card { border: var(--border-width-thin) solid var(--border-color); }

    .widget-<?php echo $_widget_class; ?> .switcher-item-price {
      font-size: calc(var(--font-size-5xl) * var(--heading-scale));
      font-weight: var(--font-weight-bold);
      line-height: var(--line-height-tight);
      color: var(--text-heading);
      margin: 0;
      margin-block-start: var(--space-sm);
    }

    @keyframes switcherFadeIn-<?php echo $blockID; ?> {
      from { opacity: 0; transform: translateY(10px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>

  <div class="widget-container">
    <?php if ($_header_html): ?>
    <div class="widget-header">
      <?php echo $_header_html; ?>
    </div>
    <?php endif; ?>

    <div class="widget-content">
      <div class="switcher-ui-wrapper reveal reveal-up">
        <div class="switcher-toggle" role="tablist" aria-label="<?php echo $_title; ?>">
          <?php echo $_toggle_html; ?>
        </div>
      </div>
      <div class="switcher-content-reveal">
        <?php echo $_panels_html; ?>
      </div>
    </div>
  </div>

  <?php echo $_script; ?>
</section>
