<?php
/*
 * Widgetizer — Action Bar Widget — view.php (custom admin UI)
 *
 * Έχει πρόσβαση σε: $db, $langID, t(), _saved_params (JS)
 * Πρέπει να ορίσει: window.get_block_data(), label
 */
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
</style>

<!-- ══ ΚΕΙΜΕΝΟ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Κείμενο"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_ab_headline"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_ab_headline" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_ab_body"><?php echo t("Περιγραφή"); ?></label>
    <textarea id="wdg_ab_body" class="listbox" rows="3" style="resize:vertical;"></textarea>
</div>


<!-- ══ ΕΜΦΑΝΙΣΗ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_ab_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_ab_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_ab_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_ab_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>

<!-- ══ BUTTON 1 ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Πρώτο κουμπί"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_ab_btn1_label"><?php echo t("Κείμενο"); ?></label>
    <input type="text" id="wdg_ab_btn1_label" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_ab_btn1_url">Link</label>
    <input type="text" id="wdg_ab_btn1_url" class="listbox" value="">
    <select class="selectLink listbox" onchange="wdgAbSetLink($(this).val(), 'wdg_ab_btn1_url'); $(this).val('');">
        <option value=""><?php echo t("ή επιλέξτε υπάρχουσα σελίδα"); ?></option>
        <option value="homepage"><?php echo t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ"); ?></option>
        <?php
        $q = "select pages.id as id, content_pages.title as title
              from pages, content_pages
              where content_pages.mainID=pages.id
              and content_pages.langID=" . $langID . "
              order by pages.sort, content_pages.title";
        foreach($db->getRecords($q) as $row): ?>
            <option value="<?php echo $row->id; ?>"><?php echo $row->title; ?></option>
        <?php endforeach; ?>
        <option value="divider">--------------------------------------</option>
        <option value="nodeLinks_btn1"><?php echo t("Link για εγγραφή ενότητας") . " >>"; ?></option>
        <option value="divider">--------------------------------------</option>
        <option value="fileLinks_btn1"><?php echo t("Link για αρχείο") . " >>"; ?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" styel="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_ab_btn1_new_tab" value="1">
        <p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>
    </div>
</div>


<div class="ody_builder_parameter">
    <label for="wdg_ab_btn1_style"><?php echo t("Εμφάνιση κουμπιού"); ?></label>
    <select id="wdg_ab_btn1_style" class="listbox">
        <option value="widget-button-primary">Primary</option>
        <option value="widget-button-secondary">Secondary</option>
        <option value="widget-button-outline">Outline</option>
    </select>
</div>

<!-- ══ BUTTON 2 ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Δεύτερο κουμπί"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_ab_btn2_label"><?php echo t("Κείμενο"); ?></label>
    <input type="text" id="wdg_ab_btn2_label" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_ab_btn2_url">Link</label>
    <input type="text" id="wdg_ab_btn2_url" class="listbox" value="">
    <select class="selectLink listbox" onchange="wdgAbSetLink($(this).val(), 'wdg_ab_btn2_url'); $(this).val('');">
        <option value=""><?php echo t("ή επιλέξτε υπάρχουσα σελίδα"); ?></option>
        <option value="homepage"><?php echo t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ"); ?></option>
        <?php
        foreach($db->getRecords($q) as $row): ?>
            <option value="<?php echo $row->id; ?>"><?php echo $row->title; ?></option>
        <?php endforeach; ?>
        <option value="divider">--------------------------------------</option>
        <option value="nodeLinks_btn2"><?php echo t("Link για εγγραφή ενότητας") . " >>"; ?></option>
        <option value="divider">--------------------------------------</option>
        <option value="fileLinks_btn2"><?php echo t("Link για αρχείο") . " >>"; ?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" styel="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_ab_btn2_new_tab" value="1">
        <p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>
    </div>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_ab_btn2_style"><?php echo t("Εμφάνιση κουμπιού"); ?></label>
    <select id="wdg_ab_btn2_style" class="listbox">
        <option value="widget-button-primary">Primary</option>
        <option value="widget-button-secondary">Secondary</option>
        <option value="widget-button-outline">Outline</option>
    </select>
</div>



<!-- Hidden link pickers — btn1 -->
<a id="wdg_ab_node_popup_btn1" class="builder_popup" data-vbtype="iframe"
   href="section_links.php?venobox=[id]wdg_ab_btn1_url">iFrame</a>
