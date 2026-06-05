<?php
/*
 * Widgetizer — Split Hero Widget — view.php
 * Prefix: sph
 * Refactored: No base64, uses [nl] for line breaks
 */
?>
<style>
    .ody_builder_parameter { max-width: 500px !important; }
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
        max-width: 100% !important;
        width: 100% !important;
        margin: 2px 0 5px;
        box-sizing: border-box;
    }
</style>

<?php
$q = "select pages.id as id, content_pages.title as title
      from pages, content_pages
      where content_pages.mainID=pages.id
      and content_pages.langID=" . $langID . "
      order by pages.sort, content_pages.title";
$_sph_pages = $db->getRecords($q);
?>

<!-- ══ ΚΕΙΜΕΝΟ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Στοιχεία κειμένου"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_sph_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_sph_eyebrow" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_sph_eyebrow_muted" value="1">
        <p><?php echo t("Υποτονισμένο κείμενο"); ?></p>
    </div>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_sph_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_sph_title" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_sph_title_size"><?php echo t("Μέγεθος τίτλου"); ?></label>
    <select id="wdg_sph_title_size" class="listbox">
        <option value="t-lg"><?php echo t("Μεγάλο"); ?></option>
        <option value="t-xl">XL</option>
        <option value="t-2xl" selected>2XL</option>
        <option value="t-3xl">3XL</option>
        <option value="t-4xl">4XL</option>
        <option value="t-5xl">5XL</option>
        <option value="t-6xl">6XL</option>
        <option value="t-7xl">7XL</option>
        <option value="t-8xl">8XL</option>
        <option value="t-9xl">9XL</option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_sph_description"><?php echo t("Περιγραφή"); ?></label>
    <textarea id="wdg_sph_description" class="listbox" rows="3" style="resize:vertical;"></textarea>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_sph_desc_size"><?php echo t("Μέγεθος κειμένου"); ?></label>
    <select id="wdg_sph_desc_size" class="listbox">
        <option value="t-sm"><?php echo t("Μικρό"); ?></option>
        <option value="t-base" selected><?php echo t("Κανονικό"); ?></option>
        <option value="t-lg"><?php echo t("Μεγάλο"); ?></option>
    </select>
</div>

<!-- ══ ΕΙΚΟΝΑ & OVERLAY ═══════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εικόνα & Μάσκα"); ?></div>

<div class="ody_builder_parameter">
    <label><?php echo t("Εικόνα Φόντου"); ?></label>
    <div class="wdg-image-row">
        <span id="wdg_sph_bg_image_display" class="wdg-img-filename"><?php echo t('Επιλέξτε εικόνα'); ?>...</span>
        <a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"
           class="ody_builder_content_action wdg-sph-select-media btn btn-inverse"
           data-vbtype="iframe" data-wdg-target="wdg_sph_bg_image">
            <?php echo t("Επιλογή"); ?>
        </a>
        <a href="javascript:void(0)" id="wdg_sph_bg_image_remove"
           class="ody_builder_content_action btn btn-danger" style="visibility:hidden;">
            <?php echo t("Αφαίρεση"); ?>
        </a>
    </div>
    <input type="hidden" id="wdg_sph_bg_image" value="">
    <img id="wdg_sph_bg_image_preview" class="wdg-img-preview" src="" alt="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_sph_overlay_color"><?php echo t("Χρώμα μάσκας"); ?></label>
    <input type="text" id="wdg_sph_overlay_color" data-preferred-format="hex" value="#000000">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_sph_overlay_opacity"><?php echo t("Διαφάνεια μάσκας"); ?> <small style="color:#999;font-weight:normal;">(0–1)</small></label>
    <input type="number" id="wdg_sph_overlay_opacity" class="listbox" value="0.4"
           min="0" max="1" step="0.1" style="max-width:100px;">
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_sph_image_position"><?php echo t("Θέση Εικόνας"); ?></label>
    <select id="wdg_sph_image_position" class="listbox">
        <option value="start"><?php echo t("Αριστερά"); ?></option>
        <option value="end"><?php echo t("Δεξιά"); ?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_sph_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_sph_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>

