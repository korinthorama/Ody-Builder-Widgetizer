<?php defined('CMS') or die("This file cannot run this way!"); ?>
<style>
    .ody_builder_parameter {
        max-width: 500px !important;
    }

    .wdg-rlst-item {
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 6px;
        background: #f0f4f4;
    }

    .wdg-rlst-item-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
        cursor: move;
    }

    .wdg-rlst-item-header span {
        color: white;
        font-size: 11px;
        flex: 1;
    }

    .wdg-rlst-item-body {
        padding: 8px;
    }

    .wdg-rlst-item-body .ody_builder_parameter {
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
        max-height: 40px;
        max-width: 100px;
        margin-top: 4px;
        border-radius: 3px;
        display: none;
        border: 1px solid #ddd;
    }
</style>
<!-- ══ ΓΕΝΙΚΑ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_rlst_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_rlst_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_rlst_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_rlst_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_rlst_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_rlst_description" class="listbox" value="">
</div>
<!-- ══ ΕΜΦΑΝΙΣΗ ═════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_rlst_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_rlst_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_rlst_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_rlst_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_rlst_header_align"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_rlst_header_align" class="listbox">
        <option value="left"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>
<!-- ══ ΕΙΚΟΝΑ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εικόνα"); ?></div>
<div class="ody_builder_parameter">
    <label><?php echo t("Εικόνα"); ?></label>
    <div class="wdg-img-row">
        <span id="wdg_rlst_image_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>
        <a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"
           id="wdg_rlst_select_media_btn"
           class="wdg-rlst-select-media ody_builder_content_action btn btn-success"
           data-vbtype="iframe"
           data-wdg-target="wdg_rlst_image"><?php echo t("Επιλογή"); ?></a>
        <a href="javascript:void(0)" id="wdg_rlst_image_remove"
           class="ody_builder_content_action btn btn-danger"
           style="visibility:hidden;">
            <?php echo t("Αφαίρεση"); ?>
        </a>
    </div>
    <input type="hidden" id="wdg_rlst_image" value="">
    <img id="wdg_rlst_image_preview" class="wdg-img-preview" src="" alt="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_rlst_image_position"><?php echo t("Θέση εικόνας"); ?></label>
    <select id="wdg_rlst_image_position" class="listbox">
        <option value="start"><?php echo t("Αριστερά"); ?></option>
        <option value="end"><?php echo t("Δεξιά"); ?></option>
    </select>
</div>
<!-- ══ ITEMS ═════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Αρχεία"); ?></div>
<div id="wdg_rlst_items_container" class="ody_builder_parameter">
    <div id="wdg_rlst_items_list"></div>
    <button type="button" id="wdg_rlst_add_item_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη αρχείου"); ?>
    </button>
