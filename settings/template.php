<?php
/*
 * Widgetizer — Settings Widget — template.php
 *
 * Βγάζει ένα <style> block με CSS variables
 * που κάνουν override τα defaults του base.css.
 * Υποστηρίζει: color variables + font-family variables.
 *
 * Διαθέσιμα: $wdg_params, $blockID
 */
if (empty($wdg_params)) return;

// ── Allowed font names (Greek subset στο Google Fonts) ────────────────────────
$_allowed_fonts = [
    'Inter', 'Inter Tight', 'Roboto', 'Roboto Condensed', 'Roboto Flex',
    'Open Sans', 'Google Sans', 'Noto Sans', 'Fira Sans Condensed', 'Play',
    'Ubuntu Condensed', 'Sofia Sans Condensed', 'Sofia Sans Extra Condensed',
    'Jura', 'Dela Gothic One', 'Playpen Sans', 'Eczar',
];

$_css_vars  = '';
$_font_links = '';

foreach ($wdg_params as $_key => $_val) {
    if (!$_val) continue;

    // ── Font variables ────────────────────────────────────────────────────────
    if ($_key === 'typography-heading_font-family' || $_key === 'typography-body_font-family') {
        // Sanitize: επιτρέπουμε μόνο fonts από τη λίστα
        if (!in_array($_val, $_allowed_fonts)) continue;
        // Inter = default του base.css → δεν χρειάζεται override ούτε link
        if ($_val === 'Inter') continue;
        // CSS variable
        $_font_stack = '"' . $_val . '", ' . (in_array($_val, ['Playfair Display', 'Lora', 'Source Serif 4']) ? 'serif' : 'sans-serif');
        $_css_vars .= '    --' . htmlspecialchars($_key) . ': ' . $_font_stack . ' !important;' . PHP_EOL;
        // Google Fonts link (μία φορά ανά font)
        $_encoded = str_replace(' ', '+', $_val);
        $_font_href = 'https://fonts.googleapis.com/css2?family=' . $_encoded . ':wght@400;600;700&subset=greek,latin&display=swap';
        if (strpos($_font_links, $_encoded) === false) {
            $_font_links .= '<link rel="stylesheet" href="' . $_font_href . '">' . PHP_EOL;
        }
        continue;
    }

    // ── Color variables ───────────────────────────────────────────────────────
    // Restore [id] → #
    $_val = str_replace('[id]', '#', $_val);
    // Sanitize: μόνο hex ή rgba
    if (!preg_match('/^#[0-9a-fA-F]{3,8}$|^rgba?\(/', $_val)) continue;
    $_css_vars .= '    --' . htmlspecialchars($_key) . ': ' . $_val . ' !important;' . PHP_EOL;
}

// ── Output ────────────────────────────────────────────────────────────────────
if ($_font_links) {
    echo $_font_links;
}

if ($_css_vars) {
    echo '<style id="widgetizer-settings-' . $blockID . '">' . PHP_EOL;
    echo ':root {' . PHP_EOL;
    echo $_css_vars;
    echo '}' . PHP_EOL;
    echo '</style>' . PHP_EOL;
}
