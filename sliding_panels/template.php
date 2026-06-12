<?php
/*
 * Widgetizer — Sliding Panels Widget — template.php
 * Prefix: slpn
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

// ── Parameters ────────────────────────────────────────────────────────────────
$_eyebrow      = htmlspecialchars($wdg_params['eyebrow']        ?? '');
$_title        = htmlspecialchars($wdg_params['title']          ?? '');
$_description  = htmlspecialchars($wdg_params['description']    ?? '');
$_header_align = htmlspecialchars($wdg_params['header_align']   ?? 'center');
$_color        = htmlspecialchars($wdg_params['color_scheme']   ?? 'color-scheme-standard-primary');
$_panels       = $wdg_params['panels'] ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map = ['full'=>null,'xl'=>'1420px','lg'=>'1200px','md'=>'960px','sm'=>'760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_widget_id    = 'widget_' . $blockID;
$_widget_class = 'widget_' . $blockID;
$_header_class = ($_header_align === 'start') ? 'widget-header widget-header--align-start' : 'widget-header';

if (empty($_panels)) {
    echo '<!-- Widgetizer Sliding Panels: no panels -->';
    return;
}

// ── Build panels HTML ─────────────────────────────────────────────────────────
$_panels_html = '';
$_panel_index = 0;

foreach ($_panels as $_pi => $_panel) {
    $_img        = htmlspecialchars($_panel['image']              ?? '');
    $_ptitle     = htmlspecialchars($_panel['panel_title']        ?? '');
    $_subtitle   = htmlspecialchars($_panel['subtitle']           ?? '');
    $_pcs        = htmlspecialchars($_panel['panel_color_scheme'] ?? 'color-scheme-highlight-primary');
    $_btn_label  = htmlspecialchars($_panel['btn_label']          ?? '');
    $_btn_url    = $_panel['btn_url'] ?? '';
    if (function_exists('wdg_parse_links')) $_btn_url = wdg_parse_links($_btn_url);
    $_btn_url_esc = htmlspecialchars($_btn_url);
    $_btn_style  = htmlspecialchars($_panel['btn_style']          ?? 'widget-button-secondary');
    $_btn_tab    = ($_panel['btn_new_tab'] ?? '0') === '1' ? ' target="_blank" rel="noopener"' : ' target="_self"';
    
    $_panel_class = 'sliding-panel';
    if ($_pi === 0) $_panel_class .= ' is-active';
    
    $_panels_html .= '<div class="' . $_panel_class . '" data-block-id="slpn_' . $blockID . '_' . $_pi . '">';
    
    // Image
    $_panels_html .= '<div class="sliding-panel-image">';
    if ($_img) {
        $_panels_html .= '<img src="' . $_img . '" alt="" width="1920" height="1080" loading="lazy">';
    }
    $_panels_html .= '</div>';
    
    // Content
    $_panels_html .= '<div class="sliding-panel-content ' . $_pcs . '">';
    if ($_ptitle) {
        $_panels_html .= '<h2 class="sliding-panel-title w-title t-xl">' . $_ptitle . '</h2>';
    }
    if ($_subtitle) {
        $_panels_html .= '<p class="sliding-panel-subtitle w-meta">' . $_subtitle . '</p>';
    }
    if ($_btn_label && $_btn_url_esc) {
        $_panels_html .= '<a href="' . $_btn_url_esc . '" class="widget-button ' . $_btn_style . ' sliding-panel-button"' . $_btn_tab . '>' . $_btn_label . '</a>';
    }
    $_panels_html .= '</div>';
    
    $_panels_html .= '</div>';
}

// ── Header HTML ───────────────────────────────────────────────────────────────
$_header_html = '<div class="' . $_header_class . '">';
if ($_eyebrow) {
    $_header_html .= '<span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0">' . $_eyebrow . '</span>';
}
if ($_title) {
    $_header_html .= '<h1 class="w-headline reveal reveal-up" style="--reveal-delay: 1">' . $_title . '</h1>';
}
if ($_description) {
    $_header_html .= '<p class="w-description reveal reveal-up" style="--reveal-delay: 2">' . $_description . '</p>';
}
$_header_html .= '</div>';

// ── Section style ─────────────────────────────────────────────────────────────
$_sec_style = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_sec_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

?>
<?php echo $_wdg_asset_html; ?>
<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-type-sliding-panels widget-<?php echo $_widget_class; ?> <?php echo $_color; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="sliding-panels"
    style="<?php echo $_sec_style; ?>"
>
    <style>
        /* Flat CSS — no nesting */
        .widget-<?php echo $_widget_class; ?> .sliding-panels-container {
            display: flex;
            gap: var(--space-sm);
            height: 600px;
        }
        
        .widget-<?php echo $_widget_class; ?> .sliding-panel {
            position: relative;
            flex: 1;
            overflow: hidden;
            border-radius: var(--radius-lg);
            cursor: pointer;
            transition: flex 0.5s ease;
        }
        
        .widget-<?php echo $_widget_class; ?> .sliding-panel.is-active {
            flex: 3;
        }
        
        .widget-<?php echo $_widget_class; ?> .sliding-panel-image {
            position: absolute;
            inset: 0;
        }
        
        .widget-<?php echo $_widget_class; ?> .sliding-panel-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        
        .widget-<?php echo $_widget_class; ?> .sliding-panel-content {
            position: absolute;
            inset-inline: 0;
            inset-block-end: 0;
            padding: var(--space-xl);
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, transparent 100%);
            color: var(--color-white) !important;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .widget-<?php echo $_widget_class; ?> .sliding-panel.is-active .sliding-panel-content {
            opacity: 1;
        }
        
        .widget-<?php echo $_widget_class; ?> .sliding-panel-title {
            margin: 0;
            color: var(--color-white) !important;
            text-shadow: 1px 1px 2px black;
        }
        
        .widget-<?php echo $_widget_class; ?> .sliding-panel-subtitle {
            margin: 0;
            margin-block-start: var(--space-xs);
            opacity: 0.8;
            color: var(--color-white) !important;
            text-shadow: 1px 1px 2px black;
        }
        
        .widget-<?php echo $_widget_class; ?> .sliding-panel-button {
            margin-block-start: var(--space-md);
        }
        
        @media (max-width: 749px) {
            .widget-<?php echo $_widget_class; ?> .sliding-panels-container {
                flex-direction: column;
                height: auto;
            }
            
            .widget-<?php echo $_widget_class; ?> .sliding-panel {
                height: 160px;
                flex: none;
                transition: height 0.5s ease;
            }
            
            .widget-<?php echo $_widget_class; ?> .sliding-panel.is-active {
                height: 400px;
                flex: none;
            }
            
            .widget-<?php echo $_widget_class; ?> .sliding-panel-content {
                opacity: 1;
            }
        }
    </style>

    <div class="widget-container">
        <?php echo $_header_html; ?>
        
        <div class="widget-content">
            <div class="sliding-panels-container reveal reveal-up">
                <?php echo $_panels_html; ?>
            </div>
        </div>
    </div>
