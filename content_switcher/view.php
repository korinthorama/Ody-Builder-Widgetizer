<?php
/*
 * Widgetizer — Content Switcher Widget — view.php
 * Prefix: csw
 */
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

    /* ── Tab items ── */
    .wdg-csw-tab-item {
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 8px;
        background: #f9f9f9;
        transition: box-shadow 0.3s ease;
    }

    .wdg-csw-tab-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 8px;
        background: #1a4a5a;
        border-radius: 4px 4px 0 0;
    }

    .wdg-csw-tab-header span {
        color: white;
        font-size: 12px;
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .wdg-csw-tab-body {
        padding: 8px;
    }

    .wdg-csw-tab-body .ody_builder_parameter {
        max-width: 100% !important;
        margin-bottom: 6px;
    }

    /* ── Card items ── */
    .wdg-csw-card-item {
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 6px;
        background: #f0f4f4;
        transition: box-shadow 0.3s ease;
    }

    .wdg-csw-card-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
    }

    .wdg-csw-card-header span {
        color: white;
        font-size: 11px;
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .wdg-csw-card-body {
        padding: 8px;
    }

    .wdg-csw-card-body .ody_builder_parameter {
        max-width: 100% !important;
        margin-bottom: 5px;
    }

    .wdg-csw-add-btn {
        display: inline-block;
        padding: 5px 14px;
        background: #002e3a;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        margin-top: 4px;
        margin-bottom: 8px;
    }

    .wdg-csw-add-btn:hover {
        background: #004a5c;
    }

    .wdg-csw-add-card-btn {
        display: inline-block;
        padding: 4px 12px;
        background: #1a4a5a;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 11px;
        margin-top: 4px;
    }

    .wdg-csw-add-card-btn:hover {
        background: #2a6a7a;
    }

    .wdg-csw-cards-list {
        margin-top: 8px;
        border-top: 1px solid #ddd;
        padding-top: 8px;
    }

    .wdg-csw-cards-label {
        font-size: 15px;
        font-weight: bold;
        color: #fff;
        margin-bottom: 6px;
        padding: 3px 10px;
        background-color: #7a7a7a;
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

    /* ── Βελάκια μετακίνησης ── */
    .wdg-csw-move-buttons {
        display: flex;
        gap: 4px;
        margin-right: 4px;
    }

    .wdg-csw-move-btn {
        background: transparent;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 12px;
        padding: 2px 4px;
        border-radius: 3px;
        transition: all 0.2s;
    }

    .wdg-csw-move-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .wdg-csw-move-btn:active {
        transform: scale(0.9);
    }
</style>
<!-- ══ ΓΕΝΙΚΑ ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_csw_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_csw_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_csw_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_csw_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_csw_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_csw_description" class="listbox" value="">
</div>
<!-- ══ ΕΜΦΑΝΙΣΗ ══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_csw_header_align"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_csw_header_align" class="listbox">
        <option value="center"><?php echo t("Κέντρο"); ?></option>
        <option value="left"><?php echo t("Αριστερά"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_csw_cols"><?php echo t("Στήλες σύγκρισης"); ?></label>
    <select id="wdg_csw_cols" class="listbox">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_csw_image_ratio"><?php echo t("Αναλογία Εικόνας"); ?></label>
    <select id="wdg_csw_image_ratio" class="listbox">
        <option value="1 / 1">1:1</option>
        <option value="4 / 3">4:3</option>
        <option value="16 / 9">16:9</option>
        <option value="3 / 4">3:4</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_csw_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_csw_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_csw_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_csw_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<!-- ══ TABS ═══════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title">Tabs</div>
<div id="wdg_csw_tabs" style="max-width:100%;"></div>
<button type="button" class="wdg-csw-add-btn" id="wdg_csw_add_tab_btn">+ <?php echo t("Προσθήκη"); ?> Tab</button>
<?php
$_page_opts_html = '<option value="">' . t("ή επιλέξτε υπάρχουσα σελίδα") . '</option>';
$_page_opts_html .= '<option value="homepage">' . t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ") . '</option>';
foreach($_pages as $row) {
    $_page_opts_html .= '<option value="' . $row->id . '">' . htmlspecialchars($row->title) . '</option>';
}
$_page_opts_html .= '<option value="divider">--------------------------------------</option>';
$_page_opts_html .= '<option value="nodeLinks_csw">' . t("Link για εγγραφή ενότητας") . ' >></option>';
$_page_opts_html .= '<option value="divider">--------------------------------------</option>';
$_page_opts_html .= '<option value="fileLinks_csw">' . t("Link για αρχείο") . ' >></option>';
?>
<script>
    jQuery(function ($) {
        var _p = _saved_params || {};
        var _tabs = _p['tabs'] || [];

        function pval(key, def) {
            return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
        }

        $('#wdg_csw_eyebrow').val(pval('eyebrow'));
        $('#wdg_csw_title').val(pval('title'));
        $('#wdg_csw_description').val(pval('description'));
        $('#wdg_csw_header_align').val(pval('header_align', 'center'));
        $('#wdg_csw_cols').val(pval('cols', '3'));
        $('#wdg_csw_image_ratio').val(pval('image_ratio', '4 / 3'));
        $('#wdg_csw_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
        $('#wdg_csw_container_width').val(pval('container_width', 'xl'));
        var _page_opts = <?php echo json_encode($_page_opts_html); ?>;
        var _tab_idx = 0;
        var _card_idx = {};

        // ── VenoBox για mediabank ─────────────────────────────────────────────
        window.venobox = new VenoBox({selector: '.wdg-csw-select-media', fitView: true, ratio: 'full'});
        $('.wdg-csw-select-media').on('click', function () {
            window._wdg_mediabank_caller = this;
        });
        window.odyRecieveMediabank = function (file, id, ext, image_path, callerEl) {
            var targetId = $(callerEl).data('wdg-target');
            if (!targetId) return;
            var fullPath = image_path + id + '.' + ext;
            $('#' + targetId).val(fullPath);
            $('#' + targetId + '_display').text(file);
            $('#' + targetId + '_preview').attr('src', fullPath).show();
            $('#' + targetId + '_remove').css('visibility', 'visible');
        };

        // ── Tab display ───────────────────────────────────────────────────────
        function updateTabDisplay($item) {
            var labelVal = $item.find('.wdg-csw-tab-label').val();
            var tabNumber = $item.index() + 1;
            var displayText = 'Tab ' + tabNumber;
            if (labelVal && labelVal.trim() !== '') {
                displayText += ': ' + labelVal;
            }
            $item.find('> .wdg-csw-tab-header span').text(displayText);
        }

        function renumberTabs() {
            $('#wdg_csw_tabs .wdg-csw-tab-item').each(function () {
                updateTabDisplay($(this));
            });
        }

        // ── Move tabs ─────────────────────────────────────────────────────────
        function moveTabUp($item) {
            var $prev = $item.prev('.wdg-csw-tab-item');
            if ($prev.length) {
                $item.slideUp(1, function () {
                    $item.insertBefore($prev);
                    $item.slideDown(1, function () {
                        renumberTabs();
                        $('html, body').animate({ scrollTop: $item.offset().top - 100 }, 300);
                        $item.css('box-shadow', '0 0 0 2px #fbbf24');
                        setTimeout(function () { $item.css('box-shadow', ''); }, 100);
                    });
                });
            }
        }

        function moveTabDown($item) {
            var $next = $item.next('.wdg-csw-tab-item');
            if ($next.length) {
                $item.slideUp(1, function () {
                    $item.insertAfter($next);
                    $item.slideDown(1, function () {
                        renumberTabs();
                        $('html, body').animate({ scrollTop: $item.offset().top - 100 }, 300);
                        $item.css('box-shadow', '0 0 0 2px #fbbf24');
                        setTimeout(function () { $item.css('box-shadow', ''); }, 100);
                    });
                });
            }
        }

        // ── Card display ──────────────────────────────────────────────────────
        function updateCardDisplay($card, $cardsList) {
            var titleVal = $card.find('.wdg-csw-card-title').val();
            var cardNumber = $card.index() + 1;
            var displayText = '<?php echo t("Κάρτα"); ?> ' + cardNumber;
            if (titleVal && titleVal.trim() !== '') {
                displayText += ': ' + titleVal;
            }
            $card.find('> .wdg-csw-card-header span').text(displayText);
        }

        function renumberCards($cardsList) {
            $cardsList.find('.wdg-csw-card-item').each(function () {
                updateCardDisplay($(this), $cardsList);
            });
        }

        // ── Move cards ────────────────────────────────────────────────────────
        function moveCardUp($card, $cardsList) {
            var $prev = $card.prev('.wdg-csw-card-item');
            if ($prev.length) {
                $card.slideUp(1, function () {
                    $card.insertBefore($prev);
                    $card.slideDown(1, function () {
                        renumberCards($cardsList);
                        $('html, body').animate({ scrollTop: $card.offset().top - 100 }, 300);
                        $card.css('box-shadow', '0 0 0 2px #fbbf24');
                        setTimeout(function () { $card.css('box-shadow', ''); }, 100);
                    });
                });
            }
        }

        function moveCardDown($card, $cardsList) {
            var $next = $card.next('.wdg-csw-card-item');
            if ($next.length) {
                $card.slideUp(1, function () {
                    $card.insertAfter($next);
                    $card.slideDown(1, function () {
                        renumberCards($cardsList);
                        $('html, body').animate({ scrollTop: $card.offset().top - 100 }, 300);
                        $card.css('box-shadow', '0 0 0 2px #fbbf24');
                        setTimeout(function () { $card.css('box-shadow', ''); }, 100);
                    });
                });
            }
        }

        // ── Add Card ──────────────────────────────────────────────────────────
        function addCard(tabIdx, cardData, $cardsList) {
            cardData = cardData || {};
            if (!_card_idx[tabIdx]) _card_idx[tabIdx] = 0;
            var ci = _card_idx[tabIdx]++;
            var uid = 'csw_' + tabIdx + '_' + ci;
            var imgId = 'wdg_csw_img_' + uid;
            var mediaId = 'wdg_csw_media_' + uid;
            var urlId = 'wdg_csw_url_' + uid;
            var nodePopupId = 'wdg_csw_node_' + uid;
            var filePopupId = 'wdg_csw_file_' + uid;
            var $card = $('<div class="wdg-csw-card-item" data-ci="' + ci + '">');
            $card.append(
                '<div class="wdg-csw-card-header">' +
                '<div class="wdg-csw-move-buttons">' +
                '<button type="button" class="wdg-csw-move-btn wdg-csw-card-move-up" title="<?php echo t("Μετακίνηση πάνω"); ?>">▲</button>' +
                '<button type="button" class="wdg-csw-move-btn wdg-csw-card-move-down" title="<?php echo t("Μετακίνηση κάτω"); ?>">▼</button>' +
                '</div>' +
                '<span><?php echo t("Κάρτα"); ?> ' + ($cardsList.find('.wdg-csw-card-item').length + 1) + '</span>' +
                '<button class="wdg-item-remove" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
                '</div>'
            );
            var $body = $('<div class="wdg-csw-card-body">');
            // Image
            $body.append(
                '<div class="ody_builder_parameter"><label><?php echo t("Εικόνα"); ?></label>' +
                '<div class="wdg-img-row">' +
                '<span id="' + imgId + '_display" class="wdg-img-filename"><?php echo t("Επιλέξτε..."); ?></span>' +
                '<a href="ody_builder_mediabank.php?blockType=widgetizer&langID=<?php echo $langID; ?>" id="' + mediaId + '"' +
                ' class="wdg-csw-select-media ody_builder_content_action btn btn-success" data-vbtype="iframe" data-wdg-target="' + imgId + '"><?php echo t("Επιλογή"); ?></a>' +
                '<a href="javascript:void(0)" id="' + imgId + '_remove" class="ody_builder_content_action btn btn-danger" style="visibility:hidden;"' +
                ' onclick="$(\'#' + imgId + '\').val(\'\'); $(\'#' + imgId + '_display\').text(\'<?php echo t("Επιλέξτε..."); ?>\'); $(\'#' + imgId + '_preview\').hide().attr(\'src\',\'\'); $(\'#' + imgId + '_remove\').css(\'visibility\',\'hidden\');"><?php echo t("Αφαίρεση"); ?></a>' +
                '</div>' +
                '<input type="hidden" id="' + imgId + '" class="wdg-csw-card-image" value="">' +
                '<img id="' + imgId + '_preview" class="wdg-img-preview" src="" alt="">' +
                '</div>'
            );
            // Title
            $body.append('<div class="ody_builder_parameter"><label><?php echo t("Τίτλος"); ?></label><input type="text" class="listbox wdg-csw-card-title" value="' + $('<div>').text(cardData.title || '').html() + '"></div>');
            // Price
            $body.append('<div class="ody_builder_parameter"><label><?php echo t("Τιμή"); ?></label><input type="text" class="listbox wdg-csw-card-price" value="' + $('<div>').text(cardData.price || '').html() + '"></div>');
            // Text
            $body.append('<div class="ody_builder_parameter"><label><?php echo t("Περιγραφή"); ?></label><textarea class="listbox wdg-csw-card-text" rows="3" style="resize:vertical;">' + $('<div>').text(cardData.text || '').html() + '</textarea></div>');
            // Button label
            $body.append('<div class="ody_builder_parameter"><label><?php echo t("Κείμενο κουμπιού"); ?></label><input type="text" class="listbox wdg-csw-card-btn-label" value="' + $('<div>').text(cardData.btn_label || '').html() + '"></div>');
            // Button URL
            $body.append(
                '<div class="ody_builder_parameter"><label>Link</label>' +
                '<input type="text" id="' + urlId + '" class="listbox wdg-csw-card-btn-url" value="">' +
                '<select class="selectLink listbox" onchange="wdgCswSetLink($(this).val(),\'' + urlId + '\',\'' + uid + '\'); $(this).val(\'\');">' + _page_opts + '</select>' +
                '</div>'
            );
            // New tab
            $body.append('<div class="ody_builder_parameter"><div class="admin_checkbox_wrapper" style="margin: 0 0 10px;"><input type="checkbox" class="wdg-csw-card-btn-new-tab" value="1"><p><?php echo t("Άνοιγμα σε νέο tab"); ?></p></div></div>');
            // Button style
            $body.append('<div class="ody_builder_parameter"><label><?php echo t("Εμφάνιση κουμπιού"); ?></label><select class="listbox wdg-csw-card-btn-style"><option value="widget-button-primary">Primary</option><option value="widget-button-secondary">Secondary</option></select></div>');
            $card.append($body);
            $cardsList.append($card);
            // Hidden popups
            $card.append(
                '<a id="' + nodePopupId + '" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]' + urlId + '">iFrame</a>' +
                '<a id="' + filePopupId + '" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]' + urlId + '">iFrame</a>'
            );
            new VenoBox({selector: '#' + nodePopupId, fitView: true, ratio: 'full'});
            new VenoBox({selector: '#' + filePopupId, fitView: true, ratio: 'full'});
            new VenoBox({selector: '#' + mediaId, fitView: true, ratio: 'full'});
            $('#' + mediaId).on('click', function () {
                window._wdg_mediabank_caller = this;
            });
            // Φόρτωση τιμών
            if (cardData.image) {
                $('#' + imgId).val(cardData.image);
                $('#' + imgId + '_display').text(cardData.image.split('/').pop());
                $('#' + imgId + '_preview').attr('src', cardData.image).show();
                $('#' + imgId + '_remove').css('visibility', 'visible');
            }
            if (cardData.btn_url) $('#' + urlId).val(cardData.btn_url);
            if (cardData.btn_new_tab == '1') $card.find('.wdg-csw-card-btn-new-tab').prop('checked', true);
            $card.find('.wdg-csw-card-btn-style').val(cardData.btn_style || 'widget-button-secondary');

            // ── Real-time title update ────────────────────────────────────────
            $card.find('.wdg-csw-card-title').on('input', function () {
                updateCardDisplay($card, $cardsList);
            });

            // ── Move buttons ──────────────────────────────────────────────────
            $card.find('.wdg-csw-card-move-up').on('click', function (e) {
                e.stopPropagation();
                moveCardUp($card, $cardsList);
            });
            $card.find('.wdg-csw-card-move-down').on('click', function (e) {
                e.stopPropagation();
                moveCardDown($card, $cardsList);
            });

            $card.find('.wdg-item-remove').on('click', function () {
                $card.fadeOut(200, function () {
                    $card.remove();
                    renumberCards($cardsList);
                });
            });

            updateCardDisplay($card, $cardsList);
        }

        // ── Add Tab ───────────────────────────────────────────────────────────
        function addTab(data) {
            data = data || {};
            var ti = _tab_idx++;
            _card_idx[ti] = 0;
            var $item = $('<div class="wdg-csw-tab-item" data-ti="' + ti + '">');
            $item.append(
                '<div class="wdg-csw-tab-header">' +
                '<div class="wdg-csw-move-buttons">' +
                '<button type="button" class="wdg-csw-move-btn wdg-csw-tab-move-up" title="<?php echo t("Μετακίνηση πάνω"); ?>">▲</button>' +
                '<button type="button" class="wdg-csw-move-btn wdg-csw-tab-move-down" title="<?php echo t("Μετακίνηση κάτω"); ?>">▼</button>' +
                '</div>' +
                '<span>Tab ' + ($('#wdg_csw_tabs .wdg-csw-tab-item').length + 1) + '</span>' +
                '<button class="wdg-item-remove" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
                '</div>'
            );
            var $body = $('<div class="wdg-csw-tab-body">');
            // Tab label
            $body.append('<div class="ody_builder_parameter"><label><?php echo t("Ετικέτα"); ?> Tab</label><input type="text" class="listbox wdg-csw-tab-label" value="' + $('<div>').text(data.label || '').html() + '"></div>');
            // Cards section
            var $cardsWrapper = $('<div class="wdg-csw-cards-list">');
            $cardsWrapper.append('<div class="wdg-csw-cards-label"><?php echo t("Κάρτες"); ?></div>');
            var $cardsList = $('<div class="wdg-csw-cards-items">');
            $cardsWrapper.append($cardsList);
            $cardsWrapper.append('<button type="button" class="wdg-csw-add-card-btn">+ <?php echo t("Προσθήκη κάρτας"); ?></button>');
            $body.append($cardsWrapper);
            $item.append($body);
            $('#wdg_csw_tabs').append($item);
            // Φόρτωση cards
            var cards = data.cards || [];
            cards.forEach(function (card) {
                addCard(ti, card, $cardsList);
            });
            // Add card button
            $cardsWrapper.find('.wdg-csw-add-card-btn').on('click', function () {
                addCard(ti, {}, $cardsList);
            });

            // ── Real-time tab label update ────────────────────────────────────
            $item.find('.wdg-csw-tab-label').on('input', function () {
                updateTabDisplay($item);
            });

            // ── Move buttons ──────────────────────────────────────────────────
            $item.find('.wdg-csw-tab-move-up').on('click', function (e) {
                e.stopPropagation();
                moveTabUp($item);
            });
            $item.find('.wdg-csw-tab-move-down').on('click', function (e) {
                e.stopPropagation();
                moveTabDown($item);
            });

            // Remove tab
            $item.find('> .wdg-csw-tab-header .wdg-item-remove').on('click', function () {
                $item.fadeOut(200, function () {
                    $item.remove();
                    renumberTabs();
                });
            });

            updateTabDisplay($item);
        }

        // Φόρτωση tabs
        _tabs.forEach(function (tab) { addTab(tab); });
        $('#wdg_csw_add_tab_btn').on('click', function () { addTab({}); });

        // ── Link picker ───────────────────────────────────────────────────────
        window.wdgCswSetLink = function (val, targetId, uid) {
            if (!val || val === 'divider') return;
            if (val === 'nodeLinks_csw') {
                document.getElementById('wdg_csw_node_' + uid).click();
                return;
            }
            if (val === 'fileLinks_csw') {
                document.getElementById('wdg_csw_file_' + uid).click();
                return;
            }
            var link = (val === 'homepage') ? 'index.php' : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
            $('#' + targetId).val(link);
        };

        // ── Label ─────────────────────────────────────────────────────────────
        label = 'Widget Content Switcher';
        $('#ody_builder_admin_label').val(label);
        $('.ody_builder_header h2').html('Widgetizer — Content Switcher');

        // ── get_block_data ────────────────────────────────────────────────────
        window.get_block_data = function () {
            var tabs = [];
            $('#wdg_csw_tabs .wdg-csw-tab-item').each(function () {
                var $tab = $(this);
                var ti = $tab.data('ti');
                var cards = [];
                $tab.find('.wdg-csw-cards-items .wdg-csw-card-item').each(function () {
                    var $c = $(this);
                    var ci = $c.data('ci');
                    var uid = 'csw_' + ti + '_' + ci;
                    cards.push({
                        image:       $('#wdg_csw_img_' + uid).val(),
                        title:       $c.find('.wdg-csw-card-title').val(),
                        price:       $c.find('.wdg-csw-card-price').val(),
                        text:        $c.find('.wdg-csw-card-text').val(),
                        btn_label:   $c.find('.wdg-csw-card-btn-label').val(),
                        btn_url:     $c.find('.wdg-csw-card-btn-url').val(),
                        btn_new_tab: $c.find('.wdg-csw-card-btn-new-tab').is(':checked') ? '1' : '0',
                        btn_style:   $c.find('.wdg-csw-card-btn-style').val()
                    });
                });
                tabs.push({label: $tab.find('.wdg-csw-tab-label').val(), cards: cards});
            });
            return {
                widget_id: 'content_switcher',
                params: {
                    eyebrow:         $('#wdg_csw_eyebrow').val(),
                    title:           $('#wdg_csw_title').val(),
                    description:     $('#wdg_csw_description').val(),
                    header_align:    $('#wdg_csw_header_align').val(),
                    cols:            $('#wdg_csw_cols').val(),
                    image_ratio:     $('#wdg_csw_image_ratio').val(),
                    color_scheme:    $('#wdg_csw_color_scheme').val(),
                    container_width: $('#wdg_csw_container_width').val(),
                    tabs:            tabs
                }
            };
        };
    });
</script>
