<?php
/*
 * Widgetizer — Accordion Widget — view.php (custom admin UI)
 *
 * Έχει πρόσβαση σε: $db, $langID, t(), _saved_params (JS)
 * Πρέπει να ορίσει: window.get_block_data(), label
 */
?>
<style>
    .ody_builder_parameter {
        max-width: 500px !important;
    }

    /* ── Repeater ── */
    #wdg_accordion_items {
        width: 100%;
        max-width: 100%;
        margin-bottom: 8px;
    }

    .wdg-acc-item {
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 8px;
        background: #f9f9f9;
    }

    .wdg-acc-item-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 8px;
        background: #002e3a;
        border-radius: 4px 4px 0 0;
        cursor: move;
    }

    .wdg-acc-item-header span {
        color: white;
        font-size: 12px;
        flex: 1;
    }

    .wdg-acc-item-body {
        padding: 8px;
    }

    .wdg-acc-item-body .ody_builder_parameter {
        max-width: 100%;
        margin-bottom: 6px;
    }

    .wdg-acc-item-body textarea {
        min-height: 60px;
        resize: vertical;
    }

    #wdg_acc_add_btn {
        display: inline-block;
        padding: 6px 16px;
        background: #002e3a;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        margin-top: 4px;
    }

    #wdg_acc_add_btn:hover {
        background: #004a5c;
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
</style>
<!-- ══ ΓΕΝΙΚΑ ════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Γενικά"); ?></div>
<div class="ody_builder_parameter">
    <label for="wdg_acc_eyebrow">Eyebrow</label>
    <input type="text" id="wdg_acc_eyebrow" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_acc_title"><?php echo t("Τίτλος"); ?></label>
    <input type="text" id="wdg_acc_title" class="listbox" value="">
</div>
<div class="ody_builder_parameter">
    <label for="wdg_acc_description"><?php echo t("Περιγραφή"); ?></label>
    <textarea id="wdg_acc_description" class="listbox" rows="3" style="resize:vertical;"></textarea>
</div>
<div class="ody_builder_parameter">
    <div class="admin_checkbox_wrapper" style="margin: 0 0 10px;">
        <input type="checkbox" id="wdg_acc_multi_open" value="1">
        <p><?php echo t("Πολλαπλά ανοιχτά"); ?></p>
    </div>
</div>
<div class="ody_builder_parameter">
    <label for="wdg_acc_color_scheme"><?php echo t("Κύρια χρωματική παλέτα"); ?></label>
    <select id="wdg_acc_color_scheme" class="listbox">
        <option value="color-scheme-standard-primary">Standard Primary</option>
        <option value="color-scheme-standard-secondary">Standard Secondary</option>
        <option value="color-scheme-highlight-primary">Highlight Primary</option>
        <option value="color-scheme-highlight-secondary">Highlight Secondary</option>
    </select>
</div>
<!-- ══ ITEMS ═════════════════════════════════════════════════════════════════ -->
<div class="wdg-section-title"><?php echo t("Ερωτήσεις / Απαντήσεις"); ?></div>
<div id="wdg_accordion_items" style="max-width:100%;"></div>
<button id="wdg_acc_add_btn" type="button">+ <?php echo t("Προσθήκη"); ?></button>

<script>
    jQuery(function ($) {
        var _p = _saved_params || {};
        var _items = _p['items'] || [];

        function pval(key, def) {
            return (_p[key] !== undefined && _p[key] !== '') ? _p[key] : (def || '');
        }

        // ── Φόρτωση γενικών τιμών ────────────────────────────────────────────────
        $('#wdg_acc_eyebrow').val(pval('eyebrow'));
        $('#wdg_acc_title').val(pval('title'));
        $('#wdg_acc_description').val(pval('description'));
        $('#wdg_acc_multi_open').prop('checked', _p['multi_open'] == '1');
        $('#wdg_acc_color_scheme').val(pval('color_scheme', 'color-scheme-standard-primary'));
        // ── Repeater ──────────────────────────────────────────────────────────────
        var _item_idx = 0;

        function addItem(question, answer) {
            var idx = _item_idx++;
            var $item = $('<div class="wdg-acc-item" data-idx="' + idx + '">');
            $item.append(
                    '<div class="wdg-acc-item-header">' +
                    '<span><?php echo t("Ερώτηση"); ?> ' + ($('#wdg_accordion_items .wdg-acc-item').length + 1) + '</span>' +
                    '<button class="wdg-item-remove" type="button" title="<?php echo t("Αφαίρεση"); ?>">✕</button>' +
                    '</div>'
            );
            var $body = $('<div class="wdg-acc-item-body">');
            $body.append(
                    '<div class="ody_builder_parameter">' +
                    '<label><?php echo t("Ερώτηση"); ?></label>' +
                    '<input type="text" class="listbox wdg-acc-question" value="' + $('<div>').text(question || '').html() + '">' +
                    '</div>'
            );
            $body.append(
                    '<div class="ody_builder_parameter">' +
                    '<label><?php echo t("Απάντηση"); ?></label>' +
                    '<textarea class="listbox wdg-acc-answer">' + $('<div>').text(answer || '').html() + '</textarea>' +
                    '</div>'
            );
            $item.append($body);
            $('#wdg_accordion_items').append($item);
            // Remove button
            $item.find('.wdg-item-remove').on('click', function () {
                $item.fadeOut(200, function () {
                    $item.remove();
                    renumberItems();
                });
            });
        }

        function renumberItems() {
            $('#wdg_accordion_items .wdg-acc-item').each(function (idx) {
                $(this).find('.wdg-acc-item-header span').text('<?php echo t("Ερώτηση"); ?> ' + (idx + 1));
            });
        }

        // Φόρτωση αποθηκευμένων items
        $.each(_items, function (i, item) {
            addItem(item.question, item.answer);
        });
        // Προσθήκη νέου item
        $('#wdg_acc_add_btn').on('click', function () {
            addItem('', '');
        });
        // Sortable
        if($.fn.sortable) {
            $('#wdg_accordion_items').sortable({
                handle:      '.wdg-acc-item-header',
                placeholder: 'block-placeholder',
                tolerance:   'pointer',
                stop:        function() { renumberItems(); }
            });
        }
        // ── Label ────────────────────────────────────────────────────────────────
        label = 'Widget Accordion';
        $('#ody_builder_admin_label').val(label);
        $('.ody_builder_header h2').html('Widgetizer — Accordion');
        // ── get_block_data ────────────────────────────────────────────────────────
        window.get_block_data = function () {
            var items = [];
            $('#wdg_accordion_items .wdg-acc-item').each(function () {
                items.push({
                    question: $(this).find('.wdg-acc-question').val(),
                    answer:   $(this).find('.wdg-acc-answer').val()
                });
            });
            return {
                widget_id: 'accordion',
                params:    {
                    eyebrow:      $('#wdg_acc_eyebrow').val(),
                    title:        $('#wdg_acc_title').val(),
                    description:  $('#wdg_acc_description').val(),
                    multi_open:   $('#wdg_acc_multi_open').is(':checked') ? '1' : '0',
                    color_scheme: $('#wdg_acc_color_scheme').val(),
                    items:        items
                }
            };
        };
    });
</script>
