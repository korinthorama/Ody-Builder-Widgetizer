<?php defined('CMS') or die("This file cannot run this way!"); ?>

<?php
$q = "select pages.id as id, content_pages.title as title
      from pages, content_pages
      where content_pages.mainID=pages.id
      and content_pages.langID=" . $langID . "
      order by pages.sort, content_pages.title";
$_nsl_pages = $db->getRecords($q);
$_nsl_page_opts  = '<option value="">' . t("ή επιλέξτε υπάρχουσα σελίδα") . '</option>';
$_nsl_page_opts .= '<option value="homepage">' . t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ") . '</option>';
foreach ($_nsl_pages as $_nsl_row) {
    $_nsl_page_opts .= '<option value="' . $_nsl_row->id . '">' . htmlspecialchars($_nsl_row->title) . '</option>';
}
$_nsl_page_opts .= '<option value="divider">--------------------------------------</option>';
$_nsl_page_opts .= '<option value="nodeLinks_nsl">' . t("Link για εγγραφή ενότητας") . ' >></option>';
$_nsl_page_opts .= '<option value="divider">--------------------------------------</option>';
$_nsl_page_opts .= '<option value="fileLinks_nsl">' . t("Link για αρχείο") . ' >></option>';
?>

<style>
    .ody_builder_parameter { max-width: 500px !important; }
    .wdg-nsl-item { border: 1px solid #ccc; border-radius: 4px; margin-bottom: 6px; background: #f0f4f4; transition: box-shadow 0.3s ease; }
    .wdg-nsl-item-header { display: flex; align-items: center; gap: 8px; padding: 5px 8px; background: #002e3a; border-radius: 4px 4px 0 0; }
    .wdg-nsl-item-header span { color: white; font-size: 11px; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .wdg-nsl-item-body { padding: 8px; }
    .wdg-nsl-item-body .ody_builder_parameter { max-width: 100% !important; margin-bottom: 5px; }
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
    .wdg-nsl-move-buttons { display: flex; gap: 4px; margin-right: 4px; }
    .wdg-nsl-move-btn { background: transparent; border: none; color: white; cursor: pointer; font-size: 12px; padding: 2px 4px; border-radius: 3px; transition: all 0.2s; }
    .wdg-nsl-move-btn:hover { background: rgba(255, 255, 255, 0.2); }
    .wdg-nsl-move-btn:active { transform: scale(0.9); }
</style>

<!-- ══ ΓΕΝΙΚΑ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_nsl_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_nsl_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_nsl_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_nsl_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_nsl_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_nsl_description" class="listbox" value="">
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ═════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_nsl_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_nsl_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_nsl_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_nsl_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_nsl_alignment"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_nsl_alignment" class="listbox">
        <option value="left"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_nsl_show_numbers" value="1">
        <p><?php echo t("Εμφάνιση αριθμών"); ?></p>
    </div>
</div>
<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_nsl_show_dividers" value="1">
        <p><?php echo t("Εμφάνιση διαχωριστικών"); ?></p>
    </div>
</div>

<!-- ══ SERVICES ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Υπηρεσίες"); ?></div>
<div id="wdg_nsl_items_container" class="ody_builder_parameter">
    <div id="wdg_nsl_items_list"></div>
    <button type="button" id="wdg_nsl_add_item_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη Υπηρεσίας"); ?>
    </button>
</div>

<div id="wdg_nsl_popups_container" style="display:none;"></div>

<script>
jQuery(function ($) {
    var _p        = _saved_params || {};
    var _items    = _p['items']   || [];
    var _item_idx = 0;
    var _page_opts = <?php echo json_encode($_nsl_page_opts); ?>;

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    // ── Restore scalars ───────────────────────────────────────────────────────
    $('#wdg_nsl_eyebrow').val(pval('eyebrow'));
    $('#wdg_nsl_title').val(pval('title'));
    $('#wdg_nsl_description').val(pval('description'));
    $('#wdg_nsl_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_nsl_container_width').val(pval('container_width', 'xl'));
    $('#wdg_nsl_alignment').val(pval('alignment', 'center'));
    if (pval('show_numbers',  '1') === '1') $('#wdg_nsl_show_numbers').prop('checked', true);
    if (pval('show_dividers', '1') === '1') $('#wdg_nsl_show_dividers').prop('checked', true);

    // ── wdgNslSetLink ─────────────────────────────────────────────────────────
    window.wdgNslSetLink = function(val, urlFieldId, idx) {
        if (!val || val === 'divider') return;
        if (val === 'nodeLinks_nsl') { document.getElementById('wdg_nsl_node_popup_' + idx).click(); return; }
        if (val === 'fileLinks_nsl') { document.getElementById('wdg_nsl_file_popup_' + idx).click(); return; }
        var link = (val === 'homepage') ? 'index.php' : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
        $('#' + urlFieldId).val(link);
    };

    // ── Item display ──────────────────────────────────────────────────────────
    function updateItemDisplay($item, titleId) {
        var titleVal = $('#' + titleId).val();
        var itemNumber = $item.index() + 1;
        var displayText = '<?php echo t("Υπηρεσία"); ?> ' + itemNumber;
        if (titleVal && titleVal.trim() !== '') {
            displayText += ': ' + titleVal;
        }
        $item.find('.wdg-nsl-item-header span').text(displayText);
    }

    function renumberItems() {
        $('#wdg_nsl_items_list .wdg-nsl-item').each(function() {
            var $it = $(this);
            var ii  = $it.data('ii');
            var titleId = 'wdg_nsl_item_title_nsl_' + ii;
            updateItemDisplay($it, titleId);
        });
    }

    // ── Move functions ────────────────────────────────────────────────────────
    function moveItemUp($item, titleId) {
        var $prev = $item.prev('.wdg-nsl-item');
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
        var $next = $item.next('.wdg-nsl-item');
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
        var ii     = _item_idx++;
        var uid    = 'nsl_' + ii;
        var titleId = 'wdg_nsl_item_title_' + uid;
        var descId  = 'wdg_nsl_item_desc_'  + uid;
        var urlId   = 'wdg_nsl_url_'        + uid;
        var tabId   = 'wdg_nsl_newtab_'     + uid;
        var nodePop = 'wdg_nsl_node_popup_' + ii;
        var filePop = 'wdg_nsl_file_popup_' + ii;

        var $item = $('<div class="wdg-nsl-item" data-ii="' + ii + '">');
        $item.append(
            '<div class="wdg-nsl-item-header">' +
            '<div class="wdg-nsl-move-buttons">' +
            '<button type="button" class="wdg-nsl-move-btn wdg-nsl-move-up" title="<?php echo t("Μετακίνηση πάνω"); ?>">▲</button>' +
            '<button type="button" class="wdg-nsl-move-btn wdg-nsl-move-down" title="<?php echo t("Μετακίνηση κάτω"); ?>">▼</button>' +
            '</div>' +
            '<span><?php echo t("Υπηρεσία"); ?> ' + ($('#wdg_nsl_items_list .wdg-nsl-item').length + 1) + '</span>' +
            '<button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );

        var $body = $('<div class="wdg-nsl-item-body">');

        // Title
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?></label>' +
            '<input type="text" id="' + titleId + '" class="listbox" value="' + $('<div>').text(itemData.title || '').html() + '"></div>'
        );

        // Description
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label>' +
            '<textarea id="' + descId + '" class="listbox" rows="3" style="width:100%; box-sizing:border-box;">' + $('<div>').text(itemData.description || '').html() + '</textarea></div>'
        );

        // URL + selectLink
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Σύνδεσμος"); ?></label>' +
            '<input type="text" id="' + urlId + '" class="listbox" value="' + $('<div>').text(itemData.url || '').html() + '">' +
            '<select class="selectLink listbox" onchange="wdgNslSetLink($(this).val(), \'' + urlId + '\', ' + ii + '); $(this).val(\'\');">' +
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
        $('#wdg_nsl_items_list').append($item);

        // Node / File popups
        $('#wdg_nsl_popups_container').append(
            '<a id="' + nodePop + '" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]' + urlId + '">iFrame</a>' +
            '<a id="' + filePop + '" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]' + urlId + '">iFrame</a>'
        );
        new VenoBox({ selector: '#' + nodePop, fitView: true, ratio: 'full' });
        new VenoBox({ selector: '#' + filePop, fitView: true, ratio: 'full' });

        // Restore
        if (itemData.new_tab == '1') $('#' + tabId).prop('checked', true);

        // ── Real-time title update ────────────────────────────────────────────
        $('#' + titleId).on('input', function() {
            updateItemDisplay($item, titleId);
        });

        // ── Move buttons ──────────────────────────────────────────────────────
        $item.find('.wdg-nsl-move-up').on('click', function(e) {
            e.stopPropagation();
            moveItemUp($item, titleId);
        });
        $item.find('.wdg-nsl-move-down').on('click', function(e) {
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
    $('#wdg_nsl_add_item_btn').on('click', function() { addItem({}); });

    // ── Label ─────────────────────────────────────────────────────────────────
    label = 'Widget Numbered Service List';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Numbered Service List');

    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function() {
        var items = [];
        $('#wdg_nsl_items_list .wdg-nsl-item').each(function() {
            var ii  = $(this).data('ii');
            var uid = 'nsl_' + ii;
            items.push({
                title:       $('#wdg_nsl_item_title_' + uid).val(),
                description: $('#wdg_nsl_item_desc_'  + uid).val(),
                url:         $('#wdg_nsl_url_'         + uid).val(),
                new_tab:     $('#wdg_nsl_newtab_'      + uid).is(':checked') ? '1' : '0'
            });
        });
        return {
            widget_id: 'numbered_service_list',
            params: {
                eyebrow:         $('#wdg_nsl_eyebrow').val(),
                title:           $('#wdg_nsl_title').val(),
                description:     $('#wdg_nsl_description').val(),
                color_scheme:    $('#wdg_nsl_color_scheme').val(),
                container_width: $('#wdg_nsl_container_width').val(),
                alignment:       $('#wdg_nsl_alignment').val(),
                show_numbers:    $('#wdg_nsl_show_numbers').is(':checked')  ? '1' : '0',
                show_dividers:   $('#wdg_nsl_show_dividers').is(':checked') ? '1' : '0',
                items:           items
            }
        };
    };
});
</script>
