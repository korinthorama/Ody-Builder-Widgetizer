<?php
/*
 * Widgetizer — Header Widget — template.php
 *
 * Παίρνει το html_markup από τα αποθηκευμένα params,
 * αντικαθιστά τα data-setting values με τις παραμέτρους,
 * χτίζει το nav-list από το $menu->displayMenu(),
 * και αφαιρεί τα contact line elements αν είναι κενά.
 *
 * Διαθέσιμα: $wdg_params, $wdg_id, $blockID, $document, $sef, $db, $langID, $menu
 */
defined('CMS') or die("This file cannot run this way!");
// ── Assets ────────────────────────────────────────────────────────────────────
$_wdg_assets = 'admin/builder_widget_assets/';
$_wdg_css = $_wdg_assets . 'base.css';
$_wdg_js = $_wdg_assets . 'scripts.js';
$_wdg_asset_html = '';
if(!in_array($_wdg_css, $document->loadedFiles)) {
    $_wdg_asset_html .= '<link href="' . $_wdg_css . '" rel="stylesheet" type="text/css">' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_css;
}
if(!in_array($_wdg_js, $document->loadedFiles)) {
    $_wdg_asset_html .= '<script src="' . $_wdg_js . '"></script>' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_js;
}
// ── HTML Markup — από params ή fallback στο html_markup.txt ─────────────────
$_markup = $wdg_params['html_markup'] ?? '';
if (!$_markup) {
    $_markup = file_get_contents(__DIR__ . '/html_markup.txt');
}
if (!$_markup) {
    echo '<!-- Widgetizer Header: δεν υπάρχει HTML markup -->';
    return;
}
// ── Logo src helper ───────────────────────────────────────────────────────────
if (!function_exists('_wdg_logo_src')) {
    function _wdg_logo_src($path) {
        return $path ?: '';
    }
}

