<?php
/*
 * Widgetizer — Class Schedule Widget — view.php
 * Refactored: Fixed 24-hour format saving/restoring
 */
$_days = [
        'monday'    => t('Δευτέρα'),
        'tuesday'   => t('Τρίτη'),
        'wednesday' => t('Τετάρτη'),
        'thursday'  => t('Πέμπτη'),
        'friday'    => t('Παρασκευή'),
        'saturday'  => t('Σάββατο'),
        'sunday'    => t('Κυριακή'),
];
$_levels = [
        ''             => t('Όλα τα επίπεδα'),
        'beginner'     => t('Αρχάριοι'),
        'intermediate' => t('Μέσο επίπεδο'),
        'advanced'     => t('Προχωρημένοι'),
];
// Page list για link pickers
$q = "select pages.id as id, content_pages.title as title
      from pages, content_pages
      where content_pages.mainID=pages.id
      and content_pages.langID=" . $langID . "
      order by pages.sort, content_pages.title";
$_pages = $db->getRecords($q);
?>
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

    /* ── Day tabs ── */
    .wdg-cs-day-tabs {
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .wdg-cs-day-tab {
        padding: 5px 12px;
        background: #eee;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
    }

    .wdg-cs-day-tab.is-active {
        background: #002e3a;
        color: white;
    }

    .wdg-cs-day-panel {
        display: none;
    }

    .wdg-cs-day-panel.is-active {
        display: block;
    }

    /* ── Class items ── */
    .wdg-cs-class-item {
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 8px;
        background: #f9f9f9;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }

    .wdg-cs-class-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
    }

    .wdg-cs-class-header span {
        color: white;
        font-size: 12px;
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ── Move buttons styling ── */
    .wdg-cs-move-buttons {
        display: flex;
        gap: 4px;
        margin-right: 4px;
    }

    .wdg-cs-move-btn {
        background: transparent;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 11px;
        padding: 2px 4px;
        border-radius: 3px;
        transition: all 0.2s;
    }

    .wdg-cs-move-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .wdg-cs-move-btn:active {
        transform: scale(0.9);
    }

    .wdg-cs-class-body {
        padding: 8px;
    }

    .wdg-cs-class-body .ody_builder_parameter {
        max-width: 100% !important;
        margin-bottom: 6px;
    }

    .wdg-cs-add-class-btn {
        display: inline-block;
        padding: 5px 14px;
        background: #002e3a;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        margin-top: 6px;
    }

    .wdg-cs-add-class-btn:hover {
        background: #004a5c;
    }
    
    .block-placeholder {
        background: #e0f0f0;
        border: 2px dashed #002e3a;
        height: 60px;
        margin-bottom: 8px;
        border-radius: 4px;
    }
</style>

<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_cs_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_cs_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_cs_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_cs_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_cs_subheading"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_cs_subheading" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_cs_footer_notes"><?php echo t("Σημειώσεις στο footer"); ?></label>
    <textarea id="wdg_cs_footer_notes" class="listbox" rows="2" style="resize:vertical;"></textarea>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_cs_header_align"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_cs_header_align" class="listbox">
        <option value="start"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_cs_layout">Layout</label>
    <select id="wdg_cs_layout" class="listbox">
        <option value="tabs">Tabs</option>
        <option value="accordion">Accordion</option>
        <option value="list">List</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_cs_default_day"><?php echo t("Προεπιλεγμένη Μέρα"); ?></label>
    <select id="wdg_cs_default_day" class="listbox">
        <option value="today"><?php echo t("Σήμερα"); ?></option>
        <option value="monday"><?php echo t("Δευτέρα"); ?></option>
        <option value="tuesday"><?php echo t("Τρίτη"); ?></option>
        <option value="wednesday"><?php echo t("Τετάρτη"); ?></option>
        <option value="thursday"><?php echo t("Πέμπτη"); ?></option>
        <option value="friday"><?php echo t("Παρασκευή"); ?></option>
        <option value="saturday"><?php echo t("Σάββατο"); ?></option>
        <option value="sunday"><?php echo t("Κυριακή"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_cs_week_start"><?php echo t("Έναρξη Εβδομάδας"); ?></label>
    <select id="wdg_cs_week_start" class="listbox">
        <option value="monday"><?php echo t("Δευτέρα"); ?></option>
        <option value="sunday"><?php echo t("Κυριακή"); ?></option>
    </select>
</div>

<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_cs_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_cs_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_cs_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_cs_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>

<div class="wdg-section-title"><?php echo t("Πρόγραμμα"); ?></div>

<div class="wdg-cs-day-tabs">
    <?php foreach($_days as $day_key => $day_label): ?>
        <button type="button" class="wdg-cs-day-tab<?php echo $day_key === 'monday' ? ' is-active' : ''; ?>"
                data-day="<?php echo $day_key; ?>">
            <?php echo $day_label; ?>
        </button>
    <?php endforeach; ?>
</div>

<?php foreach($_days as $day_key => $day_label): ?>
    <div class="wdg-cs-day-panel<?php echo $day_key === 'monday' ? ' is-active' : ''; ?>"
         id="wdg_cs_panel_<?php echo $day_key; ?>" data-day="<?php echo $day_key; ?>">
        <div class="ody_builder_parameter" style="margin: 0;">
            <div class="admin_checkbox_wrapper">
                <input type="checkbox" style="margin-top: 2px !important;" id="wdg_cs_enabled_<?php echo $day_key; ?>" class="wdg-cs-day-enabled" value="1">
                <p><?php echo t("Ενεργή μέρα"); ?></p>
            </div>
        </div>
        <div id="wdg_cs_classes_<?php echo $day_key; ?>" class="wdg-cs-classes-list"></div>
        <button type="button" class="wdg-cs-add-class-btn" data-day="<?php echo $day_key; ?>">
            + <?php echo t("Προσθήκη Μαθήματος"); ?>
        </button>
    </div>
<?php endforeach; ?>

<div id="wdg_cs_popups_container" style="display:none;"></div>

<?php
// Page options για link pickers
$_page_opts_html = '<option value="">' . t("ή επιλέξτε υπάρχουσα σελίδα") . '</option>';
$_page_opts_html .= '<option value="homepage">' . t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ") . '</option>';
foreach($_pages as $row) {
    $_page_opts_html .= '<option value="' . $row->id . '">' . htmlspecialchars($row->title) . '</option>';
}
$_page_opts_html .= '<option value="divider">--------------------------------------</option>';
$_page_opts_html .= '<option value="nodeLinks_cs">' . t("Link για εγγραφή ενότητας") . ' >></option>';
$_page_opts_html .= '<option value="divider">--------------------------------------</option>';
$_page_opts_html .= '<option value="fileLinks_cs">' . t("Link για αρχείο") . ' >></option>';
?>

<script>
jQuery(function ($) {
    // ── Κανόνας 4: Απομόνωση PHP tags από inline JS strings ───────────────────
    var transClass      = <?php echo json_encode(t("Μάθημα")); ?>;
    var transRemove     = <?php echo json_encode(t("Αφαίρεση")); ?>;
    var transMoveUp     = <?php echo json_encode(t("Μετακίνηση πάνω")); ?>;
    var transMoveDown   = <?php echo json_encode(t("Μετακίνηση κάτω")); ?>;
    var transHour       = <?php echo json_encode(t("Ώρα")); ?>;
    var transDuration   = <?php echo json_encode(t("Διάρκεια σε λεπτά")); ?>;
    var transClassTitle = <?php echo json_encode(t("Τίτλος Μαθήματος")); ?>;
    var transInstructor = <?php echo json_encode(t("Εκπαιδευτής")); ?>;
    var transLevel      = <?php echo json_encode(t("Επίπεδο δυσκολίας")); ?>;
    var transDescription= <?php echo json_encode(t("Περιγραφή")); ?>;
    var transBtnLabel   = <?php echo json_encode(t("Κείμενο κουμπιού")); ?>;
    var transNewTab     = <?php echo json_encode(t("Άνοιγμα σε νέο tab")); ?>;
    var transAllLevels  = <?php echo json_encode(t("Όλα τα επίπεδα")); ?>;
    var transBeginner   = <?php echo json_encode(t("Αρχάριοι")); ?>;
    var transIntermed   = <?php echo json_encode(t("Μέσο επίπεδο")); ?>;
    var transAdvanced   = <?php echo json_encode(t("Προχωρημένοι")); ?>;

    var _p = _saved_params || {};
    var _days_data = _p['days'] || {};

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    // ── Φόρτωση γενικών ──────────────────────────────────────────────────────
    $('#wdg_cs_eyebrow').val(pval('eyebrow'));
    $('#wdg_cs_title').val(pval('title'));
    $('#wdg_cs_subheading').val(pval('subheading'));
    $('#wdg_cs_footer_notes').val(pval('footer_notes'));
    $('#wdg_cs_header_align').val(pval('header_align', 'center'));
    $('#wdg_cs_layout').val(pval('layout', 'tabs'));
    $('#wdg_cs_default_day').val(pval('default_day', 'today'));
    $('#wdg_cs_week_start').val(pval('week_start', 'monday'));
    $('#wdg_cs_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_cs_container_width').val(pval('container_width', 'xl'));
    
    // ── Page options ──────────────────────────────────────────────────────────
    var _page_opts = <?php echo json_encode($_page_opts_html); ?>;
    
    // ── Levels ────────────────────────────────────────────────────────────────
    var _level_opts =
            '<option value="">' + transAllLevels + '</option>' +
            '<option value="beginner">' + transBeginner + '</option>' +
            '<option value="intermediate">' + transIntermed + '</option>' +
            '<option value="advanced">' + transAdvanced + '</option>';
    
    // ── Day tabs ──────────────────────────────────────────────────────────────
    $('.wdg-cs-day-tab').on('click', function () {
        var day = $(this).data('day');
        $('.wdg-cs-day-tab').removeClass('is-active');
        $(this).addClass('is-active');
        $('.wdg-cs-day-panel').removeClass('is-active');
        $('#wdg_cs_panel_' + day).addClass('is-active');
    });
    
    // ── Helper function to escape HTML ────────────────────────────────────────
    function escapeHtml(str) {
        if(!str) return '';
        return str.replace(/&/g, '&amp;')
                  .replace(/</g, '&lt;')
                  .replace(/>/g, '&gt;')
                  .replace(/"/g, '&quot;')
                  .replace(/'/g, '&#39;');
    }
    
    // ── Helper function to update time hour max/min based on format ──────────
    function updateTimeHourLimits($item) {
        var fmt = $item.find('.wdg-cs-time-format').val();
        var maxH = (fmt === '24') ? 23 : 12;
        var minH = (fmt === '24') ? 0 : 1;
        var $hourInput = $item.find('.wdg-cs-time-hour');
        var currentVal = parseInt($hourInput.val()) || 0;
        $hourInput.attr('max', maxH).attr('min', minH);
        if (currentVal > maxH) $hourInput.val(maxH);
        if (currentVal < minH) $hourInput.val(minH);
    }

    // ── Live Header Titles Update ────────────────────────────────────────────
    function updateItemHeaderTitle($item, day) {
        var titleVal = $item.find('.wdg-cs-class-title').val();
        var itemIdx = $('#wdg_cs_classes_' + day + ' .wdg-cs-class-item').index($item) + 1;
        var displayTxt = transClass + ' ' + itemIdx;
        if (titleVal && titleVal.trim() !== '') {
            displayTxt += ': ' + titleVal;
        }
        $item.find('.wdg-cs-class-header span').text(displayTxt);
    }

    // ── Move functions with smooth animations and focus scroll ──────────────
    function moveItemUp($item, day) {
        var $prev = $item.prev('.wdg-cs-class-item');
        var speed = 120;
        if ($prev.length) {
            $item.slideUp(speed, function() {
                $item.insertBefore($prev);
                $item.slideDown(speed, function() {
                    renumberDayItems(day);
                    $('html, body').animate({
                        scrollTop: $item.offset().top - 100
                    }, 300);
                    $item.css('box-shadow', '0 0 0 2px #fbbf24');
                    setTimeout(function() { $item.css('box-shadow', ''); }, 300);
                });
            });
        }
    }

    function moveItemDown($item, day) {
        var $next = $item.next('.wdg-cs-class-item');
        var speed = 120;
        if ($next.length) {
            $item.slideUp(speed, function() {
                $item.insertAfter($next);
                $item.slideDown(speed, function() {
                    renumberDayItems(day);
                    $('html, body').animate({
                        scrollTop: $item.offset().top - 100
                    }, 300);
                    $item.css('box-shadow', '0 0 0 2px #fbbf24');
                    setTimeout(function() { $item.css('box-shadow', ''); }, 300);
                });
            });
        }
    }
    
    // ── Class item repeater ───────────────────────────────────────────────────
    var _class_idx = {};
    var _days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    _days.forEach(function (day) {
        _class_idx[day] = 0;
    });

    function addClassItem(day, data) {
        data = data || {};
        var idx = _class_idx[day]++;
        var uid = day + '_' + idx;
        var urlId = 'wdg_cs_url_' + uid;
        var nodePopupId = 'wdg_cs_node_' + uid;
        var filePopupId = 'wdg_cs_file_' + uid;
        
        var timeHour = (data.time_hour !== undefined && data.time_hour !== '') ? data.time_hour : '';
        var timeMin = (data.time_min !== undefined && data.time_min !== '') ? data.time_min : '00';
        var timeFmt = (data.time_format !== undefined && data.time_format !== '') ? data.time_format : 'AM';
        
        var maxH = (timeFmt === '24') ? 23 : 12;
        var minH = (timeFmt === '24') ? 0 : 1;
        
        var $item = $('<div class="wdg-cs-class-item" data-idx="' + idx + '">');
        
        // Header with move buttons using pure JS variables (Rule 4 safe)
        $item.append(
            '<div class="wdg-cs-class-header">' +
            '<div class="wdg-cs-move-buttons">' +
            '<button type="button" class="wdg-cs-move-btn wdg-cs-move-up" title="' + transMoveUp + '">▲</button>' +
            '<button type="button" class="wdg-cs-move-btn wdg-cs-move-down" title="' + transMoveDown + '">▼</button>' +
            '</div>' +
            '<span>' + transClass + ' ' + ($('#wdg_cs_classes_' + day + ' .wdg-cs-class-item').length + 1) + '</span>' +
            '<button class="wdg-item-remove" type="button" title="' + transRemove + '">✕</button>' +
            '</div>'
        );
        
        var $body = $('<div class="wdg-cs-class-body">');
        
        // Time
        $body.append(
            '<div class="ody_builder_parameter"><label>' + transHour + '</label>' +
            '<div style="display:flex;gap:6px;align-items:center;">' +
            '<input type="number" class="listbox wdg-cs-time-hour" min="' + minH + '" max="' + maxH + '" step="1" style="max-width:70px;" value="' + escapeHtml(timeHour) + '">' +
            '<span>:</span>' +
            '<input type="number" class="listbox wdg-cs-time-min" min="0" max="59" step="1" style="max-width:70px;" value="' + escapeHtml(timeMin) + '">' +
            '<select class="listbox wdg-cs-time-format" style="max-width:90px !important;">' +
            '<option value="AM">ΠΜ</option>' +
            '<option value="PM">ΜΜ</option>' +
            '<option value="24">24ωρο</option>' +
            '</select>' +
            '</div></div>'
        );
        
        // Duration
        $body.append('<div class="ody_builder_parameter"><label>' + transDuration + '</label>' +
            '<input type="number" class="listbox wdg-cs-duration" min="1" max="480" step="1" style="max-width:100px;" value="' + escapeHtml(data.duration || '') + '"></div>');
        
        // Title
        $body.append('<div class="ody_builder_parameter"><label>' + transClassTitle + '</label>' +
            '<input type="text" class="listbox wdg-cs-class-title" value="' + escapeHtml(data.title || '') + '"></div>');
        
        // Instructor
        $body.append('<div class="ody_builder_parameter"><label>' + transInstructor + '</label>' +
            '<input type="text" class="listbox wdg-cs-instructor" value="' + escapeHtml(data.instructor || '') + '"></div>');
        
        // Level
        $body.append('<div class="ody_builder_parameter"><label>' + transLevel + '</label>' +
            '<select class="listbox wdg-cs-level" style="max-width: 177px !important;">' + _level_opts + '</select></div>');
        
        // Description
        $body.append('<div class="ody_builder_parameter"><label>' + transDescription + '</label>' +
            '<textarea class="listbox wdg-cs-description">' + escapeHtml(data.description || '') + '</textarea></div>');
        
        // Book label
        $body.append('<div class="ody_builder_parameter"><label>' + transBtnLabel + '</label>' +
            '<input type="text" class="listbox wdg-cs-book-label" value="' + escapeHtml(data.book_label || '') + '"></div>');
        
        // Book URL + picker
        $body.append('<div class="ody_builder_parameter"><label>Link</label>' +
            '<input type="text" id="' + urlId + '" class="listbox wdg-cs-book-url" value="' + escapeHtml(data.book_url || '') + '">' +
            '<select class="selectLink listbox" onchange="wdgCsSetLink($(this).val(),\'' + urlId + '\',\'' + uid + '\'); $(this).val(\'\');">' +
            _page_opts + '</select></div>');
        
        // New tab checkbox
        var isNewTab = (data.book_new_tab == '1');
        $body.append('<div class="ody_builder_parameter"><div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">' +
            '<input type="checkbox" class="wdg-cs-book-new-tab" value="1" ' + (isNewTab ? 'checked' : '') + '>' +
            '<p>' + transNewTab + '</p></div></div>');
        
        $item.append($body);
        $('#wdg_cs_classes_' + day).append($item);
        
        if(data.level) $item.find('.wdg-cs-level').val(data.level);
        $item.find('.wdg-cs-time-format').val(timeFmt);
        updateTimeHourLimits($item);
        
        // Live title input sync
        $item.find('.wdg-cs-class-title').on('input', function() {
            updateItemHeaderTitle($item, day);
        });
        
        // ── Hidden popups ─────────────────────────────────────────────────────
        $('#wdg_cs_popups_container').append(
            '<a id="' + nodePopupId + '" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]' + urlId + '" style="display:none;">iFrame</a>' +
            '<a id="' + filePopupId + '" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]' + urlId + '" style="display:none;">iFrame</a>'
        );
        new VenoBox({selector: '#' + nodePopupId, fitView: true, ratio: 'full'});
        new VenoBox({selector: '#' + filePopupId, fitView: true, ratio: 'full'});
        
        // ── Remove button ─────────────────────────────────────────────────────
        $item.find('.wdg-item-remove').on('click', function () {
            $item.fadeOut(200, function () {
                $item.remove();
                renumberDayItems(day);
            });
        });

        // ── Move buttons events ───────────────────────────────────────────────
        $item.find('.wdg-cs-move-up').on('click', function(e) {
            e.stopPropagation();
            moveItemUp($item, day);
        });

        $item.find('.wdg-cs-move-down').on('click', function(e) {
            e.stopPropagation();
            moveItemDown($item, day);
        });

        updateItemHeaderTitle($item, day);
    }
    
    function renumberDayItems(day) {
        $('#wdg_cs_classes_' + day + ' .wdg-cs-class-item').each(function () {
            updateItemHeaderTitle($(this), day);
        });
    }
    
    // ── Φόρτωση αποθηκευμένων δεδομένων ──────────────────────────────────────
    _days.forEach(function (day) {
        var day_data = _days_data[day] || {};
        if(day_data.enabled == '1' || day_data.enabled === true) {
            $('#wdg_cs_enabled_' + day).prop('checked', true);
        }
        var classes = day_data.classes || [];
        classes.forEach(function (cls) {
            addClassItem(day, cls);
        });

        // ⚠️ Αρχικό Load & Renumbering ανά ημέρα
        renumberDayItems(day);
    });
    
    // ── Add class buttons ─────────────────────────────────────────────────────
    $('.wdg-cs-add-class-btn').on('click', function () {
        var day = $(this).data('day');
        addClassItem(day, {});
        var $lastItem = $('#wdg_cs_classes_' + day + ' .wdg-cs-class-item').last();
        if ($lastItem.length) {
            $('html, body').animate({
                scrollTop: $lastItem.offset().top - 100
            }, 300);
        }
    });
    
    // ── Link picker helper ────────────────────────────────────────────────────
    window.wdgCsSetLink = function (val, targetId, uid) {
        if(!val || val === 'divider') return;
        if(val === 'nodeLinks_cs') {
            document.getElementById('wdg_cs_node_' + uid).click();
            return;
        }
        if(val === 'fileLinks_cs') {
            document.getElementById('wdg_cs_file_' + uid).click();
            return;
        }
        var link = (val === 'homepage') ? 'index.php' :
                '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
        $('#' + targetId).val(link);
    };
    
    // ── Time format change event (delegation) ────────────────────────────────
    $(document).on('change', '.wdg-cs-time-format', function () {
        var $item = $(this).closest('.wdg-cs-class-item');
        updateTimeHourLimits($item);
    });
    
    // ── Label ─────────────────────────────────────────────────────────────────
    var label = 'Widget Class Schedule';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Class Schedule');
    
    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function () {
        var days = {};
        _days.forEach(function (day) {
            var classes = [];
            $('#wdg_cs_classes_' + day + ' .wdg-cs-class-item').each(function () {
                var $it = $(this);
                classes.push({
                    time_hour:    $it.find('.wdg-cs-time-hour').val(),
                    time_min:     $it.find('.wdg-cs-time-min').val(),
                    time_format:  $it.find('.wdg-cs-time-format').val(),
                    duration:     $it.find('.wdg-cs-duration').val(),
                    title:        $it.find('.wdg-cs-class-title').val(),
                    instructor:   $it.find('.wdg-cs-instructor').val(),
                    level:        $it.find('.wdg-cs-level').val(),
                    description:  $it.find('.wdg-cs-description').val(),
                    book_label:   $it.find('.wdg-cs-book-label').val(),
                    book_url:     $it.find('.wdg-cs-book-url').val(),
                    book_new_tab: $it.find('.wdg-cs-book-new-tab').is(':checked') ? '1' : '0'
                });
            });
            days[day] = {
                enabled: $('#wdg_cs_enabled_' + day).is(':checked') ? '1' : '0',
                classes: classes
            };
        });
        return {
            widget_id: 'class_schedule',
            params:    {
                eyebrow:         $('#wdg_cs_eyebrow').val(),
                title:           $('#wdg_cs_title').val(),
                subheading:      $('#wdg_cs_subheading').val(),
                footer_notes:    $('#wdg_cs_footer_notes').val(),
                header_align:    $('#wdg_cs_header_align').val(),
                layout:          $('#wdg_cs_layout').val(),
                default_day:     $('#wdg_cs_default_day').val(),
                week_start:      $('#wdg_cs_week_start').val(),
                color_scheme:    $('#wdg_cs_color_scheme').val(),
                container_width: $('#wdg_cs_container_width').val(),
                days:            days
            }
        };
    };
});
</script>