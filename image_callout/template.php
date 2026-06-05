<?php
/*
 * Widgetizer — Image Callout Widget — template.php
 * Prefix: ic
 */
defined('CMS') or die("This file cannot run this way!");
// ── Base assets ───────────────────────────────────────────────────────────────
$_wdg_assets = 'admin/builder_widget_assets/';
$_wdg_css = $_wdg_assets . 'base.css';
$_wdg_js = $_wdg_assets . 'scripts.js';
if(!in_array($_wdg_css, $document->loadedFiles)) {
    echo '<link href="' . $_wdg_css . '" rel="stylesheet" type="text/css">' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_css;
}
if(!in_array($_wdg_js, $document->loadedFiles)) {
    echo '<script src="' . $_wdg_js . '" defer></script>' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_js;
}
// ── Params ────────────────────────────────────────────────────────────────────
$_widget_id = 'widget_' . $blockID;
$_eyebrow = htmlspecialchars($wdg_params['eyebrow'] ?? '');
$_headline = htmlspecialchars($wdg_params['headline'] ?? '');
$_body = $wdg_params['body'] ?? '';
$_features_raw = $wdg_params['features'] ?? '';
$_image = $wdg_params['image'] ?? '';
$_image_pos = $wdg_params['image_position'] ?? 'left';
$_content_cs = htmlspecialchars($wdg_params['content_color_scheme'] ?? 'color-scheme-standard-primary');
$_color = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');
$_border_width = htmlspecialchars($wdg_params['border_width'] ?? 'var(--border-width-thin)');
$_btn1_label = htmlspecialchars($wdg_params['btn1_label'] ?? '');
$_btn1_url = htmlspecialchars(wdg_parse_links($wdg_params['btn1_url'] ?? ''));
$_btn1_style = htmlspecialchars($wdg_params['btn1_style'] ?? 'widget-button-secondary');
$_btn1_new_tab = ($wdg_params['btn1_new_tab'] ?? '0') === '1';
$_btn2_label = htmlspecialchars($wdg_params['btn2_label'] ?? '');
$_btn2_url = htmlspecialchars(wdg_parse_links($wdg_params['btn2_url'] ?? ''));
$_btn2_style = htmlspecialchars($wdg_params['btn2_style'] ?? 'widget-button-secondary');
$_btn2_new_tab = ($wdg_params['btn2_new_tab'] ?? '0') === '1';
$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');
$_features = [];
if($_features_raw) {
    $_features = array_filter(array_map('trim', explode('|||', $_features_raw)));
}
$_layout_cls = ($_image_pos === 'right') ? ' layout-image-end' : '';
$_section_style = 'padding-bottom: 20px;';
if($_content_cs !== 'color-scheme-standard-primary') {
    $_section_style .= ' --widget-bg-color: var(--bg-primary);';
}
if(!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}
?>
<section
        id="<?php echo $_widget_id; ?>"
        class="widget widget-image-callout widget-<?php echo $_widget_id; ?> <?php echo $_color . $_layout_cls; ?>"
        data-widget-id="<?php echo $_widget_id; ?>"
        data-widget-type="image-callout"
        style="<?php echo $_section_style; ?>"
