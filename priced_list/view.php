<?php defined('CMS') or die("This file cannot run this way!"); ?>

<style>
    .ody_builder_parameter { max-width: 500px !important; }
    .wdg-prl-item { border: 1px solid #ccc; border-radius: 4px; margin-bottom: 6px; background: #f0f4f4; transition: box-shadow 0.3s ease; }
    .wdg-prl-item-header { display: flex; align-items: center; gap: 8px; padding: 5px 8px; background: #002e3a; border-radius: 4px 4px 0 0; }
    .wdg-prl-item-header span { color: white; font-size: 11px; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .wdg-prl-item-body { padding: 8px; }
    .wdg-prl-item-body .ody_builder_parameter { max-width: 100% !important; margin-bottom: 5px; }
    .wdg-img-row { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
    .wdg-img-filename { font-size: 12px; color: #999; font-style: italic; word-break: break-all; flex: 1; }
    .wdg-img-preview { max-height: 40px; max-width: 100px; margin-top: 4px; border-radius: 3px; display: none; border: 1px solid #ddd; }
    #wdg_prl_items_container { max-width: 680px !important; }

    /* ── Βελάκια μετακίνησης ── */
    .wdg-prl-move-buttons { display: flex; gap: 4px; margin-right: 4px; }
    .wdg-prl-move-btn { background: transparent; border: none; color: white; cursor: pointer; font-size: 12px; padding: 2px 4px; border-radius: 3px; transition: all 0.2s; }
    .wdg-prl-move-btn:hover { background: rgba(255, 255, 255, 0.2); }
    .wdg-prl-move-btn:active { transform: scale(0.9); }
</style>

<!-- ══ ΓΕΝΙΚΑ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_prl_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_prl_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prl_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_prl_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prl_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_prl_description" class="listbox" value="">
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ═════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_prl_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_prl_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prl_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_prl_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prl_alignment"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_prl_alignment" class="listbox">
        <option value="left"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prl_layout"><?php echo t("Τύπος εμφάνισης"); ?></label>
    <select id="wdg_prl_layout" class="listbox">
        <option value="two-column"><?php echo t("Δύο στήλες"); ?></option>
        <option value="single"><?php echo t("Μία στήλη"); ?></option>
    </select>
</div>

<!-- ══ ITEMS ═════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title">Items</div>
<div id="wdg_prl_items_container" class="ody_builder_parameter" style="max-width:680px !important;">
    <div id="wdg_prl_items_list"></div>
    <button type="button" id="wdg_prl_add_item_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη"); ?> Item
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
    $('#wdg_prl_eyebrow').val(pval('eyebrow'));
    $('#wdg_prl_title').val(pval('title'));
    $('#wdg_prl_description').val(pval('description'));
    $('#wdg_prl_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_prl_container_width').val(pval('container_width', 'xl'));
    $('#wdg_prl_alignment').val(pval('alignment', 'center'));
    $('#wdg_prl_layout').val(pval('layout', 'two-column'));

    // ── odyRecieveMediabank ───────────────────────────────────────────────────
    window.odyRecieveMediabank = function(file, id, ext, image_path, callerEl) {
        var targetId = $(callerEl || window._wdg_mediabank_caller).data('wdg-target');
        if (!targetId) return;
        var mediumPath = '../mediabank/medium/medium_' + id + '.' + ext;
        var fullPath   = image_path + id + '.' + ext;
        $('#' + targetId).val(mediumPath);
        $('#' + targetId + '_full').val(fullPath);
        $('#' + targetId + '_display').text(file);
        $('#' + targetId + '_preview').attr('src', mediumPath).show();
        $('#' + targetId + '_lightbox').attr('href', fullPath);
        $('#' + targetId + '_remove').css('visibility', 'visible');
    };

    // ── Item display ──────────────────────────────────────────────────────────
    function updateItemDisplay($item, nameId) {
        var nameVal = $('#' + nameId).val();
        var itemNumber = $item.index() + 1;
        var displayText = 'Item ' + itemNumber;
        if (nameVal && nameVal.trim() !== '') {
            displayText += ': ' + nameVal;
        }
        $item.find('.wdg-prl-item-header span').text(displayText);
    }

    function renumberItems() {
        $('#wdg_prl_items_list .wdg-prl-item').each(function() {
            var $it = $(this);
            var ii  = $it.data('ii');
            var nameId = 'wdg_prl_name_prl_' + ii;
            updateItemDisplay($it, nameId);
        });
    }

    // ── Move functions ────────────────────────────────────────────────────────
    function moveItemUp($item, nameId) {
        var $prev = $item.prev('.wdg-prl-item');
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

    function moveItemDown($item, nameId) {
        var $next = $item.next('.wdg-prl-item');
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
        var ii      = _item_idx++;
        var uid     = 'prl_' + ii;
        var nameId  = 'wdg_prl_name_'  + uid;
        var descId  = 'wdg_prl_desc_'  + uid;
        var priceId = 'wdg_prl_price_' + uid;
        var imgId   = 'wdg_prl_img_'   + uid;
        var mediaId = 'wdg_prl_media_' + uid;

        var $item = $('<div class="wdg-prl-item" data-ii="' + ii + '">');
        $item.append(
            '<div class="wdg-prl-item-header">' +
            '<div class="wdg-prl-move-buttons">' +
            '<button type="button" class="wdg-prl-move-btn wdg-prl-move-up" title="<?php echo t("Μετακίνηση πάνω"); ?>">▲</button>' +
            '<button type="button" class="wdg-prl-move-btn wdg-prl-move-down" title="<?php echo t("Μετακίνηση κάτω"); ?>">▼</button>' +
            '</div>' +
            '<span>Item ' + ($('#wdg_prl_items_list .wdg-prl-item').length + 1) + '</span>' +
            '<button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );

        var $body = $('<div class="wdg-prl-item-body">');

        // Name
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Όνομα"); ?></label>' +
            '<input type="text" id="' + nameId + '" class="listbox" value="' + $('<div>').text(itemData.name || '').html() + '"></div>'
        );

        // Description
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label>' +
            '<textarea id="' + descId + '" class="listbox" rows="2" style="width:100%; box-sizing:border-box;">' + $('<div>').text(itemData.description || '').html() + '</textarea></div>'
        );

        // Price
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τιμή"); ?></label>' +
            '<input type="text" id="' + priceId + '" class="listbox" value="' + $('<div>').text(itemData.price || '').html() + '"></div>'
        );

        // Image picker
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Εικόνα"); ?></label>' +
            '<div class="wdg-img-row">' +
            '<span id="' + imgId + '_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>' +
            '<a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>" id="' + mediaId + '"' +
            ' class="wdg-prl-select-media ody_builder_content_action btn btn-success" data-vbtype="iframe" data-wdg-target="' + imgId + '"><?php echo t("Επιλογή"); ?></a>' +
            '<a href="javascript:void(0)" id="' + imgId + '_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"><?php echo t("Αφαίρεση"); ?></a>' +
            '</div>' +
            '<input type="hidden" id="' + imgId + '" value="">' +
            '<input type="hidden" id="' + imgId + '_full" value="">' +
            '<a id="' + imgId + '_lightbox" href="#" class="wdg-prl-lightbox" style="display:inline-block;">' +
            '<img id="' + imgId + '_preview" class="wdg-img-preview" src="" alt="">' +
            '</a>' +
            '</div>'
        );

        $item.append($body);
        $('#wdg_prl_items_list').append($item);

        // Shared class VenoBox pattern
        window.venobox = new VenoBox({ selector: '.wdg-prl-select-media', fitView: true, ratio: 'full' });
        $('.wdg-prl-select-media').off('click').on('click', function() { window._wdg_mediabank_caller = this; });

        // Remove button
        $('#' + imgId + '_remove').on('click', function() {
            $('#' + imgId).val('');
            $('#' + imgId + '_full').val('');
            $('#' + imgId + '_display').text('<?php echo t("Επιλέξτε..."); ?>');
            $('#' + imgId + '_preview').hide().attr('src', '');
            $('#' + imgId + '_lightbox').attr('href', '#');
            $(this).css('visibility', 'hidden');
        });

        // Restore saved image
        if (itemData.image) {
            $('#' + imgId).val(itemData.image);
            var _fullImg = itemData.image_full || itemData.image.replace(/medium\/medium_/, '');
            $('#' + imgId + '_full').val(_fullImg);
            $('#' + imgId + '_display').text(itemData.image.split('/').pop());
            $('#' + imgId + '_preview').attr('src', itemData.image).show();
            $('#' + imgId + '_lightbox').attr('href', _fullImg);
            $('#' + imgId + '_remove').css('visibility', 'visible');
        }

        // ── Real-time name update ─────────────────────────────────────────────
        $('#' + nameId).on('input', function() {
            updateItemDisplay($item, nameId);
        });

        // ── Move buttons ──────────────────────────────────────────────────────
        $item.find('.wdg-prl-move-up').on('click', function(e) {
            e.stopPropagation();
            moveItemUp($item, nameId);
        });
        $item.find('.wdg-prl-move-down').on('click', function(e) {
            e.stopPropagation();
            moveItemDown($item, nameId);
        });

        $item.find('.wdg-item-remove').on('click', function() {
            $item.fadeOut(200, function() {
                $item.remove();
                renumberItems();
            });
        });

        updateItemDisplay($item, nameId);
    }

    _items.forEach(function(item) { addItem(item); });
    $('#wdg_prl_add_item_btn').on('click', function() { addItem({}); });

    // ── GLightbox για preview στον editor ─────────────────────────────────────
    if (typeof GLightbox !== 'undefined') {
        GLightbox({ selector: '.wdg-prl-lightbox', touchNavigation: true });
    }

    // ── Label ─────────────────────────────────────────────────────────────────
    label = 'Widget Priced List';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Priced List');

    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function() {
        var items = [];
        $('#wdg_prl_items_list .wdg-prl-item').each(function() {
            var ii  = $(this).data('ii');
            var uid = 'prl_' + ii;
            items.push({
                name:        $('#wdg_prl_name_'  + uid).val(),
                description: $('#wdg_prl_desc_'  + uid).val(),
                price:       $('#wdg_prl_price_' + uid).val(),
                image:       $('#wdg_prl_img_'        + uid).val(),
                image_full:  $('#wdg_prl_img_' + uid + '_full').val()
            });
        });
        return {
            widget_id: 'priced_list',
            params: {
                eyebrow:         $('#wdg_prl_eyebrow').val(),
                title:           $('#wdg_prl_title').val(),
                description:     $('#wdg_prl_description').val(),
                color_scheme:    $('#wdg_prl_color_scheme').val(),
                container_width: $('#wdg_prl_container_width').val(),
                alignment:       $('#wdg_prl_alignment').val(),
                layout:          $('#wdg_prl_layout').val(),
                items:           items
            }
        };
    };
});
</script>
