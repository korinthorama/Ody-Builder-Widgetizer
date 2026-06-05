<?php
/*
 * Widgetizer — Class Schedule Widget — template.php
 * Prefix: cs
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
$_footer_notes = htmlspecialchars($wdg_params['footer_notes'] ?? '');
$_header_align = htmlspecialchars($wdg_params['header_align'] ?? 'start');
$_layout       = htmlspecialchars($wdg_params['layout']       ?? 'tabs');
$_default_day  = htmlspecialchars($wdg_params['default_day']  ?? 'today');
$_week_start   = htmlspecialchars($wdg_params['week_start']   ?? 'monday');
$_color        = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');
$_days_data    = $wdg_params['days'] ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;
$_align_class  = ($_header_align === 'center') ? 'widget-heading-align-center' : 'widget-heading-align-left';

$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';

// ── Day labels ────────────────────────────────────────────────────────────────
$_day_labels = [
    'monday'    => t('Δευτέρα'),
    'tuesday'   => t('Τρίτη'),
    'wednesday' => t('Τετάρτη'),
    'thursday'  => t('Πέμπτη'),
    'friday'    => t('Παρασκευή'),
    'saturday'  => t('Σάββατο'),
    'sunday'    => t('Κυριακή'),
];

$_week_order = ($_week_start === 'sunday')
    ? ['sunday','monday','tuesday','wednesday','thursday','friday','saturday']
    : ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];

$_level_classes = [
    'beginner'     => 'cs-level-beginner',
    'intermediate' => 'cs-level-intermediate',
    'advanced'     => 'cs-level-advanced',
];

// ── Helper: render class row ──────────────────────────────────────────────────
if (!function_exists('_wdg_cs_render_class')) {
    function _wdg_cs_render_class(array $cls, string $blockID, string $day, int $ci, array $level_classes): string {
        $time_hour   = $cls['time_hour']   ?? '';
        $time_min    = str_pad($cls['time_min'] ?? '00', 2, '0', STR_PAD_LEFT);
        $time_format = $cls['time_format'] ?? 'AM';
        if ($time_hour !== '') {
            if ($time_format === '24') {
                $time = htmlspecialchars($time_hour . ':' . $time_min);
            } else {
                $time = htmlspecialchars($time_hour . ':' . $time_min . ' ' . ($time_format === 'AM' ? 'ΠΜ' : 'ΜΜ'));
            }
        } else {
            $time = htmlspecialchars($cls['time'] ?? '');
        }
        $duration    = ($cls['duration'] ?? '') !== '' ? htmlspecialchars($cls['duration']) . ' λεπτά' : '';
        $title       = htmlspecialchars($cls['title']       ?? '');
        $instructor  = htmlspecialchars($cls['instructor']  ?? '');
        $level       = htmlspecialchars($cls['level']       ?? '');
        $description = htmlspecialchars($cls['description'] ?? '');
        $book_label  = htmlspecialchars($cls['book_label']  ?? '');
        $book_url    = htmlspecialchars(wdg_parse_links($cls['book_url'] ?? '#'));
        $book_new_tab = ($cls['book_new_tab'] ?? '0') === '1';
        $book_target = $book_new_tab ? ' target="_blank" rel="noopener noreferrer"' : ' target="_self"';
        $level_class = $level_classes[$level] ?? '';
        $block_id    = 'widget_' . $blockID . '_' . $day . '_class_' . $ci;

        $html  = '<div class="cs-class" data-block-id="' . $block_id . '">';
        $html .= '<div class="cs-class-time">';
        if ($time)     $html .= '<span class="cs-class-time-value t-base" data-setting="time">' . $time . '</span>';
        if ($duration) $html .= '<span class="w-meta t-xs" data-setting="duration">' . $duration . '</span>';
        $html .= '</div>';
        $html .= '<div class="cs-class-main">';
        if ($title) $html .= '<p class="w-title t-lg" data-setting="title">' . $title . '</p>';
        if ($instructor || $level) {
            $html .= '<div class="cs-class-meta w-meta">';
            if ($instructor) $html .= '<span data-setting="instructor">' . $instructor . '</span>';
            if ($instructor && $level) $html .= '<span class="cs-dot" aria-hidden="true"></span>';
            if ($level) $html .= '<span class="cs-level-badge ' . $level_class . ' w-label t-xs" data-setting="level">' . ucfirst($level) . '</span>';
            $html .= '</div>';
        }
        if ($description) $html .= '<p class="w-body t-sm" data-setting="description">' . $description . '</p>';
        $html .= '</div>';
        if ($book_label) {
            $html .= '<div class="cs-class-action">';
            $html .= '<a href="' . $book_url . '" class="widget-button widget-button-small widget-button-secondary" data-setting="book_link"' . $book_target . '>' . $book_label . '</a>';
            $html .= '</div>';
        }
        $html .= '</div>';
        return $html;
    }
}

// ── Widget header ─────────────────────────────────────────────────────────────
$_header_html = '';
if ($_eyebrow !== '')    $_header_html .= '<span class="w-eyebrow t-uppercase reveal reveal-up" style="--reveal-delay: 0" data-setting="eyebrow">' . $_eyebrow . '</span>' . PHP_EOL;
if ($_title !== '')      $_header_html .= '<h2 class="w-headline reveal reveal-up" style="--reveal-delay: 1" data-setting="title">' . $_title . '</h2>' . PHP_EOL;
if ($_subheading !== '') $_header_html .= '<p class="w-description reveal reveal-up" style="--reveal-delay: 2" data-setting="description">' . $_subheading . '</p>' . PHP_EOL;

// ── Content HTML ──────────────────────────────────────────────────────────────
$_content_html = '';

if ($_layout === 'tabs') {
    // Tablist
    $_content_html .= '<div class="cs-tablist" role="tablist" aria-label="' . $_title . '">';
    foreach ($_week_order as $_day_key) {
        $_day_data     = $_days_data[$_day_key] ?? [];
        $_enabled      = ($_day_data['enabled'] ?? '0') === '1';
        $_classes_list = $_day_data['classes'] ?? [];
        $_has_classes  = !empty($_classes_list);
        $_tab_id       = 'cs-tab-' . $_widget_id . '-' . $_day_key;
        $_panel_id     = 'cs-panel-' . $_widget_id . '-' . $_day_key;
        $_disabled     = (!$_enabled || !$_has_classes) ? ' disabled' : '';
        $_content_html .= '<button type="button" class="cs-tab w-label t-base" role="tab" data-day="' . $_day_key . '" aria-selected="false" aria-controls="' . $_panel_id . '" id="' . $_tab_id . '" tabindex="-1"' . $_disabled . '>' . $_day_labels[$_day_key] . '</button>';
    }
    $_content_html .= '</div>';

    // Panels
    foreach ($_week_order as $_day_key) {
        $_day_data     = $_days_data[$_day_key] ?? [];
        $_enabled      = ($_day_data['enabled'] ?? '0') === '1';
        $_classes_list = $_day_data['classes'] ?? [];
        $_panel_id     = 'cs-panel-' . $_widget_id . '-' . $_day_key;
        $_tab_id       = 'cs-tab-' . $_widget_id . '-' . $_day_key;
        $_content_html .= '<div id="' . $_panel_id . '" class="cs-panel" role="tabpanel" aria-labelledby="' . $_tab_id . '" data-day="' . $_day_key . '" hidden>';
        if ($_enabled && !empty($_classes_list)) {
            $_content_html .= '<div class="cs-class-list">';
            foreach ($_classes_list as $_ci => $_cls_item) {
                $_content_html .= _wdg_cs_render_class($_cls_item, $blockID, $_day_key, $_ci, $_level_classes);
            }
            $_content_html .= '</div>';
        } else {
            $_content_html .= '<p class="cs-empty t-sm">No classes scheduled.</p>';
        }
        $_content_html .= '</div>';
    }

} elseif ($_layout === 'accordion') {
    foreach ($_week_order as $_day_key) {
        $_day_data     = $_days_data[$_day_key] ?? [];
        $_enabled      = ($_day_data['enabled'] ?? '0') === '1';
        $_classes_list = $_day_data['classes'] ?? [];
        if (!$_enabled || empty($_classes_list)) continue;
        $_content_html .= '<details class="cs-details">';
        $_content_html .= '<summary class="cs-summary"><span class="cs-summary-label w-label">' . $_day_labels[$_day_key] . '</span><span class="cs-summary-chevron" aria-hidden="true">›</span></summary>';
        $_content_html .= '<div class="cs-panel-body"><div class="cs-class-list">';
        foreach ($_classes_list as $_ci => $_cls_item) {
            $_content_html .= _wdg_cs_render_class($_cls_item, $blockID, $_day_key, $_ci, $_level_classes);
        }
        $_content_html .= '</div></div></details>';
    }

} else {
    // List
    foreach ($_week_order as $_day_key) {
        $_day_data     = $_days_data[$_day_key] ?? [];
        $_enabled      = ($_day_data['enabled'] ?? '0') === '1';
        $_classes_list = $_day_data['classes'] ?? [];
        if (!$_enabled || empty($_classes_list)) continue;
        $_content_html .= '<div class="cs-day-group">';
        $_content_html .= '<h3 class="cs-day-heading w-label">' . $_day_labels[$_day_key] . '</h3>';
        $_content_html .= '<div class="cs-class-list">';
        foreach ($_classes_list as $_ci => $_cls_item) {
            $_content_html .= _wdg_cs_render_class($_cls_item, $blockID, $_day_key, $_ci, $_level_classes);
        }
        $_content_html .= '</div></div>';
    }
}

if ($_footer_notes !== '') {
    $_content_html .= '<p class="cs-note t-sm" data-setting="note">' . $_footer_notes . '</p>';
}

// ── Script ───────────────────────────────────────────────────────────────────
$_script = <<<JSEOF
<script>
document.addEventListener("DOMContentLoaded", function () {
  var root = document.getElementById("{$_widget_id}");
  if (!root || root.dataset.csInit) return;
  root.dataset.csInit = "true";

  var layout = root.dataset.layout || "tabs";
  if (layout !== "tabs") return;

  var tabs   = Array.from(root.querySelectorAll(".cs-tab"));
  var panels = Array.from(root.querySelectorAll(".cs-panel"));
  if (!tabs.length) return;

  var getTodayKey = function () {
    var days = ["sunday","monday","tuesday","wednesday","thursday","friday","saturday"];
    return days[new Date().getDay()];
  };

  var activateDay = function (dayKey) {
    var activated = false;
    tabs.forEach(function (t) {
      var match = t.getAttribute("data-day") === dayKey && !t.disabled;
      t.classList.toggle("is-active", match);
      t.setAttribute("aria-selected", match ? "true" : "false");
      t.setAttribute("tabindex", match ? "0" : "-1");
      if (match) activated = true;
    });
    panels.forEach(function (p) {
      var match = p.getAttribute("data-day") === dayKey;
      p.classList.toggle("is-active", match);
      if (match) p.removeAttribute("hidden");
      else p.setAttribute("hidden", "");
    });
    return activated;
  };

  var defaultDay = root.dataset.defaultDay || "today";
  var initialDay = defaultDay === "today" ? getTodayKey() : defaultDay;
  if (!activateDay(initialDay)) {
    var firstEnabled = tabs.find(function (t) { return !t.disabled; });
    if (firstEnabled) activateDay(firstEnabled.getAttribute("data-day"));
  }

  tabs.forEach(function (tab) {
    tab.addEventListener("click", function () {
      if (tab.disabled) return;
      activateDay(tab.getAttribute("data-day"));
    });
    tab.addEventListener("keydown", function (event) {
      var enabled = tabs.filter(function (t) { return !t.disabled; });
      var currentIndex = enabled.indexOf(tab);
      if (currentIndex === -1) return;
      var nextIndex = null;
      if (event.key === "ArrowRight") nextIndex = (currentIndex + 1) % enabled.length;
      else if (event.key === "ArrowLeft") nextIndex = (currentIndex - 1 + enabled.length) % enabled.length;
      else if (event.key === "Home") nextIndex = 0;
      else if (event.key === "End") nextIndex = enabled.length - 1;
      else return;
      event.preventDefault();
      var next = enabled[nextIndex];
      next.focus();
      activateDay(next.getAttribute("data-day"));
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
  class="widget widget-class-schedule widget-<?php echo $_widget_class; ?> <?php echo $_color; ?> cs-layout-<?php echo $_layout; ?> <?php echo $_align_class; ?>"
  style="<?php echo $_section_style; ?>"
  data-widget-id="<?php echo $_widget_id; ?>"
  data-widget-type="class-schedule"
  data-layout="<?php echo $_layout; ?>"
  data-default-day="<?php echo $_default_day; ?>"
  data-week-start="<?php echo $_week_start; ?>"
>
  <style>
    .widget-<?php echo $_widget_class; ?> .cs-class {
      display: grid;
      grid-template-columns: minmax(70px, auto) 1fr auto;
      gap: var(--space-md);
      align-items: center;
      padding-block: var(--space-md);
      border-block-end: var(--border-width-thin) solid var(--border-color);
    }

    .widget-<?php echo $_widget_class; ?> .cs-class:last-child { border-block-end: none; }

    .widget-<?php echo $_widget_class; ?> .cs-class-time {
      display: flex;
      flex-direction: column;
      gap: 2px;
      color: var(--text-heading);
      font-weight: var(--font-weight-semibold);
      font-variant-numeric: tabular-nums;
    }

    .widget-<?php echo $_widget_class; ?> .cs-class-main { min-width: 0; }

    .widget-<?php echo $_widget_class; ?> .cs-class-meta {
      display: flex;
      flex-wrap: wrap;
      gap: var(--space-xs) var(--space-sm);
      align-items: center;
      margin-block-start: 3px;
    }

    .widget-<?php echo $_widget_class; ?> .cs-class-main .w-title { margin: 0; }
    .widget-<?php echo $_widget_class; ?> .cs-class-main .w-body { margin-block-start: 4px; color: var(--text-content); }

    .widget-<?php echo $_widget_class; ?> .cs-dot {
      width: 4px;
      height: 4px;
      border-radius: 50%;
      background-color: currentColor;
      opacity: 0.5;
      display: inline-block;
    }

    .widget-<?php echo $_widget_class; ?> .cs-level-badge {
      padding: var(--space-xs) var(--space-md);
      background-color: var(--bg-secondary);
      border: var(--border-width-thin) solid var(--border-color);
      border-radius: var(--radius-sm);
    }

    .widget-<?php echo $_widget_class; ?> .cs-level-advanced {
      background-color: var(--accent) !important;
      color: var(--accent-text) !important;
      border-color: var(--accent) !important;
    }

    .widget-<?php echo $_widget_class; ?> .cs-class-action { justify-self: end; }

    .widget-<?php echo $_widget_class; ?> .cs-empty {
      padding-block: var(--space-xl);
      text-align: center;
      color: var(--text-muted);
    }

    .widget-<?php echo $_widget_class; ?> .cs-note {
      margin-block-start: var(--space-lg);
      padding-block-start: var(--space-md);
      border-block-start: var(--border-width-thin) solid var(--border-color);
      color: var(--text-muted);
    }

    /* Tabs */
    .widget-<?php echo $_widget_class; ?>.cs-layout-tabs .cs-tablist {
      display: flex;
      flex-wrap: wrap;
      gap: var(--space-xs);
      margin-block-end: var(--space-lg);
      border-block-end: var(--border-width-thin) solid var(--border-color);
    }

    .widget-<?php echo $_widget_class; ?>.cs-layout-tabs .cs-tab {
      appearance: none;
      background: transparent;
      border: none;
      padding: var(--space-sm) var(--space-md);
      font-family: inherit;
      color: var(--text-muted);
      cursor: pointer;
      border-block-end: var(--border-width-medium) solid transparent;
      margin-block-end: calc(var(--border-width-thin) * -1);
      transition: color 0.2s, border-color 0.2s;
    }

    .widget-<?php echo $_widget_class; ?>.cs-layout-tabs .cs-tab:hover { color: var(--text-heading); }
    .widget-<?php echo $_widget_class; ?>.cs-layout-tabs .cs-tab.is-active { color: var(--text-heading); border-block-end-color: var(--accent); }
    .widget-<?php echo $_widget_class; ?>.cs-layout-tabs .cs-tab[disabled] { opacity: 0.4; cursor: not-allowed; }
    .widget-<?php echo $_widget_class; ?>.cs-layout-tabs .cs-panel { display: none; }
    .widget-<?php echo $_widget_class; ?>.cs-layout-tabs .cs-panel.is-active { display: block; animation: csFadeIn-<?php echo $blockID; ?> 0.2s ease-out; }

    /* Accordion */
    .widget-<?php echo $_widget_class; ?>.cs-layout-accordion .cs-details { border-block-end: var(--border-width-thin) solid var(--border-color); }
    .widget-<?php echo $_widget_class; ?>.cs-layout-accordion .cs-details:first-child { border-block-start: var(--border-width-thin) solid var(--border-color); }
    .widget-<?php echo $_widget_class; ?>.cs-layout-accordion .cs-summary {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding-block: var(--space-md);
      cursor: pointer;
      list-style: none;
      color: var(--text-heading);
    }
    .widget-<?php echo $_widget_class; ?>.cs-layout-accordion .cs-summary::-webkit-details-marker { display: none; }
    .widget-<?php echo $_widget_class; ?>.cs-layout-accordion .cs-summary-chevron { display: inline-block; transition: transform 0.2s ease; color: var(--text-muted); flex-shrink: 0; }
    .widget-<?php echo $_widget_class; ?>.cs-layout-accordion .cs-details[open] .cs-summary-chevron { transform: rotate(90deg); }
    .widget-<?php echo $_widget_class; ?>.cs-layout-accordion .cs-details[open] .cs-panel-body { padding-block-end: var(--space-md); }
    .widget-<?php echo $_widget_class; ?>.cs-layout-accordion .cs-details .cs-class:first-child { border-block-start: var(--border-width-thin) solid var(--border-color); }

    /* List */
    .widget-<?php echo $_widget_class; ?>.cs-layout-list .cs-day-group { margin-block-end: var(--space-xl); }
    .widget-<?php echo $_widget_class; ?>.cs-layout-list .cs-day-group:last-child { margin-block-end: 0; }
    .widget-<?php echo $_widget_class; ?>.cs-layout-list .cs-day-heading { margin: 0 0 var(--space-sm); color: var(--text-heading); padding-block-end: var(--space-sm); border-block-end: var(--border-width-medium) solid var(--accent); }

    /* Mobile */
    @media (max-width: 749px) {
      .widget-<?php echo $_widget_class; ?> .cs-class { grid-template-columns: 1fr; gap: var(--space-xs); }
      .widget-<?php echo $_widget_class; ?> .cs-class-action { justify-self: start; }
      .widget-<?php echo $_widget_class; ?>.cs-layout-tabs .cs-tablist { overflow-x: auto; flex-wrap: nowrap; scrollbar-width: none; }
      .widget-<?php echo $_widget_class; ?>.cs-layout-tabs .cs-tablist::-webkit-scrollbar { display: none; }
      .widget-<?php echo $_widget_class; ?>.cs-layout-tabs .cs-tab { flex-shrink: 0; }
    }

    @keyframes csFadeIn-<?php echo $blockID; ?> {
      from { opacity: 0; transform: translateY(5px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>

  <div class="widget-container">
    <?php if ($_header_html): ?>
    <div class="widget-header widget-header--align-<?php echo $_header_align; ?>">
      <?php echo $_header_html; ?>
    </div>
    <?php endif; ?>

    <div class="widget-content reveal reveal-up">
      <?php echo $_content_html; ?>
    </div>
  </div>

  <?php echo $_script; ?>
</section>
