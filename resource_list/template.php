<?php
/*
 * Widgetizer — Resource List Widget — template.php
 * Prefix: rlst
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
    echo '<script src="' . $_wdg_js . '"></script>' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_js;
}

// ── Params ────────────────────────────────────────────────────────────────────
$_widget_id      = 'widget_' . $blockID;
$_eyebrow        = htmlspecialchars($wdg_params['eyebrow']         ?? '');
$_title          = htmlspecialchars($wdg_params['title']           ?? '');
$_description    = htmlspecialchars($wdg_params['description']     ?? '');
$_header_align   = $wdg_params['header_align']                     ?? 'center';
$_image_position = $wdg_params['image_position']                   ?? 'start';
$_image          = $wdg_params['image']                            ?? '';
$_color          = htmlspecialchars($wdg_params['color_scheme']    ?? 'color-scheme-standard-primary');
$_items          = $wdg_params['items']                            ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_has_image      = !empty($_image);
$_align_class    = ($_header_align === 'left') ? ' widget-heading-align-left' : '';
$_position_class = ($_image_position === 'end') ? ' layout-image-end' : '';
$_wrapper_class  = 'resource-list-wrapper' . ($_has_image ? ' has-image' : '');

$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-resource-list widget-<?php echo $_widget_id; ?> <?php echo $_color . $_align_class . $_position_class; ?> no_collapse"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="resource-list"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?> .resource-list-wrapper {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-3xl);
}
.widget-<?php echo $_widget_id; ?> .resource-list-image {
    width: 100%;
}
.widget-<?php echo $_widget_id; ?> .resource-list-image img {
    width: 100%;
    height: auto;
    display: block;
    border: var(--border-width-thin) solid var(--border-color);
    border-radius: var(--radius-lg);
}
.widget-<?php echo $_widget_id; ?> .resource-items {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: var(--space-md);
}
.widget-<?php echo $_widget_id; ?> .resource-item {
    padding: var(--space-lg);
    background-color: var(--bg-primary);
    border: var(--border-width-thin) solid var(--border-color);
    border-radius: var(--radius-sm);
}
.widget-<?php echo $_widget_id; ?>.color-scheme-standard-secondary .resource-item,
.widget-<?php echo $_widget_id; ?>.color-scheme-highlight-secondary .resource-item {
    background-color: var(--bg-secondary);
}
.widget-<?php echo $_widget_id; ?> .resource-item-title {
    margin: 0;
}
.widget-<?php echo $_widget_id; ?> .resource-item-description {
    margin-top: var(--space-xs);
}
.widget-<?php echo $_widget_id; ?> .resource-item-action {
    margin-top: var(--space-sm);
}
@media (min-width: 990px) {
    .widget-<?php echo $_widget_id; ?> .resource-list-wrapper.has-image {
        grid-template-columns: 1fr 1fr;
        align-items: start;
        gap: var(--space-3xl);
    }
    .widget-<?php echo $_widget_id; ?>.layout-image-end .resource-list-wrapper.has-image {
        direction: rtl;
    }
    .widget-<?php echo $_widget_id; ?>.layout-image-end .resource-list-wrapper.has-image > * {
        direction: ltr;
    }
    .widget-<?php echo $_widget_id; ?> .resource-list-image {
        position: sticky;
        top: var(--space-2xl);
    }
}
</style>

    <div class="widget-container">

        <?php if ($_eyebrow || $_title || $_description): ?>
        <div class="widget-header">
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
            <div class="<?php echo $_wrapper_class; ?>">

                <?php if ($_has_image): ?>
                <div class="resource-list-image reveal reveal-fade">
                    <img src="<?php echo htmlspecialchars($_image); ?>" alt="" loading="lazy">
                </div>
                <?php endif; ?>

                <ul class="resource-items">
                    <?php foreach ($_items as $i => $_item):
                        $_item_title   = htmlspecialchars($_item['title']       ?? '');
                        $_item_desc    = htmlspecialchars($_item['description'] ?? '');
                        $_item_btn_lbl = htmlspecialchars($_item['btn_label']   ?? '');
                        $_item_btn_url = 'mediabank/' . ($_item['btn_url'] ?? '');
                        $_item_filename = htmlspecialchars($_item['btn_url']    ?? '');
                    ?>
                    <li class="resource-item reveal reveal-up" style="--reveal-delay: <?php echo $i; ?>" data-block-id="<?php echo $_widget_id; ?>_item<?php echo $i; ?>">
                        <div class="resource-item-content">
                            <?php if ($_item_title): ?>
                            <h3 class="resource-item-title w-title t-lg t-heading-font"><?php echo $_item_title; ?></h3>
                            <?php endif; ?>
                            <?php if ($_item_desc): ?>
                            <p class="resource-item-description w-body t-sm t-muted"><?php echo $_item_desc; ?></p>
                            <?php endif; ?>
                            <?php if ($_item_btn_lbl && $_item_btn_url): ?>
                            <div class="resource-item-action">
                                <a href="<?php echo htmlspecialchars($_item_btn_url); ?>" class="widget-button widget-button-secondary widget-button-small" download="<?php echo $_item_filename; ?>"><?php echo $_item_btn_lbl; ?></a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>

            </div>
        </div>
    </div>
</section>
