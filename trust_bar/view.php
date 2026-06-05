<?php defined('CMS') or die("This file cannot run this way!"); ?>
<style>
    .ody_builder_parameter {
        max-width: 500px !important;
    }

    .wdg-trbr-item {
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 8px;
        background: #f9f9f9;
    }

    .wdg-trbr-item-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
        cursor: move;
    }

    .wdg-trbr-item-header span {
        color: white;
        font-size: 12px;
        flex: 1;
    }

    .wdg-trbr-item-body {
        padding: 8px;
    }

    .wdg-trbr-item-body .ody_builder_parameter {
        max-width: 100% !important;
        margin-bottom: 6px;
    }

    .wdg-trbr-icon-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 4px;
    }

    .wdg-trbr-icon-preview {
        font-size: 28px;
        color: #002e3a;
        width: 36px;
        text-align: center;
        visibility: hidden;
    }
</style>

<!-- ══ ΕΜΦΑΝΙΣΗ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_trbr_icon_style"><?php echo t("Τύπος εικονιδίου"); ?></label>
    <select id="wdg_trbr_icon_style" class="listbox">
        <option value="w-icon-plain"><?php echo t("Απλό"); ?></option>
        <option value="w-icon-outline"><?php echo t("Με περίγραμμα"); ?></option>
        <option value="w-icon-filled"><?php echo t("Με γέμισμα"); ?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_trbr_icon_size"><?php echo t("Μέγεθος Εικονιδίου"); ?></label>
    <select id="wdg_trbr_icon_size" class="listbox">
        <option value="w-icon-sm"><?php echo t("Μικρό"); ?></option>
        <option value="w-icon-md"><?php echo t("Μεσαίο"); ?></option>
        <option value="w-icon-lg" selected><?php echo t("Μεγάλο"); ?></option>
        <option value="w-icon-xl"><?php echo t("Τεράστιο"); ?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_trbr_icon_shape"><?php echo t("Σχήμα Εικονιδίου"); ?></label>
    <select id="wdg_trbr_icon_shape" class="listbox">
        <option value="w-icon-sharp"><?php echo t("Τετραγωνισμένο"); ?></option>
        <option value="w-icon-rounded"><?php echo t("Με στρογγυλεμένες γωνίες"); ?></option>
        <option value="w-icon-circle" selected><?php echo t("Κυκλικό"); ?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_trbr_alignment"><?php echo t("Στοίχιση"); ?></label>
    <select id="wdg_trbr_alignment" class="listbox">
        <option value="start"><?php echo t("Αριστερά"); ?></option>
        <option value="center" selected><?php echo t("Κέντρο"); ?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_trbr_show_dividers" value="1" checked>
        <p><?php echo t("Εμφάνιση Διαχωριστικών"); ?></p>
    </div>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_trbr_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_trbr_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_trbr_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_trbr_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl" selected>X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>

<!-- ══ ITEMS ══════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title">Items</div>

<div id="wdg_trbr_items_container" class="ody_builder_parameter">
    <div id="wdg_trbr_items_list"></div>
    <button type="button" id="wdg_trbr_add_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη"); ?> Item
    </button>
</div>

