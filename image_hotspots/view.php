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

    /* Hotspot items */
    .wdg-imhs-item {
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 8px;
        background: #f9f9f9;
        transition: box-shadow 0.3s ease;
    }

    .wdg-imhs-item-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
    }

    .wdg-imhs-item-header span {
        color: white;
        font-size: 12px;
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .wdg-imhs-item-body {
        padding: 8px;
    }

    .wdg-imhs-item-body .ody_builder_parameter {
        max-width: 100% !important;
        margin-bottom: 6px;
    }

    #wdg_imhs_hotspots_container {
        max-width: 450px !important;
    }

    /* Position picker */
    .wdg-imhs-pos-info {
        font-size: 12px;
        color: #555;
        margin-top: 4px;
        font-style: italic;
    }

    .wdg-imhs-pos-btn {
        font-size: 12px;
        padding: 4px 10px;
    }

    .wdg-imhs-no-image-msg {
        font-size: 12px;
        color: #999;
        font-style: italic;
        margin-top: 6px;
    }

    /* Position picker modal */
    #wdg_imhs_pos_modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: rgba(0, 0, 0, 0.85);
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 12px;
    }

    #wdg_imhs_pos_modal.is-open {
        display: flex;
    }

    #wdg_imhs_pos_modal_inner {
        position: relative;
        max-width: 90vw;
        max-height: 80vh;
        cursor: crosshair;
        user-select: none;
    }

    #wdg_imhs_pos_modal_img {
        display: block;
        max-width: 90vw;
        max-height: 80vh;
        border-radius: 4px;
    }

    #wdg_imhs_pos_modal_marker {
        position: absolute;
        width: 20px;
        height: 20px;
        background: #e74c3c;
        border: 2px solid white;
        border-radius: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
        display: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
    }

    #wdg_imhs_pos_modal_info {
        color: white;
        font-size: 14px;
        text-align: center;
        min-height: 20px;
    }

    #wdg_imhs_pos_modal_actions {
        display: flex;
        gap: 10px;
    }

    #wdg_imhs_pos_modal_confirm {
        padding: 8px 20px;
        background: #27ae60;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    #wdg_imhs_pos_modal_cancel {
        padding: 8px 20px;
        background: #7f8c8d;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    #wdg_imhs_pos_modal_hint {
        color: #ccc;
        font-size: 12px;
    }

    /* ── Βελάκια μετακίνησης ── */
    .wdg-imhs-move-buttons { display: flex; gap: 4px; margin-right: 4px; }
    .wdg-imhs-move-btn { background: transparent; border: none; color: white; cursor: pointer; font-size: 12px; padding: 2px 4px; border-radius: 3px; transition: all 0.2s; }
    .wdg-imhs-move-btn:hover { background: rgba(255, 255, 255, 0.2); }
    .wdg-imhs-move-btn:active { transform: scale(0.9); }
