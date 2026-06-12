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
    }

    .wdg-icg-item-header span {
        color: white;
        font-size: 12px;
        flex: 1;
    }

    .wdg-icg-move-buttons {
        display: flex;
        gap: 2px;
        margin-right: 4px;
    }

    .wdg-icg-move-btn {
        background: #004a5c;
        border: none;
        color: white;
        border-radius: 3px;
        cursor: pointer;
        font-size: 10px;
        padding: 2px 6px;
        line-height: 1.2;
    }
    .wdg-icg-move-btn:hover { background: #006982; }

    .wdg-icg-item-body {
        padding: 8px;
    }

    .wdg-icg-item-body .ody_builder_parameter {
        max-width: 100% !important;
        margin-bottom: 6px;
    }

    .wdg-icg-image-preview {
        max-width: 80px;
        max-height: 60px;
        object-fit: cover;
        border-radius: 4px;
        display: none;
        margin-top: 6px;
    }
</style>

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
    <label for="wdg_icg_btn_style"><?php echo t("Εμφάνιση κουμπιού"); ?></label>
    <select id="wdg_icg_btn_style" class="listbox">
        <option value="widget-button-primary">Primary</option>
        <option value="widget-button-secondary">Secondary</option>
    </select>
</div>

<div class="wdg-section-title"><?php echo t("Κάρτες"); ?></div>
<div id="wdg_icg_items_container" class="ody_builder_parameter">
    <div id="wdg_icg_items_list"></div>
    <button type="button" id="wdg_icg_add_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη κάρτας"); ?>
    </button>
</div>

<div id="wdg_icg_popups_container" style="display:none;"></div>

