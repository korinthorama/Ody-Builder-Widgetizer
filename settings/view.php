<?php
/*
 * Widgetizer — Settings Widget — view.php
 *
 * Override των CSS color variables + font family variables.
 * Groups με accordion (ένα ανοιχτό τη φορά, όλα κλειστά αρχικά).
 * Χρησιμοποιεί το spectrum.js color picker (ίδιο με divider block).
 */

// Load themes from JSON
$_themes_json = file_get_contents(__DIR__ . '/colors.json');
$_themes_data = json_decode($_themes_json, true);
$_themes = $_themes_data['themes'];

// Current language ($langID = 1 for Greek, 2 for English)
$_lang_suffix = ($langID == 1) ? 'gr' : 'en';

$_colors = [
    'standard'  => [
        'label' => "Standard Color Scheme",
        'vars'  => [
            'colors-standard_bg_primary'   => ['label' => t("Φόντο Primary"), 'default' => '#ffffff'],
            'colors-standard_bg_secondary' => ['label' => t("Φόντο Secondary"), 'default' => '#f8fafc'],
            'colors-standard_text_content' => ['label' => t("Κείμενο"), 'default' => '#334155'],
            'colors-standard_text_heading' => ['label' => t("Επικεφαλίδες"), 'default' => '#0f172a'],
            'colors-standard_text_muted'   => ['label' => t("Muted κείμενο"), 'default' => '#6b7280'],
            'colors-standard_border_color' => ['label' => t("Περίγραμμα"), 'default' => '#e2e8f0'],
            'colors-standard_accent'       => ['label' => "Accent", 'default' => '#0f172a'],
            'colors-standard_accent_text'  => ['label' => t("Κείμενο Accent"), 'default' => '#ffffff'],
            'colors-standard_rating_star'  => ['label' => t("Αστέρια Rating"), 'default' => '#fbbf24'],
        ]
    ],
    'highlight' => [
        'label' => "Highlight Color Scheme",
        'vars'  => [
            'colors-highlight_bg_primary'   => ['label' => t("Φόντο Primary"), 'default' => '#0f172a'],
            'colors-highlight_bg_secondary' => ['label' => t("Φόντο Secondary"), 'default' => '#020617'],
            'colors-highlight_text_content' => ['label' => t("Κείμενο"), 'default' => '#cbd5e1'],
            'colors-highlight_text_heading' => ['label' => t("Επικεφαλίδες"), 'default' => '#ffffff'],
            'colors-highlight_text_muted'   => ['label' => t("Muted κείμενο"), 'default' => '#94a3b8'],
            'colors-highlight_border_color' => ['label' => t("Περίγραμμα"), 'default' => '#334155'],
            'colors-highlight_accent'       => ['label' => "Accent", 'default' => '#ffffff'],
            'colors-highlight_accent_text'  => ['label' => t("Κείμενο Accent"), 'default' => '#0f172a'],
            'colors-highlight_rating_star'  => ['label' => t("Αστέρια Rating"), 'default' => '#fbbf24'],
        ]
    ],
];
$_fonts = [
    ['value' => 'Inter', 'label' => 'Inter', 'category' => 'Sans-serif'],
    ['value' => 'Inter Tight', 'label' => 'Inter Tight', 'category' => 'Sans-serif'],
    ['value' => 'Roboto', 'label' => 'Roboto', 'category' => 'Sans-serif'],
    ['value' => 'Roboto Condensed', 'label' => 'Roboto Condensed', 'category' => 'Sans-serif'],
    ['value' => 'Roboto Flex', 'label' => 'Roboto Flex', 'category' => 'Sans-serif'],
    ['value' => 'Open Sans', 'label' => 'Open Sans', 'category' => 'Sans-serif'],
    ['value' => 'Google Sans', 'label' => 'Google Sans', 'category' => 'Sans-serif'],
    ['value' => 'Noto Sans', 'label' => 'Noto Sans', 'category' => 'Sans-serif'],
    ['value' => 'Fira Sans Condensed', 'label' => 'Fira Sans Condensed', 'category' => 'Sans-serif'],
    ['value' => 'Play', 'label' => 'Play', 'category' => 'Sans-serif'],
    ['value' => 'Ubuntu Condensed', 'label' => 'Ubuntu Condensed', 'category' => 'Sans-serif'],
    ['value' => 'Sofia Sans Condensed', 'label' => 'Sofia Sans Condensed', 'category' => 'Sans-serif'],
    ['value' => 'Sofia Sans Extra Condensed', 'label' => 'Sofia Sans Extra Condensed', 'category' => 'Sans-serif'],
    ['value' => 'Jura', 'label' => 'Jura', 'category' => 'Sans-serif'],
    ['value' => 'Dela Gothic One', 'label' => 'Dela Gothic One', 'category' => 'Display'],
    ['value' => 'Playpen Sans', 'label' => 'Playpen Sans', 'category' => 'Handwriting'],
    ['value' => 'Eczar', 'label' => 'Eczar', 'category' => 'Serif'],
];
?>
<style>
    #ody_builder_block_content {
        width: 100%;
        max-width: 402px;
    }

    .ody_builder_parameter {
        max-width: 402px !important;
    }

    .sp-replacer {
        scale: .8;
    }

    /* ── Accordion ────────────────────────────────────────────────────────── */
    .wdg-settings-group {
        max-width: 402px;
        border: 1px solid #002e3a;
        border-radius: 6px;
        margin: 30px 0 2px;
        overflow: hidden;
    }

    .wdg-settings-group-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        background: #f1f5f9;
        cursor: pointer;
        user-select: none;
        font-weight: 600;
        font-size: 15px;
        color: #002e3a;
    }

    .wdg-settings-group-header:hover {
        background: #e2e8f0;
    }

    .wdg-settings-group-arrow {
        font-size: 11px;
        transition: transform 0.2s ease;
        color: #002e3a;
    }

    .wdg-settings-group.is-open .wdg-settings-group-arrow {
        transform: rotate(180deg);
    }

    .wdg-settings-group-body {
        display: none;
        padding: 10px 14px 4px;
        background: #ffffff;
    }

    .wdg-settings-group-body .ody_builder_parameter {
        max-width: 100% !important;
    }

    /* ── Color scheme sections inside accordion ─────────────────────────────── */
    .wdg-color-scheme-section {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        margin: 15px 0 10px;
        overflow: hidden;
    }
    
    .wdg-color-scheme-header {
        background: #f8fafc;
        padding: 8px 12px;
        font-weight: 600;
        font-size: 14px;
        color: #002e3a;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .wdg-color-scheme-body {
        padding: 12px;
    }
    
    /* ── Color rows: label + picker σε μία σειρά ───────────────────────────── */
    .wdg-color-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    
    .wdg-color-row label {
        flex: 1;
        margin-bottom: 0;
        font-size: 13px;
        color: #334155;
    }
    
    .wdg-color-row .sp-replacer {
        flex-shrink: 0;
        margin: 0;
    }
    
    /* ── Preset section inside accordion ────────────────────────────────────── */
    .wdg-preset-section {
        margin-bottom: 20px;
        padding: 12px;
        background: #f8fafc;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
    }
    
    .wdg-preset-section label {
        font-weight: 600;
        display: block;
        margin-bottom: 8px;
        color: #000000;
        font-size: 13px;
    }
    
    .wdg-preset-description {
        font-size: 12px;
        color: #6b7280;
        margin-top: 8px;
        font-style: italic;
        line-height: 1.4;
    }
    
    /* ── Color preview swatches ─────────────────────────────────────────────── */
    .wdg-swatch-row {
        display: flex;
        flex-direction: column;
        margin: 12px 0 8px;
        gap: 8px;
    }
    
    .wdg-swatch-group {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 11px;
        font-weight: 600;
        color: #334155;
    }
    
    .wdg-swatch-group-label {
        width: 55px;
        flex-shrink: 0;
    }
    
    .wdg-swatches {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }
    
    .wdg-swatch {
        width: 16px;
        height: 16px;
        box-shadow: 0 0 0 1px #838383;
        cursor: pointer;
        transition: transform 0.1s ease;
    }
    
    .wdg-swatch:hover {
        transform: scale(1.05);
        box-shadow: 0 0 0 2px #002e3a;
    }
    
    /* ── Font preview ─────────────────────────────────────────────────────── */
    .wdg-font-preview {
        display: block;
        margin-top: 6px;
        font-size: 15px;
        color: #002e3a;
        line-height: 1.4;
        min-height: 22px;
    }

    .wdg-font-select {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        padding: 5px 10px;
    }
    
    /* ── Select2 customizations ────────────────────────────────────────────── */
    .select2-container--default .select2-results__option--highlighted .select2-results__option small {
        color: #e2e8f0 !important;
    }
