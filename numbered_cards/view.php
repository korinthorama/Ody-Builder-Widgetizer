<?php defined('CMS') or die("This file cannot run this way!"); ?>

<style>
    .ody_builder_parameter { max-width: 500px !important; }
    .wdg-numc-item { border: 1px solid #ccc; border-radius: 4px; margin-bottom: 6px; background: #f0f4f4; }
    .wdg-numc-item-header { display: flex; align-items: center; gap: 8px; padding: 5px 8px; background: #002e3a; border-radius: 4px 4px 0 0; cursor: move; }
    .wdg-numc-item-header span { color: white; font-size: 11px; flex: 1; }
    .wdg-numc-item-body { padding: 8px; }
    .wdg-numc-item-body .ody_builder_parameter { max-width: 100% !important; margin-bottom: 5px; }
</style>

<!-- ══ ΓΕΝΙΚΑ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_numc_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_numc_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_numc_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_numc_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_numc_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_numc_description" class="listbox" value="">
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ═════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_numc_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_numc_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_numc_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_numc_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_numc_header_alignment"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_numc_header_alignment" class="listbox">
        <option value="left"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_numc_card_layout"><?php echo t("Εμφάνιση κάρτας"); ?></label>
    <select id="wdg_numc_card_layout" class="listbox">
        <option value="box"><?php echo t("Με περίγραμμα"); ?></option>
        <option value="flat"><?php echo t("Χωρίς περίγραμμα"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_numc_layout"><?php echo t("Τύπος εμφάνισης"); ?></label>
    <select id="wdg_numc_layout" class="listbox">
        <option value="grid"><?php echo t("Πλέγμα (Grid)");?></option>
        <option value="carousel"><?php echo t("Οριζόντια κύληση (Carousel)");?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_numc_carousel_cols"><?php echo t("Στήλες (desktop)"); ?></label>
    <select id="wdg_numc_carousel_cols" class="listbox">
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_numc_item_alignment"><?php echo t("Στοίχιση περιεχομένου"); ?></label>
    <select id="wdg_numc_item_alignment" class="listbox">
        <option value="left"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>

<!-- ══ CARDS ═════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Κάρτες"); ?></div>
<div id="wdg_numc_items_container" class="ody_builder_parameter">
    <div id="wdg_numc_items_list"></div>
    <button type="button" id="wdg_numc_add_item_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη κάρτας"); ?>
    </button>
</div>

<script>
jQuery(function ($) {
    var _p        = _saved_params || {};
    var _items    = _p['items']   || [];
    var _item_idx = 0;

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    // ── Restore scalars ────────────────────────────────────────────────────────
    $('#wdg_numc_eyebrow').val(pval('eyebrow'));
    $('#wdg_numc_title').val(pval('title'));
    $('#wdg_numc_description').val(pval('description'));
    $('#wdg_numc_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_numc_container_width').val(pval('container_width', 'xl'));
    $('#wdg_numc_header_alignment').val(pval('header_alignment', 'center'));
    $('#wdg_numc_layout').val(pval('layout', 'grid'));
    $('#wdg_numc_card_layout').val(pval('card_layout', 'box'));
    $('#wdg_numc_carousel_cols').val(pval('carousel_cols', '4'));
    $('#wdg_numc_item_alignment').val(pval('item_alignment', 'center'));

    // ── Add Item ──────────────────────────────────────────────────────────────
    function addItem(itemData) {
        itemData = itemData || {};
        var ii  = _item_idx++;
        var uid = 'numc_' + ii;

        var $item = $('<div class="wdg-numc-item" data-ii="' + ii + '">');
        $item.append(
            '<div class="wdg-numc-item-header">' +
                '<span><?php echo t("Κάρτα"); ?> ' + ($('#wdg_numc_items_list .wdg-numc-item').length + 1) + '</span>' +
                '<button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );

        var $body = $('<div class="wdg-numc-item-body">');

        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?></label>' +
            '<input type="text" id="wdg_numc_item_title_' + uid + '" class="listbox" value="' + $('<div>').text(itemData.title || '').html() + '"></div>'
        );

        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label>' +
            '<textarea id="wdg_numc_item_desc_' + uid + '" class="listbox" rows="3" style="width:100%; box-sizing:border-box;">' + $('<div>').text(itemData.description || '').html() + '</textarea></div>'
        );

        $item.append($body);
        $('#wdg_numc_items_list').append($item);

        $item.find('.wdg-item-remove').on('click', function () {
            $item.fadeOut(200, function () { $item.remove(); renumberItems(); });
        });

        if ($.fn.sortable) {
            $('#wdg_numc_items_list').sortable({
                handle: '.wdg-numc-item-header',
                placeholder: 'block-placeholder',
                tolerance: 'pointer',
                stop: function () { renumberItems(); }
            });
        }
    }

    function renumberItems() {
        $('#wdg_numc_items_list .wdg-numc-item').each(function (idx) {
            $(this).find('.wdg-numc-item-header span').text('<?php echo t("Κάρτα"); ?> ' + (idx + 1));
        });
    }

    _items.forEach(function (item) { addItem(item); });
    $('#wdg_numc_add_item_btn').on('click', function () { addItem({}); });

    // ── Label ─────────────────────────────────────────────────────────────────
    label = 'Widget Numbered Cards';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Numbered Cards');

    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function () {
        var items = [];
        $('#wdg_numc_items_list .wdg-numc-item').each(function () {
            var ii  = $(this).data('ii');
            var uid = 'numc_' + ii;
            items.push({
                title:       $('#wdg_numc_item_title_' + uid).val(),
                description: $('#wdg_numc_item_desc_'  + uid).val()
            });
        });
        return {
            widget_id: 'numbered_cards',
            params: {
                eyebrow:          $('#wdg_numc_eyebrow').val(),
                title:            $('#wdg_numc_title').val(),
                description:      $('#wdg_numc_description').val(),
                color_scheme:     $('#wdg_numc_color_scheme').val(),
                container_width:  $('#wdg_numc_container_width').val(),
                header_alignment: $('#wdg_numc_header_alignment').val(),
                layout:           $('#wdg_numc_layout').val(),
                card_layout:      $('#wdg_numc_card_layout').val(),
                carousel_cols:    $('#wdg_numc_carousel_cols').val(),
                item_alignment:   $('#wdg_numc_item_alignment').val(),
                items:            items
            }
        };
    };
});
</script>
