<?php defined('CMS') or die("This file cannot run this way!"); ?>
<style>
    .ody_builder_parameter {
        max-width: 500px !important;
    }

    .selectLink {
        border: 2px solid #002e3a !important;
        height: auto !important;
        padding: 2px 10px !important;
        font-size: .8em !important;
        background-color: #002e3a;
        color: white;
        max-width: 400px !important;
        width: 100% !important;
        margin: 2px 0 5px;
    }

    .wdg-icg-item {
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 8px;
        background: #f9f9f9;
    }

    .wdg-icg-item-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
        cursor: move;
    }

    .wdg-icg-item-header span {
        color: white;
        font-size: 12px;
        flex: 1;
    }

    .wdg-icg-item-body {
        padding: 8px;
    }

    .wdg-icg-item-body .ody_builder_parameter {
        max-width: 100% !important;
        margin-bottom: 6px;
    }

    .wdg-icg-icon-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 4px;
    }

    .wdg-icg-icon-preview {
        font-size: 30px;
        color: rgb(0, 46, 58);
        width: 32px;
        text-align: center;
        visibility: hidden;
    }
</style>
<!-- ══ ΓΕΝΙΚΑ ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_icg_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_icg_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_icg_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_icg_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_icg_description"><?php echo t("Υπότιτλος"); ?></label>
    <textarea id="wdg_icg_description" class="listbox" rows="3" style="resize:vertical;"></textarea>
