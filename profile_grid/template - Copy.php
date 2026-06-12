<?php
/*
 * Widgetizer — Profile Grid Widget — template.php
 * Prefix: prgr
 */
defined('CMS') or die("This file cannot run this way!");

// ── Base assets ───────────────────────────────────────────────────────────────
$_wdg_assets = 'admin/builder_widget_assets/';
$_wdg_css    = $_wdg_assets . 'base.css';
$_wdg_js     = $_wdg_assets . 'scripts.js';
if (!in_array($_wdg_css, $document->loadedFiles)) {
    echo '<link href="' . $_wdg_css . '" rel="stylesheet" type="text/css">' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_css;
}
if (!in_array($_wdg_js, $document->loadedFiles)) {
    echo '<script src="' . $_wdg_js . '" defer></script>' . PHP_EOL;
    $document->loadedFiles[] = $_wdg_js;
}

// ── Params ────────────────────────────────────────────────────────────────────
$_widget_id        = 'widget_' . $blockID;
$_eyebrow          = htmlspecialchars($wdg_params['eyebrow']          ?? '');
$_title            = htmlspecialchars($wdg_params['title']            ?? '');
$_description      = htmlspecialchars($wdg_params['description']      ?? '');
$_color            = htmlspecialchars($wdg_params['color_scheme']     ?? 'color-scheme-standard-primary');
$_header_alignment = $wdg_params['header_alignment']                  ?? 'center';
$_layout           = $wdg_params['layout']                            ?? 'grid';
$_columns          = (int)($wdg_params['columns']                     ?? 3);
$_image_style      = $wdg_params['image_style']                       ?? 'circle';
$_prgr_items       = $wdg_params['items']                             ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_alignment_class = ($_header_alignment === 'center') ? 'widget-header--align-center' : 'widget-header--align-start';
$_section_style   = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

// ── Social SVG icons ──────────────────────────────────────────────────────────
$_social_svgs = [
    'linkedin'  => '<path d="M8 11v5"/><path d="M8 8v.01"/><path d="M12 16v-5"/><path d="M16 16v-3a2 2 0 1 0 -4 0"/><path d="M3 7a4 4 0 0 1 4 -4h10a4 4 0 0 1 4 4v10a4 4 0 0 1 -4 4h-10a4 4 0 0 1 -4 -4l0 -10"/>',
    'twitter'   => '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4l11.733 16h4.267l-11.733 -16l-4.267 0"/><path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"/>',
    'instagram' => '<path d="M4 8a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z"/><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"/><path d="M16.5 7.5v.01"/>',
    'facebook'  => '<path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3"/>',
    'email'     => '<path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"/><path d="M3 7l9 6l9 -6"/>',
    'github'    => '<path d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5"/>',
    'youtube'   => '<path d="M2 8a4 4 0 0 1 4 -4h12a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-12a4 4 0 0 1 -4 -4v-8z"/><path d="M10 9l5 3l-5 3z"/>',
    'tiktok'    => '<path d="M21 7.917v4.034a9.9 9.9 0 0 1 -5 -1.951v4.5a6.5 6.5 0 1 1 -8 -6.326v4.326a2.5 2.5 0 1 0 4 2v-11.5h4.083a6.005 6.005 0 0 0 4.917 4.917z"/>',
    'pinterest' => '<path d="M8 20l4 -9"/><path d="M10.7 14c.437 1.263 1.43 2 2.55 2c2.071 0 3.75 -1.554 3.75 -4a5 5 0 1 0 -9.7 1.7"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>',
    'bluesky'   => '<path d="M6.335 5.144c-1.654 -1.199 -4.335 -2.127 -4.335 .826c0 .59 .35 4.953 .556 5.661c.713 2.463 3.13 2.75 5.444 2.369c-4.045 .665 -4.889 3.208 -2.667 5.41c1.03 1.018 1.913 1.59 2.667 1.59c2 0 3.134 -2.769 3.5 -3.5c.333 -.667 .5 -1.167 .5 -1.5c0 .333 .167 .833 .5 1.5c.366 .731 1.5 3.5 3.5 3.5c.754 0 1.637 -.571 2.667 -1.59c2.222 -2.203 1.378 -4.746 -2.667 -5.41c2.314 .38 4.73 .094 5.444 -2.369c.206 -.708 .556 -5.072 .556 -5.661c0 -2.953 -2.68 -2.025 -4.335 -.826c-2.293 1.662 -4.76 5.048 -5.665 6.856c-.905 -1.808 -3.372 -5.194 -5.665 -6.856"/>',
    'discord'   => '<path d="M8 12a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"/><path d="M14 12a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"/><path d="M15.5 17c0 1 1.5 3 2 3c1.5 0 2.833 -1.667 3.5 -3c.667 -1.667 .5 -5.833 -1.5 -11.5c-1.457 -1.015 -3 -1.34 -4.5 -1.5l-.972 1.923a11.913 11.913 0 0 0 -4.053 0l-.975 -1.923c-1.5 .16 -3.043 .485 -4.5 1.5c-2 5.667 -2.167 9.833 -1.5 11.5c.667 1.333 2 3 3.5 3c.5 0 2 -2 2 -3"/><path d="M7 16.5c3.5 1 6.5 1 10 0"/>',
    'whatsapp'  => '<path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9"/><path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1"/>',
    'telegram'  => '<path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4"/>',
];

