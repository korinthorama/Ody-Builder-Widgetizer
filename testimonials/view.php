<?php defined('CMS') or die("This file cannot run this way!"); ?>
<style>
    .ody_builder_parameter {
        max-width: 500px !important;
    }

    .wdg-tmls-item {
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 6px;
        background: #f0f4f4;
        transition: box-shadow 0.3s ease;
    }

    .wdg-tmls-item-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
    }

    .wdg-tmls-item-header span {
        color: white;
        font-size: 11px;
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .wdg-tmls-move-buttons {
        display: flex;
        gap: 4px;
        margin-right: 4px;
    }

    .wdg-tmls-move-btn {
        background: transparent;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 11px;
        padding: 0 2px;
        line-height: 1;
    }

    .wdg-tmls-move-btn:hover {
        color: #fbbf24;
    }

    .wdg-tmls-move-btn:active {
        color: #f59e0b;
    }

    .wdg-tmls-item-body {
        padding: 8px;
    }

    .wdg-tmls-item-body .ody_builder_parameter {
        max-width: 100% !important;
        margin-bottom: 5px;
    }

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
        width: 40px;
        height: 40px;
        max-height: 40px;
        max-width: 40px;
        margin-top: 4px;
        border-radius: 50%;
        display: none;
        border: 1px solid #ddd;
        object-fit: cover;
        flex-shrink: 0;
    }
</style>

<!-- ══ ΕΠΙΚΕΦΑΛΙΔΑ ════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Επικεφαλίδα"); ?></div>

<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" style="margin: 10px 0 10px;">
        <input type="checkbox" id="wdg_tmls_show_header" value="1">
        <p><?php echo t("Εμφάνιση Επικεφαλίδας"); ?></p>
    </div>
</div>

<div id="wdg_tmls_header_fields" style="display:none;">
    <div class="ody_builder_parameter">
        <label for="wdg_tmls_eyebrow">Eyebrow</label>
        <input type="text" id="wdg_tmls_eyebrow" class="listbox" value="">
    </div>
    <div class="ody_builder_parameter">
        <label for="wdg_tmls_title"><?php echo t("Τίτλος"); ?></label>
        <input type="text" id="wdg_tmls_title" class="listbox" value="">
    </div>
    <div class="ody_builder_parameter">
        <label for="wdg_tmls_title_size"><?php echo t("Μέγεθος τίτλου"); ?></label>
        <select id="wdg_tmls_title_size" class="listbox">
            <option value="t-lg"><?php echo t("Μεγάλο"); ?></option>
            <option value="t-xl">XL</option>
            <option value="t-2xl" selected>2XL</option>
            <option value="t-3xl">3XL</option>
            <option value="t-4xl">4XL</option>
            <option value="t-5xl">5XL</option>
        </select>
    </div>
    <div class="ody_builder_parameter">
        <label for="wdg_tmls_description"><?php echo t("Περιγραφή"); ?></label>
        <input type="text" id="wdg_tmls_description" class="listbox" value="">
    </div>
    <div class="ody_builder_parameter">
        <label for="wdg_tmls_header_alignment"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
        <select id="wdg_tmls_header_alignment" class="listbox">
            <option value="left"><?php echo t("Αριστερά"); ?></option>
            <option value="center"><?php echo t("Κέντρο"); ?></option>
        </select>
    </div>
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_tmls_layout"><?php echo t("Τύπος εμφάνισης"); ?></label>
    <select id="wdg_tmls_layout" class="listbox">
        <option value="grid"><?php echo t("Πλέγμα (Grid)");?></option>
        <option value="carousel"><?php echo t("Οριζόντια κύληση (Carousel)");?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_tmls_columns"><?php echo t("Στήλες"); ?></label>
    <select id="wdg_tmls_columns" class="listbox">
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4" selected>4</option>
        <option value="5">5</option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_tmls_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_tmls_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_tmls_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_tmls_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl" selected>X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>