</div>
<!-- ══ ΕΜΦΑΝΙΣΗ ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_icg_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_icg_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_icg_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_icg_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_icg_columns"><?php echo t("Στήλες"); ?></label>
    <select id="wdg_icg_columns" class="listbox">
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_icg_card_layout"><?php echo t("Τύπος κάρτας"); ?></label>
    <select id="wdg_icg_card_layout" class="listbox">
        <option value="box"><?php echo t("Με περίγραμμα"); ?></option>
        <option value="flat"><?php echo t("Χωρίς περίγραμμα"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_icg_icon_style"><?php echo t("Τύπος εικονιδίου"); ?></label>
    <select id="wdg_icg_icon_style" class="listbox">
        <option value="w-icon-plain"><?php echo t("Απλό"); ?></option>
        <option value="w-icon-outline"><?php echo t("Με περίγραμμα"); ?></option>
        <option value="w-icon-filled"><?php echo t("Με γέμισμα"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_icg_icon_size"><?php echo t("Μέγεθος εικονιδίου"); ?></label>
    <select id="wdg_icg_icon_size" class="listbox">
        <option value="w-icon-sm"><?php echo t("Μικρό"); ?></option>
        <option value="w-icon-md"><?php echo t("Μικρό"); ?></option>
        <option value="w-icon-lg"><?php echo t("Μεγάλο"); ?></option>
        <option value="w-icon-xl"><?php echo t("Πολύ μεγάλο"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_icg_icon_shape"><?php echo t("Σχήμα εικονιδίου"); ?></label>
    <select id="wdg_icg_icon_shape" class="listbox">
        <option value="w-icon-sharp"><?php echo t("Τετράγωνο"); ?></option>
        <option value="w-icon-rounded"><?php echo t("Με στρογγυλεμένες γωνίες"); ?></option>
        <option value="w-icon-circle"><?php echo t("Στρογγυλό"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_icg_btn_style"><?php echo t("Εμφάνιση κουμπιού"); ?></label>
    <select id="wdg_icg_btn_style" class="listbox">
        <option value="widget-button-primary">Primary</option>
        <option value="widget-button-secondary">Secondary</option>
    </select>
</div>
<!-- ══ CARDS ═════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Κάρτες"); ?></div>
<div id="wdg_icg_items_container" class="ody_builder_parameter">
    <div id="wdg_icg_items_list"></div>
    <button type="button" id="wdg_icg_add_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη κάρτας"); ?>
    </button>
</div>

<?php
// ── Page options για selectLink (static PHP — ίδιο pattern με action_bar) ────
$q = "select pages.id as id, content_pages.title as title
      from pages, content_pages
      where content_pages.mainID=pages.id
      and content_pages.langID=" . $langID . "
      order by pages.sort, content_pages.title";
$_icg_pages = $db->getRecords($q);
$_icg_page_opts = '<option value="">' . t("ή επιλέξτε υπάρχουσα σελίδα") . '</option>';
$_icg_page_opts .= '<option value="homepage">' . t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ") . '</option>';
foreach($_icg_pages as $_icg_row) {
    $_icg_page_opts .= '<option value="' . $_icg_row->id . '">' . htmlspecialchars($_icg_row->title) . '</option>';
}
$_icg_page_opts .= '<option value="divider">--------------------------------------</option>';
$_icg_page_opts .= '<option value="nodeLinks_icg">' . t("Link για εγγραφή ενότητας") . ' >></option>';
$_icg_page_opts .= '<option value="divider">--------------------------------------</option>';
$_icg_page_opts .= '<option value="fileLinks_icg">' . t("Link για αρχείο") . ' >></option>';
?>
<!-- Hidden node/file popup anchors — δημιουργούνται dynamically per card στο JS -->
<div id="wdg_icg_popups_container" style="display:none;"></div>
<script>
    jQuery(function ($) {
        var _page_opts = <?php echo json_encode($_icg_page_opts); ?>;
        var _p = _saved_params || {};
        var _items = _p['items'] || [];
        var _item_idx = 0;

        function pval(key, def) {
            return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
        }

        $('#wdg_icg_eyebrow').val(pval('eyebrow'));
        $('#wdg_icg_title').val(pval('title'));
        $('#wdg_icg_description').val(pval('description'));
        $('#wdg_icg_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
        $('#wdg_icg_container_width').val(pval('container_width', 'xl'));
        $('#wdg_icg_columns').val(pval('columns', '4'));
        $('#wdg_icg_card_layout').val(pval('card_layout', 'box'));
        $('#wdg_icg_icon_style').val(pval('icon_style', 'w-icon-plain'));
        $('#wdg_icg_icon_size').val(pval('icon_size', 'w-icon-lg'));
        $('#wdg_icg_icon_shape').val(pval('icon_shape', 'w-icon-circle'));
        $('#wdg_icg_btn_style').val(pval('btn_style', 'widget-button-secondary'));
        // ── odyRecieveIcon callback ───────────────────────────────────────────────
        window.odyRecieveIcon = function (icon_class, target_id) {
            $('#' + target_id).val(icon_class);
            var previewId = target_id.replace('wdg_icg_icon_', 'wdg_icg_icon_preview_');
            $('#' + previewId).removeClass().addClass('fa ' + icon_class).css('visibility', 'visible');
            parent.window.venobox.close();
        };
        // ── Link picker helper — ίδιο pattern με action_bar ──────────────────────
        window.wdgIcgSetLink = function (val, urlFieldId, idx) {
            if(!val || val === 'divider') return;
            if(val === 'nodeLinks_icg') {
                document.getElementById('wdg_icg_node_popup_' + idx).click();
                return;
            }
            if(val === 'fileLinks_icg') {
                document.getElementById('wdg_icg_file_popup_' + idx).click();
                return;
            }
            var link = (val === 'homepage')
                    ? 'index.php'
                    : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
            $('#' + urlFieldId).val(link);
        };

        // ── Add Card ──────────────────────────────────────────────────────────────
        function addItem(data) {
            data = data || {};
            var idx = _item_idx++;
            var iconFieldId = 'wdg_icg_icon_' + idx;
            var iconPreviewId = 'wdg_icg_icon_preview_' + idx;
            var iconPickerId = 'wdg_icg_icon_picker_' + idx;
            var urlFieldId = 'wdg_icg_url_' + idx;
            var nodePopupId = 'wdg_icg_node_popup_' + idx;
            var filePopupId = 'wdg_icg_file_popup_' + idx;
            var $item = $('<div class="wdg-icg-item" data-idx="' + idx + '">');
            $item.append(
                    '<div class="wdg-icg-item-header">' +
                    '<span><?php echo t("Card"); ?> ' + ($('#wdg_icg_items_list .wdg-icg-item').length + 1) + '</span>' +
                    '<button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
                    '</div>'
            );
            var $body = $('<div class="wdg-icg-item-body">');
            // Icon picker
            $body.append(
                    '<div class="ody_builder_parameter"><label><?php echo t("Εικονίδιο"); ?></label>' +
                    '<div class="wdg-icg-icon-row">' +
                    '<i id="' + iconPreviewId + '" class="fa wdg-icg-icon-preview" style="font-size: 30px; color: #002e3a;"></i>' +
                    '<a href="<?php echo array_search($block_type, $blocks); ?>-<?php echo $block_type; ?>/widgets/icon_card_grid/icons.php?venobox=[id]' + iconFieldId + '"' +
                    ' id="' + iconPickerId + '" class="wdg-icg-icon-picker ody_builder_content_action btn btn-success" data-vbtype="iframe">' +
                    '<?php echo t("Επιλογή εικονιδίου"); ?></a>' +
                    '</div>' +
                    '<input type="hidden" id="' + iconFieldId + '" class="wdg-icg-icon-class" value="">' +
                    '</div>'
            );
            // Subtitle
            $body.append(
                    '<div class="ody_builder_parameter"><label><?php echo t("Υπότιτλος"); ?></label>' +
                    '<input type="text" class="listbox wdg-icg-subtitle" value="' + $('<div>').text(data.subtitle || '').html() + '"></div>'
            );
            // Title
            $body.append(
                    '<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?></label>' +
                    '<input type="text" class="listbox wdg-icg-title" value="' + $('<div>').text(data.title || '').html() + '"></div>'
            );
            // Description
            $body.append(
                    '<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label>' +
                    '<textarea class="listbox wdg-icg-description" rows="2" style="resize:vertical;">' + $('<div>').text(data.description || '').html() + '</textarea></div>'
            );
            // Button label
            $body.append(
                    '<div class="ody_builder_parameter"><label><?php echo t("Ετικέτα κουμπιού (κενό = χωρίς κουμπί)"); ?></label>' +
                    '<input type="text" class="listbox wdg-icg-btn-label" value="' + $('<div>').text(data.btn_label || '').html() + '"></div>'
            );
            // Button URL + selectLink
            $body.append(
                    '<div class="ody_builder_parameter"><label>Link</label>' +
                    '<input type="text" class="listbox wdg-icg-btn-url" id="' + urlFieldId + '" value="' + $('<div>').text(data.btn_url || '').html() + '">' +
                    '<select class="selectLink listbox" onchange="wdgIcgSetLink($(this).val(), \'' + urlFieldId + '\', ' + idx + '); $(this).val(\'\');">' +
                    _page_opts +
                    '</select>' +
                    '</div>'
            );
            // New tab checkbox
            $body.append(
                    '<div class="ody_builder_parameter">' +
                    '<div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">' +
                    '<input type="checkbox" class="wdg-icg-btn-newtab" id="wdg_icg_newtab_' + idx + '" value="1">' +
                    '<p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>' +
                    '</div></div>'
            );
            $item.append($body);
            $('#wdg_icg_items_list').append($item);
            // Hidden node/file popup anchors για αυτό το card
            $('#wdg_icg_popups_container').append(
                    '<a id="' + nodePopupId + '" class="builder_popup" data-vbtype="iframe"' +
                    ' href="section_links.php?venobox=[id]' + urlFieldId + '">iFrame</a>' +
                    '<a id="' + filePopupId + '" class="builder_popup" data-vbtype="iframe"' +
                    ' href="file_links.php?venobox=[id]' + urlFieldId + '">iFrame</a>'
            );
            new VenoBox({selector: '#' + nodePopupId, fitView: true, ratio: 'full'});
            new VenoBox({selector: '#' + filePopupId, fitView: true, ratio: 'full'});
            // VenoBox για icon picker
            window.venobox = new VenoBox({selector: '#' + iconPickerId, fitView: true, ratio: 'full'});
            // Φόρτωση αποθηκευμένων τιμών
            if(data.icon_class) {
                $('#' + iconFieldId).val(data.icon_class);
                $('#' + iconPreviewId).removeClass().addClass('fa ' + data.icon_class).css('visibility', 'visible');
            }
            if(data.btn_new_tab == '1') {
                $('#wdg_icg_newtab_' + idx).prop('checked', true);
            }
            $item.find('.wdg-item-remove').on('click', function () {
                $item.fadeOut(200, function () {
                    $item.remove();
                    renumberItems();
                });
            });
            if($.fn.sortable) {
                $('#wdg_icg_items_list').sortable({handle: '.wdg-icg-item-header', placeholder: 'block-placeholder', tolerance: 'pointer', stop: function() { renumberItems(); }});
            }
        }

        function renumberItems() {
            $('#wdg_icg_items_list .wdg-icg-item').each(function(idx) {
                $(this).find('.wdg-icg-item-header span').text('<?php echo t("Card"); ?> ' + (idx + 1));
            });
        }

        _items.forEach(function (item) {
            addItem(item);
        });
        $('#wdg_icg_add_btn').on('click', function () {
            addItem({});
        });
        label = 'Widget Icon Card Grid';
        $('#ody_builder_admin_label').val(label);
        $('.ody_builder_header h2').html('Widgetizer — Icon Card Grid');
        window.get_block_data = function () {
            var items = [];
            $('#wdg_icg_items_list .wdg-icg-item').each(function () {
                var $it = $(this);
                var idx = $it.data('idx');
                items.push({
                    icon_class:  $('#wdg_icg_icon_' + idx).val(),
                    subtitle:    $it.find('.wdg-icg-subtitle').val(),
                    title:       $it.find('.wdg-icg-title').val(),
                    description: $it.find('.wdg-icg-description').val(),
                    btn_label:   $it.find('.wdg-icg-btn-label').val(),
                    btn_url:     $it.find('.wdg-icg-btn-url').val(),
                    btn_new_tab: $it.find('.wdg-icg-btn-newtab').is(':checked') ? '1' : '0'
                });
            });
            return {
                widget_id: 'icon_card_grid',
                params:    {
                    eyebrow:         $('#wdg_icg_eyebrow').val(),
                    title:           $('#wdg_icg_title').val(),
                    description:     $('#wdg_icg_description').val(),
                    color_scheme:    $('#wdg_icg_color_scheme').val(),
                    container_width: $('#wdg_icg_container_width').val(),
                    columns:         $('#wdg_icg_columns').val(),
                    card_layout:     $('#wdg_icg_card_layout').val(),
                    icon_style:      $('#wdg_icg_icon_style').val(),
                    icon_size:       $('#wdg_icg_icon_size').val(),
                    icon_shape:      $('#wdg_icg_icon_shape').val(),
                    btn_style:       $('#wdg_icg_btn_style').val(),
                    items:           items
                }
            };
        };
    });
</script>
