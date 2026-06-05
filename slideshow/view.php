<?php defined('CMS') or die("This file cannot run this way!"); ?>

<?php
$q = "select pages.id as id, content_pages.title as title
      from pages, content_pages
      where content_pages.mainID=pages.id
      and content_pages.langID=" . $langID . "
      order by pages.sort, content_pages.title";
$_slds_pages = $db->getRecords($q);
$_slds_page_opts = '<option value="">' . t("ή επιλέξτε υπάρχουσα σελίδα") . '</option>';
$_slds_page_opts .= '<option value="homepage">' . t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ") . '</option>';
foreach($_slds_pages as $_slds_row) {
    $_slds_page_opts .= '<option value="' . $_slds_row->id . '">' . htmlspecialchars($_slds_row->title) . '</option>';
}
$_slds_page_opts .= '<option value="divider">--------------------------------------</option>';
$_slds_page_opts .= '<option value="nodeLinks_slds">' . t("Link για εγγραφή ενότητας") . ' >></option>';
$_slds_page_opts .= '<option value="divider">--------------------------------------</option>';
$_slds_page_opts .= '<option value="fileLinks_slds">' . t("Link για αρχείο") . ' >></option>';
?>

<style>
    .ody_builder_parameter {
        max-width: 500px !important;
    }

    .wdg-slds-item {
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 6px;
        background: #f0f4f4;
    }

    .wdg-slds-item-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
        cursor: move;
    }

    .wdg-slds-item-header span {
        color: white;
        font-size: 11px;
        flex: 1;
    }

    .wdg-slds-item-body {
        padding: 8px;
    }

    .wdg-slds-item-body .ody_builder_parameter {
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
    <div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_slds_autoplay" value="1" checked>
        <p>Autoplay</p>
    </div>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_slds_autoplay_speed"><?php echo t("Ταχύτητα Autoplay"); ?></label>
    <select id="wdg_slds_autoplay_speed" class="listbox">
        <option value="3000">3 <?php echo t("δευτερόλεπτα"); ?></option>
        <option value="5000" selected>5 <?php echo t("δευτερόλεπτα"); ?></option>
        <option value="7000">7 <?php echo t("δευτερόλεπτα"); ?></option>
        <option value="10000">10 <?php echo t("δευτερόλεπτα"); ?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_slds_height"><?php echo t("Ύψος"); ?></label>
    <select id="wdg_slds_height" class="listbox">
        <option value="widget-height-auto"><?php echo t("Αυτόματο"); ?></option>
        <option value="widget-height-small"><?php echo t("Μικρό"); ?></option>
        <option value="widget-height-medium" selected><?php echo t("Μέτριο"); ?></option>
        <option value="widget-height-large"><?php echo t("Μεγάλο"); ?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_slds_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_slds_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>

<!-- ══ SLIDES ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title">Slides</div>

<div id="wdg_slds_items_container" class="ody_builder_parameter">
    <div id="wdg_slds_items_list"></div>
    <button type="button" id="wdg_slds_add_item_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη"); ?> Slide
    </button>
</div>

<div id="wdg_slds_popups_container" style="display:none;"></div>