</style>
<div style="display: table; max-width: 490px !important;">
    <!-- ══ POSITION PICKER MODAL ════════════════════════════════════════════════ -->
    <div id="wdg_imhs_pos_modal">
        <div id="wdg_imhs_pos_modal_inner">
            <img id="wdg_imhs_pos_modal_img" src="" alt="">
            <div id="wdg_imhs_pos_modal_marker"></div>
        </div>
        <div id="wdg_imhs_pos_modal_info"><?php echo t("Κάντε κλικ για να ορίσετε τη θέση"); ?></div>
        <div id="wdg_imhs_pos_modal_hint"><?php echo t("Κάντε κλικ στην εικόνα για να τοποθετήσετε το hotspot"); ?></div>
        <div id="wdg_imhs_pos_modal_actions">
            <button type="button" id="wdg_imhs_pos_modal_confirm"><?php echo t("Επιβεβαίωση"); ?></button>
            <button type="button" id="wdg_imhs_pos_modal_cancel"><?php echo t("Ακύρωση"); ?></button>
        </div>
    </div>
    <!-- ══ ΓΕΝΙΚΑ ════════════════════════════════════════════════════════════════ -->
    <div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>
    <div class="ody_builder_parameter">
        <label for="wdg_imhs_eyebrow">Eyebrow</label>
        <input type="text" id="wdg_imhs_eyebrow" class="listbox" value="">
    </div>
    <div class="ody_builder_parameter">
        <label for="wdg_imhs_title"><?php echo t("Τίτλος"); ?></label>
        <input type="text" id="wdg_imhs_title" class="listbox" value="">
    </div>
    <div class="ody_builder_parameter">
        <label for="wdg_imhs_description"><?php echo t("Περιγραφή"); ?></label>
        <textarea id="wdg_imhs_description" class="listbox" rows="3" style="resize:vertical;"></textarea>
    </div>
    <!-- ══ ΕΙΚΟΝΑ ════════════════════════════════════════════════════════════════ -->
    <div class="wdg-section-title"><?php echo t("Εικόνα"); ?></div>
    <div class="ody_builder_parameter">
        <label><?php echo t("Εικόνα"); ?></label>
        <div class="wdg-image-row">
            <span id="wdg_imhs_image_display" class="wdg-img-filename"><?php echo t('Επιλέξτε εικόνα'); ?>...</span>
            <a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>"
               class="ody_builder_content_action ody_builder_select_media btn btn-success"
               data-vbtype="iframe" data-wdg-target="wdg_imhs_image">
                <?php echo t("Επιλογή"); ?>
            </a>
            <a href="javascript:void(0)" id="wdg_imhs_image_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"
               onclick="wdgImhsClearImage();">
                <?php echo t("Αφαίρεση"); ?>
            </a>
        </div>
        <input type="hidden" id="wdg_imhs_image" value="">
        <img id="wdg_imhs_image_preview" class="wdg-img-preview" src="" alt="">
    </div>
    <!-- ══ ΕΜΦΑΝΙΣΗ ══════════════════════════════════════════════════════════════ -->
    <div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>
    <div class="ody_builder_parameter">
        <label for="wdg_imhs_hotspot_color_scheme"><?php echo t("Χρωματική παλέτα των hotspots"); ?></label>
        <select id="wdg_imhs_hotspot_color_scheme" class="listbox">
            <option value="color-scheme-standard-primary">Standard Primary</option>
            <option value="color-scheme-standard-secondary">Standard Secondary</option>
            <option value="color-scheme-highlight-primary">Highlight Primary</option>
            <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
        </select>
    </div>
    <div class="ody_builder_parameter">
        <label for="wdg_imhs_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
        <select id="wdg_imhs_color_scheme" class="listbox">
            <option value="color-scheme-standard-primary">Standard Primary</option>
            <option value="color-scheme-standard-secondary">Standard Secondary</option>
            <option value="color-scheme-highlight-primary">Highlight Primary</option>
            <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
        </select>
    </div>
    <div class="ody_builder_parameter">
        <label for="wdg_imhs_container_width"><?php echo t("Πλάτος Container"); ?></label>
        <select id="wdg_imhs_container_width" class="listbox">
            <option value="full">Full Width</option>
            <option value="xl">X-Large (1420px)</option>
            <option value="lg">Large (1200px)</option>
            <option value="md">Medium (960px)</option>
            <option value="sm">Small (760px)</option>
        </select>
    </div>
    <!-- ══ HOTSPOTS ══════════════════════════════════════════════════════════════ -->
    <div class="wdg-section-title"><?php echo t("📍 Hotspots"); ?></div>
    <div id="wdg_imhs_hotspots_container" class="ody_builder_parameter" style="max-width:700px !important;">
        <div id="wdg_imhs_hotspots_list"></div>
        <div id="wdg_imhs_add_wrapper">
            <button type="button" id="wdg_imhs_add_btn" class="btn btn-success" style="margin-top:6px; display:none;">
                + <?php echo t("Προσθήκη"); ?> Hotspot
            </button>
            <p id="wdg_imhs_no_image_msg" class="wdg-imhs-no-image-msg">
                <?php echo "⚠ " . t("Επιλέξτε πρώτα εικόνα για να προσθέσετε hotspots"); ?>
            </p>
        </div>
        <input type="hidden" id="wdg_imhs_hotspots" value="">
    </div>
    <div id="wdg_imhs_popups_container" style="display:none;"></div>

