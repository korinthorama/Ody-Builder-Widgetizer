<?php
/*
 * Widgetizer — Event List Widget — view.php
 * Prefix: el
 */
$q = "select pages.id as id, content_pages.title as title from pages, content_pages where content_pages.mainID=pages.id and content_pages.langID=" . $langID . " order by pages.sort, content_pages.title";
$_pages = $db->getRecords($q);
?>
<style>
    .ody_builder_parameter { max-width: 500px !important; }
    .selectLink { border: 2px solid #002e3a !important; height: auto !important; padding: 2px 10px !important; font-size: .8em !important; background-color: #002e3a; color: white; max-width: 400px !important; width: 100% !important; margin: 2px 0 5px; }
    .wdg-el-item { border: 1px solid #ddd; border-radius: 4px; margin-bottom: 8px; background: #f9f9f9; }
    .wdg-el-item-header { display: flex; align-items: center; gap: 8px; padding: 6px 8px; background: #002e3a; border-radius: 4px 4px 0 0; cursor: move; }
    .wdg-el-item-header span { color: white; font-size: 12px; flex: 1; }
    .wdg-el-item-body { padding: 8px; }
    .wdg-el-item-body .ody_builder_parameter { max-width: 450px !important; margin-bottom: 6px; }
    .wdg-el-add-btn { display: inline-block; padding: 6px 16px; background: #002e3a; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; margin-top: 4px; }
    .wdg-el-add-btn:hover { background: #004a5c; }
</style>

<!-- ══ ΓΕΝΙΚΑ ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>
<div class="ody_builder_parameter"><label for="wdg_el_eyebrow">Eyebrow</label><input type="text" id="wdg_el_eyebrow" class="listbox" value=""></div>
<div class="ody_builder_parameter"><label for="wdg_el_title"><?php echo t("Τίτλος"); ?></label><input type="text" id="wdg_el_title" class="listbox" value=""></div>
<div class="ody_builder_parameter"><label for="wdg_el_description"><?php echo t("Υπότιτλος"); ?></label><input type="text" id="wdg_el_description" class="listbox" value=""></div>
<div class="ody_builder_parameter"><label for="wdg_el_header_align"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label><select id="wdg_el_header_align" class="listbox"><option value="start"><?php echo t("Αριστερά"); ?></option><option value="center"><?php echo t("Κέντρο"); ?></option></select></div>

<!-- ══ ΕΜΦΑΝΙΣΗ ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>
<div class="ody_builder_parameter"><label for="wdg_el_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label><select id="wdg_el_color_scheme" class="listbox"><option value="color-scheme-standard-primary">Standard Primary</option><option value="color-scheme-standard-secondary">Standard Secondary</option><option value="color-scheme-highlight-primary">Highlight Primary</option><option value="color-scheme-highlight-secondary">Highlight Secondary</option></select></div>
<div class="ody_builder_parameter"><label for="wdg_el_container_width"><?php echo t("Πλάτος Container"); ?></label><select id="wdg_el_container_width" class="listbox"><option value="full">Full Width</option><option value="xl">X-Large (1420px)</option><option value="lg">Large (1200px)</option><option value="md">Medium (960px)</option><option value="sm">Small (760px)</option></select></div>

<!-- ══ EVENTS ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title">📅 Events</div>
<div id="wdg_el_items" style="max-width: 450px;"></div>
<button type="button" class="ody_builder_content_action btn btn-success wdg-el-add-btn" id="wdg_el_add_btn">+ <?php echo t("Προσθήκη"); ?> event</button>

<?php
$_page_opts_html = '<option value="">' . t("ή επιλέξτε υπάρχουσα σελίδα") . '</option>';
$_page_opts_html .= '<option value="homepage">' . t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ") . '</option>';
foreach ($_pages as $row) { $_page_opts_html .= '<option value="' . $row->id . '">' . htmlspecialchars($row->title) . '</option>'; }
$_page_opts_html .= '<option value="divider">--------------------------------------</option>';
$_page_opts_html .= '<option value="nodeLinks_el">' . t("Link για εγγραφή ενότητας") . ' >></option>';
$_page_opts_html .= '<option value="divider">--------------------------------------</option>';
$_page_opts_html .= '<option value="fileLinks_el">' . t("Link για αρχείο") . ' >></option>';
?>

<script>
jQuery(function ($) {
    var _p = _saved_params || {};
    var _items = _p['items'] || [];

    function pval(key, def) { return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : ''); }

    $('#wdg_el_eyebrow').val(pval('eyebrow'));
    $('#wdg_el_title').val(pval('title'));
    $('#wdg_el_description').val(pval('description'));
    $('#wdg_el_header_align').val(pval('header_align', 'start'));
    $('#wdg_el_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_el_container_width').val(pval('container_width', 'xl'));

    var _page_opts = <?php echo json_encode($_page_opts_html); ?>;
    var _item_idx = 0;

    function addItem(data) {
        data = data || {};
        var idx = _item_idx++;
        var urlId = 'wdg_el_url_' + idx;
        var nodePopupId = 'wdg_el_node_' + idx;
        var filePopupId = 'wdg_el_file_' + idx;

        var $item = $('<div class="wdg-el-item" data-idx="' + idx + '">');
        $item.append('<div class="wdg-el-item-header"><span>Event ' + ($('#wdg_el_items .wdg-el-item').length + 1) + '</span><button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button></div>');
        var $body = $('<div class="wdg-el-item-body">');

        $body.append('<div class="ody_builder_parameter"><label><?php echo t("Μέρα"); ?></label><input type="number" class="listbox wdg-el-day" min="1" max="31" step="1" style="max-width:80px;" value="' + $('<div>').text(data.day||'1').html() + '"></div>');
        $body.append('<div class="ody_builder_parameter"><label><?php echo t("Μήνας"); ?></label><select class="listbox wdg-el-month" style="max-width:150px;">' +
            '<option value="<?php echo t("Ιαν"); ?>"><?php echo t("Ιανουάριος"); ?></option>' +
            '<option value="<?php echo t("Φεβ"); ?>"><?php echo t("Φεβρουάριος"); ?></option>' +
            '<option value="<?php echo t("Μαρ"); ?>"><?php echo t("Μάρτιος"); ?></option>' +
            '<option value="<?php echo t("Απρ"); ?>"><?php echo t("Απρίλιος"); ?></option>' +
            '<option value="<?php echo t("Μαι"); ?>"><?php echo t("Μάιος"); ?></option>' +
            '<option value="<?php echo t("Ιουν"); ?>"><?php echo t("Ιούνιος"); ?></option>' +
            '<option value="<?php echo t("Ιουλ"); ?>"><?php echo t("Ιούλιος"); ?></option>' +
            '<option value="<?php echo t("Αυγ"); ?>"><?php echo t("Αύγουστος"); ?></option>' +
            '<option value="<?php echo t("Σεπ"); ?>"><?php echo t("Σεπτέμβριος"); ?></option>' +
            '<option value="<?php echo t("Οκτ"); ?>"><?php echo t("Οκτώβριος"); ?></option>' +
            '<option value="<?php echo t("Νοε"); ?>"><?php echo t("Νοέμβριος"); ?></option>' +
            '<option value="<?php echo t("Δεκ"); ?>"><?php echo t("Δεκέμβριος"); ?></option>' +
            '</select></div>');
        $body.append('<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?> event</label><input type="text" class="listbox wdg-el-title" value="' + $('<div>').text(data.title||'').html() + '"></div>');
        $body.append('<div class="ody_builder_parameter"><label><?php echo t("Τοποθεσία / Ώρα"); ?></label><input type="text" class="listbox wdg-el-location" value="' + $('<div>').text(data.location||'').html() + '"></div>');
        $body.append('<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label><textarea class="listbox wdg-el-description" rows="2" style="resize:vertical;">' + $('<div>').text(data.description||'').html() + '</textarea></div>');
        $body.append('<div class="ody_builder_parameter"><label><?php echo t("Κείμενο κουμπιού"); ?></label><input type="text" class="listbox wdg-el-btn-label" value="' + $('<div>').text(data.btn_label||'').html() + '"></div>');
        $body.append('<div class="ody_builder_parameter"><label>Link</label><input type="text" id="' + urlId + '" class="listbox wdg-el-btn-url" value=""><select class="selectLink listbox" onchange="wdgElSetLink($(this).val(),\'' + urlId + '\',\'' + idx + '\'); $(this).val(\'\');">' + _page_opts + '</select></div>');
        $body.append('<div class="ody_builder_parameter"><div class="admin_checkbox_wrapper" style="margin: 0 0 10px;"><input type="checkbox" class="wdg-el-btn-new-tab" value="1"><p><?php echo t("Άνοιγμα σε νέο tab"); ?></p></div></div>');
        $body.append('<div class="ody_builder_parameter"><label><?php echo t("Εμφάνιση κουμπιού"); ?></label><select class="listbox wdg-el-btn-style"><option value="widget-button-primary">Primary</option><option value="widget-button-secondary">Secondary</option></select></div>');

        $item.append($body);
        $('#wdg_el_items').append($item);

        $item.find('.wdg-el-month').val(data.month || '<?php echo t("Ιαν"); ?>');

        $item.append('<a id="' + nodePopupId + '" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]' + urlId + '">iFrame</a><a id="' + filePopupId + '" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]' + urlId + '">iFrame</a>');
        new VenoBox({selector: '#' + nodePopupId, fitView: true, ratio: 'full'});
        new VenoBox({selector: '#' + filePopupId, fitView: true, ratio: 'full'});

        if (data.btn_url) $('#' + urlId).val(data.btn_url);
        if (data.btn_new_tab == '1') $item.find('.wdg-el-btn-new-tab').prop('checked', true);
        $item.find('.wdg-el-btn-style').val(data.btn_style || 'widget-button-secondary');
        $item.find('.wdg-item-remove').on('click', function() { $item.fadeOut(200, function() { $item.remove(); renumberItems(); }); });
    }

    function renumberItems() {
        $('#wdg_el_items .wdg-el-item').each(function(idx) {
            $(this).find('.wdg-el-item-header span').text('Event ' + (idx + 1));
        });
    }

    _items.forEach(function(item) { addItem(item); });
    $('#wdg_el_add_btn').on('click', function() { addItem({}); });

    if ($.fn.sortable) {
        $('#wdg_el_items').sortable({ handle: '.wdg-el-item-header', placeholder: 'block-placeholder', tolerance: 'pointer', stop: function() { renumberItems(); } });
    }

    window.wdgElSetLink = function(val, targetId, idx) {
        if (!val || val === 'divider') return;
        if (val === 'nodeLinks_el') { document.getElementById('wdg_el_node_' + idx).click(); return; }
        if (val === 'fileLinks_el') { document.getElementById('wdg_el_file_' + idx).click(); return; }
        var link = (val === 'homepage') ? 'index.php' : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
        $('#' + targetId).val(link);
    };

    label = 'Widget Event List';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Event List');

    window.get_block_data = function() {
        var items = [];
        $('#wdg_el_items .wdg-el-item').each(function() {
            var $it = $(this);
            var idx = $it.data('idx');
            items.push({
                day:         $it.find('.wdg-el-day').val(),
                month:       $it.find('.wdg-el-month').val(),
                title:       $it.find('.wdg-el-title').val(),
                location:    $it.find('.wdg-el-location').val(),
                description: $it.find('.wdg-el-description').val(),
                btn_label:   $it.find('.wdg-el-btn-label').val(),
                btn_url:     $('#wdg_el_url_' + idx).val(),
                btn_new_tab: $it.find('.wdg-el-btn-new-tab').is(':checked') ? '1' : '0',
                btn_style:   $it.find('.wdg-el-btn-style').val()
            });
        });
        return {
            widget_id: 'event_list',
            params: {
                eyebrow:         $('#wdg_el_eyebrow').val(),
                title:           $('#wdg_el_title').val(),
                description:     $('#wdg_el_description').val(),
                header_align:    $('#wdg_el_header_align').val(),
                color_scheme:    $('#wdg_el_color_scheme').val(),
                container_width: $('#wdg_el_container_width').val(),
                items:           items
            }
        };
    };
});
</script>
