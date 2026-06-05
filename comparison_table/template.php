<?php
/*
 * Widgetizer — Comparison Table Widget — template.php
 * Prefix: ct
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

// ── SVG icons ─────────────────────────────────────────────────────────────────
$_icon_check = '<svg class="icon comparison-table-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5l10 -10"/></svg>';
$_icon_cross  = '<svg class="icon comparison-table-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6l-12 12"/><path d="M6 6l12 12"/></svg>';

// ── Παράμετροι ────────────────────────────────────────────────────────────────
$_eyebrow        = htmlspecialchars($wdg_params['eyebrow']        ?? '');
$_title          = htmlspecialchars($wdg_params['title']          ?? '');
$_description    = htmlspecialchars($wdg_params['description']    ?? '');
$_features_label = htmlspecialchars($wdg_params['features_label'] ?? 'Features');
$_color          = htmlspecialchars($wdg_params['color_scheme']   ?? 'color-scheme-standard-primary');
$_columns        = $wdg_params['columns'] ?? [];
$_rows           = $wdg_params['rows']    ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;

$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';

// ── Widget header ─────────────────────────────────────────────────────────────
$_header_html = '';
if ($_eyebrow !== '')     $_header_html .= '<span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0" data-setting="eyebrow">' . $_eyebrow . '</span>' . PHP_EOL;
if ($_title !== '')       $_header_html .= '<h2 class="w-headline reveal reveal-up" style="--reveal-delay: 1" data-setting="title">' . $_title . '</h2>' . PHP_EOL;
if ($_description !== '') $_header_html .= '<p class="w-description reveal reveal-up" style="--reveal-delay: 2" data-setting="description">' . $_description . '</p>' . PHP_EOL;

// ── THEAD ─────────────────────────────────────────────────────────────────────
$_thead = '<thead class="comparison-table-head"><tr>';
$_thead .= '<th class="comparison-table-th">' . $_features_label . '</th>';
foreach ($_columns as $_ci => $_col) {
    $_col_name     = htmlspecialchars($_col['name']  ?? '');
    $_col_badge    = htmlspecialchars($_col['badge'] ?? '');
    $_col_featured = ($_col['featured'] ?? '0') === '1';
    $_th_class     = 'comparison-table-th' . ($_col_featured ? ' comparison-table-th-featured' : '');
    $_block_id     = $_widget_id . '_col_' . $_ci;
    $_thead .= '<th class="' . $_th_class . '" data-block-id="' . $_block_id . '">';
    $_thead .= '<div class="comparison-table-th-name w-body" data-setting="name">' . $_col_name . '</div>';
    if ($_col_badge !== '') $_thead .= '<span class="comparison-table-badge w-label t-xs" data-setting="badge">' . $_col_badge . '</span>';
    $_thead .= '</th>';
}
$_thead .= '</tr></thead>';

// ── TBODY ─────────────────────────────────────────────────────────────────────
$_tbody = '<tbody class="comparison-table-body">';
foreach ($_rows as $_ri => $_row) {
    $_row_name   = htmlspecialchars($_row['name']   ?? '');
    $_row_values = $_row['values'] ?? '';
    $_row_lines  = array_map('trim', explode('|||', $_row_values));
    $_block_id   = $_widget_id . '_row_' . $_ri;
    $_tbody .= '<tr data-block-id="' . $_block_id . '">';
    $_tbody .= '<td class="comparison-table-td w-body t-heading" data-setting="name">' . $_row_name . '</td>';
    foreach ($_columns as $_ci => $_col) {
        $_col_featured = ($_col['featured'] ?? '0') === '1';
        $_td_class     = 'comparison-table-td' . ($_col_featured ? ' comparison-table-td-featured' : '');
        $_cell_val     = strtolower(trim($_row_lines[$_ci] ?? 'no'));
        $_tbody .= '<td class="' . $_td_class . '">';
        if ($_cell_val === 'yes') {
            $_tbody .= '<span class="comparison-table-check" aria-label="Included">' . $_icon_check . '</span>';
        } elseif ($_cell_val === 'no' || $_cell_val === '') {
            $_tbody .= '<span class="comparison-table-cross" aria-label="Not included">' . $_icon_cross . '</span>';
        } else {
            $_tbody .= '<span class="w-body t-sm">' . htmlspecialchars($_row_lines[$_ci] ?? '') . '</span>';
        }
        $_tbody .= '</td>';
    }
    $_tbody .= '</tr>';
}
$_tbody .= '</tbody>';

// ── TFOOT ─────────────────────────────────────────────────────────────────────
$_tfoot = '<tfoot class="comparison-table-foot"><tr><td></td>';
foreach ($_columns as $_ci => $_col) {
    $_col_featured = ($_col['featured'] ?? '0') === '1';
    $_btn_label    = htmlspecialchars($_col['btn_label'] ?? '');
    $_btn_url      = htmlspecialchars(wdg_parse_links($_col['btn_url'] ?? '#'));
    $_btn_new_tab  = ($_col['btn_new_tab'] ?? '0') === '1' ? ' target="_blank" rel="noopener noreferrer"' : ' target="_self"';
    $_btn_style    = htmlspecialchars($_col['btn_style'] ?? 'widget-button-secondary');
    $_td_class     = $_col_featured ? ' class="comparison-table-td-featured"' : '';
    $_tfoot .= '<td' . $_td_class . '>';
    if ($_btn_label !== '') {
        $_tfoot .= '<a href="' . $_btn_url . '" class="widget-button ' . $_btn_style . '"' . $_btn_new_tab . '>' . $_btn_label . '</a>';
    }
    $_tfoot .= '</td>';
}
$_tfoot .= '</tr></tfoot>';

// ── Output ────────────────────────────────────────────────────────────────────
echo $_wdg_asset_html;
?>
<section
  id="<?php echo $_widget_id; ?>"
  class="widget widget-comparison-table widget-<?php echo $_widget_class; ?> <?php echo $_color; ?>"
  style="<?php echo $_section_style; ?>"
  data-widget-id="<?php echo $_widget_id; ?>"
  data-widget-type="comparison-table"
>
  <style>
    .widget-<?php echo $_widget_class; ?> .comparison-table-wrapper {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      margin-inline: calc(var(--space-lg) * -1);
      padding-inline: var(--space-lg);
    }

    .widget-<?php echo $_widget_class; ?> .comparison-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      min-width: 600px;
    }

    .widget-<?php echo $_widget_class; ?> .comparison-table-head { background-color: var(--bg-secondary); }

    .widget-<?php echo $_widget_class; ?> .comparison-table-th {
      padding: var(--space-lg) var(--space-md);
      text-align: center;
      border-block-end: var(--border-width-medium) solid var(--border-color);
      vertical-align: top;
    }

    .widget-<?php echo $_widget_class; ?> .comparison-table-th:first-child {
      text-align: start;
      padding-inline-start: var(--space-lg);
    }

    .widget-<?php echo $_widget_class; ?> .comparison-table-th-featured {
      position: relative;
      border-inline-start: var(--border-width-medium) solid var(--accent);
      border-inline-end: var(--border-width-medium) solid var(--accent);
      border-block-start: var(--border-width-medium) solid var(--accent);
    }

    .widget-<?php echo $_widget_class; ?> .comparison-table-badge {
      display: block;
      background-color: var(--accent) !important;
      color: var(--accent-text) !important;
      padding: 4px 8px;
      border-radius: var(--radius-sm);
      margin-block-start: var(--space-xs);
      width: fit-content;
      margin-inline: auto;
      letter-spacing: 0.05em;
    }

    .widget-<?php echo $_widget_class; ?> .comparison-table-body tr:nth-child(even) { background-color: var(--bg-secondary); }

    .widget-<?php echo $_widget_class; ?> .comparison-table-td {
      padding: var(--space-md);
      text-align: center;
      border-block-end: var(--border-width-thin) solid var(--border-color);
      vertical-align: middle;
    }

    .widget-<?php echo $_widget_class; ?> .comparison-table-td:first-child {
      text-align: start;
      padding-inline-start: var(--space-lg);
    }

    .widget-<?php echo $_widget_class; ?> .comparison-table-td.comparison-table-td-featured {
      border-inline-start: var(--border-width-medium) solid var(--accent);
      border-inline-end: var(--border-width-medium) solid var(--accent);
    }

    .widget-<?php echo $_widget_class; ?> .comparison-table-body tr:last-child .comparison-table-td.comparison-table-td-featured {
      border-block-end: var(--border-width-medium) solid var(--accent);
    }

    .widget-<?php echo $_widget_class; ?> .comparison-table-check { display: flex; justify-content: center; color: var(--accent); }
    .widget-<?php echo $_widget_class; ?> .comparison-table-cross { display: flex; justify-content: center; color: var(--text-muted); }

    .widget-<?php echo $_widget_class; ?> .comparison-table-icon { width: 15px; height: 15px; }

    .widget-<?php echo $_widget_class; ?> .comparison-table-foot td {
      padding: var(--space-lg) var(--space-md);
      text-align: center;
      vertical-align: middle;
    }

    .widget-<?php echo $_widget_class; ?> .comparison-table-foot td:first-child { padding-inline-start: var(--space-lg); }

    @media (min-width: 750px) {
      .widget-<?php echo $_widget_class; ?> .comparison-table-wrapper { margin-inline: 0; padding-inline: 0; }
      .widget-<?php echo $_widget_class; ?> .comparison-table { min-width: 0; }
      .widget-<?php echo $_widget_class; ?> .comparison-table-th { padding: var(--space-xl) var(--space-lg); }
      .widget-<?php echo $_widget_class; ?> .comparison-table-th:first-child { padding-inline-start: var(--space-xl); }
      .widget-<?php echo $_widget_class; ?> .comparison-table-badge { padding: 6px 12px; }
      .widget-<?php echo $_widget_class; ?> .comparison-table-td { padding: var(--space-lg); }
      .widget-<?php echo $_widget_class; ?> .comparison-table-td:first-child { padding-inline-start: var(--space-xl); }
      .widget-<?php echo $_widget_class; ?> .comparison-table-icon { width: 18px; height: 18px; }
      .widget-<?php echo $_widget_class; ?> .comparison-table-foot td { padding: var(--space-xl) var(--space-lg); }
      .widget-<?php echo $_widget_class; ?> .comparison-table-foot td:first-child { padding-inline-start: var(--space-xl); }
    }
  </style>

  <div class="widget-container">
    <?php if ($_header_html): ?>
    <div class="widget-header">
      <?php echo $_header_html; ?>
    </div>
    <?php endif; ?>

    <div class="widget-content">
      <div class="comparison-table-wrapper reveal reveal-up">
        <table class="comparison-table">
          <?php echo $_thead . $_tbody . $_tfoot; ?>
        </table>
      </div>
    </div>
  </div>
</section>
