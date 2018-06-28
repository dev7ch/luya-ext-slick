# Adaptive and responsive slider extension for LUYA
[![Latest Stable Version](https://poser.pugx.org/dev7ch/luya-ext-slick/v/stable)](https://packagist.org/packages/dev7ch/luya-ext-slick)
[![Build Status](https://travis-ci.org/travis-ci/travis-web.svg?branch=master)](https://travis-ci.org/travis-ci/travis-web)
[![Coverage Status](https://coveralls.io/repos/github/dev7ch/luya-ext-slick/badge.svg?branch=master)](https://coveralls.io/github/dev7ch/luya-ext-slick?branch=master)
[![Code Quality](https://scrutinizer-ci.com/g/dev7ch/luya-ext-slick/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dev7ch/luya-ext-slick/?branch=master)
[![Total Downloads](https://poser.pugx.org/dev7ch/luya-ext-slick/downloads)](https://packagist.org/packages/dev7ch/luya-ext-slick)
[![License](https://poser.pugx.org/dev7ch/luya-ext-slick/license)](https://packagist.org/packages/dev7ch/luya-ext-slick)


Implements the responsive SlickSlider from Ken Wheeler as a LUYA widget which can be used out of the box in the LUYA admin UI as draggable block extension in your project.

See the [slider demo page](http://kenwheeler.github.io/slick/#demos).

This is an yii2 extension for [LUYA](https://luya.io/).

## Features

- Adaptive images based on screen min-width and/or orientation
- Optionally addition of retina images separately
- Reusable widget which can be included in own custom view files
- Picturefill included for better browser support of `<picture>` tag
- Schema.org standards for images gallery are in charge
- Multilingual LUYA admin UI support
- Responsive and touch friendly

## Installation

1. Add the composer package to your project:

```bash
composer require dev7ch/luya-ext-slick
```

2. Run import

```sh
./luya import
```

## Usage

This LUYA extension is usable in two ways:

- As draggable block out of the box in the LUYA admin UI.
- As PHP widget in custom view files with custom Slick.js settings.

### 1. Block Usage

Simply drag and drop the block in the pages section in the admin UI to the desired place and add content to your new slick slider.

### 2. Widget Usage

This extension is shipped as widget which means it can the reused in own custom views from modules or blocks.

Example usage in a block view file:

```html
<?php
use dev7ch\slick\SlickWidget;

$images = $this->extraValue('images'); // Array of images width additional fields

?>

<div class="container">
    <?= SlickWidget::widget([
        'images' => $images,
        'slickConfigWidget' => [
            'infinite' => 'true',
            'slidesToShow' => '1',
            'slidesToScroll' => '1',
            'autoplay' => 'true',
            'autoplaySpeed' => '5000' // see all available configs http://kenwheeler.github.io/slick/#settings
        ]
    ])
    ?>
</div>

```

Or you could load the Slick.js configs from a file like this:

```php

<?= SlickWidget::widget([
    'images'            => $images,
    'slickConfigFile' => 'path/to/yourConfig.php'  // or a .json file
]);
?>

```

The beginning of the path points to your project root folder (not web root, which is directory `public_html`).

> Using `slickConfigFile` will override `slickConfigWidget` if it is configured.


Due this widget supports adaptive images, below a little explanation of the logic behind.

The single image and additional info are delivered as an array:

```html
<div class="slider slick-slider" itemscope itemtype="http://schema.org/ImageGallery">
    <?php foreach ($widget->images as $image):
        $title = $image['title'];
        $link = $image['link'];
        $imageFallback = $image['image']->source;
        $respImages = $image['responsive_images'];
        $alt = $image['alt'];
    ?>

        // ... slider content array

    <?php endforeach; ?>
</div>

```

The array of the single image includes an nested array for adaptive images, in particular:

```html
// ... wrapped by foreach loop with vars declaration  

<div class="slider-item">
   <figure itemprop="associatedMedia" class="slider-image-container" itemscope itemtype="http://schema.org/ImageObject">
       <?php if (!empty($link)) {return '<a href="'.$link->link.'" itemprop="contentUrl">';} ?>
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
       <?php if (!empty($link)) {return '</a>';} ?>
       <figcaption class="slick-caption" itemprop="caption description"><?= $title ?></figcaption>
   </figure>
 </div>
```

## Collaboration

[![StyleCI](https://styleci.io/repos/115734060/shield?branch=master&style=flat)](https://styleci.io/repos/115734060)

If you would like to contribute any thing, e.g. translations, you are very welcome.

For usage of this repo inside your [LUYA env dev](https://github.com/luyadev/luya-env-dev) please keep in mind that `picturefill` and `slick-carousel` are needed dependencies inside your `vendor/bower` folder, simply add them to your `composer.json` inside the luya-env-dev root directory by running:

```bash
composer require bower-asset/slick-carousel:~1.8.0
composer require bower-asset/picturefill:~3.0.0
```

## Unit Tests

1.) Create `assets` directory.  
2.) Run `./vendor/bin/phpunit tests/SlickBlockTest.php`

Make sure composer installed all needed dependencies correctly inside your corresponding `vendor` folder

To run the PHPUnit Test the directory `assets/` needs to be created in the **root folder of this extension**, e.g. `luya-env-dev/repos/luya-ext-slick/assets`.

> The `assets/` directory is in charge for test execution only and should  **not** be tracked or commited by your VCS.

## Disired next features

- adding all slick js options to admin UI block cfgs
- adding all slick js options as properties to the widget
- create admin UI block view
