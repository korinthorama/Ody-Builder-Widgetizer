<?php
$rootPath = "";
$counter = 0;
$file = "factory.php"; // this file is unique in root
while($counter <= 10) {
    if(is_file($rootPath . $file)) break;
    $counter++;
    $rootPath .= "../";
}
require_once($rootPath . "factory.php");
$icons_txt = file("icons.txt");
$icons = array();
foreach($icons_txt as $key => $txt_record) {
    $icons[] = trim($txt_record);
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="../../../../css/admin.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="../../../../js/jquery.js"></script>
    <script src="../../../../js/admin.js"></script>
    <script src="../../../../js/fancybox2/fancybox.js"></script> <!-- needed by ody_builder.js -->
    <script src="../../../../js/ody_builder.js"></script>
    <style>
        html, body {
            height: 100%
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #000;
            overflow: auto;
            color: #000000;
            font-weight: normal;
        }

        #icons_container {
            min-height: 416px;
            background-color: #262626;
            padding: 10px 0;
            border: 2px solid #7b7b7a;
            border-radius: 8px !important;
        }

        #search_icons_header {
            color: #bcbcbc;
            padding: 15px;
            margin-left: 14px;
        }

        #icons_list {
            height: 380px;
            overflow-y: scroll;
            padding: 10px 10px;
            border: 1px solid #bcbcbc;
            margin: 10px 20px;
            box-sizing: border-box;
            border-radius: 8px !important;
        }

        #icons_list i {
            display: inline-block;
            margin: 5px;
            padding: 7px;
            border-radius: 30px;
            width: 32px;
            color: white;
            box-sizing: border-box;
            background: transparent;
            text-align: center;
            cursor: pointer;
        }

        #icons_list i:hover {
            color: black;
            background: white;
        }

        .icons_list_selected {
            color: white !important;
            background: #9a2a54 !important;
        }

        #search_icons {
            height: 18px;
            width: 160px;
            position: relative;
            background: transparent url(../../../../../images/search_bg_magnifier.png) 160px center no-repeat;
            text-align: left;
            float: right;
            padding-right: 35px;
            color: #bcbcbc;
            outline: 0;
            border-color: #bcbcbc;
            border-radius: 5px;
            margin-right: 6px;
            font-size: 14px !important;
        }
    </style>
    <script>
        let elm;
        <?php
        $venobox = str_replace('[id]', '#', $venobox); // restore id hash symbol if any
        ?>
        let parent_icon_elm = parent.$('<?php echo $venobox;?>');
        let parent_icon_preview_elm = parent.$('#icon_preview');
        let selected_icon = parent.$('#icon_class').val();
        jQuery(function ($) {

            $('.icon_link').on('click', function () {
                deselectIcons();
                elm = $(this);
                elm.addClass('icons_list_selected');
                saveIcon(elm.attr('data-icon'));
            });

            $('.icon_link').each(function () {
                elm = $(this);
                if (elm.hasClass(selected_icon)) {
                    elm.addClass('icons_list_selected');
                }
            });

            $('#search_icons').on('keyup', function (e) {
                var keyword = $(this).val();
                if (!keyword.length || keyword.length == 1) {
                    resetIcons();
                    return false;
                }
                if (keyword && keyword.length > 1 && keyword.length <= 70) {
                    filterIcons(keyword);
                }
            });

        });

        function saveIcon(icon_class) {
            if (parent_icon_elm.length) {
                parent_icon_elm.val(icon_class);
                // Preview: βρες το αντίστοιχο preview από το target id
                var target_id = parent_icon_elm.attr('id');
                var preview_id = target_id.replace('wdg_icg_icon_', 'wdg_icg_icon_preview_');
                var $preview = parent.$('#' + preview_id);
                if ($preview.length) {
                    $preview.removeClass().addClass('fa ' + icon_class).css('visibility', 'visible');
                } else {
                    parent_icon_preview_elm.removeClass().addClass('fa ' + icon_class).css('visibility', 'visible');
                }
            }
            parent.window.venobox.close();
        }

        function deselectIcons() {
            $('.icon_link').each(function () {
                elm = $(this);
                elm.removeClass('icons_list_selected');
            });
        }

        function resetIcons() {
            $('.icon_link').each(function () {
                $(this).show();
            });
            $("#icons_list").animate({ scrollTop: 0 }, "fast");
        }
        function filterIcons(keyword){
            let keywords;
            $('.icon_link').each(function () {
                keywords = $(this).attr('data-search');
                if(!keywords.includes(keyword)){
                    $(this).hide();
                }else{
                    $(this).show();
                }

            });
        }
    </script>
</head>

<body id="inner_page">
<div id="icons_container">
    <div id="search_icons_header">
        <input id="search_icons" class="listbox">
        <?php echo t("Επιλέξτε ένα εικονίδιο"); ?>
    </div>
    <div id="icons_list">
        <?php
        foreach($icons as $icon) {
            $classes = explode("|", $icon);
            $search_icons = implode(" ", $classes);
            //$selected_class = (count($classes) > 1) ? 'icons_list_selected' : '';
            ?>
            <i title="<?php echo $classes[0]; ?>"
               data-icon="<?php echo $classes[0]; ?>"
               data-search="<?php echo $search_icons; ?>"
               class="icon_link fa <?php echo $classes[0] ?> <?php echo $selected_class; ?>"></i>
            <?php
        }
        ?>
    </div>
</div>
</body>
</html>
