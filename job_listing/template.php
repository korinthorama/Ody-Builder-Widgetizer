<?php
/*
 * Widgetizer — Job Listing Widget — template.php
 * Prefix: jbl
 */
defined('CMS') or die("This file cannot run this way!");

// ── Base assets ───────────────────────────────────────────────────────────────
$_wdg_assets = 'admin/builder_widget_assets/';
$_wdg_css    = $_wdg_assets . 'base.css';
$_wdg_js     = $_wdg_assets . 'scripts.js';
if (!in_array($_wdg_css, $document->loadedFiles)) {
    echo '<link href="' . $_wdg_css . '" rel="stylesheet" type="text/css">' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_css;
}
if (!in_array($_wdg_js, $document->loadedFiles)) {
    echo '<script src="' . $_wdg_js . '" defer></script>' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_js;
}

// ── Params ────────────────────────────────────────────────────────────────────
$_widget_id    = 'widget_' . $blockID;
$_eyebrow      = htmlspecialchars($wdg_params['eyebrow']      ?? '');
$_title        = htmlspecialchars($wdg_params['title']        ?? '');
$_description  = htmlspecialchars($wdg_params['description']  ?? '');
$_header_align = $wdg_params['header_align']                  ?? 'start';
$_show_filters = ($wdg_params['show_filters'] ?? '1') === '1';
$_color        = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');
$_jobs_raw     = $wdg_params['jobs']                          ?? '[]';
$_jobs         = json_decode($_jobs_raw, true);
if (!is_array($_jobs)) $_jobs = [];

$_emp_type_labels = [
    'full-time'  => t('Πλήρης Απασχόληση'),
    'part-time'  => t('Μερική Απασχόληση'),
    'contract'   => t('Σύμβαση'),
    'internship' => t('Πρακτική Άσκηση'),
];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

// Unique departments για filters
$_departments = [];
foreach ($_jobs as $_job) {
    $_dk = $_job['department']       ?? '';
    $_dl = $_job['department_label'] ?? $_dk;
    if ($_dk && !isset($_departments[$_dk])) $_departments[$_dk] = $_dl;
}