</div>
<div id="wdg_rlst_popups_container" style="display:none;"></div>
<script>
    jQuery(function ($) {
        var _p = _saved_params || {};
        var _items = _p['items'] || [];
        var _item_idx = 0;

        function pval(key, def) {
            return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
        }

        // ── Restore scalars ────────────────────────────────────────────────────────
        $('#wdg_rlst_eyebrow').val(pval('eyebrow'));
        $('#wdg_rlst_title').val(pval('title'));
        $('#wdg_rlst_description').val(pval('description'));
        $('#wdg_rlst_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
        $('#wdg_rlst_container_width').val(pval('container_width', 'xl'));
        $('#wdg_rlst_header_align').val(pval('header_align', 'center'));
        $('#wdg_rlst_image_position').val(pval('image_position', 'start'));
        // ── Section image restore ──────────────────────────────────────────────────
        var _savedImg = pval('image', '');
        if(_savedImg) {
            $('#wdg_rlst_image').val(_savedImg);
            $('#wdg_rlst_image_display').text(_savedImg.split('/').pop());
            $('#wdg_rlst_image_preview').attr('src', _savedImg).show();
            $('#wdg_rlst_image_remove').css('visibility', 'visible');
        }
        // ── VenoBox section image ──────────────────────────────────────────────────
        window.venobox = new VenoBox({selector: '.wdg-rlst-select-media', fitView: true, ratio: 'full'});
        $('#wdg_rlst_select_media_btn').on('click', function () {
            window._wdg_mediabank_caller = this;
        });
        $('#wdg_rlst_image_remove').on('click', function() {
            $('#wdg_rlst_image').val('');
            $('#wdg_rlst_image_display').text('<?php echo t("Επιλέξτε..."); ?>');
            $('#wdg_rlst_image_preview').hide().attr('src', '');
            $(this).css('visibility', 'hidden');
        });
        window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
            var targetId = $(callerEl || window._wdg_mediabank_caller).data('wdg-target');
            if(!targetId) return;
            var fullPath = image_path + id + '.' + ext;
            $('#' + targetId).val(fullPath);
            $('#' + targetId + '_display').text(file);
            $('#' + targetId + '_preview').attr('src', fullPath).show();
            $('#' + targetId + '_remove').css('visibility', 'visible');
        };
        // ── wdgRlstSetLink ─────────────────────────────────────────────────────────
        var _rlst_active_url_id = null;
        window.wdgRlstSetLink = function (val, urlFieldId, idx) {
            if(!val || val === 'divider') return;
            if(val === 'nodeLinks_rlst') {
                window.venobox = new VenoBox({selector: '#wdg_rlst_node_popup_' + idx, fitView: true, ratio: 'full'});
                document.getElementById('wdg_rlst_node_popup_' + idx).click();
                return;
            }
            if(val === 'fileLinks_rlst') {
                _rlst_active_url_id = urlFieldId;
                window.venobox = new VenoBox({selector: '#wdg_rlst_file_popup_' + idx, fitView: true, ratio: 'full'});
                document.getElementById('wdg_rlst_file_popup_' + idx).click();
                return;
            }
            var link = (val === 'homepage') ? 'index.php' : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
            $('#' + urlFieldId).val(link);
        };
        // ── Παρακολούθηση hidden input μετά επιλογή αρχείου ───────────────────────
        var _rlst_file_observer_timer = null;
        window.startFileObserver = function startFileObserver() {
            if(!_rlst_active_url_id) return;
            var targetId = _rlst_active_url_id;
            var lastVal = $('#' + targetId).val();
            clearInterval(_rlst_file_observer_timer);
            _rlst_file_observer_timer = setInterval(function () {
                var newVal = $('#' + targetId).val();
                if(newVal && newVal !== lastVal) {
                    clearInterval(_rlst_file_observer_timer);
                    $('#' + targetId + '_display').text(newVal.split('/').pop()).css('color', '#333').css('font-style', 'normal');
                    $('#' + targetId).val(newVal.split('/').pop());
                    _rlst_active_url_id = null;
                }
            }, 200);
        }

        // ── Add Item ───────────────────────────────────────────────────────────────
        function addItem(itemData) {
            itemData = itemData || {};
            var ii = _item_idx++;
            var uid = 'rlst_' + ii;
            var urlId = 'wdg_rlst_url_' + uid;
            var nodePop = 'wdg_rlst_node_popup_' + ii;
            var filePop = 'wdg_rlst_file_popup_' + ii;
            var $item = $('<div class="wdg-rlst-item" data-ii="' + ii + '">');
            $item.append(
                    '<div class="wdg-rlst-item-header">' +
                    '<span><?php echo t("Αρχείο"); ?> ' + ($('#wdg_rlst_items_list .wdg-rlst-item').length + 1) + '</span>' +
                    '<button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
                    '</div>'
            );
            var $body = $('<div class="wdg-rlst-item-body">');
            // Title
            $body.append(
                    '<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?></label>' +
                    '<input type="text" id="wdg_rlst_title_' + uid + '" class="listbox" value="' + $('<div>').text(itemData.title || '').html() + '"></div>'
            );
            // Description
            $body.append(
                    '<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label>' +
                    '<input type="text" id="wdg_rlst_desc_' + uid + '" class="listbox" value="' + $('<div>').text(itemData.description || '').html() + '"></div>'
            );
            // Button label
            $body.append(
                    '<div class="ody_builder_parameter"><label><?php echo t("Κείμενο κουμπιού"); ?></label>' +
                    '<input type="text" id="wdg_rlst_btn_label_' + uid + '" class="listbox" value="' + $('<div>').text(itemData.btn_label || '').html() + '"></div>'
            );
            // URL + file picker
            var fileDisplay = itemData.btn_url ? itemData.btn_url.split('/').pop() : '...';
            $body.append(
                    '<div class="ody_builder_parameter"><label><?php echo t("Αρχείο"); ?></label>' +
                    '<div style="display:flex; align-items:center; gap:8px;">' +
                    '<span id="' + urlId + '_display" style="font-size:12px; color:#555; font-style:italic; flex:1;">' + $('<div>').text(fileDisplay).html() + '</span>' +
                    '<button type="button" class="ody_builder_content_action btn btn-success" style="font-size:12px; white-space:nowrap;" onclick="wdgRlstSetLink(\'fileLinks_rlst\', \'' + urlId + '\', ' + ii + '); startFileObserver();">🔗 <?php echo t("Επιλογή αρχείου"); ?></button>' +
                    '</div>' +
                    '<input type="hidden" id="' + urlId + '" value="' + $('<div>').text(itemData.btn_url || '').html() + '">' +
                    '</div>'
            );
            $item.append($body);
            $('#wdg_rlst_items_list').append($item);
            // Node / File popups
            $('#wdg_rlst_popups_container').append(
                    '<a id="' + nodePop + '" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]' + urlId + '">iFrame</a>' +
                    '<a id="' + filePop + '" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]' + urlId + '">iFrame</a>'
            );
            $item.find('.wdg-item-remove').on('click', function () {
                $item.fadeOut(200, function () {
                    $item.remove();
                    renumberItems();
                });
            });
            if($.fn.sortable) {
                $('#wdg_rlst_items_list').sortable({
                    handle:      '.wdg-rlst-item-header',
                    placeholder: 'block-placeholder',
                    tolerance:   'pointer',
                    stop:        function () {
                        renumberItems();
                    }
                });
            }
        }

        function renumberItems() {
            $('#wdg_rlst_items_list .wdg-rlst-item').each(function (idx) {
                $(this).find('.wdg-rlst-item-header span').text('<?php echo t("Αρχείο"); ?> ' + (idx + 1));
            });
        }

        _items.forEach(function (item) {
            addItem(item);
        });
        $('#wdg_rlst_add_item_btn').on('click', function () {
            addItem({});
        });
        // ── Label ─────────────────────────────────────────────────────────────────
        label = 'Widget Resource List';
        $('#ody_builder_admin_label').val(label);
        $('.ody_builder_header h2').html('Widgetizer — Resource List');
        // ── get_block_data ────────────────────────────────────────────────────────
        window.get_block_data = function () {
            var items = [];
            $('#wdg_rlst_items_list .wdg-rlst-item').each(function () {
                var ii = $(this).data('ii');
                var uid = 'rlst_' + ii;
                items.push({
                    title:       $('#wdg_rlst_title_' + uid).val(),
                    description: $('#wdg_rlst_desc_' + uid).val(),
                    btn_label:   $('#wdg_rlst_btn_label_' + uid).val(),
                    btn_url:     $('#wdg_rlst_url_' + uid).val()
                });
            });
            return {
                widget_id: 'resource_list',
                params:    {
                    eyebrow:         $('#wdg_rlst_eyebrow').val(),
                    title:           $('#wdg_rlst_title').val(),
                    description:     $('#wdg_rlst_description').val(),
                    color_scheme:    $('#wdg_rlst_color_scheme').val(),
                    container_width: $('#wdg_rlst_container_width').val(),
                    header_align:    $('#wdg_rlst_header_align').val(),
                    image_position:  $('#wdg_rlst_image_position').val(),
                    image:           $('#wdg_rlst_image').val(),
                    items:           items
                }
            };
        };
    });
</script>
