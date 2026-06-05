<?php
/*
 * Widgetizer — Embed Widget — view.php
 * Prefix: emb
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
    <label for="wdg_emb_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_emb_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_emb_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_emb_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_emb_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_emb_description" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_emb_header_align"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_emb_header_align" class="listbox">
        <option value="start"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>
<!-- ══ EMBED CODE ═════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Κώδικας ενσωμάτωσης (Embed Code)"); ?></div>
<div class="ody_builder_parameter" style="max-width:100%;">
    <label for="wdg_emb_embed_code"><?php echo t("Κώδικας (iframe, video, form κτλ.)"); ?></label>
    <textarea id="wdg_emb_embed_code" class="listbox" rows="8" style="width:100%; font-family:monospace; font-size:11px; resize:vertical;"></textarea>
</div>
<!-- ══ ΦΟΝΤΟ ═════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εικόνα Φόντου"); ?></div>
<div class="ody_builder_parameter">
    <label><?php echo t("Εικόνα"); ?></label>
    <div class="wdg-img-row">
        <span id="wdg_emb_bg_image_display" class="wdg-img-filename"><?php echo t("Επιλέξτε εικόνα..."); ?></span>
        <a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"
           class="ody_builder_content_action ody_builder_select_media btn btn-success"
           data-vbtype="iframe" data-wdg-target="wdg_emb_bg_image">
            <?php echo t("Επιλογή"); ?>
        </a>
        <a href="javascript:void(0)" id="wdg_emb_bg_image_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"
>
            <?php echo t("Αφαίρεση"); ?>
        </a>
    </div>
    <input type="hidden" id="wdg_emb_bg_image" value="">
    <img id="wdg_emb_bg_image_preview" class="wdg-img-preview" src="" alt="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_emb_overlay_color"><?php echo t("Χρώμα μάσκας"); ?></label>
    <input type="text" id="wdg_emb_overlay_color" class="listbox" value="#000000">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_emb_overlay_opacity"><?php echo t("Διαφάνεια μάσκας"); ?> <small style="color:#999;">(0–1)</small></label>
    <input type="number" id="wdg_emb_overlay_opacity" class="listbox" value="0.4" min="0" max="1" step="0.1" style="max-width:100px;">
</div>
<!-- ══ ΕΜΦΑΝΙΣΗ ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_emb_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_emb_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_emb_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_emb_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<script>
    jQuery(function ($) {
        var _p = _saved_params || {};

        function pval(key, def) {
            return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
        }

        $('#wdg_emb_eyebrow').val(pval('eyebrow'));
        $('#wdg_emb_title').val(pval('title'));
        $('#wdg_emb_description').val(pval('description'));
        $('#wdg_emb_header_align').val(pval('header_align', 'center'));
        $('#wdg_emb_embed_code').val(pval('embed_code'));
        $('#wdg_emb_overlay_color').val(pval('overlay_color', '#000000'));
        $('#wdg_emb_overlay_opacity').val(pval('overlay_opacity', '0.4'));
        $('#wdg_emb_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
        $('#wdg_emb_container_width').val(pval('container_width', 'xl'));
        // ── Spectrum για overlay color ────────────────────────────────────────────
        var _palette = [
            ["#000", "#444", "#666", "#999", "#ccc", "#eee", "#f3f3f3", "#fff"],
            ["#f00", "#f90", "#ff0", "#0f0", "#0ff", "#00f", "#90f", "#f0f"],
            ["#f4cccc", "#fce5cd", "#fff2cc", "#d9ead3", "#d0e0e3", "#cfe2f3", "#d9d2e9", "#ead1dc"],
            ["#ea9999", "#f9cb9c", "#ffe599", "#b6d7a8", "#a2c4c9", "#9fc5e8", "#b4a7d6", "#d5a6bd"],
            ["#e06666", "#f6b26b", "#ffd966", "#93c47d", "#76a5af", "#6fa8dc", "#8e7cc3", "#c27ba0"],
            ["#c00", "#e69138", "#f1c232", "#6aa84f", "#45818e", "#3d85c6", "#674ea7", "#a64d79"],
            ["#900", "#b45f06", "#bf9000", "#38761d", "#134f5c", "#0b5394", "#351c75", "#741b47"],
            ["#600", "#783f04", "#7f6000", "#274e13", "#0c343d", "#073763", "#20124d", "#4c1130"]
        ];
        $('#wdg_emb_overlay_color').spectrum({
            showInput: true, showPalette: true, showAlpha: false,
            palette:   _palette, preferredFormat: 'hex'
        });
        // ── VenoBox για mediabank ─────────────────────────────────────────────────
        window.venobox = new VenoBox({selector: '.ody_builder_select_media', fitView: true, ratio: 'full'});
        $('.ody_builder_select_media').on('click', function () {
            window._wdg_mediabank_caller = this;
        });
        window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
            var targetId = $(callerEl).data('wdg-target');
            if(!targetId) return;
            var fullPath = image_path + id + '.' + ext;
            $('#' + targetId).val(fullPath);
            $('#' + targetId + '_display').text(file);
            $('#' + targetId + '_preview').attr('src', fullPath).show();
            $('#' + targetId + '_remove').css('visibility', 'visible');
        };
        // ── Remove button ─────────────────────────────────────────────────────────
        $('#wdg_emb_bg_image_remove').on('click', function () {
            $('#wdg_emb_bg_image').val('');
            $('#wdg_emb_bg_image_display').text('<?php echo t("Επιλέξτε εικόνα..."); ?>');
            $('#wdg_emb_bg_image_preview').hide().attr('src', '');
            $(this).css('visibility', 'hidden');
        });

        // ── Φόρτωση αποθηκευμένης εικόνας ────────────────────────────────────────
        var _bg = pval('bg_image');
        if(_bg) {
            $('#wdg_emb_bg_image').val(_bg);
            $('#wdg_emb_bg_image_display').text(_bg.split('/').pop());
            $('#wdg_emb_bg_image_preview').attr('src', _bg).show();
            $('#wdg_emb_bg_image_remove').css('visibility', 'visible');
        }
        // ── Label ─────────────────────────────────────────────────────────────────
        label = 'Widget Embed';
        $('#ody_builder_admin_label').val(label);
        $('.ody_builder_header h2').html('Widgetizer — Embed');
        // ── get_block_data ────────────────────────────────────────────────────────
        window.get_block_data = function () {
            return {
                widget_id: 'embed',
                params:    {
                    eyebrow:         $('#wdg_emb_eyebrow').val(),
                    title:           $('#wdg_emb_title').val(),
                    description:     $('#wdg_emb_description').val(),
                    header_align:    $('#wdg_emb_header_align').val(),
                    embed_code:      $('#wdg_emb_embed_code').val(),
                    bg_image:        $('#wdg_emb_bg_image').val(),
                    overlay_color:   $('#wdg_emb_overlay_color').val(),
                    overlay_opacity: $('#wdg_emb_overlay_opacity').val(),
                    color_scheme:    $('#wdg_emb_color_scheme').val(),
                    container_width: $('#wdg_emb_container_width').val()
                }
            };
        };
    });
</script>