</section>

<?php
// ── Inline JS for sliding panels (vanilla, no forEach) ────────────────────────
$_js = <<<JSEOF
<script>
(function() {
    function initSlidingPanels(widget) {
        if (widget.dataset.slpnInit) return;
        widget.dataset.slpnInit = "true";
        
        var panels = widget.querySelectorAll(".sliding-panel");
        if (panels.length === 0) return;
        
        for (var i = 0; i < panels.length; i++) {
            panels[i].addEventListener("click", function(e) {
                var target = e.target;
                var isLink = false;
                while (target) {
                    if (target.tagName === 'A') { isLink = true; break; }
                    target = target.parentNode;
                }
                if (isLink) return;
                
                for (var j = 0; j < panels.length; j++) {
                    panels[j].classList.remove("is-active");
                }
                this.classList.add("is-active");
            });
        }
        
        if (window.Widgetizer && window.Widgetizer.designMode) {
            widget.addEventListener("widget:block-select", function(e) {
                var blockId = e.detail.blockId;
                var target = widget.querySelector('.sliding-panel[data-block-id="' + blockId + '"]');
                if (target) {
                    for (var j = 0; j < panels.length; j++) {
                        panels[j].classList.remove("is-active");
                    }
                    target.classList.add("is-active");
                }
            });
        }
    }
    
    function run() {
        var widget = document.getElementById("{$_widget_id}");
        if (widget) initSlidingPanels(widget);
    }
    
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", run);
    } else {
        run();
    }
    
    document.addEventListener("widget:updated", function(e) {
        var widget = e.target.closest('[data-widget-type="sliding-panels"]');
        if (widget && widget.id === "{$_widget_id}") {
            widget.removeAttribute("data-slpnInit");
            initSlidingPanels(widget);
        }
    });
})();
</script>
JSEOF;

echo $_js;