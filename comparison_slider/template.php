<?php
/*
 * Widgetizer — Comparison Slider Widget — template.php
 * Prefix: csl
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
$_eyebrow      = htmlspecialchars($wdg_params['eyebrow']      ?? '');
$_title        = htmlspecialchars($wdg_params['title']        ?? '');
$_subheading   = htmlspecialchars($wdg_params['subheading']   ?? '');
$_header_align = htmlspecialchars($wdg_params['header_align'] ?? 'start');
$_before_image = str_replace(['"', "'"], '', $wdg_params['before_image'] ?? '');
$_before_label = htmlspecialchars($wdg_params['before_label'] ?? 'Before');
$_after_image  = str_replace(['"', "'"], '', $wdg_params['after_image']  ?? '');
$_after_label  = htmlspecialchars($wdg_params['after_label']  ?? 'After');
$_orientation  = htmlspecialchars($wdg_params['orientation']  ?? 'horizontal');
$_aspect_ratio = htmlspecialchars($wdg_params['aspect_ratio'] ?? '16-9');
$_color        = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px', 'tn' => '450px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_ratio_map = ['16-9' => '16 / 9', '4-3' => '4 / 3', '1-1' => '1 / 1', '3-2' => '3 / 2', '21-9' => '21 / 9'];
$_aspect_ratio_css = $_ratio_map[$_aspect_ratio] ?? '16 / 9';

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;
$_variant_class = ($_orientation === 'vertical') ? ' variant-vertical' : '';

$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';

// ── Widget header ─────────────────────────────────────────────────────────────
$_header_html = '';
if ($_eyebrow !== '')    $_header_html .= '<span class="w-eyebrow" data-setting="eyebrow">' . $_eyebrow . '</span>' . PHP_EOL;
if ($_title !== '')      $_header_html .= '<h2 class="w-headline" data-setting="title">' . $_title . '</h2>' . PHP_EOL;
if ($_subheading !== '') $_header_html .= '<p class="w-description" data-setting="description">' . $_subheading . '</p>' . PHP_EOL;

// ── Script ───────────────────────────────────────────────────────────────────
$_script = <<<JSEOF
<script>
document.addEventListener("DOMContentLoaded", function () {
  var widget = document.getElementById("{$_widget_id}");
  if (!widget || widget.dataset.cslInit) return;
  widget.dataset.cslInit = "true";

  var wrapper    = widget.querySelector(".comparison-slider-wrapper");
  var afterImage = widget.querySelector(".comparison-slider-after");
  var divider    = widget.querySelector(".comparison-slider-divider");
  var handle     = widget.querySelector(".comparison-slider-handle");
  var isVertical = widget.classList.contains("variant-vertical");

  if (!wrapper || !afterImage || !divider || !handle) return;

  var isDragging = false;
  var position   = 50;

  var updatePosition = function (newPosition) {
    position = Math.max(0, Math.min(100, newPosition));
    if (isVertical) {
      afterImage.style.clipPath     = "inset(" + position + "% 0 0 0)";
      divider.style.insetBlockStart = position + "%";
      handle.style.insetBlockStart  = position + "%";
    } else {
      afterImage.style.clipPath       = "inset(0 0 0 " + position + "%)";
      divider.style.insetInlineStart  = position + "%";
      handle.style.insetInlineStart   = position + "%";
    }
    handle.setAttribute("aria-valuenow",   Math.round(position));
    handle.setAttribute("aria-valuetext",  Math.round(position) + "% of after image visible");
  };

  var getPositionFromEvent = function (event) {
    var rect = wrapper.getBoundingClientRect();
    var clientPos;
    if (event.type.indexOf("touch") === 0) {
      clientPos = isVertical ? event.touches[0].clientY : event.touches[0].clientX;
    } else {
      clientPos = isVertical ? event.clientY : event.clientX;
    }
    var rectStart = isVertical ? rect.top    : rect.left;
    var rectSize  = isVertical ? rect.height : rect.width;
    return ((clientPos - rectStart) / rectSize) * 100;
  };

  var handleMove = function (event) {
    if (!isDragging) return;
    event.preventDefault();
    updatePosition(getPositionFromEvent(event));
  };

  var startDrag = function (event) {
    isDragging = true;
    handle.focus();
    updatePosition(getPositionFromEvent(event));
  };

  var stopDrag = function () { isDragging = false; };

  wrapper.addEventListener("mousedown",  startDrag);
  document.addEventListener("mousemove", handleMove);
  document.addEventListener("mouseup",   stopDrag);
  wrapper.addEventListener("touchstart", startDrag, { passive: false });
  document.addEventListener("touchmove", handleMove, { passive: false });
  document.addEventListener("touchend",  stopDrag);

  handle.addEventListener("keydown", function (event) {
    var delta = 0;
    switch (event.key) {
      case "ArrowRight": case "ArrowDown": delta =  5; break;
      case "ArrowLeft":  case "ArrowUp":   delta = -5; break;
      case "PageDown": delta = -10; break;
      case "PageUp":   delta =  10; break;
      case "Home": updatePosition(0);   event.preventDefault(); return;
      case "End":  updatePosition(100); event.preventDefault(); return;
      default: return;
    }
    event.preventDefault();
    updatePosition(position + delta);
  });

  updatePosition(position);
});
</script>
JSEOF;

// ── Output ────────────────────────────────────────────────────────────────────
echo $_wdg_asset_html;
?>
<section
  id="<?php echo $_widget_id; ?>"
  class="widget widget-comparison-slider widget-<?php echo $_widget_class; ?> <?php echo $_color . $_variant_class; ?>"
  style="<?php echo $_section_style; ?>"
  data-widget-id="<?php echo $_widget_id; ?>"
  data-widget-type="comparison-slider"
>
  <style>
    .widget-<?php echo $_widget_class; ?> .comparison-slider-wrapper {
      position: relative;
      overflow: hidden;
      aspect-ratio: <?php echo $_aspect_ratio_css; ?>;
      user-select: none;
      border: var(--border-width-thin) solid var(--border-color);
      border-radius: var(--radius-md);
    }

    .widget-<?php echo $_widget_class; ?> .comparison-slider-image {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      pointer-events: none;
    }

    .widget-<?php echo $_widget_class; ?> .comparison-slider-before { z-index: 1; }

    .widget-<?php echo $_widget_class; ?> .comparison-slider-after {
      z-index: 2;
      clip-path: inset(0 0 0 50%);
    }

    .widget-<?php echo $_widget_class; ?> .comparison-slider-divider {
      position: absolute;
      inset-block-start: 0;
      inset-block-end: 0;
      inset-inline-start: 50%;
      width: 3px;
      background-color: var(--bg-primary);
      z-index: 3;
      transform: translateX(-50%);
      cursor: ew-resize;
    }

    .widget-<?php echo $_widget_class; ?> .comparison-slider-handle {
      position: absolute;
      inset-block-start: 50%;
      inset-inline-start: 50%;
      width: 48px;
      height: 48px;
      background-color: var(--bg-primary);
      border: 3px solid var(--bg-primary);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: ew-resize;
      z-index: 4;
      transform: translate(-50%, -50%);
      transition: opacity 0.2s;
    }

    .widget-<?php echo $_widget_class; ?> .comparison-slider-handle:hover  { opacity: 0.9; }
    .widget-<?php echo $_widget_class; ?> .comparison-slider-handle:focus   { outline: var(--border-width-medium) solid var(--text-heading); outline-offset: 3px; }
    .widget-<?php echo $_widget_class; ?> .comparison-slider-handle:active  { opacity: 0.8; }

    .widget-<?php echo $_widget_class; ?> .comparison-slider-handle-icon {
      width: 24px;
      height: 24px;
      color: var(--text-heading);
    }

    .widget-<?php echo $_widget_class; ?> .comparison-slider-label {
      position: absolute;
      padding: var(--space-sm) var(--space-md);
      background-color: var(--bg-primary);
      border: var(--border-width-thin) solid var(--border-color);
      z-index: 5;
      pointer-events: none;
    }

    .widget-<?php echo $_widget_class; ?> .comparison-slider-label-before {
      inset-block-start: var(--space-md);
      inset-inline-start: var(--space-md);
    }

    .widget-<?php echo $_widget_class; ?> .comparison-slider-label-after {
      inset-block-start: var(--space-md);
      inset-inline-end: var(--space-md);
    }

    /* Vertical */
    .widget-<?php echo $_widget_class; ?>.variant-vertical .comparison-slider-after { clip-path: inset(50% 0 0 0); }
    .widget-<?php echo $_widget_class; ?>.variant-vertical .comparison-slider-divider {
      inset-inline-start: 0;
      inset-inline-end: 0;
      inset-block-start: 50%;
      width: auto;
      height: 3px;
      transform: translateY(-50%);
      cursor: ns-resize;
    }
    .widget-<?php echo $_widget_class; ?>.variant-vertical .comparison-slider-handle { cursor: ns-resize; }
    .widget-<?php echo $_widget_class; ?>.variant-vertical .comparison-slider-label-before {
      inset-block-start: auto;
      inset-block-end: var(--space-md);
      inset-inline-start: var(--space-md);
    }

    @media (min-width: 750px) {
      .widget-<?php echo $_widget_class; ?> .comparison-slider-handle { width: 56px; height: 56px; }
      .widget-<?php echo $_widget_class; ?> .comparison-slider-handle-icon { width: 26px; height: 26px; }
      .widget-<?php echo $_widget_class; ?> .comparison-slider-label { padding: var(--space-sm) var(--space-lg); }
      .widget-<?php echo $_widget_class; ?> .comparison-slider-label-before { inset-block-start: var(--space-lg); inset-inline-start: var(--space-lg); }
      .widget-<?php echo $_widget_class; ?> .comparison-slider-label-after  { inset-block-start: var(--space-lg); inset-inline-end: var(--space-lg); }
      .widget-<?php echo $_widget_class; ?>.variant-vertical .comparison-slider-label-before { inset-block-end: var(--space-lg); inset-inline-start: var(--space-lg); }
      .widget-<?php echo $_widget_class; ?>.variant-vertical .comparison-slider-label-after  { inset-block-start: var(--space-lg); inset-inline-end: var(--space-lg); }
    }

    @media (min-width: 990px) {
      .widget-<?php echo $_widget_class; ?> .comparison-slider-handle { width: 64px; height: 64px; }
      .widget-<?php echo $_widget_class; ?> .comparison-slider-handle-icon { width: 28px; height: 28px; }
    }
  </style>

  <div class="widget-container">
    <div class="widget-content widget-content-lg">
      <?php if ($_header_html): ?>
      <div class="widget-header widget-header--align-<?php echo $_header_align; ?>">
        <?php echo $_header_html; ?>
      </div>
      <?php endif; ?>

      <div class="comparison-slider-wrapper">
        <img src="<?php echo $_before_image; ?>" alt="" class="comparison-slider-image comparison-slider-before" loading="eager">
        <img src="<?php echo $_after_image; ?>"  alt="" class="comparison-slider-image comparison-slider-after"  loading="eager">

        <div class="comparison-slider-label comparison-slider-label-before w-label t-sm t-heading"><?php echo $_before_label; ?></div>
        <div class="comparison-slider-label comparison-slider-label-after w-label t-sm t-heading"><?php echo $_after_label; ?></div>

        <div class="comparison-slider-divider"></div>

        <button class="comparison-slider-handle" type="button"
                aria-label="Drag to compare before and after images"
                role="slider" aria-valuemin="0" aria-valuemax="100"
                aria-valuenow="50" aria-valuetext="50% of after image visible"
                tabindex="0">
          <svg class="comparison-slider-handle-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M9 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
            <path d="M9 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
            <path d="M9 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
            <path d="M15 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
            <path d="M15 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
            <path d="M15 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
          </svg>
        </button>
      </div>
    </div>
  </div>

  <?php echo $_script; ?>
</section>