// ── Menu: displayMenu → nav-list HTML ────────────────────────────────────────
$_menu_name = $wdg_params['menu_name'] ?? '';
$_nav_list_html = '';
if($_menu_name) {
    // Capture output του displayMenu
    ob_start();
    global $menu;
    $menu->displayMenu("horizontal", $_menu_name, true, false, '', '', true);
    $_raw_menu = ob_get_clean();
    // Parse του Odyssey menu markup → nav-list markup
    if($_raw_menu) {
        libxml_use_internal_errors(true);
        $_mdom = new DOMDocument();
        $_mdom->loadHTML('<?xml encoding="utf-8"?>' . $_raw_menu, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        $_mxpath = new DOMXPath($_mdom);
        // Βρες το root <ul> (το menu)
        $_root_ul = $_mxpath->query('//ul[1]')->item(0);
        if($_root_ul) {
            // Recursive function: μετατρέπει Odyssey li → widget li
            if (!function_exists('_wdg_build_nav_items')) {
                function _wdg_build_nav_items(DOMElement $ul, DOMDocument $srcDom): string {
                    $html = '';
                    foreach($ul->childNodes as $li) {
                        if(!($li instanceof DOMElement) || $li->nodeName !== 'li') continue;
                        $liClass = $li->getAttribute('class');
                        $isActive = (strpos($liClass, 'first-option') !== false && strpos($liClass, 'rootItem') !== false)
                                ? ' is-active' : '';
                        // Link
                        $xpath = new DOMXPath($srcDom);
                        $aNodes = $xpath->query('a', $li);
                        $href = '';
                        $text = '';
                        if($aNodes->length) {
                            $a = $aNodes->item(0);
                            $href = $a->getAttribute('href');
                            $text = trim($a->textContent);
                        }
                        // Submenu?
                        $subUls = $xpath->query('ul', $li);
                        $hasSub = $subUls->length > 0;
                        $navItemClass = 'nav-item' . ($hasSub ? ' has-submenu' : '') . $isActive;
                        $html .= '<li class="' . htmlspecialchars($navItemClass) . '">';
                        $html .= '<a href="' . htmlspecialchars($href) . '">' . htmlspecialchars($text) . '</a>';
                        if($hasSub) {
                            $html .= '<ul class="nav-submenu">';
                            $html .= _wdg_build_nav_items($subUls->item(0), $srcDom);
                            $html .= '</ul>';
                        }
                        $html .= '</li>';
                    }
                    return $html;
                }
            }

            $_nav_list_html = _wdg_build_nav_items($_root_ul, $_mdom);
        }
    }
}
// ── Parse markup με DOMDocument ───────────────────────────────────────────────
libxml_use_internal_errors(true);
$_dom = new DOMDocument();
$_dom->loadHTML('<?xml encoding="utf-8"?>' . $_markup, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
libxml_clear_errors();
$_xpath = new DOMXPath($_dom);
// ── Phone detection helper ───────────────────────────────────────────────────
if (!function_exists('_wdg_make_tel_link')) {
    function _wdg_make_tel_link($text, DOMDocument $dom) {
        // Patterns: +30 6948117266 | 6948 117266 | 6948117266 | +306948117266
        if (!preg_match('/^(\+?[\d][\d\s\-]{6,17}[\d])$/', trim($text))) return null;

        $tel = preg_replace('/[\s\-]/', '', $text);

        if (str_starts_with($tel, '+')) {
            // Ήδη έχει country code — κρατάμε ως έχει
        } elseif (preg_match('/^(69|2\d)/', $tel)) {
            // Ελληνικός αριθμός (κινητό 69x ή σταθερό 2xx)
            $tel = '+30' . $tel;
        }
        // Αλλιώς δεν προσθέτουμε prefix

        $a = $dom->createElement('a');
        $a->setAttribute('href', 'tel:' . $tel);
        $a->setAttribute('style', 'color:inherit;text-decoration:none;');
        $a->appendChild($dom->createTextNode($text));
        return $a;
    }
}

// ── 1. Contact lines — αφαίρεση αν κενά ──────────────────────────────────────
$_contact_map = [
        'contactDetailsLine1' => $wdg_params['contact_line1'] ?? '',
        'contactDetailsLine2' => $wdg_params['contact_line2'] ?? '',
];
$_setting_nodes = $_xpath->query('//*[@data-setting]');
// Συλλέγουμε πρώτα για να μην επηρεαστεί το iteration από DOM mutations
$_setting_node_list = [];
foreach($_setting_nodes as $_n) {
    $_setting_node_list[] = $_n;
}
foreach($_setting_node_list as $_node) {
    $_setting_name = $_node->getAttribute('data-setting');
    if(!array_key_exists($_setting_name, $_contact_map)) continue;
    $_value = $_contact_map[$_setting_name];
    if($_value === '') {
        // Αφαίρεση του element εντελώς
        $_node->parentNode->removeChild($_node);
    } else {
        while($_node->firstChild) $_node->removeChild($_node->firstChild);
        // Έλεγχος αν είναι τηλέφωνο → wrap σε <a href="tel:">
        $_tel_link = _wdg_make_tel_link($_value, $_dom);
        if($_tel_link) {
            $_node->appendChild($_tel_link);
        } else {
            $_node->appendChild($_dom->createTextNode($_value));
        }
    }
}
// ── 2. Logo images ────────────────────────────────────────────────────────────
$_logo_max_width = (int)($wdg_params['logo_max_width'] ?? 250);
$_logo_default_nodes = $_xpath->query('//*[contains(@class,"header-logo-default")]');
foreach($_logo_default_nodes as $_node) {
    $_src = _wdg_logo_src($wdg_params['logo_default'] ?? '');
    if($_src) {
        $_node->setAttribute('src', $_src);
        $_node->setAttribute('style', 'max-width:' . $_logo_max_width . 'px; height:auto;');
        $_node->removeAttribute('width');
        $_node->removeAttribute('height');
    }
}
$_logo_transp_nodes = $_xpath->query('//*[contains(@class,"header-logo-transparent")]');
foreach($_logo_transp_nodes as $_node) {
    $_src = $wdg_params['logo_transparent'] ?? '';
    if($_src) {
        $_node->setAttribute('src', $_src);
        $_node->setAttribute('style', 'max-width:' . $_logo_max_width . 'px; height:auto;');
        $_node->removeAttribute('width');
        $_node->removeAttribute('height');
    } else {
        $_node->parentNode->removeChild($_node);
    }
}
// ── 3. Logo link → home URL ───────────────────────────────────────────────────
$_logo_links = $_xpath->query('//a[contains(@class,"header-logo")]');
foreach($_logo_links as $_node) {
    $_node->setAttribute('href', $sef->url('index.php', false));
}
// ── 4. CTA buttons ───────────────────────────────────────────────────────────
$_cta_label = $wdg_params['cta_label'] ?? '';
$_cta_url   = $wdg_params['cta_url']   ?? '';
$_cta_style = $wdg_params['cta_style'] ?? 'widget-button-secondary';

if(strpos($_cta_url, '««') !== false) {
    $_cta_url = str_replace(['««', '»»', '~|||~'], ['', '', '&'], $_cta_url);
    $_cta_url = $sef->url($_cta_url, false);
} elseif($_cta_url === 'index.php') {
    $_cta_url = $sef->url('index.php', false);
}

$_cta_nodes = $_xpath->query('//*[contains(@class,"mobile-cta") or contains(@class,"desktop-cta")]');
$_cta_node_list = [];
foreach($_cta_nodes as $_n) $_cta_node_list[] = $_n;

foreach($_cta_node_list as $_node) {
    if(!$_cta_label || !$_cta_url) {
        $_node->parentNode->removeChild($_node);
        continue;
    }
    $_node->setAttribute('href', $_cta_url);
    $_cls = preg_replace('/widget-button-primary|widget-button-secondary/', $_cta_style, $_node->getAttribute('class'));
    $_node->setAttribute('class', $_cls);
    while($_node->firstChild) $_node->removeChild($_node->firstChild);
    $_node->appendChild($_dom->createTextNode($_cta_label));
}
// ── 5. nav-list → inject remapped menu items ──────────────────────────────────
$_nav_list_nodes = $_xpath->query('//*[contains(@class,"nav-list")]');
foreach($_nav_list_nodes as $_navList) {
    // Καθάρισε το placeholder
    while($_navList->firstChild) $_navList->removeChild($_navList->firstChild);
    if($_nav_list_html) {
        // Inject το remapped menu markup
        $_frag = $_dom->createDocumentFragment();
        $_frag->appendXML($_nav_list_html);
        $_navList->appendChild($_frag);
    }
}
// ── 6. Inline logo styles ─────────────────────────────────────────────────────
$_style_nodes = $_xpath->query('//style');
foreach($_style_nodes as $_style) {
    $css = $_style->nodeValue;
    $css = preg_replace('/max-width:\s*\d+px/', 'max-width:' . $_logo_max_width . 'px', $css);
    $css = preg_replace('/max-height:\s*\d+px/', 'max-height:' . $_logo_max_width . 'px', $css);
    while($_style->firstChild) $_style->removeChild($_style->firstChild);
    $_style->appendChild($_dom->createTextNode($css));
}
// ── 7. Color scheme class + sticky + transparent ─────────────────────────────
$_color_scheme       = $wdg_params['color_scheme']       ?? 'color-scheme-standard-primary';
$_header_sticky      = ($wdg_params['header_sticky']      ?? '') === '1';
$_header_transparent = ($wdg_params['header_transparent'] ?? '') === '1';
$_break       = (int)($wdg_params['responsive_break'] ?? 990);
$_break_minus = $_break - 1;

$_header_nodes = $_xpath->query('//header');
foreach($_header_nodes as $_h) {
    $_classes = preg_replace('/color-scheme-[\w-]+/', '', $_h->getAttribute('class'));
    $_classes .= ' ' . $_color_scheme;
    if($_header_sticky) $_classes .= ' header-sticky';
    $_h->setAttribute('class', trim(preg_replace('/\s+/', ' ', $_classes)));
    $_h->setAttribute('data-responsive-break', $_break);
}
// ── 8. Serialize output ───────────────────────────────────────────────────────
$_output = '';

$_header_nodes = $_xpath->query('//header');
foreach($_header_nodes as $_h) {
    $_output = $_dom->saveHTML($_h);
    break;
}
if(!$_output) {
    $_output = $_dom->saveHTML();
}
// ── 9. CSS overrides — fix conflicts με CMS styles ───────────────────────────
$_output .= '<style>
/* ── New layout: top-row + nav-row ── */
.widget-site-header .header-top-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-inline: var(--space-xl);
    padding-block: var(--space-sm);
    border-bottom: 1px solid var(--border-color);
    height: auto !important;
}
.widget-site-header .header-top-row .menu-toggle {
    display: none;
}
.widget-site-header .header-nav-row {
    display: flex;
    align-items: center;
    justify-content: center;
    padding-inline: var(--space-xl);
}
.widget-site-header .header-nav-row .header-nav {
    width: 100%;
    margin-top: 0 !important;
}
.widget-site-header .header-nav-row .nav-list {
    justify-content: center !important;
}
.widget-site-header .header-end {
	display: flex;
	align-items: center;
	gap: var(--space-md);
	margin-inline-start: auto;
	margin-right: 20px;
}
.widget-site-header .mobile-cta {
    max-width: 215px !important;
}
@media (max-width: ' . $_break_minus . 'px) {
    .widget-site-header .header-top-row .menu-toggle {
        display: flex;
    }
    .widget-site-header .header-nav-row {
        display: none;
    }
}
.widget-site-header {
    --header-nav-top-link-active-bg:    transparent;
    --header-nav-top-link-active-color: inherit;
    --header-nav-top-link-hover-bg:     rgba(128,128,128,0.12);
    --header-nav-top-link-hover-color:  inherit;
}
.widget-site-header .nav-submenu {
    background-color: var(--bg-primary) !important;
    min-width: 180px !important;
    max-width: 280px !important;
}
/* Top level μόνο — desktop only */
@media (min-width: ' . $_break . 'px) {
    .widget-site-header .nav-list > .nav-item > a,
    .widget-site-header .nav-list > .nav-item > button:not(.submenu-toggle) {
        width: auto !important;
        display: inline-flex !important;
    }
}

/* Submenu items — επαναφορά */
.widget-site-header .nav-submenu .nav-item > a,
.widget-site-header .nav-submenu .nav-item > button:not(.submenu-toggle) {
    width: 100% !important;
    display: flex !important;
    justify-content: space-between !important;
    padding-inline: 16px !important;
    box-sizing: border-box !important;
}
.widget-site-header .nav-submenu .nav-submenu {
    inset-inline-start: calc(100% - 30px) !important;
    width: max-content !important;
    min-width: 180px !important;
    max-width: 280px !important;
}
.widget-site-header .nav-submenu .nav-submenu .nav-item > a:hover,
.widget-site-header .nav-submenu .nav-submenu .nav-item > button:not(.submenu-toggle):hover {
    background-color: var(--colors-highlight_bg_secondary) !important;
    color: var(--colors-highlight_text_heading) !important;
}
.widget-site-header .nav-submenu .nav-submenu.submenu-flip {
    inset-inline-start: auto !important;
    inset-inline-end: calc(100% - 30px) !important;
}
.widget-site-header nav ul ul {
	padding: 0 !important;
}
.widget-site-header .nav-list{
    margin: 0 !important;
}
.widget-site-header .header-nav-row{
    height: auto !important;
}

.widget-site-header .nav-submenu .nav-item > a,
.widget-site-header .nav-submenu .nav-item > button {
    padding-block: 6px;
}

.widget-site-header {
	padding-block: 0 !important;
	height: auto !important;
}

/* ── Sticky header ── */
.widget-site-header.header-sticky {
    position: sticky;
    top: 0;
    z-index: 999;
    background-color: var(--bg-primary) !important;
    transition: box-shadow 0.2s ease-in-out;
}
.widget-site-header.header-sticky.header-scrolled {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* ── Transparent logo swap ── */
.widget-site-header .header-logo-image.header-logo-transparent {
    display: none;
}
.transparent-header .widget-site-header:not(.header-sticky) .header-logo-image.header-logo-transparent,
.transparent-header .widget-site-header.header-sticky:not(.header-scrolled) .header-logo-image.header-logo-transparent {
    display: block;
}
.transparent-header .widget-site-header:not(.header-sticky) .header-logo-image.header-logo-default,
.transparent-header .widget-site-header.header-sticky:not(.header-scrolled) .header-logo-image.header-logo-default {
    display: none;
}

/* ── Transparent header (non-sticky) ── */
.transparent-header .widget-site-header:not(.header-sticky) {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 999;
    background-color: transparent !important;
    border-block-end-color: transparent;
    color: var(--colors-highlight_text_heading, #fff) !important;
    --header-nav-top-link-color: var(--colors-highlight_text_content, #fff);
    --header-nav-top-link-hover-color: var(--colors-highlight_text_heading, #fff);
    --header-nav-top-link-hover-bg: rgb(255 255 255 / 0.08);
    --header-nav-top-link-hover-indicator: transparent;
    --header-nav-top-link-active-color: var(--header-nav-top-link-hover-color);
    --header-nav-top-link-active-bg: var(--header-nav-top-link-hover-bg);
    --header-nav-top-link-active-indicator: transparent;
}
.transparent-header .widget-site-header:not(.header-sticky) .header-logo,
.transparent-header .widget-site-header:not(.header-sticky) .menu-toggle,
.transparent-header .widget-site-header:not(.header-sticky) .header-contact-line {
    color: var(--colors-highlight_text_content, #fff) !important;
}
.transparent-header .widget-site-header:not(.header-sticky) .widget-button-primary {
    background-color: var(--colors-highlight_accent, #de1877) !important;
    color: var(--colors-highlight_accent_text, #fff) !important;
    border-color: var(--colors-highlight_accent, #de1877) !important;
}
.transparent-header .widget-site-header:not(.header-sticky) .widget-button-secondary {
    color: var(--colors-highlight_text_heading, #fff) !important;
    border-color: var(--colors-highlight_border_color, rgba(255, 255, 255, 0.5)) !important;
}

/* ── Transparent + sticky ── */
.transparent-header .widget-site-header.header-sticky {
    position: fixed;
    left: 0;
    right: 0;
    width: 100%;
    transition: background-color 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease, color 0.3s ease;
}
.transparent-header .widget-site-header.header-sticky:not(.header-scrolled) {
    background-color: transparent !important;
    border-block-end-color: transparent;
    box-shadow: none;
    color: var(--colors-highlight_text_heading, #fff) !important;
    --header-nav-top-link-color: var(--colors-highlight_text_content, #fff);
    --header-nav-top-link-hover-color: var(--colors-highlight_text_heading, #fff);
    --header-nav-top-link-hover-bg: rgb(255 255 255 / 0.08);
    --header-nav-top-link-hover-indicator: transparent;
    --header-nav-top-link-active-color: var(--header-nav-top-link-hover-color);
    --header-nav-top-link-active-bg: var(--header-nav-top-link-hover-bg);
    --header-nav-top-link-active-indicator: transparent;
}
.transparent-header .widget-site-header.header-sticky:not(.header-scrolled) .header-logo,
.transparent-header .widget-site-header.header-sticky:not(.header-scrolled) .menu-toggle,
.transparent-header .widget-site-header.header-sticky:not(.header-scrolled) .header-contact-line {
    color: var(--colors-highlight_text_content, #fff) !important;
}
.transparent-header .widget-site-header.header-sticky:not(.header-scrolled) .widget-button-primary {
    background-color: var(--colors-highlight_accent, #de1877) !important;
    color: var(--colors-highlight_accent_text, #fff) !important;
    border-color: var(--colors-highlight_accent, #de1877) !important;
}
.transparent-header .widget-site-header.header-sticky:not(.header-scrolled) .widget-button-secondary {
    color: var(--colors-highlight_text_heading, #fff) !important;
    border-color: var(--colors-highlight_border_color, rgba(255, 255, 255, 0.5)) !important;
}

/* ── Mobile transparent nav (reset to normal colors) ── */
@media (max-width: ' . $_break_minus . 'px) {
    .transparent-header .widget-site-header:not(.header-sticky) .header-nav,
    .transparent-header .widget-site-header.header-sticky:not(.header-scrolled) .header-nav {
        color: var(--text-content) !important;
    }
    .transparent-header .widget-site-header:not(.header-sticky) .header-nav .nav-close-title,
    .transparent-header .widget-site-header:not(.header-sticky) .header-nav .nav-close-btn,
    .transparent-header .widget-site-header:not(.header-sticky) .header-nav .nav-item > a,
    .transparent-header .widget-site-header:not(.header-sticky) .header-nav .nav-item > button:not(.submenu-toggle),
    .transparent-header .widget-site-header:not(.header-sticky) .header-nav .submenu-toggle,
    .transparent-header .widget-site-header:not(.header-sticky) .header-nav .header-contact-line,
    .transparent-header .widget-site-header.header-sticky:not(.header-scrolled) .header-nav .nav-close-title,
    .transparent-header .widget-site-header.header-sticky:not(.header-scrolled) .header-nav .nav-close-btn,
    .transparent-header .widget-site-header.header-sticky:not(.header-scrolled) .header-nav .nav-item > a,
    .transparent-header .widget-site-header.header-sticky:not(.header-scrolled) .header-nav .nav-item > button:not(.submenu-toggle),
    .transparent-header .widget-site-header.header-sticky:not(.header-scrolled) .header-nav .submenu-toggle,
    .transparent-header .widget-site-header.header-sticky:not(.header-scrolled) .header-nav .header-contact-line {
        color: inherit !important;
    }
    .transparent-header .widget-site-header:not(.header-sticky) .header-nav .widget-button-primary,
    .transparent-header .widget-site-header.header-sticky:not(.header-scrolled) .header-nav .widget-button-primary {
        background-color: var(--accent) !important;
        color: var(--accent-text) !important;
        border-color: var(--accent) !important;
    }
    .transparent-header .widget-site-header:not(.header-sticky) .header-nav .widget-button-secondary,
    .transparent-header .widget-site-header.header-sticky:not(.header-scrolled) .header-nav .widget-button-secondary {
        background-color: transparent !important;
        color: var(--text-content) !important;
        border-color: var(--accent) !important;
    }
}

/* ── Desktop nav — dynamic breakpoint (replaces base.css @media 990px) ── */
@media (min-width: ' . $_break . 'px) {
    .widget-site-header {
        padding-inline: var(--space-xl);
    }
    .widget-site-header .header-actions {
        flex: 1;
        justify-content: flex-end;
    }
    .widget-site-header .menu-toggle {
        display: none;
    }
    .widget-site-header .nav-close {
        display: none;
    }
    .widget-site-header .header-nav {
        position: static;
        width: auto;
        height: auto;
        display: flex;
        align-items: center;
        background-color: transparent !important;
        padding: 0;
        overflow: visible;
        transform: none;
        box-shadow: none;
        inset-inline-end: auto;
        margin-top: 0;
    }
    .widget-site-header .nav-list {
        display: flex;
        gap: var(--space-xs);
        align-items: center;
    }
    .widget-site-header .nav-item {
        position: relative;
    }
    .widget-site-header .nav-item > a,
    .widget-site-header .nav-item > button:not(.submenu-toggle) {
        padding-block: 10px;
        padding-inline: var(--space-md);
        font-size: calc(var(--font-size-sm) * var(--body-scale));
        border-radius: var(--radius-button);
        color: var(--header-nav-top-link-color) !important;
        box-shadow: none;
        transition: background-color 0.2s, color 0.2s;
    }
    .widget-site-header .nav-item > a:hover,
    .widget-site-header .nav-item > button:not(.submenu-toggle):hover {
        background-color: var(--header-nav-top-link-hover-bg) !important;
        color: var(--header-nav-top-link-hover-color) !important;
    }
    .widget-site-header .nav-item.is-active > a,
    .widget-site-header .nav-item > a[aria-current="page"] {
        background-color: var(--header-nav-top-link-active-bg) !important;
        color: var(--header-nav-top-link-active-color) !important;
        box-shadow: none;
    }
    .widget-site-header .header-contact-right .header-contact-line:first-child {
        /*first line*/
        position: relative;
    }
    .widget-site-header .header-contact-right .header-contact-line:last-child {
         /*secondline line*/
          position: relative;
    }
    .widget-site-header .nav-item .submenu-toggle {
        display: none;
    }
    .widget-site-header .nav-item:hover > .nav-submenu,
    .widget-site-header .nav-item:focus-within > .nav-submenu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    .widget-site-header .nav-submenu {
        position: absolute;
        inset-block-start: calc(100% - 0.4rem);
        inset-inline-start: 0;
        min-width: 22rem;
        background-color: var(--color-white) !important;
        border: var(--border-width-thin) solid var(--border-color);
        border-radius: var(--radius-md);
        max-height: none;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-0.5rem);
        transition: opacity var(--transition-speed-fast) ease, visibility var(--transition-speed-fast) ease, transform var(--transition-speed-fast) ease;
        overflow: visible;
        padding-block: var(--space-xs);
        padding-inline: 0;
    }
    .widget-site-header .nav-submenu .nav-item {
        position: static;
        padding: 0;
    }
    .widget-site-header .nav-submenu .nav-item > a,
    .widget-site-header .nav-submenu .nav-item > button:not(.submenu-toggle) {
        padding-block: 6px;
        padding-inline: var(--space-md);
        font-size: calc(var(--font-size-sm) * var(--body-scale));
        border-radius: 0;
        color: var(--header-nav-row-link-color) !important;
        box-shadow: inset 0 0 0 0 transparent;
        transition: background-color 0.2s, color 0.2s, box-shadow 0.2s;
    }
    .widget-site-header .nav-submenu .nav-item > a:hover,
    .widget-site-header .nav-submenu .nav-item > button:not(.submenu-toggle):hover {
        background-color: var(--header-nav-row-hover-bg) !important;
        color: var(--header-nav-row-hover-color) !important;
    }
    .widget-site-header .nav-submenu .nav-item.has-submenu {
        position: relative;
    }
    .widget-site-header .nav-submenu .nav-submenu {
        position: absolute;
        inset-block-start: 0;
        inset-inline-start: calc(100% - 0.4rem);
        min-width: 22rem;
        background-color: var(--color-white) !important;
        border: var(--border-width-thin) solid var(--border-color);
        border-radius: var(--radius-md);
        padding-block: var(--space-xs);
        padding-inline: 0;
        max-height: none;
        opacity: 0;
        visibility: hidden;
        transform: translateX(-0.5rem);
        transition: opacity var(--transition-speed-fast) ease, visibility var(--transition-speed-fast) ease, transform var(--transition-speed-fast) ease;
    }
    .widget-site-header .nav-submenu:hover > .nav-submenu,
    .widget-site-header .nav-submenu:focus-within > .nav-submenu {
        opacity: 1;
        visibility: visible;
        transform: translateX(0);
    }
    .widget-site-header .mobile-cta {
        display: none;
    }
    .widget-site-header .desktop-cta {
        display: inline-block;
    }
    .widget-site-header .header-contact-mobile {
        display: none;
    }
    .widget-site-header .header-contact-right {
        display: flex;
    }
    .widget-site-header .header-end {
        display: flex;
    }
}

.widget-site-header .nav-submenu .nav-item > a:hover,
.widget-site-header .nav-submenu .nav-item > button:not(.submenu-toggle):hover {
    background-color: var(--colors-highlight_bg_secondary) !important;
    color: var(--colors-highlight_text_heading) !important;
}

/* ── Mobile nav ── */
@media (max-width: ' . $_break_minus . 'px) {
    .widget-site-header .header-nav {
        position: fixed !important;
        inset-inline-end: -800px !important;
        width: 32rem !important;
        height: 100vh !important;
        display: block !important;
        margin-top: 0 !important;
    }
    .widget-site-header .header-nav.nav-open {
        inset-inline-end: 0 !important;
    }
    .widget-site-header .header-nav-row .header-nav {
        max-width: 320px;
    }
    .widget-site-header .header-nav-row.nav-row-open {
        display: flex !important;
        z-index: 9999;
        position: relative;
    }
    .widget-site-header .nav-item > a,
    .widget-site-header .nav-item > button:not(.submenu-toggle) {
        padding-block: 5px !important;
    }
    .widget-site-header .submenu-toggle svg {
        width: 25px !important;
        height: 25px !important;
    }
    .widget-site-header .submenu-toggle {
        width: 35px !important;
        height: 35px !important;
    }
    #header nav ul ul.nav-submenu {
        box-shadow: none !important;
    }
}

</style>';
echo $_wdg_asset_html . $_output;
?>
<js>
    (function ($) {
    $(function () {
    // Fix overflow-x στο builder container για να φαίνονται τα submenus
    $(".container[data-builderID]").has(".widget-site-header").css("overflow-x", "visible");
<?php if($_header_transparent): ?>
    $('body').addClass('transparent-header');
<?php endif; ?>
    });
    }(jQuery));
</js>
