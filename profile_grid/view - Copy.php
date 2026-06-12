<?php defined('CMS') or die("This file cannot run this way!"); ?>
<style>
    .ody_builder_parameter {
        max-width: 500px !important;
    }

    .wdg-prgr-item {
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 6px;
        background: #f0f4f4;
    }

    .wdg-prgr-item-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
        cursor: move;
    }

    .wdg-prgr-item-header span {
        color: white;
        font-size: 11px;
        flex: 1;
    }

    .wdg-prgr-item-body {
        padding: 8px;
    }

    .wdg-prgr-item-body .ody_builder_parameter {
        max-width: 100% !important;
        margin-bottom: 5px;
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
        max-height: 40px;
        max-width: 100px;
        margin-top: 4px;
        border-radius: 3px;
        display: none;
        border: 1px solid #ddd;
    }

    .wdg-prgr-social-list {
        list-style: none;
        padding: 0;
        margin: 4px 0;
    }

    .wdg-prgr-social-item {
        clear:both;
    }

    .wdg-prgr-social-item input {
        font-size: 12px;
        height: 28px;
        padding: 2px 6px;
    }

    .wdg-prgr-social-pick-btn:hover {
        background: #e0f0f4 !important;
        border-color: #002e3a !important;
    }

    .wdg-prgr-social-item button {
        flex-shrink: 0;
        border-radius: 10px;
        width: 20px;
        height: 20px;
        font-size: 11px !important;
        padding: 0 !important;
        font-weight: bold;
    }

    .wdg-prgr-add-social {
        display: block;
        margin-top: 4px;
        clear: both;
        padding: 4px 10px;
        font-size: 13px !important;
        float: right;
        margin-right: 70px;
    }

    .wdg-prgr-social-picker {
        display: none;
        margin-top: 6px;
        padding: 8px;
        background: #f0f4f4;
        border: 1px solid #ccc;
        border-radius: 4px;
        clear: both;
        max-width: 304px;
        margin: 6px auto 0;
    }
</style>
<!-- ══ ΓΕΝΙΚΑ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_prgr_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_prgr_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prgr_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_prgr_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prgr_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_prgr_description" class="listbox" value="">
</div>
<!-- ══ ΕΜΦΑΝΙΣΗ ═════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_prgr_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_prgr_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prgr_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_prgr_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prgr_header_alignment"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_prgr_header_alignment" class="listbox">
        <option value="left"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prgr_layout"><?php echo t("Τύπος εμφάνισης"); ?></label>
    <select id="wdg_prgr_layout" class="listbox">
        <option value="grid"><?php echo t("Πλέγμα (Grid)");?></option>
        <option value="carousel"><?php echo t("Οριζόντια κύληση (Carousel)");?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prgr_columns"><?php echo t("Στήλες"); ?></label>
    <select id="wdg_prgr_columns" class="listbox">
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prgr_image_style"><?php echo t("Σχήμα & μέγεθος εικόνας"); ?></label>
    <select id="wdg_prgr_image_style" class="listbox">
        <option value="circle"><?php echo t("Μικρός κύκλος"); ?></option>
        <option value="square"><?php echo t("Μικρό τετράγωνο"); ?></option>
        <option value="full"><?php echo t("Μεγάλη διάσταση"); ?></option>
    </select>
</div>
<!-- ══ PROFILES ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title">Profiles</div>
<div id="wdg_prgr_items_container" class="ody_builder_parameter">
    <div id="wdg_prgr_items_list"></div>
    <button type="button" id="wdg_prgr_add_item_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη"); ?> Profile
    </button>
