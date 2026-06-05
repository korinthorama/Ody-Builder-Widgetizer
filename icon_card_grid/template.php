<?php
/*
 * Widgetizer — Icon Card Grid Widget — template.php
 * Prefix: icg
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
$_eyebrow     = htmlspecialchars($wdg_params['eyebrow']       ?? '');
$_title       = htmlspecialchars($wdg_params['title']         ?? '');
$_description = htmlspecialchars($wdg_params['description']   ?? '');
$_color       = htmlspecialchars($wdg_params['color_scheme']  ?? 'color-scheme-standard-primary');
$_cols        = (int)($wdg_params['columns']                  ?? 4);
$_card_layout = $wdg_params['card_layout']                    ?? 'box';
$_icon_style  = htmlspecialchars($wdg_params['icon_style']    ?? 'w-icon-plain');
$_icon_size   = htmlspecialchars($wdg_params['icon_size']     ?? 'w-icon-lg');
$_icon_shape  = htmlspecialchars($wdg_params['icon_shape']    ?? 'w-icon-sharp');
$_btn_style   = htmlspecialchars($wdg_params['btn_style']     ?? 'widget-button-secondary');
$_items       = $wdg_params['items'] ?? [];

$_icon_span_cls = trim($_icon_style . ' ' . $_icon_shape . ' ' . $_icon_size);

$_icon_font_size_map = [
    'w-icon-sm' => '22px',
    'w-icon-md' => '29px',
    'w-icon-lg' => '40px',
    'w-icon-xl' => '48px',
];
$_icon_font_size = $_icon_font_size_map[$_icon_size] ?? '40px';

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_layout_class  = ($_card_layout === 'flat') ? ' card-layout-flat' : '';
$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

if (!function_exists('wdg_parse_links')) {
    function wdg_parse_links($url) {
        if (!$url) return '#';
        return str_replace(['««', '»»', '~|||~'], ['', '', '&'], $url);
    }
}
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-type-icon-card-grid widget-<?php echo $_widget_id; ?> <?php echo $_color . $_layout_class; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="icon-card-grid"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?>:not(.card-layout-flat).color-scheme-standard-secondary .widget-card,
.widget-<?php echo $_widget_id; ?>:not(.card-layout-flat).color-scheme-highlight-secondary .widget-card {
    background-color: var(--bg-secondary);
}
.widget-<?php echo $_widget_id; ?>:not(.card-layout-flat).color-scheme-standard-secondary .widget-card,
.widget-<?php echo $_widget_id; ?>:not(.card-layout-flat).color-scheme-highlight-primary .widget-card,
.widget-<?php echo $_widget_id; ?>:not(.card-layout-flat).color-scheme-highlight-secondary .widget-card {
    border: var(--border-width-thin) solid var(--border-color);
}
</style>

    <div class="widget-container">

        <?php if ($_eyebrow || $_title || $_description): ?>
        <div class="widget-header">
            <?php if ($_eyebrow): ?>
            <span class="w-eyebrow"><?php echo $_eyebrow; ?></span>
            <?php endif; ?>
            <?php if ($_title): ?>
            <h2 class="w-headline"><?php echo $_title; ?></h2>
            <?php endif; ?>
            <?php if ($_description): ?>
            <p class="w-description"><?php echo $_description; ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="widget-content">
            <ul class="widget-card-grid widget-grid" style="--grid-cols-desktop: <?php echo $_cols; ?>">
                <?php foreach ($_items as $i => $_card):
                    $_icon_class = htmlspecialchars($_card['icon_class']  ?? '');
                    $_c_subtitle = htmlspecialchars($_card['subtitle']    ?? '');
                    $_c_title    = htmlspecialchars($_card['title']       ?? '');
                    $_c_desc     = htmlspecialchars($_card['description'] ?? '');
                    $_c_btn_lbl  = htmlspecialchars($_card['btn_label']   ?? '');
                    $_c_btn_url  = htmlspecialchars(wdg_parse_links($_card['btn_url'] ?? ''));
                    $_c_new_tab  = ($_card['btn_new_tab'] ?? '0') === '1';
                    $_btn_target = $_c_new_tab ? 'target="_blank" rel="noopener noreferrer"' : 'target="_self"';
                ?>
                <li class="widget-card reveal reveal-up" style="--reveal-delay: <?php echo $i; ?>" data-block-id="<?php echo $_widget_id; ?>_card<?php echo $i; ?>">
                    <div class="widget-card-content">
                        <?php if ($_icon_class): ?>
                        <span class="<?php echo $_icon_span_cls; ?>">
                            <i class="fa <?php echo $_icon_class; ?> w-icon" style="font-size: <?php echo $_icon_font_size; ?>;"></i>
                        </span>
                        <?php endif; ?>
                        <?php if ($_c_subtitle): ?>
                        <span class="w-eyebrow"><?php echo $_c_subtitle; ?></span>
                        <?php endif; ?>
                        <?php if ($_c_title): ?>
                        <h2 class="w-title t-xl"><?php echo $_c_title; ?></h2>
                        <?php endif; ?>
                        <?php if ($_c_desc): ?>
                        <div class="w-body w-rte t-sm"><p><?php echo $_c_desc; ?></p></div>
                        <?php endif; ?>
                        <?php if ($_c_btn_lbl && $_c_btn_url): ?>
                        <div class="widget-card-footer">
                            <a href="<?php echo $_c_btn_url; ?>" class="widget-button <?php echo $_btn_style; ?>" <?php echo $_btn_target; ?>><?php echo $_c_btn_lbl; ?></a>
                        </div>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>
</section>
