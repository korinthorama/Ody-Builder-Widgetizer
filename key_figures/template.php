<?php
/*
 * Widgetizer — Key Figures Widget — template.php
 * Prefix: kfg
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

// ── Odometer assets (DOM-check loader) ────────────────────────────────────────
$_odometer_css = $_wdg_assets . 'odometer-theme-default.css';
$_odometer_js  = $_wdg_assets . 'odometer.js';
?>
<script>
(function(){
    var cssHref = "<?php echo $_odometer_css; ?>";
    var jsHref  = "<?php echo $_odometer_js; ?>";
    var links = document.querySelectorAll("link[rel=stylesheet]");
    var cssLoaded = false;
    for (var i = 0; i < links.length; i++) { if (links[i].getAttribute("href") === cssHref) { cssLoaded = true; break; } }
    if (!cssLoaded) { var l = document.createElement("link"); l.rel = "stylesheet"; l.type = "text/css"; l.href = cssHref; document.head.appendChild(l); }
    var scripts = document.querySelectorAll("script[src]");
    var jsLoaded = false;
    for (var j = 0; j < scripts.length; j++) { if (scripts[j].getAttribute("src") === jsHref) { jsLoaded = true; break; } }
    if (!jsLoaded) {
        window.odometerOptions = { format: "d", duration: 2000 };
        var s = document.createElement("script");
        s.src = jsHref;
        s.onload = function() { document.dispatchEvent(new CustomEvent("odometer:ready")); };
        document.head.appendChild(s);
    } else {
        document.dispatchEvent(new CustomEvent("odometer:ready"));
    }
})();
</script>
<?php

// ── Params ────────────────────────────────────────────────────────────────────
$_widget_id   = 'widget_' . $blockID;
$_eyebrow     = htmlspecialchars($wdg_params['eyebrow']      ?? '');
$_title       = htmlspecialchars($wdg_params['title']        ?? '');
$_description = htmlspecialchars($wdg_params['description']  ?? '');
$_cols        = (int)($wdg_params['columns']    ?? 4);
$_card_layout = $wdg_params['card_layout']       ?? 'box';
$_color       = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');
$_items_raw   = $wdg_params['items']             ?? '[]';
$_items       = is_array($_items_raw) ? $_items_raw : json_decode($_items_raw, true);
if (!is_array($_items)) $_items = [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_layout_cls    = ($_card_layout === 'flat') ? ' card-layout-flat' : '';
$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-type-key-figures widget-<?php echo $_widget_id; ?> <?php echo $_color . $_layout_cls; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="key-figures"
    data-animate="true"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?> .widget-card {
    text-align: center;
    padding: var(--space-xl) var(--space-lg);
}
.widget-<?php echo $_widget_id; ?> .stats-number {
    font-size: calc(var(--font-size-5xl) * var(--heading-scale));
    line-height: 1;
    color: var(--text-heading) !important;
    margin: 0;
    font-variant-numeric: tabular-nums;
}
.widget-<?php echo $_widget_id; ?> .stats-number-wrap {
    display: inline-flex;
    align-items: center; /* ΔΙΟΡΘΩΣΗ: Από baseline σε center για σταθερή στοίχιση */
    justify-content: center;
    gap: var(--space-xs);
    flex-wrap: wrap;
    margin-block-end: var(--space-sm);
}
.widget-<?php echo $_widget_id; ?> .stats-suffix {
    font-size: calc(var(--font-size-5xl) * var(--heading-scale));
    line-height: 1;
    color: var(--text-heading) !important;
    font-weight: normal;
    display: inline-block; /* ΔΙΟΡΘΩΣΗ: Προσθήκη για καλύτερο έλεγχο του box μοντέλου */
}
.widget-<?php echo $_widget_id; ?> .odometer {
    display: inline-block; /* ΔΙΟΡΘΩΣΗ: Από inline-flex σε inline-block για αποφυγή bugs με το overflow */
    line-height: 1;
    vertical-align: middle;
}
.widget-<?php echo $_widget_id; ?> .odometer-digit {
    display: inline-block;
    height: 1em;
    overflow: hidden;
}
.widget-<?php echo $_widget_id; ?> .odometer-strip {
    display: flex;
    flex-direction: column;
    transform: translateY(0);
    transition: transform var(--odometer-duration, 1200ms) cubic-bezier(0.16, 1, 0.3, 1);
    transition-delay: var(--odometer-delay, 0ms);
}
.widget-<?php echo $_widget_id; ?> .odometer-strip > span {
    height: 1em;
    display: flex;
    align-items: center;
    justify-content: center;
}
.widget-<?php echo $_widget_id; ?> .odometer-digit.odometer-active .odometer-strip {
    transform: translateY(calc(var(--digit-target) * -1em));
}
@media (prefers-reduced-motion: reduce) {
    .widget-<?php echo $_widget_id; ?> .odometer-strip {
        transition: none;
    }
}
.widget-<?php echo $_widget_id; ?> .w-title {
    margin-block-end: var(--space-xs);
}
@media (min-width: 990px) {
    .widget-<?php echo $_widget_id; ?> .widget-card {
        padding: var(--space-3xl) var(--space-xl);
    }
}
@media (max-width: 989px) {
    .widget-<?php echo $_widget_id; ?> .stats-number,
    .widget-<?php echo $_widget_id; ?> .stats-suffix {
        font-size: calc(var(--font-size-4xl) * var(--heading-scale));
    }
}
@media (max-width: 640px) {
    .widget-<?php echo $_widget_id; ?> .stats-number,
    .widget-<?php echo $_widget_id; ?> .stats-suffix {
        font-size: calc(var(--font-size-3xl) * var(--heading-scale));
    }
}
.widget-<?php echo $_widget_id; ?>:not(.card-layout-flat).color-scheme-standard-secondary .widget-card,
.widget-<?php echo $_widget_id; ?>:not(.card-layout-flat).color-scheme-highlight-secondary .widget-card {
    background-color: var(--bg-secondary) !important;
}
.widget-<?php echo $_widget_id; ?>:not(.card-layout-flat).color-scheme-standard-secondary .widget-card,
.widget-<?php echo $_widget_id; ?>:not(.card-layout-flat).color-scheme-highlight-primary .widget-card,
.widget-<?php echo $_widget_id; ?>:not(.card-layout-flat).color-scheme-highlight-secondary .widget-card {
    border: var(--border-width-thin) solid var(--border-color);
}
.widget-<?php echo $_widget_id; ?>.card-layout-flat .widget-card {
    padding: 0;
}
@media (min-width: 990px) {
    .widget-<?php echo $_widget_id; ?>.card-layout-flat .widget-card {
        padding: 0;
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
            <ul class="widget-card-grid widget-grid" style="--grid-cols-desktop: <?php echo $_cols; ?>">
                <?php foreach ($_items as $i => $_item):
                    $_count    = htmlspecialchars($_item['count']       ?? '0');
                    $_suffix   = htmlspecialchars($_item['suffix']      ?? '');
                    $_label    = htmlspecialchars($_item['label']       ?? '');
                    $_desc     = htmlspecialchars($_item['description'] ?? '');
                    $_block_id = $_widget_id . '_fig' . $i;
                ?>
                <li class="widget-card reveal reveal-up" style="--reveal-delay: <?php echo $i; ?>" data-block-id="<?php echo $_block_id; ?>">
                    <div class="stats-number-wrap">
                        <span class="odometer stats-number" data-count="<?php echo $_count; ?>">0</span>
                        <?php if ($_suffix): ?>
                        <span class="stats-suffix"><?php echo $_suffix; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="widget-card-content">
                        <h3 class="w-title t-xl"><?php echo $_label; ?></h3>
                        <?php if ($_desc): ?>
                        <p class="w-body t-sm"><?php echo $_desc; ?></p>
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
    function initKfg() {
        var widget = document.getElementById("{$_widget_id_js}");
        if (!widget || widget.dataset.kfgInit) return;
        widget.dataset.kfgInit = "true";

        var elements = widget.querySelectorAll(".stats-number[data-count]");
        if (!elements.length) return;

        window.odometerOptions = { format: '(.ddd),dd', duration: 2000 };

        var odometers = [];
        elements.forEach(function(el) {
            el.innerHTML = "0";
            var od = new Odometer({ el: el, value: 0, theme: "default", duration: 2000, format: '(.ddd),dd' });
            odometers.push({ od: od, count: parseFloat(el.getAttribute("data-count")) || 0 });
        });

        var triggered = false;
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting && !triggered) {
                    triggered = true;
                    odometers.forEach(function(item) { item.od.update(item.count); });
                    observer.disconnect();
                }
            });
        }, { threshold: 0.2 });

        observer.observe(widget);
    }

    function waitForOdometerAndInit() {
        if (typeof Odometer !== "undefined") {
            initKfg();
        } else {
            document.addEventListener("odometer:ready", initKfg, { once: true });
        }
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", waitForOdometerAndInit);
    } else {
        waitForOdometerAndInit();
    }
})();
</script>
JSEOF;
echo $_script;
?>