<?php defined('CMS') or die("This file cannot run this way!"); ?>
<style>
    .ody_builder_parameter {
        max-width: 500px !important;
    }

    .wdg-iclst-item {
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 8px;
        background: #f9f9f9;
        transition: box-shadow 0.3s ease;
    }

    .wdg-iclst-item-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
    }

    .wdg-iclst-item-header span {
        color: white;
        font-size: 12px;
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .wdg-iclst-item-body {
        padding: 8px;
    }

    .wdg-iclst-item-body .ody_builder_parameter {
        max-width: 100% !important;
        margin-bottom: 6px;
    }

    .wdg-iclst-icon-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 4px;
    }

    .wdg-iclst-icon-preview {
        font-size: 28px;
        color: #002e3a;
        width: 36px;
        text-align: center;
        visibility: hidden;
    }

    /* ── Βελάκια μετακίνησης ── */
    .wdg-iclst-move-buttons { display: flex; gap: 4px; margin-right: 4px; }
    .wdg-iclst-move-btn { background: transparent; border: none; color: white; cursor: pointer; font-size: 12px; padding: 2px 4px; border-radius: 3px; transition: all 0.2s; }
    .wdg-iclst-move-btn:hover { background: rgba(255, 255, 255, 0.2); }
    .wdg-iclst-move-btn:active { transform: scale(0.9); }
</style>
<!-- ══ ΓΕΝΙΚΑ ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_iclst_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_iclst_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_iclst_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_iclst_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_iclst_description"><?php echo t("Υπότιτλος"); ?></label>
    <textarea id="wdg_iclst_description" class="listbox" rows="3" style="resize:vertical;"></textarea>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_iclst_header_align"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_iclst_header_align" class="listbox">
        <option value="start"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>