$_social_labels = [
    'linkedin' => 'LinkedIn', 'twitter' => 'Twitter/X', 'instagram' => 'Instagram',
    'facebook' => 'Facebook', 'email'   => 'Email',      'github'   => 'GitHub',
    'youtube'  => 'YouTube',  'tiktok'  => 'TikTok',     'pinterest'=> 'Pinterest',
    'bluesky'  => 'Bluesky',  'discord' => 'Discord',    'whatsapp' => 'WhatsApp',
    'telegram' => 'Telegram',
];

if (!function_exists('_prgr_svg')) {
    function _prgr_svg($paths) {
        return '<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">' . $paths . '</svg>';
    }
}
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-type-profile-grid widget-<?php echo $_widget_id; ?> <?php echo $_color; ?> image-style-<?php echo htmlspecialchars($_image_style); ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="profile-grid"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?> .profile-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
.widget-<?php echo $_widget_id; ?>.image-style-circle .profile-image {
    width: 160px;
    height: 160px;
    border-radius: 50%;
    object-fit: cover;
    margin-block-end: var(--space-md);
    border: var(--border-width-medium) solid var(--border-color);
}
.widget-<?php echo $_widget_id; ?>.image-style-square .profile-image {
    width: 160px !important;
    height: 160px !important;
    border-radius: var(--radius-md);
    object-fit: cover;
    margin-block-end: var(--space-md);
    border: var(--border-width-medium) solid var(--border-color);
}
.widget-<?php echo $_widget_id; ?>.image-style-full .profile-image {
    width: 100%;
    height: auto;
    aspect-ratio: 3 / 4;
    object-fit: cover;
    display: block;
    border-radius: var(--radius-md);
    margin-block-end: var(--space-lg);
}
.widget-<?php echo $_widget_id; ?> .profile-name {
    margin-block-end: var(--space-xs);
}
.widget-<?php echo $_widget_id; ?> .profile-role {
    margin-block-end: var(--space-xs);
}
.widget-<?php echo $_widget_id; ?> .profile-specialty {
    margin-block-end: var(--space-sm);
}
.widget-<?php echo $_widget_id; ?> .profile-bio {
    margin-block-end: var(--space-md);
    max-width: 300px;
}
.widget-<?php echo $_widget_id; ?> .profile-social {
    display: flex;
    gap: var(--space-sm);
    justify-content: center;
    margin-block-start: var(--space-md);
}
.widget-<?php echo $_widget_id; ?> .profile-social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: var(--border-width-thin) solid var(--border-color);
    color: var(--text-content);
    text-decoration: none;
    transition: all var(--transition-speed-normal);
}
.widget-<?php echo $_widget_id; ?> .profile-social-link:hover {
    border-color: var(--accent);
    color: var(--accent);
}
.widget-<?php echo $_widget_id; ?> .profile-social-link svg {
    width: 18px;
    height: 18px;
}
</style>

    <div class="widget-container">

        <?php if ($_eyebrow || $_title || $_description): ?>
        <div class="widget-header <?php echo $_alignment_class; ?>">
            <?php if ($_eyebrow): ?>
            <span class="w-eyebrow reveal reveal-up" style="--reveal-delay: 0"><?php echo $_eyebrow; ?></span>
            <?php endif; ?>
            <?php if ($_title): ?>
            <h2 class="w-headline reveal reveal-up" style="--reveal-delay: 1"><?php echo $_title; ?></h2>
            <?php endif; ?>
            <?php if ($_description): ?>
            <p class="w-description reveal reveal-up" style="--reveal-delay: 2"><?php echo $_description; ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="widget-content">
            <?php if ($_layout === 'carousel'): ?>
            <div class="carousel-container reveal reveal-up">
                <button type="button" class="carousel-btn carousel-btn-prev" aria-label="Previous">
                    <svg class="carousel-btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M15 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <button type="button" class="carousel-btn carousel-btn-next" aria-label="Next">
                    <svg class="carousel-btn-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 18l6-6-6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <ul class="widget-card-grid carousel-track" style="--carousel-cols: <?php echo $_columns; ?>">
                    <?php foreach ($_prgr_items as $i => $_item):
                        $_img       = htmlspecialchars($_item['image']     ?? '');
                        $_name      = htmlspecialchars($_item['name']      ?? '');
                        $_role      = htmlspecialchars($_item['role']      ?? '');
                        $_specialty = htmlspecialchars($_item['specialty'] ?? '');
                        $_bio       = htmlspecialchars($_item['bio']       ?? '');
                        $_socials_raw = trim($_item['socials'] ?? '');
                        $_blk_id    = $_widget_id . '_profile' . $i;
                    ?>
                    <li class="profile-card carousel-item" style="--reveal-delay: <?php echo $i; ?>" data-block-id="<?php echo $_blk_id; ?>">
                        <?php if ($_img): ?><img src="<?php echo $_img; ?>" alt="<?php echo $_name; ?>" class="profile-image" width="700" height="700" loading="lazy"><?php endif; ?>
                        <?php if ($_name): ?><h3 class="profile-name w-title t-xl"><?php echo $_name; ?></h3><?php endif; ?>
                        <?php if ($_role): ?><p class="profile-role w-meta t-base t-semibold t-accent"><?php echo $_role; ?></p><?php endif; ?>
                        <?php if ($_specialty): ?><p class="profile-specialty w-meta t-sm"><?php echo $_specialty; ?></p><?php endif; ?>
                        <?php if ($_bio): ?><p class="profile-bio w-body t-sm"><?php echo $_bio; ?></p><?php endif; ?>
                        <?php if ($_socials_raw): ?>
                        <div class="profile-social">
                            <?php foreach (array_filter(explode('|||', $_socials_raw)) as $_spart):
                                $_spart = trim($_spart);
                                $_colon = strpos($_spart, ':');
                                if ($_colon === false) continue;
                                $_skey  = substr($_spart, 0, $_colon);
                                $_sval  = trim(substr($_spart, $_colon + 1));
                                if (!$_sval || !isset($_social_svgs[$_skey])) continue;
                                $_href   = ($_skey === 'email') ? 'mailto:' . htmlspecialchars($_sval) : htmlspecialchars($_sval);
                                $_target = ($_skey === 'email') ? '' : 'target="_blank" rel="noopener"';
                                $_label  = $_social_labels[$_skey] ?? $_skey;
                            ?>
                            <a href="<?php echo $_href; ?>" class="profile-social-link" aria-label="<?php echo htmlspecialchars($_label); ?>" <?php echo $_target; ?>><?php echo _prgr_svg($_social_svgs[$_skey]); ?></a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php else: ?>
            <ul class="widget-card-grid widget-grid" style="--grid-cols-desktop: <?php echo $_columns; ?>">
                <?php foreach ($_prgr_items as $i => $_item):
                    $_img       = htmlspecialchars($_item['image']     ?? '');
                    $_name      = htmlspecialchars($_item['name']      ?? '');
                    $_role      = htmlspecialchars($_item['role']      ?? '');
                    $_specialty = htmlspecialchars($_item['specialty'] ?? '');
                    $_bio       = htmlspecialchars($_item['bio']       ?? '');
                    $_socials_raw = trim($_item['socials'] ?? '');
                    $_blk_id    = $_widget_id . '_profile' . $i;
                ?>
                <li class="profile-card reveal reveal-up" style="--reveal-delay: <?php echo $i; ?>" data-block-id="<?php echo $_blk_id; ?>">
                    <?php if ($_img): ?><img src="<?php echo $_img; ?>" alt="<?php echo $_name; ?>" class="profile-image" width="700" height="700" loading="lazy"><?php endif; ?>
                    <?php if ($_name): ?><h3 class="profile-name w-title t-xl"><?php echo $_name; ?></h3><?php endif; ?>
                    <?php if ($_role): ?><p class="profile-role w-meta t-base t-semibold t-accent"><?php echo $_role; ?></p><?php endif; ?>
                    <?php if ($_specialty): ?><p class="profile-specialty w-meta t-sm"><?php echo $_specialty; ?></p><?php endif; ?>
                    <?php if ($_bio): ?><p class="profile-bio w-body t-sm"><?php echo $_bio; ?></p><?php endif; ?>
                    <?php if ($_socials_raw): ?>
                    <div class="profile-social">
                        <?php foreach (array_filter(explode('|||', $_socials_raw)) as $_spart):
                            $_spart = trim($_spart);
                            $_colon = strpos($_spart, ':');
                            if ($_colon === false) continue;
                            $_skey  = substr($_spart, 0, $_colon);
                            $_sval  = trim(substr($_spart, $_colon + 1));
                            if (!$_sval || !isset($_social_svgs[$_skey])) continue;
                            $_href   = ($_skey === 'email') ? 'mailto:' . htmlspecialchars($_sval) : htmlspecialchars($_sval);
                            $_target = ($_skey === 'email') ? '' : 'target="_blank" rel="noopener"';
                            $_label  = $_social_labels[$_skey] ?? $_skey;
                        ?>
                        <a href="<?php echo $_href; ?>" class="profile-social-link" aria-label="<?php echo htmlspecialchars($_label); ?>" <?php echo $_target; ?>><?php echo _prgr_svg($_social_svgs[$_skey]); ?></a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php if ($_layout === 'carousel'):
