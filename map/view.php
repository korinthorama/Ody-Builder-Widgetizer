<?php defined('CMS') or die("This file cannot run this way!"); ?>

<style>
    .ody_builder_parameter { max-width: 500px !important; }
    .wdg-map-item { border: 1px solid #ccc; border-radius: 4px; margin-bottom: 6px; background: #f0f4f4; }
    .wdg-map-item-header { display: flex; align-items: center; gap: 8px; padding: 5px 8px; background: #002e3a; border-radius: 4px 4px 0 0; cursor: move; }
    .wdg-map-item-header span { color: white; font-size: 11px; flex: 1; }
    .wdg-map-item-body { padding: 8px; }
    .wdg-map-item-body .ody_builder_parameter { max-width: 100% !important; margin-bottom: 5px; }
</style>

<!-- ══ ΓΕΝΙΚΑ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_map_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_map_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_map_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_map_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_map_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_map_description" class="listbox" value="">
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ═════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_map_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_map_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_map_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_map_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_map_alignment"><?php echo t("Στοίχιση κειμένου"); ?></label>
    <select id="wdg_map_alignment" class="listbox">
        <option value="left"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_map_position"><?php echo t("Θέση χάρτη"); ?></label>
    <select id="wdg_map_position" class="listbox">
        <option value="right"><?php echo t("Δεξιά (sidebar αριστερά)"); ?></option>
        <option value="left"><?php echo t("Αριστερά (sidebar δεξιά)"); ?></option>
        <option value="fullwidth"><?php echo t("Full Width (χωρίς sidebar)"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_map_height"><?php echo t("Ύψος χάρτη"); ?></label>
    <select id="wdg_map_height" class="listbox">
        <option value="small"><?php echo t("μικρό");?> (300px)</option>
        <option value="medium"><?php echo t("μέτριο");?> (450px)</option>
        <option value="large"><?php echo t("μεγάλο");?> (600px)</option>
    </select>
</div>

<!-- ══ ΧΑΡΤΗΣ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Χάρτης"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_map_embed_url">Embed URL of the map</label>
    <textarea id="wdg_map_embed_url" class="listbox" rows="3" style="width:100%; box-sizing:border-box;" placeholder="https://www.google.com/maps/embed?pb=..."></textarea>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_map_address"><?php echo t("Διεύθυνση"); ?></label>
    <input type="text" id="wdg_map_address" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_map_directions_url"><?php echo t("Link Οδηγιών (Get Directions)"); ?></label>
    <input type="text" id="wdg_map_directions_url" class="listbox" value="" placeholder="https://maps.google.com/?q=...">
</div>

<!-- ══ SIDEBAR BLOCKS ════════════════════════════════════════════════════════ -->
<div class="wdg-section-title">Sidebar Blocks</div>
<div id="wdg_map_items_container" class="ody_builder_parameter">
    <div id="wdg_map_items_list"></div>
    <button type="button" id="wdg_map_add_item_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη"); ?> Block
    </button>
</div>

<script>
jQuery(function ($) {
    var _p        = _saved_params || {};
    var _items    = _p['sidebar_items'] || [];
    var _item_idx = 0;

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    // ── Restore scalars ────────────────────────────────────────────────────────
    $('#wdg_map_eyebrow').val(pval('eyebrow'));
    $('#wdg_map_title').val(pval('title'));
    $('#wdg_map_description').val(pval('description'));
    $('#wdg_map_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_map_container_width').val(pval('container_width', 'xl'));
    $('#wdg_map_alignment').val(pval('alignment', 'center'));
    $('#wdg_map_position').val(pval('map_position', 'right'));
    $('#wdg_map_height').val(pval('map_height', 'medium'));
    $('#wdg_map_embed_url').val(pval('embed_url'));
    $('#wdg_map_address').val(pval('address'));
    $('#wdg_map_directions_url').val(pval('directions_url'));

    // ── Add Item ──────────────────────────────────────────────────────────────
    function addItem(itemData) {
        itemData = itemData || {};
        var ii  = _item_idx++;
        var uid = 'map_' + ii;

        var $item = $('<div class="wdg-map-item" data-ii="' + ii + '">');
        $item.append(
            '<div class="wdg-map-item-header">' +
                '<span>Block ' + ($('#wdg_map_items_list .wdg-map-item').length + 1) + '</span>' +
                '<button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );

        var $body = $('<div class="wdg-map-item-body">');

        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?></label>' +
            '<input type="text" id="wdg_map_block_title_' + uid + '" class="listbox" value="' + $('<div>').text(itemData.title || '').html() + '"></div>'
        );

        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Κείμενο κουμπιού"); ?></label>' +
            '<textarea id="wdg_map_block_text_' + uid + '" class="listbox" rows="4" style="width:100%; box-sizing:border-box;">' + $('<div>').text(itemData.text || '').html() + '</textarea></div>'
        );

        $item.append($body);
        $('#wdg_map_items_list').append($item);

        $item.find('.wdg-item-remove').on('click', function () {
            $item.fadeOut(200, function () { $item.remove(); renumberItems(); });
        });

        if ($.fn.sortable) {
            $('#wdg_map_items_list').sortable({ handle: '.wdg-map-item-header', placeholder: 'block-placeholder', tolerance: 'pointer', stop: function() { renumberItems(); } });
        }
    }

    function renumberItems() {
        $('#wdg_map_items_list .wdg-map-item').each(function(idx) {
            $(this).find('.wdg-map-item-header span').text('Block ' + (idx + 1));
        });
    }

    // ── Restore items ─────────────────────────────────────────────────────────
    if (_items.length > 0) {
        _items.forEach(function (item) { addItem(item); });
    } else {
        addItem({});
    }

    $('#wdg_map_add_item_btn').on('click', function () { addItem({}); });

    // ── Label ─────────────────────────────────────────────────────────────────
    label = 'Widget Map';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Map');

    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function () {
        var sidebar_items = [];
        $('#wdg_map_items_list .wdg-map-item').each(function () {
            var ii  = $(this).data('ii');
            var uid = 'map_' + ii;
            sidebar_items.push({
                title: $('#wdg_map_block_title_' + uid).val(),
                text:  $('#wdg_map_block_text_'  + uid).val()
            });
        });
        return {
            widget_id: 'map',
            params: {
                eyebrow:         $('#wdg_map_eyebrow').val(),
                title:           $('#wdg_map_title').val(),
                description:     $('#wdg_map_description').val(),
                color_scheme:    $('#wdg_map_color_scheme').val(),
                container_width: $('#wdg_map_container_width').val(),
                alignment:       $('#wdg_map_alignment').val(),
                map_position:    $('#wdg_map_position').val(),
                map_height:      $('#wdg_map_height').val(),
                embed_url:       $('#wdg_map_embed_url').val(),
                address:         $('#wdg_map_address').val(),
                directions_url:  $('#wdg_map_directions_url').val(),
                sidebar_items:   sidebar_items
            }
        };
    };
});
</script>
