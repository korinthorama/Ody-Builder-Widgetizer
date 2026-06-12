<?php
/*
 * Widgetizer — Bento Grid Widget — view.php (custom admin UI)
 * Fully sanitized to absolutely prevent any '<' or inline tags inside JavaScript.
 * Added smooth scrolling focus on item re-ordering.
 */
?>
<style>
    .ody_builder_parameter {
        max-width: 500px !important;
    }
    #wdg_bento_items_list .selectLink {
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
    /* ── Repeater ── */
    #wdg_bento_items_list {
        width: 100%;
        max-width: 100%;
        margin-bottom: 8px;
    }
    .wdg-bento-item {
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 8px;
        background: #f9f9f9;
        overflow: hidden;
    }
    .wdg-bento-item-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
    }
    .wdg-bento-item-header .wdg-bento-title-display {
        color: white;
        font-size: 12px;
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .wdg-bento-move-buttons {
        display: flex;
        gap: 2px;
        margin-right: 4px;
    }
    .wdg-bento-move-btn, .wdg-bento-remove-btn {
        background: #004a5c;
        border: none;
        color: white;
        border-radius: 3px;
        cursor: pointer;
        font-size: 10px;
        padding: 2px 6px;
        line-height: 1.2;
    }
    .wdg-bento-move-btn:hover { background: #006982; }
    
    .wdg-bento-remove-btn {
        background: #c0392b;
    }
    .wdg-bento-remove-btn:hover { background: #e74c3c; }

    .wdg-bento-item-body {
        padding: 8px;
    }
    .wdg-bento-item-body .ody_builder_parameter {
        max-width: 100% !important;
        margin-bottom: 6px;
    }
    #wdg_bento_add_btn {
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
    #wdg_bento_add_btn:hover { background: #004a5c; }
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
        border: 1px solid #ddd;
    }
</style>

<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_bg_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_bg_eyebrow" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_bg_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_bg_title" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_bg_description"><?php echo t("Περιγραφή"); ?></label>
    <textarea id="wdg_bg_description" class="listbox" rows="3" style="resize:vertical;"></textarea>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_bg_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_bg_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_bg_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_bg_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>

<div class="wdg-section-title">Bento Items</div>

<div id="wdg_bento_items_list" style="max-width:500px"></div>
<button id="wdg_bento_add_btn" type="button">+ <?php echo t("Προσθήκη"); ?> Item</button>

<div id="wdg_bento_popups_container" style="display:none;"></div>

<div id="wdg_bento_item_template" style="display:none;">
    <div class="wdg-bento-item">
        <div class="wdg-bento-item-header">
            <div class="wdg-bento-move-buttons">
                <button class="wdg-bento-move-btn move-up" type="button">▲</button>
                <button class="wdg-bento-move-btn move-down" type="button">▼</button>
            </div>
            <div class="wdg-bento-title-display">Item</div>
            <button class="wdg-bento-remove-btn remove-item" type="button">✕</button>
        </div>
        <div class="wdg-bento-item-body">
            
            <div class="ody_builder_parameter">
                <label><?php echo t("Τίτλος"); ?></label>
                <input type="text" class="listbox wdg-bento-title" value="">
            </div>

            <div class="ody_builder_parameter">
                <label><?php echo t("Περιγραφή"); ?></label>
                <textarea class="listbox wdg-bento-text" rows="3"></textarea>
            </div>

            <div class="ody_builder_parameter">
                <label><?php echo t("Εικόνα Φόντου"); ?></label>
                <div class="wdg-img-row">
                    <span class="wdg-img-filename display-filename"><?php echo t("Επιλέξτε..."); ?></span>
                    <a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"
                       class="wdg-bento-select-media ody_builder_content_action btn btn-success media-btn" 
                       data-vbtype="iframe"><?php echo t("Επιλογή"); ?></a>
                    <a href="javascript:void(0)" class="ody_builder_content_action btn btn-danger remove-media-btn" style="display:none;"><?php echo t("Αφαίρεση"); ?></a>
                </div>
                <input type="hidden" class="wdg-bento-bg-image hidden-image-val" value="">
                <img class="wdg-img-preview image-preview" src="" style="display:none;">
            </div>

            <div class="ody_builder_parameter">
                <label><?php echo t("Χρώμα μάσκας"); ?></label>
                <input type="text" class="wdg-bento-overlay-color color-picker-input" data-preferred-format="hex" value="#000000">
            </div>

            <div class="ody_builder_parameter">
                <label><?php echo t("Διαφάνεια μάσκας"); ?> <small style="color:#999;font-weight:normal;">(0–1)</small></label>
                <input type="number" class="listbox wdg-bento-overlay-opacity" value="0.4" min="0" max="1" step="0.1" style="max-width:100px;">
            </div>

            <div class="ody_builder_parameter">
                <label>Col Span (1-4)</label>
                <input type="number" class="listbox wdg-bento-col-span" value="1" min="1" max="4" style="max-width:80px;">
            </div>

            <div class="ody_builder_parameter">
                <label>Row Span (1-3)</label>
                <input type="number" class="listbox wdg-bento-row-span" value="1" min="1" max="3" style="max-width:80px;">
            </div>

            <div class="ody_builder_parameter">
                <label><?php echo t("Στοίχιση"); ?></label>
                <select class="listbox wdg-bento-align">
                    <option value="align-start"><?php echo t("Αριστερά"); ?></option>
                    <option value="align-center"><?php echo t("Κέντρο"); ?></option>
                </select>
            </div>

            <div class="ody_builder_parameter">
                <label><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
                <select class="listbox wdg-bento-color-scheme">
                    <option value="color-scheme-standard-primary">Standard Primary</option>
                    <option value="color-scheme-standard-secondary">Standard Secondary</option>
                    <option value="color-scheme-highlight-primary">Highlight Primary</option>
                    <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
                </select>
            </div>

            <div class="ody_builder_parameter">
                <label>Link URL</label>
                <input type="text" class="listbox wdg-bento-link-url" value="">
                <select class="selectLink listbox link-picker-select">
                    </select>
            </div>

            <div class="ody_builder_parameter">
                <div class="admin_checkbox_wrapper">
                    <input type="checkbox" class="wdg-bento-link-newtab" value="1">
                    <p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
jQuery(function ($) {
    var _p = _saved_params || {};
    var _items = _p['items'] || [];

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    $('#wdg_bg_eyebrow').val(pval('eyebrow'));
    $('#wdg_bg_title').val(pval('title'));
    $('#wdg_bg_description').val(pval('description'));
    $('#wdg_bg_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_bg_container_width').val(pval('container_width', 'full'));

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

    var selectHtml = '<option value="">ή επιλέξτε υπάρχουσα σελίδα</option>';
    selectHtml += '<option value="homepage">ΑΡΧΙΚΗ ΣΕΛΙΔΑ</option>';
    for (var i = 0; i < pagesData.length; i++) {
        selectHtml += '<option value="' + pagesData[i].id + '">' + pagesData[i].title + '</option>';
    }
    selectHtml += '<option value="divider">--------------------------------------</option>';
    selectHtml += '<option value="nodeLinks_bento">Link για εγγραφή ενότητας</option>';
    selectHtml += '<option value="divider">--------------------------------------</option>';
    selectHtml += '<option value="fileLinks_bento">Link για αρχείο</option>';

    var _palette = [
        ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
        ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
        ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
        ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
        ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
        ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
    ];

    window.venobox = new VenoBox({selector: '.wdg-bento-select-media', fitView: true, ratio: 'full'});
    $(document).on('click', '.wdg-bento-select-media', function () {
        window._wdg_mediabank_caller = this;
    });

    window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
        var $itemBody = $(callerEl).closest('.wdg-bento-item-body');
        var fullPath = image_path + id + '.' + ext;
        
        $itemBody.find('.hidden-image-val').val(fullPath);
        $itemBody.find('.display-filename').text(file);
        $itemBody.find('.image-preview').attr('src', fullPath).show();
        $itemBody.find('.remove-media-btn').show();
    };

    window.wdgBentoSetLink = function (val, $urlInput, uid) {
        if (!val || val === 'divider') return;

        if (val === 'nodeLinks_bento') {
            document.getElementById('wdg_bento_node_popup_' + uid).click();
            return;
        }
        if (val === 'fileLinks_bento') {
            document.getElementById('wdg_bento_file_popup_' + uid).click();
            return;
        }

        var link = (val === 'homepage')
            ? 'index.php'
            : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
        $urlInput.val(link);
    };

    // Helper λειτουργία για ομαλή κύλιση στο στοιχείο
    function scrollToItem($el) {
        if ($el.length) {
            $('html, body').animate({
                scrollTop: $el.offset().top - 60
            }, 300);
        }
    }

    function addItem(data) {
        var uid = new Date().getTime() + '_' + Math.floor(Math.random() * 1000);
        
        var $item = $('#wdg_bento_item_template .wdg-bento-item').clone();
        $item.attr('data-uid', uid);

        $item.find('.link-picker-select').html(selectHtml);

        $item.find('.wdg-bento-title').val(data.title || '');
        $item.find('.wdg-bento-text').val(data.text || '');
        $item.find('.wdg-bento-col-span').val(data.col_span || 1);
        $item.find('.wdg-bento-row-span').val(data.row_span || 1);
        $item.find('.wdg-bento-align').val(data.align || 'align-start');
        $item.find('.wdg-bento-color-scheme').val(data.color_scheme || 'color-scheme-standard-primary');
        $item.find('.wdg-bento-link-url').val(data.link_url || '');
        $item.find('.wdg-bento-overlay-opacity').val(data.overlay_opacity !== undefined ? data.overlay_opacity : '0.4');
        
        if (data.link_newtab == '1' || data.link_newtab === '_blank') {
            $item.find('.wdg-bento-link-newtab').prop('checked', true);
        }

        if (data.bg_image) {
            $item.find('.hidden-image-val').val(data.bg_image);
            $item.find('.display-filename').text(data.bg_image.split('/').pop());
            $item.find('.image-preview').attr('src', data.bg_image).show();
            $item.find('.remove-media-btn').show();
        }

        var urlInputId = 'wdg_bento_url_input_' + uid;
        $item.find('.wdg-bento-link-url').attr('id', urlInputId);
        $item.find('.media-btn').attr('data-wdg-target', urlInputId); 

        var $nodeLink = $('<a></a>')
            .attr('id', 'wdg_bento_node_popup_' + uid)
            .attr('class', 'builder_popup')
            .attr('data-vbtype', 'iframe')
            .attr('href', 'section_links.php?venobox=[id]' + urlInputId)
            .css('display', 'none')
            .text('iFrame');

        var $fileLink = $('<a></a>')
            .attr('id', 'wdg_bento_file_popup_' + uid)
            .attr('class', 'builder_popup')
            .attr('data-vbtype', 'iframe')
            .attr('href', 'file_links.php?venobox=[id]' + urlInputId)
            .css('display', 'none')
            .text('iFrame');

        $('#wdg_bento_popups_container').append($nodeLink).append($fileLink);

        new VenoBox({selector: '#wdg_bento_node_popup_' + uid, fitView: true, ratio: 'full'});
        new VenoBox({selector: '#wdg_bento_file_popup_' + uid, fitView: true, ratio: 'full'});

        $item.find('.link-picker-select').on('change', function() {
            var $urlInput = $item.find('.wdg-bento-link-url');
            wdgBentoSetLink($(this).val(), $urlInput, uid);
            $(this).val('');
        });

        $item.find('.remove-media-btn').on('click', function() {
            $item.find('.hidden-image-val').val('');
            $item.find('.display-filename').text('Επιλέξτε...');
            $item.find('.image-preview').attr('src', '').hide();
            $(this).hide();
        });

        var overlayVal = (data.overlay_color || '[id]000000').replace('[id]', '#');
        $item.find('.color-picker-input').val(overlayVal).spectrum({
            showInput:       true,
            showPalette:     true,
            showAlpha:       false,
            palette:         _palette,
            preferredFormat: 'hex'
        });

        $('#wdg_bento_items_list').append($item);

        function updateHeader() {
            var inputTitle = $item.find('.wdg-bento-title').val().trim();
            var indexNum = $('#wdg_bento_items_list .wdg-bento-item').index($item) + 1;
            var finalTitle = 'Item ' + indexNum;
            if (inputTitle) {
                finalTitle += ': ' + inputTitle;
            }
            $item.find('.wdg-bento-title-display').text(finalTitle);
        }
        $item.find('.wdg-bento-title').on('input', updateHeader);
        updateHeader();

        // Μετακίνηση Πάνω + Smooth Scroll Focus
        $item.find('.move-up').on('click', function (e) {
            e.preventDefault();
            var $prev = $item.prev('.wdg-bento-item');
            if ($prev.length > 0) {
                $item.insertBefore($prev);
                renumberAllHeaders();
                scrollToItem($item);
            }
        });

        // Μετακίνηση Κάτω + Smooth Scroll Focus
        $item.find('.move-down').on('click', function (e) {
            e.preventDefault();
            var $next = $item.next('.wdg-bento-item');
            if ($next.length > 0) {
                $item.insertAfter($next);
                renumberAllHeaders();
                scrollToItem($item);
            }
        });

        $item.find('.remove-item').on('click', function () {
            $item.remove();
            $('#wdg_bento_node_popup_' + uid).remove();
            $('#wdg_bento_file_popup_' + uid).remove();
            renumberAllHeaders();
        });

        new VenoBox({selector: '.wdg-bento-select-media', fitView: true, ratio: 'full'});
    }

    function renumberAllHeaders() {
        $('#wdg_bento_items_list .wdg-bento-item').each(function (idx) {
            var currentTitle = $(this).find('.wdg-bento-title').val().trim();
            var displayTitle = 'Item ' + (idx + 1);
            if (currentTitle) {
                displayTitle += ': ' + currentTitle;
            }
            $(this).find('.wdg-bento-title-display').text(displayTitle);
        });
    }

    $.each(_items, function (i, item) {
        addItem(item);
    });

    $('#wdg_bento_add_btn').on('click', function () {
        addItem({});
        // Scroll στο νέο item που μόλις προστέθηκε
        scrollToItem($('#wdg_bento_items_list .wdg-bento-item').last());
    });

    label = 'Widget Bento Grid';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Bento Grid');

    window.get_block_data = function () {
        var items = [];
        $('#wdg_bento_items_list .wdg-bento-item').each(function () {
            var $it = $(this);
            var overlayRaw = $it.find('.color-picker-input').val() || '#000000';
            items.push({
                title:           $it.find('.wdg-bento-title').val(),
                text:            $it.find('.wdg-bento-text').val(),
                bg_image:        $it.find('.hidden-image-val').val(),
                overlay_color:   overlayRaw.replace('#', '[id]'),
                overlay_opacity: $it.find('.wdg-bento-overlay-opacity').val(),
                col_span:        $it.find('.wdg-bento-col-span').val(),
                row_span:        $it.find('.wdg-bento-row-span').val(),
                align:           $it.find('.wdg-bento-align').val(),
                color_scheme:    $it.find('.wdg-bento-color-scheme').val(),
                link_url:        $it.find('.wdg-bento-link-url').val(),
                link_newtab:     $it.find('.wdg-bento-link-newtab').is(':checked') ? '1' : '0'
            });
        });
        return {
            widget_id: 'bento_grid',
            params: {
                eyebrow:         $('#wdg_bg_eyebrow').val(),
                title:           $('#wdg_bg_title').val(),
                description:     $('#wdg_bg_description').val(),
                color_scheme:    $('#wdg_bg_color_scheme').val(),
                container_width: $('#wdg_bg_container_width').val(),
                items:           items
            }
        };
    };
});
</script>