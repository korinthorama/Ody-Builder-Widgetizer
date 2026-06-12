<?php defined('CMS') or die("This file cannot run this way!"); ?>

<?php
$q = "select pages.id as id, content_pages.title as title
      from pages, content_pages
      where content_pages.mainID=pages.id
      and content_pages.langID=" . $langID . "
      order by pages.sort, content_pages.title";
$_slpn_pages = $db->getRecords($q);
$_slpn_page_opts = '<option value="">' . t("ή επιλέξτε υπάρχουσα σελίδα") . '</option>';
$_slpn_page_opts .= '<option value="homepage">' . t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ") . '</option>';
foreach($_slpn_pages as $_slpn_row) {
    $_slpn_page_opts .= '<option value="' . $_slpn_row->id . '">' . htmlspecialchars($_slpn_row->title) . '</option>';
}
$_slpn_page_opts .= '<option value="divider">--------------------------------------</option>';
$_slpn_page_opts .= '<option value="nodeLinks_slpn">' . t("Link για εγγραφή ενότητας") . ' >></option>';
$_slpn_page_opts .= '<option value="divider">--------------------------------------</option>';
$_slpn_page_opts .= '<option value="fileLinks_slpn">' . t("Link για αρχείο") . ' >></option>';
?>

<style>
    .ody_builder_parameter {
        max-width: 500px !important;
    }

    .wdg-slpn-item {
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 6px;
        background: #f0f4f4;
        transition: box-shadow 0.3s ease;
    }

    .wdg-slpn-item-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
    }

    .wdg-slpn-item-header span {
        color: white;
        font-size: 11px;
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .wdg-slpn-move-buttons {
        display: flex;
        gap: 4px;
        margin-right: 4px;
    }

    .wdg-slpn-move-btn {
        background: transparent;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 11px;
        padding: 0 2px;
        line-height: 1;
    }

    .wdg-slpn-move-btn:hover {
        color: #fbbf24;
    }

    .wdg-slpn-move-btn:active {
        color: #f59e0b;
    }

    .wdg-slpn-item-body {
        padding: 8px;
    }

    .wdg-slpn-item-body .ody_builder_parameter {
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
</style>

<!-- ══ ΓΕΝΙΚΑ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_slpn_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_slpn_eyebrow" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_slpn_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_slpn_title" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_slpn_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_slpn_description" class="listbox" value="">
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ═════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_slpn_header_align"><?php echo t("Στοίχιση"); ?></label>
    <select id="wdg_slpn_header_align" class="listbox">
        <option value="center" selected><?php echo t("Κέντρο"); ?></option>
        <option value="start"><?php echo t("Αριστερά"); ?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_slpn_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_slpn_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_slpn_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_slpn_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl" selected>X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>

<!-- ══ PANELS ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εικόνες"); ?></div>

<div id="wdg_slpn_items_container" class="ody_builder_parameter">
    <div id="wdg_slpn_items_list"></div>
    <button type="button" id="wdg_slpn_add_item_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη εικόνας"); ?>
    </button>
</div>

<div id="wdg_slpn_popups_container" style="display:none;"></div>

<script>
jQuery(function ($) {
    var _p = _saved_params || {};
    var _panels = _p['panels'] || [];
    var _item_idx = 0;
    var _page_opts = <?php echo json_encode($_slpn_page_opts); ?>;

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    // ── Restore scalars ────────────────────────────────────────────────────────
    $('#wdg_slpn_eyebrow').val(pval('eyebrow'));
    $('#wdg_slpn_title').val(pval('title'));
    $('#wdg_slpn_description').val(pval('description'));
    $('#wdg_slpn_header_align').val(pval('header_align', 'center'));
    $('#wdg_slpn_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_slpn_container_width').val(pval('container_width', 'xl'));

    // ── VenoBox for image selector ─────────────────────────────────────────────
    window.venobox = new VenoBox({selector: '.wdg-slpn-select-media', fitView: true, ratio: 'full'});
    
    window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
        var targetId = $(callerEl || window._wdg_mediabank_caller).data('wdg-target');
        if (!targetId) return;
        var fullPath = image_path + id + '.' + ext;
        $('#' + targetId).val(fullPath);
        $('#' + targetId + '_display').text(file);
        $('#' + targetId + '_preview').attr('src', fullPath).show();
        $('#' + targetId + '_remove').css('visibility', 'visible');
    };

    // ── wdgSlpnSetLink ─────────────────────────────────────────────────────────
    window.wdgSlpnSetLink = function (val, urlFieldId, idx) {
        if (!val || val === 'divider') return;
        if (val === 'nodeLinks_slpn') {
            window.venobox = new VenoBox({selector: '#wdg_slpn_node_popup_' + idx, fitView: true, ratio: 'full'});
            document.getElementById('wdg_slpn_node_popup_' + idx).click();
            return;
        }
        if (val === 'fileLinks_slpn') {
            window.venobox = new VenoBox({selector: '#wdg_slpn_file_popup_' + idx, fitView: true, ratio: 'full'});
            document.getElementById('wdg_slpn_file_popup_' + idx).click();
            return;
        }
        var link = (val === 'homepage') ? 'index.php' : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
        $('#' + urlFieldId).val(link);
    };

    function addItem(data) {
        data = data || {};
        var ii = _item_idx++;
        var uid = 'slpn_' + ii;
        var imgId = 'wdg_slpn_img_' + uid;
        var urlId = 'wdg_slpn_url_' + uid;
        var nodePop = 'wdg_slpn_node_popup_' + ii;
        var filePop = 'wdg_slpn_file_popup_' + ii;
        
        var $item = $('<div class="wdg-slpn-item" data-ii="' + ii + '">');
        $item.append(
            '<div class="wdg-slpn-item-header">' +
            '<div class="wdg-slpn-move-buttons">' +
            '<button type="button" class="wdg-slpn-move-btn wdg-slpn-move-up">▲</button>' +
            '<button type="button" class="wdg-slpn-move-btn wdg-slpn-move-down">▼</button>' +
            '</div>' +
            '<span class="wdg-slpn-title-display"></span>' +
            '<button type="button" class="wdg-item-remove" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );
        
        var $body = $('<div class="wdg-slpn-item-body">');
        
        // ── Image ──────────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Εικόνα"); ?></label>' +
            '<div class="wdg-img-row">' +
            '<span id="' + imgId + '_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>' +
            '<a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"' +
            ' class="wdg-slpn-select-media ody_builder_content_action btn btn-success"' +
            ' data-vbtype="iframe" data-wdg-target="' + imgId + '"><?php echo t("Επιλογή"); ?></a>' +
            '<a href="javascript:void(0)" id="' + imgId + '_remove"' +
            ' class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"><?php echo t("Αφαίρεση"); ?></a>' +
            '</div>' +
            '<input type="hidden" id="' + imgId + '" value="">' +
            '<img id="' + imgId + '_preview" class="wdg-img-preview" src="" alt="">' +
            '</div>'
        );
        
        // ── Panel title ────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τίτλος εικόνας"); ?></label>' +
            '<input type="text" id="wdg_slpn_ptitle_' + uid + '" class="listbox" value="' + $('<div>').text(data.panel_title || '').html() + '"></div>'
        );
        
        // ── Subtitle ───────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Υπότιτλος εικόνας"); ?></label>' +
            '<input type="text" id="wdg_slpn_subtitle_' + uid + '" class="listbox" value="' + $('<div>').text(data.subtitle || '').html() + '"></div>'
        );
        
        // ── Panel color scheme ─────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Χρωματική παλέτα του panel"); ?></label>' +
            '<select id="wdg_slpn_pcs_' + uid + '" class="listbox">' +
            '<option value="color-scheme-highlight-primary" selected>Highlight Primary</option>' +
            '<option value="color-scheme-highlight-secondary">Highlight Secondary</option>' +
            '<option value="color-scheme-standard-primary">Standard Primary</option>' +
            '<option value="color-scheme-standard-secondary">Standard Secondary</option>' +
            '</select></div>'
        );
        
        // ── Button label ───────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Κείμενο Κουμπιού"); ?></label>' +
            '<input type="text" id="wdg_slpn_btnlabel_' + uid + '" class="listbox" value="' + $('<div>').text(data.btn_label || '').html() + '"></div>'
        );
        
        // ── Button URL ─────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label>Link</label>' +
            '<input type="text" id="' + urlId + '" class="listbox" value="' + $('<div>').text(data.btn_url || '').html() + '" placeholder="https://">' +
            '<select class="selectLink listbox" onchange="wdgSlpnSetLink($(this).val(), \'' + urlId + '\', ' + ii + '); $(this).val(\'\');">' +
            _page_opts +
            '</select></div>'
        );
        
        // ── Button style ───────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Εμφάνιση κουμπιού"); ?></label>' +
            '<select id="wdg_slpn_btnstyle_' + uid + '" class="listbox">' +
            '<option value="widget-button-secondary" selected><?php echo t("Secondary"); ?></option>' +
            '<option value="widget-button-primary"><?php echo t("Primary"); ?></option>' +
            '<option value="widget-button-outline"><?php echo t("Outline"); ?></option>' +
            '</select></div>'
        );
        
        // ── Button new tab ─────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">' +
            '<input type="checkbox" id="wdg_slpn_btntab_' + uid + '" value="1">' +
            '<p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>' +
            '</div></div>'
        );
        
        $item.append($body);
        $('#wdg_slpn_items_list').append($item);
        
        // ── Node / File popups ─────────────────────────────────────────────────
        $('#wdg_slpn_popups_container').append(
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
        
        // ── VenoBox for image picker (reinit after append) ─────────────────────
        $('.wdg-slpn-select-media').off('click').on('click', function () {
            window._wdg_mediabank_caller = this;
        });
        window.venobox = new VenoBox({selector: '.wdg-slpn-select-media', fitView: true, ratio: 'full'});
        
        // ── Restore other values ───────────────────────────────────────────────
        if (data.panel_color_scheme) $('#wdg_slpn_pcs_' + uid).val(data.panel_color_scheme);
        if (data.btn_style) $('#wdg_slpn_btnstyle_' + uid).val(data.btn_style);
        if (data.btn_new_tab == '1') $('#wdg_slpn_btntab_' + uid).prop('checked', true);
        
        // ── Remove button event listener ───────────────────────────────────────
        $('#' + imgId + '_remove').on('click', function() {
            $('#' + imgId).val('');
            $('#' + imgId + '_display').text('<?php echo t("Επιλέξτε..."); ?>');
            $('#' + imgId + '_preview').hide().attr('src', '');
            $(this).css('visibility', 'hidden');
        });
        
        // ── Item remove ────────────────────────────────────────────────────────
        $item.find('.wdg-item-remove').on('click', function () {
            $item.fadeOut(200, function () {
                $item.remove();
                renumberItems();
            });
        });
        
        // ── Move buttons ───────────────────────────────────────────────────────
        $item.find('.wdg-slpn-move-up').on('click', function (e) {
            e.stopPropagation();
            moveSlpnUp($item);
        });
        $item.find('.wdg-slpn-move-down').on('click', function (e) {
            e.stopPropagation();
            moveSlpnDown($item);
        });

        // ── Title input → update display ───────────────────────────────────────
        $('#wdg_slpn_ptitle_' + uid).on('input', function () {
            updateSlpnDisplay($item);
        });

        updateSlpnDisplay($item);
    }

    function updateSlpnDisplay($item) {
        var ii = $item.data('ii');
        var uid = 'slpn_' + ii;
        var n = $item.index() + 1;
        var title = $('#wdg_slpn_ptitle_' + uid).val();
        var label = '<?php echo t("Εικόνα"); ?> ' + n + (title ? ': ' + title : '');
        $item.find('.wdg-slpn-title-display').text(label);
    }

    function moveSlpnUp($item) {
        var $prev = $item.prev('.wdg-slpn-item');
        if (!$prev.length) return;
        $item.slideUp(1, function () {
            $item.insertBefore($prev);
            $item.slideDown(1, function () {
                renumberItems();
                $('html, body').animate({scrollTop: $item.offset().top - 100}, 300);
                $item.css('box-shadow', '0 0 0 2px #fbbf24');
                setTimeout(function () { $item.css('box-shadow', ''); }, 600);
            });
        });
    }

    function moveSlpnDown($item) {
        var $next = $item.next('.wdg-slpn-item');
        if (!$next.length) return;
        $item.slideUp(1, function () {
            $item.insertAfter($next);
            $item.slideDown(1, function () {
                renumberItems();
                $('html, body').animate({scrollTop: $item.offset().top - 100}, 300);
                $item.css('box-shadow', '0 0 0 2px #fbbf24');
                setTimeout(function () { $item.css('box-shadow', ''); }, 600);
            });
        });
    }

    function renumberItems() {
        $('#wdg_slpn_items_list .wdg-slpn-item').each(function () {
            updateSlpnDisplay($(this));
        });
    }

    // ── Restore panels ─────────────────────────────────────────────────────────
    for (var i = 0; i < _panels.length; i++) {
        addItem(_panels[i]);
    }
    
    $('#wdg_slpn_add_item_btn').on('click', function () {
        addItem({});
    });
    
    // ── Label ─────────────────────────────────────────────────────────────────
    var label = 'Widget Sliding Panels';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Sliding Panels');
    
    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function () {
        var panels = [];
        var itemEls = $('#wdg_slpn_items_list .wdg-slpn-item');
        
        for (var i = 0; i < itemEls.length; i++) {
            var ii = $(itemEls[i]).data('ii');
            var uid = 'slpn_' + ii;
            
            panels.push({
                image:              $('#wdg_slpn_img_' + uid).val(),
                panel_title:        $('#wdg_slpn_ptitle_' + uid).val(),
                subtitle:           $('#wdg_slpn_subtitle_' + uid).val(),
                panel_color_scheme: $('#wdg_slpn_pcs_' + uid).val(),
                btn_label:          $('#wdg_slpn_btnlabel_' + uid).val(),
                btn_url:            $('#wdg_slpn_url_' + uid).val(),
                btn_style:          $('#wdg_slpn_btnstyle_' + uid).val(),
                btn_new_tab:        $('#wdg_slpn_btntab_' + uid).is(':checked') ? '1' : '0'
            });
        }
        
        return {
            widget_id: 'sliding_panels',
            params: {
                eyebrow:         $('#wdg_slpn_eyebrow').val(),
                title:           $('#wdg_slpn_title').val(),
                description:     $('#wdg_slpn_description').val(),
                header_align:    $('#wdg_slpn_header_align').val(),
                color_scheme:    $('#wdg_slpn_color_scheme').val(),
                container_width: $('#wdg_slpn_container_width').val(),
                panels:          panels
            }
        };
    };
});
</script>