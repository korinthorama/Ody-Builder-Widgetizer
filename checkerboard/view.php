<?php
/*
 * Widgetizer — Checkerboard Widget — view.php
 */
?>
<style>
    .ody_builder_parameter {
        max-width: 500px !important;
    }

    #wdg_checkerboard_items {
        width: 100%;
        max-width: 500px !important;
        margin-bottom: 8px;
    }

    .wdg-cb-item {
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 12px;
        background: #f9f9f9;
    }

    .wdg-cb-item-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
        cursor: move;
    }

    .wdg-cb-item-header span {
        color: white;
        font-size: 12px;
        flex: 1;
    }

    .wdg-cb-item-body {
        padding: 12px;
    }

    .wdg-cb-item-body .ody_builder_parameter {
        max-width: 100% !important;
        margin-bottom: 8px;
    }

    .wdg-cb-item-body textarea {
        min-height: 60px;
        resize: vertical;
    }

    #wdg_cb_add_btn {
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

    #wdg_cb_add_btn:hover { background: #004a5c; }

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

    .wdg-type-select {
        margin-bottom: 12px;
    }

    .wdg-type-select select {
        width: auto !important;
        min-width: 150px;
    }

    .wdg-content-fields, .wdg-image-fields {
        transition: all 0.2s ease;
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
</style>

<!-- ΓΕΝΙΚΑ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_chkb_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_chkb_eyebrow" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_chkb_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_chkb_title" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_chkb_description"><?php echo t("Περιγραφή"); ?></label>
    <textarea id="wdg_chkb_description" class="listbox" rows="3" style="resize:vertical;"></textarea>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_chkb_columns"><?php echo t("Αριθμός Στηλών"); ?></label>
    <select id="wdg_chkb_columns" class="listbox">
        <option value="2">2 στήλες</option>
        <option value="3">3 στήλες</option>
        <option value="4" selected>4 στήλες</option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_chkb_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_chkb_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_chkb_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_chkb_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>

<!-- ITEMS -->
<div class="wdg-section-title">Checkerboard Items</div>

<div id="wdg_checkerboard_items"></div>
<button id="wdg_cb_add_btn" type="button">+ <?php echo t("Προσθήκη"); ?> Item</button>




<script>
jQuery(function ($) {
    var _p = _saved_params || {};
    var _items = _p['items'] || [];

    // ── Pages για link picker ────────────────────────────────────────────────
    var pagesData = <?php
        $q = "select pages.id as id, content_pages.title as title
              from pages, content_pages
              where content_pages.mainID=pages.id
              and content_pages.langID=" . $langID . "
              order by pages.sort, content_pages.title";
        $pagesList = [];
        foreach($db->getRecords($q) as $row) {
            $pagesList[] = ['id' => $row->id, 'title' => $row->title];
        }
        echo json_encode($pagesList);
    ?>;

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    // Φόρτωση γενικών τιμών
    $('#wdg_chkb_eyebrow').val(pval('eyebrow'));
    $('#wdg_chkb_title').val(pval('title'));
    $('#wdg_chkb_description').val(pval('description'));
    $('#wdg_chkb_columns').val(pval('columns', '4'));
    $('#wdg_chkb_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_chkb_container_width').val(pval('container_width', 'full'));

    // VenoBox
    window.venobox = new VenoBox({selector: '.wdg-cb-select-media', fitView: true, ratio: 'full'});
    $(document).on('click', '.wdg-cb-select-media', function () {
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

    // ── Link picker helper ───────────────────────────────────────────────────
    window.wdgChkbSetLink = function (val, targetId, idx) {
        if (!val || val === 'divider') return;

        if (val === 'nodeLinks_chkb') {
            document.getElementById('wdg_chkb_node_popup_' + idx).click();
            return;
        }
        if (val === 'fileLinks_chkb') {
            document.getElementById('wdg_chkb_file_popup_' + idx).click();
            return;
        }

        var link = (val === 'homepage')
            ? 'index.php'
            : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
        $('#' + targetId).val(link);
    };

    var _item_idx = 0;

    function addItem(data) {
        var idx = _item_idx++;
        var type = data.type || 'content';
        var typeLabel = (type === 'content') ? '📝 Κείμενο' : '🖼️ Εικόνα';
        
        var imgId = 'wdg_chkb_img_' + idx;
        var mediaId = 'wdg_chkb_media_btn_' + idx;
        var urlId = 'wdg_chkb_url_' + idx;

        var $item = $('<div class="wdg-cb-item" data-idx="' + idx + '">');

        // Header
        $item.append(
            '<div class="wdg-cb-item-header">' +
            '<span>' + typeLabel + '</span>' +
            '<button class="wdg-item-remove" type="button" title="<?php echo t("Αφαίρεση"); ?>">✕</button>' +
            '</div>'
        );

        var $body = $('<div class="wdg-cb-item-body">');

        // Type selector
        $body.append(
            '<div class="ody_builder_parameter wdg-type-select">' +
            '<label><?php echo t("Τύπος"); ?></label>' +
            '<select class="listbox wdg-cb-type">' +
            '<option value="content" ' + (type === 'content' ? 'selected' : '') + '>📝 Κείμενο (Title, Description, Button)</option>' +
            '<option value="image" ' + (type === 'image' ? 'selected' : '') + '>🖼️ Εικόνα μόνο</option>' +
            '</select>' +
            '</div>'
        );

        // Content fields
        var $contentFields = $('<div class="wdg-content-fields" style="' + (type !== 'content' ? 'display:none' : '') + '">');
        
        // Title
        $contentFields.append(
            '<div class="ody_builder_parameter">' +
            '<label><?php echo t("Τίτλος"); ?></label>' +
            '<input type="text" class="listbox wdg-cb-title" value="' + $('<div>').text(data.title || '').html() + '">' +
            '</div>'
        );
        
        // Description
        $contentFields.append(
            '<div class="ody_builder_parameter">' +
            '<label><?php echo t("Περιγραφή"); ?></label>' +
            '<textarea class="listbox wdg-cb-description" rows="3">' + $('<div>').text(data.description || '').html() + '</textarea>' +
            '</div>'
        );
        
        // Button label
        $contentFields.append(
            '<div class="ody_builder_parameter">' +
            '<label><?php echo t("Κείμενο κουμπιού"); ?></label>' +
            '<input type="text" class="listbox wdg-cb-button-label" value="' + $('<div>').text(data.button_label || '').html() + '">' +
            '</div>'
        );
        
        // Button URL με link picker
        $contentFields.append(
            '<div class="ody_builder_parameter">' +
            '<label>Link</label>' +
            '<input type="text" id="' + urlId + '" class="listbox wdg-cb-button-url" value="' + $('<div>').text(data.button_url || '').html() + '">' +
            '<select class="selectLink listbox" onchange="wdgChkbSetLink($(this).val(), \'' + urlId + '\', ' + idx + '); $(this).val(\'\');">' +
            '<option value=""><?php echo t("ή επιλέξτε υπάρχουσα σελίδα"); ?></option>' +
            '<option value="homepage"><?php echo t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ"); ?></option>'
        );
        
        // Add pages from database
        for (var i = 0; i < pagesData.length; i++) {
            $contentFields.find('select').append('<option value="' + pagesData[i].id + '">' + pagesData[i].title + '</option>');
        }
        
        $contentFields.find('select').append(
            '<option value="divider">--------------------------------------</option>' +
            '<option value="nodeLinks_chkb"><?php echo t("Link για εγγραφή ενότητας") . " >>"; ?></option>' +
            '<option value="divider">--------------------------------------</option>' +
            '<option value="fileLinks_chkb"><?php echo t("Link για αρχείο") . " >>"; ?></option>' +
            '</select>' +
            '</div>'
        );

        var isChecked = (data.open_new == '1' || data.open_new === '_blank');
        $contentFields.append(
            '<div class="ody_builder_parameter">' +
            '<div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">' +
            '<input type="checkbox" class="wdg-cb-open-new" value="1" ' + (isChecked ? 'checked' : '') + '>' +
            '<p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>' +
            '</div>' +
            '</div>'
        );
        
        $body.append($contentFields);

        // Image fields (χωρίς ALT)
        var $imageFields = $('<div class="wdg-image-fields" style="' + (type !== 'image' ? 'display:none' : '') + '">');
        $imageFields.append(
            '<div class="ody_builder_parameter">' +
            '<label><?php echo t("Εικόνα"); ?></label>' +
            '<div class="wdg-img-row">' +
            '<span id="' + imgId + '_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>' +
            '<a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"' +
            ' id="' + mediaId + '"' +
            ' class="wdg-cb-select-media ody_builder_content_action btn btn-success"' +
            ' data-vbtype="iframe" data-wdg-target="' + imgId + '"><?php echo t("Επιλογή"); ?></a>' +
            '<a href="javascript:void(0)" id="' + imgId + '_remove" class="ody_builder_content_action btn btn-danger" style="visibility:' + (data.image ? 'visible' : 'hidden') + ';"' +
            ' onclick="$(\'#' + imgId + '\').val(\'\'); $(\'#' + imgId + '_display\').text(\'<?php echo t("Επιλέξτε..."); ?>\'); $(\'#' + imgId + '_preview\').hide().attr(\'src\',\'\'); $(\'#' + imgId + '_remove\').css(\'visibility\',\'hidden\');"><?php echo t("Αφαίρεση"); ?></a>' +
            '</div>' +
            '<input type="hidden" id="' + imgId + '" class="wdg-cb-image" value="' + $('<div>').text(data.image || '').html() + '">' +
            '<img id="' + imgId + '_preview" class="wdg-img-preview" src="' + $('<div>').text(data.image || '').html() + '" style="' + (data.image ? 'display:block' : 'display:none') + '">' +
            '</div>'
        );
        $body.append($imageFields);

        $item.append($body);
        $('#wdg_checkerboard_items').append($item);

        // Φόρτωση εικόνας αν υπάρχει
        if (data.image) {
            $('#' + imgId + '_display').text(data.image.split('/').pop());
        }

        // Type change handler
        $item.find('.wdg-cb-type').on('change', function() {
            var newType = $(this).val();
            if (newType === 'content') {
                $item.find('.wdg-content-fields').show();
                $item.find('.wdg-image-fields').hide();
                $item.find('.wdg-cb-item-header span').text('📝 Κείμενο');
            } else {
                $item.find('.wdg-content-fields').hide();
                $item.find('.wdg-image-fields').show();
                $item.find('.wdg-cb-item-header span').text('🖼️ Εικόνα');
            }
        });

        // Remove button
        $item.find('.wdg-item-remove').on('click', function () {
            $item.fadeOut(200, function () { $item.remove(); });
        });

        // Re-init VenoBox for new media button
        new VenoBox({selector: '#' + mediaId, fitView: true, ratio: 'full'});
        $('#' + mediaId).on('click', function () {
            window._wdg_mediabank_caller = this;
        });

        // Hidden link picker popups — per item (μετά το DOM insertion)
        $('#wdg_checkerboard_items').append(
            '<a id="wdg_chkb_node_popup_' + idx + '" class="builder_popup" data-vbtype="iframe"' +
            ' href="section_links.php?venobox=[id]' + urlId + '" style="display:none;">iFrame</a>'
        );
        $('#wdg_checkerboard_items').append(
            '<a id="wdg_chkb_file_popup_' + idx + '" class="builder_popup" data-vbtype="iframe"' +
            ' href="file_links.php?venobox=[id]' + urlId + '" style="display:none;">iFrame</a>'
        );
        new VenoBox({selector: '#wdg_chkb_node_popup_' + idx, fitView: true, ratio: 'full'});
        new VenoBox({selector: '#wdg_chkb_file_popup_' + idx, fitView: true, ratio: 'full'});
    }

    // Load saved items
    $.each(_items, function (i, item) {
        addItem(item);
    });

    // Add new item
    $('#wdg_cb_add_btn').on('click', function () {
        addItem({});
    });

    // Sortable
    if ($.fn.sortable) {
        $('#wdg_checkerboard_items').sortable({
            handle: '.wdg-cb-item-header',
            placeholder: 'block-placeholder',
            tolerance: 'pointer'
        });
    }

    // Label
    label = 'Widget Checkerboard';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Checkerboard');

    // get_block_data
    window.get_block_data = function () {
        var items = [];
        $('#wdg_checkerboard_items .wdg-cb-item').each(function () {
            var $it = $(this);
            var type = $it.find('.wdg-cb-type').val();
            if (type === 'content') {
                items.push({
                    type: 'content',
                    title: $it.find('.wdg-cb-title').val(),
                    description: $it.find('.wdg-cb-description').val(),
                    button_label: $it.find('.wdg-cb-button-label').val(),
                    button_url: $it.find('.wdg-cb-button-url').val(),
                    open_new: $it.find('.wdg-cb-open-new').is(':checked') ? '_blank' : '_self'
                });
            } else {
                items.push({
                    type: 'image',
                    image: $it.find('.wdg-cb-image').val()
                });
            }
        });
        return {
            widget_id: 'checkerboard',
            params: {
                eyebrow: $('#wdg_chkb_eyebrow').val(),
                title: $('#wdg_chkb_title').val(),
                description: $('#wdg_chkb_description').val(),
                columns: $('#wdg_chkb_columns').val(),
                color_scheme: $('#wdg_chkb_color_scheme').val(),
                container_width: $('#wdg_chkb_container_width').val(),
                items: items
            }
        };
    };
});
</script>