<script>
jQuery(function ($) {
    var _p = _saved_params || {};
    var _items = _p['items'] || [];
    var _item_idx = 0;
    var _MAX_ITEMS = 4;

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    // ── Restore scalars ────────────────────────────────────────────────────────
    $('#wdg_trbr_icon_style').val(pval('icon_style', 'w-icon-plain'));
    $('#wdg_trbr_icon_size').val(pval('icon_size', 'w-icon-lg'));
    $('#wdg_trbr_icon_shape').val(pval('icon_shape', 'w-icon-circle'));
    $('#wdg_trbr_alignment').val(pval('alignment', 'center'));
    
    if (pval('show_dividers', '1') !== '0') {
        $('#wdg_trbr_show_dividers').prop('checked', true);
    } else {
        $('#wdg_trbr_show_dividers').prop('checked', false);
    }
    
    $('#wdg_trbr_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_trbr_container_width').val(pval('container_width', 'xl'));

    // ── odyRecieveIcon callback ───────────────────────────────────────────────
    window.odyRecieveIcon = function (icon_class, target_id) {
        $('#' + target_id).val(icon_class);
        var $picker = $('[data-icon-target="' + target_id + '"]');
        var previewId = $picker.data('icon-preview');
        if (previewId) {
            $('#' + previewId).removeClass().addClass('fa ' + icon_class + ' wdg-trbr-icon-preview').css('visibility', 'visible');
        }
        parent.window.venobox.close();
    };

    // ── checkAddBtn ───────────────────────────────────────────────────────────
    function checkAddBtn() {
        var count = $('#wdg_trbr_items_list .wdg-trbr-item').length;
        $('#wdg_trbr_add_btn').toggle(count < _MAX_ITEMS);
    }

    // ── addItem ────────────────────────────────────────────────────────────────
    function addItem(data) {
        data = data || {};
        if ($('#wdg_trbr_items_list .wdg-trbr-item').length >= _MAX_ITEMS) return;
        
        var idx = _item_idx++;
        var iconFieldId = 'wdg_trbr_icon_' + idx;
        var iconPreviewId = 'wdg_trbr_icon_preview_' + idx;
        var iconPickerId = 'wdg_trbr_icon_picker_' + idx;
        
        var $item = $('<div class="wdg-trbr-item" data-idx="' + idx + '">');
        $item.append(
            '<div class="wdg-trbr-item-header">' +
            '<span>Item ' + ($('#wdg_trbr_items_list .wdg-trbr-item').length + 1) + '</span>' +
            '<button type="button" class="wdg-item-remove" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );
        
        var $body = $('<div class="wdg-trbr-item-body">');
        
        // ── Icon picker ───────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Εικονίδιο"); ?></label>' +
            '<div class="wdg-trbr-icon-row">' +
            '<i id="' + iconPreviewId + '" class="fa wdg-trbr-icon-preview"></i>' +
            '<a href="<?php echo array_search($block_type, $blocks); ?>-<?php echo $block_type; ?>/widgets/trust_bar/icons.php?venobox=[id]' + iconFieldId + '"' +
            ' id="' + iconPickerId + '" class="ody_builder_content_action btn btn-success" data-vbtype="iframe"' +
            ' data-icon-target="' + iconFieldId + '" data-icon-preview="' + iconPreviewId + '">' +
            '<?php echo t("Επιλογή εικονιδίου"); ?></a>' +
            '</div>' +
            '<input type="hidden" id="' + iconFieldId + '" value="">' +
            '</div>'
        );
        
        // ── Τίτλος ────────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?></label>' +
            '<input type="text" class="listbox wdg-trbr-title" value="' + $('<div>').text(data.title || '').html() + '"></div>'
        );
        
        // ── Κείμενο ───────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label>' +
            '<input type="text" class="listbox wdg-trbr-text" value="' + $('<div>').text(data.text || '').html() + '"></div>'
        );
        
        $item.append($body);
        $('#wdg_trbr_items_list').append($item);
        
        // VenoBox για icon picker
        window.venobox = new VenoBox({selector: '#' + iconPickerId, fitView: true, ratio: 'full'});
        
        // Restore icon
        if (data.icon_class) {
            $('#' + iconFieldId).val(data.icon_class);
            $('#' + iconPreviewId).removeClass().addClass('fa ' + data.icon_class + ' wdg-trbr-icon-preview').css('visibility', 'visible');
        }
        
        // Restore title + text
        if (data.title) $item.find('.wdg-trbr-title').val(data.title);
        if (data.text) $item.find('.wdg-trbr-text').val(data.text);
        
        // ── Item remove event listener (no onclick) ───────────────────────────
        $item.find('.wdg-item-remove').on('click', function () {
            $item.fadeOut(200, function () {
                $item.remove();
                renumberItems();
                checkAddBtn();
            });
        });
        
        // ── Sortable ─────────────────────────────────────────────────────────
        if ($.fn.sortable) {
            $('#wdg_trbr_items_list').sortable({
                handle: '.wdg-trbr-item-header',
                placeholder: 'block-placeholder',
                tolerance: 'pointer',
                stop: function () {
                    renumberItems();
                }
            });
        }
        
        checkAddBtn();
    }

    function renumberItems() {
        var items = $('#wdg_trbr_items_list .wdg-trbr-item');
        for (var i = 0; i < items.length; i++) {
            $(items[i]).find('.wdg-trbr-item-header span').text('Item ' + (i + 1));
        }
    }

    // ── Restore items ─────────────────────────────────────────────────────────
    for (var i = 0; i < _items.length; i++) {
        addItem(_items[i]);
    }
    
    $('#wdg_trbr_add_btn').on('click', function () {
        addItem({});
    });
    
    // ── Label ─────────────────────────────────────────────────────────────────
    var label = 'Widget Trust Bar';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Trust Bar');
    
    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function () {
        var items = [];
        var itemEls = $('#wdg_trbr_items_list .wdg-trbr-item');
        
        for (var i = 0; i < itemEls.length; i++) {
            var idx = $(itemEls[i]).data('idx');
            items.push({
                icon_class: $('#wdg_trbr_icon_' + idx).val(),
                title:      $(itemEls[i]).find('.wdg-trbr-title').val(),
                text:       $(itemEls[i]).find('.wdg-trbr-text').val()
            });
        }
        
        return {
            widget_id: 'trust_bar',
            params: {
                icon_style:      $('#wdg_trbr_icon_style').val(),
                icon_size:       $('#wdg_trbr_icon_size').val(),
                icon_shape:      $('#wdg_trbr_icon_shape').val(),
                alignment:       $('#wdg_trbr_alignment').val(),
                show_dividers:   $('#wdg_trbr_show_dividers').is(':checked') ? '1' : '0',
                color_scheme:    $('#wdg_trbr_color_scheme').val(),
                container_width: $('#wdg_trbr_container_width').val(),
                items:           items
            }
        };
    };
});
</script>