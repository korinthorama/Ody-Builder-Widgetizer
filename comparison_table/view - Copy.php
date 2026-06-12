<?php
/*
 * Widgetizer — Comparison Table Widget — view.php
 *
 * Έχει πρόσβαση σε: $db, $langID, t(), _saved_params (JS)
 * Πρέπει να ορίσει: window.get_block_data(), label
 */
// Page list για link pickers
$q = "select pages.id as id, content_pages.title as title
      from pages, content_pages
      where content_pages.mainID=pages.id
      and content_pages.langID=" . $langID . "
      order by pages.sort, content_pages.title";
$_pages = $db->getRecords($q);
?>
<style>
    .ody_builder_parameter {
        max-width: 500px !important;
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

    /* ── Repeaters ── */
    .wdg-ct-col-item, .wdg-ct-row-item {
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 8px;
        background: #f9f9f9;
    }

    .wdg-ct-col-header, .wdg-ct-row-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
        cursor: move;
    }

    .wdg-ct-col-header {
        background: #1a4a5a;
    }

    .wdg-ct-row-header {
        background: #002e3a;
    }

    .wdg-ct-col-header span, .wdg-ct-row-header span {
        color: white;
        font-size: 12px;
        flex: 1;
    }

    .wdg-ct-col-body, .wdg-ct-row-body {
        padding: 8px;
    }

    .wdg-ct-col-body .ody_builder_parameter,
    .wdg-ct-row-body .ody_builder_parameter {
        max-width: 100% !important;
        margin-bottom: 6px;
    }

    .wdg-ct-add-btn {
        display: inline-block;
        padding: 6px 16px;
        background: #002e3a;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        margin-top: 4px;
        margin-bottom: 12px;
    }

    .wdg-ct-add-btn:hover {
        background: #004a5c;
    }
</style>
<!-- ══ ΓΕΝΙΚΑ ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_ct_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_ct_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_ct_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_ct_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_ct_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_ct_description" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_ct_features_label"><?php echo t("Ετικέτα Χαρακτηριστικών"); ?></label>
    <input type="text" id="wdg_ct_features_label" class="listbox" value="" placeholder="<?php echo t("Χαρακτηριστικά");?>">
