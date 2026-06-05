<?php
/*
 * Widgetizer — Project Showcase Widget — template.php
 * Prefix: psc
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
$_header_alignment = $wdg_params['header_alignment']                  ?? 'left';
$_layout           = $wdg_params['layout']                            ?? 'grid';
$_columns          = (int)($wdg_params['columns']                     ?? 3);
$_aspect_ratio     = $wdg_params['aspect_ratio']                      ?? '4 / 3';
$_text_display     = $wdg_params['text_display']                      ?? 'on_hover';
$_psc_items        = $wdg_params['items']                             ?? [];

$_container_width = $wdg_params['container_width'] ?? 'xl';
$_width_map  = ['full' => null, 'xl' => '1420px', 'lg' => '1200px', 'md' => '960px', 'sm' => '760px'];
$_max_width  = $_width_map[$_container_width] ?? '1420px';
$_full_width = ($_container_width === 'full');

$_alignment_class = ($_header_alignment === 'center') ? 'widget-header--align-center' : 'widget-header--align-start';
$_section_style   = 'padding-bottom: 20px;';
if (!$_full_width && $_max_width) {
    $_section_style .= ' max-width: ' . $_max_width . '; margin-inline: auto;';
}

// ── Aspect ratio CSS ──────────────────────────────────────────────────────────
if ($_aspect_ratio === 'contain') {
    $_img_css = 'width: 100%; height: 240px; max-height: 60vh; object-fit: contain; display: block; transition: transform var(--transition-speed-normal) ease;';
} elseif ($_aspect_ratio === 'auto') {
    $_img_css = 'width: 100%; height: auto; aspect-ratio: auto; object-fit: cover; display: block; transition: transform var(--transition-speed-normal) ease;';
} else {
    $_img_css = 'width: 100%; height: auto; aspect-ratio: ' . $_aspect_ratio . '; object-fit: cover; display: block; transition: transform var(--transition-speed-normal) ease;';
}

$_overlay_always = ($_text_display === 'always') ? 'opacity: 1 !important;' : '';
?>

<section
    id="<?php echo $_widget_id; ?>"
    class="widget widget-type-project-showcase widget-<?php echo $_widget_id; ?> <?php echo $_color; ?>"
    data-widget-id="<?php echo $_widget_id; ?>"
    data-widget-type="project-showcase"
    style="<?php echo $_section_style; ?>"
>

<style>
.widget-<?php echo $_widget_id; ?> .widget-card {
    position: relative;
    padding: 0;
    overflow: hidden;
    border: none;
}
.widget-<?php echo $_widget_id; ?> .widget-card:hover .project-image {
    transform: scale(1.05);
}
.widget-<?php echo $_widget_id; ?> .widget-card:hover .project-overlay {
    opacity: 1;
}
.widget-<?php echo $_widget_id; ?> .project-image {
    <?php echo $_img_css; ?>
    border-radius: 0;
    margin: 0;
}
.widget-<?php echo $_widget_id; ?> .project-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%);
    display: flex;
    align-items: flex-end;
    padding: var(--space-lg);
    opacity: 0;
    transition: opacity var(--transition-speed-normal) ease;
    <?php echo $_overlay_always; ?>
}
.widget-<?php echo $_widget_id; ?> .project-content {
    color: #ffffff;
}
.widget-<?php echo $_widget_id; ?> .project-title {
    color: #ffffff !important;
}
.widget-<?php echo $_widget_id; ?> .project-description {
    font-size: calc(var(--font-size-sm) * var(--body-scale));
    color: rgba(255,255,255,0.8) !important;
    margin-block-start: var(--space-xs);
}
.widget-<?php echo $_widget_id; ?> .widget-card-link {
    position: absolute;
    inset: 0;
    z-index: 1;
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
                    <?php foreach ($_psc_items as $i => $_item):
                        $_img    = htmlspecialchars($_item['image']       ?? '');
                        $_ititle = htmlspecialchars($_item['title']       ?? '');
                        $_idesc  = htmlspecialchars($_item['description'] ?? '');
                        $_iurl   = htmlspecialchars(wdg_parse_links($_item['url'] ?? ''));
                        $_itab   = ($_item['new_tab'] ?? '0') === '1';
                        $_blk_id = $_widget_id . '_psc' . $i;
                    ?>
                    <li class="widget-card reveal reveal-scale carousel-item" style="--reveal-delay: <?php echo $i; ?>" data-block-id="<?php echo $_blk_id; ?>">
                        <?php if ($_img): ?><img src="<?php echo $_img; ?>" alt="<?php echo $_ititle; ?>" class="project-image" width="800" height="600" loading="lazy"><?php endif; ?>
                        <?php if ($_ititle || $_idesc): ?>
                        <div class="project-overlay">
                            <div class="project-content">
                                <?php if ($_ititle): ?><h3 class="project-title w-title t-xl"><?php echo $_ititle; ?></h3><?php endif; ?>
                                <?php if ($_idesc): ?><p class="project-description w-body t-sm"><?php echo $_idesc; ?></p><?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if ($_iurl): ?><a href="<?php echo $_iurl; ?>" class="widget-card-link" aria-label="<?php echo $_ititle; ?>" <?php echo $_itab ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>></a><?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php else: ?>
            <ul class="widget-card-grid widget-grid" style="--grid-cols-desktop: <?php echo $_columns; ?>">
                <?php foreach ($_psc_items as $i => $_item):
                    $_img    = htmlspecialchars($_item['image']       ?? '');
                    $_ititle = htmlspecialchars($_item['title']       ?? '');
                    $_idesc  = htmlspecialchars($_item['description'] ?? '');
                    $_iurl   = htmlspecialchars(wdg_parse_links($_item['url'] ?? ''));
                    $_itab   = ($_item['new_tab'] ?? '0') === '1';
                    $_blk_id = $_widget_id . '_psc' . $i;
                ?>
                <li class="widget-card reveal reveal-scale" style="--reveal-delay: <?php echo $i; ?>" data-block-id="<?php echo $_blk_id; ?>">
                    <?php if ($_img): ?><img src="<?php echo $_img; ?>" alt="<?php echo $_ititle; ?>" class="project-image" width="800" height="600" loading="lazy"><?php endif; ?>
                    <?php if ($_ititle || $_idesc): ?>
                    <div class="project-overlay">
                        <div class="project-content">
                            <?php if ($_ititle): ?><h3 class="project-title w-title t-xl"><?php echo $_ititle; ?></h3><?php endif; ?>
                            <?php if ($_idesc): ?><p class="project-description w-body t-sm"><?php echo $_idesc; ?></p><?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if ($_iurl): ?><a href="<?php echo $_iurl; ?>" class="widget-card-link" aria-label="<?php echo $_ititle; ?>" <?php echo $_itab ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>></a><?php endif; ?>
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
