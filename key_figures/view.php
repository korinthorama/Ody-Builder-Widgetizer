<?php defined('CMS') or die("This file cannot run this way!"); ?>

<style>
    .ody_builder_parameter { max-width: 500px !important; }
    .wdg-kfg-item { border: 1px solid #ccc; border-radius: 4px; margin-bottom: 8px; background: #f9f9f9; transition: box-shadow 0.3s ease; }
    .wdg-kfg-item-header { display: flex; align-items: center; gap: 8px; padding: 6px 8px; background: #002e3a; border-radius: 4px 4px 0 0; }
    .wdg-kfg-item-header span { color: white; font-size: 12px; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .wdg-kfg-item-body { padding: 8px; }
    .wdg-kfg-item-body .ody_builder_parameter { max-width: 100% !important; margin-bottom: 6px; }
    .wdg-kfg-number-row { display: flex; gap: 8px; }
    .wdg-kfg-number-row .ody_builder_parameter { flex: 1; }

    /* ── Βελάκια μετακίνησης ── */
    .wdg-kfg-move-buttons { display: flex; gap: 4px; margin-right: 4px; }
    .wdg-kfg-move-btn { background: transparent; border: none; color: white; cursor: pointer; font-size: 12px; padding: 2px 4px; border-radius: 3px; transition: all 0.2s; }
    .wdg-kfg-move-btn:hover { background: rgba(255, 255, 255, 0.2); }
    .wdg-kfg-move-btn:active { transform: scale(0.9); }
</style>

<!-- ══ ΓΕΝΙΚΑ ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_kfg_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_kfg_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_kfg_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_kfg_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_kfg_description"><?php echo t("Περιγραφή"); ?></label>
    <textarea id="wdg_kfg_description" class="listbox" rows="3" style="resize:vertical;"></textarea>
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_kfg_columns"><?php echo t("Στήλες"); ?></label>
    <select id="wdg_kfg_columns" class="listbox">
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_kfg_card_layout"><?php echo t("Τύπος κάρτας"); ?></label>
    <select id="wdg_kfg_card_layout" class="listbox">
        <option value="box"><?php echo t("Με περίγραμμα");?></option>
        <option value="flat"><?php echo t("Χωρίς περίγραμμα");?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_kfg_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_kfg_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_kfg_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_kfg_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>

<!-- ══ ITEMS ══════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Κάρτες"); ?></div>
<div id="wdg_kfg_items_container" class="ody_builder_parameter">
    <div id="wdg_kfg_items_list"></div>
    <button type="button" id="wdg_kfg_add_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη"); ?>
    </button>
    <input type="hidden" id="wdg_kfg_items" value="">
</div>

<script>
jQuery(function ($) {
    var _p = _saved_params || {};
    var _item_idx = 0;

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    $('#wdg_kfg_eyebrow').val(pval('eyebrow'));
    $('#wdg_kfg_title').val(pval('title'));
    $('#wdg_kfg_description').val(pval('description'));
    $('#wdg_kfg_columns').val(pval('columns', '4'));
    $('#wdg_kfg_card_layout').val(pval('card_layout', 'box'));
    $('#wdg_kfg_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_kfg_container_width').val(pval('container_width', 'xl'));

    // ── Save items ────────────────────────────────────────────────────────────
    function saveItems() {
        var items = [];
        $('#wdg_kfg_items_list .wdg-kfg-item').each(function() {
            var $it = $(this);
            items.push({
                count:       $it.find('.wdg-kfg-count').val(),
                suffix:      $it.find('.wdg-kfg-suffix').val(),
                label:       $it.find('.wdg-kfg-label').val(),
                description: $it.find('.wdg-kfg-desc').val()
            });
        });
        $('#wdg_kfg_items').val(JSON.stringify(items));
    }

    // ── Item display ──────────────────────────────────────────────────────────
    function updateItemDisplay($item) {
        var labelVal = $item.find('.wdg-kfg-label').val();
        var itemNumber = $item.index() + 1;
        var displayText = '<?php echo t("Κάρτα"); ?> ' + itemNumber;
        if (labelVal && labelVal.trim() !== '') {
            displayText += ': ' + labelVal;
        }
        $item.find('.wdg-kfg-item-header span').text(displayText);
    }

    function renumberItems() {
        $('#wdg_kfg_items_list .wdg-kfg-item').each(function() {
            updateItemDisplay($(this));
        });
    }

    // ── Move functions ────────────────────────────────────────────────────────
    function moveItemUp($item) {
        var $prev = $item.prev('.wdg-kfg-item');
        if ($prev.length) {
            $item.slideUp(1, function() {
                $item.insertBefore($prev);
                $item.slideDown(1, function() {
                    renumberItems();
                    saveItems();
                    $('html, body').animate({ scrollTop: $item.offset().top - 100 }, 300);
                    $item.css('box-shadow', '0 0 0 2px #fbbf24');
                    setTimeout(function() { $item.css('box-shadow', ''); }, 100);
                });
            });
        }
    }

    function moveItemDown($item) {
        var $next = $item.next('.wdg-kfg-item');
        if ($next.length) {
            $item.slideUp(1, function() {
                $item.insertAfter($next);
                $item.slideDown(1, function() {
                    renumberItems();
                    saveItems();
                    $('html, body').animate({ scrollTop: $item.offset().top - 100 }, 300);
                    $item.css('box-shadow', '0 0 0 2px #fbbf24');
                    setTimeout(function() { $item.css('box-shadow', ''); }, 100);
                });
            });
        }
    }

    // ── Add Item ──────────────────────────────────────────────────────────────
    function addItem(data) {
        data = data || {};
        var idx = _item_idx++;

        var $item = $('<div class="wdg-kfg-item" data-idx="' + idx + '">');
        $item.append(
            '<div class="wdg-kfg-item-header">' +
            '<div class="wdg-kfg-move-buttons">' +
            '<button type="button" class="wdg-kfg-move-btn wdg-kfg-move-up" title="<?php echo t("Μετακίνηση πάνω"); ?>">▲</button>' +
            '<button type="button" class="wdg-kfg-move-btn wdg-kfg-move-down" title="<?php echo t("Μετακίνηση κάτω"); ?>">▼</button>' +
            '</div>' +
            '<span><?php echo t("Κάρτα"); ?> ' + ($('#wdg_kfg_items_list .wdg-kfg-item').length + 1) + '</span>' +
            '<button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );

        var $body = $('<div class="wdg-kfg-item-body">');

        $body.append(
            '<div class="wdg-kfg-number-row">' +
            '<div class="ody_builder_parameter"><label><?php echo t("Αριθμός"); ?></label>' +
            '<input type="number" class="listbox_small listbox wdg-kfg-count" value="' + $('<div>').text(data.count || '0').html() + '"></div>' +
            '<div class="ody_builder_parameter"><label><?php echo t("Επίθεμα (πχ. +, %, /7)"); ?></label>' +
            '<input type="text" class="listbox_small listbox wdg-kfg-suffix" value="' + $('<div>').text(data.suffix || '').html() + '"></div>' +
            '</div>'
        );

        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Ετικέτα"); ?></label>' +
            '<input type="text" class="listbox wdg-kfg-label" value="' + $('<div>').text(data.label || '').html() + '"></div>'
        );

        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label>' +
            '<input type="text" class="listbox wdg-kfg-desc" value="' + $('<div>').text(data.description || '').html() + '"></div>'
        );

        $item.append($body);
        $('#wdg_kfg_items_list').append($item);

        // ── Real-time label update ────────────────────────────────────────────
        $item.find('.wdg-kfg-label').on('input', function() {
            updateItemDisplay($item);
        });

        // ── Move buttons ──────────────────────────────────────────────────────
        $item.find('.wdg-kfg-move-up').on('click', function(e) {
            e.stopPropagation();
            moveItemUp($item);
        });
        $item.find('.wdg-kfg-move-down').on('click', function(e) {
            e.stopPropagation();
            moveItemDown($item);
        });

        $item.find('.wdg-item-remove').on('click', function() {
            $item.fadeOut(200, function() {
                $item.remove();
                renumberItems();
                saveItems();
            });
        });

        $item.find('input').on('input change', function() { saveItems(); });

        updateItemDisplay($item);
    }

    // Φόρτωση αποθηκευμένων items
    var _saved = pval('items');
    if (_saved) {
        try { JSON.parse(_saved).forEach(function(it) { addItem(it); }); } catch(e) {}
    }

    $('#wdg_kfg_add_btn').on('click', function() { addItem({}); saveItems(); });

    label = 'Widget Key Figures';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Key Figures');

    window.get_block_data = function() {
        saveItems();
        return {
            widget_id: 'key_figures',
            params: {
                eyebrow:         $('#wdg_kfg_eyebrow').val(),
                title:           $('#wdg_kfg_title').val(),
                description:     $('#wdg_kfg_description').val(),
                columns:         $('#wdg_kfg_columns').val(),
                card_layout:     $('#wdg_kfg_card_layout').val(),
                color_scheme:    $('#wdg_kfg_color_scheme').val(),
                container_width: $('#wdg_kfg_container_width').val(),
                items:           $('#wdg_kfg_items').val()
            }
        };
    };
});
</script>
