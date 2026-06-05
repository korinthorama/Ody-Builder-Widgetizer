<?php
/*
 * Widgetizer — Countdown Timer Widget — view.php
 * Prefix: cd
 */
$q = "select pages.id as id, content_pages.title as title
      from pages, content_pages
      where content_pages.mainID=pages.id
      and content_pages.langID=" . $langID . "
      order by pages.sort, content_pages.title";
$_pages = $db->getRecords($q);
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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

    .flatpickr-day.selected {
        background: #9a2a54;
        border-color: #9a2a54;
    }

    .flatpickr-day.today {
        border-color: #9a2a54;
    }

    .flatpickr-day:hover {
        background: #002e3a;
        border: none;
        color: white;
    }
</style>
<!-- ══ ΓΕΝΙΚΑ ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_cd_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_cd_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_cd_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_cd_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_cd_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_cd_description" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_cd_header_align"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_cd_header_align" class="listbox">
        <option value="center"><?php echo t("Κέντρο"); ?></option>
        <option value="left"><?php echo t("Αριστερά"); ?></option>
    </select>
</div>
<!-- ══ COUNTDOWN ═════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title">⏱️<?php echo t("Αντίστροφη μέτρηση");?></div>
<div class="ody_builder_parameter">
    <label for="wdg_cd_target"><?php echo t("Ημερομηνία Στόχος"); ?></label>
    <input type="text" id="wdg_cd_target" class="listbox" placeholder="DD/MM/YYYY HH:MM">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_cd_expired_message"><?php echo t("Μήνυμα λήξης"); ?></label>
    <input type="text" id="wdg_cd_expired_message" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_cd_show_seconds" value="1">
        <p><?php echo t("Εμφάνιση Δευτερολέπτων"); ?></p>
    </div>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_cd_style"><?php echo t("Τύπος εμφάνισης"); ?></label>
    <select id="wdg_cd_style" class="listbox">
        <option value="cards"><?php echo t("με πλαίσια");?></option>
        <option value="minimal"><?php echo t("χωρίς πλαίσια");?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_cd_countdown_text"><?php echo t("Κείμενο (μετά τον timer)"); ?></label>
    <textarea id="wdg_cd_countdown_text" class="listbox" rows="3" style="resize:vertical;"></textarea>
</div>
<!-- ══ BUTTON ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Κουμπί"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_cd_btn_label"><?php echo t("Κείμενο κουμπιού"); ?></label>
    <input type="text" id="wdg_cd_btn_label" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_cd_btn_url">Link</label>
    <input type="text" id="wdg_cd_btn_url" class="listbox" value="">
    <select class="selectLink listbox" onchange="wdgCdSetLink($(this).val()); $(this).val('');">
        <option value=""><?php echo t("ή επιλέξτε υπάρχουσα σελίδα"); ?></option>
        <option value="homepage"><?php echo t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ"); ?></option>
        <?php foreach($db->getRecords($q) as $row): ?>
            <option value="<?php echo $row->id; ?>"><?php echo htmlspecialchars($row->title); ?></option>
        <?php endforeach; ?>
        <option value="divider">--------------------------------------</option>
        <option value="nodeLinks_cd"><?php echo t("Link για εγγραφή ενότητας") . " >>"; ?></option>
        <option value="divider">--------------------------------------</option>
        <option value="fileLinks_cd"><?php echo t("Link για αρχείο") . " >>"; ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_cd_btn_new_tab" value="1">
        <p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>
    </div>
</div>
<!-- ══ ΕΜΦΑΝΙΣΗ ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_cd_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_cd_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_cd_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_cd_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<!-- Hidden link pickers -->
<a id="wdg_cd_node_popup" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]wdg_cd_btn_url">iFrame</a>
<a id="wdg_cd_file_popup" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]wdg_cd_btn_url">iFrame</a>
<script>
    jQuery(function ($) {
        var _p = _saved_params || {};

        function pval(key, def) {
            return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
        }

        $('#wdg_cd_eyebrow').val(pval('eyebrow'));
        $('#wdg_cd_title').val(pval('title'));
        $('#wdg_cd_description').val(pval('description'));
        $('#wdg_cd_header_align').val(pval('header_align', 'center'));
        // Μετατροπή από YYYY-MM-DD HH:MM σε DD/MM/YYYY HH:MM για εμφάνιση
        var _targetRaw = pval('target');
        var _targetDisplay = '';
        if(_targetRaw) {
            var _parts = _targetRaw.match(/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2})/);
            if(_parts) _targetDisplay = _parts[3] + '/' + _parts[2] + '/' + _parts[1] + ' ' + _parts[4] + ':' + _parts[5];
        }
        flatpickr('#wdg_cd_target', {
            enableTime:  true,
            time_24hr:   true,
            dateFormat:  'd/m/Y H:i',
            defaultDate: _targetDisplay || null,
            static:      true
        });
        $('#wdg_cd_expired_message').val(pval('expired_message'));
        $('#wdg_cd_show_seconds').prop('checked', _p['show_seconds'] !== '0');
        $('#wdg_cd_style').val(pval('style', 'cards'));
        $('#wdg_cd_countdown_text').val(pval('countdown_text'));
        $('#wdg_cd_btn_label').val(pval('btn_label'));
        $('#wdg_cd_btn_url').val(pval('btn_url'));
        $('#wdg_cd_btn_new_tab').prop('checked', _p['btn_new_tab'] == '1');
        $('#wdg_cd_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
        $('#wdg_cd_container_width').val(pval('container_width', 'xl'));
        new VenoBox({selector: '#wdg_cd_node_popup', fitView: true, ratio: 'full'});
        new VenoBox({selector: '#wdg_cd_file_popup', fitView: true, ratio: 'full'});
        window.wdgCdSetLink = function (val) {
            if(!val || val === 'divider') return;
            if(val === 'nodeLinks_cd') {
                document.getElementById('wdg_cd_node_popup').click();
                return;
            }
            if(val === 'fileLinks_cd') {
                document.getElementById('wdg_cd_file_popup').click();
                return;
            }
            var link = (val === 'homepage') ? 'index.php' : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
            $('#wdg_cd_btn_url').val(link);
        };
        label = 'Widget Countdown Timer';
        $('#ody_builder_admin_label').val(label);
        $('.ody_builder_header h2').html('Widgetizer — Countdown Timer');
        window.get_block_data = function () {
            return {
                widget_id: 'countdown_timer',
                params:    {
                    eyebrow:         $('#wdg_cd_eyebrow').val(),
                    title:           $('#wdg_cd_title').val(),
                    description:     $('#wdg_cd_description').val(),
                    header_align:    $('#wdg_cd_header_align').val(),
                    target:          (function () {
                        var v = $('#wdg_cd_target').val();
                        var m = v.match(/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})/);
                        return m ? m[3] + '-' + m[2] + '-' + m[1] + ' ' + m[4] + ':' + m[5] : v;
                    })(),
                    expired_message: $('#wdg_cd_expired_message').val(),
                    show_seconds:    $('#wdg_cd_show_seconds').is(':checked') ? '1' : '0',
                    style:           $('#wdg_cd_style').val(),
                    countdown_text:  $('#wdg_cd_countdown_text').val(),
                    btn_label:       $('#wdg_cd_btn_label').val(),
                    btn_url:         $('#wdg_cd_btn_url').val(),
                    btn_new_tab:     $('#wdg_cd_btn_new_tab').is(':checked') ? '1' : '0',
                    color_scheme:    $('#wdg_cd_color_scheme').val(),
                    container_width: $('#wdg_cd_container_width').val()
                }
            };
        };
    });
</script>
