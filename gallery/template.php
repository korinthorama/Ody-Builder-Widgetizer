<?php
/*
 * Widgetizer — Gallery Widget — template.php
 * Prefix: gl
 *
 * Pure PHP string output — χωρίς DOMDocument, χωρίς html_markup.
 */

// ── Assets ────────────────────────────────────────────────────────────────────
$_wdg_assets  = 'admin/builder_widget_assets/';
$_wdg_css     = $_wdg_assets . 'base.css';
$_wdg_js      = $_wdg_assets . 'scripts.js';
$_wdg_glb_css = 'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css';
$_wdg_glb_js  = 'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js';
$_wdg_asset_html = '';
if (!in_array($_wdg_css, $document->loadedFiles)) {
    $_wdg_asset_html .= '<link href="' . $_wdg_css . '" rel="stylesheet" type="text/css">' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_css;
}
if (!in_array($_wdg_js, $document->loadedFiles)) {
    $_wdg_asset_html .= '<script src="' . $_wdg_js . '"></script>' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_js;
}
// GLightbox — DOM-check loader
$_wdg_asset_html .= '<script>' .
'(function(){' .
'if(!document.querySelector("link[href*=\'glightbox\']")){' .
'var l=document.createElement("link");l.rel="stylesheet";' .
'l.href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css";' .
'document.head.appendChild(l);}' .
'if(!document.querySelector("script[src*=\'glightbox\']")){' .
'var s=document.createElement("script");' .
's.src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js";' .
's.onload=function(){document.dispatchEvent(new CustomEvent("glightbox:ready"));};' .
'document.head.appendChild(s);' .
'}else if(typeof GLightbox!=="undefined"){' .
'document.dispatchEvent(new CustomEvent("glightbox:ready"));' .
'}' .
'})();' .
'</script>' . PHP_EOL;

// ── Παράμετροι ────────────────────────────────────────────────────────────────
$_eyebrow      = htmlspecialchars($wdg_params['eyebrow']      ?? '');
$_title        = htmlspecialchars($wdg_params['title']        ?? '');
$_description  = htmlspecialchars($wdg_params['description']  ?? '');
$_cols         = (int)($wdg_params['columns']                 ?? 4);
$_layout       = htmlspecialchars($wdg_params['layout']       ?? 'grid');
$_aspect_ratio = htmlspecialchars($wdg_params['aspect_ratio'] ?? '4 / 3');
$_color        = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');
$_gl_items     = $wdg_params['items'] ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;
$_gallery_id   = 'gallery-' . $blockID;

$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';

// ── Widget header ─────────────────────────────────────────────────────────────
$_header_html = '';
if ($_eyebrow !== '')    $_header_html .= '<span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0" data-setting="eyebrow">' . $_eyebrow . '</span>' . PHP_EOL;
if ($_title !== '')      $_header_html .= '<h2 class="w-headline reveal reveal-up" style="--reveal-delay: 1" data-setting="title">' . $_title . '</h2>' . PHP_EOL;
if ($_description !== '') $_header_html .= '<p class="w-description reveal reveal-up" style="--reveal-delay: 2" data-setting="description">' . $_description . '</p>' . PHP_EOL;

// ── Items HTML ────────────────────────────────────────────────────────────────
$_items_html = '';
$_li_extra = ($_layout === 'carousel') ? ' carousel-item' : '';
foreach ($_gl_items as $_ii => $_item) {
    $_img_src  = str_replace(['"', "'"], '', $_item['image']   ?? '');
    $_caption  = htmlspecialchars($_item['caption'] ?? '');
    $_block_id = $_widget_id . '_img' . $_ii;

    $_items_html .= '<li class="widget-card' . $_li_extra . '" data-block-id="' . $_block_id . '">';
    if ($_img_src) {
        $_glightbox_attr = ' data-gallery="' . $_gallery_id . '"';
        if ($_caption !== '') $_glightbox_attr .= ' data-glightbox="description: ' . str_replace('"', '&quot;', $_caption) . '"';
        $_items_html .= '<a href="' . $_img_src . '" class="glightbox"' . $_glightbox_attr . '>';
        $_items_html .= '<img src="' . $_img_src . '" alt="' . $_caption . '" class="widget-card-image" loading="lazy">';
        $_items_html .= '</a>';
    }
    if ($_caption !== '') {
        $_items_html .= '<div class="gallery-overlay"><span class="gallery-caption w-meta t-sm">' . $_caption . '</span></div>';
    }
    $_items_html .= '</li>' . PHP_EOL;
}

