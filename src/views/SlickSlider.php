<div class="slider slick-slider" itemscope itemtype="http://schema.org/ImageGallery">
    <?php foreach ($widget->images as $image):
        $title = $image['title'];
        $link = $image['link'];
        $imageFallback = $image['image']->source;
        $respImages = $image['responsive_images'];
        $alt = $image['alt'];
    ?>
        <div class="slider-item">
            <figure itemprop="associatedMedia" class="slider-image-container" itemscope itemtype="http://schema.org/ImageObject">
                <?php if (!empty($link)): ?>
                    <a href="<?= $link->link ?>" itemprop="contentUrl">';} ?>
                <?php endif; ?>
                    <?php if (is_array($respImages) || is_object($respImages)): ?>
                        <!-- adaptive images -->
                        <picture>
                            <?php foreach ($respImages as $item):
                                $image = $item['image']->source;
                                $imageHD = $item['imageHD'] ? $item['imageHD']->source : $item['image']->source;
                                $orientation = $item['orientation'] ? ' and (orientation:'.$item['orientation'].')' : '';
                                $breakpoint = $item['breakpoint'] ? ' media="(min-width:'.$item['breakpoint'].'px)'.$orientation.'"' : 'media="(min-width:0)'.$orientation.'"';
                            ?>
                                <source srcset="<?= $image ?>, <?= $imageHD ?> 2x"<?= $breakpoint ?>>
                            <?php endforeach; ?>
                            <!-- fallback image -->
                            <img class="slider-image" src="<?= $imageFallback ?>" itemprop="image" alt="<?= $alt ?>"
                                 srcset="<?= $imageFallback ?>, <?= $imageFallback ?> 2x">
                        </picture>
                    <?php else: ?>
                        <img class="slider-image" src="<?= $imageFallback ?>" itemprop="image" alt="<?= $alt ?>"/>
                    <?php endif; ?>
                <?php if (!empty($link)): ?>
                    </a>
                <?php endif; ?>
                <figcaption class="slick-caption" itemprop="caption description"><?= $title ?></figcaption>
            </figure>
        </div>
    <?php endforeach; ?>
</div>
