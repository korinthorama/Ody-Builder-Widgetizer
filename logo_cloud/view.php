<?php defined('CMS') or die("This file cannot run this way!"); ?>

<?php
$q = "select pages.id as id, content_pages.title as title
      from pages, content_pages
      where content_pages.mainID=pages.id
      and content_pages.langID=" . $langID . "
      order by pages.sort, content_pages.title";
$_lcld_pages = $db->getRecords($q);
$_lcld_page_opts  = '<option value="">' . t("ή επιλέξτε υπάρχουσα σελίδα") . '</option>';
$_lcld_page_opts .= '<option value="homepage">' . t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ") . '</option>';
foreach ($_lcld_pages as $_lcld_row) {
    $_lcld_page_opts .= '<option value="' . $_lcld_row->id . '">' . htmlspecialchars($_lcld_row->title) . '</option>';
}
$_lcld_page_opts .= '<option value="divider">--------------------------------------</option>';
$_lcld_page_opts .= '<option value="nodeLinks_lcld">' . t("Link για εγγραφή ενότητας") . ' >></option>';
$_lcld_page_opts .= '<option value="divider">--------------------------------------</option>';
$_lcld_page_opts .= '<option value="fileLinks_lcld">' . t("Link για αρχείο") . ' >></option>';
?>

