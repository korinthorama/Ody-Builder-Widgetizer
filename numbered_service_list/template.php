<?php
/*
 * Widgetizer — Numbered Service List Widget — template.php
 * Prefix: nsl
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
$_widget_id     = 'widget_' . $blockID;
$_eyebrow       = htmlspecialchars($wdg_params['eyebrow']      ?? '');
$_title         = htmlspecialchars($wdg_params['title']        ?? '');
$_description   = htmlspecialchars($wdg_params['description']  ?? '');
$_color         = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');
$_alignment     = $wdg_params['alignment']                     ?? 'center';
$_show_numbers  = ($wdg_params['show_numbers']  ?? '1') === '1';
$_show_dividers = ($wdg_params['show_dividers'] ?? '1') === '1';
$_nsl_items     = $wdg_params['items']                         ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_alignment_class = ($_alignment === 'center') ? 'widget-header--align-center' : 'widget-header--align-start';
$_section_style   = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

// ── CSS overrides για dividers + numbers ──────────────────────────────────────
$_extra_css = '';
if (!$_show_dividers) {
    $_extra_css .= '.widget-' . $_widget_id . ' .service-list { border-block-start: none !important; }' . PHP_EOL;
    $_extra_css .= '.widget-' . $_widget_id . ' .service-item { border-block-end: none !important; }' . PHP_EOL;
}
if (!$_show_numbers) {
    $_extra_css .= '.widget-' . $_widget_id . ' .service-number { display: none !important; }' . PHP_EOL;
    $_extra_css .= '@media (min-width: 750px) {' . PHP_EOL;
    $_extra_css .= '  .widget-' . $_widget_id . ' .service-row { grid-template-columns: minmax(180px, 320px) minmax(0, 1fr) 70px !important; }' . PHP_EOL;
    $_extra_css .= '}' . PHP_EOL;
}

$_arrow_svg = '<svg viewBox="0 0 24 24" fill="none">'
    . '<path d="M5 12h14" stroke-width="1.8" stroke-linecap="round"/>'
    . '<path d="M13 6l6 6-6 6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>'
    . '</svg>';
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-numbered-service-list widget-<?php echo $_widget_id; ?> <?php echo $_color; ?> no_collapse"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="numbered-service-list"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?> .service-list {
    list-style: none;
    padding: 0;
    margin: 0;
    border-block-start: var(--border-width-thin) solid var(--border-color);
}
.widget-<?php echo $_widget_id; ?> .service-item {
    border-block-end: var(--border-width-thin) solid var(--border-color);
}
.widget-<?php echo $_widget_id; ?> .service-row {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: var(--space-md) var(--space-lg);
    align-items: start;
    padding-block: var(--space-xl);
    color: inherit;
    text-decoration: none;
}
.widget-<?php echo $_widget_id; ?> .service-number {
    grid-column: 1 / -1;
    font-size: calc(var(--font-size-5xl) * var(--heading-scale));
    line-height: 1;
    color: var(--text-muted);
}
.widget-<?php echo $_widget_id; ?> .service-title-wrap {
    min-width: 0;
}
.widget-<?php echo $_widget_id; ?> .service-description-wrap {
    grid-column: 1 / -1;
    min-width: 0;
}
.widget-<?php echo $_widget_id; ?> .service-arrow {
    display: flex;
    align-items: center;
    justify-content: center;
    align-self: center;
}
.widget-<?php echo $_widget_id; ?> .service-arrow-circle {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    border: var(--border-width-thin) solid var(--border-color);
    color: var(--text-heading);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.25s ease, border-color 0.25s ease, background-color 0.25s ease, color 0.25s ease;
}
.widget-<?php echo $_widget_id; ?> .service-arrow-circle svg {
    width: 20px;
    height: 20px;
    stroke: currentColor;
}
.widget-<?php echo $_widget_id; ?> .service-row-link:hover .service-arrow-circle,
.widget-<?php echo $_widget_id; ?> .service-row-link:focus-visible .service-arrow-circle {
    background-color: var(--text-heading);
    border-color: var(--text-heading);
    color: var(--bg-primary);
    transform: translateX(2px);
}
.widget-<?php echo $_widget_id; ?> .service-row-link:focus-visible {
    outline: none;
}
.widget-<?php echo $_widget_id; ?> .service-row-link:focus-visible .service-title {
    text-decoration: underline;
    text-underline-offset: 2px;
}
@media (min-width: 750px) {
    .widget-<?php echo $_widget_id; ?> .service-row {
        grid-template-columns: 100px minmax(180px, 320px) minmax(0, 1fr) 70px;
        gap: var(--space-xl);
        align-items: center;
        padding-block: var(--space-2xl);
    }
    .widget-<?php echo $_widget_id; ?> .service-number {
        grid-column: auto;
    }
    .widget-<?php echo $_widget_id; ?> .service-description-wrap {
        grid-column: auto;
    }
    .widget-<?php echo $_widget_id; ?> .service-arrow {
        justify-self: end;
    }
}
<?php echo $_extra_css; ?>
</style>

    <div class="widget-container">

        <?php if ($_eyebrow || $_title || $_description): ?>
        <div class="widget-header <?php echo $_alignment_class; ?>">
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

        <div class="widget-content">
            <ul class="service-list">
                <?php foreach ($_nsl_items as $i => $_item):
                    $_ititle = htmlspecialchars($_item['title']       ?? '');
                    $_idesc  = htmlspecialchars($_item['description'] ?? '');
                    $_iurl   = htmlspecialchars(wdg_parse_links($_item['url'] ?? ''));
                    $_itab   = ($_item['new_tab'] ?? '0') === '1';
                    $_blk_id = $_widget_id . '_svc' . $i;
                    $_num    = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
                ?>
                <li class="service-item reveal reveal-up" style="--reveal-delay: <?php echo $i; ?>" data-block-id="<?php echo $_blk_id; ?>">
                    <?php if ($_iurl): ?>
                    <a href="<?php echo $_iurl; ?>" class="service-row service-row-link" aria-label="Learn More" <?php echo $_itab ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                    <?php else: ?>
                    <div class="service-row">
                    <?php endif; ?>

                        <?php if ($_show_numbers): ?>
                        <div class="service-number"><?php echo $_num; ?></div>
                        <?php endif; ?>

                        <div class="service-title-wrap">
                            <h3 class="service-title w-title t-2xl"><?php echo $_ititle; ?></h3>
                        </div>

                        <?php if ($_idesc): ?>
                        <div class="service-description-wrap">
                            <div class="w-body w-rte t-sm"><p><?php echo nl2br($_idesc); ?></p></div>
                        </div>
                        <?php endif; ?>

                        <?php if ($_iurl): ?>
                        <span class="service-arrow" aria-hidden="true">
                            <span class="service-arrow-circle"><?php echo $_arrow_svg; ?></span>
                        </span>
                    </a>
                    <?php else: ?>
                    </div>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
