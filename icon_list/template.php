<?php
/*
 * Widgetizer — Icon List Widget — template.php
 * Prefix: iclst
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

// ── Font Awesome — DOM-check loader ───────────────────────────────────────────
?>
<script>
(function(){
    if (!document.querySelector('link[href*="font-awesome"]')) {
        var l = document.createElement('link');
        l.rel  = 'stylesheet';
        l.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css';
        document.head.appendChild(l);
    }
})();
</script>
<?php

// ── Params ────────────────────────────────────────────────────────────────────
$_widget_id   = 'widget_' . $blockID;
$_eyebrow     = htmlspecialchars($wdg_params['eyebrow']        ?? '');
$_title       = htmlspecialchars($wdg_params['title']          ?? '');
$_description = htmlspecialchars($wdg_params['description']    ?? '');
$_h_align     = htmlspecialchars($wdg_params['header_align']   ?? 'center');
$_color       = htmlspecialchars($wdg_params['color_scheme']   ?? 'color-scheme-standard-primary');
$_cols        = (int)($wdg_params['columns']                   ?? 6);
$_icon_style  = htmlspecialchars($wdg_params['icon_style']     ?? 'w-icon-plain');
$_icon_size   = htmlspecialchars($wdg_params['icon_size']      ?? 'w-icon-xl');
$_icon_shape  = htmlspecialchars($wdg_params['icon_shape']     ?? 'w-icon-circle');
$_items       = $wdg_params['items'] ?? [];

$_icon_span_cls = trim($_icon_style . ' ' . $_icon_shape . ' ' . $_icon_size);

$_icon_font_size_map = [
    'w-icon-sm' => '22px',
    'w-icon-md' => '29px',
    'w-icon-lg' => '40px',
    'w-icon-xl' => '48px',
];
$_icon_font_size = $_icon_font_size_map[$_icon_size] ?? '48px';

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-icon-list widget-<?php echo $_widget_id; ?> <?php echo $_color; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="icon-list"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?> .icon-list-grid {
    list-style: none;
    padding: 0;
    margin: 0;
    row-gap: var(--space-xl);
    column-gap: var(--space-lg);
    grid-template-columns: repeat(2, minmax(0, 1fr));
}
@media (min-width: 750px) {
    .widget-<?php echo $_widget_id; ?> .icon-list-grid {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
}
@media (min-width: 990px) {
    .widget-<?php echo $_widget_id; ?> .icon-list-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}
@media (min-width: 1200px) {
    .widget-<?php echo $_widget_id; ?> .icon-list-grid {
        grid-template-columns: repeat(var(--grid-cols-desktop, 6), minmax(0, 1fr));
    }
}
.widget-<?php echo $_widget_id; ?> .icon-list-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: var(--space-sm);
}
.widget-<?php echo $_widget_id; ?> .icon-list-title {
    margin: 0;
    color: var(--text-heading);
}
</style>

    <div class="widget-container">

        <?php if ($_eyebrow || $_title || $_description): ?>
        <div class="widget-header widget-header--align-<?php echo $_h_align; ?>">
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
            <ul class="icon-list-grid widget-grid" style="--grid-cols-desktop: <?php echo $_cols; ?>">
                <?php foreach ($_items as $i => $_item):
                    $_icon_class = htmlspecialchars($_item['icon_class']  ?? '');
                    $_i_title    = htmlspecialchars($_item['title']       ?? '');
                    $_i_desc     = htmlspecialchars($_item['description'] ?? '');
                ?>
                <li class="icon-list-item reveal reveal-up" style="--reveal-delay: <?php echo $i; ?>" data-block-id="<?php echo $_widget_id; ?>_item<?php echo $i; ?>">
                    <?php if ($_icon_class): ?>
                    <span class="<?php echo $_icon_span_cls; ?>">
                        <i class="fa <?php echo $_icon_class; ?> w-icon" style="font-size: <?php echo $_icon_font_size; ?>;"></i>
                    </span>
                    <?php endif; ?>
                    <?php if ($_i_title): ?>
                    <span class="icon-list-title t-heading-font"><?php echo $_i_title; ?></span>
                    <?php endif; ?>
                    <?php if ($_i_desc): ?>
                    <span class="icon-list-description w-body t-muted t-sm"><?php echo $_i_desc; ?></span>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>
</section>
