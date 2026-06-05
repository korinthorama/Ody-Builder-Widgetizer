<?php
/*
 * Widgetizer — Header Widget — view.php (custom admin UI)
 *
 * Included από το block's view.php όταν επιλεγεί το header widget.
 * Έχει πρόσβαση σε: $db, $langID, t(), $wid, $w_label, _saved_params (JS)
 *
 * ΠΡΕΠΕΙ να ορίσει:
 *   window.get_block_data() → { widget_id, params }
 *   label (JS global)
 */
?>
<style>
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
        margin-left: auto;
    }
    .wdg-img-preview {
        max-height: 60px;
        max-width: 200px;
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
    .ody_builder_parameter {
        max-width: 500px !important;
    }
</style>

<!-- ══ BRANDING ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Λογότυπο"); ?></div>

<div class="ody_builder_parameter">
    <label>Logo (Default header)</label>
    <div class="wdg-image-row">
        <span id="logo_default_display" class="wdg-img-filename"><?php echo t('Επιλέξτε εικόνα'); ?>...</span>
        <a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"
           class="ody_builder_content_action ody_builder_select_media btn btn-inverse"
           data-vbtype="iframe" data-wdg-target="logo_default">
            <?php echo t("Επιλογή"); ?>
        </a>
        <a href="javascript:void(0)" id="logo_default_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"
           onclick="$('#logo_default').val(''); $('#logo_default_display').text('<?php echo t("Επιλέξτε εικόνα..."); ?>'); $('#logo_default_preview').hide().attr('src',''); $('#logo_default_remove').css('visibility','hidden');">
            <?php echo t("Αφαίρεση"); ?>
        </a>
    </div>
    <input type="hidden" id="logo_default" value="">
    <img id="logo_default_preview" class="wdg-img-preview" src="" alt="">
</div>

<div class="ody_builder_parameter">
    <label>Logo (Transparent Header)</label>
    <div class="wdg-image-row">
        <span id="logo_transparent_display" class="wdg-img-filename"><?php echo t('Επιλέξτε εικόνα'); ?>...</span>
        <a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"
           class="ody_builder_content_action ody_builder_select_media btn btn-inverse"
           data-vbtype="iframe" data-wdg-target="logo_transparent">
            <?php echo t("Επιλογή"); ?>
        </a>
        <a href="javascript:void(0)" id="logo_transparent_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"
           onclick="$('#logo_transparent').val(''); $('#logo_transparent_display').text('<?php echo t("Επιλέξτε εικόνα..."); ?>'); $('#logo_transparent_preview').hide().attr('src',''); $('#logo_transparent_remove').css('visibility','hidden');">
            <?php echo t("Αφαίρεση"); ?>
        </a>
    </div>
    <input type="hidden" id="logo_transparent" value="">
    <img id="logo_transparent_preview" class="wdg-img-preview" src="" alt="">
</div>

<div class="ody_builder_parameter">
    <label for="logo_text"><?php echo t("Κείμενο λογοτύπου"); ?></label>
    <input type="text" id="logo_text" class="listbox" value="" placeholder="<?php echo t("Εμφανίζεται αν δεν υπάρχει εικόνα"); ?>">
</div>

<div class="ody_builder_parameter">
    <label for="logo_max_width">Logo Max Width (px)</label>
    <input type="number" id="logo_max_width" class="listbox" value="250" min="20" max="600" style="max-width:100px;">
</div>

<!-- ══ NAVIGATION ════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Navigation"); ?></div>

<div class="ody_builder_parameter">
    <label for="menu_name"><?php echo t("Menu"); ?></label>
    <select id="menu_name" class="listbox">
        <option value=""><?php echo t("— Επιλέξτε menu —"); ?></option>
        <?php
        $q = "SELECT s.name, cs.title
              FROM sections s, content_sections cs
              WHERE s.id = cs.mainID
              AND cs.langID = " . $langID . "
              AND s.isMenu = 1
              AND s.active = 1";
        foreach ($db->getRecords($q) as $row): ?>
            <option value="<?php echo htmlspecialchars($row->name); ?>_categories">
                <?php echo htmlspecialchars($row->title); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<!-- ══ CONTACT ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Επικοινωνία"); ?></div>

<div class="ody_builder_parameter">
    <label for="contact_line1"><?php echo t("Γραμμή"); ?> 1</label>
    <input type="text" id="contact_line1" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="contact_line2"><?php echo t("Γραμμή"); ?> 2</label>
    <input type="text" id="contact_line2" class="listbox" value="">
</div>

<!-- ══ CTA ═══════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Κουμπί"); ?> CTA</div>

<div class="ody_builder_parameter">
    <label for="cta_label"><?php echo t("Κείμενο κουμπιού"); ?></label>
    <input type="text" id="cta_label" class="listbox" value="">
</div>

<div class="ody_builder_parameter">
    <label for="cta_style"><?php echo t("Στυλ κουμπιού"); ?></label>
    <select id="cta_style" class="listbox">
        <option value="widget-button-primary">Primary</option>
        <option value="widget-button-secondary">Secondary</option>
    </select>
</div>

<div class="ody_builder_parameter">
    <label for="cta_url">Link</label>
    <input type="text" id="cta_url" class="listbox" value="">
    <select class="selectLink listbox" onchange="wdgHeaderSetLink($(this).val()); $(this).val('');">
        <option value=""><?php echo t("ή επιλέξτε υπάρχουσα σελίδα"); ?></option>
        <option value="homepage"><?php echo t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ"); ?></option>
        <?php
        $q = "select pages.id as id, content_pages.title as title
              from pages, content_pages
              where content_pages.mainID=pages.id
              and content_pages.langID=" . $langID . "
              order by pages.sort, content_pages.title";
        foreach ($db->getRecords($q) as $row): ?>
            <option value="<?php echo $row->id; ?>"><?php echo $row->title; ?></option>
        <?php endforeach; ?>
        <option value="divider">--------------------------------------</option>
        <option value="nodeLinks"><?php echo t("Link για εγγραφή ενότητας") . " >>"; ?></option>
        <option value="divider">--------------------------------------</option>
        <option value="fileLinks"><?php echo t("Link για αρχείο") . " >>"; ?></option>
    </select>
</div>

<!-- ══ COLOR SCHEME ══════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>

<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" style="margin: 10px 0 20px;">
        <input type="checkbox" id="header_sticky" value="1">
        <p><?php echo t("Sticky Header"); ?></p>
    </div>
</div>

<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" style="margin: 10px 0 20px;">
        <input type="checkbox" id="header_transparent" value="1">
        <p><?php echo t("Transparent Header (πάνω από hero)"); ?></p>
    </div>
</div>

<div class="ody_builder_parameter">
    <label for="responsive_break"><?php echo t("Responsive Breakpoint (px)"); ?></label>
    <input type="number" id="responsive_break" class="listbox" value="990" min="480" max="1400" style="max-width:100px;">
</div>

<!-- ══ HTML MARKUP ═══════════════════════════════════════════════════════════ -->

<!-- Hidden link pickers -->
<a id="wdg_hdr_node_popup" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]cta_url">iFrame</a>
<a id="wdg_hdr_file_popup" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]cta_url">iFrame</a>