// ── Content block ─────────────────────────────────────────────────────────────
if ($_layout === 'grid') {
    $_content_html = '<ul class="widget-card-grid widget-grid" style="--grid-cols-desktop: ' . $_cols . '">' . $_items_html . '</ul>';
} else {
    $_content_html =
        '<div class="carousel-container">' .
        '<button type="button" class="carousel-btn carousel-btn-prev" aria-label="Previous">' .
        '<svg class="carousel-btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M15 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>' .
        '</button>' .
        '<button type="button" class="carousel-btn carousel-btn-next" aria-label="Next">' .
        '<svg class="carousel-btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 18l6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>' .
        '</button>' .
        '<ul class="widget-card-grid carousel-track" style="--carousel-cols: ' . $_cols . '">' .
        $_items_html .
        '</ul></div>';
}

// ── Script ───────────────────────────────────────────────────────────────────
$_script = <<<JSEOF
<script>
(function () {
  var sectionId = "{$_widget_id}";
  var galleryId = "{$_gallery_id}";

  function run() {
    var section = document.getElementById(sectionId);
    if (!section) return;

    // Carousel
    var carouselContainer = section.querySelector(".carousel-container");
    if (carouselContainer && !carouselContainer.dataset.carouselInit) {
      carouselContainer.dataset.carouselInit = "true";
      var track   = carouselContainer.querySelector(".carousel-track");
      var prevBtn = carouselContainer.querySelector(".carousel-btn-prev");
      var nextBtn = carouselContainer.querySelector(".carousel-btn-next");
      if (track && prevBtn && nextBtn) {
        var updateButtons = function () {
          prevBtn.disabled = track.scrollLeft <= 0;
          nextBtn.disabled = track.scrollLeft + track.clientWidth >= track.scrollWidth - 1;
        };
        var getScrollAmount = function () {
          var item = track.querySelector(".carousel-item");
          if (!item) return track.clientWidth;
          var gap = parseFloat(getComputedStyle(track).gap) || 0;
          return item.offsetWidth + gap;
        };
        prevBtn.addEventListener("click", function () { track.scrollBy({ left: -getScrollAmount(), behavior: "smooth" }); });
        nextBtn.addEventListener("click", function () { track.scrollBy({ left: getScrollAmount(), behavior: "smooth" }); });
        track.addEventListener("scroll", updateButtons, { passive: true });
        new ResizeObserver(function () { requestAnimationFrame(updateButtons); }).observe(carouselContainer);
        updateButtons();
      }
    }

    // GLightbox
    var initLightbox = function () {
      if (typeof GLightbox !== "undefined") {
        GLightbox({ selector: '.glightbox[data-gallery="' + galleryId + '"]', touchNavigation: true, loop: true });
      }
    };
    document.addEventListener("glightbox:ready", initLightbox);
    if (typeof GLightbox !== "undefined") initLightbox();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", run);
  } else {
    requestAnimationFrame(function () { requestAnimationFrame(run); });
  }
})();
</script>
JSEOF;

// ── Output ────────────────────────────────────────────────────────────────────
echo $_wdg_asset_html;
?>
<section
  id="<?php echo $_widget_id; ?>"
  class="widget widget-type-gallery widget-<?php echo $_widget_class; ?> <?php echo $_color; ?>"
  style="<?php echo $_section_style; ?>"
  data-widget-id="<?php echo $_widget_id; ?>"
  data-widget-type="gallery"
>
  <style>
    .widget-<?php echo $_widget_class; ?> .widget-card {
      position: relative;
      overflow: hidden;
      aspect-ratio: <?php echo $_aspect_ratio; ?>;
      cursor: pointer;
      padding: 0;
    }

    .widget-<?php echo $_widget_class; ?> .widget-card:hover .widget-card-image { transform: scale(1.05); }
    .widget-<?php echo $_widget_class; ?> .widget-card:hover .gallery-overlay { opacity: 1; }

    .widget-<?php echo $_widget_class; ?> .widget-card-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      transition: transform 0.3s;
      aspect-ratio: auto;
      margin-block-end: 0;
      border-radius: 0;
    }

    .widget-<?php echo $_widget_class; ?> .gallery-overlay {
      position: absolute;
      inset: 0;
      background-color: rgba(0,0,0,0.3);
      display: flex;
      align-items: flex-end;
      padding: var(--space-md);
      opacity: 0;
      transition: opacity 0.3s;
      pointer-events: none;
    }

    .widget-<?php echo $_widget_class; ?> .gallery-caption {
      color: #fff !important;
      text-shadow: 0 1px 2px rgba(0,0,0,0.5);
    }

    .glightbox-clean .gslide-description { background: #000; color: silver; }
  </style>

  <div class="widget-container">
    <?php if ($_header_html): ?>
    <div class="widget-header widget-header--align-center">
      <?php echo $_header_html; ?>
    </div>
    <?php endif; ?>

    <div class="widget-content">
      <?php echo $_content_html; ?>
    </div>
  </div>

  <?php echo $_script; ?>
</section>