<a id="wdg_ab_file_popup_btn1" class="builder_popup" data-vbtype="iframe"
   href="file_links.php?venobox=[id]wdg_ab_btn1_url">iFrame</a>

<!-- Hidden link pickers — btn2 -->
<a id="wdg_ab_node_popup_btn2" class="builder_popup" data-vbtype="iframe"
   href="section_links.php?venobox=[id]wdg_ab_btn2_url">iFrame</a>
<a id="wdg_ab_file_popup_btn2" class="builder_popup" data-vbtype="iframe"
   href="file_links.php?venobox=[id]wdg_ab_btn2_url">iFrame</a>

<script>
jQuery(function ($) {
    var _p = _saved_params || {};

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def || '');
    }

    // ── Φόρτωση τιμών ────────────────────────────────────────────────────────
    $('#wdg_ab_headline').val(pval('headline'));
    $('#wdg_ab_body').val(pval('body'));
    $('#wdg_ab_btn1_label').val(pval('btn1_label'));
    $('#wdg_ab_btn1_url').val(pval('btn1_url'));
    $('#wdg_ab_btn1_style').val(pval('btn1_style', 'widget-button-primary'));
    $('#wdg_ab_btn1_new_tab').prop('checked', _p['btn1_new_tab'] == '1');
    $('#wdg_ab_btn2_label').val(pval('btn2_label'));
    $('#wdg_ab_btn2_url').val(pval('btn2_url'));
    $('#wdg_ab_btn2_style').val(pval('btn2_style', 'widget-button-secondary'));
    $('#wdg_ab_btn2_new_tab').prop('checked', _p['btn2_new_tab'] == '1');
    $('#wdg_ab_color_scheme').val(pval('color_scheme', 'color-scheme-highlight-primary'));
    $('#wdg_ab_container_width').val(pval('container_width', 'xl'));

    // ── VenoBox popups ────────────────────────────────────────────────────────
    new VenoBox({selector: '#wdg_ab_node_popup_btn1', fitView: true, ratio: 'full'});
    new VenoBox({selector: '#wdg_ab_file_popup_btn1', fitView: true, ratio: 'full'});
    new VenoBox({selector: '#wdg_ab_node_popup_btn2', fitView: true, ratio: 'full'});
    new VenoBox({selector: '#wdg_ab_file_popup_btn2', fitView: true, ratio: 'full'});

    // ── Link picker helper ────────────────────────────────────────────────────
    window.wdgAbSetLink = function (val, targetId) {
        if (!val || val === 'divider') return;

        if (val === 'nodeLinks_btn1') {
            document.getElementById('wdg_ab_node_popup_btn1').click(); return;
        }
        if (val === 'fileLinks_btn1') {
            document.getElementById('wdg_ab_file_popup_btn1').click(); return;
        }
        if (val === 'nodeLinks_btn2') {
            document.getElementById('wdg_ab_node_popup_btn2').click(); return;
        }
        if (val === 'fileLinks_btn2') {
            document.getElementById('wdg_ab_file_popup_btn2').click(); return;
        }

        var link = (val === 'homepage')
            ? 'index.php'
            : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
        $('#' + targetId).val(link);
    };

    // ── Label ─────────────────────────────────────────────────────────────────
    label = 'Widget Action Bar';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Action Bar');

    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function () {
        return {
            widget_id: 'action_bar',
            params: {
                headline:     $('#wdg_ab_headline').val(),
                body:         $('#wdg_ab_body').val(),
                btn1_label:   $('#wdg_ab_btn1_label').val(),
                btn1_url:     $('#wdg_ab_btn1_url').val(),
                btn1_style:   $('#wdg_ab_btn1_style').val(),
                btn1_new_tab: $('#wdg_ab_btn1_new_tab').is(':checked') ? '1' : '0',
                btn2_label:   $('#wdg_ab_btn2_label').val(),
                btn2_url:     $('#wdg_ab_btn2_url').val(),
                btn2_style:   $('#wdg_ab_btn2_style').val(),
                btn2_new_tab: $('#wdg_ab_btn2_new_tab').is(':checked') ? '1' : '0',
                color_scheme:     $('#wdg_ab_color_scheme').val(),
                container_width:  $('#wdg_ab_container_width').val()
            }
        };
    };
});
</script>