</div>
<script>
    var _social_defs = [
        {type: 'linkedin', label: 'LinkedIn', paths: '<path d="M8 11v5"/><path d="M8 8v.01"/><path d="M12 16v-5"/><path d="M16 16v-3a2 2 0 1 0 -4 0"/><path d="M3 7a4 4 0 0 1 4 -4h10a4 4 0 0 1 4 4v10a4 4 0 0 1 -4 4h-10a4 4 0 0 1 -4 -4l0 -10"/>'},
        {type: 'twitter', label: 'Twitter/X', paths: '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4l11.733 16h4.267l-11.733 -16l-4.267 0"/><path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"/>'},
        {type: 'instagram', label: 'Instagram', paths: '<path d="M4 8a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z"/><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"/><path d="M16.5 7.5v.01"/>'},
        {type: 'facebook', label: 'Facebook', paths: '<path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3"/>'},
        {type: 'email', label: 'Email', paths: '<path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"/><path d="M3 7l9 6l9 -6"/>'},
        {type: 'github', label: 'GitHub', paths: '<path d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5"/>'},
        {type: 'youtube', label: 'YouTube', paths: '<path d="M2 8a4 4 0 0 1 4 -4h12a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-12a4 4 0 0 1 -4 -4v-8z"/><path d="M10 9l5 3l-5 3z"/>'},
        {type: 'tiktok', label: 'TikTok', paths: '<path d="M21 7.917v4.034a9.9 9.9 0 0 1 -5 -1.951v4.5a6.5 6.5 0 1 1 -8 -6.326v4.326a2.5 2.5 0 1 0 4 2v-11.5h4.083a6.005 6.005 0 0 0 4.917 4.917z"/>'},
        {type: 'pinterest', label: 'Pinterest', paths: '<path d="M8 20l4 -9"/><path d="M10.7 14c.437 1.263 1.43 2 2.55 2c2.071 0 3.75 -1.554 3.75 -4a5 5 0 1 0 -9.7 1.7"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>'},
        {type: 'bluesky', label: 'Bluesky', paths: '<path d="M6.335 5.144c-1.654 -1.199 -4.335 -2.127 -4.335 .826c0 .59 .35 4.953 .556 5.661c.713 2.463 3.13 2.75 5.444 2.369c-4.045 .665 -4.889 3.208 -2.667 5.41c1.03 1.018 1.913 1.59 2.667 1.59c2 0 3.134 -2.769 3.5 -3.5c.333 -.667 .5 -1.167 .5 -1.5c0 .333 .167 .833 .5 1.5c.366 .731 1.5 3.5 3.5 3.5c.754 0 1.637 -.571 2.667 -1.59c2.222 -2.203 1.378 -4.746 -2.667 -5.41c2.314 .38 4.73 .094 5.444 -2.369c.206 -.708 .556 -5.072 .556 -5.661c0 -2.953 -2.68 -2.025 -4.335 -.826c-2.293 1.662 -4.76 5.048 -5.665 6.856c-.905 -1.808 -3.372 -5.194 -5.665 -6.856"/>'},
        {type: 'discord', label: 'Discord', paths: '<path d="M8 12a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"/><path d="M14 12a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"/><path d="M15.5 17c0 1 1.5 3 2 3c1.5 0 2.833 -1.667 3.5 -3c.667 -1.667 .5 -5.833 -1.5 -11.5c-1.457 -1.015 -3 -1.34 -4.5 -1.5l-.972 1.923a11.913 11.913 0 0 0 -4.053 0l-.975 -1.923c-1.5 .16 -3.043 .485 -4.5 1.5c-2 5.667 -2.167 9.833 -1.5 11.5c.667 1.333 2 3 3.5 3c.5 0 2 -2 2 -3"/><path d="M7 16.5c3.5 1 6.5 1 10 0"/>'},
        {type: 'meta', label: 'Meta', paths: '<path d="M12 10.174c1.766 -2.784 3.315 -4.174 4.648 -4.174c2 0 3.263 2.213 4 5.217c.704 2.869 .5 6.783 -2 6.783c-1.114 0 -2.648 -1.565 -4.148 -3.652a27.627 27.627 0 0 1 -2.5 -4.174z"/><path d="M12 10.174c-1.766 -2.784 -3.315 -4.174 -4.648 -4.174c-2 0 -3.263 2.213 -4 5.217c-.704 2.869 -.5 6.783 2 6.783c1.114 0 2.648 -1.565 4.148 -3.652c-1 -1.391 -1.833 -2.783 -2.5 -4.174z"/>'},
        {type: 'reddit', label: 'Reddit', paths: '<path d="M12 8c2.648 0 5.028 .826 6.675 2.14a2.5 2.5 0 0 1 2.326 4.36c0 3.59 -4.03 6.5 -9 6.5c-4.875 0 -8.845 -2.8 -9 -6.294l-1 -.206h-.5a2.5 2.5 0 0 1 0 -5a2.5 2.5 0 0 1 2.5 2.5c0 .386 -.088 .752 -.245 1.078l.005 .617c.002 .522 .005 1.021 .01 1.485a2.5 2.5 0 0 1 2.326 -4.36c1.647 -1.313 4.027 -2.139 6.675 -2.14z"/><path d="M12 8l1 -5l6 1"/><path d="M19 4m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/><circle cx="9" cy="13" r=".5" fill="currentColor"/><circle cx="15" cy="13" r=".5" fill="currentColor"/><path d="M10 17c.667 .333 1.333 .5 2 .5s1.333 -.167 2 -.5"/>'},
        {type: 'telegram', label: 'Telegram', paths: '<path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4"/>'},
        {type: 'threads', label: 'Threads', paths: '<path d="M19 7.5c-1.333 -3 -3.667 -4.5 -7 -4.5c-5 0 -8 2.5 -8 9s3.5 9 8 9s7 -3 7 -5s-1 -5 -7 -5c-2.5 0 -3 1.25 -3 2.5c0 1.5 1 2.5 2.5 2.5c2.5 0 3.5 -1.5 3.5 -5c0 -3 -1 -5 -3 -5s-3 2 -3 5"/>'},
        {type: 'whatsapp', label: 'WhatsApp', paths: '<path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9"/><path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1"/>'}
    ];
    jQuery(function ($) {
        var _p = _saved_params || {};
        var _items = _p['items'] || [];
        var _item_idx = 0;

        function pval(key, def) {
            return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
        }

        // ── Restore scalars ────────────────────────────────────────────────────────
        $('#wdg_prgr_eyebrow').val(pval('eyebrow'));
        $('#wdg_prgr_title').val(pval('title'));
        $('#wdg_prgr_description').val(pval('description'));
        $('#wdg_prgr_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
        $('#wdg_prgr_container_width').val(pval('container_width', 'xl'));
        $('#wdg_prgr_header_alignment').val(pval('header_alignment', 'center'));
        $('#wdg_prgr_layout').val(pval('layout', 'grid'));
        $('#wdg_prgr_columns').val(pval('columns', '3'));
        $('#wdg_prgr_image_style').val(pval('image_style', 'circle'));
        // ── VenoBox shared class ───────────────────────────────────────────────────
        window.venobox = new VenoBox({selector: '.wdg-prgr-select-media', fitView: true, ratio: 'full'});
        // ── odyRecieveMediabank ────────────────────────────────────────────────────
        window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
            var targetId = $(callerEl || window._wdg_mediabank_caller).data('wdg-target');
            if(!targetId) return;
            var fullPath = image_path + id + '.' + ext;
            $('#' + targetId).val(fullPath);
            $('#' + targetId + '_display').text(file);
            $('#' + targetId + '_preview').attr('src', fullPath).show();
            $('#' + targetId + '_remove').css('visibility', 'visible');
        };

        // ── Add Item ──────────────────────────────────────────────────────────────
        function addItem(itemData) {
            itemData = itemData || {};
            var ii = _item_idx++;
            var uid = 'prgr_' + ii;
            var imgId = 'wdg_prgr_img_' + uid;
            var mediaId = 'wdg_prgr_media_' + uid;
            var $item = $('<div class="wdg-prgr-item" data-ii="' + ii + '">');
            $item.append(
                    '<div class="wdg-prgr-item-header">' +
                    '<span><?php echo t("Profile"); ?> ' + ($('#wdg_prgr_items_list .wdg-prgr-item').length + 1) + '</span>' +
                    '<button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
                    '</div>'
            );
            var $body = $('<div class="wdg-prgr-item-body">');
            // Image picker
            $body.append(
                    '<div class="ody_builder_parameter"><label><?php echo t("Φωτογραφία"); ?></label>' +
                    '<div class="wdg-img-row">' +
                    '<span id="' + imgId + '_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>' +
                    '<a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>" id="' + mediaId + '"' +
                    ' class="wdg-prgr-select-media ody_builder_content_action btn btn-success" data-vbtype="iframe" data-wdg-target="' + imgId + '"><?php echo t("Επιλογή"); ?></a>' +
                    '<a href="javascript:void(0)" id="' + imgId + '_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"><?php echo t("Αφαίρεση"); ?></a>' +
                    '</div>' +
                    '<input type="hidden" id="' + imgId + '" value="">' +
                    '<img id="' + imgId + '_preview" class="wdg-img-preview" src="" alt="">' +
                    '</div>'
            );
            // Text fields
            var _fields = [
                {id: 'name', label: '<?php echo t("Όνομα"); ?>'},
                {id: 'role', label: '<?php echo t("Ρόλος / Τίτλος"); ?>'},
                {id: 'specialty', label: '<?php echo t("Ειδικότητα"); ?>'},
                {id: 'bio', label: '<?php echo t("Βιογραφικό"); ?>'}
            ];
            _fields.forEach(function (f) {
                $body.append(
                        '<div class="ody_builder_parameter"><label>' + f.label + '</label>' +
                        '<input type="text" id="wdg_prgr_' + f.id + '_' + uid + '" class="listbox" value="' + $('<div>').text(itemData[f.id] || '').html() + '"></div>'
                );
            });
            // Social links
            var $socialWrap = $('<div class="ody_builder_parameter"><label><?php echo t("Social Links (max 6)"); ?></label>' +
                    '<ul class="wdg-prgr-social-list" id="wdg_prgr_socials_' + uid + '"></ul>' +
                    '<button type="button" class="ody_builder_content_action btn btn-success btn-sm wdg-prgr-add-social">+ <?php echo t("Προσθήκη"); ?> Social</button>' +
                    '<div class="wdg-prgr-social-picker" id="wdg_prgr_picker_' + uid + '"></div>' +
                    '</div>');
            $body.append($socialWrap);
            // Use direct references — not ID selectors (not in DOM yet)
            var $picker = $socialWrap.find('.wdg-prgr-social-picker');
            var $socialList = $socialWrap.find('.wdg-prgr-social-list');
            var $addSocialBtn = $socialWrap.find('.wdg-prgr-add-social');
            // Populate picker buttons
            _social_defs.forEach(function (s) {
                var $btn = $('<button type="button" class="wdg-prgr-social-pick-btn" title="' + s.label + '" style="background:none;border:1px solid #ccc;border-radius:4px;padding:4px 6px;margin:2px;cursor:pointer;" data-type="' + s.type + '">');
                var svgPicker = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                svgPicker.setAttribute('width', '20');
                svgPicker.setAttribute('height', '20');
                svgPicker.setAttribute('viewBox', '0 0 24 24');
                svgPicker.setAttribute('fill', 'none');
                svgPicker.setAttribute('stroke', 'currentColor');
                svgPicker.setAttribute('stroke-width', '1.5');
                svgPicker.setAttribute('stroke-linecap', 'round');
                svgPicker.setAttribute('stroke-linejoin', 'round');
                svgPicker.innerHTML = s.paths;
                $btn.append(svgPicker);
                $picker.append($btn);
            });

            function updateSocialBtn() {
                var count = $socialList.find('.wdg-prgr-social-item').length;
                if (count >= 6) {
                    $addSocialBtn.hide();
                } else {
                    $addSocialBtn.show();
                }
            }

            function addSocialItem(type, url) {
                var def = _social_defs.find(function (s) {
                    return s.type === type;
                });
                if(!def) return;
                var $li = $('<li class="wdg-prgr-social-item" data-type="' + type + '" style="display:flex;align-items:center;gap:6px;margin-bottom:4px;">');
                var $iconSpan = $('<span style="flex-shrink:0;"></span>');
                var svgEl = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                svgEl.setAttribute('width', '16');
                svgEl.setAttribute('height', '16');
                svgEl.setAttribute('viewBox', '0 0 24 24');
                svgEl.setAttribute('fill', 'none');
                svgEl.setAttribute('stroke', 'currentColor');
                svgEl.setAttribute('stroke-width', '1.5');
                svgEl.setAttribute('stroke-linecap', 'round');
                svgEl.setAttribute('stroke-linejoin', 'round');
                svgEl.innerHTML = def.paths;
                $iconSpan.append(svgEl);
                $li.append($iconSpan);
                $li.append('<input type="text" class="listbox wdg-prgr-social-url" placeholder="' + def.label + '" value="' + $('<div>').text(url || '').html() + '" style="flex:1;">');
                var $del = $('<button type="button" class="ody_builder_content_action btn btn-danger btn-sm" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>');
                $del.on('click', function () {
                    $li.remove();
                    $picker.hide();
                    updateSocialBtn();
                });
                $li.append($del);
                $socialList.append($li);
                updateSocialBtn();
            }

            $addSocialBtn.on('click', function () {
                $picker.toggle();
            });
            $picker.on('click', '.wdg-prgr-social-pick-btn', function () {
                var type = $(this).data('type');
                // Check for duplicate
                var exists = $socialList.find('.wdg-prgr-social-item[data-type="' + type + '"]').length > 0;
                if(exists) {
                    var def = _social_defs.find(function (s) {
                        return s.type === type;
                    });
                    alert('<?php echo t("Το"); ?> ' + (def ? def.label : type) + ' <?php echo t("έχει ήδη προστεθεί."); ?>');
                    return;
                }
                addSocialItem(type, '');
                $picker.hide();
                updateSocialBtn();
            });
            // Restore saved socials
            if(itemData.socials) {
                var parts = itemData.socials.split('|||');
                parts.forEach(function (part) {
                    if(!part.trim()) return;
                    var idx = part.indexOf(':');
                    if(idx < 0) return;
                    var t = part.substring(0, idx);
                    var u = part.substring(idx + 1);
                    addSocialItem(t, u);
                });
            }
            updateSocialBtn();
            $item.append($body);
            $('#wdg_prgr_items_list').append($item);
            // Per-item VenoBox + caller tracker
            new VenoBox({selector: '#' + mediaId, fitView: true, ratio: 'full'});
            $('#' + mediaId).on('click', function () {
                window._wdg_mediabank_caller = this;
            });
            // Remove button
            $('#' + imgId + '_remove').on('click', function() {
                $('#' + imgId).val('');
                $('#' + imgId + '_display').text('<?php echo t("Επιλέξτε..."); ?>');
                $('#' + imgId + '_preview').hide().attr('src', '');
                $(this).css('visibility', 'hidden');
            });
            // Restore saved image
            if(itemData.image) {
                $('#' + imgId).val(itemData.image);
                $('#' + imgId + '_display').text(itemData.image.split('/').pop());
                $('#' + imgId + '_preview').attr('src', itemData.image).show();
                $('#' + imgId + '_remove').css('visibility', 'visible');
            }
            $item.find('.wdg-item-remove').on('click', function () {
                $item.fadeOut(200, function () {
                    $item.remove();
                    renumberItems();
                });
            });
            if($.fn.sortable) {
                $('#wdg_prgr_items_list').sortable({
                    handle:      '.wdg-prgr-item-header',
                    placeholder: 'block-placeholder',
                    tolerance:   'pointer',
                    stop:        function () {
                        renumberItems();
                    }
                });
            }
        }

        function renumberItems() {
            $('#wdg_prgr_items_list .wdg-prgr-item').each(function (idx) {
                $(this).find('.wdg-prgr-item-header span').text('<?php echo t("Profile"); ?> ' + (idx + 1));
            });
        }

        _items.forEach(function (item) {
            addItem(item);
        });
        $('#wdg_prgr_add_item_btn').on('click', function () {
            addItem({});
        });
        // ── Label ─────────────────────────────────────────────────────────────────
        label = 'Widget Profile Grid';
        $('#ody_builder_admin_label').val(label);
        $('.ody_builder_header h2').html('Widgetizer — Profile Grid');
        // ── get_block_data ────────────────────────────────────────────────────────
        window.get_block_data = function () {
            var items = [];
            $('#wdg_prgr_items_list .wdg-prgr-item').each(function () {
                var ii = $(this).data('ii');
                var uid = 'prgr_' + ii;
                items.push({
                    image:     $('#wdg_prgr_img_' + uid).val(),
                    name:      $('#wdg_prgr_name_' + uid).val(),
                    role:      $('#wdg_prgr_role_' + uid).val(),
                    specialty: $('#wdg_prgr_specialty_' + uid).val(),
                    bio:       $('#wdg_prgr_bio_' + uid).val(),
                    socials:   (function () {
                        var parts = [];
                        $('#wdg_prgr_socials_' + uid + ' .wdg-prgr-social-item').each(function () {
                            var t = $(this).data('type');
                            var u = $(this).find('.wdg-prgr-social-url').val().trim();
                            if(t && u) parts.push(t + ':' + u);
                        });
                        return parts.join('|||');
                    })()
                });
            });
            return {
                widget_id: 'profile_grid',
                params:    {
                    eyebrow:          $('#wdg_prgr_eyebrow').val(),
                    title:            $('#wdg_prgr_title').val(),
                    description:      $('#wdg_prgr_description').val(),
                    color_scheme:     $('#wdg_prgr_color_scheme').val(),
                    container_width:  $('#wdg_prgr_container_width').val(),
                    header_alignment: $('#wdg_prgr_header_alignment').val(),
                    layout:           $('#wdg_prgr_layout').val(),
                    columns:          $('#wdg_prgr_columns').val(),
                    image_style:      $('#wdg_prgr_image_style').val(),
                    items:            items
                }
            };
        };
    });
</script>
