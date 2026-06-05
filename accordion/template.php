<?php
/*
 * Widgetizer — Accordion Widget — template.php
 * Prefix: acc
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
$_multi_open  = ($wdg_params['multi_open'] ?? '0') === '1' ? 'true' : 'false';
$_color       = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');
$_items       = $wdg_params['items'] ?? [];

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;

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

// ── Accordion items ───────────────────────────────────────────────────────────
$_items_html = '';
foreach ($_items as $_i => $_item) {
    $_q       = htmlspecialchars($_item['question'] ?? '');
    $_a       = htmlspecialchars($_item['answer']   ?? '');
    $_trig_id = 'accordion-trigger-' . $_widget_id . '-' . $_i;
    $_cont_id = 'accordion-content-' . $_widget_id . '-' . $_i;

    $_items_html .= '
          <li class="accordion-item reveal reveal-up" style="--reveal-delay: ' . $_i . '" data-block-id="' . $_widget_id . '_item_' . $_i . '">
            <button type="button" class="accordion-trigger" aria-expanded="false"
                    aria-controls="' . $_cont_id . '" id="' . $_trig_id . '">
              <span class="accordion-question w-title t-xl t-heading-font" data-setting="question">' . $_q . '</span>
              <span class="accordion-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M6 9l6 6 6-6"/>
                </svg>
              </span>
            </button>
            <div class="accordion-collapse" id="' . $_cont_id . '" role="region"
                 aria-labelledby="' . $_trig_id . '" aria-hidden="true">
              <div class="accordion-inner">
                <div class="accordion-answer w-body w-rte" data-setting="answer"><p>' . $_a . '</p></div>
              </div>
            </div>
          </li>';
}

// ── Script ───────────────────────────────────────────────────────────────────
$_script = <<<JSEOF
<script>
document.addEventListener("DOMContentLoaded", function () {
  var widget = document.getElementById("{$_widget_id}");
  if (!widget || widget.dataset.accInit) return;
  widget.dataset.accInit = "true";

  var isMultiOpen = widget.dataset.multiOpen === "true";
  var triggers = widget.querySelectorAll(".accordion-trigger");

  triggers.forEach(function (trigger) {
    trigger.addEventListener("click", function () {
      var isExpanded = this.getAttribute("aria-expanded") === "true";
      var collapse = this.nextElementSibling;

      if (!isMultiOpen) {
        widget.querySelectorAll(".accordion-trigger").forEach(function (t) {
          if (t !== trigger) {
            t.setAttribute("aria-expanded", "false");
            t.nextElementSibling.setAttribute("aria-hidden", "true");
          }
        });
      }

      this.setAttribute("aria-expanded", String(!isExpanded));
      collapse.setAttribute("aria-hidden", String(isExpanded));
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
  class="widget widget-accordion widget-<?php echo $_widget_class; ?> <?php echo $_color; ?>"
  style="padding-bottom: 20px;"
  data-widget-id="<?php echo $_widget_id; ?>"
  data-widget-type="accordion"
  data-multi-open="<?php echo $_multi_open; ?>"
>
  <style>
    .widget-<?php echo $_widget_class; ?> .accordion-content-wrapper {
      display: grid;
      grid-template-columns: 1fr;
      gap: 20px;
    }

    .widget-<?php echo $_widget_class; ?> .accordion-list {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .widget-<?php echo $_widget_class; ?> .accordion-item {
      background-color: var(--bg-primary);
      border: var(--border-width-thin) solid var(--border-color);
      border-radius: var(--radius-sm);
      overflow: hidden;
    }

    .widget-<?php echo $_widget_class; ?>.color-scheme-standard-secondary .accordion-item,
    .widget-<?php echo $_widget_class; ?>.color-scheme-highlight-secondary .accordion-item {
      background-color: var(--bg-secondary);
    }

    .widget-<?php echo $_widget_class; ?> .accordion-trigger {
      width: 100%;
      padding: 16px 20px;
      text-align: start;
      background: transparent;
      border: none;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 16px;
      color: var(--text-heading);
      transition: background-color 0.2s;
      font-family: inherit;
    }

    .widget-<?php echo $_widget_class; ?> .accordion-trigger:focus-visible {
      outline-offset: -2px;
    }

    .widget-<?php echo $_widget_class; ?> .accordion-question {
      flex: 1;
      text-align: start;
    }

    .widget-<?php echo $_widget_class; ?> .accordion-icon {
      width: 24px;
      height: 24px;
      flex-shrink: 0;
      transition: transform 0.3s ease;
    }

    .widget-<?php echo $_widget_class; ?> .accordion-icon svg {
      width: 100%;
      height: 100%;
    }

    .widget-<?php echo $_widget_class; ?> .accordion-trigger[aria-expanded="true"] .accordion-icon {
      transform: rotate(180deg);
    }

    .widget-<?php echo $_widget_class; ?> .accordion-collapse {
      display: grid;
      grid-template-rows: 0fr;
      transition: grid-template-rows 0.3s ease-out;
    }

    .widget-<?php echo $_widget_class; ?> .accordion-collapse[aria-hidden="false"] {
      grid-template-rows: 1fr;
    }

    .widget-<?php echo $_widget_class; ?> .accordion-inner {
      min-height: 0;
      overflow: hidden;
    }

    .widget-<?php echo $_widget_class; ?> .accordion-answer {
      padding: 0 20px 20px 20px;
      font-size: calc(var(--font-size-base) * var(--body-scale));
      opacity: 0;
      transform: translateY(-8px);
      transition: opacity 0.25s ease-out, transform 0.25s ease-out;
    }

    .widget-<?php echo $_widget_class; ?> .accordion-collapse[aria-hidden="false"] .accordion-answer {
      opacity: 1;
      transform: translateY(0);
    }

    .widget-<?php echo $_widget_class; ?>.accordion-bordered .accordion-list {
      gap: 0;
      border: var(--border-width-thin) solid var(--border-color);
      border-radius: var(--radius-sm);
      overflow: hidden;
    }

    .widget-<?php echo $_widget_class; ?>.accordion-bordered .accordion-item {
      border: none;
      border-radius: 0;
      border-bottom: var(--border-width-thin) solid var(--border-color);
    }

    .widget-<?php echo $_widget_class; ?>.accordion-bordered .accordion-item:last-child {
      border-bottom: none;
    }

    @media (min-width: 750px) {
      .widget-<?php echo $_widget_class; ?> .accordion-trigger { padding: 20px; }
      .widget-<?php echo $_widget_class; ?> .accordion-content-wrapper:not(.no-sidebar) { grid-template-columns: 7fr 3fr; gap: 60px; }
      .widget-<?php echo $_widget_class; ?>.layout-reverse .accordion-content-wrapper:not(.no-sidebar) { grid-template-columns: 3fr 7fr; }
      .widget-<?php echo $_widget_class; ?>.layout-reverse .accordion-list-wrapper { order: 2; }
      .widget-<?php echo $_widget_class; ?>.layout-reverse .accordion-info { order: 1; }
    }
  </style>

  <div class="widget-container">
    <?php if ($_header_html): ?>
    <div class="widget-header">
      <?php echo $_header_html; ?>
    </div>
    <?php endif; ?>

    <div class="widget-content widget-content-md">
      <div class="accordion-content-wrapper no-sidebar">
        <div class="accordion-list-wrapper">
          <ul class="accordion-list">
            <?php echo $_items_html; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <?php echo $_script; ?>
</section>