<!-- ══ BUTTON 1 ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Πρώτο κουμπί"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_sph_btn1_label"><?php echo t("Κείμενο Κουμπιού"); ?></label>
    <input type="text" id="wdg_sph_btn1_label" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_sph_btn1_url">Link</label>
    <input type="text" id="wdg_sph_btn1_url" class="listbox" value="">
    <select class="selectLink listbox" onchange="wdgSphSetLink($(this).val(), 'wdg_sph_btn1_url', 'btn1'); $(this).val('');">
        <option value=""><?php echo t("ή επιλέξτε υπάρχουσα σελίδα"); ?></option>
        <option value="homepage"><?php echo t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ"); ?></option>
        <?php foreach ($_sph_pages as $_sph_row): ?>
            <option value="<?php echo $_sph_row->id; ?>"><?php echo htmlspecialchars($_sph_row->title); ?></option>
        <?php endforeach; ?>
        <option value="divider">--------------------------------------</option>
        <option value="nodeLinks_btn1"><?php echo t("Link για εγγραφή ενότητας") . " >>"; ?></option>
        <option value="divider">--------------------------------------</option>
        <option value="fileLinks_btn1"><?php echo t("Link για αρχείο") . " >>"; ?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_sph_btn1_new_tab" value="1">
        <p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>
    </div>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_sph_btn1_style"><?php echo t("Εμφάνιση κουμπιού"); ?></label>
    <select id="wdg_sph_btn1_style" class="listbox">
        <option value="widget-button-primary">Primary</option>
        <option value="widget-button-secondary">Secondary</option>
    </select>
</div>

<!-- ══ BUTTON 2 ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Δεύτερο κουμπί"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_sph_btn2_label"><?php echo t("Κείμενο Κουμπιού"); ?></label>
    <input type="text" id="wdg_sph_btn2_label" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_sph_btn2_url">Link</label>
    <input type="text" id="wdg_sph_btn2_url" class="listbox" value="">
    <select class="selectLink listbox" onchange="wdgSphSetLink($(this).val(), 'wdg_sph_btn2_url', 'btn2'); $(this).val('');">
        <option value=""><?php echo t("ή επιλέξτε υπάρχουσα σελίδα"); ?></option>
        <option value="homepage"><?php echo t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ"); ?></option>
        <?php foreach ($_sph_pages as $_sph_row): ?>
            <option value="<?php echo $_sph_row->id; ?>"><?php echo htmlspecialchars($_sph_row->title); ?></option>
        <?php endforeach; ?>
        <option value="divider">--------------------------------------</option>
        <option value="nodeLinks_btn2"><?php echo t("Link για εγγραφή ενότητας") . " >>"; ?></option>
        <option value="divider">--------------------------------------</option>
        <option value="fileLinks_btn2"><?php echo t("Link για αρχείο") . " >>"; ?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_sph_btn2_new_tab" value="1">
        <p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>
    </div>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_sph_btn2_style"><?php echo t("Εμφάνιση κουμπιού"); ?></label>
    <select id="wdg_sph_btn2_style" class="listbox">
        <option value="widget-button-primary">Primary</option>
        <option value="widget-button-secondary">Secondary</option>
    </select>
</div>

<!-- Hidden link pickers — btn1 -->
<a id="wdg_sph_node_popup_btn1" class="builder_popup" data-vbtype="iframe"
   href="section_links.php?venobox=[id]wdg_sph_btn1_url">iFrame</a>
<a id="wdg_sph_file_popup_btn1" class="builder_popup" data-vbtype="iframe"
   href="file_links.php?venobox=[id]wdg_sph_btn1_url">iFrame</a>

