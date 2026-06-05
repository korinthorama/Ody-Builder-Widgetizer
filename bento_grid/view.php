<?php
/*
 * Widgetizer — Bento Grid Widget — view.php (custom admin UI)
 *
 * Έχει πρόσβαση σε: $db, $langID, t(), _saved_params (JS)
 * Πρέπει να ορίσει: window.get_block_data(), label
 */
?>
<style>
    .ody_builder_parameter {
        max-width: 500px !important;
    }
    /* ── Repeater ── */
    #wdg_bento_items {
        width: 100%;
        max-width: 100%;
        margin-bottom: 8px;
    }
    .wdg-bento-item {
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 8px;
        background: #f9f9f9;
    }
    .wdg-bento-item-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
        cursor: move;
    }
    .wdg-bento-item-header span {
        color: white;
        font-size: 12px;
        flex: 1;
    }
    .wdg-bento-item-body {
        padding: 8px;
    }
    .wdg-bento-item-body .ody_builder_parameter {
        max-width: 100% !important;
        margin-bottom: 6px;
    }
    #wdg_bento_add_btn {
        display: inline-block;
        padding: 6px 16px;
        background: #002e3a;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        margin-top: 4px;
    }
    #wdg_bento_add_btn:hover { background: #004a5c; }
    .wdg-img-row {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }
    .wdg-img-filename {
        font-size: 12px;
        color: #999;
        font-style: italic;
        word-break: break-all;
        flex: 1;
    }
    .wdg-img-preview {
        max-height: 50px;
        max-width: 120px;
        margin-top: 4px;
        border-radius: 4px;
        display: none;
        border: 1px solid #ddd;
    }
</style>

<!-- ══ ΓΕΝΙΚΑ ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_bg_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_bg_eyebrow" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_bg_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_bg_title" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_bg_description"><?php echo t("Περιγραφή"); ?></label>
    <textarea id="wdg_bg_description" class="listbox" rows="3" style="resize:vertical;"></textarea>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_bg_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_bg_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_bg_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_bg_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>

<!-- ══ ITEMS ═════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title">Bento Items</div>

<div id="wdg_bento_items" style="max-width:100%;"></div>
<button id="wdg_bento_add_btn" type="button">+ <?php echo t("Προσθήκη"); ?> Item</button>


