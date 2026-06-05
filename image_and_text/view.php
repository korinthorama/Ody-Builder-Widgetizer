<?php defined('CMS') or die("This file cannot run this way!"); ?>
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
    <label for="wdg_it_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_it_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_it_headline"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_it_headline" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_it_body"><?php echo t("Περιγραφή"); ?></label>
    <textarea id="wdg_it_body" class="listbox" rows="4" style="resize:vertical;"></textarea>
</div>
<!-- ══ ΕΜΦΑΝΙΣΗ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_it_image_position"><?php echo t("Θέση Εικόνας"); ?></label>
    <select id="wdg_it_image_position" class="listbox">
        <option value="left"><?php echo t("Αριστερά"); ?></option>
        <option value="right"><?php echo t("Δεξιά"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_it_text_align_y"><?php echo t("Κατακόρυφη Στοίχιση Κειμένου"); ?></label>
    <select id="wdg_it_text_align_y" class="listbox">
        <option value="flex-start"><?php echo t("Πάνω"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
        <option value="flex-end"><?php echo t("Κάτω"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_it_content_color_scheme"><?php echo t("Παλέτα περιεχομένου"); ?></label>
    <select id="wdg_it_content_color_scheme" class="listbox">
        <option value="none"><?php echo t("Χωρίς χρώμα"); ?></option>
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_it_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_it_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_it_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_it_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<!-- ══ ΕΙΚΟΝΑ ═════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εικόνα"); ?></div>
<div class="ody_builder_parameter">
    <label><?php echo t("Εικόνα"); ?></label>
    <div class="wdg-image-row">
        <span id="wdg_it_image_display" class="wdg-img-filename"><?php echo t('Επιλέξτε εικόνα'); ?>...</span>
        <a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"
           class="ody_builder_content_action ody_builder_select_media btn btn-success"
           data-vbtype="iframe" data-wdg-target="wdg_it_image">
            <?php echo t("Επιλογή"); ?>
        </a>
        <a href="javascript:void(0)" id="wdg_it_image_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;">
            <?php echo t("Αφαίρεση"); ?>
        </a>
    </div>
    <input type="hidden" id="wdg_it_image" value="">
    <img id="wdg_it_image_preview" class="wdg-img-preview" src="" alt="">
</div>
<!-- ══ BUTTON 1 ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Πρώτο κουμπί"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_it_btn1_label"><?php echo t("Κείμενο κουμπιού"); ?></label>
    <input type="text" id="wdg_it_btn1_label" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_it_btn1_url">Link</label>
    <input type="text" id="wdg_it_btn1_url" class="listbox" value="">
    <select class="selectLink listbox" onchange="wdgItSetLink($(this).val(), 'wdg_it_btn1_url', 'btn1'); $(this).val('');">
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
    <div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_it_btn1_new_tab" value="1">
        <p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>
    </div>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_it_btn1_style"><?php echo t("Εμφάνιση κουμπιού"); ?></label>
    <select id="wdg_it_btn1_style" class="listbox">
        <option value="widget-button-primary">Primary</option>
        <option value="widget-button-secondary">Secondary</option>
        <option value="widget-button-outline">Outline</option>
    </select>
</div>
<!-- ══ BUTTON 2 ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Δεύτερο κουμπί"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_it_btn2_label"><?php echo t("Κείμενο κουμπιού"); ?></label>
    <input type="text" id="wdg_it_btn2_label" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_it_btn2_url">Link</label>
    <input type="text" id="wdg_it_btn2_url" class="listbox" value="">
    <select class="selectLink listbox" onchange="wdgItSetLink($(this).val(), 'wdg_it_btn2_url', 'btn2'); $(this).val('');">
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
    <div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_it_btn2_new_tab" value="1">
        <p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>
    </div>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_it_btn2_style"><?php echo t("Εμφάνιση κουμπιού"); ?></label>
    <select id="wdg_it_btn2_style" class="listbox">
        <option value="widget-button-primary">Primary</option>
        <option value="widget-button-secondary">Secondary</option>
        <option value="widget-button-outline">Outline</option>
    </select>
</div>
<!-- Hidden link pickers — btn1 -->
<a id="wdg_it_node_popup_btn1" class="builder_popup" data-vbtype="iframe"
   href="section_links.php?venobox=[id]wdg_it_btn1_url">iFrame</a>
<a id="wdg_it_file_popup_btn1" class="builder_popup" data-vbtype="iframe"
   href="file_links.php?venobox=[id]wdg_it_btn1_url">iFrame</a>
<!-- Hidden link pickers — btn2 -->
<a id="wdg_it_node_popup_btn2" class="builder_popup" data-vbtype="iframe"
   href="section_links.php?venobox=[id]wdg_it_btn2_url">iFrame</a>
<a id="wdg_it_file_popup_btn2" class="builder_popup" data-vbtype="iframe"
   href="file_links.php?venobox=[id]wdg_it_btn2_url">iFrame</a>
<script>
    jQuery(function ($) {
        var _p = _saved_params || {};

        function pval(key, def) {
            return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
        }

        // ── Φόρτωση τιμών ────────────────────────────────────────────────────────
        $('#wdg_it_eyebrow').val(pval('eyebrow'));
        $('#wdg_it_headline').val(pval('headline'));
        $('#wdg_it_body').val(pval('body'));
        $('#wdg_it_btn1_label').val(pval('btn1_label'));
        $('#wdg_it_btn1_url').val(pval('btn1_url'));
        $('#wdg_it_btn1_style').val(pval('btn1_style', 'widget-button-primary'));
        $('#wdg_it_btn1_new_tab').prop('checked', _p['btn1_new_tab'] == '1');
        $('#wdg_it_btn2_label').val(pval('btn2_label'));
        $('#wdg_it_btn2_url').val(pval('btn2_url'));
        $('#wdg_it_btn2_style').val(pval('btn2_style', 'widget-button-secondary'));
        $('#wdg_it_btn2_new_tab').prop('checked', _p['btn2_new_tab'] == '1');
        $('#wdg_it_image_position').val(pval('image_position', 'left'));
        $('#wdg_it_text_align_y').val(pval('text_align_y', 'flex-start'));
        $('#wdg_it_content_color_scheme').val(pval('content_color_scheme', 'none'));
        $('#wdg_it_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
        $('#wdg_it_container_width').val(pval('container_width', 'xl'));

        // ── Image load helper ─────────────────────────────────────────────────────
        function loadImage(id, path) {
            if(!path) return;
            $('#' + id).val(path);
            $('#' + id + '_display').text(path.split('/').pop());
            $('#' + id + '_preview').attr('src', path).show();
            $('#' + id + '_remove').css('visibility', 'visible');
        }

        loadImage('wdg_it_image', pval('image'));
        // ── VenoBox ───────────────────────────────────────────────────────────────
        window.venobox = new VenoBox({selector: '.ody_builder_select_media', fitView: true, ratio: 'full'});
        new VenoBox({selector: '#wdg_it_node_popup_btn1', fitView: true, ratio: 'full'});
        new VenoBox({selector: '#wdg_it_file_popup_btn1', fitView: true, ratio: 'full'});
        new VenoBox({selector: '#wdg_it_node_popup_btn2', fitView: true, ratio: 'full'});
        new VenoBox({selector: '#wdg_it_file_popup_btn2', fitView: true, ratio: 'full'});
        $('.ody_builder_select_media').on('click', function () {
            window._wdg_mediabank_caller = this;
        });
        $('#wdg_it_image_remove').on('click', function () {
            $('#wdg_it_image').val('');
            $('#wdg_it_image_display').text('<?php echo t("Επιλέξτε εικόνα..."); ?>');
            $('#wdg_it_image_preview').hide().attr('src', '');
            $(this).css('visibility', 'hidden');
        });
        // ── Mediabank callback ────────────────────────────────────────────────────
        window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
            var targetId = $(callerEl || window._wdg_mediabank_caller).data('wdg-target');
            if(!targetId) return;
            var fullPath = image_path + id + '.' + ext;
            $('#' + targetId).val(fullPath);
            $('#' + targetId + '_display').text(file);
            $('#' + targetId + '_preview').attr('src', fullPath).show();
            $('#' + targetId + '_remove').css('visibility', 'visible');
        };
        // ── Link picker helper ────────────────────────────────────────────────────
        window.wdgItSetLink = function (val, targetId, btnKey) {
            if(!val || val === 'divider') return;
            if(val === 'nodeLinks_btn1') {
                document.getElementById('wdg_it_node_popup_btn1').click();
                return;
            }
            if(val === 'fileLinks_btn1') {
                document.getElementById('wdg_it_file_popup_btn1').click();
                return;
            }
            if(val === 'nodeLinks_btn2') {
                document.getElementById('wdg_it_node_popup_btn2').click();
                return;
            }
            if(val === 'fileLinks_btn2') {
                document.getElementById('wdg_it_file_popup_btn2').click();
                return;
            }
            var link = (val === 'homepage')
                    ? 'index.php'
                    : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
            $('#' + targetId).val(link);
        };
        // ── Label ─────────────────────────────────────────────────────────────────
        label = 'Widget Image and Text';
        $('#ody_builder_admin_label').val(label);
        $('.ody_builder_header h2').html('Widgetizer — Image and Text');
        // ── get_block_data ────────────────────────────────────────────────────────
        window.get_block_data = function () {
            return {
                widget_id: 'image_and_text',
                params:    {
                    eyebrow:              $('#wdg_it_eyebrow').val(),
                    headline:             $('#wdg_it_headline').val(),
                    body:                 $('#wdg_it_body').val(),
                    btn1_label:           $('#wdg_it_btn1_label').val(),
                    btn1_url:             $('#wdg_it_btn1_url').val(),
                    btn1_style:           $('#wdg_it_btn1_style').val(),
                    btn1_new_tab:         $('#wdg_it_btn1_new_tab').is(':checked') ? '1' : '0',
                    btn2_label:           $('#wdg_it_btn2_label').val(),
                    btn2_url:             $('#wdg_it_btn2_url').val(),
                    btn2_style:           $('#wdg_it_btn2_style').val(),
                    btn2_new_tab:         $('#wdg_it_btn2_new_tab').is(':checked') ? '1' : '0',
                    image:                $('#wdg_it_image').val(),
                    image_position:       $('#wdg_it_image_position').val(),
                    text_align_y:         $('#wdg_it_text_align_y').val(),
                    content_color_scheme: $('#wdg_it_content_color_scheme').val(),
                    color_scheme:         $('#wdg_it_color_scheme').val(),
                    container_width:      $('#wdg_it_container_width').val()
                }
            };
        };
    });
</script>