<!-- Hidden link pickers — btn2 -->
<a id="wdg_sph_node_popup_btn2" class="builder_popup" data-vbtype="iframe"
   href="section_links.php?venobox=[id]wdg_sph_btn2_url">iFrame</a>
<a id="wdg_sph_file_popup_btn2" class="builder_popup" data-vbtype="iframe"
   href="file_links.php?venobox=[id]wdg_sph_btn2_url">iFrame</a>

<script>
jQuery(function ($) {
    var _p = _saved_params || {};

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    // Helper function for escaping textarea content
    function escapeForTextarea(str) {
        if (!str) return '';
        return str.replace(/&/g, '&amp;')
                  .replace(/</g, '&lt;')
                  .replace(/>/g, '&gt;');
    }

    // ── Restore scalars ────────────────────────────────────────────────────────
    $('#wdg_sph_eyebrow').val(pval('eyebrow'));
    if (pval('eyebrow_muted') === '1') $('#wdg_sph_eyebrow_muted').prop('checked', true);
    $('#wdg_sph_title').val(pval('title'));
    $('#wdg_sph_title_size').val(pval('title_size', 't-2xl'));
    
    // Description restore: decode [nl] to \n (NO base64)
    var descVal = pval('description', '');
    var descDecoded = descVal.replace(/\[nl\]/g, '\n');
    $('#wdg_sph_description').val(descDecoded);
    
    $('#wdg_sph_desc_size').val(pval('desc_size', 't-base'));
    $('#wdg_sph_btn1_label').val(pval('btn1_label'));
    $('#wdg_sph_btn1_url').val(pval('btn1_url'));
    $('#wdg_sph_btn1_style').val(pval('btn1_style', 'widget-button-primary'));
    $('#wdg_sph_btn1_new_tab').prop('checked', pval('btn1_new_tab') == '1');
    $('#wdg_sph_btn2_label').val(pval('btn2_label'));
    $('#wdg_sph_btn2_url').val(pval('btn2_url'));
    $('#wdg_sph_btn2_style').val(pval('btn2_style', 'widget-button-secondary'));
    $('#wdg_sph_btn2_new_tab').prop('checked', pval('btn2_new_tab') == '1');
    $('#wdg_sph_overlay_opacity').val(pval('overlay_opacity', '0.4'));
    $('#wdg_sph_image_position').val(pval('image_position', 'start'));
    $('#wdg_sph_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));

    // ── Spectrum — overlay color ──────────────────────────────────────────────
    var palette = [
        ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
        ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
        ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
        ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
        ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
        ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
    ];

    var savedOverlayColor = pval('overlay_color', '#000000').replace('[id]', '#');
    $('#wdg_sph_overlay_color').val(savedOverlayColor).spectrum({
        showInput:       true,
        showPalette:     true,
        showAlpha:       false,
        palette:         palette,
        preferredFormat: 'hex'
    });

    // ── Φόρτωση εικόνας ───────────────────────────────────────────────────────
    var _savedImg = pval('bg_image');
    if (_savedImg) {
        $('#wdg_sph_bg_image').val(_savedImg);
        $('#wdg_sph_bg_image_display').text(_savedImg.split('/').pop());
        $('#wdg_sph_bg_image_preview').attr('src', _savedImg).show();
        $('#wdg_sph_bg_image_remove').css('visibility', 'visible');
    }

    // ── Remove button event listener (no onclick) ────────────────────────────
    $('#wdg_sph_bg_image_remove').on('click', function() {
        $('#wdg_sph_bg_image').val('');
        $('#wdg_sph_bg_image_display').text('<?php echo t("Επιλέξτε εικόνα..."); ?>');
        $('#wdg_sph_bg_image_preview').hide().attr('src', '');
        $(this).css('visibility', 'hidden');
    });

    // ── VenoBox ──────────────────────────────────────────────────────────────
    window.venobox = new VenoBox({selector: '.wdg-sph-select-media', fitView: true, ratio: 'full'});
    new VenoBox({selector: '#wdg_sph_node_popup_btn1', fitView: true, ratio: 'full'});
    new VenoBox({selector: '#wdg_sph_file_popup_btn1', fitView: true, ratio: 'full'});
    new VenoBox({selector: '#wdg_sph_node_popup_btn2', fitView: true, ratio: 'full'});
    new VenoBox({selector: '#wdg_sph_file_popup_btn2', fitView: true, ratio: 'full'});

    $('.wdg-sph-select-media').on('click', function () {
        window._wdg_mediabank_caller = this;
    });

    // ── Mediabank callback ────────────────────────────────────────────────────
    window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
        var targetId = $(callerEl || window._wdg_mediabank_caller).data('wdg-target');
        if (!targetId) return;
        var fullPath = image_path + id + '.' + ext;
        $('#' + targetId).val(fullPath);
        $('#' + targetId + '_display').text(file);
        $('#' + targetId + '_preview').attr('src', fullPath).show();
        $('#' + targetId + '_remove').css('visibility', 'visible');
    };

    // ── Link picker helper ────────────────────────────────────────────────────
    window.wdgSphSetLink = function (val, targetId, btnKey) {
        if (!val || val === 'divider') return;
        if (val === 'nodeLinks_btn1') { document.getElementById('wdg_sph_node_popup_btn1').click(); return; }
        if (val === 'fileLinks_btn1') { document.getElementById('wdg_sph_file_popup_btn1').click(); return; }
        if (val === 'nodeLinks_btn2') { document.getElementById('wdg_sph_node_popup_btn2').click(); return; }
        if (val === 'fileLinks_btn2') { document.getElementById('wdg_sph_file_popup_btn2').click(); return; }
        var link = (val === 'homepage')
            ? 'index.php'
            : '\u00ab\u00abindex.php?section=pages~|||~view=render~|||~id=' + val + '\u00bb\u00bb';
        $('#' + targetId).val(link);
    };

    // ── Label ─────────────────────────────────────────────────────────────────
    var label = 'Widget Split Hero';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Split Hero');

    // ── get_block_data (save) ─────────────────────────────────────────────────
    window.get_block_data = function () {
        var descVal = $('#wdg_sph_description').val();
        // Encode newlines to [nl] (NO base64)
        var descEncoded = descVal.replace(/\n/g, '[nl]');
        
        return {
            widget_id: 'split_hero',
            params: {
                eyebrow:         $('#wdg_sph_eyebrow').val(),
                eyebrow_muted:   $('#wdg_sph_eyebrow_muted').is(':checked') ? '1' : '0',
                title:           $('#wdg_sph_title').val(),
                title_size:      $('#wdg_sph_title_size').val(),
                description:     descEncoded,
                desc_size:       $('#wdg_sph_desc_size').val(),
                btn1_label:      $('#wdg_sph_btn1_label').val(),
                btn1_url:        $('#wdg_sph_btn1_url').val(),
                btn1_style:      $('#wdg_sph_btn1_style').val(),
                btn1_new_tab:    $('#wdg_sph_btn1_new_tab').is(':checked') ? '1' : '0',
                btn2_label:      $('#wdg_sph_btn2_label').val(),
                btn2_url:        $('#wdg_sph_btn2_url').val(),
                btn2_style:      $('#wdg_sph_btn2_style').val(),
                btn2_new_tab:    $('#wdg_sph_btn2_new_tab').is(':checked') ? '1' : '0',
                bg_image:        $('#wdg_sph_bg_image').val(),
                overlay_color:   $('#wdg_sph_overlay_color').val().replace('#', '[id]'),
                overlay_opacity: $('#wdg_sph_overlay_opacity').val(),
                image_position:  $('#wdg_sph_image_position').val(),
                color_scheme:    $('#wdg_sph_color_scheme').val()
            }
        };
    };
});
</script>