// SVG icons
$_svg_dept = '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" stroke="currentColor" stroke-width="2"/></svg>';
$_svg_loc  = '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2"/></svg>';
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-job-listings widget-<?php echo $_widget_id; ?> <?php echo $_color; ?> widget-heading-align-<?php echo htmlspecialchars($_header_align); ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="job-listing"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?> .job-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: var(--space-md);
}
.widget-<?php echo $_widget_id; ?> .widget-card {
    display: flex;
    flex-direction: column;
    gap: var(--space-md);
}
.widget-<?php echo $_widget_id; ?> .widget-card.is-hidden {
    display: none;
}
.widget-<?php echo $_widget_id; ?> .job-header {
    display: flex;
    flex-direction: column;
    gap: var(--space-sm);
}
.widget-<?php echo $_widget_id; ?> .job-meta {
    display: flex;
    align-items: center;
    gap: var(--space-md);
    flex-wrap: wrap;
}
.widget-<?php echo $_widget_id; ?> .job-meta-item {
    display: flex;
    align-items: center;
    gap: var(--space-xs);
}
.widget-<?php echo $_widget_id; ?> .job-meta-item svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    stroke-width: 2px;
    flex-shrink: 0;
}
.widget-<?php echo $_widget_id; ?> .job-badge {
    padding: var(--space-xs) var(--space-md);
    background-color: var(--bg-secondary) !important;
    border: var(--border-width-thin) solid var(--border-color);
    border-radius: var(--radius-sm);
}
@media (min-width: 750px) {
    .widget-<?php echo $_widget_id; ?> .widget-card {
        padding: var(--space-2xl);
    }
}
@media (min-width: 990px) {
    .widget-<?php echo $_widget_id; ?> .widget-card-content {
        flex-direction: row;
        align-items: center;
        gap: var(--space-xl);
        display: flex;
    }
    .widget-<?php echo $_widget_id; ?> .job-header {
        flex: 1;
        flex-direction: row;
        align-items: center;
        gap: var(--space-xl);
    }
    .widget-<?php echo $_widget_id; ?> .w-title {
        min-width: 250px;
        flex-shrink: 0;
    }
    .widget-<?php echo $_widget_id; ?> .job-meta {
        flex: 1;
    }
}
.widget-<?php echo $_widget_id; ?>.color-scheme-standard-secondary .widget-card,
.widget-<?php echo $_widget_id; ?>.color-scheme-highlight-secondary .widget-card {
    background-color: var(--bg-secondary) !important;
}
.widget-<?php echo $_widget_id; ?>.color-scheme-standard-secondary .widget-card,
.widget-<?php echo $_widget_id; ?>.color-scheme-highlight-primary .widget-card,
.widget-<?php echo $_widget_id; ?>.color-scheme-highlight-secondary .widget-card {
    border: var(--border-width-thin) solid var(--border-color);
}
.widget-<?php echo $_widget_id; ?> .job-filter-list {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-md);
    justify-content: center;
    margin-block-end: var(--space-2xl);
    padding: 0;
    list-style: none;
}
.widget-<?php echo $_widget_id; ?>.widget-heading-align-left .job-filter-list {
    justify-content: flex-start;
}
.widget-<?php echo $_widget_id; ?> .job-filter-btn {
    padding: var(--space-sm) var(--space-lg);
    font-family: inherit;
    background-color: var(--bg-primary) !important;
    border: var(--border-width-thin) solid var(--border-color);
    border-radius: var(--radius-button);
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s;
}
.widget-<?php echo $_widget_id; ?> .job-filter-btn:hover,
.widget-<?php echo $_widget_id; ?> .job-filter-btn.is-active {
    background-color: var(--text-heading) !important;
    color: var(--bg-primary) !important;
    border-color: var(--text-heading) !important;
}
.widget-<?php echo $_widget_id; ?> .job-filter-btn:focus {
    outline: var(--border-width-medium) solid var(--border-color);
    outline-offset: 2px;
}
</style>

    <div class="widget-container">

        <?php if ($_eyebrow || $_title || $_description): ?>
        <div class="widget-header widget-header--align-<?php echo htmlspecialchars($_header_align); ?>">
            <?php if ($_eyebrow): ?>
            <span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0"><?php echo $_eyebrow; ?></span>
            <?php endif; ?>
            <?php if ($_title): ?>
            <h2 class="w-headline reveal reveal-up" style="--reveal-delay: 1"><?php echo $_title; ?></h2>
            <?php endif; ?>
            <?php if ($_description): ?>
            <p class="w-description reveal reveal-up" style="--reveal-delay: 2"><?php echo $_description; ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ($_show_filters && !empty($_departments)): ?>
        <ul class="job-filter-list" role="group" aria-label="Job filters">
            <li>
                <button type="button" class="job-filter-btn w-label t-sm is-active" data-filter="all" aria-pressed="true">
                    <?php echo t('Όλες οι θέσεις'); ?>
                </button>
            </li>
            <?php foreach ($_departments as $_dk => $_dl): ?>
            <li>
                <button type="button" class="job-filter-btn w-label t-sm" data-filter="<?php echo htmlspecialchars($_dk); ?>" aria-pressed="false">
                    <?php echo htmlspecialchars($_dl); ?>
                </button>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <div class="widget-content">
            <ul class="job-list">
                <?php foreach ($_jobs as $i => $_job):
                    $_j_title    = htmlspecialchars($_job['title']            ?? '');
                    $_j_dept_key = htmlspecialchars($_job['department']       ?? '');
                    $_j_dept_lbl = htmlspecialchars($_job['department_label'] ?? $_j_dept_key);
                    $_j_location = htmlspecialchars($_job['location']         ?? '');
                    $_j_emp_type = $_job['employment_type']                   ?? 'full-time';
                    $_j_emp_lbl  = htmlspecialchars($_emp_type_labels[$_j_emp_type] ?? $_j_emp_type);
                    $_j_btn_lbl  = htmlspecialchars($_job['btn_label']        ?? t('Υποβολή Αίτησης'));
                    $_j_btn_url  = htmlspecialchars(wdg_parse_links($_job['btn_url'] ?? ''));
                    $_j_new_tab  = ($_job['btn_new_tab'] ?? '0') === '1';
                    $_j_target   = $_j_new_tab ? 'target="_blank" rel="noopener noreferrer"' : 'target="_self"';
                    $_block_id   = $_widget_id . '_job' . $i;
                ?>
                <li class="widget-card reveal reveal-up" style="--reveal-delay: <?php echo $i; ?>" data-department="<?php echo $_j_dept_key; ?>" data-block-id="<?php echo $_block_id; ?>">
                    <div class="widget-card-content">
                        <div class="job-header">
                            <h3 class="w-title t-2xl"><?php echo $_j_title; ?></h3>
                            <div class="job-meta w-meta">
                                <?php if ($_j_dept_lbl): ?>
                                <span class="job-meta-item">
                                    <?php echo $_svg_dept; ?>
                                    <span><?php echo $_j_dept_lbl; ?></span>
                                </span>
                                <?php endif; ?>
                                <?php if ($_j_location): ?>
                                <span class="job-meta-item">
                                    <?php echo $_svg_loc; ?>
                                    <span><?php echo $_j_location; ?></span>
                                </span>
                                <?php endif; ?>
                                <span class="job-badge w-label t-xs"><?php echo $_j_emp_lbl; ?></span>
                            </div>
                        </div>
                        <?php if ($_j_btn_lbl && $_j_btn_url): ?>
                        <div class="widget-card-footer">
                            <a href="<?php echo $_j_btn_url; ?>" class="widget-button" <?php echo $_j_target; ?>><?php echo $_j_btn_lbl; ?></a>
                        </div>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
<?php
$_widget_id_js = 'widget_' . $blockID;
$_script = <<<JSEOF
<script>
(function () {
    var widgetElement = document.getElementById("{$_widget_id_js}");
    if (!widgetElement || widgetElement.dataset.jblInit) return;
    widgetElement.dataset.jblInit = "true";

    var filterButtons = Array.prototype.slice.call(widgetElement.querySelectorAll(".job-filter-btn"));
    var jobItems      = Array.prototype.slice.call(widgetElement.querySelectorAll(".widget-card"));

    function filterJobs(filter) {
        jobItems.forEach(function (item) {
            var department = item.getAttribute("data-department");
            if (filter === "all" || department === filter) {
                item.classList.remove("is-hidden");
            } else {
                item.classList.add("is-hidden");
            }
        });
    }

    filterButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            var filter = this.getAttribute("data-filter");
            filterButtons.forEach(function (btn) {
                btn.classList.remove("is-active");
                btn.setAttribute("aria-pressed", "false");
            });
            this.classList.add("is-active");
            this.setAttribute("aria-pressed", "true");
            filterJobs(filter);
        });
    });
})();
</script>
JSEOF;
echo $_script;
?>
