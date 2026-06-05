<?php defined('CMS') or die("This file cannot run this way!"); ?>

<style>
    .ody_builder_parameter { max-width: 500px !important; }
    .wdg-gl-item { border: 1px solid #ccc; border-radius: 4px; margin-bottom: 6px; background: #f0f4f4; }
    .wdg-gl-item-header { display: flex; align-items: center; gap: 8px; padding: 5px 8px; background: #002e3a; border-radius: 4px 4px 0 0; cursor: move; }
    .wdg-gl-item-header span { color: white; font-size: 11px; flex: 1; }
    .wdg-gl-item-body { padding: 8px; }
    .wdg-gl-item-body .ody_builder_parameter { max-width: 100% !important; margin-bottom: 5px; }
    .wdg-img-row { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
    .wdg-img-filename { font-size: 12px; color: #999; font-style: italic; word-break: break-all; flex: 1; }
    .wdg-img-preview { max-height: 40px; max-width: 100px; margin-top: 4px; border-radius: 3px; display: none; border: 1px solid #ddd; }
</style>

<!-- ══ ΓΕΝΙΚΑ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_gl_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_gl_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_gl_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_gl_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_gl_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_gl_description" class="listbox" value="">
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ═════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_gl_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_gl_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_gl_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_gl_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_gl_layout"><?php echo t("Τύπος Gallery"); ?></label>
    <select id="wdg_gl_layout" class="listbox">
        <option value="grid"><?php echo t("Πλέγμα (Grid)");?></option>
        <option value="carousel"><?php echo t("Οριζόντια κύληση (Carousel)");?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_gl_columns"><?php echo t("Στήλες"); ?></label>
    <select id="wdg_gl_columns" class="listbox">
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_gl_aspect_ratio">Aspect Ratio</label>
    <select id="wdg_gl_aspect_ratio" class="listbox">
        <option value="auto">Auto</option>
        <option value="contain">Contain</option>
        <option value="1 / 1">1:1</option>
        <option value="4 / 3">4:3</option>
        <option value="3 / 2">3:2</option>
        <option value="3 / 4">3:4</option>
        <option value="16 / 9">16:9</option>
    </select>
</div>

<!-- ══ GALLERY ITEMS ════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εικόνες Gallery"); ?></div>
<div id="wdg_gl_items_container" class="ody_builder_parameter">
    <div id="wdg_gl_items_list"></div>
    <button type="button" id="wdg_gl_add_item_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη Εικόνας"); ?>
    </button>
</div>


<script>
jQuery(function ($) {
    var _p = _saved_params || {};
    var _items = _p['items'] || [];
    var _item_idx = 0;

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    $('#wdg_gl_eyebrow').val(pval('eyebrow'));
    $('#wdg_gl_title').val(pval('title'));
    $('#wdg_gl_description').val(pval('description'));
    $('#wdg_gl_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_gl_container_width').val(pval('container_width', 'xl'));
    $('#wdg_gl_layout').val(pval('layout', 'grid'));
    $('#wdg_gl_columns').val(pval('columns', '4'));
    $('#wdg_gl_aspect_ratio').val(pval('aspect_ratio', '4 / 3'));


    // ── VenoBox για mediabank ─────────────────────────────────────────────────
    window.venobox = new VenoBox({ selector: '.wdg-gl-select-media', fitView: true, ratio: 'full' });

    // odyRecieveMediabank — csw pattern
    window.odyRecieveMediabank = function(file, id, ext, image_path, callerEl) {
        var targetId = $(callerEl || window._wdg_mediabank_caller).data('wdg-target');
        if (!targetId) return;
        var fullPath = image_path + id + '.' + ext;
        $('#' + targetId).val(fullPath);
        $('#' + targetId + '_display').text(file);
        $('#' + targetId + '_preview').attr('src', fullPath).show();
        $('#' + targetId + '_remove').css('visibility', 'visible');
    };

    // ── Add Item ──────────────────────────────────────────────────────────────
    function addItem(itemData) {
        itemData = itemData || {};
        var ii      = _item_idx++;
        var uid     = 'gl_' + ii;
        var imgId   = 'wdg_gl_img_' + uid;
        var mediaId = 'wdg_gl_media_' + uid;

        var $item = $('<div class="wdg-gl-item" data-ii="' + ii + '">');
        $item.append('<div class="wdg-gl-item-header"><span><?php echo t("Εικόνα"); ?> ' + (ii + 1) + '</span><button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button></div>');

        var $body = $('<div class="wdg-gl-item-body">');

        // Image picker
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Εικόνα"); ?></label>' +
            '<div class="wdg-img-row">' +
            '<span id="' + imgId + '_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>' +
            '<a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>" id="' + mediaId + '"' +
            ' class="wdg-gl-select-media ody_builder_content_action btn btn-success" data-vbtype="iframe" data-wdg-target="' + imgId + '"><?php echo t("Επιλογή"); ?></a>' +
            '<a href="javascript:void(0)" id="' + imgId + '_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"><?php echo t("Αφαίρεση"); ?></a>' +
            '</div>' +
            '<input type="hidden" id="' + imgId + '" class="wdg-gl-item-image" value="">' +
            '<img id="' + imgId + '_preview" class="wdg-img-preview" src="" alt="">' +
            '</div>'
        );

        // Caption
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Λεζάντα"); ?></label>' +
            '<input type="text" class="listbox wdg-gl-item-caption" value="' + $('<div>').text(itemData.caption || '').html() + '"></div>'
        );

        $item.append($body);
        $('#wdg_gl_items_list').append($item);

        // Per-item VenoBox + caller tracker
        new VenoBox({ selector: '#' + mediaId, fitView: true, ratio: 'full' });
        $('#' + mediaId).on('click', function() { window._wdg_mediabank_caller = this; });

        // Remove button
        $('#' + imgId + '_remove').on('click', function () {
            $('#' + imgId).val('');
            $('#' + imgId + '_display').text('<?php echo t("Επιλέξτε..."); ?>');
            $('#' + imgId + '_preview').hide().attr('src', '');
            $(this).css('visibility', 'hidden');
        });

        // Φόρτωση αποθηκευμένης εικόνας
        if (itemData.image) {
            $('#' + imgId).val(itemData.image);
            $('#' + imgId + '_display').text(itemData.image.split('/').pop());
            $('#' + imgId + '_preview').attr('src', itemData.image).show();
            $('#' + imgId + '_remove').css('visibility', 'visible');
        }

        $item.find('.wdg-item-remove').on('click', function() {
            $item.fadeOut(200, function() { $item.remove(); });
        });

        if ($.fn.sortable) {
            $('#wdg_gl_items_list').sortable({ handle: '.wdg-gl-item-header', placeholder: 'block-placeholder', tolerance: 'pointer' });
        }
    }

    _items.forEach(function(item) { addItem(item); });
    $('#wdg_gl_add_item_btn').on('click', function() { addItem({}); });

    // ── Label ─────────────────────────────────────────────────────────────────
    label = 'Widget Gallery';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Gallery');

    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function() {
        var items = [];
        $('#wdg_gl_items_list .wdg-gl-item').each(function() {
            var $it = $(this);
            var ii  = $it.data('ii');
            var uid = 'gl_' + ii;
            items.push({
                image:   $('#wdg_gl_img_' + uid).val(),
                caption: $it.find('.wdg-gl-item-caption').val()
            });
        });
        return {
            widget_id: 'gallery',
            params: {
                eyebrow:         $('#wdg_gl_eyebrow').val(),
                title:           $('#wdg_gl_title').val(),
                description:     $('#wdg_gl_description').val(),
                color_scheme:    $('#wdg_gl_color_scheme').val(),
                container_width: $('#wdg_gl_container_width').val(),
                layout:          $('#wdg_gl_layout').val(),
                columns:         $('#wdg_gl_columns').val(),
                aspect_ratio:    $('#wdg_gl_aspect_ratio').val(),
                items:           items
            }
        };
    };
});
</script>