</div>
<?php
$q = "select pages.id as id, content_pages.title as title
      from pages, content_pages
      where content_pages.mainID=pages.id
      and content_pages.langID=" . $langID . "
      order by pages.sort, content_pages.title";
$_imhs_pages = $db->getRecords($q);
$_imhs_page_opts = '<option value="">' . t("ή επιλέξτε υπάρχουσα σελίδα") . '</option>';
$_imhs_page_opts .= '<option value="homepage">' . t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ") . '</option>';
foreach($_imhs_pages as $_imhs_row) {
    $_imhs_page_opts .= '<option value="' . $_imhs_row->id . '">' . htmlspecialchars($_imhs_row->title) . '</option>';
}
$_imhs_page_opts .= '<option value="divider">--------------------------------------</option>';
$_imhs_page_opts .= '<option value="nodeLinks_imhs">' . t("Link για εγγραφή ενότητας") . ' >></option>';
$_imhs_page_opts .= '<option value="divider">--------------------------------------</option>';
$_imhs_page_opts .= '<option value="fileLinks_imhs">' . t("Link για αρχείο") . ' >></option>';
?>
<script>
    jQuery(function ($) {
        var _p = _saved_params || {};
        var _item_idx = 0;
        var _page_opts = <?php echo json_encode($_imhs_page_opts); ?>;
        var _current_pos_target = null;
        var _pending_x = null;
        var _pending_y = null;

        function pval(key, def) {
            return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
        }

        // ── Φόρτωση τιμών ────────────────────────────────────────────────────
        $('#wdg_imhs_eyebrow').val(pval('eyebrow'));
        $('#wdg_imhs_title').val(pval('title'));
        $('#wdg_imhs_description').val(pval('description'));
        $('#wdg_imhs_hotspot_color_scheme').val(pval('hotspot_color_scheme', 'color-scheme-standard-primary'));
        $('#wdg_imhs_color_scheme').val(pval('color_scheme', 'color-scheme-standard-secondary'));
        $('#wdg_imhs_container_width').val(pval('container_width', 'xl'));

        // ── Image visibility helper ───────────────────────────────────────────
        function updateAddBtn() {
            var hasImage = !!$('#wdg_imhs_image').val();
            $('#wdg_imhs_add_btn').toggle(hasImage);
            $('#wdg_imhs_no_image_msg').toggle(!hasImage);
        }

        // ── Image load ────────────────────────────────────────────────────────
        var _saved_img = pval('image');
        if (_saved_img) {
            $('#wdg_imhs_image').val(_saved_img);
            $('#wdg_imhs_image_display').text(_saved_img.split('/').pop());
            $('#wdg_imhs_image_preview').attr('src', _saved_img).show();
            $('#wdg_imhs_image_remove').css('visibility', 'visible');
        }
        updateAddBtn();
        window.venobox = new VenoBox({selector: '.ody_builder_select_media', fitView: true, ratio: 'full'});
        $('.ody_builder_select_media').on('click', function () {
            window._wdg_mediabank_caller = this;
        });
        window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
            var targetId = $(callerEl || window._wdg_mediabank_caller).data('wdg-target');
            if (!targetId) return;
            var fullPath = image_path + id + '.' + ext;
            $('#' + targetId).val(fullPath);
            $('#' + targetId + '_display').text(file);
            $('#' + targetId + '_preview').attr('src', fullPath).show();
            $('#' + targetId + '_remove').css('visibility', 'visible');
            updateAddBtn();
        };
        window.wdgImhsClearImage = function () {
            $('#wdg_imhs_image').val('');
            $('#wdg_imhs_image_display').text('<?php echo t("Επιλέξτε εικόνα..."); ?>');
            $('#wdg_imhs_image_preview').hide().attr('src', '');
            $('#wdg_imhs_image_remove').css('visibility', 'hidden');
            updateAddBtn();
        };

        // ── Position Picker Modal ─────────────────────────────────────────────
        var $modal    = $('#wdg_imhs_pos_modal');
        var $modalImg = $('#wdg_imhs_pos_modal_img');
        var $marker   = $('#wdg_imhs_pos_modal_marker');
        var $info     = $('#wdg_imhs_pos_modal_info');
        var $inner    = $('#wdg_imhs_pos_modal_inner');

        function openPosPicker($item) {
            var imgSrc = $('#wdg_imhs_image').val();
            if (!imgSrc) return;
            _current_pos_target = $item;
            _pending_x = null;
            _pending_y = null;
            $marker.hide();
            $info.text('<?php echo t("Κάντε κλικ για να ορίσετε τη θέση"); ?>');
            $modalImg.attr('src', imgSrc);
            $modal.addClass('is-open');
        }

        function closePosModal() {
            $modal.removeClass('is-open');
            _current_pos_target = null;
            _pending_x = null;
            _pending_y = null;
        }

        $inner.on('click', function (e) {
            var rect = $modalImg[0].getBoundingClientRect();
            var x = Math.round(((e.clientX - rect.left) / rect.width) * 100);
            var y = Math.round(((e.clientY - rect.top) / rect.height) * 100);
            x = Math.max(0, Math.min(100, x));
            y = Math.max(0, Math.min(100, y));
            _pending_x = x;
            _pending_y = y;
            $marker.css({left: x + '%', top: y + '%'}).show();
            $info.text('X: ' + x + '%  —  Y: ' + y + '%');
        });

        $('#wdg_imhs_pos_modal_confirm').on('click', function () {
            if (_pending_x === null || !_current_pos_target) {
                closePosModal();
                return;
            }
            var $it = _current_pos_target;
            $it.find('.wdg-imhs-pos-x').val(_pending_x);
            $it.find('.wdg-imhs-pos-y').val(_pending_y);
            $it.find('.wdg-imhs-pos-info').text('X: ' + _pending_x + '%  —  Y: ' + _pending_y + '%');
            saveHotspots();
            closePosModal();
        });

        $('#wdg_imhs_pos_modal_cancel').on('click', closePosModal);
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') closePosModal();
        });

        // ── Link helper ───────────────────────────────────────────────────────
        window.wdgImhsSetLink = function (val, urlFieldId, idx) {
            if (!val || val === 'divider') return;
            if (val === 'nodeLinks_imhs') {
                document.getElementById('wdg_imhs_node_popup_' + idx).click();
                return;
            }
            if (val === 'fileLinks_imhs') {
                document.getElementById('wdg_imhs_file_popup_' + idx).click();
                return;
            }
            var link = (val === 'homepage')
                ? 'index.php'
                : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
            $('#' + urlFieldId).val(link);
        };

        // ── Save hotspots ─────────────────────────────────────────────────────
        function saveHotspots() {
            var items = [];
            $('#wdg_imhs_hotspots_list .wdg-imhs-item').each(function () {
                var $it = $(this);
                var idx = $it.data('idx');
                items.push({
                    title:       $it.find('.wdg-imhs-title').val(),
                    description: $it.find('.wdg-imhs-desc').val(),
                    pos_x:       $it.find('.wdg-imhs-pos-x').val(),
                    pos_y:       $it.find('.wdg-imhs-pos-y').val(),
                    btn_label:   $it.find('.wdg-imhs-btn-label').val(),
                    btn_url:     $('#wdg_imhs_url_' + idx).val(),
                    btn_style:   $it.find('.wdg-imhs-btn-style').val(),
                    btn_new_tab: $it.find('.wdg-imhs-btn-newtab').is(':checked') ? '1' : '0'
                });
            });
            $('#wdg_imhs_hotspots').val(JSON.stringify(items));
        }

        // ── Item display ──────────────────────────────────────────────────────
        function updateItemDisplay($item) {
            var titleVal = $item.find('.wdg-imhs-title').val();
            var itemNumber = $item.index() + 1;
            var displayText = 'Hotspot ' + itemNumber;
            if (titleVal && titleVal.trim() !== '') {
                displayText += ': ' + titleVal;
            }
            $item.find('.wdg-imhs-item-header span').text(displayText);
        }

        function renumberItems() {
            $('#wdg_imhs_hotspots_list .wdg-imhs-item').each(function () {
                updateItemDisplay($(this));
            });
        }

        // ── Move functions ────────────────────────────────────────────────────
        function moveItemUp($item) {
            var $prev = $item.prev('.wdg-imhs-item');
            if ($prev.length) {
                $item.slideUp(1, function () {
                    $item.insertBefore($prev);
                    $item.slideDown(1, function () {
                        renumberItems();
                        saveHotspots();
                        $('html, body').animate({ scrollTop: $item.offset().top - 100 }, 300);
                        $item.css('box-shadow', '0 0 0 2px #fbbf24');
                        setTimeout(function () { $item.css('box-shadow', ''); }, 100);
                    });
                });
            }
        }

        function moveItemDown($item) {
            var $next = $item.next('.wdg-imhs-item');
            if ($next.length) {
                $item.slideUp(1, function () {
                    $item.insertAfter($next);
                    $item.slideDown(1, function () {
                        renumberItems();
                        saveHotspots();
                        $('html, body').animate({ scrollTop: $item.offset().top - 100 }, 300);
                        $item.css('box-shadow', '0 0 0 2px #fbbf24');
                        setTimeout(function () { $item.css('box-shadow', ''); }, 100);
                    });
                });
            }
        }

        // ── Add Hotspot ───────────────────────────────────────────────────────
        function addItem(data) {
            data = data || {};
            var idx  = _item_idx++;
            var urlId  = 'wdg_imhs_url_' + idx;
            var nodeId = 'wdg_imhs_node_popup_' + idx;
            var fileId = 'wdg_imhs_file_popup_' + idx;
            var posX   = data.pos_x || '50';
            var posY   = data.pos_y || '50';

            var $item = $('<div class="wdg-imhs-item" data-idx="' + idx + '">');
            $item.append(
                '<div class="wdg-imhs-item-header">' +
                '<div class="wdg-imhs-move-buttons">' +
                '<button type="button" class="wdg-imhs-move-btn wdg-imhs-move-up" title="<?php echo t("Μετακίνηση πάνω"); ?>">▲</button>' +
                '<button type="button" class="wdg-imhs-move-btn wdg-imhs-move-down" title="<?php echo t("Μετακίνηση κάτω"); ?>">▼</button>' +
                '</div>' +
                '<span>Hotspot ' + ($('#wdg_imhs_hotspots_list .wdg-imhs-item').length + 1) + '</span>' +
                '<button class="wdg-item-remove" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
                '</div>'
            );
            var $body = $('<div class="wdg-imhs-item-body">');

            // Title
            $body.append(
                '<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?></label>' +
                '<input type="text" class="listbox wdg-imhs-title" value="' + $('<div>').text(data.title || '').html() + '"></div>'
            );
            // Description
            $body.append(
                '<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label>' +
                '<textarea class="listbox wdg-imhs-desc" rows="2" style="resize:vertical;">' + $('<div>').text(data.description || '').html() + '</textarea></div>'
            );
            // Position picker
            $body.append(
                '<div class="ody_builder_parameter">' +
                '<label><?php echo t("Θέση στην εικόνα"); ?></label>' +
                '<button type="button" class="btn btn-success wdg-imhs-pos-btn wdg-imhs-open-picker">' +
                '🎯 <?php echo t("Ορισμός θέσης"); ?></button>' +
                '<div class="wdg-imhs-pos-info">X: ' + posX + '%  —  Y: ' + posY + '%</div>' +
                '<input type="hidden" class="wdg-imhs-pos-x" value="' + posX + '">' +
                '<input type="hidden" class="wdg-imhs-pos-y" value="' + posY + '">' +
                '</div>'
            );
            // Button label
            $body.append(
                '<div class="ody_builder_parameter"><label><?php echo t("Κείμενο κουμπιού (κενό = χωρίς κουμπί)"); ?></label>' +
                '<input type="text" class="listbox wdg-imhs-btn-label" value="' + $('<div>').text(data.btn_label || '').html() + '"></div>'
            );
            // Button URL
            $body.append(
                '<div class="ody_builder_parameter"><label>Link</label>' +
                '<input type="text" class="listbox wdg-imhs-btn-url" id="' + urlId + '" value="' + $('<div>').text(data.btn_url || '').html() + '">' +
                '<select class="selectLink listbox" onchange="wdgImhsSetLink($(this).val(), \'' + urlId + '\', ' + idx + '); $(this).val(\'\');">' +
                _page_opts + '</select></div>'
            );
            // New tab
            $body.append(
                '<div class="ody_builder_parameter"><div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">' +
                '<input type="checkbox" class="wdg-imhs-btn-newtab" id="wdg_imhs_newtab_' + idx + '" value="1">' +
                '<p><?php echo t("Άνοιγμα σε νέο tab"); ?></p></div></div>'
            );
            // Button style
            $body.append(
                '<div class="ody_builder_parameter"><label><?php echo t("Εμφάνιση κουμπιού"); ?></label>' +
                '<select class="listbox wdg-imhs-btn-style">' +
                '<option value="widget-button-primary">Primary</option>' +
                '<option value="widget-button-secondary">Secondary</option>' +
                '<option value="widget-button-outline">Outline</option>' +
                '</select></div>'
            );

            $item.append($body);
            $('#wdg_imhs_hotspots_list').append($item);

            // Position picker open
            $item.find('.wdg-imhs-open-picker').on('click', function () {
                openPosPicker($item);
            });

            // Hidden popups
            $('#wdg_imhs_popups_container').append(
                '<a id="' + nodeId + '" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]' + urlId + '">iFrame</a>' +
                '<a id="' + fileId + '" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]' + urlId + '">iFrame</a>'
            );
            new VenoBox({selector: '#' + nodeId, fitView: true, ratio: 'full'});
            new VenoBox({selector: '#' + fileId, fitView: true, ratio: 'full'});

            if (data.btn_new_tab == '1') $('#wdg_imhs_newtab_' + idx).prop('checked', true);
            if (data.btn_style) $item.find('.wdg-imhs-btn-style').val(data.btn_style);

            // ── Real-time title update ────────────────────────────────────────
            $item.find('.wdg-imhs-title').on('input', function () {
                updateItemDisplay($item);
            });

            // ── Move buttons ──────────────────────────────────────────────────
            $item.find('.wdg-imhs-move-up').on('click', function (e) {
                e.stopPropagation();
                moveItemUp($item);
            });
            $item.find('.wdg-imhs-move-down').on('click', function (e) {
                e.stopPropagation();
                moveItemDown($item);
            });

            $item.find('.wdg-item-remove').on('click', function () {
                $item.fadeOut(200, function () {
                    $item.remove();
                    renumberItems();
                    saveHotspots();
                });
            });

            $item.find('input:not(.wdg-imhs-pos-x):not(.wdg-imhs-pos-y), textarea, select').on('change input', function () {
                saveHotspots();
            });

            updateItemDisplay($item);
        }

        // Φόρτωση αποθηκευμένων hotspots
        var _saved_hotspots = pval('hotspots');
        if (_saved_hotspots) {
            try {
                JSON.parse(_saved_hotspots).forEach(function (hs) { addItem(hs); });
            } catch (e) {}
        }

        $('#wdg_imhs_add_btn').on('click', function () {
            addItem({});
            saveHotspots();
        });

        label = 'Widget Image Hotspots';
        $('#ody_builder_admin_label').val(label);
        $('.ody_builder_header h2').html('Widgetizer — Image Hotspots');

        window.get_block_data = function () {
            saveHotspots();
            return {
                widget_id: 'image_hotspots',
                params: {
                    eyebrow:              $('#wdg_imhs_eyebrow').val(),
                    title:                $('#wdg_imhs_title').val(),
                    description:          $('#wdg_imhs_description').val(),
                    image:                $('#wdg_imhs_image').val(),
                    hotspot_color_scheme: $('#wdg_imhs_hotspot_color_scheme').val(),
                    color_scheme:         $('#wdg_imhs_color_scheme').val(),
                    container_width:      $('#wdg_imhs_container_width').val(),
                    hotspots:             $('#wdg_imhs_hotspots').val()
                }
            };
        };
    });
</script>