<!-- ══ TESTIMONIALS ═══════════════════════════════════════════════════════════ -->
<div class="wdg-section-title">💬 <?php echo t("Γνώμες"); ?></div>

<div id="wdg_tmls_items_container" class="ody_builder_parameter">
    <div id="wdg_tmls_items_list"></div>
    <button type="button" id="wdg_tmls_add_item_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη γνώμης"); ?>
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

    // Helper function for escaping textarea content
    function escapeForTextarea(str) {
        if (!str) return '';
        return str.replace(/&/g, '&amp;')
                  .replace(/</g, '&lt;')
                  .replace(/>/g, '&gt;');
    }

    // ── Restore scalars ────────────────────────────────────────────────────────
    $('#wdg_tmls_layout').val(pval('layout', 'grid'));
    $('#wdg_tmls_columns').val(pval('columns', '4'));
    $('#wdg_tmls_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_tmls_container_width').val(pval('container_width', 'xl'));

    // ── Header toggle ──────────────────────────────────────────────────────────
    if (pval('show_header') === '1') {
        $('#wdg_tmls_show_header').prop('checked', true);
        $('#wdg_tmls_header_fields').show();
    }
    
    $('#wdg_tmls_show_header').on('change', function () {
        $('#wdg_tmls_header_fields').toggle($(this).is(':checked'));
    });
    
    $('#wdg_tmls_eyebrow').val(pval('eyebrow'));
    $('#wdg_tmls_title').val(pval('title'));
    $('#wdg_tmls_title_size').val(pval('title_size', 't-2xl'));
    $('#wdg_tmls_description').val(pval('description'));
    $('#wdg_tmls_header_alignment').val(pval('header_alignment', 'center'));

    // ── VenoBox shared class ───────────────────────────────────────────────────
    window.venobox = new VenoBox({selector: '.wdg-tmls-select-media', fitView: true, ratio: 'full'});
    
    window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
        var targetId = $(callerEl || window._wdg_mediabank_caller).data('wdg-target');
        if (!targetId) return;
        var fullPath = 'mediabank/medium/medium_' + id + '.' + ext;
        $('#' + targetId).val(fullPath);
        $('#' + targetId + '_display').text('medium_' + id + '.' + ext);
        $('#' + targetId + '_preview').attr('src', '../' + fullPath).show();
        $('#' + targetId + '_remove').css('visibility', 'visible');
    };

    // ── addItem ────────────────────────────────────────────────────────────────
    function addItem(data) {
        data = data || {};
        var ii = _item_idx++;
        var uid = 'tmls_' + ii;
        var imgId = 'wdg_tmls_avatar_' + uid;
        
        var $item = $('<div class="wdg-tmls-item" data-ii="' + ii + '">');
        $item.append(
            '<div class="wdg-tmls-item-header">' +
            '<div class="wdg-tmls-move-buttons">' +
            '<button type="button" class="wdg-tmls-move-btn wdg-tmls-move-up">▲</button>' +
            '<button type="button" class="wdg-tmls-move-btn wdg-tmls-move-down">▼</button>' +
            '</div>' +
            '<span class="wdg-tmls-title-display"></span>' +
            '<button type="button" class="wdg-item-remove" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );
        
        var $body = $('<div class="wdg-tmls-item-body">');
        
        // ── Quote with [nl] decode ────────────────────────────────────────────
        var quoteVal = data.quote || '';
        var quoteDecoded = quoteVal.replace(/\[nl\]/g, '\n');
        
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Γνώμη"); ?></label>' +
            '<textarea id="wdg_tmls_quote_' + uid + '" class="wdg-tmls-noline listbox" rows="3" style="resize:vertical;">' + escapeForTextarea(quoteDecoded) + '</textarea></div>'
        );
        
        // ── Rating ────────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Αξιολόγηση"); ?></label>' +
            '<select id="wdg_tmls_rating_' + uid + '" class="listbox" style="max-width: 177px !important">' +
            '<option value="1">★</option>' +
            '<option value="2">★★</option>' +
            '<option value="3">★★★</option>' +
            '<option value="4">★★★★</option>' +
            '<option value="5" selected>★★★★★</option>' +
            '</select></div>'
        );
        
        // ── Avatar ────────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Εικόνα avatar"); ?></label>' +
            '<div class="wdg-img-row">' +
            '<span id="' + imgId + '_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>' +
            '<a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"' +
            ' class="wdg-tmls-select-media ody_builder_content_action btn btn-success"' +
            ' data-vbtype="iframe" data-wdg-target="' + imgId + '"><?php echo t("Επιλογή"); ?></a>' +
            '<a href="javascript:void(0)" id="' + imgId + '_remove"' +
            ' class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"><?php echo t("Αφαίρεση"); ?></a>' +
            '</div>' +
            '<input type="hidden" id="' + imgId + '" value="">' +
            '<img id="' + imgId + '_preview" class="wdg-img-preview" src="" alt="">' +
            '</div>'
        );
        
        // ── Όνομα ─────────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Όνομα"); ?></label>' +
            '<input type="text" id="wdg_tmls_name_' + uid + '" class="listbox" value="' + escapeForTextarea(data.name || '') + '"></div>'
        );
        
        // ── Ρόλος ─────────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Ρόλος / Θέση"); ?></label>' +
            '<input type="text" id="wdg_tmls_role_' + uid + '" class="listbox" value="' + escapeForTextarea(data.role || '') + '"></div>'
        );
        
        $item.append($body);
        $('#wdg_tmls_items_list').append($item);
        
        // ── Prevent Enter in quote ─────────────────────────────────────────────
        $item.find('.wdg-tmls-noline').on('keydown', function (e) {
            if (e.key === 'Enter') e.preventDefault();
        });
        
        // ── Restore rating ───────────────────────────────────────────────────
        if (data.rating) $('#wdg_tmls_rating_' + uid).val(data.rating);
        
        // ── Restore avatar ───────────────────────────────────────────────────
        if (data.avatar) {
            $('#' + imgId).val(data.avatar);
            $('#' + imgId + '_display').text(data.avatar.split('/').pop());
            $('#' + imgId + '_preview').attr('src', '../' + data.avatar).show();
            $('#' + imgId + '_remove').css('visibility', 'visible');
        }
        
        // ── Restore name + role ──────────────────────────────────────────────
        if (data.name) $('#wdg_tmls_name_' + uid).val(data.name);
        if (data.role) $('#wdg_tmls_role_' + uid).val(data.role);
        
        // ── Remove button event listener (no onclick) ────────────────────────
        $('#' + imgId + '_remove').on('click', function() {
            $('#' + imgId).val('');
            $('#' + imgId + '_display').text('<?php echo t("Επιλέξτε..."); ?>');
            $('#' + imgId + '_preview').hide().attr('src', '');
            $(this).css('visibility', 'hidden');
        });
        
        // ── Media picker reinit ──────────────────────────────────────────────
        $('.wdg-tmls-select-media').off('click').on('click', function () {
            window._wdg_mediabank_caller = this;
        });
        window.venobox = new VenoBox({selector: '.wdg-tmls-select-media', fitView: true, ratio: 'full'});
        
        // ── Item remove ──────────────────────────────────────────────────────
        $item.find('.wdg-item-remove').on('click', function () {
            $item.fadeOut(200, function () {
                $item.remove();
                renumberItems();
            });
        });
        
        // ── Move buttons ─────────────────────────────────────────────────────
        $item.find('.wdg-tmls-move-up').on('click', function (e) {
            e.stopPropagation();
            moveTmlsUp($item);
        });
        $item.find('.wdg-tmls-move-down').on('click', function (e) {
            e.stopPropagation();
            moveTmlsDown($item);
        });

        // ── Name input → update display ──────────────────────────────────────
        $('#wdg_tmls_name_' + uid).on('input', function () {
            updateTmlsDisplay($item);
        });

        updateTmlsDisplay($item);
    }

    function updateTmlsDisplay($item) {
        var ii = $item.data('ii');
        var uid = 'tmls_' + ii;
        var n = $item.index() + 1;
        var name = $('#wdg_tmls_name_' + uid).val();
        var label = '<?php echo t("Γνώμη"); ?> ' + n + (name ? ': ' + name : '');
        $item.find('.wdg-tmls-title-display').text(label);
    }

    function moveTmlsUp($item) {
        var $prev = $item.prev('.wdg-tmls-item');
        if (!$prev.length) return;
        $item.slideUp(1, function () {
            $item.insertBefore($prev);
            $item.slideDown(1, function () {
                renumberItems();
                $('html, body').animate({scrollTop: $item.offset().top - 100}, 300);
                $item.css('box-shadow', '0 0 0 2px #fbbf24');
                setTimeout(function () { $item.css('box-shadow', ''); }, 600);
            });
        });
    }

    function moveTmlsDown($item) {
        var $next = $item.next('.wdg-tmls-item');
        if (!$next.length) return;
        $item.slideUp(1, function () {
            $item.insertAfter($next);
            $item.slideDown(1, function () {
                renumberItems();
                $('html, body').animate({scrollTop: $item.offset().top - 100}, 300);
                $item.css('box-shadow', '0 0 0 2px #fbbf24');
                setTimeout(function () { $item.css('box-shadow', ''); }, 600);
            });
        });
    }

    function renumberItems() {
        $('#wdg_tmls_items_list .wdg-tmls-item').each(function () {
            updateTmlsDisplay($(this));
        });
    }

    // ── Restore items ─────────────────────────────────────────────────────────
    for (var i = 0; i < _items.length; i++) {
        addItem(_items[i]);
    }
    
    $('#wdg_tmls_add_item_btn').on('click', function () {
        addItem({});
    });
    
    // ── Label ─────────────────────────────────────────────────────────────────
    var label = 'Widget Testimonials';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Testimonials');
    
    // ── get_block_data (save) ─────────────────────────────────────────────────
    window.get_block_data = function () {
        var items = [];
        var itemEls = $('#wdg_tmls_items_list .wdg-tmls-item');
        
        for (var i = 0; i < itemEls.length; i++) {
            var ii = $(itemEls[i]).data('ii');
            var uid = 'tmls_' + ii;
            var quoteVal = $('#wdg_tmls_quote_' + uid).val();
            // Encode newlines to [nl] (NO base64)
            var quoteEncoded = quoteVal.replace(/\n/g, '[nl]');
            
            items.push({
                quote:  quoteEncoded,
                rating: $('#wdg_tmls_rating_' + uid).val(),
                avatar: $('#wdg_tmls_avatar_' + uid).val(),
                name:   $('#wdg_tmls_name_' + uid).val(),
                role:   $('#wdg_tmls_role_' + uid).val()
            });
        }
        
        return {
            widget_id: 'testimonials',
            params: {
                show_header:      $('#wdg_tmls_show_header').is(':checked') ? '1' : '0',
                eyebrow:          $('#wdg_tmls_eyebrow').val(),
                title:            $('#wdg_tmls_title').val(),
                title_size:       $('#wdg_tmls_title_size').val(),
                description:      $('#wdg_tmls_description').val(),
                header_alignment: $('#wdg_tmls_header_alignment').val(),
                layout:           $('#wdg_tmls_layout').val(),
                columns:          $('#wdg_tmls_columns').val(),
                color_scheme:     $('#wdg_tmls_color_scheme').val(),
                container_width:  $('#wdg_tmls_container_width').val(),
                items:            items
            }
        };
    };
});
</script>