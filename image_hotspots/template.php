<?php
/*
 * Widgetizer — Image Hotspots Widget — template.php
 * Prefix: imhs
 *
 * Χτίζει το output ως PHP string — χωρίς DOMDocument manipulation.
 * Διατηρεί rem values στο CSS (δεν χρειάζεται conversion).
 */
// ── Assets ────────────────────────────────────────────────────────────────────
$_wdg_assets = 'admin/builder_widget_assets/';
$_wdg_css = $_wdg_assets . 'base.css';
$_wdg_js = $_wdg_assets . 'scripts.js';
$_wdg_asset_html = '';
if(!in_array($_wdg_css, $document->loadedFiles)) {
    $_wdg_asset_html .= '<link href="' . $_wdg_css . '" rel="stylesheet" type="text/css">' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_css;
}
if(!in_array($_wdg_js, $document->loadedFiles)) {
    $_wdg_asset_html .= '<script src="' . $_wdg_js . '"></script>' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_js;
}
// ── Παράμετροι ────────────────────────────────────────────────────────────────
$_eyebrow = htmlspecialchars($wdg_params['eyebrow'] ?? '');
$_title = htmlspecialchars($wdg_params['title'] ?? '');
$_description = htmlspecialchars($wdg_params['description'] ?? '');
$_image = htmlspecialchars($wdg_params['image'] ?? '');
$_hotspot_cs = htmlspecialchars($wdg_params['hotspot_color_scheme'] ?? 'color-scheme-standard-primary');
$_color = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-secondary');
$_hotspots_raw = $wdg_params['hotspots'] ?? '[]';
$_hotspots = json_decode($_hotspots_raw, true);
if(!is_array($_hotspots)) $_hotspots = [];
$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');
$_widget_id = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;
$_section_style = '--widget-bg-color: var(--bg-primary); padding-bottom: 20px;';
if(!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}
// ── Hotspots HTML ─────────────────────────────────────────────────────────────
$_hotspots_html = '';
foreach($_hotspots as $_hi => $_hs) {
    $_hs_title = htmlspecialchars($_hs['title'] ?? '');
    $_hs_desc = htmlspecialchars($_hs['description'] ?? '');
    $_hs_pos_x = htmlspecialchars($_hs['pos_x'] ?? '50');
    $_hs_pos_y = htmlspecialchars($_hs['pos_y'] ?? '50');
    $_hs_btn_lbl = htmlspecialchars($_hs['btn_label'] ?? '');
    $_hs_btn_url = htmlspecialchars(wdg_parse_links($_hs['btn_url'] ?? '#'));
    $_hs_btn_sty = htmlspecialchars($_hs['btn_style'] ?? 'widget-button-secondary');
    $_hs_new_tab = ($_hs['btn_new_tab'] ?? '0') === '1'
            ? ' target="_blank" rel="noopener noreferrer"'
            : ' target="_self"';
    $_block_id = $_widget_id . '_hs' . $_hi;
    $_tooltip_id = 'imhs-tooltip-' . $_widget_id . '-' . $_hi;
    $_pos_attr = (intval($_hs_pos_y) > 60) ? ' data-position="top"' : '';
    $_hotspots_html .= '
          <div class="image-hotspot"' . $_pos_attr . '
               style="inset-inline-start: ' . $_hs_pos_x . '%; inset-block-start: ' . $_hs_pos_y . '%"
               data-block-id="' . $_block_id . '">
            <button type="button" class="image-hotspot-button"
                    aria-label="' . $_hs_title . '"
                    aria-expanded="false"
                    aria-controls="' . $_tooltip_id . '"
                    aria-describedby="' . $_tooltip_id . '">
              <svg class="image-hotspot-icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 5v14" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M5 12h14" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
            <div class="image-hotspot-tooltip" role="tooltip" id="' . $_tooltip_id . '" aria-hidden="true">
              <div class="image-hotspot-tooltip-header">
                <h3 class="image-hotspot-tooltip-title w-title t-sm">' . $_hs_title . '</h3>
                <button type="button" class="image-hotspot-tooltip-close" aria-label="Close tooltip">
                  <svg class="image-hotspot-tooltip-close-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </button>
              </div>';
    if($_hs_desc !== '') {
        $_hotspots_html .= '
              <div class="image-hotspot-tooltip-description w-body w-rte"><p>' . $_hs_desc . '</p></div>';
    }
    if($_hs_btn_lbl !== '') {
        $_hotspots_html .= '
              <div class="image-hotspot-tooltip-footer">
                <a href="' . $_hs_btn_url . '" class="widget-button ' . $_hs_btn_sty . '"' . $_hs_new_tab . '>' . $_hs_btn_lbl . '</a>
              </div>';
    }
    $_hotspots_html .= '
            </div>
          </div>';
}
// ── Widget header HTML ────────────────────────────────────────────────────────
$_header_html = '';
if($_eyebrow !== '') {
    $_header_html .= '<span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0" data-setting="eyebrow">' . $_eyebrow . '</span>' . PHP_EOL;
}
if($_title !== '') {
    $_header_html .= '<h2 class="w-headline reveal reveal-up" style="--reveal-delay: 1" data-setting="title">' . $_title . '</h2>' . PHP_EOL;
}
if($_description !== '') {
    $_header_html .= '<p class="w-description reveal reveal-up" style="--reveal-delay: 2" data-setting="description">' . $_description . '</p>' . PHP_EOL;
}
// ── Image src ────────────────────────────────────────────────────────────────
$_img_src = $_image ?: 'assets/placeholder.svg';
// ── Script (heredoc — $blockID interpolated απευθείας) ───────────────────────
$_script = <<<JSEOF
<script>
document.addEventListener("DOMContentLoaded", function () {
  var widget = document.getElementById("{$_widget_id}");
  if (!widget || widget.dataset.imhsInit) return;
  widget.dataset.imhsInit = "true";

  var wrapper  = widget.querySelector(".image-hotspots-wrapper");
  var hotspots = widget.querySelectorAll(".image-hotspot");
  var isMobile = function () { return window.innerWidth < 750; };

  var arrowStyleEl = document.createElement("style");
  arrowStyleEl.id  = "imhs-arrow-styles-{$_widget_id}";
  document.head.appendChild(arrowStyleEl);

  var closeAll = function () {
    widget.querySelectorAll(".image-hotspot-tooltip.is-visible").forEach(function (t) {
      t.classList.remove("is-visible");
      t.classList.remove("is-mobile");
      t.setAttribute("aria-hidden", "true");
      t.style.insetInlineStart = "";
      t.style.insetInlineEnd   = "";
      t.style.transform        = "";
      arrowStyleEl.textContent = "";
      var parentHotspot = widget.querySelector("[data-tooltip-id='" + t.id + "']");
      if (parentHotspot && t.parentElement !== parentHotspot) {
        parentHotspot.appendChild(t);
      }
    });
    widget.querySelectorAll(".image-hotspot-button.is-active").forEach(function (b) {
      b.classList.remove("is-active");
      b.setAttribute("aria-expanded", "false");
    });
    widget.querySelectorAll(".image-hotspot").forEach(function (h) {
      h.style.zIndex = "";
    });
  };

  hotspots.forEach(function (hotspot) {
    var button      = hotspot.querySelector(".image-hotspot-button");
    var tooltip     = hotspot.querySelector(".image-hotspot-tooltip");
    var closeButton = hotspot.querySelector(".image-hotspot-tooltip-close");

    if (!button || !tooltip) return;

    hotspot.setAttribute("data-tooltip-id", tooltip.id);

    var toggleTooltip = function () {
      var isVisible = tooltip.classList.contains("is-visible");
      closeAll();
      if (!isVisible) {
        hotspot.style.zIndex = "100";
        widget.querySelectorAll(".image-hotspot").forEach(function (h) {
          if (h !== hotspot) h.style.zIndex = "0";
        });
        if (isMobile()) {
          wrapper.after(tooltip);
          tooltip.classList.add("is-mobile");
        }
        tooltip.classList.add("is-visible");
        tooltip.setAttribute("aria-hidden", "false");
        button.classList.add("is-active");
        button.setAttribute("aria-expanded", "true");

        if (!isMobile()) {
          var wrapperRect    = wrapper.getBoundingClientRect();
          var hotspotRect    = hotspot.getBoundingClientRect();
          var hotspotCenterX = hotspotRect.left + hotspotRect.width / 2;
          var tooltipWidth   = 280;
          var margin         = 16;
          arrowStyleEl.textContent = "";

          if (hotspotCenterX - tooltipWidth / 2 < wrapperRect.left + margin) {
            tooltip.style.insetInlineStart = "0";
            tooltip.style.insetInlineEnd   = "auto";
            tooltip.style.transform        = "none";
            var arrowX = Math.max(16, Math.round(hotspotCenterX - wrapperRect.left));
            arrowStyleEl.textContent = "#" + tooltip.id + "::before, #" + tooltip.id + "::after { inset-inline-start: " + arrowX + "px !important; transform: none !important; }";
          } else if (hotspotCenterX + tooltipWidth / 2 > wrapperRect.right - margin) {
            tooltip.style.insetInlineStart = "auto";
            tooltip.style.insetInlineEnd   = "0";
            tooltip.style.transform        = "none";
            var tooltipRect = tooltip.getBoundingClientRect();
            var arrowX2 = Math.min(tooltipRect.width - 16, Math.max(16, Math.round(hotspotCenterX - tooltipRect.left) - 40));
            arrowStyleEl.textContent = "#" + tooltip.id + "::before, #" + tooltip.id + "::after { inset-inline-start: " + arrowX2 + "px !important; inset-inline-end: auto !important; transform: none !important; }";
          } else {
            tooltip.style.insetInlineStart = "";
            tooltip.style.insetInlineEnd   = "";
            tooltip.style.transform        = "";
          }
        }
      }
    };

    button.addEventListener("click", function (e) { e.stopPropagation(); toggleTooltip(); });
    button.addEventListener("keydown", function (e) {
      if (e.key === "Enter" || e.key === " ") { e.preventDefault(); toggleTooltip(); }
    });
    if (closeButton) {
      closeButton.addEventListener("click", function (e) { e.stopPropagation(); closeAll(); button.focus(); });
    }
  });

  document.addEventListener("click", function (e) { if (!widget.contains(e.target)) closeAll(); });
  document.addEventListener("keydown", function (e) { if (e.key === "Escape") closeAll(); });
});
</script>
JSEOF;
// ── Output ────────────────────────────────────────────────────────────────────
echo $_wdg_asset_html;
?>
<section
        id="<?php echo $_widget_id; ?>"
        class="widget widget-image-hotspots widget-<?php echo $_widget_class; ?> <?php echo $_color; ?>"
        style="<?php echo $_section_style; ?>"
        data-widget-id="<?php echo $_widget_id; ?>"
        data-widget-type="image-hotspots"
