<?php
/*
 * Widgetizer — Checkerboard Widget — view.php
 * Refactored: Arrows instead of drag & drop, title display
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
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }

    .wdg-cb-item-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
    }

    .wdg-cb-item-header .wdg-cb-title-display {
        color: white;
        font-size: 11px;
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .wdg-cb-move-buttons {
        display: flex;
        gap: 4px;
        margin-right: 4px;
    }

    .wdg-cb-move-btn {
        background: transparent;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 12px;
        padding: 2px 4px;
        border-radius: 3px;
        transition: all 0.2s;
    }

    .wdg-cb-move-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .wdg-cb-move-btn:active {
        transform: scale(0.9);
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

    .block-placeholder {
        background: #e0f0f0;
        border: 2px dashed #002e3a;
        height: 60px;
        margin-bottom: 12px;
        border-radius: 4px;
    }
</style>

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

<div class="wdg-section-title">Checkerboard Items</div>

<div id="wdg_checkerboard_items"></div>
<button id="wdg_cb_add_btn" type="button">+ <?php echo t("Προσθήκη"); ?> Item</button>

<div id="wdg_cb_popups_container" style="display:none;"></div>

<script>
jQuery(function ($) {
    // Απομόνωση μεταφράσεων σε καθαρές JS μεταβλητές για αποφυγή SyntaxError
    var transMoveUp     = <?php echo json_encode(t("Μετακίνηση πάνω")); ?>;
    var transMoveDown   = <?php echo json_encode(t("Μετακίνηση κάτω")); ?>;
    var transRemove     = <?php echo json_encode(t("Αφαίρεση")); ?>;
    var transSelectImg  = <?php echo json_encode(t("Επιλέξτε...")); ?>;
    var transSelectBtn  = <?php echo json_encode(t("Επιλογή")); ?>;
    var transOrSelect   = <?php echo json_encode(t("ή επιλέξτε υπάρχουσα σελίδα")); ?>;
    var transHome       = <?php echo json_encode(t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ")); ?>;
    var transSectionLink= <?php echo json_encode(t("Link για εγγραφή ενότητας")); ?>;
    var transFileLink   = <?php echo json_encode(t("Link για αρχείο")); ?>;
    var transTypeLabel  = <?php echo json_encode(t("Τύπος")); ?>;
    var transTitleLabel = <?php echo json_encode(t("Τίτλος")); ?>;
    var transDescLabel  = <?php echo json_encode(t("Περιγραφή")); ?>;
    var transBtnLabel   = <?php echo json_encode(t("Κείμενο κουμπιού")); ?>;
    var transNewTab     = <?php echo json_encode(t("Άνοιγμα σε νέο tab")); ?>;
    var transImgLabel   = <?php echo json_encode(t("Εικόνα")); ?>;

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

    // Helper function for escaping textarea content
    function escapeForTextarea(str) {
        if (!str) return '';
        return str.replace(/&/g, '&amp;')
                  .replace(/</g, '&lt;')
                  .replace(/>/g, '&gt;');
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

    // ── Update title display ─────────────────────────────────────────────────
    function updateTitleDisplay($item, uid) {
        var titleValue = $('#wdg_cb_title_' + uid).val();
        var itemNumber = $('#wdg_checkerboard_items .wdg-cb-item').index($item) + 1;
        var displayText = 'Item ' + itemNumber;
        
        if (titleValue && titleValue.trim() !== '') {
            displayText += ': ' + titleValue;
        }
        
        $item.find('.wdg-cb-title-display').text(displayText);
    }

    // ── Move functions with smooth slide animation, scroll and highlight ──────
    function moveItemUp($item) {
        var $prev = $item.prev('.wdg-cb-item');
        var speed = 120;
        if ($prev.length) {
            $item.slideUp(speed, function() {
                $item.insertBefore($prev);
                $item.slideDown(speed, function() {
                    renumberItems();
                    // Scroll to moved item
                    $('html, body').animate({
                        scrollTop: $item.offset().top - 100
                    }, 300);
                    // Highlight effect
                    $item.css('box-shadow', '0 0 0 2px #fbbf24');
                    setTimeout(function() {
                        $item.css('box-shadow', '');
                    }, 300);
                });
            });
        }
    }

    function moveItemDown($item) {
        var $next = $item.next('.wdg-cb-item');
        var speed = 120;
        if ($next.length) {
            $item.slideUp(speed, function() {
                $item.insertAfter($next);
                $item.slideDown(speed, function() {
                    renumberItems();
                    // Scroll to moved item
                    $('html, body').animate({
                        scrollTop: $item.offset().top - 100
                    }, 300);
                    // Highlight effect
                    $item.css('box-shadow', '0 0 0 2px #fbbf24');
                    setTimeout(function() {
                        $item.css('box-shadow', '');
                    }, 300);
                });
            });
        }
    }

    function renumberItems() {
        $('#wdg_checkerboard_items .wdg-cb-item').each(function() {
            var $item = $(this);
            var idx = $item.data('idx');
            var uid = 'cb_' + idx;
            updateTitleDisplay($item, uid);
        });
    }

    var _item_idx = 0;

    function addItem(data) {
        var idx = _item_idx++;
        var uid = 'cb_' + idx;
        var type = data.type || 'content';
        
        var imgId = 'wdg_cb_img_' + uid;
        var mediaId = 'wdg_cb_media_btn_' + uid;
        var urlId = 'wdg_cb_url_' + uid;
        var nodePop = 'wdg_cb_node_popup_' + idx;
        var filePop = 'wdg_cb_file_popup_' + idx;

        var $item = $('<div class="wdg-cb-item" data-idx="' + idx + '">');

        // Header with move buttons and title display using JS variables
        $item.append(
            '<div class="wdg-cb-item-header">' +
            '<div class="wdg-cb-move-buttons">' +
            '<button type="button" class="wdg-cb-move-btn wdg-cb-move-up" title="' + transMoveUp + '">▲</button>' +
            '<button type="button" class="wdg-cb-move-btn wdg-cb-move-down" title="' + transMoveDown + '">▼</button>' +
            '</div>' +
            '<span class="wdg-cb-title-display">Item ' + ($('#wdg_checkerboard_items .wdg-cb-item').length + 1) + '</span>' +
            '<button class="wdg-item-remove" type="button" title="' + transRemove + '">✕</button>' +
            '</div>'
        );

        var $body = $('<div class="wdg-cb-item-body">');

        // Type selector
        $body.append(
            '<div class="ody_builder_parameter wdg-type-select">' +
            '<label>' + transTypeLabel + '</label>' +
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
            '<label>' + transTitleLabel + '</label>' +
            '<input type="text" id="wdg_cb_title_' + uid + '" class="listbox wdg-cb-title" value="' + escapeForTextarea(data.title || '') + '">' +
            '</div>'
        );
        
        // Description
        $contentFields.append(
            '<div class="ody_builder_parameter">' +
            '<label>' + transDescLabel + '</label>' +
            '<textarea id="wdg_cb_description_' + uid + '" class="listbox wdg-cb-description" rows="3">' + escapeForTextarea(data.description || '') + '</textarea>' +
            '</div>'
        );
        
        // Button label
        $contentFields.append(
            '<div class="ody_builder_parameter">' +
            '<label>' + transBtnLabel + '</label>' +
            '<input type="text" id="wdg_cb_btnlabel_' + uid + '" class="listbox wdg-cb-button-label" value="' + escapeForTextarea(data.button_label || '') + '">' +
            '</div>'
        );
        
        // Button URL με link picker
        $contentFields.append(
            '<div class="ody_builder_parameter">' +
            '<label>Link</label>' +
            '<input type="text" id="' + urlId + '" class="listbox wdg-cb-button-url" value="' + escapeForTextarea(data.button_url || '') + '">' +
            '<select class="selectLink listbox" onchange="wdgChkbSetLink($(this).val(), \'' + urlId + '\', ' + idx + '); $(this).val(\'\');">' +
            '<option value="">' + transOrSelect + '</option>' +
            '<option value="homepage">' + transHome + '</option>'
        );
        
        // Add pages from database
        var $select = $contentFields.find('select').last();
        for (var i = 0; i < pagesData.length; i++) {
            $select.append('<option value="' + pagesData[i].id + '">' + pagesData[i].title + '</option>');
        }
        
        $select.append(
            '<option value="divider">--------------------------------------</option>' +
            '<option value="nodeLinks_chkb">' + transSectionLink + ' >></option>' +
            '<option value="divider">--------------------------------------</option>' +
            '<option value="fileLinks_chkb">' + transFileLink + ' >></option>' +
            '</select>' +
            '</div>'
        );

        var isChecked = (data.open_new == '1' || data.open_new === '_blank');
        $contentFields.append(
            '<div class="ody_builder_parameter">' +
            '<div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">' +
            '<input type="checkbox" id="wdg_cb_btntab_' + uid + '" class="wdg-cb-open-new" value="1" ' + (isChecked ? 'checked' : '') + '>' +
            '<p>' + transNewTab + '</p>' +
            '</div>' +
            '</div>'
        );
        
        $body.append($contentFields);

        // Image fields
        var $imageFields = $('<div class="wdg-image-fields" style="' + (type !== 'image' ? 'display:none' : '') + '">');
        $imageFields.append(
            '<div class="ody_builder_parameter">' +
            '<label>' + transImgLabel + '</label>' +
            '<div class="wdg-img-row">' +
            '<span id="' + imgId + '_display" class="wdg-img-filename">' + transSelectImg + '</span>' +
            '<a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"' +
            ' id="' + mediaId + '"' +
            ' class="wdg-cb-select-media ody_builder_content_action btn btn-success"' +
            ' data-vbtype="iframe" data-wdg-target="' + imgId + '">' + transSelectBtn + '</a>' +
            '<a href="javascript:void(0)" id="' + imgId + '_remove" class="ody_builder_content_action btn btn-danger" style="visibility:' + (data.image ? 'visible' : 'hidden') + ';">' + transRemove + '</a>' +
            '</div>' +
            '<input type="hidden" id="' + imgId + '" class="wdg-cb-image" value="' + escapeForTextarea(data.image || '') + '">' +
            '<img id="' + imgId + '_preview" class="wdg-img-preview" src="' + escapeForTextarea(data.image || '') + '" style="' + (data.image ? 'display:block' : 'display:none') + '">' +
            '</div>'
        );
        $body.append($imageFields);

        $item.append($body);
        $('#wdg_checkerboard_items').append($item);

        // Φόρτωση εικόνας αν υπάρχει
        if (data.image) {
            $('#' + imgId + '_display').text(data.image.split('/').pop());
        }

        // ── Title input handler for display update ───────────────────────────
        $('#wdg_cb_title_' + uid).on('input', function() {
            updateTitleDisplay($item, uid);
        });

        // ── Remove image handler ──────────────────────────────────────────────
        $('#' + imgId + '_remove').on('click', function() {
            $('#' + imgId).val('');
            $('#' + imgId + '_display').text(transSelectImg);
            $('#' + imgId + '_preview').hide().attr('src', '');
            $(this).css('visibility', 'hidden');
        });

        // ── Type change handler ───────────────────────────────────────────────
        $item.find('.wdg-cb-type').on('change', function() {
            var newType = $(this).val();
            if (newType === 'content') {
                $item.find('.wdg-content-fields').show();
                $item.find('.wdg-image-fields').hide();
            } else {
                $item.find('.wdg-content-fields').hide();
                $item.find('.wdg-image-fields').show();
            }
        });

        // ── Move buttons events ───────────────────────────────────────────────
        $item.find('.wdg-cb-move-up').on('click', function(e) {
            e.stopPropagation();
            moveItemUp($item);
        });
        
        $item.find('.wdg-cb-move-down').on('click', function(e) {
            e.stopPropagation();
            moveItemDown($item);
        });

        // ── Remove button ─────────────────────────────────────────────────────
        $item.find('.wdg-item-remove').on('click', function () {
            $item.fadeOut(200, function() { 
                $item.remove();
                renumberItems();
            });
        });

        // ── VenoBox for media button ──────────────────────────────────────────
        new VenoBox({selector: '#' + mediaId, fitView: true, ratio: 'full'});
        $('#' + mediaId).on('click', function () {
            window._wdg_mediabank_caller = this;
        });

        // ── Hidden link picker popups ─────────────────────────────────────────
        $('#wdg_cb_popups_container').append(
            '<a id="' + nodePop + '" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]' + urlId + '" style="display:none;">iFrame</a>'
        );
        $('#wdg_cb_popups_container').append(
            '<a id="' + filePop + '" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]' + urlId + '" style="display:none;">iFrame</a>'
        );
        new VenoBox({selector: '#' + nodePop, fitView: true, ratio: 'full'});
        new VenoBox({selector: '#' + filePop, fitView: true, ratio: 'full'});

        // Initial title display update
        updateTitleDisplay($item, uid);
    }

    // Load saved items
    $.each(_items, function (i, item) {
        addItem(item);
    });

    // Renumbering immediately after all initial items are rendered to fix potential index strings
    renumberItems();

    // Add new item
    $('#wdg_cb_add_btn').on('click', function () {
        addItem({});
        var $lastItem = $('#wdg_checkerboard_items .wdg-cb-item').last();
        if ($lastItem.length) {
            $('html, body').animate({
                scrollTop: $lastItem.offset().top - 100
            }, 300);
        }
    });

    // Label
    var label = 'Widget Checkerboard';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Checkerboard');

    // get_block_data
    window.get_block_data = function () {
        var items = [];
        $('#wdg_checkerboard_items .wdg-cb-item').each(function () {
            var $it = $(this);
            var idx = $it.data('idx');
            var uid = 'cb_' + idx;
            var type = $it.find('.wdg-cb-type').val();
            
            if (type === 'content') {
                items.push({
                    type: 'content',
                    title: $('#wdg_cb_title_' + uid).val(),
                    description: $('#wdg_cb_description_' + uid).val(),
                    button_label: $('#wdg_cb_btnlabel_' + uid).val(),
                    button_url: $('#wdg_cb_url_' + uid).val(),
                    open_new: $('#wdg_cb_btntab_' + uid).is(':checked') ? '_blank' : '_self'
                });
            } else {
                items.push({
                    type: 'image',
                    image: $('#wdg_cb_img_' + uid).val()
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