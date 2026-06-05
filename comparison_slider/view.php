<?php
/*
 * Widgetizer — Comparison Slider Widget — view.php
 *
 * Έχει πρόσβαση σε: $db, $langID, t(), _saved_params (JS)
 * Πρέπει να ορίσει: window.get_block_data(), label
 */
?>
<style>
    .ody_builder_parameter {
        max-width: 500px !important;
    }
    .wdg-img-row {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }
    .wdg-img-filename {
        font-size: 12px;
        color: #999;
        font-style: italic;
        word-break: break-all;
        flex: 1;
    }
    .wdg-img-preview {
        max-height: 50px;
        max-width: 120px;
        margin-top: 4px;
        border-radius: 4px;
        display: none;
        border: 1px solid #ddd;
    }
</style>

<!-- ══ ΓΕΝΙΚΑ ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_csl_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_csl_eyebrow" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_csl_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_csl_title" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_csl_subheading"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_csl_subheading" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_csl_header_align"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_csl_header_align" class="listbox">
        <option value="start"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>

<!-- ══ BEFORE IMAGE ══════════════════════════════════════════════════════════ -->
<div class="wdg-section-title">⬅️ Before Image</div>

<div class="ody_builder_parameter">
    <label><?php echo t("Before Image"); ?></label>
    <div class="wdg-img-row">
        <span id="wdg_csl_before_image_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>
        <a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"
           class="wdg-csl-select-media ody_builder_content_action btn btn-success"
           data-vbtype="iframe"
           data-wdg-target="wdg_csl_before_image"><?php echo t("Επιλογή"); ?></a>
        <a href="javascript:void(0)" id="wdg_csl_before_image_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;">
            <?php echo t("Αφαίρεση"); ?>
        </a>
    </div>
    <input type="hidden" id="wdg_csl_before_image" value="">
    <img id="wdg_csl_before_image_preview" class="wdg-img-preview" src="" alt="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_csl_before_label"><?php echo t("Ετικέτα της Before εικόνας"); ?></label>
    <input type="text" id="wdg_csl_before_label" class="listbox" value="">
</div>

<!-- ══ AFTER IMAGE ═══════════════════════════════════════════════════════════ -->
<div class="wdg-section-title">➡️ After Image</div>

<div class="ody_builder_parameter">
    <label><?php echo t("After Image"); ?></label>
    <div class="wdg-img-row">
        <span id="wdg_csl_after_image_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>
        <a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"
           class="wdg-csl-select-media ody_builder_content_action btn btn-success"
           data-vbtype="iframe"
           data-wdg-target="wdg_csl_after_image"><?php echo t("Επιλογή"); ?></a>
        <a href="javascript:void(0)" id="wdg_csl_after_image_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;">
            <?php echo t("Αφαίρεση"); ?>
        </a>
    </div>
    <input type="hidden" id="wdg_csl_after_image" value="">
    <img id="wdg_csl_after_image_preview" class="wdg-img-preview" src="" alt="">
</div>

<div class="ody_builder_parameter">
    <label for="wdg_csl_after_label"><?php echo t("Ετικέτα της After εικόνας"); ?></label>
    <input type="text" id="wdg_csl_after_label" class="listbox" value="">
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_csl_orientation"><?php echo t("Προσανατολισμός"); ?></label>
    <select id="wdg_csl_orientation" class="listbox">
        <option value="horizontal"><?php echo t("Οριζόντιος"); ?></option>
        <option value="vertical"><?php echo t("Κατακόρυφος"); ?></option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_csl_aspect_ratio">Aspect Ratio</label>
    <select id="wdg_csl_aspect_ratio" class="listbox">
        <option value="16-9">16:9</option>
        <option value="4-3">4:3</option>
        <option value="1-1"><?php echo t("1:1 (Τετράγωνο)"); ?></option>
        <option value="3-2">3:2</option>
        <option value="21-9">21:9 (Cinematic)</option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_csl_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_csl_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="wdg_csl_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_csl_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
        <option value="tn">Tiny (450px)</option>
    </select>
</div>


