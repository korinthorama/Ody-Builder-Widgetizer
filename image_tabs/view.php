<?php defined('CMS') or die("This file cannot run this way!"); ?>

<style>
    .ody_builder_parameter { max-width: 500px !important; }
    .wdg-image-row { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
    .wdg-img-filename { font-size: 12px; color: #999; font-style: italic; word-break: break-all; }
    .wdg-img-preview { max-height: 50px; max-width: 120px; margin-top: 4px; border-radius: 3px; display: none; border: 1px solid #ddd; }
    .selectLink {
        border: 2px solid #002e3a !important; height: auto !important; padding: 2px 10px !important;
        font-size: .8em !important; background-color: #002e3a; color: white;
        max-width: 400px !important; width: 100% !important; margin: 2px 0 5px;
    }
    /* Tab items */
    .wdg-imtb-item { border: 1px solid #ccc; border-radius: 4px; margin-bottom: 8px; background: #f9f9f9; }
    .wdg-imtb-item-header { display: flex; align-items: center; gap: 8px; padding: 6px 8px; background: #002e3a; border-radius: 4px 4px 0 0; cursor: move; }
    .wdg-imtb-item-header span { color: white; font-size: 12px; flex: 1; }
    .wdg-imtb-item-body { padding: 8px; }
    .wdg-imtb-item-body .ody_builder_parameter { max-width: 100% !important; margin-bottom: 6px; }
</style>

<!-- ══ ΓΕΝΙΚΑ ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_imtb_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_imtb_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_imtb_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_imtb_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_imtb_description"><?php echo t("Περιγραφή"); ?></label>
    <textarea id="wdg_imtb_description" class="listbox" rows="3" style="resize:vertical;"></textarea>
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_imtb_image_position"><?php echo t("Θέση Εικόνας"); ?></label>
    <select id="wdg_imtb_image_position" class="listbox">
        <option value="left"><?php echo t("Αριστερά"); ?></option>
        <option value="right"><?php echo t("Δεξιά"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_imtb_aspect_ratio">Aspect Ratio</label>
    <select id="wdg_imtb_aspect_ratio" class="listbox">
        <option value="auto">Auto</option>
        <option value="contain">Contain</option>
        <option value="1 / 1">1:1</option>
        <option value="4 / 3">4:3</option>
        <option value="3 / 2">3:2</option>
        <option value="3 / 4">3:4</option>
        <option value="16 / 9">16:9</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_imtb_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_imtb_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_imtb_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_imtb_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>

<!-- ══ TABS ═══════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("📑 Tabs"); ?></div>
<div id="wdg_imtb_tabs_container" class="ody_builder_parameter">
    <div id="wdg_imtb_tabs_list"></div>
    <button type="button" id="wdg_imtb_add_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη Tab"); ?>
    </button>
    <input type="hidden" id="wdg_imtb_tabs" value="">
</div>

<script>
jQuery(function ($) {
    var _p = _saved_params || {};
    var _item_idx = 0;

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    $('#wdg_imtb_eyebrow').val(pval('eyebrow'));
    $('#wdg_imtb_title').val(pval('title'));
    $('#wdg_imtb_description').val(pval('description'));
    $('#wdg_imtb_image_position').val(pval('image_position', 'left'));
    $('#wdg_imtb_aspect_ratio').val(pval('aspect_ratio', 'contain'));
    $('#wdg_imtb_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_imtb_container_width').val(pval('container_width', 'xl'));

    // ── odyRecieveMediabank — csw pattern ─────────────────────────────────────
    window.venobox = new VenoBox({selector: '.ody_builder_select_media', fitView: true, ratio: 'full'});
    $('.ody_builder_select_media').on('click', function() { window._wdg_mediabank_caller = this; });

    window.odyRecieveMediabank = function(file, id, ext, image_path, callerEl) {
        var targetId = $(callerEl || window._wdg_mediabank_caller).data('wdg-target');
        if (!targetId) return;
        var fullPath = image_path + id + '.' + ext;
        $('#' + targetId).val(fullPath);
        $('#' + targetId + '_display').text(file);
        $('#' + targetId + '_preview').attr('src', fullPath).show();
        $('#' + targetId + '_remove').css('visibility', 'visible');
    };

    // ── Save tabs ─────────────────────────────────────────────────────────────
    function saveTabs() {
        var items = [];
        $('#wdg_imtb_tabs_list .wdg-imtb-item').each(function() {
            var $it = $(this);
            var idx = $it.data('idx');
            items.push({
                title:       $it.find('.wdg-imtb-title').val(),
                description: $it.find('.wdg-imtb-desc').val(),
                image:       $('#wdg_imtb_img_' + idx).val()
            });
        });
        $('#wdg_imtb_tabs').val(JSON.stringify(items));
    }

    // ── Add Tab ───────────────────────────────────────────────────────────────
    function addItem(data) {
        data = data || {};
        var idx    = _item_idx++;
        var imgId  = 'wdg_imtb_img_' + idx;
        var mediaId = 'wdg_imtb_media_' + idx;

        var $item = $('<div class="wdg-imtb-item" data-idx="' + idx + '">');
        $item.append(
            '<div class="wdg-imtb-item-header">' +
            '<span>Tab ' + ($('#wdg_imtb_tabs_list .wdg-imtb-item').length + 1) + '</span>' +
            '<button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );

        var $body = $('<div class="wdg-imtb-item-body">');

        // Title
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?></label>' +
            '<input type="text" class="listbox wdg-imtb-title" value="' + $('<div>').text(data.title || '').html() + '"></div>'
        );

        // Description
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label>' +
            '<textarea class="listbox wdg-imtb-desc" rows="2" style="resize:vertical;">' + $('<div>').text(data.description || '').html() + '</textarea></div>'
        );

        // Image picker
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Εικόνα"); ?></label>' +
            '<div class="wdg-image-row">' +
            '<span id="' + imgId + '_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>' +
            '<a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>" id="' + mediaId + '"' +
            ' class="ody_builder_select_media ody_builder_content_action btn btn-success" data-vbtype="iframe" data-wdg-target="' + imgId + '"><?php echo t("Επιλογή"); ?></a>' +
            '<a href="javascript:void(0)" id="' + imgId + '_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;">' +
            '<?php echo t("Αφαίρεση"); ?></a>' +
            '</div>' +
            '<input type="hidden" id="' + imgId + '" class="wdg-imtb-img" value="">' +
            '<img id="' + imgId + '_preview" class="wdg-img-preview" src="" alt="">' +
            '</div>'
        );

        $item.append($body);
        $('#wdg_imtb_tabs_list').append($item);

        // Per-item VenoBox
        new VenoBox({ selector: '#' + mediaId, fitView: true, ratio: 'full' });
        $('#' + mediaId).on('click', function() { window._wdg_mediabank_caller = this; });

        // Remove button
        $('#' + imgId + '_remove').on('click', function() {
            $('#' + imgId).val('');
            $('#' + imgId + '_display').text('<?php echo t("Επιλέξτε..."); ?>');
            $('#' + imgId + '_preview').hide().attr('src', '');
            $(this).css('visibility', 'hidden');
            saveTabs();
        });

        // Φόρτωση αποθηκευμένης εικόνας
        if (data.image) {
            $('#' + imgId).val(data.image);
            $('#' + imgId + '_display').text(data.image.split('/').pop());
            $('#' + imgId + '_preview').attr('src', data.image).show();
            $('#' + imgId + '_remove').css('visibility', 'visible');
        }

        $item.find('.wdg-item-remove').on('click', function() {
            $item.fadeOut(200, function() { $item.remove(); renumberItems(); saveTabs(); });
        });

        $item.find('input:not(.wdg-imtb-img), textarea').on('input change', function() { saveTabs(); });

        if ($.fn.sortable) {
            $('#wdg_imtb_tabs_list').sortable({
                handle: '.wdg-imtb-item-header',
                placeholder: 'block-placeholder',
                tolerance: 'pointer',
                update: function() { renumberItems(); saveTabs(); }
            });
        }
    }

    function renumberItems() {
        $('#wdg_imtb_tabs_list .wdg-imtb-item').each(function(idx) {
            $(this).find('.wdg-imtb-item-header span').text('<?php echo t("Tab"); ?> ' + (idx + 1));
        });
    }

    // Φόρτωση αποθηκευμένων tabs
    var _saved_tabs = pval('tabs');
    if (_saved_tabs) {
        try { JSON.parse(_saved_tabs).forEach(function(t) { addItem(t); }); } catch(e) {}
    }

    $('#wdg_imtb_add_btn').on('click', function() { addItem({}); saveTabs(); });

    label = 'Widget Image Tabs';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Image Tabs');

    window.get_block_data = function() {
        saveTabs();
        return {
            widget_id: 'image_tabs',
            params: {
                eyebrow:        $('#wdg_imtb_eyebrow').val(),
                title:          $('#wdg_imtb_title').val(),
                description:    $('#wdg_imtb_description').val(),
                image_position: $('#wdg_imtb_image_position').val(),
                aspect_ratio:   $('#wdg_imtb_aspect_ratio').val(),
                color_scheme:   $('#wdg_imtb_color_scheme').val(),
                container_width:$('#wdg_imtb_container_width').val(),
                tabs:           $('#wdg_imtb_tabs').val()
            }
        };
    };
});
</script>
