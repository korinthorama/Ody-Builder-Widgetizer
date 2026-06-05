<?php defined('CMS') or die("This file cannot run this way!"); ?>

<?php
$q = "select pages.id as id, content_pages.title as title
      from pages, content_pages
      where content_pages.mainID=pages.id
      and content_pages.langID=" . $langID . "
      order by pages.sort, content_pages.title";
$_prng_pages = $db->getRecords($q);
$_prng_page_opts  = '<option value="">' . t("ή επιλέξτε υπάρχουσα σελίδα") . '</option>';
$_prng_page_opts .= '<option value="homepage">' . t("ΑΡΧΙΚΗ ΣΕΛΙΔΑ") . '</option>';
foreach ($_prng_pages as $_prng_row) {
    $_prng_page_opts .= '<option value="' . $_prng_row->id . '">' . htmlspecialchars($_prng_row->title) . '</option>';
}
$_prng_page_opts .= '<option value="divider">--------------------------------------</option>';
$_prng_page_opts .= '<option value="nodeLinks_prng">' . t("Link για εγγραφή ενότητας") . ' >></option>';
$_prng_page_opts .= '<option value="divider">--------------------------------------</option>';
$_prng_page_opts .= '<option value="fileLinks_prng">' . t("Link για αρχείο") . ' >></option>';
?>

