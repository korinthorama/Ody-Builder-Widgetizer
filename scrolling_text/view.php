<?php defined('CMS') or die("This file cannot run this way!"); ?>

<style>
    #ody_builder_block_content {
        display: table;
        margin: auto;
        width: 100%;
        max-width: 400px;
    }

    .ody_builder_parameter {
        max-width: 500px !important;
    }

    .wdg-scrt-item {
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 6px;
        background: #f0f4f4;
        transition: box-shadow 0.3s ease;
    }

    .wdg-scrt-item-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
    }

    .wdg-scrt-item-header span {
        color: white;
        font-size: 11px;
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .wdg-scrt-item-body {
        padding: 8px;
    }

    .wdg-scrt-item-body .ody_builder_parameter {
        max-width: 100% !important;
        margin-bottom: 5px;
    }

    input:disabled {
        background-color: #f9fad7 !important;
        color: gray !important;
    }

    /* ── Βελάκια μετακίνησης ── */
    .wdg-scrt-move-buttons { display: flex; gap: 4px; margin-right: 4px; }
    .wdg-scrt-move-btn { background: transparent; border: none; color: white; cursor: pointer; font-size: 12px; padding: 2px 4px; border-radius: 3px; transition: all 0.2s; }
    .wdg-scrt-move-btn:hover { background: rgba(255, 255, 255, 0.2); }
    .wdg-scrt-move-btn:active { transform: scale(0.9); }
</style>

<!-- ══ STRIPS ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Κυλιόμενα μηνύματα"); ?></div>
<div id="wdg_scrt_items_container" class="ody_builder_parameter">
    <div id="wdg_scrt_items_list"></div>
    <button type="button" id="wdg_scrt_add_item_btn" class="ody_builder_content_action btn btn-inverse" style="float:right; margin-top:6px;">
        + <?php echo t("Προσθήκη μηνύματος"); ?>
    </button>
</div>

<script>
jQuery(function ($) {
    var _p = _saved_params || {};
    var _items = _p['items'] || [];
    var _item_idx = 0;

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

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    // ── Item display ──────────────────────────────────────────────────────────
    function updateItemDisplay($item, textId) {
        var textVal = $('#' + textId).val();
        var itemNumber = $item.index() + 1;
        var displayText = '<?php echo t("Κυλιόμενο μήνυμα"); ?> ' + itemNumber;
        if (textVal && textVal.trim() !== '') {
            displayText += ': ' + textVal;
        }
        $item.find('.wdg-scrt-item-header span').text(displayText);
    }

    function renumberItems() {
        $('#wdg_scrt_items_list .wdg-scrt-item').each(function() {
            var $it = $(this);
            var ii  = $it.data('ii');
            var textId = 'wdg_scrt_text_scrt_' + ii;
            updateItemDisplay($it, textId);
        });
    }

    // ── Move functions ────────────────────────────────────────────────────────
    function moveItemUp($item, textId) {
        var $prev = $item.prev('.wdg-scrt-item');
        if ($prev.length) {
            $item.slideUp(1, function() {
                $item.insertBefore($prev);
                $item.slideDown(1, function() {
                    renumberItems();
                    $('html, body').animate({ scrollTop: $item.offset().top - 100 }, 300);
                    $item.css('box-shadow', '0 0 0 2px #fbbf24');
                    setTimeout(function() { $item.css('box-shadow', ''); }, 100);
                });
            });
        }
    }

    function moveItemDown($item, textId) {
        var $next = $item.next('.wdg-scrt-item');
        if ($next.length) {
            $item.slideUp(1, function() {
                $item.insertAfter($next);
                $item.slideDown(1, function() {
                    renumberItems();
                    $('html, body').animate({ scrollTop: $item.offset().top - 100 }, 300);
                    $item.css('box-shadow', '0 0 0 2px #fbbf24');
                    setTimeout(function() { $item.css('box-shadow', ''); }, 100);
                });
            });
        }
    }

    function addItem(data) {
        data = data || {};
        var ii    = _item_idx++;
        var uid   = 'scrt_' + ii;
        var textId = 'wdg_scrt_text_' + uid;

        var $item = $('<div class="wdg-scrt-item" data-ii="' + ii + '">');

        $item.append(
            '<div class="wdg-scrt-item-header">' +
            '<div class="wdg-scrt-move-buttons">' +
            '<button type="button" class="wdg-scrt-move-btn wdg-scrt-move-up" title="<?php echo t("Μετακίνηση πάνω"); ?>">▲</button>' +
            '<button type="button" class="wdg-scrt-move-btn wdg-scrt-move-down" title="<?php echo t("Μετακίνηση κάτω"); ?>">▼</button>' +
            '</div>' +
            '<span><?php echo t("Κυλιόμενο μήνυμα"); ?> ' + ($('#wdg_scrt_items_list .wdg-scrt-item').length + 1) + '</span>' +
            '<button type="button" class="wdg-item-remove" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );

        var $body = $('<div class="wdg-scrt-item-body">');

        // Text
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Μήνυμα"); ?></label>' +
            '<input type="text" id="' + textId + '" class="listbox" value="' + $('<div>').text(data.text || '').html() + '"></div>'
        );

        // Separator
        var _sep_val = data.separator || '★';
        var _sep_presets = ['★', '✦', '✧', '◆', '◇', '●', '○', '▪', '—', '·', '｜'];
        var _sep_is_custom = (_sep_presets.indexOf(_sep_val) === -1);
        var _sep_opts = '';
        for (var s = 0; s < _sep_presets.length; s++) {
            _sep_opts += '<option value="' + _sep_presets[s] + '"' + (_sep_val === _sep_presets[s] ? ' selected' : '') + '>' + _sep_presets[s] + '</option>';
        }
        _sep_opts += '<option value="__custom__"' + (_sep_is_custom ? ' selected' : '') + '><?php echo t("Άλλο"); ?></option>';

        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Διαχωριστής"); ?></label>' +
            '<div style="display:flex; gap:6px; align-items:center;">' +
            '<select id="wdg_scrt_sep_select_' + uid + '" class="listbox" style="max-width:90px !important;">' + _sep_opts + '</select>' +
            '<input type="text" id="wdg_scrt_sep_' + uid + '" class="listbox" value="' + $('<div>').text(_sep_val).html() + '" style="text-align: center; max-width:40px !important;"' + (_sep_is_custom ? '' : ' disabled') + '>' +
            '</div></div>'
        );

        // Background color
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Χρώμα Φόντου"); ?></label>' +
            '<input type="text" id="wdg_scrt_bg_' + uid + '" data-preferred-format="hex" class="listbox" value="#000000"></div>'
        );

        // Text color
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Χρώμα Κειμένου"); ?></label>' +
            '<input type="text" id="wdg_scrt_color_' + uid + '" data-preferred-format="hex" class="listbox" value="#ffffff"></div>'
        );

        // Rotation
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Κλίση"); ?></label>' +
            '<select id="wdg_scrt_rotate_' + uid + '" class="listbox" style="max-width: 148px !important;">' +
            '<option value="-3deg">-3°</option><option value="-2deg">-2°</option><option value="-1deg">-1°</option>' +
            '<option value="0deg" selected><?php echo t("Χωρίς κλίση"); ?></option>' +
            '<option value="1deg">1°</option><option value="2deg">2°</option><option value="3deg">3°</option>' +
            '</select></div>'
        );

        // Font size
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Μέγεθος γραμματοσειράς"); ?></label>' +
            '<select id="wdg_scrt_fsize_' + uid + '" class="listbox">' +
            '<option value="var(--font-size-sm)"><?php echo t("Μικρό"); ?></option>' +
            '<option value="var(--font-size-md)"><?php echo t("Κανονικό"); ?></option>' +
            '<option value="var(--font-size-lg)"><?php echo t("Μεγάλο"); ?></option>' +
            '<option value="var(--font-size-xl)" selected>XL</option>' +
            '<option value="var(--font-size-2xl)">2XL</option>' +
            '<option value="var(--font-size-3xl)">3XL</option>' +
            '</select></div>'
        );

        // Speed
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Ταχύτητα"); ?></label>' +
            '<select id="wdg_scrt_dur_' + uid + '" class="listbox">' +
            '<option value="100"><?php echo t("Πολύ αργά"); ?></option>' +
            '<option value="75"><?php echo t("Αργά"); ?></option>' +
            '<option value="50" selected><?php echo t("Κανονικά"); ?></option>' +
            '<option value="40"><?php echo t("Γρήγορα"); ?></option>' +
            '<option value="30"><?php echo t("Πολύ γρήγορα"); ?></option>' +
            '</select></div>'
        );

        // Padding
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Περιθώριο σε pixels"); ?></label>' +
            '<input type="number" id="wdg_scrt_padding_' + uid + '" class="listbox" min="0" max="100" step="1" value="60" style="max-width:100px !important;"></div>'
        );

        $item.append($body);
        $('#wdg_scrt_items_list').append($item);

        // ── Restore values ────────────────────────────────────────────────────
        var bgVal    = data.strip_bg    ? data.strip_bg.replace('[id]', '#')    : '#1e3a8a';
        var colorVal = data.strip_color ? data.strip_color.replace('[id]', '#') : '#ffffff';

        $('#wdg_scrt_bg_' + uid).val(bgVal).spectrum({
            showInput: true, showPalette: true, showAlpha: false,
            palette: palette, preferredFormat: 'hex'
        });

        $('#wdg_scrt_color_' + uid).val(colorVal).spectrum({
            showInput: true, showPalette: true, showAlpha: false,
            palette: palette, preferredFormat: 'hex'
        });

        if (data.strip_rotate)    $('#wdg_scrt_rotate_' + uid).val(data.strip_rotate);
        if (data.strip_font_size) $('#wdg_scrt_fsize_'  + uid).val(data.strip_font_size);
        if (data.scroll_duration) $('#wdg_scrt_dur_'    + uid).val(data.scroll_duration);
        if (data.padding !== undefined) $('#wdg_scrt_padding_' + uid).val(data.padding);

        // ── Separator select sync ─────────────────────────────────────────────
        setTimeout(function() {
            $('#wdg_scrt_sep_select_' + uid).on('change', function() {
                var val = $(this).val();
                if (val === '__custom__') {
                    $('#wdg_scrt_sep_' + uid).prop('disabled', false).val('').focus();
                } else {
                    $('#wdg_scrt_sep_' + uid).val(val).prop('disabled', true);
                }
            });
        }, 0);

        // ── Real-time text update ─────────────────────────────────────────────
        $('#' + textId).on('input', function() {
            updateItemDisplay($item, textId);
        });

        // ── Move buttons ──────────────────────────────────────────────────────
        $item.find('.wdg-scrt-move-up').on('click', function(e) {
            e.stopPropagation();
            moveItemUp($item, textId);
        });
        $item.find('.wdg-scrt-move-down').on('click', function(e) {
            e.stopPropagation();
            moveItemDown($item, textId);
        });

        // ── Remove button ─────────────────────────────────────────────────────
        $item.find('.wdg-item-remove').on('click', function() {
            $item.fadeOut(200, function() {
                $item.remove();
                renumberItems();
            });
        });

        updateItemDisplay($item, textId);
    }

    // ── Restore items ─────────────────────────────────────────────────────────
    for (var i = 0; i < _items.length; i++) {
        addItem(_items[i]);
    }

    $('#wdg_scrt_add_item_btn').on('click', function() { addItem({}); });

    // ── Label ─────────────────────────────────────────────────────────────────
    var label = 'Widget Scrolling Text';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Scrolling Text');

    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function() {
        var items = [];
        var itemEls = $('#wdg_scrt_items_list .wdg-scrt-item');
        for (var i = 0; i < itemEls.length; i++) {
            var ii  = $(itemEls[i]).data('ii');
            var uid = 'scrt_' + ii;
            items.push({
                text:            $('#wdg_scrt_text_'    + uid).val(),
                separator:       $('#wdg_scrt_sep_'     + uid).val(),
                strip_bg:        $('#wdg_scrt_bg_'      + uid).val().replace('#', '[id]'),
                strip_color:     $('#wdg_scrt_color_'   + uid).val().replace('#', '[id]'),
                strip_rotate:    $('#wdg_scrt_rotate_'  + uid).val(),
                strip_font_size: $('#wdg_scrt_fsize_'   + uid).val(),
                scroll_duration: $('#wdg_scrt_dur_'     + uid).val(),
                padding:         $('#wdg_scrt_padding_' + uid).val()
            });
        }
        return {
            widget_id: 'scrolling_text',
            params: { items: items }
        };
    };
});
</script>
