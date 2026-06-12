<?php defined('CMS') or die("This file cannot run this way!"); ?>

<?php
$q = "select pages.id as id, content_pages.title as title
      from pages, content_pages
      where content_pages.mainID=pages.id
      and content_pages.langID=" . $langID . "
      order by pages.sort, content_pages.title";
$_psc_pages = $db->getRecords($q);
$_psc_page_opts  = '<option value="">' . t("ή επιλέξτε υπάρχουσα σελίδα") . '</option>';
$_psc_page_opts .= '<option value="homepage">' . t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ") . '</option>';
foreach ($_psc_pages as $_psc_row) {
    $_psc_page_opts .= '<option value="' . $_psc_row->id . '">' . htmlspecialchars($_psc_row->title) . '</option>';
}
$_psc_page_opts .= '<option value="divider">--------------------------------------</option>';
$_psc_page_opts .= '<option value="nodeLinks_psc">' . t("Link για εγγραφή ενότητας") . ' >></option>';
$_psc_page_opts .= '<option value="divider">--------------------------------------</option>';
$_psc_page_opts .= '<option value="fileLinks_psc">' . t("Link για αρχείο") . ' >></option>';
?>

<style>
    .ody_builder_parameter { max-width: 500px !important; }
    .wdg-psc-item { border: 1px solid #ccc; border-radius: 4px; margin-bottom: 6px; background: #f0f4f4; transition: box-shadow 0.3s ease; }
    .wdg-psc-item-header { display: flex; align-items: center; gap: 8px; padding: 5px 8px; background: #002e3a; border-radius: 4px 4px 0 0; }
    .wdg-psc-item-header span { color: white; font-size: 11px; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .wdg-psc-item-body { padding: 8px; }
    .wdg-psc-item-body .ody_builder_parameter { max-width: 100% !important; margin-bottom: 5px; }
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

    /* ── Βελάκια μετακίνησης ── */
    .wdg-psc-move-buttons { display: flex; gap: 4px; margin-right: 4px; }
    .wdg-psc-move-btn { background: transparent; border: none; color: white; cursor: pointer; font-size: 12px; padding: 2px 4px; border-radius: 3px; transition: all 0.2s; }
    .wdg-psc-move-btn:hover { background: rgba(255, 255, 255, 0.2); }
    .wdg-psc-move-btn:active { transform: scale(0.9); }
</style>

<!-- ══ ΓΕΝΙΚΑ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_psc_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_psc_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_psc_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_psc_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_psc_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_psc_description" class="listbox" value="">
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ═════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_psc_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_psc_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_psc_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_psc_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_psc_header_alignment"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_psc_header_alignment" class="listbox">
        <option value="left"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_psc_layout"><?php echo t("Τύπος εμφάνισης"); ?></label>
    <select id="wdg_psc_layout" class="listbox">
        <option value="grid"><?php echo t("Πλέγμα (Grid)");?></option>
        <option value="carousel"><?php echo t("Οριζόντια κύληση (Carousel)");?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_psc_columns"><?php echo t("Στήλες"); ?></label>
    <select id="wdg_psc_columns" class="listbox">
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_psc_aspect_ratio">Aspect Ratio</label>
    <select id="wdg_psc_aspect_ratio" class="listbox">
        <option value="auto">Auto</option>
        <option value="contain">Contain</option>
        <option value="1 / 1">1:1</option>
        <option value="4 / 3">4:3</option>
        <option value="3 / 2">3:2</option>
        <option value="3 / 4">3:4</option>
        <option value="16 / 9">16:9</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_psc_text_display"><?php echo t("Συνθήκη εμφάνισης"); ?></label>
    <select id="wdg_psc_text_display" class="listbox">
        <option value="on_hover">On Hover</option>
        <option value="always">Always</option>
    </select>
</div>

<!-- ══ PROJECTS ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title">Projects</div>
<div id="wdg_psc_items_container" class="ody_builder_parameter">
    <div id="wdg_psc_items_list"></div>
    <button type="button" id="wdg_psc_add_item_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη"); ?> Project
    </button>
</div>

<div id="wdg_psc_popups_container" style="display:none;"></div>

<script>
jQuery(function ($) {
    var _p        = _saved_params || {};
    var _items    = _p['items']   || [];
    var _item_idx = 0;
    var _page_opts = <?php echo json_encode($_psc_page_opts); ?>;

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    // ── Restore scalars ───────────────────────────────────────────────────────
    $('#wdg_psc_eyebrow').val(pval('eyebrow'));
    $('#wdg_psc_title').val(pval('title'));
    $('#wdg_psc_description').val(pval('description'));
    $('#wdg_psc_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_psc_container_width').val(pval('container_width', 'xl'));
    $('#wdg_psc_header_alignment').val(pval('header_alignment', 'center'));
    $('#wdg_psc_layout').val(pval('layout', 'grid'));
    $('#wdg_psc_columns').val(pval('columns', '3'));
    $('#wdg_psc_aspect_ratio').val(pval('aspect_ratio', '4 / 3'));
    $('#wdg_psc_text_display').val(pval('text_display', 'on_hover'));

    // ── VenoBox shared class ──────────────────────────────────────────────────
    window.venobox = new VenoBox({ selector: '.wdg-psc-select-media', fitView: true, ratio: 'full' });

    // ── odyRecieveMediabank ───────────────────────────────────────────────────
    window.odyRecieveMediabank = function(file, id, ext, image_path, callerEl) {
        var targetId = $(callerEl || window._wdg_mediabank_caller).data('wdg-target');
        if (!targetId) return;
        var fullPath = image_path + id + '.' + ext;
        $('#' + targetId).val(fullPath);
        $('#' + targetId + '_display').text(file);
        $('#' + targetId + '_preview').attr('src', fullPath).show();
        $('#' + targetId + '_remove').css('visibility', 'visible');
    };

    // ── wdgPscSetLink ─────────────────────────────────────────────────────────
    window.wdgPscSetLink = function(val, urlFieldId, idx) {
        if (!val || val === 'divider') return;
        if (val === 'nodeLinks_psc') { document.getElementById('wdg_psc_node_popup_' + idx).click(); return; }
        if (val === 'fileLinks_psc') { document.getElementById('wdg_psc_file_popup_' + idx).click(); return; }
        var link = (val === 'homepage') ? 'index.php' : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
        $('#' + urlFieldId).val(link);
    };

    // ── Item display ──────────────────────────────────────────────────────────
    function updateItemDisplay($item, titleId) {
        var titleVal = $('#' + titleId).val();
        var itemNumber = $item.index() + 1;
        var displayText = 'Project ' + itemNumber;
        if (titleVal && titleVal.trim() !== '') {
            displayText += ': ' + titleVal;
        }
        $item.find('.wdg-psc-item-header span').text(displayText);
    }

    function renumberItems() {
        $('#wdg_psc_items_list .wdg-psc-item').each(function() {
            var $it = $(this);
            var ii  = $it.data('ii');
            var titleId = 'wdg_psc_title_psc_' + ii;
            updateItemDisplay($it, titleId);
        });
    }

    // ── Move functions ────────────────────────────────────────────────────────
    function moveItemUp($item, titleId) {
        var $prev = $item.prev('.wdg-psc-item');
        if ($prev.length) {
            $item.slideUp(1, function() {
                $item.insertBefore($prev);
                $item.slideDown(1, function() {
                    renumberItems();
                    $('html, body').animate({ scrollTop: $item.offset().top - 100 }, 300);
                    $item.css('box-shadow', '0 0 0 2px #fbbf24');
                    setTimeout(function() { $item.css('box-shadow', ''); }, 100);
                });
            });
        }
    }

    function moveItemDown($item, titleId) {
        var $next = $item.next('.wdg-psc-item');
        if ($next.length) {
            $item.slideUp(1, function() {
                $item.insertAfter($next);
                $item.slideDown(1, function() {
                    renumberItems();
                    $('html, body').animate({ scrollTop: $item.offset().top - 100 }, 300);
                    $item.css('box-shadow', '0 0 0 2px #fbbf24');
                    setTimeout(function() { $item.css('box-shadow', ''); }, 100);
                });
            });
        }
    }

    // ── Add Item ──────────────────────────────────────────────────────────────
    function addItem(itemData) {
        itemData = itemData || {};
        var ii      = _item_idx++;
        var uid     = 'psc_' + ii;
        var imgId   = 'wdg_psc_img_'   + uid;
        var mediaId = 'wdg_psc_media_' + uid;
        var urlId   = 'wdg_psc_url_'   + uid;
        var tabId   = 'wdg_psc_newtab_' + uid;
        var titleId = 'wdg_psc_title_' + uid;
        var nodePop = 'wdg_psc_node_popup_' + ii;
        var filePop = 'wdg_psc_file_popup_' + ii;

        var $item = $('<div class="wdg-psc-item" data-ii="' + ii + '">');
        $item.append(
            '<div class="wdg-psc-item-header">' +
            '<div class="wdg-psc-move-buttons">' +
            '<button type="button" class="wdg-psc-move-btn wdg-psc-move-up" title="<?php echo t("Μετακίνηση πάνω"); ?>">▲</button>' +
            '<button type="button" class="wdg-psc-move-btn wdg-psc-move-down" title="<?php echo t("Μετακίνηση κάτω"); ?>">▼</button>' +
            '</div>' +
            '<span>Project ' + ($('#wdg_psc_items_list .wdg-psc-item').length + 1) + '</span>' +
            '<button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );

        var $body = $('<div class="wdg-psc-item-body">');

        // Image picker
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Εικόνα"); ?></label>' +
            '<div class="wdg-img-row">' +
            '<span id="' + imgId + '_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>' +
            '<a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>" id="' + mediaId + '"' +
            ' class="wdg-psc-select-media ody_builder_content_action btn btn-success" data-vbtype="iframe" data-wdg-target="' + imgId + '"><?php echo t("Επιλογή"); ?></a>' +
            '<a href="javascript:void(0)" id="' + imgId + '_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"><?php echo t("Αφαίρεση"); ?></a>' +
            '</div>' +
            '<input type="hidden" id="' + imgId + '" value="">' +
            '<img id="' + imgId + '_preview" class="wdg-img-preview" src="" alt="">' +
            '</div>'
        );

        // Title
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?></label>' +
            '<input type="text" id="' + titleId + '" class="listbox" value="' + $('<div>').text(itemData.title || '').html() + '"></div>'
        );

        // Description
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label>' +
            '<input type="text" id="wdg_psc_desc_' + uid + '" class="listbox" value="' + $('<div>').text(itemData.description || '').html() + '"></div>'
        );

        // URL + selectLink
        $body.append(
            '<div class="ody_builder_parameter"><label>Link</label>' +
            '<input type="text" id="' + urlId + '" class="listbox" value="' + $('<div>').text(itemData.url || '').html() + '">' +
            '<select class="selectLink listbox" onchange="wdgPscSetLink($(this).val(), \'' + urlId + '\', ' + ii + '); $(this).val(\'\');">' +
            _page_opts +
            '</select></div>'
        );

        // New tab
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">' +
            '<input type="checkbox" id="' + tabId + '" value="1">' +
            '<p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>' +
            '</div></div>'
        );

        $item.append($body);
        $('#wdg_psc_items_list').append($item);

        // Per-item VenoBox + caller tracker
        new VenoBox({ selector: '#' + mediaId, fitView: true, ratio: 'full' });
        $('#' + mediaId).on('click', function() { window._wdg_mediabank_caller = this; });

        // Remove image button
        $('#' + imgId + '_remove').on('click', function() {
            $('#' + imgId).val('');
            $('#' + imgId + '_display').text('<?php echo t("Επιλέξτε..."); ?>');
            $('#' + imgId + '_preview').hide().attr('src', '');
            $(this).css('visibility', 'hidden');
        });

        // Node / File popups
        $('#wdg_psc_popups_container').append(
            '<a id="' + nodePop + '" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]' + urlId + '">iFrame</a>' +
            '<a id="' + filePop + '" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]' + urlId + '">iFrame</a>'
        );
        new VenoBox({ selector: '#' + nodePop, fitView: true, ratio: 'full' });
        new VenoBox({ selector: '#' + filePop, fitView: true, ratio: 'full' });

        // Restore
        if (itemData.image) {
            $('#' + imgId).val(itemData.image);
            $('#' + imgId + '_display').text(itemData.image.split('/').pop());
            $('#' + imgId + '_preview').attr('src', itemData.image).show();
            $('#' + imgId + '_remove').css('visibility', 'visible');
        }
        if (itemData.new_tab == '1') $('#' + tabId).prop('checked', true);

        // ── Real-time title update ────────────────────────────────────────────
        $('#' + titleId).on('input', function() {
            updateItemDisplay($item, titleId);
        });

        // ── Move buttons ──────────────────────────────────────────────────────
        $item.find('.wdg-psc-move-up').on('click', function(e) {
            e.stopPropagation();
            moveItemUp($item, titleId);
        });
        $item.find('.wdg-psc-move-down').on('click', function(e) {
            e.stopPropagation();
            moveItemDown($item, titleId);
        });

        $item.find('.wdg-item-remove').on('click', function() {
            $item.fadeOut(200, function() {
                $item.remove();
                renumberItems();
            });
        });

        updateItemDisplay($item, titleId);
    }

    _items.forEach(function(item) { addItem(item); });
    $('#wdg_psc_add_item_btn').on('click', function() { addItem({}); });

    // ── Label ─────────────────────────────────────────────────────────────────
    label = 'Widget Project Showcase';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Project Showcase');

    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function() {
        var items = [];
        $('#wdg_psc_items_list .wdg-psc-item').each(function() {
            var ii  = $(this).data('ii');
            var uid = 'psc_' + ii;
            items.push({
                image:       $('#wdg_psc_img_'    + uid).val(),
                title:       $('#wdg_psc_title_'  + uid).val(),
                description: $('#wdg_psc_desc_'   + uid).val(),
                url:         $('#wdg_psc_url_'    + uid).val(),
                new_tab:     $('#wdg_psc_newtab_' + uid).is(':checked') ? '1' : '0'
            });
        });
        return {
            widget_id: 'project_showcase',
            params: {
                eyebrow:          $('#wdg_psc_eyebrow').val(),
                title:            $('#wdg_psc_title').val(),
                description:      $('#wdg_psc_description').val(),
                color_scheme:     $('#wdg_psc_color_scheme').val(),
                container_width:  $('#wdg_psc_container_width').val(),
                header_alignment: $('#wdg_psc_header_alignment').val(),
                layout:           $('#wdg_psc_layout').val(),
                columns:          $('#wdg_psc_columns').val(),
                aspect_ratio:     $('#wdg_psc_aspect_ratio').val(),
                text_display:     $('#wdg_psc_text_display').val(),
                items:            items
            }
        };
    };
});
</script>
