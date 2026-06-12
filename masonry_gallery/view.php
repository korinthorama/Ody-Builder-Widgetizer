<?php defined('CMS') or die("This file cannot run this way!"); ?>

<style>
    .ody_builder_parameter { max-width: 500px !important; }
    .wdg-mgal-item { border: 1px solid #ccc; border-radius: 4px; margin-bottom: 6px; background: #f0f4f4; transition: box-shadow 0.3s ease; }
    .wdg-mgal-item-header { display: flex; align-items: center; gap: 8px; padding: 5px 8px; background: #002e3a; border-radius: 4px 4px 0 0; }
    .wdg-mgal-item-header span { color: white; font-size: 11px; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .wdg-mgal-item-body { padding: 8px; }
    .wdg-mgal-item-body .ody_builder_parameter { max-width: 100% !important; margin-bottom: 5px; }
    .wdg-img-row { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
    .wdg-img-filename { font-size: 12px; color: #999; font-style: italic; word-break: break-all; flex: 1; }
    .wdg-img-preview { max-height: 40px; max-width: 100px; margin-top: 4px; border-radius: 3px; display: none; border: 1px solid #ddd; }

    /* ── Βελάκια μετακίνησης ── */
    .wdg-mgal-move-buttons { display: flex; gap: 4px; margin-right: 4px; }
    .wdg-mgal-move-btn { background: transparent; border: none; color: white; cursor: pointer; font-size: 12px; padding: 2px 4px; border-radius: 3px; transition: all 0.2s; }
    .wdg-mgal-move-btn:hover { background: rgba(255, 255, 255, 0.2); }
    .wdg-mgal-move-btn:active { transform: scale(0.9); }
</style>

<!-- ══ ΓΕΝΙΚΑ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_mgal_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_mgal_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_mgal_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_mgal_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_mgal_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_mgal_description" class="listbox" value="">
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ═════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_mgal_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_mgal_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_mgal_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_mgal_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_mgal_header_alignment"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_mgal_header_alignment" class="listbox">
        <option value="left"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_mgal_columns"><?php echo t("Στήλες"); ?></label>
    <select id="wdg_mgal_columns" class="listbox">
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_mgal_spacing"><?php echo t("Απόσταση"); ?></label>
    <select id="wdg_mgal_spacing" class="listbox">
        <option value="small"><?php echo t("Μικρή"); ?></option>
        <option value="medium"><?php echo t("Μεσαία"); ?></option>
        <option value="large"><?php echo t("Μεγάλη"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_mgal_item_alignment"><?php echo t("Στοίχιση περιεχομένου"); ?></label>
    <select id="wdg_mgal_item_alignment" class="listbox">
        <option value="left"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_mgal_show_border" value="1">
        <p><?php echo t("Εμφάνιση περιγράμματος στα items"); ?></p>
    </div>
</div>

<!-- ══ GALLERY ITEMS ════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εικόνες Gallery"); ?></div>
<div id="wdg_mgal_items_container" class="ody_builder_parameter">
    <div id="wdg_mgal_items_list"></div>
    <button type="button" id="wdg_mgal_add_item_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη Εικόνας"); ?>
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

    // ── Restore scalars ───────────────────────────────────────────────────────
    $('#wdg_mgal_eyebrow').val(pval('eyebrow'));
    $('#wdg_mgal_title').val(pval('title'));
    $('#wdg_mgal_description').val(pval('description'));
    $('#wdg_mgal_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_mgal_container_width').val(pval('container_width', 'xl'));
    $('#wdg_mgal_header_alignment').val(pval('header_alignment', 'center'));
    $('#wdg_mgal_columns').val(pval('columns', '4'));
    $('#wdg_mgal_spacing').val(pval('spacing', 'small'));
    $('#wdg_mgal_item_alignment').val(pval('item_alignment', 'center'));
    if (pval('show_border', '0') === '1') $('#wdg_mgal_show_border').prop('checked', true);

    // ── VenoBox shared class ──────────────────────────────────────────────────
    window.venobox = new VenoBox({ selector: '.wdg-mgal-select-media', fitView: true, ratio: 'full' });

    // ── odyRecieveMediabank ───────────────────────────────────────────────────
    window.odyRecieveMediabank = function(file, id, ext, image_path, callerEl) {
        var targetId = $(callerEl || window._wdg_mediabank_caller).data('wdg-target');
        if (!targetId) return;
        var fullPath = image_path + id + '.' + ext;
        $('#' + targetId).val(fullPath);
        $('#' + targetId + '_display').text(file);
        $('#' + targetId + '_preview').attr('src', fullPath).show();
        $('#' + targetId + '_remove').css('visibility', 'visible');
    };

    // ── Item display ──────────────────────────────────────────────────────────
    function updateItemDisplay($item, headingId) {
        var headingVal = $('#' + headingId).val();
        var itemNumber = $item.index() + 1;
        var displayText = '<?php echo t("Εικόνα"); ?> ' + itemNumber;
        if (headingVal && headingVal.trim() !== '') {
            displayText += ': ' + headingVal;
        }
        $item.find('.wdg-mgal-item-header span').text(displayText);
    }

    function renumberItems() {
        $('#wdg_mgal_items_list .wdg-mgal-item').each(function() {
            var $it = $(this);
            var ii  = $it.data('ii');
            var headingId = 'wdg_mgal_heading_mgal_' + ii;
            updateItemDisplay($it, headingId);
        });
    }

    // ── Move functions ────────────────────────────────────────────────────────
    function moveItemUp($item, headingId) {
        var $prev = $item.prev('.wdg-mgal-item');
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

    function moveItemDown($item, headingId) {
        var $next = $item.next('.wdg-mgal-item');
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

    // ── Add Item ──────────────────────────────────────────────────────────────
    function addItem(itemData) {
        itemData = itemData || {};
        var ii        = _item_idx++;
        var uid       = 'mgal_' + ii;
        var imgId     = 'wdg_mgal_img_'      + uid;
        var mediaId   = 'wdg_mgal_media_'    + uid;
        var headingId = 'wdg_mgal_heading_'  + uid;
        var categoryId= 'wdg_mgal_category_' + uid;

        var $item = $('<div class="wdg-mgal-item" data-ii="' + ii + '">');
        $item.append(
            '<div class="wdg-mgal-item-header">' +
            '<div class="wdg-mgal-move-buttons">' +
            '<button type="button" class="wdg-mgal-move-btn wdg-mgal-move-up" title="<?php echo t("Μετακίνηση πάνω"); ?>">▲</button>' +
            '<button type="button" class="wdg-mgal-move-btn wdg-mgal-move-down" title="<?php echo t("Μετακίνηση κάτω"); ?>">▼</button>' +
            '</div>' +
            '<span><?php echo t("Εικόνα"); ?> ' + ($('#wdg_mgal_items_list .wdg-mgal-item').length + 1) + '</span>' +
            '<button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );

        var $body = $('<div class="wdg-mgal-item-body">');

        // Image picker
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Εικόνα"); ?></label>' +
            '<div class="wdg-img-row">' +
            '<span id="' + imgId + '_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>' +
            '<a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>" id="' + mediaId + '"' +
            ' class="wdg-mgal-select-media ody_builder_content_action btn btn-success" data-vbtype="iframe" data-wdg-target="' + imgId + '"><?php echo t("Επιλογή"); ?></a>' +
            '<a href="javascript:void(0)" id="' + imgId + '_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"><?php echo t("Αφαίρεση"); ?></a>' +
            '</div>' +
            '<input type="hidden" id="' + imgId + '" value="">' +
            '<img id="' + imgId + '_preview" class="wdg-img-preview" src="" alt="">' +
            '</div>'
        );

        // Heading
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Επικεφαλίδα"); ?></label>' +
            '<input type="text" id="' + headingId + '" class="listbox" value="' + $('<div>').text(itemData.heading || '').html() + '"></div>'
        );

        // Category
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Κατηγορία"); ?></label>' +
            '<input type="text" id="' + categoryId + '" class="listbox" value="' + $('<div>').text(itemData.category || '').html() + '"></div>'
        );

        $item.append($body);
        $('#wdg_mgal_items_list').append($item);

        // Per-item VenoBox + caller tracker
        new VenoBox({ selector: '#' + mediaId, fitView: true, ratio: 'full' });
        $('#' + mediaId).on('click', function() { window._wdg_mediabank_caller = this; });

        // Remove button
        $('#' + imgId + '_remove').on('click', function() {
            $('#' + imgId).val('');
            $('#' + imgId + '_display').text('<?php echo t("Επιλέξτε..."); ?>');
            $('#' + imgId + '_preview').hide().attr('src', '');
            $(this).css('visibility', 'hidden');
        });

        // Restore saved image
        if (itemData.image) {
            $('#' + imgId).val(itemData.image);
            $('#' + imgId + '_display').text(itemData.image.split('/').pop());
            $('#' + imgId + '_preview').attr('src', itemData.image).show();
            $('#' + imgId + '_remove').css('visibility', 'visible');
        }

        // ── Real-time heading update ──────────────────────────────────────────
        $('#' + headingId).on('input', function() {
            updateItemDisplay($item, headingId);
        });

        // ── Move buttons ──────────────────────────────────────────────────────
        $item.find('.wdg-mgal-move-up').on('click', function(e) {
            e.stopPropagation();
            moveItemUp($item, headingId);
        });
        $item.find('.wdg-mgal-move-down').on('click', function(e) {
            e.stopPropagation();
            moveItemDown($item, headingId);
        });

        $item.find('.wdg-item-remove').on('click', function() {
            $item.fadeOut(200, function() {
                $item.remove();
                renumberItems();
            });
        });

        updateItemDisplay($item, headingId);
    }

    _items.forEach(function(item) { addItem(item); });
    $('#wdg_mgal_add_item_btn').on('click', function() { addItem({}); });

    // ── Label ─────────────────────────────────────────────────────────────────
    label = 'Widget Masonry Gallery';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Masonry Gallery');

    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function() {
        var items = [];
        $('#wdg_mgal_items_list .wdg-mgal-item').each(function() {
            var ii  = $(this).data('ii');
            var uid = 'mgal_' + ii;
            items.push({
                image:    $('#wdg_mgal_img_'      + uid).val(),
                heading:  $('#wdg_mgal_heading_'  + uid).val(),
                category: $('#wdg_mgal_category_' + uid).val()
            });
        });
        return {
            widget_id: 'masonry_gallery',
            params: {
                eyebrow:          $('#wdg_mgal_eyebrow').val(),
                title:            $('#wdg_mgal_title').val(),
                description:      $('#wdg_mgal_description').val(),
                color_scheme:     $('#wdg_mgal_color_scheme').val(),
                container_width:  $('#wdg_mgal_container_width').val(),
                header_alignment: $('#wdg_mgal_header_alignment').val(),
                columns:          $('#wdg_mgal_columns').val(),
                spacing:          $('#wdg_mgal_spacing').val(),
                item_alignment:   $('#wdg_mgal_item_alignment').val(),
                show_border:      $('#wdg_mgal_show_border').is(':checked') ? '1' : '0',
                items:            items
            }
        };
    };
});
</script>