>
    <style>
        .widget-<?php echo $_widget_class; ?> {
            overflow-x: clip;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspots-wrapper {
            position: relative;
            border: var(--border-width-thin) solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspots-image {
            width: 100%;
            height: auto;
            display: block;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot {
            position: absolute;
            width: 26px;
            height: 26px;
            transform: translate(-50%, -50%);
            z-index: 1;
            pointer-events: none;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot::after {
            content: "";
            position: absolute;
            inset: -6px;
            border: var(--border-width-thin) solid var(--border-color);
            border-radius: 50%;
            animation: hotspot-pulse-<?php echo $blockID; ?> 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            pointer-events: none;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-button {
            position: relative;
            width: 100%;
            height: 100%;
            background-color: var(--text-heading);
            border: var(--border-width-medium) solid var(--bg-primary);
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s, background-color 0.3s;
            pointer-events: auto;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-button:hover {
            transform: scale(1.1);
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-button:focus {
            outline: var(--border-width-medium) solid var(--text-heading);
            outline-offset: 3px;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-button:active {
            transform: scale(0.95);
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-button.is-active {
            transform: scale(1.1);
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-icon {
            width: 10px;
            height: 10px;
            stroke: var(--bg-primary);
            stroke-width: 2;
            fill: none;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-tooltip {
            position: absolute;
            inset-block-start: calc(100% + 12px);
            inset-inline-start: 50%;
            transform: translateX(-50%);
            width: 280px;
            max-width: calc(100vw - 32px);
            background-color: var(--bg-primary);
            border: var(--border-width-thin) solid var(--border-color);
            border-radius: var(--radius-sm);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
            z-index: 10;
            pointer-events: none;
            padding: 20px;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-tooltip::before {
            content: "";
            position: absolute;
            inset-block-end: 100%;
            inset-inline-start: 50%;
            transform: translateX(-50%);
            border: 8px solid transparent;
            border-block-end-color: var(--border-color);
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-tooltip::after {
            content: "";
            position: absolute;
            inset-block-end: calc(100% - 1px);
            inset-inline-start: 50%;
            transform: translateX(-50%);
            border: 8px solid transparent;
            border-block-end-color: var(--bg-primary);
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-tooltip.is-mobile {
            position: relative;
            inset: auto;
            width: 100%;
            max-width: 300px;
            padding: 10px;
            transform: none;
            border: var(--border-width-thin) solid var(--border-color);
            border-radius: var(--radius-sm);
            margin-block-start: 8px;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-tooltip.is-mobile::before,
        .widget-<?php echo $_widget_class; ?> .image-hotspot-tooltip.is-mobile::after {
            display: none;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-tooltip.is-visible {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-tooltip-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 8px;
            margin-block-end: 8px;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-tooltip-close {
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.3s;
            flex-shrink: 0;
            margin-block-start: -4px;
            margin-inline-end: -4px;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-tooltip-close:hover {
            opacity: 0.7;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-tooltip-close:focus {
            outline: var(--border-width-medium) solid var(--text-heading);
            outline-offset: 2px;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-tooltip-close-icon {
            width: 16px;
            height: 16px;
            stroke: var(--text-heading);
            stroke-width: 2;
            fill: none;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-tooltip-description {
            font-size: calc(var(--font-size-sm) * var(--body-scale));
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot-tooltip-footer {
            margin-block-start: 16px;
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot[data-position="top"] .image-hotspot-tooltip {
            inset-block-start: auto;
            inset-block-end: calc(100% + 12px);
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot[data-position="top"] .image-hotspot-tooltip::before {
            inset-block-end: auto;
            inset-block-start: 100%;
            border-block-end-color: transparent;
            border-block-start-color: var(--border-color);
        }

        .widget-<?php echo $_widget_class; ?> .image-hotspot[data-position="top"] .image-hotspot-tooltip::after {
            inset-block-end: auto;
            inset-block-start: calc(100% - 1px);
            border-block-end-color: transparent;
            border-block-start-color: var(--bg-primary);
        }

        @keyframes hotspot-pulse-<?php echo $blockID; ?> {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0;
                transform: scale(1.5);
            }
        }

        @media (min-width: 750px) {
            .widget-<?php echo $_widget_class; ?> .image-hotspot {
                width: 32px;
                height: 32px;
            }

            .widget-<?php echo $_widget_class; ?> .image-hotspot::after {
                inset: -8px;
            }

            .widget-<?php echo $_widget_class; ?> .image-hotspot-icon {
                width: 12px;
                height: 12px;
            }

            .widget-<?php echo $_widget_class; ?> .image-hotspot-tooltip {
                width: 300px;
            }
        }

        @media (min-width: 990px) {
            .widget-<?php echo $_widget_class; ?> .image-hotspot {
                width: 36px;
                height: 36px;
            }

            .widget-<?php echo $_widget_class; ?> .image-hotspot::after {
                inset: -10px;
            }

            .widget-<?php echo $_widget_class; ?> .image-hotspot-icon {
                width: 14px;
                height: 14px;
            }

            .widget-<?php echo $_widget_class; ?> .image-hotspot-tooltip {
                width: 300px;
            }
        }
    </style>
    <div class="widget-container widget-container-padded">
        <?php if($_header_html): ?>
            <div class="widget-header widget-header--align-center">
                <?php echo $_header_html; ?>
            </div>
        <?php endif; ?>
        <div class="widget-content">
            <div class="<?php echo $_hotspot_cs; ?>">
                <div class="image-hotspots-wrapper reveal reveal-fade">
                    <img
                            src="<?php echo $_img_src; ?>"
                            alt=""
                            class="image-hotspots-image"
                            loading="eager"
                    />
                    <?php echo $_hotspots_html; ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo $_script; ?>
</section>