<script>
jQuery(function ($) {
    var _p = _saved_params || {};

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def || '');
    }

    // ── Φόρτωση τιμών (edit mode) ─────────────────────────────────────────────
    $('#logo_text').val(pval('logo_text'));
    $('#logo_max_width').val(pval('logo_max_width', '250'));
    $('#contact_line1').val(pval('contact_line1'));
    $('#contact_line2').val(pval('contact_line2'));
    $('#cta_label').val(pval('cta_label'));
    $('#cta_url').val(pval('cta_url'));
    $('#color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#menu_name').val(pval('menu_name'));
    $('#cta_style').val(pval('cta_style', 'widget-button-secondary'));
    if (pval('header_sticky')      === '1') $('#header_sticky').prop('checked', true);
    if (pval('header_transparent') === '1') $('#header_transparent').prop('checked', true);
    $('#responsive_break').val(pval('responsive_break', '990'));

    // ── Image loader ──────────────────────────────────────────────────────────
    function loadImage(id, path) {
        if (!path) return;
        $('#' + id).val(path);
        $('#' + id + '_display').text(path.split('/').pop());
        $('#' + id + '_preview').attr('src', path).show();
        $('#' + id + '_remove').css('visibility', 'visible');
    }

    loadImage('logo_default',     pval('logo_default'));
    loadImage('logo_transparent', pval('logo_transparent'));

    // ── VenoBox ───────────────────────────────────────────────────────────────
    window.venobox = new VenoBox({selector: '.ody_builder_select_media', fitView: true, ratio: 'full'});
    new VenoBox({selector: '#wdg_hdr_node_popup', fitView: true, ratio: 'full'});
    new VenoBox({selector: '#wdg_hdr_file_popup', fitView: true, ratio: 'full'});

    $('.ody_builder_select_media').on('click', function () {
        window._wdg_mediabank_caller = this;
    });

    // ── Mediabank callback ────────────────────────────────────────────────────
    window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
        var targetId = $(callerEl).data('wdg-target');
        if (!targetId) return;
        var fullPath = image_path + id + '.' + ext;
        $('#' + targetId).val(fullPath);
        $('#' + targetId + '_display').text(file);
        $('#' + targetId + '_preview').attr('src', fullPath).show();
        $('#' + targetId + '_remove').css('visibility', 'visible');
    };

    // ── CTA link picker ───────────────────────────────────────────────────────
    window.wdgHeaderSetLink = function (id) {
        if (!id || id === 'divider') return;
        if (id === 'nodeLinks') { document.getElementById('wdg_hdr_node_popup').click(); return; }
        if (id === 'fileLinks') { document.getElementById('wdg_hdr_file_popup').click(); return; }
        var link = (id === 'homepage')
            ? 'index.php'
            : '««index.php?section=pages~|||~view=render~|||~id=' + id + '»»';
        $('#cta_url').val(link);
    };

    // ── Label & header ────────────────────────────────────────────────────────
    label = 'Widget Site Header';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Site Header');

    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function () {
        return {
            widget_id: 'header',
            params: {
                logo_default:     $('#logo_default').val(),
                logo_transparent: $('#logo_transparent').val(),
                logo_text:        $('#logo_text').val(),
                logo_max_width:   $('#logo_max_width').val(),
                menu_name:        $('#menu_name').val(),
                contact_line1:    $('#contact_line1').val(),
                contact_line2:    $('#contact_line2').val(),
                cta_label:        $('#cta_label').val(),
                cta_url:          $('#cta_url').val(),
                cta_style:        $('#cta_style').val(),
                color_scheme:     $('#color_scheme').val(),
                header_sticky:    $('#header_sticky').is(':checked') ? '1' : '',
                header_transparent: $('#header_transparent').is(':checked') ? '1' : '',
                responsive_break:   $('#responsive_break').val()
            }
        };
    };
});
</script>
