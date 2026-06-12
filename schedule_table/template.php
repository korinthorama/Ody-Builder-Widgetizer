<?php
/*
 * Widgetizer — Schedule Table Widget — template.php
 * Prefix: sct
 * Refactored: Pure PHP output, flat CSS, no DOMDocument
 * Supports continuous + discontinuous (two periods) with bold separator |
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
$_eyebrow       = htmlspecialchars($wdg_params['eyebrow']        ?? '');
$_title         = htmlspecialchars($wdg_params['title']          ?? '');
$_description   = htmlspecialchars($wdg_params['description']    ?? '');
$_header_align  = htmlspecialchars($wdg_params['header_align']   ?? 'left');
$_layout_reverse = ($wdg_params['layout_reverse'] ?? '0') === '1';
$_week_start    = htmlspecialchars($wdg_params['week_start']     ?? 'monday');
$_note_raw      = base64_decode(str_replace('[equal]', '=', $wdg_params['note'] ?? ''));
$_note          = nl2br(htmlspecialchars($_note_raw));
$_color         = htmlspecialchars($wdg_params['color_scheme']   ?? 'color-scheme-standard-primary');
$_days_data     = $wdg_params['days']        ?? [];
$_info_blocks   = $wdg_params['info_blocks'] ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map = ['full'=>null,'xl'=>'1420px','lg'=>'1200px','md'=>'960px','sm'=>'760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

// ── Widget IDs ────────────────────────────────────────────────────────────────
$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;

// ── Day labels & order ────────────────────────────────────────────────────────
$_day_labels = [
    'monday'    => t('Δευτέρα'),
    'tuesday'   => t('Τρίτη'),
    'wednesday' => t('Τετάρτη'),
    'thursday'  => t('Πέμπτη'),
    'friday'    => t('Παρασκευή'),
    'saturday'  => t('Σάββατο'),
    'sunday'    => t('Κυριακή'),
];
$_week_order_monday = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
$_week_order_sunday = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
$_week_order = ($_week_start === 'sunday') ? $_week_order_sunday : $_week_order_monday;

// ── Helper: format time with 12‑hour conversion for AM/PM ─────────────────────
if (!function_exists('_wdg_sct_format_time')) {
    function _wdg_sct_format_time(string $h, string $m, string $fmt): string {
        if ($h === '') return '';
        $hour = (int)$h;
        $min = str_pad($m, 2, '0', STR_PAD_LEFT);
        
        if ($fmt === '24') {
            return str_pad($hour, 2, '0', STR_PAD_LEFT) . ':' . $min;
        }
        
        // Convert to 12-hour format for AM/PM
        $suffix = ($fmt === 'AM') ? 'ΠΜ' : 'ΜΜ';
        $hour12 = $hour % 12;
        if ($hour12 === 0) $hour12 = 12;
        return $hour12 . ':' . $min . ' ' . $suffix;
    }
}

// ── Helper: format periods into HTML with bold separator ─────────────────────
if (!function_exists('_wdg_sct_format_periods')) {
    function _wdg_sct_format_periods(array $periods): string {
        $parts = [];
        foreach ($periods as $p) {
            $open = _wdg_sct_format_time($p['open_h'] ?? '', $p['open_m'] ?? '', $p['open_f'] ?? '24');
            $close = _wdg_sct_format_time($p['close_h'] ?? '', $p['close_m'] ?? '', $p['close_f'] ?? '24');
            if ($open && $close) {
                $parts[] = htmlspecialchars($open . ' – ' . $close);
            } elseif ($open) {
                $parts[] = htmlspecialchars($open);
            } elseif ($close) {
                $parts[] = htmlspecialchars($close);
            }
        }
        // Bold separator with spaces
        $separator = '<span class="schedule-separator"> + </span>';
        return implode($separator, $parts);
    }
}

// ── Build schedule rows HTML ──────────────────────────────────────────────────
$_schedule_rows_html = '';
$_di = 0;
foreach ($_week_order as $_day_key) {
    $_day_data = $_days_data[$_day_key] ?? [];
    $_is_closed = ($_day_data['closed'] ?? '0') === '1';
    $_label = $_day_labels[$_day_key];
    
    $_row_class = 'schedule-row reveal reveal-up';
    if ($_is_closed) $_row_class .= ' is-closed';
    
    $_row_html = '<div class="' . $_row_class . '" style="--reveal-delay: ' . $_di . '" data-day-index="' . $_di . '">';
    $_row_html .= '<span class="schedule-label w-body">' . htmlspecialchars($_label) . '</span>';
    
    if ($_is_closed) {
        $_row_html .= '<span class="schedule-closed w-body t-muted">' . t('Κλειστό') . '</span>';
    } else {
        // Read periods (supports both new and old data structure)
        $_periods = $_day_data['periods'] ?? [];
        
        // Backward compatibility: convert old single‑period fields
        if (empty($_periods) && (isset($_day_data['open_h']) || isset($_day_data['close_h']))) {
            $_periods = [[
                'open_h'  => $_day_data['open_h']  ?? '',
                'open_m'  => $_day_data['open_m']  ?? '',
                'open_f'  => $_day_data['open_f']  ?? '24',
                'close_h' => $_day_data['close_h'] ?? '',
                'close_m' => $_day_data['close_m'] ?? '',
                'close_f' => $_day_data['close_f'] ?? '24',
            ]];
        }
        
        // Format periods (returns HTML with bold separator)
        $_hours_html = _wdg_sct_format_periods($_periods);
        if ($_hours_html === '') {
            $_hours_html = t('Κλειστό'); // fallback
        }
        $_row_html .= '<span class="schedule-value w-body t-heading">' . $_hours_html . '</span>';
    }
    $_row_html .= '</div>';
    
    $_schedule_rows_html .= $_row_html;
    $_di++;
}

// ── Build info blocks HTML ────────────────────────────────────────────────────
$_info_blocks_html = '';
if (!empty($_info_blocks)) {
    foreach ($_info_blocks as $_block) {
        $_bi_title = htmlspecialchars($_block['title'] ?? '');
        $_bi_text_raw = base64_decode(str_replace('[equal]', '=', $_block['text'] ?? ''));
        $_bi_text = nl2br(htmlspecialchars($_bi_text_raw));
        
        $_info_blocks_html .= '<div class="schedule-info-block">';
        if ($_bi_title) {
            $_info_blocks_html .= '<h3 class="schedule-info-title w-title t-xl">' . $_bi_title . '</h3>';
        }
        if ($_bi_text) {
            $_info_blocks_html .= '<div class="schedule-info-text w-body w-rte">' . $_bi_text . '</div>';
        }
        $_info_blocks_html .= '</div>';
    }
}

// ── No sidebar class ──────────────────────────────────────────────────────────
$_no_sidebar_class = (empty($_info_blocks)) ? ' no-sidebar' : '';

// ── Header align class ────────────────────────────────────────────────────────
$_align_class = ' widget-heading-align-' . $_header_align;
$_reverse_class = $_layout_reverse ? ' layout-reverse' : '';

// ── Section style ─────────────────────────────────────────────────────────────
$_sec_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_sec_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

// ── Build full HTML ───────────────────────────────────────────────────────────
?>
<?php echo $_wdg_asset_html; ?>
<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-schedule-table widget-<?php echo $_widget_class; ?> <?php echo $_color . $_align_class . $_reverse_class; ?> no_collapse"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="schedule-table"
    data-week-start="<?php echo $_week_start; ?>"
    style="<?php echo $_sec_style; ?>"
>
    <style>
        /* Flat CSS — no nesting */
        .widget-<?php echo $_widget_class; ?> .schedule-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        .widget-<?php echo $_widget_class; ?> .schedule-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--space-md) 0;
            border-block-end: var(--border-width-thin) solid var(--border-color);
        }
        .widget-<?php echo $_widget_class; ?> .schedule-row:first-child {
            border-block-start: var(--border-width-thin) solid var(--border-color);
        }
        .widget-<?php echo $_widget_class; ?> .schedule-row.is-today {
            border-block-start: var(--border-width-medium) solid var(--accent);
            border-block-end: var(--border-width-medium) solid var(--accent);
        }
        .widget-<?php echo $_widget_class; ?> .schedule-row.is-today .schedule-label,
        .widget-<?php echo $_widget_class; ?> .schedule-row.is-today .schedule-value {
            font-weight: var(--font-weight-semibold);
        }
        .widget-<?php echo $_widget_class; ?> .schedule-separator {
            font-weight: bold;
            margin: 0 4px;
            color: red;
        }
        .widget-<?php echo $_widget_class; ?> .schedule-note {
            margin-block-start: var(--space-lg);
        }
        .widget-<?php echo $_widget_class; ?> .schedule-info {
            display: flex;
            flex-direction: column;
            gap: var(--space-xl);
        }
        .widget-<?php echo $_widget_class; ?> .schedule-info-block {
            display: flex;
            flex-direction: column;
            gap: var(--space-sm);
        }
        .widget-<?php echo $_widget_class; ?> .schedule-content {
            display: grid;
            grid-template-columns: 1fr;
            gap: var(--space-3xl);
        }
        @media (min-width: 750px) {
            .widget-<?php echo $_widget_class; ?> .schedule-content:not(.no-sidebar) {
                grid-template-columns: 7fr 3fr;
                gap: var(--space-3xl);
            }
            .widget-<?php echo $_widget_class; ?>.layout-reverse .schedule-content:not(.no-sidebar) {
                grid-template-columns: 3fr 7fr;
            }
            .widget-<?php echo $_widget_class; ?>.layout-reverse .schedule-table-wrapper {
                order: 2;
            }
            .widget-<?php echo $_widget_class; ?>.layout-reverse .schedule-info {
                order: 1;
            }
        }
    </style>

    <div class="widget-container">
        <div class="widget-content widget-content-md">
            <div class="widget-header">
                <?php if ($_eyebrow): ?>
                <span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0"><?php echo $_eyebrow; ?></span>
                <?php endif; ?>
                <?php if ($_title): ?>
                <h1 class="w-headline reveal reveal-up" style="--reveal-delay: 1"><?php echo $_title; ?></h1>
                <?php endif; ?>
                <?php if ($_description): ?>
                <p class="w-description reveal reveal-up" style="--reveal-delay: 2"><?php echo $_description; ?></p>
                <?php endif; ?>
            </div>

            <div class="schedule-content<?php echo $_no_sidebar_class; ?>">
                <div class="schedule-table-wrapper">
                    <div class="schedule-list">
                        <?php echo $_schedule_rows_html; ?>
                    </div>
                    <?php if ($_note): ?>
                    <p class="schedule-note w-meta t-sm"><?php echo $_note; ?></p>
                    <?php endif; ?>
                </div>

                <?php if ($_info_blocks_html): ?>
                <div class="schedule-info">
                    <?php echo $_info_blocks_html; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
// ── Inline JS for is-today ────────────────────────────────────────────────────
$_js = <<<JSEOF
<script>
(function() {
    var widget = document.getElementById("{$_widget_id}");
    if (!widget || widget.dataset.sctInit) return;
    widget.dataset.sctInit = "true";

    var weekStart = widget.dataset.weekStart || "monday";
    var weekStartDay = (weekStart === "sunday") ? 0 : 1;
    var jsDay = new Date().getDay();
    var today = (jsDay - weekStartDay + 7) % 7;

    var rows = widget.querySelectorAll(".schedule-row");
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        if (parseInt(row.getAttribute("data-day-index"), 10) === today) {
            row.classList.add("is-today");
        }
    }
})();
</script>
JSEOF;

echo $_js;