<style>
    .ody_builder_parameter { max-width: 500px !important; }
    .wdg-lcld-item { border: 1px solid #ccc; border-radius: 4px; margin-bottom: 6px; background: #f0f4f4; overflow: hidden; }
    .wdg-lcld-item-header { display: flex; align-items: center; gap: 8px; padding: 5px 8px; background: #002e3a; border-radius: 4px 4px 0 0; cursor: move; }
    .wdg-lcld-item-header span { color: white; font-size: 11px; flex: 1; }
    .wdg-lcld-item-body { padding: 8px; overflow: hidden; }
    .wdg-lcld-item-body .listbox { width: 100%; box-sizing: border-box; }
    .wdg-lcld-item-body .ody_builder_parameter { max-width: 100% !important; margin-bottom: 5px; box-sizing: border-box; }
    .wdg-img-row { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
    .wdg-img-filename { font-size: 12px; color: #999; font-style: italic; word-break: break-all; flex: 1; }
    .wdg-img-preview { max-height: 40px; max-width: 100px; margin-top: 4px; border-radius: 3px; display: none; border: 1px solid #ddd; }
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
    <label for="wdg_lcld_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_lcld_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_lcld_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_lcld_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_lcld_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_lcld_description" class="listbox" value="">
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ═════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_lcld_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_lcld_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_lcld_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_lcld_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_lcld_layout"><?php echo t("Τύπος εμφάνισης"); ?></label>
    <select id="wdg_lcld_layout" class="listbox">
        <option value="grid"><?php echo t("Πλέγμα (Grid)");?></option>
        <option value="carousel"><?php echo t("Οριζόντια κύληση (Carousel)");?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_lcld_card_layout"><?php echo t("Εμφάνιση Logo"); ?></label>
    <select id="wdg_lcld_card_layout" class="listbox">
        <option value="flat">Flat</option>
        <option value="card">Box</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_lcld_carousel_cols"><?php echo t("Logos ανά σειρά"); ?></label>
    <select id="wdg_lcld_carousel_cols" class="listbox">
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_lcld_alignment"><?php echo t("Στοίχιση κειμένου"); ?></label>
    <select id="wdg_lcld_alignment" class="listbox">
        <option value="left"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_lcld_aspect_ratio">Aspect Ratio</label>
    <select id="wdg_lcld_aspect_ratio" class="listbox">
        <option value="auto">Auto</option>
        <option value="4 / 3">4:3</option>
        <option value="3 / 2">3:2</option>
        <option value="1 / 1">1:1</option>
    </select>
</div>

<!-- ══ LOGO ITEMS ════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title">Logos</div>
<div id="wdg_lcld_items_container" class="ody_builder_parameter">
    <div id="wdg_lcld_items_list"></div>
    <button type="button" id="wdg_lcld_add_item_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη"); ?> Logo
    </button>
</div>

<div id="wdg_lcld_popups_container" style="display:none;"></div>

<script>
jQuery(function ($) {
    var _p        = _saved_params || {};
    var _items    = _p['items']   || [];
    var _item_idx = 0;
    var _page_opts = <?php echo json_encode($_lcld_page_opts); ?>;

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    $('#wdg_lcld_eyebrow').val(pval('eyebrow'));
    $('#wdg_lcld_title').val(pval('title'));
    $('#wdg_lcld_description').val(pval('description'));
    $('#wdg_lcld_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_lcld_container_width').val(pval('container_width', 'xl'));
    $('#wdg_lcld_layout').val(pval('layout', 'grid'));
    $('#wdg_lcld_card_layout').val(pval('card_layout', 'flat'));
    $('#wdg_lcld_carousel_cols').val(pval('carousel_cols', '5'));
    $('#wdg_lcld_alignment').val(pval('alignment', 'left'));
    $('#wdg_lcld_aspect_ratio').val(pval('aspect_ratio', 'auto'));

    // ── VenoBox για mediabank ─────────────────────────────────────────────────
    window.venobox = new VenoBox({ selector: '.wdg-lcld-select-media', fitView: true, ratio: 'full' });

    // ── odyRecieveMediabank ────────────────────────────────────────────────────
    window.odyRecieveMediabank = function(file, id, ext, image_path, callerEl) {
        var targetId = $(callerEl || window._wdg_mediabank_caller).data('wdg-target');
        if (!targetId) return;
        var fullPath = image_path + id + '.' + ext;
        $('#' + targetId).val(fullPath);
        $('#' + targetId + '_display').text(file);
        $('#' + targetId + '_preview').attr('src', fullPath).show();
        $('#' + targetId + '_remove').css('visibility', 'visible');
    };

    // ── wdgLcldSetLink ─────────────────────────────────────────────────────────
    window.wdgLcldSetLink = function(val, urlFieldId, idx) {
        if (!val || val === 'divider') return;
        if (val === 'nodeLinks_lcld') { document.getElementById('wdg_lcld_node_popup_' + idx).click(); return; }
        if (val === 'fileLinks_lcld') { document.getElementById('wdg_lcld_file_popup_' + idx).click(); return; }
        var link = (val === 'homepage')
            ? 'index.php'
            : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
        $('#' + urlFieldId).val(link);
    };

    // ── Add Item ──────────────────────────────────────────────────────────────
    function addItem(itemData) {
        itemData = itemData || {};
        var ii      = _item_idx++;
        var uid     = 'lcld_' + ii;
        var imgId   = 'wdg_lcld_img_' + uid;
        var altId   = 'wdg_lcld_alt_' + uid;
        var urlId   = 'wdg_lcld_url_' + uid;
        var tabId   = 'wdg_lcld_newtab_' + uid;
        var mediaId = 'wdg_lcld_media_' + uid;
        var nodePop = 'wdg_lcld_node_popup_' + ii;
        var filePop = 'wdg_lcld_file_popup_' + ii;

        var $item = $('<div class="wdg-lcld-item" data-ii="' + ii + '">');
        $item.append('<div class="wdg-lcld-item-header"><span><?php echo t("Logo"); ?> ' + ($('#wdg_lcld_items_list .wdg-lcld-item').length + 1) + '</span><button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button></div>');

        var $body = $('<div class="wdg-lcld-item-body">');

        // Image picker
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Εικόνα Logo"); ?></label>' +
            '<div class="wdg-img-row">' +
            '<span id="' + imgId + '_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>' +
            '<a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>" id="' + mediaId + '"' +
            ' class="wdg-lcld-select-media ody_builder_content_action btn btn-success" data-vbtype="iframe" data-wdg-target="' + imgId + '"><?php echo t("Επιλογή"); ?></a>' +
            '<a href="javascript:void(0)" id="' + imgId + '_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"><?php echo t("Αφαίρεση"); ?></a>' +
            '</div>' +
            '<input type="hidden" id="' + imgId + '" value="">' +
            '<img id="' + imgId + '_preview" class="wdg-img-preview" src="" alt="">' +
            '</div>'
        );

        // Alt text
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Επωνυμία εταιρείας"); ?></label>' +
            '<input type="text" id="' + altId + '" class="listbox" value="' + $('<div>').text(itemData.alt || '').html() + '"></div>'
        );

        // URL + selectLink
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Σύνδεσμος"); ?></label>' +
            '<input type="text" id="' + urlId + '" class="listbox" value="' + $('<div>').text(itemData.url || '').html() + '">' +
            '<select class="selectLink listbox" onchange="wdgLcldSetLink($(this).val(), \'' + urlId + '\', ' + ii + '); $(this).val(\'\');">' +
                _page_opts +
            '</select></div>'
        );

        // New tab checkbox
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">' +
            '<input type="checkbox" id="' + tabId + '" value="1">' +
            '<p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>' +
            '</div></div>'
        );

        $item.append($body);
        $('#wdg_lcld_items_list').append($item);

        // Per-item VenoBox + caller tracker
        new VenoBox({ selector: '#' + mediaId, fitView: true, ratio: 'full' });
        $('#' + mediaId).on('click', function() { window._wdg_mediabank_caller = this; });

        // Remove button
        $('#' + imgId + '_remove').on('click', function() {
            $('#' + imgId).val('');
            $('#' + imgId + '_display').text('<?php echo t("Επιλέξτε..."); ?>');
            $('#' + imgId + '_preview').hide().attr('src', '');
            $(this).css('visibility', 'hidden');
        });

        // Node / File popups
        $('#wdg_lcld_popups_container').append(
            '<a id="' + nodePop + '" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]' + urlId + '">iFrame</a>' +
            '<a id="' + filePop + '" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]' + urlId + '">iFrame</a>'
        );
        new VenoBox({ selector: '#' + nodePop, fitView: true, ratio: 'full' });
        new VenoBox({ selector: '#' + filePop, fitView: true, ratio: 'full' });

        // Restore saved data
        if (itemData.image) {
            $('#' + imgId).val(itemData.image);
            $('#' + imgId + '_display').text(itemData.image.split('/').pop());
            $('#' + imgId + '_preview').attr('src', itemData.image).show();
            $('#' + imgId + '_remove').css('visibility', 'visible');
        }
        if (itemData.new_tab == '1') $('#' + tabId).prop('checked', true);

        $item.find('.wdg-item-remove').on('click', function() {
            $item.fadeOut(200, function() { $item.remove(); renumberItems(); });
        });

        if ($.fn.sortable) {
            $('#wdg_lcld_items_list').sortable({ handle: '.wdg-lcld-item-header', placeholder: 'block-placeholder', tolerance: 'pointer', stop: function() { renumberItems(); } });
        }
    }

    function renumberItems() {
        $('#wdg_lcld_items_list .wdg-lcld-item').each(function(idx) {
            $(this).find('.wdg-lcld-item-header span').text('<?php echo t("Logo"); ?> ' + (idx + 1));
        });
    }

    _items.forEach(function(item) { addItem(item); });
    $('#wdg_lcld_add_item_btn').on('click', function() { addItem({}); });

    // ── Label ─────────────────────────────────────────────────────────────────
    label = 'Widget Logo Cloud';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Logo Cloud');

    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function() {
        var items = [];
        $('#wdg_lcld_items_list .wdg-lcld-item').each(function() {
            var ii  = $(this).data('ii');
            var uid = 'lcld_' + ii;
            items.push({
                image:   $('#wdg_lcld_img_'    + uid).val(),
                alt:     $('#wdg_lcld_alt_'    + uid).val(),
                url:     $('#wdg_lcld_url_'    + uid).val(),
                new_tab: $('#wdg_lcld_newtab_' + uid).is(':checked') ? '1' : '0'
            });
        });
        return {
            widget_id: 'logo_cloud',
            params: {
                eyebrow:         $('#wdg_lcld_eyebrow').val(),
                title:           $('#wdg_lcld_title').val(),
                description:     $('#wdg_lcld_description').val(),
                color_scheme:    $('#wdg_lcld_color_scheme').val(),
                container_width: $('#wdg_lcld_container_width').val(),
                layout:          $('#wdg_lcld_layout').val(),
                card_layout:     $('#wdg_lcld_card_layout').val(),
                carousel_cols:   $('#wdg_lcld_carousel_cols').val(),
                alignment:       $('#wdg_lcld_alignment').val(),
                aspect_ratio:    $('#wdg_lcld_aspect_ratio').val(),
                items:           items
            }
        };
    };
});
</script>