</style>

<!-- ── ACCORDION 1: COLORS ─────────────────────────────────────────────────── -->
<div class="wdg-settings-group" data-group="colors">
    <div class="wdg-settings-group-header">
        <span>Colors</span>
        <span class="wdg-settings-group-arrow">▼</span>
    </div>
    <div class="wdg-settings-group-body">
        
        <!-- PRESET SELECTOR (μέσα στο Colors accordion) -->
        <div class="wdg-preset-section">
            <label for="wdg_preset_global">🎨 <?php echo t("Φόρτωση παλέτας χρωμάτων"); ?></label>
            <select id="wdg_preset_global" style="width: 100%;">
                <option value="" selected disabled style="color: #999;">-- <?php echo t("επιλέξτε preset"); ?> --</option>
                <?php foreach($_themes as $idx => $theme): ?>
                    <option value="<?php echo $idx; ?>"
                            data-description-en="<?php echo htmlspecialchars($theme['en']['description']); ?>"
                            data-description-gr="<?php echo htmlspecialchars($theme['gr']['description']); ?>">
                        <?php echo htmlspecialchars($theme[$_lang_suffix]['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="wdg-preset-description" id="wdg_preset_global_desc"></div>
            
            <!-- Χρωματικά δείγματα (θα γεμίσουν με JS) -->
            <div id="wdg_preset_swatches" class="wdg-swatch-row" style="display: none;">
                <div class="wdg-swatch-group">
                    <div class="wdg-swatches" id="wdg_swatches_standard"></div>
                </div>
                <div class="wdg-swatch-group">
                    <div class="wdg-swatches" id="wdg_swatches_highlight"></div>
                </div>
            </div>
        </div>
        
        <!-- STANDARD COLOR SCHEME (fieldset style) -->
        <div class="wdg-color-scheme-section">
            <div class="wdg-color-scheme-header">
                Standard Color Scheme
            </div>
            <div class="wdg-color-scheme-body">
                <?php foreach($_colors['standard']['vars'] as $var_key => $var): ?>
                    <div class="wdg-color-row">
                        <label for="wdg_color_<?php echo $var_key; ?>"><?php echo $var['label']; ?></label>
                        <input type="text"
                               id="wdg_color_<?php echo $var_key; ?>"
                               data-preferred-format="hex"
                               data-var="<?php echo $var_key; ?>"
                               value="<?php echo $var['default']; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- HIGHLIGHT COLOR SCHEME (fieldset style) -->
        <div class="wdg-color-scheme-section">
            <div class="wdg-color-scheme-header">
                Highlight Color Scheme
            </div>
            <div class="wdg-color-scheme-body">
                <?php foreach($_colors['highlight']['vars'] as $var_key => $var): ?>
                    <div class="wdg-color-row">
                        <label for="wdg_color_<?php echo $var_key; ?>"><?php echo $var['label']; ?></label>
                        <input type="text"
                               id="wdg_color_<?php echo $var_key; ?>"
                               data-preferred-format="hex"
                               data-var="<?php echo $var_key; ?>"
                               value="<?php echo $var['default']; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
    </div>
</div>

<!-- ── ACCORDION 2: TYPOGRAPHY ──────────────────────────────────────────────── -->
<div class="wdg-settings-group" data-group="typography">
    <div class="wdg-settings-group-header">
        <span>Typography</span>
        <span class="wdg-settings-group-arrow">▼</span>
    </div>
    <div class="wdg-settings-group-body">
        <div class="ody_builder_parameter">
            <label for="wdg_font_heading"><?php echo t("Font Επικεφαλίδων"); ?></label>
            <select id="wdg_font_heading" class="wdg-font-select" data-font-var="typography-heading_font-family">
                <?php foreach($_fonts as $_f): ?>
                    <option value="<?php echo htmlspecialchars($_f['value']); ?>"
                            data-category="<?php echo $_f['category']; ?>">
                        <?php echo htmlspecialchars($_f['label']); ?> — <?php echo $_f['category']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span class="wdg-font-preview" id="wdg_font_heading_preview">
                Όλοι οι άνθρωποι γεννιούνται ελεύθεροι και ίσοι στην αξιοπρέπεια και τα δικαιώματα
            </span>
        </div>
        <div class="ody_builder_parameter">
            <label for="wdg_font_body"><?php echo t("Font Κειμένου"); ?></label>
            <select id="wdg_font_body" class="wdg-font-select" data-font-var="typography-body_font-family">
                <?php foreach($_fonts as $_f): ?>
                    <option value="<?php echo htmlspecialchars($_f['value']); ?>"
                            data-category="<?php echo $_f['category']; ?>">
                        <?php echo htmlspecialchars($_f['label']); ?> — <?php echo $_f['category']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span class="wdg-font-preview" id="wdg_font_body_preview">
                Όλοι οι άνθρωποι γεννιούνται ελεύθεροι και ίσοι στην αξιοπρέπεια και τα δικαιώματα
            </span>
        </div>
    </div>
</div>

<script>
jQuery(function ($) {
    var _p = _saved_params || {};
    
    // Themes data from PHP
    var themesData = <?php echo json_encode($_themes); ?>;
    var currentLang = '<?php echo $_lang_suffix; ?>';

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : def;
    }

    var palette = [
        ["#000", "#444", "#666", "#999", "#ccc", "#eee", "#f3f3f3", "#fff"],
        ["#f00", "#f90", "#ff0", "#0f0", "#0ff", "#00f", "#90f", "#f0f"],
        ["#f4cccc", "#fce5cd", "#fff2cc", "#d9ead3", "#d0e0e3", "#cfe2f3", "#d9d2e9", "#ead1dc"],
        ["#ea9999", "#f9cb9c", "#ffe599", "#b6d7a8", "#a2c4c9", "#9fc5e8", "#b4a7d6", "#d5a6bd"],
        ["#e06666", "#f6b26b", "#ffd966", "#93c47d", "#76a5af", "#6fa8dc", "#8e7cc3", "#c27ba0"],
        ["#c00", "#e69138", "#f1c232", "#6aa84f", "#45818e", "#3d85c6", "#674ea7", "#a64d79"],
        ["#900", "#b45f06", "#bf9000", "#38761d", "#134f5c", "#0b5394", "#351c75", "#741b47"],
        ["#600", "#783f04", "#7f6000", "#274e13", "#0c343d", "#073763", "#20124d", "#4c1130"]
    ];
    
    // ── Helper: Scroll to picker element and open spectrum ──────────────────
    function scrollToPickerAndOpen($target) {
        if(!$target.length) return;
        
        // Get the .wdg-color-row container
        var $row = $target.closest('.wdg-color-row');
        if($row.length) {
            // Smooth scroll to the row
            $('html, body').animate({
                scrollTop: $row.offset().top - 100
            }, 300, function() {
                // Highlight briefly
                $row.css('transition', 'background-color 0.3s');
                $row.css('background-color', '#e8f0fe');
                setTimeout(function() {
                    $row.css('background-color', '');
                }, 800);
                
                // Open the spectrum picker
                $target.spectrum('show');
            });
        } else {
            // Fallback: just open
            $target.spectrum('show');
        }
    }

    // ── Function to update swatches from theme data ──────────────────────────
    function updateSwatchesFromTheme(theme) {
        if(!theme) return false;

        var standardColors = theme.standardColors;
        var highlightColors = theme.highlightColors;

        if(!standardColors || !highlightColors) return false;

        // Χαρτογράφηση: κλειδί JSON → data-var attribute (standard)
        var standardMapping = {
            'primaryBackground':   'colors-standard_bg_primary',
            'secondaryBackground': 'colors-standard_bg_secondary',
            'contentText':         'colors-standard_text_content',
            'headingText':         'colors-standard_text_heading',
            'mutedText':           'colors-standard_text_muted',
            'borderColor':         'colors-standard_border_color',
            'accentColor':         'colors-standard_accent',
            'accentTextColor':     'colors-standard_accent_text',
            'ratingStarColor':     'colors-standard_rating_star'
        };

        // Χαρτογράφηση: κλειδί JSON → data-var attribute (highlight)
        var highlightMapping = {
            'primaryBackground':   'colors-highlight_bg_primary',
            'secondaryBackground': 'colors-highlight_bg_secondary',
            'contentText':         'colors-highlight_text_content',
            'headingText':         'colors-highlight_text_heading',
            'mutedText':           'colors-highlight_text_muted',
            'borderColor':         'colors-highlight_border_color',
            'accentColor':         'colors-highlight_accent',
            'accentTextColor':     'colors-highlight_accent_text',
            'ratingStarColor':     'colors-highlight_rating_star'
        };

        // Σειρά εμφάνισης swatches
        var orderKeys = [
            'primaryBackground', 'secondaryBackground', 'borderColor',
            'contentText', 'headingText', 'mutedText',
            'accentColor', 'accentTextColor', 'ratingStarColor'
        ];

        // Clear containers
        $('#wdg_swatches_standard').empty();
        $('#wdg_swatches_highlight').empty();

        // Add standard swatches
        for(var i = 0; i < orderKeys.length; i++) {
            var key = orderKeys[i];
            var color = standardColors[key];
            if(color) {
                var varKey = standardMapping[key];
                var $swatch = $('<div class="wdg-swatch" title="' + key + '"></div>');
                $swatch.css('background-color', color);
                // Click to find and highlight the corresponding color picker
                $swatch.on('click', (function(varKeyName, colorValue) {
                    return function() {
                        var $target = $('input[data-var="' + varKeyName + '"]');
                        if($target.length) {
                            $target.spectrum('set', colorValue);
                            $target.val(colorValue);
                            scrollToPickerAndOpen($target);
                        } else {
                            console.log('Not found: input[data-var="' + varKeyName + '"]');
                        }
                    };
                })(varKey, color));
                $('#wdg_swatches_standard').append($swatch);
            }
        }

        // Add highlight swatches
        for(var i = 0; i < orderKeys.length; i++) {
            var key = orderKeys[i];
            var color = highlightColors[key];
            if(color) {
                var varKey = highlightMapping[key];
                var $swatch = $('<div class="wdg-swatch" title="' + key + '"></div>');
                $swatch.css('background-color', color);
                $swatch.on('click', (function(varKeyName, colorValue) {
                    return function() {
                        var $target = $('input[data-var="' + varKeyName + '"]');
                        if($target.length) {
                            $target.spectrum('set', colorValue);
                            $target.val(colorValue);
                            scrollToPickerAndOpen($target);
                        } else {
                            console.log('Not found: input[data-var="' + varKeyName + '"]');
                        }
                    };
                })(varKey, color));
                $('#wdg_swatches_highlight').append($swatch);
            }
        }

        return true;
    }

    // ── Accordion ─────────────────────────────────────────────────────────────
    $('.wdg-settings-group-header').on('click', function () {
        var $group = $(this).closest('.wdg-settings-group');
        var isOpen = $group.hasClass('is-open');
        // Κλείσε όλα
        $('.wdg-settings-group.is-open').each(function () {
            $(this).removeClass('is-open');
            $(this).find('.wdg-settings-group-body').slideUp(200);
        });
        // Άνοιξε αυτό αν ήταν κλειστό
        if(!isOpen) {
            $group.addClass('is-open');
            $group.find('.wdg-settings-group-body').slideDown(200);
        }
    });
    
    // ── Color pickers ─────────────────────────────────────────────────────────
    $('input[data-var]').each(function () {
        var varKey = $(this).data('var');
        var savedVal = pval(varKey, '');
        if(savedVal) {
            $(this).val(savedVal.replace('[id]', '#'));
        }
        $(this).spectrum({
            showInput:       true,
            showPalette:     true,
            showAlpha:       false,
            palette:         palette,
            preferredFormat: 'hex'
        });
    });
    
    // ── GLOBAL Preset colors loading function (ενημερώνει Standard + Highlight) ──
    function loadGlobalPreset(themeIndex) {
        if(themeIndex === null || themeIndex === '' || !themesData[themeIndex]) return;
        
        var theme = themesData[themeIndex];
        
        // Standard Colors mapping
        var standardColors = theme.standardColors;
        var standardMapping = {
            'primaryBackground':   'colors-standard_bg_primary',
            'secondaryBackground': 'colors-standard_bg_secondary',
            'contentText':         'colors-standard_text_content',
            'headingText':         'colors-standard_text_heading',
            'mutedText':           'colors-standard_text_muted',
            'borderColor':         'colors-standard_border_color',
            'accentColor':         'colors-standard_accent',
            'accentTextColor':     'colors-standard_accent_text',
            'ratingStarColor':     'colors-standard_rating_star'
        };
        
        // Highlight Colors mapping
        var highlightColors = theme.highlightColors;
        var highlightMapping = {
            'primaryBackground':   'colors-highlight_bg_primary',
            'secondaryBackground': 'colors-highlight_bg_secondary',
            'contentText':         'colors-highlight_text_content',
            'headingText':         'colors-highlight_text_heading',
            'mutedText':           'colors-highlight_text_muted',
            'borderColor':         'colors-highlight_border_color',
            'accentColor':         'colors-highlight_accent',
            'accentTextColor':     'colors-highlight_accent_text',
            'ratingStarColor':     'colors-highlight_rating_star'
        };
        
        // Update Standard pickers
        for(var jsonField in standardMapping) {
            if(standardColors[jsonField]) {
                var varKey = standardMapping[jsonField];
                var newValue = standardColors[jsonField];
                var $input = $('input[data-var="' + varKey + '"]');
                if($input.length) {
                    $input.spectrum('set', newValue);
                    $input.val(newValue);
                }
            }
        }
        
        // Update Highlight pickers
        for(var jsonField in highlightMapping) {
            if(highlightColors[jsonField]) {
                var varKey = highlightMapping[jsonField];
                var newValue = highlightColors[jsonField];
                var $input = $('input[data-var="' + varKey + '"]');
                if($input.length) {
                    $input.spectrum('set', newValue);
                    $input.val(newValue);
                }
            }
        }
        
        // Update swatches
        updateSwatchesFromTheme(theme);
    }
    
    // ── Initialize Select2 for GLOBAL preset select ──────────────────────────────
    if($.fn.select2) {
        $('#wdg_preset_global').select2({
            width: '100%',
            allowClear: false,
            templateResult: function(state) {
                if(!state.id) return state.text;
                var $option = $(state.element);
                var desc = (currentLang === 'gr') ? $option.data('description-gr') : $option.data('description-en');
                var $wrapper = $('<div><strong>' + state.text + '</strong><br/><small style="font-size:11px; color:#888;">' + (desc || '') + '</small></div>');
                return $wrapper;
            },
            templateSelection: function(state) {
                return state.text;
            }
        });
        
        // Handle global preset change
        $('#wdg_preset_global').on('change', function() {
            var $this = $(this);
            var selectedOption = $this.find('option:selected');
            var descId = '#wdg_preset_global_desc';
            
            if($this.val() && $this.val() !== '') {
                var desc = (currentLang === 'gr') ? selectedOption.data('description-gr') : selectedOption.data('description-en');
                $(descId).html('<span> ' + (desc || '') + '</span>');
                $('#wdg_preset_swatches').show();
                loadGlobalPreset(parseInt($this.val()));
            } else {
                $(descId).html('');
                $('#wdg_preset_swatches').hide();
            }
        });
    }
    
    // ── Font helpers ──────────────────────────────────────────────────────────
    var _loadedFonts = {'Inter': true};

    function loadGoogleFont(fontName) {
        if(_loadedFonts[fontName]) return;
        _loadedFonts[fontName] = true;
        var encoded = fontName.replace(/ /g, '+');
        var href = 'https://fonts.googleapis.com/css2?family=' + encoded
                + ':wght@400;600;700&subset=greek,latin&display=swap';
        var linkId = 'wdg-font-link-' + fontName.replace(/ /g, '-').toLowerCase();
        if(!document.getElementById(linkId)) {
            var link = document.createElement('link');
            link.id = linkId;
            link.rel = 'stylesheet';
            link.href = href;
            document.head.appendChild(link);
        }
    }

    function applyFontPreview(selectEl) {
        var fontName = $(selectEl).val();
        var previewId = $(selectEl).attr('id') + '_preview';
        loadGoogleFont(fontName);
        $('#' + previewId).css('font-family', '"' + fontName + '", sans-serif');
    }

    // ── Font selects: restore + init preview ─────────────────────────────────
    $('select[data-font-var]').each(function () {
        var varKey = $(this).data('font-var');
        var savedVal = pval(varKey, 'Inter');
        $(this).val(savedVal);
        applyFontPreview(this);
    });
    $('select[data-font-var]').on('change', function () {
        applyFontPreview(this);
    });
    
    // ── Label ─────────────────────────────────────────────────────────────────
    label = 'Widget Widgetizer Settings';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Settings');
    
    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function () {
        var params = {};
        // Colors
        $('input[data-var]').each(function () {
            var varKey = $(this).data('var');
            params[varKey] = $(this).val().replace('#', '[id]');
        });
        // Fonts — αποθηκεύουμε μόνο αν δεν είναι Inter (default)
        $('select[data-font-var]').each(function () {
            var varKey = $(this).data('font-var');
            var fontVal = $(this).val();
            if(fontVal && fontVal !== 'Inter') {
                params[varKey] = fontVal;
            }
        });
        return {
            widget_id: 'settings',
            params:    params
        };
    };
});
</script>