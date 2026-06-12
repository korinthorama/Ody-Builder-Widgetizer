<?php
/*
 * Widgetizer — Image Tabs Widget — template.php
 * Prefix: imtb
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
$_panel_id     = 'image-tabs-panel-' . $_widget_id;
$_eyebrow      = htmlspecialchars($wdg_params['eyebrow']      ?? '');
$_title        = htmlspecialchars($wdg_params['title']        ?? '');
$_description  = htmlspecialchars($wdg_params['description']  ?? '');
$_image_pos    = $wdg_params['image_position']                ?? 'left';
$_aspect_ratio = $wdg_params['aspect_ratio']                  ?? 'contain';
$_color        = htmlspecialchars($wdg_params['color_scheme'] ?? 'color-scheme-standard-primary');
$_tabs_raw     = $wdg_params['tabs']                          ?? '[]';
$_tabs         = json_decode($_tabs_raw, true);
if (!is_array($_tabs)) $_tabs = [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_layout_cls    = ($_image_pos === 'right') ? ' layout-image-end' : '';
$_section_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

// ── Aspect ratio CSS — πιστή αντιγραφή λογικής από αρχικό template ───────────
if ($_aspect_ratio === 'auto') {
    $_img_area_extra = 'aspect-ratio: auto;';
    $_img_extra      = 'width: 100%; height: auto; object-fit: cover; display: block;';
} elseif ($_aspect_ratio === 'contain') {
    $_img_area_extra = 'aspect-ratio: auto;';
    $_img_extra      = 'width: 100%; height: 240px; max-height: 60vh; object-fit: contain; display: block;';
} else {
    $_img_area_extra = 'aspect-ratio: ' . $_aspect_ratio . ';';
    $_img_extra      = 'position: absolute; inset: 0; width: 100% !important; height: 100%; object-fit: cover; display: block;';
}
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-image-tabs widget-<?php echo $_widget_id; ?> <?php echo $_color . $_layout_cls; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="image-tabs"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?> .image-tabs-wrapper {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-lg);
}
.widget-<?php echo $_widget_id; ?> .image-tabs-image-area {
    position: relative;
    width: 100%;
    overflow: hidden;
    background-color: var(--bg-secondary);
    border: var(--border-width-thin) solid var(--border-color);
    border-radius: var(--radius-md);
    <?php echo $_img_area_extra; ?>
}
.widget-<?php echo $_widget_id; ?> .image-tabs-image-frame {
    width: 100%;
    height: 100%;
    display: block;
    position: relative;
}
.widget-<?php echo $_widget_id; ?> .image-tabs-image-frame[hidden] {
    display: none;
}
.widget-<?php echo $_widget_id; ?> .image-tabs-image {
    <?php echo $_img_extra; ?>
}
.widget-<?php echo $_widget_id; ?> .image-tabs-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0;
}
.widget-<?php echo $_widget_id; ?> .image-tabs-tab {
    background-color: var(--bg-primary);
    border: var(--border-width-thin) solid var(--border-color);
    border-block-start: none;
    padding: var(--space-lg);
    cursor: pointer;
    transition: background-color 0.3s;
    position: relative;
}
.widget-<?php echo $_widget_id; ?> .image-tabs-tab:first-child {
    border-block-start: var(--border-width-thin) solid var(--border-color);
}
.widget-<?php echo $_widget_id; ?> .image-tabs-tab:hover {
    background-color: var(--bg-secondary);
}
.widget-<?php echo $_widget_id; ?> .image-tabs-tab.is-active {
    background-color: var(--bg-secondary);
    box-shadow: inset 0.3rem 0 0 0 var(--text-heading);
}
.widget-<?php echo $_widget_id; ?> .image-tabs-tab-button {
    background: none;
    border: none;
    padding: 0;
    text-align: start;
    width: 100%;
    cursor: pointer;
    font-family: inherit;
}
.widget-<?php echo $_widget_id; ?> .image-tabs-tab-description {
    font-size: calc(var(--font-size-sm) * var(--body-scale));
}
@media (min-width: 750px) {
    .widget-<?php echo $_widget_id; ?> .image-tabs-wrapper {
        grid-template-columns: 1fr 1fr;
    }
    .widget-<?php echo $_widget_id; ?> .image-tabs-tab {
        padding: var(--space-xl);
    }
}
.widget-<?php echo $_widget_id; ?>.layout-image-end .image-tabs-image-area {
    order: 2;
}
.widget-<?php echo $_widget_id; ?>.layout-image-end .image-tabs-list {
    order: 1;
}
.widget-<?php echo $_widget_id; ?>.layout-image-end .image-tabs-tab.is-active {
    box-shadow: inset -0.3rem 0 0 0 var(--text-heading);
}
</style>

    <div class="widget-container widget-container-padded">

        <?php if ($_eyebrow || $_title || $_description): ?>
        <div class="widget-header widget-header--align-center">
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
            <div class="image-tabs-wrapper reveal reveal-up">

                <div
                    class="image-tabs-image-area"
                    id="<?php echo $_panel_id; ?>"
                    role="tabpanel"
                    aria-labelledby="image-tabs-tab-<?php echo $_widget_id; ?>-tab0"
                >
                    <?php foreach ($_tabs as $i => $_tab):
                        $_block_id = $_widget_id . '_tab' . $i;
                        $_tab_img  = htmlspecialchars($_tab['image'] ?? '');
                        $_tab_ttl  = htmlspecialchars($_tab['title'] ?? '');
                    ?>
                    <div
                        class="image-tabs-image-frame<?php echo $i === 0 ? ' is-active' : ''; ?>"
                        <?php echo $i !== 0 ? 'hidden' : ''; ?>
                        data-block-id="<?php echo $_block_id; ?>"
                    >
                        <?php if ($_tab_img): ?>
                        <img src="<?php echo $_tab_img; ?>" alt="<?php echo $_tab_ttl; ?>" class="image-tabs-image" loading="lazy">
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>

                <ul class="image-tabs-list" role="tablist">
                    <?php foreach ($_tabs as $i => $_tab):
                        $_block_id = $_widget_id . '_tab' . $i;
                        $_tab_id   = 'image-tabs-tab-' . $_widget_id . '-tab' . $i;
                        $_tab_ttl  = htmlspecialchars($_tab['title']       ?? '');
                        $_tab_desc = htmlspecialchars($_tab['description'] ?? '');
                        $_is_first = ($i === 0);
                    ?>
                    <li
                        class="image-tabs-tab<?php echo $_is_first ? ' is-active' : ''; ?>"
                        role="presentation"
                        data-block-id="<?php echo $_block_id; ?>"
                    >
                        <button
                            type="button"
                            id="<?php echo $_tab_id; ?>"
                            class="image-tabs-tab-button"
                            role="tab"
                            aria-selected="<?php echo $_is_first ? 'true' : 'false'; ?>"
                            aria-controls="<?php echo $_panel_id; ?>"
                            tabindex="<?php echo $_is_first ? '0' : '-1'; ?>"
                        >
                            <h3 class="image-tabs-tab-title w-title t-xl"><?php echo $_tab_ttl; ?></h3>
                            <?php if ($_tab_desc): ?>
                            <div class="image-tabs-tab-description w-body w-rte"><p><?php echo $_tab_desc; ?></p></div>
                            <?php endif; ?>
                        </button>
                    </li>
                    <?php endforeach; ?>
                </ul>

            </div>
        </div>
    </div>
</section>
<?php
$_widget_id_js = 'widget_' . $blockID;
$_panel_id_js  = 'image-tabs-panel-' . $_widget_id_js;
$_script = <<<JSEOF
<script>
(function () {
    var widget = document.getElementById("{$_widget_id_js}");
    if (!widget || widget.dataset.imtbInit) return;
    widget.dataset.imtbInit = "true";

    var panel  = widget.querySelector("#{$_panel_id_js}");
    var tabs   = Array.prototype.slice.call(widget.querySelectorAll(".image-tabs-tab"));
    var frames = Array.prototype.slice.call(widget.querySelectorAll(".image-tabs-image-frame"));

    function activateTab(button) {
        tabs.forEach(function (t) {
            var btn = t.querySelector(".image-tabs-tab-button");
            t.classList.remove("is-active");
            btn.setAttribute("aria-selected", "false");
            btn.setAttribute("tabindex", "-1");
        });
        var tab = button.closest(".image-tabs-tab");
        tab.classList.add("is-active");
        button.setAttribute("aria-selected", "true");
        button.setAttribute("tabindex", "0");
        if (panel) panel.setAttribute("aria-labelledby", button.id);
        var blockId = tab && tab.dataset.blockId;
        if (blockId) {
            frames.forEach(function (frame) {
                var isActive = frame.dataset.blockId === blockId;
                frame.hidden = !isActive;
                frame.classList.toggle("is-active", isActive);
            });
        }
    }

    tabs.forEach(function (tab) {
        var button = tab.querySelector(".image-tabs-tab-button");
        button.addEventListener("click", function () { activateTab(button); });
        button.addEventListener("keydown", function (event) {
            var currentIndex = tabs.indexOf(tab);
            var nextIndex = null;
            switch (event.key) {
                case "ArrowRight": nextIndex = (currentIndex + 1) % tabs.length; break;
                case "ArrowLeft":  nextIndex = (currentIndex - 1 + tabs.length) % tabs.length; break;
                case "Home":       nextIndex = 0; break;
                case "End":        nextIndex = tabs.length - 1; break;
                default: return;
            }
            event.preventDefault();
            var nextButton = tabs[nextIndex].querySelector(".image-tabs-tab-button");
            nextButton.focus();
            activateTab(nextButton);
        });
    });
})();
</script>
JSEOF;
echo $_script;
?>