<!-- ══ ΕΜΦΑΝΙΣΗ ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_iclst_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_iclst_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_iclst_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_iclst_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_iclst_columns"><?php echo t("Στήλες"); ?></label>
    <select id="wdg_iclst_columns" class="listbox">
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_iclst_icon_style"><?php echo t("Τύπος εικονιδίου"); ?></label>
    <select id="wdg_iclst_icon_style" class="listbox">
        <option value="w-icon-plain"><?php echo t("Απλό"); ?></option>
        <option value="w-icon-outline"><?php echo t("Με περίγραμμα"); ?></option>
        <option value="w-icon-filled"><?php echo t("Με γέμισμα"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_iclst_icon_size"><?php echo t("Μέγεθος εικονιδίου"); ?></label>
    <select id="wdg_iclst_icon_size" class="listbox">
        <option value="w-icon-sm"><?php echo t("Μικρό"); ?></option>
        <option value="w-icon-md"><?php echo t("Κανονικό"); ?></option>
        <option value="w-icon-lg"><?php echo t("Μεγάλο"); ?></option>
        <option value="w-icon-xl"><?php echo t("Πολύ μεγάλο"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_iclst_icon_shape"><?php echo t("Σχήμα εικονιδίου"); ?></label>
    <select id="wdg_iclst_icon_shape" class="listbox">
        <option value="w-icon-sharp"><?php echo t("Τετράγωνο"); ?></option>
        <option value="w-icon-rounded"><?php echo t("Με στρογγυλεμένες γωνίες"); ?></option>
        <option value="w-icon-circle"><?php echo t("Στρογγυλό"); ?></option>
    </select>
</div>
<!-- ══ ITEMS ══════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Αντικείμενα"); ?></div>
<div id="wdg_iclst_items_container" class="ody_builder_parameter">
    <div id="wdg_iclst_items_list"></div>
    <button type="button" id="wdg_iclst_add_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη αντικειμένου"); ?>
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

        $('#wdg_iclst_eyebrow').val(pval('eyebrow'));
        $('#wdg_iclst_title').val(pval('title'));
        $('#wdg_iclst_description').val(pval('description'));
        $('#wdg_iclst_header_align').val(pval('header_align', 'center'));
        $('#wdg_iclst_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
        $('#wdg_iclst_container_width').val(pval('container_width', 'xl'));
        $('#wdg_iclst_columns').val(pval('columns', '6'));
        $('#wdg_iclst_icon_style').val(pval('icon_style', 'w-icon-plain'));
        $('#wdg_iclst_icon_size').val(pval('icon_size', 'w-icon-xl'));
        $('#wdg_iclst_icon_shape').val(pval('icon_shape', 'w-icon-circle'));

        // ── odyRecieveIcon callback ───────────────────────────────────────────
        window.odyRecieveIcon = function (icon_class, target_id) {
            $('#' + target_id).val(icon_class);
            var previewId = target_id.replace('wdg_iclst_icon_', 'wdg_iclst_icon_preview_');
            $('#' + previewId).removeClass().addClass('fa ' + icon_class).css('visibility', 'visible');
            parent.window.venobox.close();
        };

        // ── Item display ──────────────────────────────────────────────────────
        function updateItemDisplay($item) {
            var titleVal = $item.find('.wdg-iclst-title').val();
            var itemNumber = $item.index() + 1;
            var displayText = '<?php echo t("Αντικείμενο"); ?> ' + itemNumber;
            if (titleVal && titleVal.trim() !== '') {
                displayText += ': ' + titleVal;
            }
            $item.find('.wdg-iclst-item-header span').text(displayText);
        }

        function renumberItems() {
            $('#wdg_iclst_items_list .wdg-iclst-item').each(function () {
                updateItemDisplay($(this));
            });
        }

        // ── Move functions ────────────────────────────────────────────────────
        function moveItemUp($item) {
            var $prev = $item.prev('.wdg-iclst-item');
            if ($prev.length) {
                $item.slideUp(1, function () {
                    $item.insertBefore($prev);
                    $item.slideDown(1, function () {
                        renumberItems();
                        $('html, body').animate({ scrollTop: $item.offset().top - 100 }, 300);
                        $item.css('box-shadow', '0 0 0 2px #fbbf24');
                        setTimeout(function () { $item.css('box-shadow', ''); }, 100);
                    });
                });
            }
        }

        function moveItemDown($item) {
            var $next = $item.next('.wdg-iclst-item');
            if ($next.length) {
                $item.slideUp(1, function () {
                    $item.insertAfter($next);
                    $item.slideDown(1, function () {
                        renumberItems();
                        $('html, body').animate({ scrollTop: $item.offset().top - 100 }, 300);
                        $item.css('box-shadow', '0 0 0 2px #fbbf24');
                        setTimeout(function () { $item.css('box-shadow', ''); }, 100);
                    });
                });
            }
        }

        // ── Add Item ──────────────────────────────────────────────────────────
        function addItem(data) {
            data = data || {};
            var idx = _item_idx++;
            var iconFieldId   = 'wdg_iclst_icon_' + idx;
            var iconPreviewId = 'wdg_iclst_icon_preview_' + idx;
            var iconPickerId  = 'wdg_iclst_icon_picker_' + idx;

            var $item = $('<div class="wdg-iclst-item" data-idx="' + idx + '">');
            $item.append(
                '<div class="wdg-iclst-item-header">' +
                '<div class="wdg-iclst-move-buttons">' +
                '<button type="button" class="wdg-iclst-move-btn wdg-iclst-move-up" title="<?php echo t("Μετακίνηση πάνω"); ?>">▲</button>' +
                '<button type="button" class="wdg-iclst-move-btn wdg-iclst-move-down" title="<?php echo t("Μετακίνηση κάτω"); ?>">▼</button>' +
                '</div>' +
                '<span><?php echo t("Αντικείμενο"); ?> ' + ($('#wdg_iclst_items_list .wdg-iclst-item').length + 1) + '</span>' +
                '<button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
                '</div>'
            );
            var $body = $('<div class="wdg-iclst-item-body">');

            // Icon picker
            $body.append(
                '<div class="ody_builder_parameter"><label><?php echo t("Εικονίδιο"); ?></label>' +
                '<div class="wdg-iclst-icon-row">' +
                '<i id="' + iconPreviewId + '" class="fa wdg-iclst-icon-preview" style="font-size: 30px; color: #002e3a;"></i>' +
                '<a href="<?php echo array_search($block_type, $blocks); ?>-<?php echo $block_type; ?>/widgets/icon_list/icons.php?venobox=[id]' + iconFieldId + '"' +
                ' id="' + iconPickerId + '" class="wdg-iclst-icon-picker ody_builder_content_action btn btn-success" data-vbtype="iframe">' +
                '<?php echo t("Επιλογή εικονιδίου"); ?></a>' +
                '</div>' +
                '<input type="hidden" id="' + iconFieldId + '" class="wdg-iclst-icon-class" value="">' +
                '</div>'
            );
            // Title
            $body.append(
                '<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?></label>' +
                '<input type="text" class="listbox wdg-iclst-title" value="' + $('<div>').text(data.title || '').html() + '"></div>'
            );
            // Description
            $body.append(
                '<div class="ody_builder_parameter"><label><?php echo t("Υπότιτλος"); ?></label>' +
                '<input type="text" class="listbox wdg-iclst-item-desc" value="' + $('<div>').text(data.description || '').html() + '"></div>'
            );

            $item.append($body);
            $('#wdg_iclst_items_list').append($item);

            // VenoBox για icon picker
            window.venobox = new VenoBox({selector: '#' + iconPickerId, fitView: true, ratio: 'full'});

            // Φόρτωση αποθηκευμένου icon
            if (data.icon_class) {
                $('#' + iconFieldId).val(data.icon_class);
                $('#' + iconPreviewId).removeClass().addClass('fa ' + data.icon_class).css('visibility', 'visible');
            }

            // ── Real-time title update ────────────────────────────────────────
            $item.find('.wdg-iclst-title').on('input', function () {
                updateItemDisplay($item);
            });

            // ── Move buttons ──────────────────────────────────────────────────
            $item.find('.wdg-iclst-move-up').on('click', function (e) {
                e.stopPropagation();
                moveItemUp($item);
            });
            $item.find('.wdg-iclst-move-down').on('click', function (e) {
                e.stopPropagation();
                moveItemDown($item);
            });

            $item.find('.wdg-item-remove').on('click', function () {
                $item.fadeOut(200, function () {
                    $item.remove();
                    renumberItems();
                });
            });

            updateItemDisplay($item);
        }

        _items.forEach(function (item) { addItem(item); });
        $('#wdg_iclst_add_btn').on('click', function () { addItem({}); });

        label = 'Widget Icon List';
        $('#ody_builder_admin_label').val(label);
        $('.ody_builder_header h2').html('Widgetizer — Icon List');

        window.get_block_data = function () {
            var items = [];
            $('#wdg_iclst_items_list .wdg-iclst-item').each(function () {
                var $it = $(this);
                var idx = $it.data('idx');
                items.push({
                    icon_class:  $('#wdg_iclst_icon_' + idx).val(),
                    title:       $it.find('.wdg-iclst-title').val(),
                    description: $it.find('.wdg-iclst-item-desc').val()
                });
            });
            return {
                widget_id: 'icon_list',
                params: {
                    eyebrow:         $('#wdg_iclst_eyebrow').val(),
                    title:           $('#wdg_iclst_title').val(),
                    description:     $('#wdg_iclst_description').val(),
                    header_align:    $('#wdg_iclst_header_align').val(),
                    color_scheme:    $('#wdg_iclst_color_scheme').val(),
                    container_width: $('#wdg_iclst_container_width').val(),
                    columns:         $('#wdg_iclst_columns').val(),
                    icon_style:      $('#wdg_iclst_icon_style').val(),
                    icon_size:       $('#wdg_iclst_icon_size').val(),
                    icon_shape:      $('#wdg_iclst_icon_shape').val(),
                    items:           items
                }
            };
        };
    });
</script>
