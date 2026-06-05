<?php
/*
 * Widgetizer — Steps Widget — view.php
 * Prefix: stp
 * Refactored: No base64, uses [nl] for line breaks
 */
?>
<style>
    .ody_builder_parameter {
        max-width: 500px !important;
    }

    #wdg_stp_items_list .selectLink {
        border: 2px solid #747474 !important;
        background-color: #747474 !important;
        color: white !important;
    }

    .wdg-stp-item {
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 8px;
        background: #f0f4f4;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }

    .wdg-stp-item-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
    }

    .wdg-stp-item-header .wdg-stp-title-display {
        color: white;
        font-size: 11px;
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .wdg-stp-item-body {
        padding: 8px;
    }

    .wdg-stp-item-body .ody_builder_parameter {
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
        max-height: 60px;
        max-width: 120px;
        margin-top: 4px;
        border-radius: 3px;
        display: none;
        border: 1px solid #ddd;
    }

    .selectLink {
        border: 2px solid #002e3a !important;
        height: auto !important;
        padding: 2px 10px !important;
        font-size: .8em !important;
        background-color: #002e3a;
        color: white;
        max-width: 100% !important;
        width: 100% !important;
        margin: 2px 0 5px;
        box-sizing: border-box;
    }
    
    /* Βελάκια μετακίνησης */
    .wdg-stp-move-buttons {
        display: flex;
        gap: 4px;
        margin-right: 4px;
    }
    
    .wdg-stp-move-btn {
        background: transparent;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 12px;
        padding: 2px 4px;
        border-radius: 3px;
        transition: all 0.2s;
    }
    
    .wdg-stp-move-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }
    
    .wdg-stp-move-btn:active {
        transform: scale(0.9);
    }
</style>

<?php
$q = "select pages.id as id, content_pages.title as title
      from pages, content_pages
      where content_pages.mainID=pages.id
      and content_pages.langID=" . $langID . "
      order by pages.sort, content_pages.title";
$_stp_pages = $db->getRecords($q);
$_stp_page_opts = '<option value="">' . t("ή επιλέξτε υπάρχουσα σελίδα") . '</option>';
$_stp_page_opts .= '<option value="homepage">' . t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ") . '</option>';
foreach($_stp_pages as $_stp_row) {
    $_stp_page_opts .= '<option value="' . $_stp_row->id . '">' . htmlspecialchars($_stp_row->title) . '</option>';
}
$_stp_page_opts .= '<option value="divider">--------------------------------------</option>';
$_stp_page_opts .= '<option value="nodeLinks_stp">' . t("Link για εγγραφή ενότητας") . ' >></option>';
$_stp_page_opts .= '<option value="divider">--------------------------------------</option>';
$_stp_page_opts .= '<option value="fileLinks_stp">' . t("Link για αρχείο") . ' >></option>';
?>

<!-- ══ ΚΕΙΜΕΝΟ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Στοιχεία κειμένου"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_stp_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_stp_eyebrow" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_stp_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_stp_title" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_stp_title_size"><?php echo t("Μέγεθος τίτλου"); ?></label>
    <select id="wdg_stp_title_size" class="listbox">
        <option value="t-lg"><?php echo t("Μεγάλο"); ?></option>
        <option value="t-xl">XL</option>
        <option value="t-2xl" selected>2XL</option>
        <option value="t-3xl">3XL</option>
        <option value="t-4xl">4XL</option>
        <option value="t-5xl">5XL</option>
        <option value="t-6xl">6XL</option>
        <option value="t-7xl">7XL</option>
        <option value="t-8xl">8XL</option>
        <option value="t-9xl">9XL</option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_stp_description"><?php echo t("Περιγραφή"); ?></label>
    <textarea id="wdg_stp_description" class="listbox" rows="3" style="resize:vertical;"></textarea>
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_stp_header_align"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_stp_header_align" class="listbox">
        <option value="center" selected><?php echo t("Κέντρο"); ?></option>
        <option value="start"><?php echo t("Αριστερά"); ?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_stp_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_stp_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_stp_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_stp_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl" selected>X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>

<!-- ══ STEPS ═════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title">Steps</div>

<div id="wdg_stp_items_container" class="ody_builder_parameter">
    <div id="wdg_stp_items_list"></div>
    <button type="button" id="wdg_stp_add_item_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη"); ?> Step
    </button>
</div>

<div id="wdg_stp_popups_container" style="display:none;"></div>