</div>
<!-- ══ ΕΜΦΑΝΙΣΗ ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_ct_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_ct_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_ct_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_ct_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<!-- ══ COLUMNS ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Στήλες (Plans)"); ?></div>
<div id="wdg_ct_columns" style="max-width:100%;"></div>
<button type="button" class="wdg-ct-add-btn" id="wdg_ct_add_col_btn">+ <?php echo t("Προσθήκη στήλης"); ?></button>
<!-- ══ ROWS ══════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Σειρές (Χαρακτηριστικά)"); ?></div>
<div id="wdg_ct_rows" style="max-width:100%;"></div>
<button type="button" class="wdg-ct-add-btn" id="wdg_ct_add_row_btn">+ <?php echo t("Προσθήκη σειράς"); ?></button>
<?php
$_page_opts_html = '<option value="">' . t("ή επιλέξτε υπάρχουσα σελίδα") . '</option>';
$_page_opts_html .= '<option value="homepage">' . t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ") . '</option>';
foreach($_pages as $row) {
    $_page_opts_html .= '<option value="' . $row->id . '">' . htmlspecialchars($row->title) . '</option>';
}
$_page_opts_html .= '<option value="divider">--------------------------------------</option>';
$_page_opts_html .= '<option value="nodeLinks_ct">' . t("Link για εγγραφή ενότητας") . ' >></option>';
$_page_opts_html .= '<option value="divider">--------------------------------------</option>';
$_page_opts_html .= '<option value="fileLinks_ct">' . t("Link για αρχείο") . ' >></option>';
?>
<script>
    jQuery(function ($) {
        var _p = _saved_params || {};
        var _cols = _p['columns'] || [];
        var _rows = _p['rows'] || [];

        function pval(key, def) {
            return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
        }

        $('#wdg_ct_eyebrow').val(pval('eyebrow'));
        $('#wdg_ct_title').val(pval('title'));
        $('#wdg_ct_description').val(pval('description'));
        $('#wdg_ct_features_label').val(pval('features_label', 'Features'));
        $('#wdg_ct_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
        $('#wdg_ct_container_width').val(pval('container_width', 'xl'));
        var _page_opts = <?php echo json_encode($_page_opts_html); ?>;
        var _col_idx = 0;
        var _row_idx = 0;

        function addColumn(data) {
            data = data || {};
            var idx = _col_idx++;
            var urlId = 'wdg_ct_col_url_' + idx;
            var nodePopupId = 'wdg_ct_col_node_' + idx;
            var filePopupId = 'wdg_ct_col_file_' + idx;
            var $item = $('<div class="wdg-ct-col-item" data-idx="' + idx + '">');
            $item.append('<div class="wdg-ct-col-header"><span><?php echo t("Στήλη"); ?> ' + ($('#wdg_ct_columns .wdg-ct-col-item').length + 1) + '</span><button class="wdg-item-remove" type="button">✕</button></div>');
            var $body = $('<div class="wdg-ct-col-body">');
            $body.append('<div class="ody_builder_parameter"><label><?php echo t("Όνομα Plan"); ?></label><input type="text" class="listbox wdg-ct-col-name" value="' + $('<div>').text(data.name || '').html() + '"></div>');
            $body.append('<div class="ody_builder_parameter"><label><?php echo t("Κείμενο ετικέτας marketing"); ?></label><input type="text" class="listbox wdg-ct-col-badge" value="' + $('<div>').text(data.badge || '').html() + '"></div>');
            $body.append('<div class="ody_builder_parameter"><div class="admin_checkbox_wrapper" style="margin: 0 0 10px;"><input type="checkbox" class="wdg-ct-col-featured" value="1"><p><?php echo t("Featured (highlighted)"); ?></p></div></div>');
            $body.append('<div class="ody_builder_parameter"><label><?php echo t("Κείμενο κουμπιού"); ?></label><input type="text" class="listbox wdg-ct-col-btn-label" value="' + $('<div>').text(data.btn_label || '').html() + '"></div>');
            $body.append('<div class="ody_builder_parameter"><label>Link</label><input type="text" id="' + urlId + '" class="listbox wdg-ct-col-btn-url" value=""><select class="selectLink listbox" onchange="wdgCtSetLink($(this).val(),\'' + urlId + '\',\'' + idx + '\',\'col\'); $(this).val(\'\');">' + _page_opts + '</select></div>');
            $body.append('<div class="ody_builder_parameter"><div class="admin_checkbox_wrapper" style="margin: 0 0 10px;"><input type="checkbox" class="wdg-ct-col-btn-new-tab" value="1"><p><?php echo t("Άνοιγμα σε νέο tab"); ?></p></div></div>');
            $body.append('<div class="ody_builder_parameter"><label><?php echo t("Εμφάνιση κουμπιού"); ?></label><select class="listbox wdg-ct-col-btn-style"><option value="widget-button-primary">Primary</option><option value="widget-button-secondary">Secondary</option></select></div>');
            $item.append($body);
            $('#wdg_ct_columns').append($item);
            $item.append('<a id="' + nodePopupId + '" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]' + urlId + '">iFrame</a><a id="' + filePopupId + '" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]' + urlId + '">iFrame</a>');
            new VenoBox({selector: '#' + nodePopupId, fitView: true, ratio: 'full'});
            new VenoBox({selector: '#' + filePopupId, fitView: true, ratio: 'full'});
            if(data.featured == '1') $item.find('.wdg-ct-col-featured').prop('checked', true);
            if(data.btn_url) $('#' + urlId).val(data.btn_url);
            if(data.btn_new_tab == '1') $item.find('.wdg-ct-col-btn-new-tab').prop('checked', true);
            $item.find('.wdg-ct-col-btn-style').val(data.btn_style || 'widget-button-secondary');
            $item.find('.wdg-item-remove').on('click', function () {
                $item.fadeOut(200, function () {
                    $item.remove();
                    renumberCols();
                });
            });
        }

        function renumberCols() {
            $('#wdg_ct_columns .wdg-ct-col-item').each(function (idx) {
                $(this).find('.wdg-ct-col-header span').text('<?php echo t("Στήλη"); ?> ' + (idx + 1));
            });
        }

        function addRow(data) {
            data = data || {};
            var idx = _row_idx++;
            var $item = $('<div class="wdg-ct-row-item" data-idx="' + idx + '">');
            $item.append('<div class="wdg-ct-row-header"><span><?php echo t("Σειρά"); ?> ' + ($('#wdg_ct_rows .wdg-ct-row-item').length + 1) + '</span><button class="wdg-item-remove" type="button">✕</button></div>');
            var $body = $('<div class="wdg-ct-row-body">');
            $body.append('<div class="ody_builder_parameter"><label><?php echo t("Χαρακτηριστικό"); ?></label><input type="text" class="listbox wdg-ct-row-name" value="' + $('<div>').text(data.name || '').html() + '"></div>');
            $body.append('<div class="ody_builder_parameter"><label><?php echo t("Τιμές ανά σειρά (χωρισμένες με |||, πχ: yes|||no|||yes)"); ?></label><input type="text" class="listbox wdg-ct-row-values" value="' + $('<div>').text(data.values || '').html() + '"></div>');
            $item.append($body);
            $('#wdg_ct_rows').append($item);
            $item.find('.wdg-item-remove').on('click', function () {
                $item.fadeOut(200, function () {
                    $item.remove();
                    renumberRows();
                });
            });
        }

        function renumberRows() {
            $('#wdg_ct_rows .wdg-ct-row-item').each(function (idx) {
                $(this).find('.wdg-ct-row-header span').text('<?php echo t("Σειρά"); ?> ' + (idx + 1));
            });
        }
        _cols.forEach(function (col) {
            addColumn(col);
        });
        _rows.forEach(function (row) {
            addRow(row);
        });
        $('#wdg_ct_add_col_btn').on('click', function () {
            addColumn({});
        });
        $('#wdg_ct_add_row_btn').on('click', function () {
            addRow({});
        });
        if($.fn.sortable) {
            $('#wdg_ct_columns').sortable({handle: '.wdg-ct-col-header', placeholder: 'block-placeholder', tolerance: 'pointer', stop: function() { renumberCols(); }});
            $('#wdg_ct_rows').sortable({handle: '.wdg-ct-row-header', placeholder: 'block-placeholder', tolerance: 'pointer', stop: function() { renumberRows(); }});
        }
        window.wdgCtSetLink = function (val, targetId, idx, type) {
            if(!val || val === 'divider') return;
            if(val === 'nodeLinks_ct') {
                document.getElementById('wdg_ct_' + type + '_node_' + idx).click();
                return;
            }
            if(val === 'fileLinks_ct') {
                document.getElementById('wdg_ct_' + type + '_file_' + idx).click();
                return;
            }
            var link = (val === 'homepage') ? 'index.php' : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
            $('#' + targetId).val(link);
        };
        label = 'Widget Comparison Table';
        $('#ody_builder_admin_label').val(label);
        $('.ody_builder_header h2').html('Widgetizer — Comparison Table');
        window.get_block_data = function () {
            var columns = [];
            $('#wdg_ct_columns .wdg-ct-col-item').each(function () {
                var $it = $(this);
                columns.push({name: $it.find('.wdg-ct-col-name').val(), badge: $it.find('.wdg-ct-col-badge').val(), featured: $it.find('.wdg-ct-col-featured').is(':checked') ? '1' : '0', btn_label: $it.find('.wdg-ct-col-btn-label').val(), btn_url: $it.find('.wdg-ct-col-btn-url').val(), btn_new_tab: $it.find('.wdg-ct-col-btn-new-tab').is(':checked') ? '1' : '0', btn_style: $it.find('.wdg-ct-col-btn-style').val()});
            });
            var rows = [];
            $('#wdg_ct_rows .wdg-ct-row-item').each(function () {
                var $it = $(this);
                rows.push({name: $it.find('.wdg-ct-row-name').val(), values: $it.find('.wdg-ct-row-values').val()});
            });
            return {widget_id: 'comparison_table', params: {eyebrow: $('#wdg_ct_eyebrow').val(), title: $('#wdg_ct_title').val(), description: $('#wdg_ct_description').val(), features_label: $('#wdg_ct_features_label').val(), color_scheme: $('#wdg_ct_color_scheme').val(), container_width: $('#wdg_ct_container_width').val(), columns: columns, rows: rows}};
        };
    });
</script>
