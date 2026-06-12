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

    /* Features list */
    .wdg-ic-feature-item {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 5px;
        background: #ededed;
        border-radius: 3px;
        padding: 5px 8px;
    }

    .wdg-ic-feature-item input {
        flex: 1;
        border: 1px solid #ccc;
        border-radius: 3px;
        padding: 4px 7px;
        font-size: 13px;
    }

    .wdg-ic-feature-item .wdg-item-remove {
        border-radius: 10px;
        width: 20px;
        height: 20px;
        font-size: 11px !important;
        padding: 0 !important;
        font-weight: bold;
        flex-shrink: 0;
        background-color: #c00000 !important;
        text-shadow: 1px 1px 1px rgba(0, 0, 0, 1);
    }

    .wdg-item-remove:hover {
        color: #fff;
        background-color: #ff0000 !important;
    }
</style>
<!-- ══ ΚΕΙΜΕΝΟ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Κείμενο"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_ic_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_ic_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_ic_headline"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_ic_headline" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_ic_body"><?php echo t("Περιγραφή"); ?></label>
    <textarea id="wdg_ic_body" class="listbox" rows="4" style="resize:vertical;"></textarea>
</div>
<!-- ══ ΕΜΦΑΝΙΣΗ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_ic_image_position"><?php echo t("Θέση Εικόνας"); ?></label>
    <select id="wdg_ic_image_position" class="listbox">
        <option value="left"><?php echo t("Αριστερά"); ?></option>
        <option value="right"><?php echo t("Δεξιά"); ?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_ic_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_ic_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_ic_content_color_scheme"><?php echo t("Χρωματική παλέτα περιεχομένου"); ?></label>
    <select id="wdg_ic_content_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_ic_border_width"><?php echo t("Πάχος περιγράμματος περιεχομένου"); ?></label>
    <select id="wdg_ic_border_width" class="listbox">
        <option value="var(--border-width-thin)"><?php echo t("Λεπτό (1px)"); ?></option>
        <option value="var(--border-width-medium)"><?php echo t("Μέτριο (2px)"); ?></option>
        <option value="var(--border-width-thick)"><?php echo t("Χοντρό (3px)"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_ic_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_ic_container_width" class="listbox">
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
        <span id="wdg_ic_image_display" class="wdg-img-filename"><?php echo t('Επιλέξτε εικόνα'); ?>...</span>
        <a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"
           class="ody_builder_content_action ody_builder_select_media btn btn-success"
           data-vbtype="iframe" data-wdg-target="wdg_ic_image">
            <?php echo t("Επιλογή"); ?>
        </a>
        <a href="javascript:void(0)" id="wdg_ic_image_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;">
            <?php echo t("Αφαίρεση"); ?>
        </a>
    </div>
    <input type="hidden" id="wdg_ic_image" value="">
    <img id="wdg_ic_image_preview" class="wdg-img-preview" src="" alt="">
</div>
<!-- ══ FEATURES ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Χαρακτηριστικά"); ?></div>
<div id="wdg_ic_features_container" class="ody_builder_parameter">
    <div id="wdg_ic_features_list"></div>
    <button type="button" id="wdg_ic_add_feature" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη χαρακτηριστικού"); ?>
    </button>
    <input type="hidden" id="wdg_ic_features" value="">
</div>
<!-- ══ BUTTON 1 ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Πρώτο κουμπί"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_ic_btn1_label"><?php echo t("Κείμενο κουμπιού"); ?></label>
    <input type="text" id="wdg_ic_btn1_label" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_ic_btn1_url">Link</label>
    <input type="text" id="wdg_ic_btn1_url" class="listbox" value="">
    <select class="selectLink listbox" onchange="wdgIcSetLink($(this).val(), 'wdg_ic_btn1_url', 'btn1'); $(this).val('');">
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
        <input type="checkbox" id="wdg_ic_btn1_new_tab" value="1">
        <p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>
    </div>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_ic_btn1_style"><?php echo t("Εμφάνιση κουμπιού"); ?></label>
    <select id="wdg_ic_btn1_style" class="listbox">
        <option value="widget-button-primary">Primary</option>
        <option value="widget-button-secondary">Secondary</option>
        <option value="widget-button-outline">Outline</option>
    </select>
</div>
<!-- ══ BUTTON 2 ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Δεύτερο κουμπί"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_ic_btn2_label"><?php echo t("Κείμενο κουμπιού"); ?></label>
    <input type="text" id="wdg_ic_btn2_label" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_ic_btn2_url">Link</label>
    <input type="text" id="wdg_ic_btn2_url" class="listbox" value="">
    <select class="selectLink listbox" onchange="wdgIcSetLink($(this).val(), 'wdg_ic_btn2_url', 'btn2'); $(this).val('');">
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
        <input type="checkbox" id="wdg_ic_btn2_new_tab" value="1">
        <p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>
    </div>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_ic_btn2_style"><?php echo t("Εμφάνιση κουμπιού"); ?></label>
    <select id="wdg_ic_btn2_style" class="listbox">
        <option value="widget-button-primary">Primary</option>
        <option value="widget-button-secondary">Secondary</option>
        <option value="widget-button-outline">Outline</option>
    </select>
</div>
<!-- Hidden link pickers -->
<a id="wdg_ic_node_popup_btn1" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]wdg_ic_btn1_url">iFrame</a>
<a id="wdg_ic_file_popup_btn1" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]wdg_ic_btn1_url">iFrame</a>
<a id="wdg_ic_node_popup_btn2" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]wdg_ic_btn2_url">iFrame</a>
<a id="wdg_ic_file_popup_btn2" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]wdg_ic_btn2_url">iFrame</a>
<script>
    jQuery(function ($) {
        var _p = _saved_params || {};

        function pval(key, def) {
            return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
        }

        // ── Φόρτωση τιμών ────────────────────────────────────────────────────────
        $('#wdg_ic_eyebrow').val(pval('eyebrow'));
        $('#wdg_ic_headline').val(pval('headline'));
        $('#wdg_ic_body').val(pval('body'));
        $('#wdg_ic_btn1_label').val(pval('btn1_label'));
        $('#wdg_ic_btn1_url').val(pval('btn1_url'));
        $('#wdg_ic_btn1_style').val(pval('btn1_style', 'widget-button-secondary'));
        $('#wdg_ic_btn1_new_tab').prop('checked', _p['btn1_new_tab'] == '1');
        $('#wdg_ic_btn2_label').val(pval('btn2_label'));
        $('#wdg_ic_btn2_url').val(pval('btn2_url'));
        $('#wdg_ic_btn2_style').val(pval('btn2_style', 'widget-button-secondary'));
        $('#wdg_ic_btn2_new_tab').prop('checked', _p['btn2_new_tab'] == '1');
        $('#wdg_ic_image_position').val(pval('image_position', 'left'));
        $('#wdg_ic_content_color_scheme').val(pval('content_color_scheme', 'color-scheme-standard-primary'));
        $('#wdg_ic_border_width').val(pval('border_width', 'var(--border-width-thin)'));
        $('#wdg_ic_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
        $('#wdg_ic_container_width').val(pval('container_width', 'xl'));

        // ── Features list ─────────────────────────────────────────────────────────
        function renderFeatures(features) {
            $('#wdg_ic_features_list').empty();
            $.each(features, function (i, val) {
                addFeatureRow(val);
            });
            saveFeatures();
        }

        function addFeatureRow(val) {
            var $row = $(
                    '<div class="wdg-ic-feature-item">' +
                    '<input type="text" class="wdg-ic-feature-text" placeholder="<?php echo t("Χαρακτηριστικό..."); ?>" value="' + $('<div>').text(val || '').html() + '">' +
                    '<button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
                    '</div>'
            );
            $row.find('.wdg-item-remove').on('click', function () {
                $row.remove();
                saveFeatures();
            });
            $row.find('input').on('input', function () {
                saveFeatures();
            });
            $('#wdg_ic_features_list').append($row);
            if($.fn.sortable) {
                $('#wdg_ic_features_list').sortable({
                    placeholder: 'block-placeholder',
                    tolerance:   'pointer',
                    update:      function () {
                        saveFeatures();
                    }
                });
            }
        }

        function saveFeatures() {
            var vals = [];
            $('#wdg_ic_features_list .wdg-ic-feature-text').each(function () {
                var v = $(this).val().trim();
                if(v) vals.push(v);
            });
            $('#wdg_ic_features').val(vals.join('|||'));
        }

        // Φόρτωση αποθηκευμένων features
        var _saved_features = pval('features');
        if(_saved_features) {
            var _feature_arr = _saved_features.split('|||');
            $.each(_feature_arr, function (i, v) {
                addFeatureRow(v.trim());
            });
        }
        $('#wdg_ic_add_feature').on('click', function () {
            addFeatureRow('');
            saveFeatures();
        });
        // ── Image ─────────────────────────────────────────────────────────────────
        var _saved_img = pval('image');
        if(_saved_img) {
            $('#wdg_ic_image').val(_saved_img);
            $('#wdg_ic_image_display').text(_saved_img.split('/').pop());
            $('#wdg_ic_image_preview').attr('src', _saved_img).show();
            $('#wdg_ic_image_remove').css('visibility', 'visible');
        }
        window.venobox = new VenoBox({selector: '.ody_builder_select_media', fitView: true, ratio: 'full'});
        new VenoBox({selector: '#wdg_ic_node_popup_btn1', fitView: true, ratio: 'full'});
        new VenoBox({selector: '#wdg_ic_file_popup_btn1', fitView: true, ratio: 'full'});
        new VenoBox({selector: '#wdg_ic_node_popup_btn2', fitView: true, ratio: 'full'});
        new VenoBox({selector: '#wdg_ic_file_popup_btn2', fitView: true, ratio: 'full'});
        $('.ody_builder_select_media').on('click', function () {
            window._wdg_mediabank_caller = this;
        });
        $('#wdg_ic_image_remove').on('click', function () {
            $('#wdg_ic_image').val('');
            $('#wdg_ic_image_display').text('<?php echo t("Επιλέξτε εικόνα"); ?>...');
            $('#wdg_ic_image_preview').hide().attr('src', '');
            $(this).css('visibility', 'hidden');
        });
        window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
            var targetId = $(callerEl || window._wdg_mediabank_caller).data('wdg-target');
            if(!targetId) return;
            var fullPath = image_path + id + '.' + ext;
            $('#' + targetId).val(fullPath);
            $('#' + targetId + '_display').text(file);
            $('#' + targetId + '_preview').attr('src', fullPath).show();
            $('#' + targetId + '_remove').css('visibility', 'visible');
        };
        // ── Link picker ───────────────────────────────────────────────────────────
        window.wdgIcSetLink = function (val, targetId, btnKey) {
            if(!val || val === 'divider') return;
            if(val === 'nodeLinks_btn1') {
                document.getElementById('wdg_ic_node_popup_btn1').click();
                return;
            }
            if(val === 'fileLinks_btn1') {
                document.getElementById('wdg_ic_file_popup_btn1').click();
                return;
            }
            if(val === 'nodeLinks_btn2') {
                document.getElementById('wdg_ic_node_popup_btn2').click();
                return;
            }
            if(val === 'fileLinks_btn2') {
                document.getElementById('wdg_ic_file_popup_btn2').click();
                return;
            }
            var link = (val === 'homepage')
                    ? 'index.php'
                    : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
            $('#' + targetId).val(link);
        };
        // ── Label ─────────────────────────────────────────────────────────────────
        label = 'Widget Image Callout';
        $('#ody_builder_admin_label').val(label);
        $('.ody_builder_header h2').html('Widgetizer — Image Callout');
        // ── get_block_data ────────────────────────────────────────────────────────
        window.get_block_data = function () {
            saveFeatures();
            return {
                widget_id: 'image_callout',
                params:    {
                    eyebrow:              $('#wdg_ic_eyebrow').val(),
                    headline:             $('#wdg_ic_headline').val(),
                    body:                 $('#wdg_ic_body').val(),
                    features:             $('#wdg_ic_features').val(),
                    btn1_label:           $('#wdg_ic_btn1_label').val(),
                    btn1_url:             $('#wdg_ic_btn1_url').val(),
                    btn1_style:           $('#wdg_ic_btn1_style').val(),
                    btn1_new_tab:         $('#wdg_ic_btn1_new_tab').is(':checked') ? '1' : '0',
                    btn2_label:           $('#wdg_ic_btn2_label').val(),
                    btn2_url:             $('#wdg_ic_btn2_url').val(),
                    btn2_style:           $('#wdg_ic_btn2_style').val(),
                    btn2_new_tab:         $('#wdg_ic_btn2_new_tab').is(':checked') ? '1' : '0',
                    image:                $('#wdg_ic_image').val(),
                    image_position:       $('#wdg_ic_image_position').val(),
                    content_color_scheme: $('#wdg_ic_content_color_scheme').val(),
                    border_width:         $('#wdg_ic_border_width').val(),
                    color_scheme:         $('#wdg_ic_color_scheme').val(),
                    container_width:      $('#wdg_ic_container_width').val()
                }
            };
        };
    });
</script>
