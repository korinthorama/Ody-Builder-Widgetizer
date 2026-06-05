<?php
/*
 * Widgetizer — Features Split Widget — view.php
 * Prefix: fs
 */
?>
<style>
    .ody_builder_parameter { max-width: 500px !important; }
    .wdg-fs-item { border: 1px solid #ddd; border-radius: 4px; margin-bottom: 8px; background: #f9f9f9; }
    .wdg-fs-item-header { display: flex; align-items: center; gap: 8px; padding: 6px 8px; background: #002e3a; border-radius: 4px 4px 0 0; cursor: move; }
    .wdg-fs-item-header span { color: white; font-size: 12px; flex: 1; }
    .wdg-fs-item-body { padding: 8px; }
    .wdg-fs-item-body .ody_builder_parameter { max-width: 100% !important; margin-bottom: 6px; }
    .wdg-fs-add-btn { display: inline-block; padding: 6px 16px; background: #002e3a; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; margin-top: 4px; }
    .wdg-fs-add-btn:hover { background: #004a5c; }
    .wdg-fs-icon-row { display: flex; align-items: center; gap: 10px; margin-bottom: 6px; }
    .wdg-fs-icon-preview { font-size: 28px; color: #002e3a; width: 36px; text-align: center; visibility: hidden; }
</style>

<!-- ══ ΓΕΝΙΚΑ ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_fs_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_fs_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_fs_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_fs_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_fs_description"><?php echo t("Υπότιτλος"); ?></label>
    <textarea id="wdg_fs_description" class="listbox" rows="3" style="resize:vertical;"></textarea>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_fs_header_align"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_fs_header_align" class="listbox">
        <option value="start"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_fs_icon_style"><?php echo t("Τύπος εικονιδίου"); ?></label>
    <select id="wdg_fs_icon_style" class="listbox">
        <option value="w-icon-plain"><?php echo t("Απλό");?></option>
        <option value="w-icon-outline"><?php echo t("Με περίγραμμα");?></option>
        <option value="w-icon-filled"><?php echo t("Με γέμισμα");?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_fs_icon_size"><?php echo t("Μέγεθος εικονιδίου"); ?></label>
    <select id="wdg_fs_icon_size" class="listbox">
        <option value="w-icon-sm"><?php echo t("Μικρό");?></option>
        <option value="w-icon-md"><?php echo t("Κανονικό");?></option>
        <option value="w-icon-lg"><?php echo t("Μεγάλο");?></option>
        <option value="w-icon-xl"><?php echo t("Πολύ μεγάλο");?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_fs_icon_shape"><?php echo t("Σχήμα εικονιδίου"); ?></label>
    <select id="wdg_fs_icon_shape" class="listbox">
        <option value="w-icon-sharp"><?php echo t("Τετράγωνο");?></option>
        <option value="w-icon-rounded"><?php echo t("Με στρογγυλεμένες γωνίες");?></option>
        <option value="w-icon-circle"><?php echo t("Στρογγυλό");?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_fs_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_fs_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_fs_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_fs_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>

<!-- ══ FEATURES ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Χαρακτηριστικά / Δυνατότητες"); ?></div>
<div id="wdg_fs_items" style="max-width:100%;"></div>
<button type="button" class="ody_builder_content_action btn btn-success wdg-fs-add-btn" id="wdg_fs_add_btn">+ <?php echo t("Προσθήκη χαρακτηριστικού"); ?></button>


<script>
jQuery(function ($) {
    var _p = _saved_params || {};
    var _items = _p['items'] || [];

    function pval(key, def) { return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : ''); }

    $('#wdg_fs_eyebrow').val(pval('eyebrow'));
    $('#wdg_fs_title').val(pval('title'));
    $('#wdg_fs_description').val(pval('description'));
    $('#wdg_fs_header_align').val(pval('header_align', 'center'));
    $('#wdg_fs_icon_style').val(pval('icon_style', 'w-icon-filled'));
    $('#wdg_fs_icon_size').val(pval('icon_size', 'w-icon-lg'));
    $('#wdg_fs_icon_shape').val(pval('icon_shape', 'w-icon-circle'));
    $('#wdg_fs_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_fs_container_width').val(pval('container_width', 'xl'));


    var _item_idx = 0;

    function addItem(data) {
        data = data || {};
        var idx = _item_idx++;
        var iconFieldId  = 'wdg_fs_icon_' + idx;
        var iconPreviewId = 'wdg_fs_icon_preview_' + idx;
        var iconPickerId  = 'wdg_fs_icon_picker_' + idx;

        var $item = $('<div class="wdg-fs-item" data-idx="' + idx + '">');
        $item.append('<div class="wdg-fs-item-header"><span><?php echo t("Χαρακτηριστικό"); ?> ' + ($('#wdg_fs_items .wdg-fs-item').length + 1) + '</span><button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button></div>');
        var $body = $('<div class="wdg-fs-item-body">');

        // Icon picker
        $body.append(
                '<div class="ody_builder_parameter"><label><?php echo t("Εικονίδιο"); ?></label>' +
                '<div class="wdg-fs-icon-row">' +
                '<i id="' + iconPreviewId + '" class="fa wdg-fs-icon-preview" style="font-size: 30px; color: #002e3a;"></i>' +
                '<a href="<?php echo array_search($block_type, $blocks); ?>-<?php echo $block_type; ?>/widgets/features_split/icons.php?venobox=[id]' + iconFieldId + '"' +
                ' id="' + iconPickerId + '" class="wdg-fs-icon-picker ody_builder_content_action btn btn-success" data-vbtype="iframe">' +
                '<?php echo t("Επιλογή εικονιδίου"); ?></a>' +
                '</div>' +
                '<input type="hidden" id="' + iconFieldId + '" class="wdg-fs-icon-class" value="">' +
                '</div>'
        );

        // Title
        $body.append('<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?></label><input type="text" class="listbox wdg-fs-title" value="' + $('<div>').text(data.title||'').html() + '"></div>');

        // Description
        $body.append('<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label><textarea class="listbox wdg-fs-description" rows="2" style="resize:vertical;">' + $('<div>').text(data.description||'').html() + '</textarea></div>');

        $item.append($body);
        $('#wdg_fs_items').append($item);

        // VenoBox για icon picker — window.venobox απαιτείται από icons.php για close()
        window.venobox = new VenoBox({selector: '#' + iconPickerId, fitView: true, ratio: 'full'});

        // Φόρτωση αποθηκευμένου icon
        if (data.icon_class) {
            $('#' + iconFieldId).val(data.icon_class);
            $('#' + iconPreviewId).removeClass().addClass('fa ' + data.icon_class).css('visibility', 'visible');
        }

        $item.find('.wdg-item-remove').on('click', function() { $item.fadeOut(200, function() { $item.remove(); renumberItems(); }); });
    }

    function renumberItems() {
        $('#wdg_fs_items .wdg-fs-item').each(function(idx) {
            $(this).find('.wdg-fs-item-header span').text('<?php echo t("Χαρακτηριστικό"); ?> ' + (idx + 1));
        });
    }

    // ── odyRecieveIcon: callback από icons.php ────────────────────────────────
    window.odyRecieveIcon = function(icon_class, target_id) {
        $('#' + target_id).val(icon_class);
        // Βρες το preview που αντιστοιχεί
        var previewId = target_id.replace('wdg_fs_icon_', 'wdg_fs_icon_preview_');
        $('#' + previewId).removeClass().addClass('fa ' + icon_class).css('visibility', 'visible');
        parent.window.venobox.close();
    };

    _items.forEach(function(item) { addItem(item); });
    $('#wdg_fs_add_btn').on('click', function() { addItem({}); });

    if ($.fn.sortable) {
        $('#wdg_fs_items').sortable({ handle: '.wdg-fs-item-header', placeholder: 'block-placeholder', tolerance: 'pointer', stop: function() { renumberItems(); } });
    }

    label = 'Widget Features Split';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Features Split');

    window.get_block_data = function() {
        var items = [];
        $('#wdg_fs_items .wdg-fs-item').each(function() {
            var $it = $(this);
            var idx = $it.data('idx');
            items.push({
                icon_class:  $('#wdg_fs_icon_' + idx).val(),
                title:       $it.find('.wdg-fs-title').val(),
                description: $it.find('.wdg-fs-description').val()
            });
        });
        return {
            widget_id: 'features_split',
            params: {
                eyebrow:         $('#wdg_fs_eyebrow').val(),
                title:           $('#wdg_fs_title').val(),
                description:     $('#wdg_fs_description').val(),
                header_align:    $('#wdg_fs_header_align').val(),
                icon_style:      $('#wdg_fs_icon_style').val(),
                icon_size:       $('#wdg_fs_icon_size').val(),
                icon_shape:      $('#wdg_fs_icon_shape').val(),
                color_scheme:    $('#wdg_fs_color_scheme').val(),
                container_width: $('#wdg_fs_container_width').val(),
                items:           items
            }
        };
    };
});
</script>
