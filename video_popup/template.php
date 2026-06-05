<?php
/*
 * Widgetizer — Video Popup Widget — template.php
 * Prefix: vpup
 * Refactored: Pure PHP output, flat CSS, no DOMDocument
 */

// ── Assets ────────────────────────────────────────────────────────────────────
$_wdg_assets     = 'admin/builder_widget_assets/';
$_wdg_css        = $_wdg_assets . 'base.css';
$_wdg_js         = $_wdg_assets . 'scripts.js';
$_wdg_asset_html = '';

$_base_css_exists = false;
foreach ($document->loadedFiles as $_f) {
    if (strpos($_f, 'base.css') !== false) { $_base_css_exists = true; break; }
}
if (!$_base_css_exists) {
    $_wdg_asset_html .= '<link href="' . $_wdg_css . '" rel="stylesheet" type="text/css">' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_css;
}

$_scripts_js_exists = false;
foreach ($document->loadedFiles as $_f) {
    if (strpos($_f, 'scripts.js') !== false) { $_scripts_js_exists = true; break; }
}
if (!$_scripts_js_exists) {
    $_wdg_asset_html .= '<script src="' . $_wdg_js . '"></script>' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_js;
}

$_vpup_js = $_wdg_assets . 'video-modal.js';

// Inline modal CSS + video-modal.js (DOM check loader)
$_wdg_asset_html .= '<script>
(function(){
    // Inline modal CSS — check if already exists
    if (!document.querySelector("style[data-vpup-modal]")) {
        var st = document.createElement("style");
        st.setAttribute("data-vpup-modal", "1");
        st.textContent = ".video-modal{position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,.85);opacity:0;pointer-events:none;transition:opacity .25s}.video-modal.is-open{opacity:1;pointer-events:all}.video-modal-content{position:relative;width:90vw;max-width:960px;aspect-ratio:16/9}.video-modal-close{position:absolute;top:-40px;right:0;background:none;border:none;color:#fff;cursor:pointer;padding:4px;line-height:1}.video-modal-close svg{width:24px;height:24px;display:block}.video-modal-frame{width:100%;height:100%}.video-modal-iframe{width:100%;height:100%;border:0}";
        document.head.appendChild(st);
    }
    // video-modal.js
    var jsHref = "' . $_vpup_js . '";
    var scripts = document.querySelectorAll("script[src]");
    var loaded = false;
    for (var i = 0; i < scripts.length; i++) {
        if (scripts[i].getAttribute("src") === jsHref) { loaded = true; break; }
    }
    if (!loaded) { var s = document.createElement("script"); s.src = jsHref; document.head.appendChild(s); }
})();
</script>' . PHP_EOL;

// ── Parameters ────────────────────────────────────────────────────────────────
$_bg_image        = str_replace(['"', "'"], '', $wdg_params['bg_image'] ?? '');
$_overlay_color   = str_replace('[id]', '#', $wdg_params['overlay_color'] ?? '#0a1e38');
$_overlay_opacity = floatval($wdg_params['overlay_opacity'] ?? 0.7);
$_video_url       = htmlspecialchars($wdg_params['video_url'] ?? '');
$_video_title     = htmlspecialchars($wdg_params['video_title'] ?? 'Video');
$_height          = htmlspecialchars($wdg_params['height']      ?? 'widget-height-medium');
$_play_style      = htmlspecialchars($wdg_params['play_style']  ?? 'video-popup-play-light');

$_widget_id = 'widget_' . $blockID;

// ── Section style ─────────────────────────────────────────────────────────────
$_sec_style = 'padding-bottom: 20px;';
if ($_bg_image) {
    $_sec_style .= 'background-image: url(\'' . $_bg_image . '\'); ';
}
$_sec_style .= '--widget-overlay-color: ' . $_overlay_color . '; --widget-overlay-opacity: ' . $_overlay_opacity . ';';

?>
<?php echo $_wdg_asset_html; ?>
<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-video-popup widget-<?php echo $_widget_id; ?> has-bg-image has-overlay <?php echo $_height; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="video-popup"
    data-video-url="<?php echo $_video_url; ?>"
    data-video-title="<?php echo $_video_title; ?>"
    style="<?php echo $_sec_style; ?>"
>
    <style>
        /* Flat CSS — no nesting */
        .widget-<?php echo $_widget_id; ?> {
            margin-block: 0;
            padding-inline: 0;
            cursor: pointer;
        }
        .widget-<?php echo $_widget_id; ?> .widget-container {
            max-width: none;
        }
    </style>
    <div class="widget-container">
        <div class="video-popup-trigger" role="button" tabindex="0" aria-label="<?php echo $_video_title; ?>">
            <button class="video-popup-play <?php echo $_play_style; ?> reveal reveal-scale" type="button" aria-label="<?php echo $_video_title; ?>">
                <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="40" cy="40" r="39" stroke="currentColor" stroke-width="2" opacity="0.9" />
                    <path d="M33 25L57 40L33 55V25Z" fill="currentColor" />
                </svg>
            </button>
        </div>
    </div>
</section>