$_widget_id_js = 'widget_' . $blockID;
$_script = <<<JSEOF
<script>
(function(){
    function run() {
        var section = document.getElementById('{$_widget_id_js}');
        if (!section) return;
        var cc = section.querySelector('.carousel-container');
        if (cc && !cc.dataset.carouselInit) {
            cc.dataset.carouselInit = 'true';
            var track = cc.querySelector('.carousel-track');
            var prev  = cc.querySelector('.carousel-btn-prev');
            var next  = cc.querySelector('.carousel-btn-next');
            if (track && prev && next) {
                var upd = function() {
                    prev.disabled = track.scrollLeft <= 0;
                    next.disabled = track.scrollLeft + track.clientWidth >= track.scrollWidth - 1;
                };
                var amt = function() {
                    var item = track.querySelector('.carousel-item');
                    if (!item) return track.clientWidth;
                    return item.offsetWidth + (parseFloat(getComputedStyle(track).gap) || 0);
                };
                prev.addEventListener('click', function() { track.scrollBy({ left: -amt(), behavior: 'smooth' }); });
                next.addEventListener('click', function() { track.scrollBy({ left:  amt(), behavior: 'smooth' }); });
                track.addEventListener('scroll', upd, { passive: true });
                new ResizeObserver(function() { requestAnimationFrame(upd); }).observe(cc);
                upd();
            }
        }
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', run);
    else requestAnimationFrame(function() { requestAnimationFrame(run); });
})();
</script>
JSEOF;
echo $_script;
endif;
?>