<script>
jQuery(function ($) {
    var _p = _saved_params || {};
    var _items = _p['items'] || [];

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    // ── Φόρτωση γενικών τιμών ────────────────────────────────────────────────
    $('#wdg_bg_eyebrow').val(pval('eyebrow'));
    $('#wdg_bg_title').val(pval('title'));
    $('#wdg_bg_description').val(pval('description'));
    $('#wdg_bg_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_bg_container_width').val(pval('container_width', 'full'));

    // ── Default HTML Markup ───────────────────────────────────────────────────

    // ── Spectrum palette ──────────────────────────────────────────────────────
    var _palette = [
        ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
        ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
        ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
        ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
        ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
        ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
    ];

    // ── VenoBox για mediabank ─────────────────────────────────────────────────
    window.venobox = new VenoBox({selector: '.wdg-bento-select-media', fitView: true, ratio: 'full'});
    $('.wdg-bento-select-media').on('click', function () {
        window._wdg_mediabank_caller = this;
    });

    window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
        var targetId = $(callerEl).data('wdg-target');
        if (!targetId) return;
        var fullPath = image_path + id + '.' + ext;
        $('#' + targetId).val(fullPath);
        $('#' + targetId + '_display').text(file);
        $('#' + targetId + '_preview').attr('src', fullPath).show();
        $('#' + targetId + '_remove').css('visibility', 'visible');
    };

    // ── Repeater ──────────────────────────────────────────────────────────────
    var _item_idx = 0;

    function addItem(data) {
        var idx = _item_idx++;
        var imgId = 'wdg_bento_img_' + idx;
        var overlayId = 'wdg_bento_overlay_' + idx;
        var opacityId = 'wdg_bento_opacity_' + idx;
        var mediaId = 'wdg_bento_media_btn_' + idx;

        var $item = $('<div class="wdg-bento-item" data-idx="' + idx + '">');

        // Header
        $item.append(
            '<div class="wdg-bento-item-header">' +
            '<span><?php echo t("Item"); ?> ' + ($('#wdg_bento_items .wdg-bento-item').length + 1) + '</span>' +
            '<button class="wdg-item-remove" type="button" title="<?php echo t("Αφαίρεση"); ?>">✕</button>' +
            '</div>'
        );

        var $body = $('<div class="wdg-bento-item-body">');

        // Title
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<label><?php echo t("Τίτλος"); ?></label>' +
            '<input type="text" class="listbox wdg-bento-title" value="' + $('<div>').text(data.title || '').html() + '">' +
            '</div>'
        );

        // Text
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<label><?php echo t("Περιγραφή"); ?></label>' +
            '<textarea class="listbox wdg-bento-text">' + $('<div>').text(data.text || '').html() + '</textarea>' +
            '</div>'
        );

        // BG Image
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<label><?php echo t("Εικόνα Φόντου"); ?></label>' +
            '<div class="wdg-img-row">' +
            '<span id="' + imgId + '_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>' +
            '<a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"' +
            ' id="' + mediaId + '"' +
            ' class="wdg-bento-select-media ody_builder_content_action btn btn-success"' +
            ' data-vbtype="iframe" data-wdg-target="' + imgId + '"><?php echo t("Επιλογή"); ?></a>' +
            '<a href="javascript:void(0)" id="' + imgId + '_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"' +
            ' onclick="$(\'#' + imgId + '\').val(\'\'); $(\'#' + imgId + '_display\').text(\'<?php echo t("Επιλέξτε..."); ?>\'); $(\'#' + imgId + '_preview\').hide().attr(\'src\',\'\'); $(\'#' + imgId + '_remove\').css(\'visibility\',\'hidden\');"><?php echo t("Αφαίρεση"); ?></a>' +
            '</div>' +
            '<input type="hidden" id="' + imgId + '" class="wdg-bento-bg-image" value="">' +
            '<img id="' + imgId + '_preview" class="wdg-img-preview" src="" alt="">' +
            '</div>'
        );

        // Overlay color
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<label><?php echo t("Χρώμα μάσκας"); ?></label>' +
            '<input type="text" id="' + overlayId + '" class="wdg-bento-overlay-color" data-preferred-format="hex" value="#000000">' +
            '</div>'
        );

        // Overlay opacity
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<label><?php echo t("Διαφάνεια μάσκας"); ?> <small style="color:#999;font-weight:normal;">(0–1)</small></label>' +
            '<input type="number" id="' + opacityId + '" class="listbox wdg-bento-overlay-opacity" value="0.4" min="0" max="1" step="0.1" style="max-width:100px;">' +
            '</div>'
        );

        // Grid spans + align + color_scheme — κατακόρυφα
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<label>Col Span (1-4)</label>' +
            '<input type="number" class="listbox wdg-bento-col-span" value="1" min="1" max="4" style="max-width:80px;">' +
            '</div>'
        );
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<label>Row Span (1-3)</label>' +
            '<input type="number" class="listbox wdg-bento-row-span" value="1" min="1" max="3" style="max-width:80px;">' +
            '</div>'
        );
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<label><?php echo t("Στοίχιση"); ?></label>' +
            '<select class="listbox wdg-bento-align">' +
            '<option value="align-start"><?php echo t("Αριστερά"); ?></option>' +
            '<option value="align-center"><?php echo t("Κέντρο"); ?></option>' +
            '</select>' +
            '</div>'
        );
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<label><?php echo t("Κύρια χρωματική παλέτα"); ?></label>' +
            '<select class="listbox wdg-bento-color-scheme">' +
            '<option value="color-scheme-standard-primary">Standard Primary</option>' +
            '<option value="color-scheme-standard-secondary">Standard Secondary</option>' +
            '<option value="color-scheme-highlight-primary">Highlight Primary</option>' +
            '<option value="color-scheme-highlight-secondary">Highlight Secondary</option>' +
            '</select>' +
            '</div>'
        );

        $item.append($body);
        $('#wdg_bento_items').append($item);

        // Φόρτωση τιμών
        if (data.bg_image) {
            $('#' + imgId).val(data.bg_image);
            $('#' + imgId + '_display').text(data.bg_image.split('/').pop());
            $('#' + imgId + '_preview').attr('src', data.bg_image).show();
            $('#' + imgId + '_remove').css('visibility', 'visible');
        }

        var overlayVal = (data.overlay_color || '[id]000000').replace('[id]', '#');
        var opacityVal = data.overlay_opacity !== undefined ? data.overlay_opacity : '0.4';
        $item.find('.wdg-bento-col-span').val(data.col_span || 1);
        $item.find('.wdg-bento-row-span').val(data.row_span || 1);
        $item.find('.wdg-bento-align').val(data.align || 'align-start');
        $item.find('.wdg-bento-color-scheme').val(data.color_scheme || 'color-scheme-standard-primary');
        $('#' + opacityId).val(opacityVal);

        // Spectrum για overlay
        $('#' + overlayId).val(overlayVal).spectrum({
            showInput:       true,
            showPalette:     true,
            showAlpha:       false,
            palette:         _palette,
            preferredFormat: 'hex'
        });

        // Remove button
        $item.find('.wdg-item-remove').on('click', function () {
            $item.fadeOut(200, function () { $item.remove(); renumberItems(); });
        });

        // Re-init VenoBox για το νέο media button
        new VenoBox({selector: '#' + mediaId, fitView: true, ratio: 'full'});
        $('#' + mediaId).on('click', function () {
            window._wdg_mediabank_caller = this;
        });
    }

    function renumberItems() {
        $('#wdg_bento_items .wdg-bento-item').each(function (idx) {
            $(this).find('.wdg-bento-item-header span').text('<?php echo t("Item"); ?> ' + (idx + 1));
        });
    }

    // Φόρτωση αποθηκευμένων items
    $.each(_items, function (i, item) {
        addItem(item);
    });

    // Προσθήκη νέου item
    $('#wdg_bento_add_btn').on('click', function () {
        addItem({});
    });

    // Sortable
    if ($.fn.sortable) {
        $('#wdg_bento_items').sortable({
            handle: '.wdg-bento-item-header',
            placeholder: 'block-placeholder',
            tolerance: 'pointer',
            stop: function () { renumberItems(); }
        });
    }

    // ── Label ─────────────────────────────────────────────────────────────────
    label = 'Widget Bento Grid';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Bento Grid');

    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function () {
        var items = [];
        $('#wdg_bento_items .wdg-bento-item').each(function () {
            var $it = $(this);
            var overlayRaw = $it.find('.wdg-bento-overlay-color').val() || '#000000';
            items.push({
                title:        $it.find('.wdg-bento-title').val(),
                text:         $it.find('.wdg-bento-text').val(),
                bg_image:     $it.find('.wdg-bento-bg-image').val(),
                overlay_color:   overlayRaw.replace('#', '[id]'),
                overlay_opacity: $it.find('.wdg-bento-overlay-opacity').val(),
                col_span:     $it.find('.wdg-bento-col-span').val(),
                row_span:     $it.find('.wdg-bento-row-span').val(),
                align:        $it.find('.wdg-bento-align').val(),
                color_scheme: $it.find('.wdg-bento-color-scheme').val()
            });
        });
        return {
            widget_id: 'bento_grid',
            params: {
                eyebrow:      $('#wdg_bg_eyebrow').val(),
                title:        $('#wdg_bg_title').val(),
                description:  $('#wdg_bg_description').val(),
                color_scheme:    $('#wdg_bg_color_scheme').val(),
                container_width: $('#wdg_bg_container_width').val(),
                items:        items
            }
        };
    };
});
</script>