>
    <style>
        .widget-<?php echo $_widget_id; ?> .callout-wrapper {
            position: relative;
            display: grid;
            grid-template-columns: 1fr;
            gap: var(--space-lg);
            overflow: hidden;
        }

        .widget-<?php echo $_widget_id; ?> .callout-image-wrapper {
            position: relative;
            width: 100%;
            height: 400px;
            overflow: hidden;
        }

        .widget-<?php echo $_widget_id; ?> .callout-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border: var(--border-width-thin) solid var(--border-color);
            border-radius: var(--radius-lg);
        }

        .widget-<?php echo $_widget_id; ?> .callout-content {
            background-color: var(--bg-primary);
            padding: var(--space-xl);
            border: var(--border-width-thin) solid var(--border-color);
            border-radius: var(--radius-md);
            position: relative;
            z-index: 2;
        }

        @media (min-width: 750px) {
            .widget-<?php echo $_widget_id; ?> .callout-image-wrapper {
                height: 500px;
            }

            .widget-<?php echo $_widget_id; ?> .callout-content {
                padding: var(--space-3xl);
            }
        }

        @media (min-width: 990px) {
            .widget-<?php echo $_widget_id; ?> .callout-wrapper {
                grid-template-columns: repeat(12, 1fr);
                align-items: center;
                gap: 0;
            }

            .widget-<?php echo $_widget_id; ?> .callout-image-wrapper {
                grid-column: 1 / 7;
                grid-row: 1;
                height: 600px;
            }

            .widget-<?php echo $_widget_id; ?> .callout-content {
                grid-column: 6 / 13;
                grid-row: 1;
                padding: var(--space-4xl);
                margin-inline-start: -2rem;
            }
        }

        @media (min-width: 1200px) {
            .widget-<?php echo $_widget_id; ?> .callout-content {
                padding: var(--space-5xl);
                margin-inline-start: -3rem;
            }
        }

        .widget-<?php echo $_widget_id; ?>.layout-image-end .callout-image-wrapper {
            grid-column: 7 / 13;
            grid-row: 1;
        }

        .widget-<?php echo $_widget_id; ?>.layout-image-end .callout-content {
            grid-column: 1 / 8;
            grid-row: 1;
            margin-inline-start: 0;
            margin-inline-end: -2rem;
        }

        @media (min-width: 1200px) {
            .widget-<?php echo $_widget_id; ?>.layout-image-end .callout-content {
                margin-inline-end: -3rem;
            }
        }
    </style>
    <div class="widget-container widget-container-padded">
        <div class="callout-wrapper">
            <?php if($_image): ?>
                <div class="callout-image-wrapper reveal reveal-fade">
                    <img
                            src="<?php echo htmlspecialchars($_image); ?>"
                            alt=""
                            class="callout-image"
                            loading="lazy"
                    />
                </div>
            <?php endif; ?>
            <div class="callout-content content-flow widget-content-align-start <?php echo $_content_cs; ?>" style="border-width: <?php echo $_border_width; ?>;">
                <?php if($_eyebrow): ?>
                    <div class="w-body w-rte t-sm t-muted reveal reveal-up" style="--reveal-delay: 0"><?php echo $_eyebrow; ?></div>
                <?php endif; ?>

                <?php if($_headline): ?>
                    <h2 class="w-headline t-2xl reveal reveal-up" style="--reveal-delay: 1"><?php echo $_headline; ?></h2>
                <?php endif; ?>

                <?php if($_body): ?>
                    <div class="w-body w-rte t-base reveal reveal-up" style="--reveal-delay: 2">
                        <p><?php echo htmlspecialchars($_body); ?></p>
                    </div>
                <?php endif; ?>

                <?php if(!empty($_features)): ?>
                    <ul class="features-list reveal reveal-up" style="--reveal-delay: 3">
                        <?php foreach($_features as $_feat): ?>
                            <li class="feature-item w-body">
                        <span class="feature-icon">
                            <svg class="icon feature-icon-svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12l5 5l10 -10"/>
                            </svg>
                        </span>
                                <span><?php echo htmlspecialchars($_feat); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if($_btn1_label || $_btn2_label): ?>
                    <div class="widget-actions reveal reveal-up" style="--reveal-delay: 4">
                        <?php if($_btn1_label && $_btn1_url): ?>
                            <a href="<?php echo $_btn1_url; ?>"
                               class="widget-button <?php echo $_btn1_style; ?>"
                                    <?php echo $_btn1_new_tab ? 'target="_blank" rel="noopener noreferrer"' : 'target="_self"'; ?>>
                                <?php echo $_btn1_label; ?>
                            </a>
                        <?php endif; ?>
                        <?php if($_btn2_label && $_btn2_url): ?>
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
</section>