<script>
jQuery(function ($) {
    var _p = _saved_params || {};
    var _steps = _p['steps'] || [];
    var _item_idx = 0;
    var _page_opts = <?php echo json_encode($_stp_page_opts); ?>;

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
    $('#wdg_stp_eyebrow').val(pval('eyebrow'));
    $('#wdg_stp_title').val(pval('title'));
    $('#wdg_stp_title_size').val(pval('title_size', 't-2xl'));
    
    // Description restore: decode [nl] to \n (NO base64)
    var descVal = pval('description', '');
    var descDecoded = descVal.replace(/\[nl\]/g, '\n');
    $('#wdg_stp_description').val(descDecoded);
    
    $('#wdg_stp_header_align').val(pval('header_align', 'center'));
    $('#wdg_stp_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_stp_container_width').val(pval('container_width', 'xl'));

    // ── VenoBox mediabank ──────────────────────────────────────────────────────
    window.venobox = new VenoBox({selector: '.wdg-stp-select-media', fitView: true, ratio: 'full'});
    
    window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
        var targetId = $(callerEl || window._wdg_mediabank_caller).data('wdg-target');
        if (!targetId) return;
        var fullPath = image_path + id + '.' + ext;
        $('#' + targetId).val(fullPath);
        $('#' + targetId + '_display').text(file);
        $('#' + targetId + '_preview').attr('src', fullPath).show();
        $('#' + targetId + '_remove').css('visibility', 'visible');
    };

    // ── wdgStpSetLink ──────────────────────────────────────────────────────────
    window.wdgStpSetLink = function (val, urlFieldId, ii) {
        if (!val || val === 'divider') return;
        if (val === 'nodeLinks_stp') {
            window.venobox = new VenoBox({selector: '#wdg_stp_node_popup_' + ii, fitView: true, ratio: 'full'});
            document.getElementById('wdg_stp_node_popup_' + ii).click();
            return;
        }
        if (val === 'fileLinks_stp') {
            window.venobox = new VenoBox({selector: '#wdg_stp_file_popup_' + ii, fitView: true, ratio: 'full'});
            document.getElementById('wdg_stp_file_popup_' + ii).click();
            return;
        }
        var link = (val === 'homepage') ? 'index.php' : '\u00ab\u00abindex.php?section=pages~|||~view=render~|||~id=' + val + '\u00bb\u00bb';
        $('#' + urlFieldId).val(link);
    };

    // ── Function to update title display ──────────────────────────────────────
    function updateTitleDisplay($item, uid) {
        var titleValue = $('#wdg_stp_title_' + uid).val();
        var stepNumber = $item.index() + 1;
        var displayText = 'Step ' + stepNumber;
        if (titleValue && titleValue.trim() !== '') {
            displayText += ': ' + titleValue;
        }
        $item.find('.wdg-stp-title-display').text(displayText);
    }

    // ── Move functions with smooth slide animation, scroll and highlight ──────
    function moveStepUp($item) {
        var $prev = $item.prev('.wdg-stp-item');
        var speed = 1;
        if ($prev.length) {
            $item.slideUp(speed, function() {
                $item.insertBefore($prev);
                $item.slideDown(speed, function() {
                    renumberItems();
                    // Scroll to moved step
                    $('html, body').animate({
                        scrollTop: $item.offset().top - 100
                    }, 300);
                    // Highlight effect
                    $item.css('box-shadow', '0 0 0 2px #fbbf24');
                    setTimeout(function() {
                        $item.css('box-shadow', '');
                    }, 100);
                });
            });
        }
    }

    function moveStepDown($item) {
        var $next = $item.next('.wdg-stp-item');
        var speed = 1;
        if ($next.length) {
            $item.slideUp(speed, function() {
                $item.insertAfter($next);
                $item.slideDown(speed, function() {
                    renumberItems();
                    // Scroll to moved step
                    $('html, body').animate({
                        scrollTop: $item.offset().top - 100
                    }, 300);
                    // Highlight effect
                    $item.css('box-shadow', '0 0 0 2px #fbbf24');
                    setTimeout(function() {
                        $item.css('box-shadow', '');
                    }, 100);
                });
            });
        }
    }

    // ── addItem ────────────────────────────────────────────────────────────────
    function addItem(data) {
        data = data || {};
        var ii = _item_idx++;
        var uid = 'stp_' + ii;
        var imgId = 'wdg_stp_img_' + uid;
        var urlId = 'wdg_stp_url_' + uid;
        var nodePop = 'wdg_stp_node_popup_' + ii;
        var filePop = 'wdg_stp_file_popup_' + ii;
        
        var $item = $('<div class="wdg-stp-item" data-ii="' + ii + '">');
        $item.append(
            '<div class="wdg-stp-item-header">' +
            '<div class="wdg-stp-move-buttons">' +
            '<button type="button" class="wdg-stp-move-btn wdg-stp-move-up" title="<?php echo t("Μετακίνηση πάνω"); ?>">▲</button>' +
            '<button type="button" class="wdg-stp-move-btn wdg-stp-move-down" title="<?php echo t("Μετακίνηση κάτω"); ?>">▼</button>' +
            '</div>' +
            '<span class="wdg-stp-title-display"><?php echo t("Step"); ?> ' + ($('#wdg_stp_items_list .wdg-stp-item').length + 1) + '</span>' +
            '<button type="button" class="wdg-item-remove" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );
        
        var $body = $('<div class="wdg-stp-item-body">');
        
        // ── Εικόνα ────────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Εικόνα"); ?></label>' +
            '<div class="wdg-img-row">' +
            '<span id="' + imgId + '_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>' +
            '<a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"' +
            ' class="wdg-stp-select-media ody_builder_content_action btn btn-success"' +
            ' data-vbtype="iframe" data-wdg-target="' + imgId + '"><?php echo t("Επιλογή"); ?></a>' +
            '<a href="javascript:void(0)" id="' + imgId + '_remove"' +
            ' class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"><?php echo t("Αφαίρεση"); ?></a>' +
            '</div>' +
            '<input type="hidden" id="' + imgId + '" value="">' +
            '<img id="' + imgId + '_preview" class="wdg-img-preview" src="" alt="">' +
            '</div>'
        );
        
        // ── Τίτλος ────────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?></label>' +
            '<input type="text" id="wdg_stp_title_' + uid + '" class="listbox wdg-stp-title-input" value="' + escapeForTextarea(data.title || '') + '"></div>'
        );
        
        // ── Μέγεθος τίτλου ────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Μέγεθος τίτλου"); ?></label>' +
            '<select id="wdg_stp_tsize_' + uid + '" class="listbox">' +
            '<option value="t-lg"><?php echo t("Μεγάλο"); ?></option>' +
            '<option value="t-xl">XL</option>' +
            '<option value="t-2xl">2XL</option>' +
            '<option value="t-3xl" selected>3XL</option>' +
            '<option value="t-4xl">4XL</option>' +
            '<option value="t-5xl">5XL</option>' +
            '</select></div>'
        );
        
        // ── Body (description) with [nl] decode ────────────────────────────────
        var bodyVal = data.body || '';
        var bodyDecoded = bodyVal.replace(/\[nl\]/g, '\n');
        
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label>' +
            '<textarea id="wdg_stp_body_' + uid + '" class="listbox" rows="3" style="resize:vertical;">' + escapeForTextarea(bodyDecoded) + '</textarea></div>'
        );
        
        // ── Κείμενο Κουμπιού ──────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Κείμενο Κουμπιού"); ?></label>' +
            '<input type="text" id="wdg_stp_btnlabel_' + uid + '" class="listbox" value="' + escapeForTextarea(data.btn_label || '') + '"></div>'
        );
        
        // ── Link Κουμπιού ─────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label>Link</label>' +
            '<input type="text" id="' + urlId + '" class="listbox" value="' + escapeForTextarea(data.btn_url || '') + '">' +
            '<select class="selectLink listbox" onchange="wdgStpSetLink($(this).val(), \'' + urlId + '\', ' + ii + '); $(this).val(\'\');">' +
            _page_opts +
            '</select></div>'
        );
        
        // ── Νέο tab ───────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">' +
            '<input type="checkbox" id="wdg_stp_btntab_' + uid + '" value="1">' +
            '<p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>' +
            '</div></div>'
        );
        
        // ── Παλέτα Κουμπιού ───────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Εμφάνιση κουμπιού"); ?></label>' +
            '<select id="wdg_stp_btnstyle_' + uid + '" class="listbox">' +
            '<option value="widget-button-primary">Primary</option>' +
            '<option value="widget-button-secondary" selected>Secondary</option>' +
            '</select></div>'
        );
        
        $item.append($body);
        $('#wdg_stp_items_list').append($item);
        
        // ── Node / File popups ─────────────────────────────────────────────────
        $('#wdg_stp_popups_container').append(
            '<a id="' + nodePop + '" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]' + urlId + '">iFrame</a>' +
            '<a id="' + filePop + '" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]' + urlId + '">iFrame</a>'
        );
        
        window.venobox = new VenoBox({selector: '#' + nodePop, fitView: true, ratio: 'full'});
        window.venobox = new VenoBox({selector: '#' + filePop, fitView: true, ratio: 'full'});
        
        // ── Restore image ──────────────────────────────────────────────────────
        if (data.image) {
            $('#' + imgId).val(data.image);
            $('#' + imgId + '_display').text(data.image.split('/').pop());
            $('#' + imgId + '_preview').attr('src', data.image).show();
            $('#' + imgId + '_remove').css('visibility', 'visible');
        }
        
        // ── Remove button event listener ───────────────────────────────────────
        $('#' + imgId + '_remove').on('click', function() {
            $('#' + imgId).val('');
            $('#' + imgId + '_display').text('<?php echo t("Επιλέξτε..."); ?>');
            $('#' + imgId + '_preview').hide().attr('src', '');
            $(this).css('visibility', 'hidden');
        });
        
        // ── Restore other values ───────────────────────────────────────────────
        if (data.step_title_size) $('#wdg_stp_tsize_' + uid).val(data.step_title_size);
        if (data.btn_style) $('#wdg_stp_btnstyle_' + uid).val(data.btn_style);
        if (data.btn_new_tab == '1') $('#wdg_stp_btntab_' + uid).prop('checked', true);
        
        // ── Media picker reinit ────────────────────────────────────────────────
        $('.wdg-stp-select-media').off('click').on('click', function () {
            window._wdg_mediabank_caller = this;
        });
        window.venobox = new VenoBox({selector: '.wdg-stp-select-media', fitView: true, ratio: 'full'});
        
        // ── Update title display on input change ───────────────────────────────
        $('#wdg_stp_title_' + uid).on('input', function() {
            updateTitleDisplay($item, uid);
        });
        
        // ── Move buttons events ────────────────────────────────────────────────
        $item.find('.wdg-stp-move-up').on('click', function(e) {
            e.stopPropagation();
            moveStepUp($item);
        });
        
        $item.find('.wdg-stp-move-down').on('click', function(e) {
            e.stopPropagation();
            moveStepDown($item);
        });
        
        // ── Item remove ────────────────────────────────────────────────────────
        $item.find('.wdg-item-remove').on('click', function () {
            $item.fadeOut(200, function () {
                $item.remove();
                renumberItems();
            });
        });
        
        // Initial title display update
        updateTitleDisplay($item, uid);
    }

    function renumberItems() {
        var items = $('#wdg_stp_items_list .wdg-stp-item');
        for (var i = 0; i < items.length; i++) {
            var $item = $(items[i]);
            var ii = $item.data('ii');
            var uid = 'stp_' + ii;
            updateTitleDisplay($item, uid);
        }
    }

    // ── Restore steps ─────────────────────────────────────────────────────────
    for (var i = 0; i < _steps.length; i++) {
        addItem(_steps[i]);
    }
    
    $('#wdg_stp_add_item_btn').on('click', function () {
        addItem({});
    });
    
    // ── Label ─────────────────────────────────────────────────────────────────
    var label = 'Widget Steps';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Steps');
    
    // ── get_block_data (save) ─────────────────────────────────────────────────
    window.get_block_data = function () {
        var steps = [];
        var itemEls = $('#wdg_stp_items_list .wdg-stp-item');
        
        for (var i = 0; i < itemEls.length; i++) {
            var ii = $(itemEls[i]).data('ii');
            var uid = 'stp_' + ii;
            var bodyVal = $('#wdg_stp_body_' + uid).val();
            // Encode newlines to [nl] (NO base64)
            var bodyEncoded = bodyVal.replace(/\n/g, '[nl]');
            
            steps.push({
                image:           $('#wdg_stp_img_' + uid).val(),
                title:           $('#wdg_stp_title_' + uid).val(),
                step_title_size: $('#wdg_stp_tsize_' + uid).val(),
                body:            bodyEncoded,
                btn_label:       $('#wdg_stp_btnlabel_' + uid).val(),
                btn_url:         $('#wdg_stp_url_' + uid).val(),
                btn_new_tab:     $('#wdg_stp_btntab_' + uid).is(':checked') ? '1' : '0',
                btn_style:       $('#wdg_stp_btnstyle_' + uid).val()
            });
        }
        
        var headerDescVal = $('#wdg_stp_description').val();
        // Encode newlines to [nl] (NO base64)
        var headerDescEncoded = headerDescVal.replace(/\n/g, '[nl]');
        
        return {
            widget_id: 'steps',
            params: {
                eyebrow:         $('#wdg_stp_eyebrow').val(),
                title:           $('#wdg_stp_title').val(),
                title_size:      $('#wdg_stp_title_size').val(),
                description:     headerDescEncoded,
                header_align:    $('#wdg_stp_header_align').val(),
                color_scheme:    $('#wdg_stp_color_scheme').val(),
                container_width: $('#wdg_stp_container_width').val(),
                steps:           steps
            }
        };
    };
});
</script>