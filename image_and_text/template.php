<?php
/*
 * Widgetizer — Image + Text Widget — template.php
 * Prefix: it
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
$_widget_id      = 'widget_' . $blockID;
$_eyebrow        = htmlspecialchars($wdg_params['eyebrow']              ?? '');
$_headline       = htmlspecialchars($wdg_params['headline']             ?? '');
$_body           = $wdg_params['body']                                  ?? '';
$_image          = $wdg_params['image']                                 ?? '';
$_image_position = $wdg_params['image_position']                       ?? 'left';
$_text_align_y   = htmlspecialchars($wdg_params['text_align_y']        ?? 'flex-start');
$_content_cs     = $wdg_params['content_color_scheme']                 ?? 'none';
$_color          = htmlspecialchars($wdg_params['color_scheme']        ?? 'color-scheme-standard-primary');
$_has_content_cs = ($_content_cs !== 'none');

$_btn1_label   = htmlspecialchars($wdg_params['btn1_label']            ?? '');
$_btn1_url     = htmlspecialchars(wdg_parse_links($wdg_params['btn1_url'] ?? ''));
$_btn1_style   = htmlspecialchars($wdg_params['btn1_style']            ?? 'widget-button-primary');
$_btn1_new_tab = ($wdg_params['btn1_new_tab'] ?? '0') === '1';

$_btn2_label   = htmlspecialchars($wdg_params['btn2_label']            ?? '');
$_btn2_url     = htmlspecialchars(wdg_parse_links($wdg_params['btn2_url'] ?? ''));
$_btn2_style   = htmlspecialchars($wdg_params['btn2_style']            ?? 'widget-button-secondary');
$_btn2_new_tab = ($wdg_params['btn2_new_tab'] ?? '0') === '1';

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_layout_cls    = ($_image_position === 'right') ? ' layout-image-end' : '';
$_has_cs_cls    = $_has_content_cs ? ' has-content-color-scheme' : '';
$_section_style = '--text-align-y: ' . $_text_align_y . '; padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

$_image_css = $_image ? str_replace(['"', "'"], '', $_image) : '';
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-type-image-text widget-<?php echo $_widget_id; ?> <?php echo $_color . $_layout_cls . $_has_cs_cls; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="image-text"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?> .image-text-wrapper {
    display: flex;
    flex-direction: column;
    gap: var(--space-3xl);
}
.widget-<?php echo $_widget_id; ?> .image-wrapper {
    width: 100%;
}
.widget-<?php echo $_widget_id; ?> .image-wrapper img {
    width: 100%;
    height: auto;
    display: block;
    border: var(--border-width-thin) solid var(--border-color);
    border-radius: var(--radius-lg);
}
.widget-<?php echo $_widget_id; ?> .text-content-colored {
    background-color: var(--bg-primary);
    padding: var(--space-2xl);
    border-radius: var(--radius-lg);
    display: flex;
    flex-direction: column;
    justify-content: var(--text-align-y, center);
}
.widget-<?php echo $_widget_id; ?>.has-content-color-scheme .image-wrapper img {
    border: none;
    border-radius: var(--radius-lg);
}
@media (min-width: 990px) {
    .widget-<?php echo $_widget_id; ?> .text-content-colored {
        padding: var(--space-4xl);
    }
    .widget-<?php echo $_widget_id; ?>.has-content-color-scheme .image-text-wrapper {
        align-items: stretch;
        gap: 0;
    }
    .widget-<?php echo $_widget_id; ?>.has-content-color-scheme .image-wrapper img {
        height: 100%;
        object-fit: cover;
        border-radius: 0;
    }
    .widget-<?php echo $_widget_id; ?>.has-content-color-scheme .text-content-colored {
        border-radius: 0;
    }
    .widget-<?php echo $_widget_id; ?> .image-text-wrapper {
        flex-direction: row;
        gap: var(--space-4xl);
        align-items: var(--text-align-y, center);
    }
    .widget-<?php echo $_widget_id; ?> .image-wrapper,
    .widget-<?php echo $_widget_id; ?> .text-content {
        width: 50%;
    }
    .widget-<?php echo $_widget_id; ?>.layout-image-end .image-text-wrapper {
        flex-direction: row-reverse;
    }
}
</style>

    <div class="widget-container widget-container-padded">
        <div class="widget-content">
            <div class="image-text-wrapper">

                <?php if ($_image): ?>
                <div class="image-wrapper reveal reveal-fade">
                    <img
                        src="<?php echo htmlspecialchars($_image); ?>"
                        alt=""
                        class="image-text-image"
                        loading="lazy"
                    />
                </div>
                <?php endif; ?>

                <div class="text-content content-flow widget-content-align-start<?php echo $_has_content_cs ? ' text-content-colored ' . htmlspecialchars($_content_cs) : ''; ?>">

                    <?php if ($_eyebrow): ?>
                    <div class="w-body w-rte t-base t-muted reveal reveal-up" style="--reveal-delay: 0">
                        <p><?php echo $_eyebrow; ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if ($_headline): ?>
                    <h2 class="w-headline t-2xl reveal reveal-up" style="--reveal-delay: 1"><?php echo $_headline; ?></h2>
                    <?php endif; ?>

                    <?php if ($_body): ?>
                    <div class="w-body w-rte t-base reveal reveal-up" style="--reveal-delay: 2">
                        <p><?php echo htmlspecialchars($_body); ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if ($_btn1_label || $_btn2_label): ?>
                    <div class="widget-actions reveal reveal-up" style="--reveal-delay: 3">
                        <?php if ($_btn1_label && $_btn1_url): ?>
                        <a href="<?php echo $_btn1_url; ?>"
                           class="widget-button <?php echo $_btn1_style; ?>"
                           <?php echo $_btn1_new_tab ? 'target="_blank" rel="noopener noreferrer"' : 'target="_self"'; ?>>
                            <?php echo $_btn1_label; ?>
                        </a>
                        <?php endif; ?>
                        <?php if ($_btn2_label && $_btn2_url): ?>
                        <a href="<?php echo $_btn2_url; ?>"
                           class="widget-button <?php echo $_btn2_style; ?>"
                           <?php echo $_btn2_new_tab ? 'target="_blank" rel="noopener noreferrer"' : 'target="_self"'; ?>>
                            <?php echo $_btn2_label; ?>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>
