<?php defined('CMS') or die("This file cannot run this way!"); ?>

<?php
$_sct_days = [
    'monday'    => t('Δευτέρα'),
    'tuesday'   => t('Τρίτη'),
    'wednesday' => t('Τετάρτη'),
    'thursday'  => t('Πέμπτη'),
    'friday'    => t('Παρασκευή'),
    'saturday'  => t('Σάββατο'),
    'sunday'    => t('Κυριακή'),
];
?>

<style>
    .ody_builder_parameter { max-width: 500px !important; }
    /* ── Day tabs ── */
    .wdg-sct-day-tabs { display:flex; gap:4px; flex-wrap:wrap; margin-bottom:12px; }
    .wdg-sct-day-tab { padding:5px 12px; background:#eee; border:none; border-radius:4px; cursor:pointer; font-size:12px; font-weight:bold; }
    .wdg-sct-day-tab.is-active { background:#002e3a; color:white; }
    .wdg-sct-day-panel { display:none; }
    .wdg-sct-day-panel.is-active { display:block; }
    /* ── Time row ── */
    .wdg-sct-time-row { display:flex; gap:6px; align-items:center; flex-wrap:wrap; }
    .wdg-sct-time-row .listbox { max-width:75px !important; }
    .wdg-sct-time-row .wdg-sct-fmt { max-width:90px !important; }
    .wdg-sct-time-sep { font-weight:bold; color:#555; }
    /* ── Info blocks ── */
    .wdg-sct-info-item { border:1px solid #ccc; border-radius:4px; margin-bottom:6px; background:#f0f4f4; }
    .wdg-sct-info-header { display:flex; align-items:center; gap:8px; padding:5px 8px; background:#002e3a; border-radius:4px 4px 0 0; cursor:move; }
    .wdg-sct-info-header span { color:white; font-size:11px; flex:1; }
    .wdg-sct-info-body { padding:8px; }
    .wdg-sct-info-body .ody_builder_parameter { max-width:100% !important; margin-bottom:5px; }
</style>

<!-- ══ ΓΕΝΙΚΑ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_sct_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_sct_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_sct_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_sct_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_sct_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_sct_description" class="listbox" value="">
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ═════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_sct_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_sct_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_sct_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_sct_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_sct_header_align"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_sct_header_align" class="listbox">
        <option value="left"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_sct_week_start"><?php echo t("Έναρξη Εβδομάδας"); ?></label>
    <select id="wdg_sct_week_start" class="listbox">
        <option value="monday"><?php echo t("Δευτέρα"); ?></option>
        <option value="sunday"><?php echo t("Κυριακή"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_sct_layout_reverse" value="1">
        <p><?php echo t("Αντίστροφη διάταξη (sidebar αριστερά)"); ?></p>
    </div>
</div>

<!-- ══ ΩΡΑΡΙΟ ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Ωράριο"); ?></div>

<div class="wdg-sct-day-tabs">
    <?php foreach ($_sct_days as $day_key => $day_label): ?>
    <button type="button"
            class="wdg-sct-day-tab ody_builder_content_action<?php echo $day_key === 'monday' ? ' is-active' : ''; ?>"
            data-day="<?php echo $day_key; ?>">
        <?php echo $day_label; ?>
    </button>
    <?php endforeach; ?>
</div>

<?php foreach ($_sct_days as $day_key => $day_label): ?>
<div class="wdg-sct-day-panel<?php echo $day_key === 'monday' ? ' is-active' : ''; ?>"
     id="wdg_sct_panel_<?php echo $day_key; ?>">

    <div class="ody_builder_parameter">
        <div class="admin_checkbox_wrapper" style="margin: 10px 0 12px;">
            <input type="checkbox" id="wdg_sct_closed_<?php echo $day_key; ?>"
                   class="wdg-sct-closed-chk" data-day="<?php echo $day_key; ?>" value="1">
            <p><?php echo t("Κλειστό"); ?></p>
        </div>
    </div>

    <div id="wdg_sct_hours_<?php echo $day_key; ?>" class="wdg-sct-hours-wrap">
        <div class="ody_builder_parameter">
            <label><?php echo t("Ώρα Ανοίγματος"); ?></label>
            <div class="wdg-sct-time-row">
                <input type="number" id="wdg_sct_open_h_<?php echo $day_key; ?>" class="listbox" min="0" max="23" step="1" value="0">
                <span class="wdg-sct-time-sep">:</span>
                <input type="number" id="wdg_sct_open_m_<?php echo $day_key; ?>" class="listbox" min="0" max="59" step="1" value="0">
                <select id="wdg_sct_open_f_<?php echo $day_key; ?>" class="listbox wdg-sct-fmt">
                    <option value="24"><?php echo t("24ωρο"); ?></option>
                    <option value="AM"><?php echo t("ΠΜ"); ?></option>
                    <option value="PM"><?php echo t("ΜΜ"); ?></option>
                </select>
            </div>
        </div>
        <div class="ody_builder_parameter">
            <label><?php echo t("Ώρα Κλεισίματος"); ?></label>
            <div class="wdg-sct-time-row">
                <input type="number" id="wdg_sct_close_h_<?php echo $day_key; ?>" class="listbox" min="0" max="23" step="1" value="0">
                <span class="wdg-sct-time-sep">:</span>
                <input type="number" id="wdg_sct_close_m_<?php echo $day_key; ?>" class="listbox" min="0" max="59" step="1" value="0">
                <select id="wdg_sct_close_f_<?php echo $day_key; ?>" class="listbox wdg-sct-fmt">
                    <option value="24"><?php echo t("24ωρο"); ?></option>
                    <option value="AM"><?php echo t("ΠΜ"); ?></option>
                    <option value="PM"><?php echo t("ΜΜ"); ?></option>
                </select>
            </div>
        </div>
    </div>

</div>
<?php endforeach; ?>

<!-- ══ ΣΗΜΕΙΩΣΗ ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Σημείωση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_sct_note"><?php echo t("Σημείωση (κάτω από τον πίνακα)"); ?></label>
    <textarea id="wdg_sct_note" class="listbox" rows="2" style="resize:vertical;"></textarea>
</div>

<!-- ══ INFO BLOCKS ═══════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Πληροφορίες εβδομάδας στο sidebar"); ?></div>

<div id="wdg_sct_info_container" class="ody_builder_parameter">
    <div id="wdg_sct_info_list"></div>
    <button type="button" id="wdg_sct_add_info_btn" class="ody_builder_content_action btn btn-success" style="margin-top:6px;">
        + <?php echo t("Προσθήκη πληροφορίας εβδομάδας"); ?>
    </button>
</div>

<script>
jQuery(function ($) {
    var _p        = _saved_params || {};
    var _days_data = _p['days'] || {};
    var _info_idx  = 0;

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    var _days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];

    // ── Restore scalars ────────────────────────────────────────────────────────
    $('#wdg_sct_eyebrow').val(pval('eyebrow'));
    $('#wdg_sct_title').val(pval('title'));
    $('#wdg_sct_description').val(pval('description'));
    $('#wdg_sct_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_sct_container_width').val(pval('container_width', 'xl'));
    $('#wdg_sct_header_align').val(pval('header_align', 'center'));
    $('#wdg_sct_week_start').val(pval('week_start', 'monday'));
    
    // Note restore: base64 με [equal] → decode
    var noteVal = pval('note', '');
    if (noteVal) {
        $('#wdg_sct_note').val(atob(noteVal.replace(/\[equal\]/g, '=')));
    }
    
    if (pval('layout_reverse') == '1') $('#wdg_sct_layout_reverse').prop('checked', true);

    // ── Day tabs ───────────────────────────────────────────────────────────────
    $('.wdg-sct-day-tab').on('click', function() {
        $('.wdg-sct-day-tab').removeClass('is-active');
        $(this).addClass('is-active');
        $('.wdg-sct-day-panel').removeClass('is-active');
        $('#wdg_sct_panel_' + $(this).data('day')).addClass('is-active');
    });

    // ── Closed checkbox toggle ─────────────────────────────────────────────────
    $(document).on('change', '.wdg-sct-closed-chk', function() {
        var day = $(this).data('day');
        if ($(this).is(':checked')) {
            $('#wdg_sct_hours_' + day).hide();
        } else {
            $('#wdg_sct_hours_' + day).show();
        }
    });

    // ── Format change: adjust max hour + convert value ────────────────────────
    $(document).on('change', '.wdg-sct-fmt', function() {
        var fmt  = $(this).val();
        var maxH = (fmt === '24') ? 23 : 12;
        var minH = (fmt === '24') ? 0  : 1;
        var $row = $(this).closest('.wdg-sct-time-row');
        var $hourInput = $row.find('input[type=number]').first();
        var currentH = parseInt($hourInput.val()) || 0;

        if (fmt !== '24' && currentH > 12) {
            $hourInput.val(currentH - 12);
        }

        $hourInput.attr('min', minH).attr('max', maxH);
    });

    // ── Restore days ───────────────────────────────────────────────────────────
    _days.forEach(function(day) {
        var d = _days_data[day] || {};

        if (d.closed == '1') {
            $('#wdg_sct_closed_' + day).prop('checked', true);
            $('#wdg_sct_hours_' + day).hide();
        }

        if (d.open_h  !== undefined) $('#wdg_sct_open_h_'  + day).val(d.open_h);
        if (d.open_m  !== undefined) $('#wdg_sct_open_m_'  + day).val(d.open_m);
        if (d.open_f  !== undefined) $('#wdg_sct_open_f_'  + day).val(d.open_f);
        if (d.close_h !== undefined) $('#wdg_sct_close_h_' + day).val(d.close_h);
        if (d.close_m !== undefined) $('#wdg_sct_close_m_' + day).val(d.close_m);
        if (d.close_f !== undefined) $('#wdg_sct_close_f_' + day).val(d.close_f);
    });

    // ── Info blocks ────────────────────────────────────────────────────────────
    function addInfoBlock(data) {
        data = data || {};
        var ii  = _info_idx++;
        var uid = 'sct_info_' + ii;

        var $item = $('<div class="wdg-sct-info-item" data-ii="' + ii + '">');
        $item.append(
            '<div class="wdg-sct-info-header">' +
            '<span><?php echo t("Πληροφορία εβδομάδας"); ?> ' + (ii + 1) + '</span>' +
            '<button type="button" class="wdg-item-remove" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );

        var $body = $('<div class="wdg-sct-info-body">');

        // Title
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?></label>' +
            '<input type="text" id="wdg_sct_info_title_' + uid + '" class="listbox" value="' + $('<div>').text(data.title || '').html() + '"></div>'
        );

        // Text — restore από base64 με [equal]
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label>' +
            '<textarea id="wdg_sct_info_text_' + uid + '" class="listbox" rows="4"></textarea></div>'
        );
        $item.append($body);
        $('#wdg_sct_info_list').append($item);

        // Restore text
        var textVal = data.text || '';
        if (textVal) {
            $('#wdg_sct_info_text_' + uid).val(atob(textVal.replace(/\[equal\]/g, '=')));
        }

        $item.find('.wdg-item-remove').on('click', function() {
            $item.fadeOut(200, function() { $item.remove(); renumberInfoBlocks(); });
        });

        if ($.fn.sortable) {
            $('#wdg_sct_info_list').sortable({
                handle: '.wdg-sct-info-header',
                placeholder: 'block-placeholder',
                tolerance: 'pointer',
                stop: function() { renumberInfoBlocks(); }
            });
        }
    }

    function renumberInfoBlocks() {
        $('#wdg_sct_info_list .wdg-sct-info-item').each(function(idx) {
            $(this).find('.wdg-sct-info-header span').text('<?php echo t("Πληροφορία εβδομάδας"); ?> ' + (idx + 1));
        });
    }

    var _info_blocks = _p['info_blocks'] || [];
    _info_blocks.forEach(function(b) { addInfoBlock(b); });
    $('#wdg_sct_add_info_btn').on('click', function() { addInfoBlock({}); });

    // ── Label ─────────────────────────────────────────────────────────────────
    var label = 'Widget Schedule Table';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Schedule Table');

    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function() {
        var days = {};
        _days.forEach(function(day) {
            days[day] = {
                closed:  $('#wdg_sct_closed_'  + day).is(':checked') ? '1' : '0',
                open_h:  $('#wdg_sct_open_h_'  + day).val(),
                open_m:  $('#wdg_sct_open_m_'  + day).val(),
                open_f:  $('#wdg_sct_open_f_'  + day).val(),
                close_h: $('#wdg_sct_close_h_' + day).val(),
                close_m: $('#wdg_sct_close_m_' + day).val(),
                close_f: $('#wdg_sct_close_f_' + day).val()
            };
        });

        var info_blocks = [];
        $('#wdg_sct_info_list .wdg-sct-info-item').each(function() {
            var ii  = $(this).data('ii');
            var uid = 'sct_info_' + ii;
            var textVal = $('#wdg_sct_info_text_' + uid).val();
            var encoded = '';
            if (textVal !== '') {
                encoded = btoa(unescape(encodeURIComponent(textVal))).replace(/=/g, '[equal]');
            }
            info_blocks.push({
                title: $('#wdg_sct_info_title_' + uid).val(),
                text:  encoded
            });
        });

        var noteVal = $('#wdg_sct_note').val();
        var noteEncoded = '';
        if (noteVal !== '') {
            noteEncoded = btoa(unescape(encodeURIComponent(noteVal))).replace(/=/g, '[equal]');
        }

        return {
            widget_id: 'schedule_table',
            params: {
                eyebrow:         $('#wdg_sct_eyebrow').val(),
                title:           $('#wdg_sct_title').val(),
                description:     $('#wdg_sct_description').val(),
                color_scheme:    $('#wdg_sct_color_scheme').val(),
                container_width: $('#wdg_sct_container_width').val(),
                header_align:    $('#wdg_sct_header_align').val(),
                week_start:      $('#wdg_sct_week_start').val(),
                layout_reverse:  $('#wdg_sct_layout_reverse').is(':checked') ? '1' : '0',
                note:            noteEncoded,
                days:            days,
                info_blocks:     info_blocks
            }
        };
    };
});
</script>