<script>
jQuery(function ($) {
    var _p = _saved_params || {};

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    // ── Φόρτωση τιμών ────────────────────────────────────────────────────────
    $('#wdg_csl_eyebrow').val(pval('eyebrow'));
    $('#wdg_csl_title').val(pval('title'));
    $('#wdg_csl_subheading').val(pval('subheading'));
    $('#wdg_csl_header_align').val(pval('header_align', 'center'));
    $('#wdg_csl_before_label').val(pval('before_label', 'Before'));
    $('#wdg_csl_after_label').val(pval('after_label', 'After'));
    $('#wdg_csl_orientation').val(pval('orientation', 'horizontal'));
    $('#wdg_csl_aspect_ratio').val(pval('aspect_ratio', '16-9'));
    $('#wdg_csl_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_csl_container_width').val(pval('container_width', 'xl'));


    // ── VenoBox για mediabank pickers ─────────────────────────────────────────
    // window.venobox απαιτείται από το ody_builder_mediabank.php για το close()
    window.venobox = new VenoBox({selector: '.wdg-csl-select-media', fitView: true, ratio: 'full'});

    $('.wdg-csl-select-media').on('click', function () {
        window._wdg_mediabank_caller = this;
    });

    // ── odyRecieveMediabank: callback από mediabank iframe ────────────────────
    window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
        var targetId = $(callerEl).data('wdg-target');
        if (!targetId) return;
        var fullPath = image_path + id + '.' + ext;
        $('#' + targetId).val(fullPath);
        $('#' + targetId + '_display').text(file);
        $('#' + targetId + '_preview').attr('src', fullPath).show();
        $('#' + targetId + '_remove').css('visibility', 'visible');
    };

    // ── Remove buttons ────────────────────────────────────────────────────────
    $('#wdg_csl_before_image_remove').on('click', function () {
        $('#wdg_csl_before_image').val('');
        $('#wdg_csl_before_image_display').text('<?php echo t("Επιλέξτε..."); ?>');
        $('#wdg_csl_before_image_preview').hide().attr('src', '');
        $(this).css('visibility', 'hidden');
    });
    $('#wdg_csl_after_image_remove').on('click', function () {
        $('#wdg_csl_after_image').val('');
        $('#wdg_csl_after_image_display').text('<?php echo t("Επιλέξτε..."); ?>');
        $('#wdg_csl_after_image_preview').hide().attr('src', '');
        $(this).css('visibility', 'hidden');
    });

    // ── Φόρτωση αποθηκευμένων εικόνων ────────────────────────────────────────
    var _before = pval('before_image');
    if (_before) {
        $('#wdg_csl_before_image').val(_before);
        $('#wdg_csl_before_image_display').text(_before.split('/').pop());
        $('#wdg_csl_before_image_preview').attr('src', _before).show();
        $('#wdg_csl_before_image_remove').css('visibility', 'visible');
    }

    var _after = pval('after_image');
    if (_after) {
        $('#wdg_csl_after_image').val(_after);
        $('#wdg_csl_after_image_display').text(_after.split('/').pop());
        $('#wdg_csl_after_image_preview').attr('src', _after).show();
        $('#wdg_csl_after_image_remove').css('visibility', 'visible');
    }

    // ── Label ─────────────────────────────────────────────────────────────────
    label = 'Widget Comparison Slider';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Comparison Slider');

    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function () {
        return {
            widget_id: 'comparison_slider',
            params: {
                eyebrow:         $('#wdg_csl_eyebrow').val(),
                title:           $('#wdg_csl_title').val(),
                subheading:      $('#wdg_csl_subheading').val(),
                header_align:    $('#wdg_csl_header_align').val(),
                before_image:    $('#wdg_csl_before_image').val(),
                before_label:    $('#wdg_csl_before_label').val(),
                after_image:     $('#wdg_csl_after_image').val(),
                after_label:     $('#wdg_csl_after_label').val(),
                orientation:     $('#wdg_csl_orientation').val(),
                aspect_ratio:    $('#wdg_csl_aspect_ratio').val(),
                color_scheme:    $('#wdg_csl_color_scheme').val(),
                container_width: $('#wdg_csl_container_width').val()
            }
        };
    };
});
</script>