<style>
    .ody_builder_parameter { max-width: 500px !important; }
    .wdg-prng-card { border: 1px solid #ccc; border-radius: 4px; margin-bottom: 8px; background: #f0f4f4; }
    .wdg-prng-card-header { display: flex; align-items: center; gap: 8px; padding: 5px 8px; background: #002e3a; border-radius: 4px 4px 0 0; cursor: move; }
    .wdg-prng-card-header span { color: white; font-size: 11px; flex: 1; }
    .wdg-prng-card-body { padding: 8px; }
    .wdg-prng-card-body .ody_builder_parameter { max-width: 100% !important; margin-bottom: 5px; }
    .wdg-prng-features-list { list-style: none; padding: 0; margin: 6px 0; clear:both}
    .wdg-prng-feature-item { display: flex; align-items: center; gap: 6px; margin-bottom: 4px; }
    .wdg-prng-feature-item input { flex: 1; }
    .wdg-prng-feature-item button {
        flex-shrink: 0;
        border-radius: 10px;
        width: 20px;
        height: 20px;
        font-size: 11px !important;
        padding: 0 !important;
        font-weight: bold;
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

<!-- ══ ΓΕΝΙΚΑ ═══════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_prng_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_prng_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prng_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_prng_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prng_description"><?php echo t("Υπότιτλος"); ?></label>
    <input type="text" id="wdg_prng_description" class="listbox" value="">
</div>

<!-- ══ ΕΜΦΑΝΙΣΗ ═════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Εμφάνιση"); ?></div>

<div class="ody_builder_parameter">
    <label for="wdg_prng_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_prng_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prng_container_width"><?php echo t("Πλάτος Container"); ?></label>
    <select id="wdg_prng_container_width" class="listbox">
        <option value="full">Full Width</option>
        <option value="xl">X-Large (1420px)</option>
        <option value="lg">Large (1200px)</option>
        <option value="md">Medium (960px)</option>
        <option value="sm">Small (760px)</option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prng_header_alignment"><?php echo t("Στοίχιση Επικεφαλίδας"); ?></label>
    <select id="wdg_prng_header_alignment" class="listbox">
        <option value="left"><?php echo t("Αριστερά"); ?></option>
        <option value="center"><?php echo t("Κέντρο"); ?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prng_layout"><?php echo t("Τύπος εμφάνισης"); ?></label>
    <select id="wdg_prng_layout" class="listbox">
        <option value="grid"><?php echo t("Πλέγμα (Grid)");?></option>
        <option value="carousel"><?php echo t("Οριζόντια κύληση (Carousel)");?></option>
    </select>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_prng_columns"><?php echo t("Στήλες"); ?></label>
    <select id="wdg_prng_columns" class="listbox">
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
</div>

<!-- ══ PLANS ═════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Plans"); ?></div>
<div id="wdg_prng_cards_list"></div>
<div class="ody_builder_parameter">
    <button type="button" id="wdg_prng_add_card_btn" class="ody_builder_content_action btn btn-success">
        + <?php echo t("Προσθήκη"); ?> Plan
    </button>
</div>

<div id="wdg_prng_popups_container" style="display:none;"></div>

<script>
jQuery(function ($) {
    var _p        = _saved_params || {};
    var _items    = _p['items']   || [];
    var _card_idx = 0;
    var _page_opts = <?php echo json_encode($_prng_page_opts); ?>;

    function pval(key, def) {
        return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def !== undefined ? def : '');
    }

    // ── Restore scalars ────────────────────────────────────────────────────────
    $('#wdg_prng_eyebrow').val(pval('eyebrow'));
    $('#wdg_prng_title').val(pval('title'));
    $('#wdg_prng_description').val(pval('description'));
    $('#wdg_prng_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
    $('#wdg_prng_container_width').val(pval('container_width', 'xl'));
    $('#wdg_prng_header_alignment').val(pval('header_alignment', 'center'));
    $('#wdg_prng_layout').val(pval('layout', 'grid'));
    $('#wdg_prng_columns').val(pval('columns', '3'));

    // ── wdgPrngSetLink ─────────────────────────────────────────────────────────
    window.wdgPrngSetLink = function(val, urlFieldId, idx) {
        if (!val || val === 'divider') return;
        if (val === 'nodeLinks_prng') { document.getElementById('wdg_prng_node_popup_' + idx).click(); return; }
        if (val === 'fileLinks_prng') { document.getElementById('wdg_prng_file_popup_' + idx).click(); return; }
        var link = (val === 'homepage') ? 'index.php' : '««index.php?section=pages~|||~view=render~|||~id=' + val + '»»';
        $('#' + urlFieldId).val(link);
    };

    // ── addFeature ────────────────────────────────────────────────────────────
    function addFeature($list, value) {
        var $item = $('<li class="wdg-prng-feature-item">');
        $item.append('<input type="text" class="listbox wdg-prng-feature-text" value="' + $('<div>').text(value || '').html() + '">');
        $item.append('<button type="button" class="wdg-prng-feature-remove ody_builder_content_action btn btn-danger" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>');
        $list.append($item);
        $item.find('.wdg-prng-feature-remove').on('click', function() {
            $item.remove();
        });
    }

    // ── addCard ───────────────────────────────────────────────────────────────
    function addCard(cardData) {
        cardData = cardData || {};
        var ci     = _card_idx++;
        var uid    = 'prng_' + ci;
        var urlId  = 'wdg_prng_url_'    + uid;
        var tabId  = 'wdg_prng_newtab_' + uid;
        var nodePop = 'wdg_prng_node_popup_' + ci;
        var filePop = 'wdg_prng_file_popup_' + ci;

        var $card = $('<div class="wdg-prng-card" data-ci="' + ci + '">');
        $card.append(
            '<div class="wdg-prng-card-header">' +
                '<span><?php echo t("Plan"); ?> ' + ($('#wdg_prng_cards_list .wdg-prng-card').length + 1) + '</span>' +
                '<button class="wdg-item-remove ody_builder_content_action btn btn-danger" type="button" style="border-radius:10px;width:20px;height:20px;font-size:11px !important;padding:0 !important;font-weight:bold;flex-shrink:0;">✕</button>' +
            '</div>'
        );

        var $body = $('<div class="wdg-prng-card-body">');

        // is_featured checkbox
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">' +
            '<input type="checkbox" id="wdg_prng_featured_' + uid + '" value="1">' +
            '<p><?php echo t("Featured (επισημασμένο plan)"); ?></p>' +
            '</div></div>'
        );

        // Title
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τίτλος του plan"); ?></label>' +
            '<input type="text" id="wdg_prng_title_' + uid + '" class="listbox" value="' + $('<div>').text(cardData.title || '').html() + '"></div>'
        );

        // Price
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Τιμή"); ?></label>' +
            '<input type="text" id="wdg_prng_price_' + uid + '" class="listbox" value="' + $('<div>').text(cardData.price || '').html() + '"></div>'
        );

        // Period
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Περίοδος (πχ ανά μήνα)"); ?></label>' +
            '<input type="text" id="wdg_prng_period_' + uid + '" class="listbox" value="' + $('<div>').text(cardData.period || '').html() + '"></div>'
        );

        // Features
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Χαρακτηριστικά"); ?></label>' +
            '<ul class="wdg-prng-features-list" id="wdg_prng_features_' + uid + '"></ul>' +
            '<button type="button" class="ody_builder_content_action btn btn-success btn-sm wdg-prng-add-feature" style="margin-top:4px;">+ <?php echo t("Προσθήκη Feature"); ?></button>' +
            '</div>'
        );

        // Button text
        $body.append(
            '<div class="ody_builder_parameter"><label><?php echo t("Κείμενο κουμπιού"); ?></label>' +
            '<input type="text" id="wdg_prng_btn_text_' + uid + '" class="listbox" value="' + $('<div>').text(cardData.button_text || '').html() + '"></div>'
        );

        // Button URL + selectLink
        $body.append(
            '<div class="ody_builder_parameter"><label>Link</label>' +
            '<input type="text" id="' + urlId + '" class="listbox" value="' + $('<div>').text(cardData.button_url || '').html() + '">' +
            '<select class="selectLink listbox" onchange="wdgPrngSetLink($(this).val(), \'' + urlId + '\', ' + ci + '); $(this).val(\'\');">' +
                _page_opts +
            '</select></div>'
        );

        // New tab
        $body.append(
            '<div class="ody_builder_parameter">' +
            '<div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">' +
            '<input type="checkbox" id="' + tabId + '" value="1">' +
            '<p><?php echo t("Άνοιγμα σε νέο tab"); ?></p>' +
            '</div></div>'
        );

        $card.append($body);
        $('#wdg_prng_cards_list').append($card);

        // Node / File popups
        $('#wdg_prng_popups_container').append(
            '<a id="' + nodePop + '" class="builder_popup" data-vbtype="iframe" href="section_links.php?venobox=[id]' + urlId + '">iFrame</a>' +
            '<a id="' + filePop + '" class="builder_popup" data-vbtype="iframe" href="file_links.php?venobox=[id]' + urlId + '">iFrame</a>'
        );
        new VenoBox({ selector: '#' + nodePop, fitView: true, ratio: 'full' });
        new VenoBox({ selector: '#' + filePop, fitView: true, ratio: 'full' });

        // Restore
        if (cardData.is_featured == '1') $('#wdg_prng_featured_' + uid).prop('checked', true);
        if (cardData.button_new_tab == '1') $('#' + tabId).prop('checked', true);

        // Restore features
        var $featureList = $('#wdg_prng_features_' + uid);
        if (cardData.features) {
            var feats = cardData.features.split('|||');
            feats.forEach(function(f) { if (f.trim()) addFeature($featureList, f.trim()); });
        }

        // Add feature button
        $body.find('.wdg-prng-add-feature').on('click', function() {
            addFeature($featureList, '');
        });

        $card.find('.wdg-item-remove').on('click', function() {
            $card.fadeOut(200, function() { $card.remove(); renumberCards(); });
        });

        if ($.fn.sortable) {
            $('#wdg_prng_cards_list').sortable({
                handle: '.wdg-prng-card-header',
                placeholder: 'block-placeholder',
                tolerance: 'pointer',
                stop: function() { renumberCards(); }
            });
        }
    }

    function renumberCards() {
        $('#wdg_prng_cards_list .wdg-prng-card').each(function(idx) {
            $(this).find('.wdg-prng-card-header span').text('Plan ' + (idx + 1));
        });
    }

    _items.forEach(function(item) { addCard(item); });
    $('#wdg_prng_add_card_btn').on('click', function() { addCard({}); });

    // ── Label ─────────────────────────────────────────────────────────────────
    label = 'Widget Pricing';
    $('#ody_builder_admin_label').val(label);
    $('.ody_builder_header h2').html('Widgetizer — Pricing');

    // ── get_block_data ────────────────────────────────────────────────────────
    window.get_block_data = function() {
        var items = [];
        $('#wdg_prng_cards_list .wdg-prng-card').each(function() {
            var ci  = $(this).data('ci');
            var uid = 'prng_' + ci;

            var features = [];
            $('#wdg_prng_features_' + uid + ' .wdg-prng-feature-text').each(function() {
                var v = $(this).val().trim();
                if (v) features.push(v);
            });

            items.push({
                is_featured:    $('#wdg_prng_featured_' + uid).is(':checked') ? '1' : '0',
                title:          $('#wdg_prng_title_'    + uid).val(),
                price:          $('#wdg_prng_price_'    + uid).val(),
                period:         $('#wdg_prng_period_'   + uid).val(),
                features:       features.join('|||'),
                button_text:    $('#wdg_prng_btn_text_' + uid).val(),
                button_url:     $('#wdg_prng_url_'      + uid).val(),
                button_new_tab: $('#wdg_prng_newtab_'   + uid).is(':checked') ? '1' : '0'
            });
        });
        return {
            widget_id: 'pricing',
            params: {
                eyebrow:          $('#wdg_prng_eyebrow').val(),
                title:            $('#wdg_prng_title').val(),
                description:      $('#wdg_prng_description').val(),
                color_scheme:     $('#wdg_prng_color_scheme').val(),
                container_width:  $('#wdg_prng_container_width').val(),
                header_alignment: $('#wdg_prng_header_alignment').val(),
                layout:           $('#wdg_prng_layout').val(),
                columns:          $('#wdg_prng_columns').val(),
                items:            items
            }
        };
    };
});
</script>
