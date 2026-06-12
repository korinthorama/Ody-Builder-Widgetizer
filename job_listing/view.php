<?php defined('CMS') or die("This file cannot run this way!"); ?>

<style>
    .ody_builder_parameter { max-width: 500px !important; }
    .selectLink {
        border: 2px solid #002e3a !important; height: auto !important; padding: 2px 10px !important;
        font-size: .8em !important; background-color: #002e3a; color: white;
        max-width: 400px !important; width: 100% !important; margin: 2px 0 5px;
    }
    .wdg-jbl-item { border: 1px solid #ccc; border-radius: 4px; margin-bottom: 8px; background: #f9f9f9; transition: box-shadow 0.3s ease; }
    .wdg-jbl-item-header { display: flex; align-items: center; gap: 8px; padding: 6px 8px; background: #002e3a; border-radius: 4px 4px 0 0; }
    .wdg-jbl-item-header span { color: white; font-size: 12px; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .wdg-jbl-item-body { padding: 8px; }
    .wdg-jbl-item-body .ody_builder_parameter { max-width: 100% !important; margin-bottom: 6px; }

    /* ── Βελάκια μετακίνησης ── */
    .wdg-jbl-move-buttons { display: flex; gap: 4px; margin-right: 4px; }
    .wdg-jbl-move-btn { background: transparent; border: none; color: white; cursor: pointer; font-size: 12px; padding: 2px 4px; border-radius: 3px; transition: all 0.2s; }
    .wdg-jbl-move-btn:hover { background: rgba(255, 255, 255, 0.2); }
    .wdg-jbl-move-btn:active { transform: scale(0.9); }
</style>

<!-- ══ ΓΕΝΙΚΑ ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_jbl_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_jbl_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_jbl_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_jbl_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_jbl_description"><?php echo t("Περιγραφή"); ?></label>
    <textarea id="wdg_jbl_description" class="listbox" rows="3" style="resize:vertical;"></textarea>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_jbl_header_align"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_jbl_header_align" class="listbox">
        <option value="start"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_jbl_show_filters" value="1">
        <p><?php echo t("Εμφάνιση Φίλτρων Τμήματος"); ?></p>
    </div>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_jbl_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_jbl_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_jbl_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_jbl_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>

<!-- ══ ΘΕΣΕΙΣ ΕΡΓΑΣΙΑΣ ═══════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Θέσεις Εργασίας"); ?></div>
<div id="wdg_jbl_jobs_container" class="ody_builder_parameter">
    <div id="wdg_jbl_jobs_list"></div>
    <button type="button" id="wdg_jbl_add_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη Θέσης"); ?>
    </button>
    <input type="hidden" id="wdg_jbl_jobs" value="">
</div>

<div id="wdg_jbl_popups_container" style="display:none;"></div>

<?php
$q = "select pages.id as id, content_pages.title as title
      from pages, content_pages
      where content_pages.mainID=pages.id
      and content_pages.langID=" . $langID . "
      order by pages.sort, content_pages.title";
$_jbl_pages = $db->getRecords($q);
$_jbl_page_opts  = '<option value="">' . t("ή επιλέξτε υπάρχουσα σελίδα") . '</option>';
$_jbl_page_opts .= '<option value="homepage">' . t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ") . '</option>';
foreach ($_jbl_pages as $_jbl_row) {
    $_jbl_page_opts .= '<option value="' . $_jbl_row->id . '">' . htmlspecialchars($_jbl_row->title) . '</option>';
}
$_jbl_page_opts .= '<option value="divider">--------------------------------------</option>';
$_jbl_page_opts .= '<option value="nodeLinks_jbl">' . t("Link για εγγραφή ενότητας") . ' >></option>';
$_jbl_page_opts .= '<option value="divider">--------------------------------------</option>';
$_jbl_page_opts .= '<option value="fileLinks_jbl">' . t("Link για αρχείο") . ' >></option>';
?>

<script>
jQuery(function ($) {
    var _p = _saved_params || {};
    var _item_idx = 0;
    var _page_opts = <?php echo json_encode($_jbl_page_opts); ?>;

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    $('#wdg_jbl_eyebrow').val(pval('eyebrow'));
    $('#wdg_jbl_title').val(pval('title'));
    $('#wdg_jbl_description').val(pval('description'));
    $('#wdg_jbl_header_align').val(pval('header_align', 'center'));
    if (pval('show_filters', '1') !== '0') $('#wdg_jbl_show_filters').prop('checked', true);
    $('#wdg_jbl_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_jbl_container_width').val(pval('container_width', 'xl'));

    function createDeptKey(label) {
        if (!label || label.trim() === '') return 'other';
        var key = label.toLowerCase()
            .replace(/[^a-z\u0370-\u03ff\u1f00-\u1fff\s-]/g, '')
            .replace(/[\s-]+/g, '-')
            .replace(/^-|-$/g, '');
        return key || 'other';
    }

    // ── Link helper ───────────────────────────────────────────────────────────
    window.wdgJblSetLink = function(val, urlFieldId, idx) {
        if (!val || val === 'divider') return;
        if (val === 'nodeLinks_jbl') { document.getElementById('wdg_jbl_node_popup_' + idx).click(); return; }
        if (val === 'fileLinks_jbl') { document.getElementById('wdg_jbl_file_popup_' + idx).click(); return; }
        var link = (val === 'homepage')
            ? 'index.php'
            : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
        $('#' + urlFieldId).val(link);
    };

    // ── Save jobs ─────────────────────────────────────────────────────────────
    function saveJobs() {
        var items = [];
        $('#wdg_jbl_jobs_list .wdg-jbl-item').each(function() {
            var $it = $(this);
            var idx = $it.data('idx');
            var deptLabel = $it.find('.wdg-jbl-dept').val() || '';
            var deptKey = createDeptKey(deptLabel);
            items.push({
                title:            $it.find('.wdg-jbl-title').val(),
                department:       deptKey,
                department_label: deptLabel,
                location:         $it.find('.wdg-jbl-location').val(),
                employment_type:  $it.find('.wdg-jbl-emp-type').val(),
                btn_label:        $it.find('.wdg-jbl-btn-label').val(),
                btn_url:          $('#wdg_jbl_url_' + idx).val(),
                btn_new_tab:      $it.find('.wdg-jbl-btn-newtab').is(':checked') ? '1' : '0'
            });
        });
        $('#wdg_jbl_jobs').val(JSON.stringify(items));
    }

    // ── Item display ──────────────────────────────────────────────────────────
    function updateItemDisplay($item) {
        var titleVal = $item.find('.wdg-jbl-title').val();
        var itemNumber = $item.index() + 1;
        var displayText = '<?php echo t("Θέση"); ?> ' + itemNumber;
        if (titleVal && titleVal.trim() !== '') {
            displayText += ': ' + titleVal;
        }
        $item.find('.wdg-jbl-item-header span').text(displayText);
    }

    function renumberItems() {
        $('#wdg_jbl_jobs_list .wdg-jbl-item').each(function() {
            updateItemDisplay($(this));
        });
    }

    // ── Move functions ────────────────────────────────────────────────────────
    function moveItemUp($item) {
        var $prev = $item.prev('.wdg-jbl-item');
        if ($prev.length) {
            $item.slideUp(1, function() {
                $item.insertBefore($prev);
                $item.slideDown(1, function() {
                    renumberItems();
                    saveJobs();
                    $('html, body').animate({ scrollTop: $item.offset().top - 100 }, 300);
                    $item.css('box-shadow', '0 0 0 2px #fbbf24');
                    setTimeout(function() { $item.css('box-shadow', ''); }, 100);
                });
            });
        }
    }

    function moveItemDown($item) {
        var $next = $item.next('.wdg-jbl-item');
        if ($next.length) {
            $item.slideUp(1, function() {
                $item.insertAfter($next);
                $item.slideDown(1, function() {
                    renumberItems();
                    saveJobs();
                    $('html, body').animate({ scrollTop: $item.offset().top - 100 }, 300);
                    $item.css('box-shadow', '0 0 0 2px #fbbf24');
                    setTimeout(function() { $item.css('box-shadow', ''); }, 100);
                });
            });
        }
    }

    // ── Add Job ───────────────────────────────────────────────────────────────
    function addItem(data) {
        data = data || {};
        var idx    = _item_idx++;
        var urlId  = 'wdg_jbl_url_' + idx;
        var nodeId = 'wdg_jbl_node_popup_' + idx;
        var fileId = 'wdg_jbl_file_popup_' + idx;

        var $item = $('<div class="wdg-jbl-item" data-idx="' + idx + '">');
        $item.append(
            '<div class="wdg-jbl-item-header">' +
            '<div class="wdg-jbl-move-buttons">' +
            '<button type="button" class="wdg-jbl-move-btn wdg-jbl-move-up" title="<?php echo t("Μετακίνηση πάνω"); ?>">▲</button>' +
            '<button type="button" class="wdg-jbl-move-btn wdg-jbl-move-down" title="<?php echo t("Μετακίνηση κάτω"); ?>">▼</button>' +
            '</div>' +
            '<span><?php echo t("Θέση"); ?> ' + ($('#wdg_jbl_jobs_list .wdg-jbl-item').length + 1) + '</span>' +
            '<button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );

        var $body = $('<div class="wdg-jbl-item-body">');

        // Job title
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τίτλος Θέσης"); ?></label>' +
            '<input type="text" class="listbox wdg-jbl-title" value="' + $('<div>').text(data.title || '').html() + '"></div>'
        );
        // Department
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τμήμα"); ?></label>' +
            '<input type="text" class="listbox wdg-jbl-dept" value="' + $('<div>').text(data.department_label || data.department || '').html() + '"></div>'
        );
        // Location
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τοποθεσία"); ?></label>' +
            '<input type="text" class="listbox wdg-jbl-location" value="' + $('<div>').text(data.location || '').html() + '"></div>'
        );
        // Employment type
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τύπος Απασχόλησης"); ?></label>' +
            '<select class="listbox wdg-jbl-emp-type" style="max-width: 177px !important">' +
            '<option value="full-time"><?php echo t("Πλήρης Απασχόληση"); ?></option>' +
            '<option value="part-time"><?php echo t("Μερική Απασχόληση"); ?></option>' +
            '<option value="contract"><?php echo t("Σύμβαση"); ?></option>' +
            '<option value="internship"><?php echo t("Πρακτική Άσκηση"); ?></option>' +
            '</select></div>'
        );
        // Button label
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Κείμενο κουμπιού"); ?></label>' +
            '<input type="text" class="listbox wdg-jbl-btn-label" value="' + $('<div>').text(data.btn_label || '<?php echo t("Υποβολή Αίτησης"); ?>').html() + '"></div>'
        );
        // Button URL
        $body.append(
            '<div class="ody_builder_parameter"><label>Link</label>' +
            '<input type="text" class="listbox wdg-jbl-btn-url" id="' + urlId + '" value="' + $('<div>').text(data.btn_url || '').html() + '">' +
            '<select class="selectLink listbox" onchange="wdgJblSetLink($(this).val(), \'' + urlId + '\', ' + idx + '); $(this).val(\'\');">' +
            _page_opts + '</select></div>'
        );
        // New tab
        $body.append(
            '<div class="ody_builder_parameter"><div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">' +
            '<input type="checkbox" class="wdg-jbl-btn-newtab" id="wdg_jbl_newtab_' + idx + '" value="1">' +
            '<p><?php echo t("Άνοιγμα σε νέο tab"); ?></p></div></div>'
        );

        $item.append($body);
        $('#wdg_jbl_jobs_list').append($item);

        // Hidden link popups
        $('#wdg_jbl_popups_container').append(
            '<a id="' + nodeId + '" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]' + urlId + '">iFrame</a>' +
            '<a id="' + fileId + '" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]' + urlId + '">iFrame</a>'
        );
        new VenoBox({selector: '#' + nodeId, fitView: true, ratio: 'full'});
        new VenoBox({selector: '#' + fileId, fitView: true, ratio: 'full'});

        if (data.employment_type) $item.find('.wdg-jbl-emp-type').val(data.employment_type);
        if (data.btn_new_tab == '1') $('#wdg_jbl_newtab_' + idx).prop('checked', true);

        // ── Real-time title update ────────────────────────────────────────────
        $item.find('.wdg-jbl-title').on('input', function() {
            updateItemDisplay($item);
        });

        // ── Move buttons ──────────────────────────────────────────────────────
        $item.find('.wdg-jbl-move-up').on('click', function(e) {
            e.stopPropagation();
            moveItemUp($item);
        });
        $item.find('.wdg-jbl-move-down').on('click', function(e) {
            e.stopPropagation();
            moveItemDown($item);
        });

        $item.find('.wdg-item-remove').on('click', function() {
            $item.fadeOut(200, function() {
                $item.remove();
                renumberItems();
                saveJobs();
            });
        });

        $item.find('input, textarea, select').on('change input', function() { saveJobs(); });

        updateItemDisplay($item);
    }

    // Φόρτωση αποθηκευμένων jobs
    var _saved_jobs = pval('jobs');
    if (_saved_jobs) {
        try { JSON.parse(_saved_jobs).forEach(function(j) { addItem(j); }); } catch(e) {}
    }

    $('#wdg_jbl_add_btn').on('click', function() { addItem({}); saveJobs(); });

    label = 'Widget Job Listing';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Job Listing');

    window.get_block_data = function() {
        saveJobs();
        return {
            widget_id: 'job_listing',
            params: {
                eyebrow:         $('#wdg_jbl_eyebrow').val(),
                title:           $('#wdg_jbl_title').val(),
                description:     $('#wdg_jbl_description').val(),
                header_align:    $('#wdg_jbl_header_align').val(),
                show_filters:    $('#wdg_jbl_show_filters').is(':checked') ? '1' : '0',
                color_scheme:    $('#wdg_jbl_color_scheme').val(),
                container_width: $('#wdg_jbl_container_width').val(),
                jobs:            $('#wdg_jbl_jobs').val()
            }
        };
    };
});
</script>