<script>
jQuery(function ($) {
    var _p = _saved_params || {};
    var _slides = _p['slides'] || [];
    var _item_idx = 0;
    var _page_opts = <?php echo json_encode($_slds_page_opts); ?>;

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    // ── Restore scalars ────────────────────────────────────────────────────────
    if (pval('autoplay', '1') == '1') $('#wdg_slds_autoplay').prop('checked', true);
    else $('#wdg_slds_autoplay').prop('checked', false);
    
    $('#wdg_slds_autoplay_speed').val(pval('autoplay_speed', '5000'));
    $('#wdg_slds_height').val(pval('height', 'widget-height-medium'));
    $('#wdg_slds_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));

    var palette = [
        ["#000", "#444", "#666", "#999", "#ccc", "#eee", "#f3f3f3", "#fff"],
        ["#f00", "#f90", "#ff0", "#0f0", "#0ff", "#00f", "#90f", "#f0f"],
        ["#f4cccc", "#fce5cd", "#fff2cc", "#d9ead3", "#d0e0e3", "#cfe2f3", "#d9d2e9", "#ead1dc"],
        ["#ea9999", "#f9cb9c", "#ffe599", "#b6d7a8", "#a2c4c9", "#9fc5e8", "#b4a7d6", "#d5a6bd"],
        ["#e06666", "#f6b26b", "#ffd966", "#93c47d", "#76a5af", "#6fa8dc", "#8e7cc3", "#c27ba0"],
        ["#c00", "#e69138", "#f1c232", "#6aa84f", "#45818e", "#3d85c6", "#674ea7", "#a64d79"],
        ["#900", "#b45f06", "#bf9000", "#38761d", "#134f5c", "#0b5394", "#351c75", "#741b47"],
        ["#600", "#783f04", "#7f6000", "#274e13", "#0c343d", "#073763", "#20124d", "#4c1130"]
    ];

    // ── wdgSldsSetLink ─────────────────────────────────────────────────────────
    window.wdgSldsSetLink = function (val, urlFieldId, idx) {
        if (!val || val === 'divider') return;
        if (val === 'nodeLinks_slds') {
            window.venobox = new VenoBox({selector: '#wdg_slds_node_popup_' + idx, fitView: true, ratio: 'full'});
            document.getElementById('wdg_slds_node_popup_' + idx).click();
            return;
        }
        if (val === 'fileLinks_slds') {
            window.venobox = new VenoBox({selector: '#wdg_slds_file_popup_' + idx, fitView: true, ratio: 'full'});
            document.getElementById('wdg_slds_file_popup_' + idx).click();
            return;
        }
        var link = (val === 'homepage') ? 'index.php' : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
        $('#' + urlFieldId).val(link);
    };

    // ── VenoBox for image selector ─────────────────────────────────────────────
    window.venobox = new VenoBox({selector: '.wdg-slds-select-media', fitView: true, ratio: 'full'});
    
    window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
        var targetId = $(callerEl || window._wdg_mediabank_caller).data('wdg-target');
        if (!targetId) return;
        var fullPath = image_path + id + '.' + ext;
        $('#' + targetId).val(fullPath);
        $('#' + targetId + '_display').text(file);
        $('#' + targetId + '_preview').attr('src', fullPath).show();
        $('#' + targetId + '_remove').css('visibility', 'visible');
    };

    function addItem(data) {
        data = data || {};
        var ii = _item_idx++;
        var uid = 'slds_' + ii;
        var imgId = 'wdg_slds_img_' + uid;
        var urlId = 'wdg_slds_url_' + uid;
        var nodePop = 'wdg_slds_node_popup_' + ii;
        var filePop = 'wdg_slds_file_popup_' + ii;
        
        var $item = $('<div class="wdg-slds-item" data-ii="' + ii + '">');
        $item.append(
            '<div class="wdg-slds-item-header">' +
            '<span>Slide ' + ($('#wdg_slds_items_list .wdg-slds-item').length + 1) + '</span>' +
            '<button type="button" class="wdg-item-remove" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );
        
        var $body = $('<div class="wdg-slds-item-body">');
        
        // ── Image ──────────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Εικόνα"); ?></label>' +
            '<div class="wdg-img-row">' +
            '<span id="' + imgId + '_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>' +
            '<a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"' +
            ' class="wdg-slds-select-media ody_builder_content_action btn btn-success"' +
            ' data-vbtype="iframe" data-wdg-target="' + imgId + '"><?php echo t("Επιλογή"); ?></a>' +
            '<a href="javascript:void(0)" id="' + imgId + '_remove"' +
            ' class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"><?php echo t("Αφαίρεση"); ?></a>' +
            '</div>' +
            '<input type="hidden" id="' + imgId + '" value="">' +
            '<img id="' + imgId + '_preview" class="wdg-img-preview" src="" alt="">' +
            '</div>'
        );
        
        // ── Color scheme ───────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Χρωματική παλέτα του slide"); ?></label>' +
            '<select id="wdg_slds_cs_' + uid + '" class="listbox">' +
            '<option value="color-scheme-standard-primary">Standard Primary</option>' +
            '<option value="color-scheme-standard-secondary">Standard Secondary</option>' +
            '<option value="color-scheme-highlight-primary">Highlight Primary</option>' +
            '<option value="color-scheme-highlight-secondary">Highlight Secondary</option>' +
            '</select></div>'
        );
        
        // ── Overlay color ──────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Χρώμα μάσκας"); ?></label>' +
            '<input type="text" id="wdg_slds_ovcolor_' + uid + '" data-preferred-format="hex" class="listbox" value="#000000"></div>'
        );
        
        // ── Overlay opacity ────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Διαφάνεια μάσκας"); ?></label>' +
            '<input type="number" id="wdg_slds_ovopacity_' + uid + '" class="listbox" min="0" max="100" step="1" value="40" style="max-width:90px !important;"></div>'
        );
        
        // ── Content alignment ──────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Στοίχιση"); ?></label>' +
            '<select id="wdg_slds_align_' + uid + '" class="listbox">' +
            '<option value="left"><?php echo t("Αριστερά"); ?></option>' +
            '<option value="center" selected><?php echo t("Κέντρο"); ?></option>' +
            '</select></div>'
        );
        
        // ── Vertical alignment ─────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Κάθετη στοίχιση"); ?></label>' +
            '<select id="wdg_slds_valign_' + uid + '" class="listbox">' +
            '<option value="flex-start"><?php echo t("Πάνω"); ?></option>' +
            '<option value="center" selected><?php echo t("Κέντρο"); ?></option>' +
            '<option value="flex-end"><?php echo t("Κάτω"); ?></option>' +
            '</select></div>'
        );
        
        // ── Heading ────────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?></label>' +
            '<input type="text" id="wdg_slds_heading_' + uid + '" class="listbox" value="' + $('<div>').text(data.heading || '').html() + '"></div>'
        );
        
        // ── Heading size ───────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Μέγεθος τίτλου"); ?></label>' +
            '<select id="wdg_slds_hsize_' + uid + '" class="listbox">' +
            '<option value="t-lg"><?php echo t("Μεγάλο"); ?></option>' +
            '<option value="t-xl">XL</option>' +
            '<option value="t-2xl">2XL</option>' +
            '<option value="t-3xl">3XL</option>' +
            '<option value="t-4xl">4XL</option>' +
            '<option value="t-5xl" selected>5XL</option>' +
            '<option value="t-6xl">6XL</option>' +
            '<option value="t-7xl">7XL</option>' +
            '<option value="t-8xl">8XL</option>' +
            '<option value="t-9xl">9XL</option>' +
            '</select></div>'
        );
        
        // ── Content (description) with [nl] decode ─────────────────────────────
        // Decode [nl] to \n for textarea display
        var descRaw = data.description || '';
        var descDecoded = descRaw.replace(/\[nl\]/g, '\n');
        
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label>' +
            '<textarea id="wdg_slds_desc_' + uid + '" class="listbox" rows="3">' + escapeForTextarea(descDecoded) + '</textarea></div>'
        );
        
        // ── Text size ──────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Μέγεθος κειμένου"); ?></label>' +
            '<select id="wdg_slds_tsize_' + uid + '" class="listbox">' +
            '<option value="t-sm"><?php echo t("Μικρό"); ?></option>' +
            '<option value="t-base"><?php echo t("Κανονικό"); ?></option>' +
            '<option value="t-lg" selected><?php echo t("Μεγάλο"); ?></option>' +
            '</select></div>'
        );
        
        // ── Muted text ─────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">' +
            '<input type="checkbox" id="wdg_slds_muted_' + uid + '" value="1">' +
            '<p><?php echo t("Υποτονισμένο κείμενο"); ?></p>' +
            '</div></div>'
        );
        
        // ── Button label ───────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Κείμενο Κουμπιού"); ?></label>' +
            '<input type="text" id="wdg_slds_btnlabel_' + uid + '" class="listbox" value="' + $('<div>').text(data.btn_label || '').html() + '"></div>'
        );
        
        // ── Button URL ─────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label>Link</label>' +
            '<input type="text" id="' + urlId + '" class="listbox" value="' + $('<div>').text(data.btn_url || '').html() + '" placeholder="https://">' +
            '<select class="selectLink listbox" onchange="wdgSldsSetLink($(this).val(), \'' + urlId + '\', ' + ii + '); $(this).val(\'\');">' +
            _page_opts +
            '</select></div>'
        );
        
        // ── Button style ───────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Εμφάνιση κουμπιού"); ?></label>' +
            '<select id="wdg_slds_btnstyle_' + uid + '" class="listbox">' +
            '<option value="widget-button-primary" selected>Primary</option>' +
            '<option value="widget-button-secondary">Secondary</option>' +
            '<option value="widget-button-outline">Outline</option>' +
            '</select></div>'
        );
        
        // ── Button size ────────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Μέγεθος Κουμπιού"); ?></label>' +
            '<select id="wdg_slds_btnsize_' + uid + '" class="listbox">' +
            '<option value=""><?php echo t("Μικρό"); ?></option>' +
            '<option value="widget-button-medium" selected><?php echo t("Μέτριο"); ?></option>' +
            '<option value="widget-button-large"><?php echo t("Μεγάλο"); ?></option>' +
            '<option value="widget-button-xlarge"><?php echo t("Τεράστιο"); ?></option>' +
            '</select></div>'
        );
        
        // ── Button new tab ─────────────────────────────────────────────────────
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">' +
            '<input type="checkbox" id="wdg_slds_btntab_' + uid + '" value="1">' +
            '<p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>' +
            '</div></div>'
        );
        
        $item.append($body);
        $('#wdg_slds_items_list').append($item);
        
        // ── Node / File popups ─────────────────────────────────────────────────
        $('#wdg_slds_popups_container').append(
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
        
        // ── Restore overlay color ──────────────────────────────────────────────
        var _ovColor = data.overlay_color ? data.overlay_color.replace('[id]', '#') : '#000000';
        $('#wdg_slds_ovcolor_' + uid).val(_ovColor).spectrum({
            showInput: true, showPalette: true, showAlpha: false,
            palette: palette, preferredFormat: 'hex'
        });
        
        // ── VenoBox for image picker (reinit after append) ─────────────────────
        $('.wdg-slds-select-media').off('click').on('click', function () {
            window._wdg_mediabank_caller = this;
        });
        window.venobox = new VenoBox({selector: '.wdg-slds-select-media', fitView: true, ratio: 'full'});
        
        // ── Restore other values ───────────────────────────────────────────────
        if (data.color_scheme) $('#wdg_slds_cs_' + uid).val(data.color_scheme);
        if (data.overlay_opacity !== undefined) $('#wdg_slds_ovopacity_' + uid).val(data.overlay_opacity);
        if (data.valign) $('#wdg_slds_valign_' + uid).val(data.valign);
        if (data.align) $('#wdg_slds_align_' + uid).val(data.align);
        if (data.heading_size) $('#wdg_slds_hsize_' + uid).val(data.heading_size);
        if (data.text_size) $('#wdg_slds_tsize_' + uid).val(data.text_size);
        if (data.muted_text == '1') $('#wdg_slds_muted_' + uid).prop('checked', true);
        if (data.btn_style) $('#wdg_slds_btnstyle_' + uid).val(data.btn_style);
        if (data.btn_size) $('#wdg_slds_btnsize_' + uid).val(data.btn_size);
        if (data.btn_new_tab == '1') $('#wdg_slds_btntab_' + uid).prop('checked', true);
        
        // ── Remove image button event listener ─────────────────────────────────
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
        
        // ── Sortable ───────────────────────────────────────────────────────────
        if ($.fn.sortable) {
            $('#wdg_slds_items_list').sortable({
                handle: '.wdg-slds-item-header',
                placeholder: 'block-placeholder',
                tolerance: 'pointer',
                stop: function () {
                    renumberItems();
                }
            });
        }
    }
    
    // Helper function for escaping textarea content
    function escapeForTextarea(str) {
        if (!str) return '';
        return str.replace(/&/g, '&amp;')
                  .replace(/</g, '&lt;')
                  .replace(/>/g, '&gt;');
    }

    function renumberItems() {
        var items = $('#wdg_slds_items_list .wdg-slds-item');
        for (var i = 0; i < items.length; i++) {
            $(items[i]).find('.wdg-slds-item-header span').text('Slide ' + (i + 1));
        }
    }

    // ── Restore slides ─────────────────────────────────────────────────────────
    for (var i = 0; i < _slides.length; i++) {
        addItem(_slides[i]);
    }
    
    $('#wdg_slds_add_item_btn').on('click', function () {
        addItem({});
    });
    
    // ── Label ─────────────────────────────────────────────────────────────────
    var label = 'Widget Slideshow';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Slideshow');
    
    // ── get_block_data (save) ─────────────────────────────────────────────────
    window.get_block_data = function () {
        var slides = [];
        var itemEls = $('#wdg_slds_items_list .wdg-slds-item');
        
        for (var i = 0; i < itemEls.length; i++) {
            var ii = $(itemEls[i]).data('ii');
            var uid = 'slds_' + ii;
            var contentVal = $('#wdg_slds_desc_' + uid).val();
            
            var slideObj = {
                image:           $('#wdg_slds_img_' + uid).val(),
                color_scheme:    $('#wdg_slds_cs_' + uid).val(),
                overlay_color:   $('#wdg_slds_ovcolor_' + uid).val().replace('#', '[id]'),
                overlay_opacity: $('#wdg_slds_ovopacity_' + uid).val(),
                valign:          $('#wdg_slds_valign_' + uid).val(),
                align:           $('#wdg_slds_align_' + uid).val(),
                heading:         $('#wdg_slds_heading_' + uid).val(),
                heading_size:    $('#wdg_slds_hsize_' + uid).val(),
                text_size:       $('#wdg_slds_tsize_' + uid).val(),
                muted_text:      $('#wdg_slds_muted_' + uid).is(':checked') ? '1' : '0',
                btn_label:       $('#wdg_slds_btnlabel_' + uid).val(),
                btn_url:         $('#wdg_slds_url_' + uid).val(),
                btn_style:       $('#wdg_slds_btnstyle_' + uid).val(),
                btn_size:        $('#wdg_slds_btnsize_' + uid).val(),
                btn_new_tab:     $('#wdg_slds_btntab_' + uid).is(':checked') ? '1' : '0'
            };
            
            // Encode newlines to [nl] (NO base64)
            if (contentVal) {
                slideObj.description = contentVal.replace(/\n/g, '[nl]');
            }
            
            slides.push(slideObj);
        }
        
        return {
            widget_id: 'slideshow',
            params: {
                autoplay:       $('#wdg_slds_autoplay').is(':checked') ? '1' : '0',
                autoplay_speed: $('#wdg_slds_autoplay_speed').val(),
                height:         $('#wdg_slds_height').val(),
                color_scheme:   $('#wdg_slds_color_scheme').val(),
                slides:         slides
            }
        };
    };
});
</script>