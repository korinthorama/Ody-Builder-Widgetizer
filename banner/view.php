<?php
/*
 * Widgetizer — Banner Widget — view.php (custom admin UI)
 *
 * Έχει πρόσβαση σε: $db, $langID, t(), _saved_params (JS)
 * Πρέπει να ορίσει: window.get_block_data(), label
 */
?>
<style>
    .ody_builder_parameter {
        max-width: 500px !important;
    }

    .wdg-image-row {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .wdg-img-filename {
        font-size: 12px;
        color: #999;
        font-style: italic;
        min-width: 0;
        word-break: break-all;
    }

    .wdg-img-preview {
        max-height: 80px;
        max-width: 100%;
        margin-top: 6px;
        border-radius: 4px;
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
        max-width: 400px !important;
        width: 100% !important;
        margin: 2px 0 5px;
    }
</style>
<!-- ══ ΚΕΙΜΕΝΟ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Κείμενο"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_bn_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_bn_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_bn_headline"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_bn_headline" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_bn_body"><?php echo t("Περιγραφή"); ?></label>
    <textarea id="wdg_bn_body" class="listbox" rows="3" style="resize:vertical;"></textarea>
</div>
<!-- ══ ΕΜΦΑΝΙΣΗ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_bn_height"><?php echo t("Ύψος"); ?></label>
    <select id="wdg_bn_height" class="listbox">
        <option value="auto">Auto</option>
        <option value="small"><?php echo t("Μικρό");?></option>
        <option value="medium" selected><?php echo t("Μέτριο");?></option>
        <option value="large"><?php echo t("Μεγάλο");?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_bn_content_align"><?php echo t("Οριζόντια Στοίχιση"); ?></label>
    <select id="wdg_bn_content_align" class="listbox">
        <option value="start"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_bn_content_valign"><?php echo t("Κατακόρυφη Στοίχιση"); ?></label>
    <select id="wdg_bn_content_valign" class="listbox">
        <option value="top"><?php echo t("Πάνω"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
        <option value="bottom"><?php echo t("Κάτω"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_bn_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_bn_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_bn_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_bn_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<!-- ══ ΕΙΚΟΝΑ & OVERLAY ═══════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εικόνα & Μάσκα"); ?></div>
<div class="ody_builder_parameter">
    <label><?php echo t("Εικόνα Φόντου"); ?></label>
    <div class="wdg-image-row">
        <span id="wdg_bn_bg_image_display" class="wdg-img-filename"><?php echo t('Επιλέξτε εικόνα'); ?>...</span>
        <a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"
           class="ody_builder_content_action ody_builder_select_media btn btn-inverse"
           data-vbtype="iframe" data-wdg-target="wdg_bn_bg_image">
            <?php echo t("Επιλογή"); ?>
        </a>
        <a href="javascript:void(0)" id="wdg_bn_bg_image_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"
           onclick="$('#wdg_bn_bg_image').val(''); $('#wdg_bn_bg_image_display').text('<?php echo t("Επιλέξτε εικόνα..."); ?>'); $('#wdg_bn_bg_image_preview').hide().attr('src',''); $('#wdg_bn_bg_image_remove').css('visibility','hidden');">
            <?php echo t("Αφαίρεση"); ?>
        </a>
    </div>
    <input type="hidden" id="wdg_bn_bg_image" value="">
    <img id="wdg_bn_bg_image_preview" class="wdg-img-preview" src="" alt="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_bn_overlay_color"><?php echo t("Χρώμα μάσκας"); ?></label>
    <input type="text" id="wdg_bn_overlay_color" data-preferred-format="hex" value="#000000">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_bn_overlay_opacity"><?php echo t("Διαφάνεια μάσκας"); ?> <small style="color:#999;font-weight:normal;">(0–1)</small></label>
    <input type="number" id="wdg_bn_overlay_opacity" class="listbox" value="0.4"
           min="0" max="1" step="0.1" style="max-width:100px;">
</div>
<!-- ══ BUTTON 1 ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Πρώτο κουμπί"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_bn_btn1_label"><?php echo t("Κείμενο κουμπιού"); ?></label>
    <input type="text" id="wdg_bn_btn1_label" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_bn_btn1_url">Link</label>
    <input type="text" id="wdg_bn_btn1_url" class="listbox" value="">
    <select class="selectLink listbox" onchange="wdgBnSetLink($(this).val(), 'wdg_bn_btn1_url', 'btn1'); $(this).val('');">
        <option value=""><?php echo t("ή επιλέξτε υπάρχουσα σελίδα"); ?></option>
        <option value="homepage"><?php echo t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ"); ?></option>
        <?php
        $q = "select pages.id as id, content_pages.title as title
              from pages, content_pages
              where content_pages.mainID=pages.id
              and content_pages.langID=" . $langID . "
              order by pages.sort, content_pages.title";
        $pages = $db->getRecords($q);
        foreach($pages as $row): ?>
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
        <input type="checkbox" id="wdg_bn_btn1_new_tab" value="1">
        <p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>
    </div>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_bn_btn1_style"><?php echo t("Εμφάνιση κουμπιού"); ?>
    </label>
    <select id="wdg_bn_btn1_style" class="listbox">
        <option value="widget-button-primary">Primary</option>
        <option value="widget-button-secondary">Secondary</option>
    </select>
</div>
<!-- ══ BUTTON 2 ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Δεύτερο κουμπί"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_bn_btn2_label"><?php echo t("Κείμενο κουμπιού"); ?></label>
    <input type="text" id="wdg_bn_btn2_label" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_bn_btn2_url">Link</label>
    <input type="text" id="wdg_bn_btn2_url" class="listbox" value="">
    <select class="selectLink listbox" onchange="wdgBnSetLink($(this).val(), 'wdg_bn_btn2_url', 'btn2'); $(this).val('');">
        <option value=""><?php echo t("ή επιλέξτε υπάρχουσα σελίδα"); ?></option>
        <option value="homepage"><?php echo t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ"); ?></option>
        <?php foreach($pages as $row): ?>
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
        <input type="checkbox" id="wdg_bn_btn2_new_tab" value="1">
        <p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>
    </div>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_bn_btn2_style"><?php echo t("Εμφάνιση κουμπιού"); ?></label>
    <select id="wdg_bn_btn2_style" class="listbox">
        <option value="widget-button-primary">Primary</option>
        <option value="widget-button-secondary">Secondary</option>
    </select>
</div>
<!-- Hidden link pickers — btn1 -->
<a id="wdg_bn_node_popup_btn1" class="builder_popup" data-vbtype="iframe"
   href="section_links.php?venobox=[id]wdg_bn_btn1_url">iFrame</a>
<a id="wdg_bn_file_popup_btn1" class="builder_popup" data-vbtype="iframe"
   href="file_links.php?venobox=[id]wdg_bn_btn1_url">iFrame</a>
<!-- Hidden link pickers — btn2 -->
<a id="wdg_bn_node_popup_btn2" class="builder_popup" data-vbtype="iframe"
   href="section_links.php?venobox=[id]wdg_bn_btn2_url">iFrame</a>
<a id="wdg_bn_file_popup_btn2" class="builder_popup" data-vbtype="iframe"
   href="file_links.php?venobox=[id]wdg_bn_btn2_url">iFrame</a>
<script>
    jQuery(function ($) {
        var _p = _saved_params || {};

        function pval(key, def) {
            return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
        }

        // ── Φόρτωση τιμών ────────────────────────────────────────────────────────
        $('#wdg_bn_eyebrow').val(pval('eyebrow'));
        $('#wdg_bn_headline').val(pval('headline'));
        $('#wdg_bn_body').val(pval('body'));
        $('#wdg_bn_btn1_label').val(pval('btn1_label'));
        $('#wdg_bn_btn1_url').val(pval('btn1_url'));
        $('#wdg_bn_btn1_style').val(pval('btn1_style', 'widget-button-primary'));
        $('#wdg_bn_btn1_new_tab').prop('checked', _p['btn1_new_tab'] == '1');
        $('#wdg_bn_btn2_label').val(pval('btn2_label'));
        $('#wdg_bn_btn2_url').val(pval('btn2_url'));
        $('#wdg_bn_btn2_style').val(pval('btn2_style', 'widget-button-secondary'));
        $('#wdg_bn_btn2_new_tab').prop('checked', _p['btn2_new_tab'] == '1');
        $('#wdg_bn_overlay_opacity').val(pval('overlay_opacity', '0.4'));
        $('#wdg_bn_height').val(pval('height', 'medium'));
        $('#wdg_bn_content_align').val(pval('content_align', 'center'));
        $('#wdg_bn_content_valign').val(pval('content_valign', 'center'));
        $('#wdg_bn_container_width').val(pval('container_width', 'xl'));
        $('#wdg_bn_color_scheme').val(pval('color_scheme', 'color-scheme-highlight-primary'));
        // ── Spectrum — overlay color ──────────────────────────────────────────────
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
        var savedOverlayColor = pval('overlay_color', '#000000').replace('[id]', '#');
        $('#wdg_bn_overlay_color').val(savedOverlayColor).spectrum({
            showInput:       true,
            showPalette:     true,
            showAlpha:       false,
            palette:         palette,
            preferredFormat: 'hex'
        });

        // Φόρτωση εικόνας
        function loadImage(id, path) {
            if(!path) return;
            $('#' + id).val(path);
            $('#' + id + '_display').text(path.split('/').pop());
            $('#' + id + '_preview').attr('src', path).show();
            $('#' + id + '_remove').css('visibility', 'visible');
        }

        loadImage('wdg_bn_bg_image', pval('bg_image'));
        // ── VenoBox ──────────────────────────────────────────────────────────────
        window.venobox = new VenoBox({selector: '.ody_builder_select_media', fitView: true, ratio: 'full'});
        new VenoBox({selector: '#wdg_bn_node_popup_btn1', fitView: true, ratio: 'full'});
        new VenoBox({selector: '#wdg_bn_file_popup_btn1', fitView: true, ratio: 'full'});
        new VenoBox({selector: '#wdg_bn_node_popup_btn2', fitView: true, ratio: 'full'});
        new VenoBox({selector: '#wdg_bn_file_popup_btn2', fitView: true, ratio: 'full'});
        $('.ody_builder_select_media').on('click', function () {
            window._wdg_mediabank_caller = this;
        });
        // ── Mediabank callback ────────────────────────────────────────────────────
        window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
            var targetId = $(callerEl).data('wdg-target');
            if(!targetId) return;
            var fullPath = image_path + id + '.' + ext;
            $('#' + targetId).val(fullPath);
            $('#' + targetId + '_display').text(file);
            $('#' + targetId + '_preview').attr('src', fullPath).show();
            $('#' + targetId + '_remove').css('visibility', 'visible');
        };
        // ── Link picker helper ────────────────────────────────────────────────────
        window.wdgBnSetLink = function (val, targetId, btnKey) {
            if(!val || val === 'divider') return;
            if(val === 'nodeLinks_btn1') {
                document.getElementById('wdg_bn_node_popup_btn1').click();
                return;
            }
            if(val === 'fileLinks_btn1') {
                document.getElementById('wdg_bn_file_popup_btn1').click();
                return;
            }
            if(val === 'nodeLinks_btn2') {
                document.getElementById('wdg_bn_node_popup_btn2').click();
                return;
            }
            if(val === 'fileLinks_btn2') {
                document.getElementById('wdg_bn_file_popup_btn2').click();
                return;
            }
            var link = (val === 'homepage')
                    ? 'index.php'
                    : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
            $('#' + targetId).val(link);
        };
        // ── Label ─────────────────────────────────────────────────────────────────
        label = 'Widget Banner';
        $('#ody_builder_admin_label').val(label);
        $('.ody_builder_header h2').html('Widgetizer — Banner');
        // ── get_block_data ────────────────────────────────────────────────────────
        window.get_block_data = function () {
            return {
                widget_id: 'banner',
                params:    {
                    eyebrow:         $('#wdg_bn_eyebrow').val(),
                    headline:        $('#wdg_bn_headline').val(),
                    body:            $('#wdg_bn_body').val(),
                    btn1_label:      $('#wdg_bn_btn1_label').val(),
                    btn1_url:        $('#wdg_bn_btn1_url').val(),
                    btn1_style:      $('#wdg_bn_btn1_style').val(),
                    btn1_new_tab:    $('#wdg_bn_btn1_new_tab').is(':checked') ? '1' : '0',
                    btn2_label:      $('#wdg_bn_btn2_label').val(),
                    btn2_url:        $('#wdg_bn_btn2_url').val(),
                    btn2_style:      $('#wdg_bn_btn2_style').val(),
                    btn2_new_tab:    $('#wdg_bn_btn2_new_tab').is(':checked') ? '1' : '0',
                    bg_image:        $('#wdg_bn_bg_image').val(),
                    overlay_color:   $('#wdg_bn_overlay_color').val().replace('#', '[id]'),
                    overlay_opacity: $('#wdg_bn_overlay_opacity').val(),
                    height:          $('#wdg_bn_height').val(),
                    content_align:   $('#wdg_bn_content_align').val(),
                    content_valign:  $('#wdg_bn_content_valign').val(),
                    container_width: $('#wdg_bn_container_width').val(),
                    color_scheme:    $('#wdg_bn_color_scheme').val()
                }
            };
        };
    });
</script>