<?php
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
        $('#wdg_icg_btn_style').val(pval('btn_style', 'widget-button-secondary'));

        window.odyRecieveMediabank = function(file, id, ext, image_path, callerEl) {
            var fullPath = image_path + id + '.' + ext;
            var $btn = $(callerEl || window._wdg_mediabank_caller);
            var idx2 = $btn.attr('id').replace('wdg_icg_img_media_', '');
            $('#wdg_icg_img_' + idx2).val(fullPath);
            $('#wdg_icg_img_display_' + idx2).text(fullPath);
            $('#wdg_icg_img_preview_' + idx2).show().attr('src', fullPath);
            $('#wdg_icg_img_remove_' + idx2).css('visibility', 'visible');
            parent.window.venobox.close();
        };

        window.wdgIcgSetLink = function (val, urlFieldId, idx) {
            if (!val || val === 'divider') return;
            if (val === 'nodeLinks_icg') { document.getElementById('wdg_icg_node_popup_' + idx).click(); return; }
            if (val === 'fileLinks_icg') { document.getElementById('wdg_icg_file_popup_' + idx).click(); return; }
            var link = (val === 'homepage') ? 'index.php' : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
            $('#' + urlFieldId).val(link);
        };

        function scrollToItem($el) {
            if ($el.length) {
                $('html, body').animate({
                    scrollTop: $el.offset().top - 60
                }, 300);
            }
        }

        function addItem(data) {
            data = data || {};
            var idx         = _item_idx++;
            var imgFieldId  = 'wdg_icg_img_' + idx;
            var imgDisplayId= 'wdg_icg_img_display_' + idx;
            var imgPreviewId= 'wdg_icg_img_preview_' + idx;
            var imgRemoveId = 'wdg_icg_img_remove_' + idx;
            var imgMediaId  = 'wdg_icg_img_media_' + idx;
            var urlFieldId  = 'wdg_icg_url_' + idx;
            var nodePopupId = 'wdg_icg_node_popup_' + idx;
            var filePopupId = 'wdg_icg_file_popup_' + idx;

            var $item = $('<div class="wdg-icg-item" data-idx="' + idx + '">');
            $item.append(
                '<div class="wdg-icg-item-header">' +
                '<div class="wdg-icg-move-buttons">' +
                '<button class="wdg-icg-move-btn move-up" type="button">▲</button>' +
                '<button class="wdg-icg-move-btn move-down" type="button">▼</button>' +
                '</div>' +
                '<span></span>' +
                '<button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
                '</div>'
            );
            var $body = $('<div class="wdg-icg-item-body">');

            // Image picker
            var $imgWrap = $('<div class="ody_builder_parameter">' +
                '<label><?php echo t("Εικόνα"); ?></label>' +
                '<input type="hidden" id="' + imgFieldId + '" class="wdg-icg-img" value="">' +
                '<p id="' + imgDisplayId + '" style="font-size:11px;color:#666;margin:2px 0;">...</p>' +
                '<img id="' + imgPreviewId + '" class="wdg-icg-image-preview" src="" alt="">' +
                '<br>' +
                '<a href="<?php echo "ody_builder_mediabank.php?blockType=widgetizer&langID=$langID"; ?>" id="' + imgMediaId + '" class="wdg-icg-select-media ody_builder_content_action btn btn-success" data-vbtype="iframe"><?php echo t("Επιλογή εικόνας"); ?></a> ' +
                '<a href="javascript:void(0)" id="' + imgRemoveId + '" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"><?php echo t("Αφαίρεση"); ?></a>' +
                '</div>');
            $imgWrap.find('#' + imgRemoveId).on('click', function () {
                $('#' + imgFieldId).val('');
                $('#' + imgDisplayId).text('...');
                $('#' + imgPreviewId).hide().attr('src', '');
                $(this).css('visibility', 'hidden');
            });
            $body.append($imgWrap);

            // Subtitle
            $body.append('<div class="ody_builder_parameter"><label><?php echo t("Υπότιτλος"); ?></label><input type="text" class="listbox wdg-icg-subtitle" value="' + $('<div>').text(data.subtitle || '').html() + '"></div>');
            // Title
            $body.append('<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?></label><input type="text" class="listbox wdg-icg-title" value="' + $('<div>').text(data.title || '').html() + '"></div>');
            // Description
            $body.append('<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label><textarea class="listbox wdg-icg-description" rows="2" style="resize:vertical;">' + $('<div>').text(data.description || '').html() + '</textarea></div>');
            // Button label
            $body.append('<div class="ody_builder_parameter"><label><?php echo t("Ετικέτα κουμπιού (κενό = χωρίς κουμπί)"); ?></label><input type="text" class="listbox wdg-icg-btn-label" value="' + $('<div>').text(data.btn_label || '').html() + '"></div>');
            // Button URL
            $body.append(
                '<div class="ody_builder_parameter"><label>Link</label>' +
                '<input type="text" class="listbox wdg-icg-btn-url" id="' + urlFieldId + '" value="' + $('<div>').text(data.btn_url || '').html() + '">' +
                '<select class="selectLink listbox" onchange="wdgIcgSetLink($(this).val(), \'' + urlFieldId + '\', ' + idx + '); $(this).val(\'\');">' + _page_opts + '</select>' +
                '</div>'
            );
            // New tab
            $body.append(
                '<div class="ody_builder_parameter"><div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">' +
                '<input type="checkbox" class="wdg-icg-btn-newtab" id="wdg_icg_newtab_' + idx + '" value="1">' +
                '<p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>' +
                '</div></div>'
            );

            $item.append($body);
            $('#wdg_icg_items_list').append($item);

            // Δυναμική ενημέρωση του Header κατά την πληκτρολόγηση του τίτλου της κάρτας
            $item.find('.wdg-icg-title').on('keyup', function () {
                var currentIdx = $('#wdg_icg_items_list .wdg-icg-item').index($item);
                var userTitle = $(this).val().trim();
                var headerText = '<?php echo t("Card"); ?> ' + (currentIdx + 1);
                if (userTitle) {
                    headerText += ': ' + userTitle;
                }
                $item.find('.wdg-icg-item-header span').text(headerText);
            });

            // Popups
            $('#wdg_icg_popups_container').append(
                '<a id="' + nodePopupId + '" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]' + urlFieldId + '">iFrame</a>' +
                '<a id="' + filePopupId + '" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]' + urlFieldId + '">iFrame</a>'
            );
            new VenoBox({selector: '#' + nodePopupId, fitView: true, ratio: 'full'});
            new VenoBox({selector: '#' + filePopupId, fitView: true, ratio: 'full'});
            window.venobox = new VenoBox({selector: '#' + imgMediaId, fitView: true, ratio: 'full'});
            $('#' + imgMediaId).on('click', function () { window._wdg_mediabank_caller = this; });

            // Φόρτωση αποθηκευμένης εικόνας
            if (data.image) {
                $('#' + imgFieldId).val(data.image);
                $('#' + imgDisplayId).text(data.image);
                $('#' + imgPreviewId).show().attr('src', data.image);
                $('#' + imgRemoveId).css('visibility', 'visible');
            }
            if (data.btn_new_tab == '1') {
                $('#wdg_icg_newtab_' + idx).prop('checked', true);
            }

            // Κουμπί Μετακίνησης Πάνω (▲) + Smooth Scroll Focus
            $item.find('.move-up').on('click', function (e) {
                e.preventDefault();
                var $prev = $item.prev('.wdg-icg-item');
                if ($prev.length > 0) {
                    $item.insertBefore($prev);
                    renumberItems();
                    scrollToItem($item);
                }
            });

            // Κουμπί Μετακίνησης Κάτω (▼) + Smooth Scroll Focus
            $item.find('.move-down').on('click', function (e) {
                e.preventDefault();
                var $next = $item.next('.wdg-icg-item');
                if ($next.length > 0) {
                    $item.insertAfter($next);
                    renumberItems();
                    scrollToItem($item);
                }
            });

            $item.find('.wdg-item-remove').on('click', function () {
                $item.fadeOut(200, function () { $item.remove(); renumberItems(); });
            });

            // Αρχικό renumbering για να πάρει σωστά τον τίτλο στο load
            renumberItems();
        }

        function renumberItems() {
            $('#wdg_icg_items_list .wdg-icg-item').each(function (idx) {
                var userTitle = $(this).find('.wdg-icg-title').val().trim();
                var headerText = '<?php echo t("Card"); ?> ' + (idx + 1);
                if (userTitle) {
                    headerText += ': ' + userTitle;
                }
                $(this).find('.wdg-icg-item-header span').text(headerText);
            });
        }

        _items.forEach(function (item) { addItem(item); });
        
        $('#wdg_icg_add_btn').on('click', function () { 
            addItem({}); 
            scrollToItem($('#wdg_icg_items_list .wdg-icg-item').last());
        });

        label = 'Widget Card Grid';
        $('#ody_builder_admin_label').val(label);
        $('.ody_builder_header h2').html('Widgetizer — Card Grid');

        window.get_block_data = function () {
            var items = [];
            $('#wdg_icg_items_list .wdg-icg-item').each(function () {
                var $it = $(this);
                items.push({
                    image:       $it.find('.wdg-icg-img').val(),
                    subtitle:    $it.find('.wdg-icg-subtitle').val(),
                    title:       $it.find('.wdg-icg-title').val(),
                    description: $it.find('.wdg-icg-description').val(),
                    btn_label:   $it.find('.wdg-icg-btn-label').val(),
                    btn_url:     $it.find('.wdg-icg-btn-url').val(),
                    btn_new_tab: $it.find('.wdg-icg-btn-newtab').is(':checked') ? '1' : '0'
                });
            });
            return {
                widget_id: 'card_grid',
                params: {
                    eyebrow:         $('#wdg_icg_eyebrow').val(),
                    title:           $('#wdg_icg_title').val(),
                    description:     $('#wdg_icg_description').val(),
                    color_scheme:    $('#wdg_icg_color_scheme').val(),
                    container_width: $('#wdg_icg_container_width').val(),
                    columns:         $('#wdg_icg_columns').val(),
                    card_layout:     $('#wdg_icg_card_layout').val(),
                    btn_style:       $('#wdg_icg_btn_style').val(),
                    items:           items
                }
            };
        };
    });
</script>