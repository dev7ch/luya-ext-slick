# Adaptive and responsive slider extension for LUYA
[![Latest Stable Version](https://poser.pugx.org/dev7ch/luya-ext-slick/v/stable)](https://packagist.org/packages/dev7ch/luya-ext-slick)
[![Build Status](https://travis-ci.org/travis-ci/travis-web.svg?branch=master)](https://travis-ci.org/travis-ci/travis-web)
[![Code Coverage](https://scrutinizer-ci.com/g/dev7ch/luya-ext-slick/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/dev7ch/luya-ext-slick/?branch=master)
[![Code Quality](https://scrutinizer-ci.com/g/dev7ch/luya-ext-slick/badges/quality-score.png?b=master&l=quality)](https://scrutinizer-ci.com/g/dev7ch/luya-ext-slick/?branch=master)
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

This LUYA extension is usable in 3 ways:

- As draggable block out of the box in the LUYA admin UI.
- As Widget in custom view files.

### Block
Simply drag and drop the block in the pages section in the admin UI to the desired place and add content to the slider.

### Widget
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
        'slickConfig' => [
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

### Module
Include the module extension into your `configs/env.php` under the modules section:

```php
'modules' => [
    // ... other modules
    'slick' => [
        'class' => 'dev7ch\slick\Module'
    ]
],

```

Further this extension let you configure the Slick.js slider js options directly from your, e.g. in `configs\env.php`, can be set via `$params` very simple:

```php
'modules' => [
    // ... other modules
    'slick' => [
        'class' => 'dev7ch\slick\Module',
        'params' => [
            'slickConfig' => true // loads public_html/slick-config.json
        ]
    ]
],
```

Adding your configs in different formats is supported, see the example below:

```php
'params' => [
    'slickConfig' => true // Loads public_html/slick-config.json and override Slick.js configs from the widget.
    'slickConfig' => false // default configs from the widget will be used.
    'slickConfig' => 'custom/your-slick-config.json' // Loads public_html/custom/your-slick-config.json
    'slickConfig' => [ 
        'inifinte' => 'true',       
        'autoplay' => 'true',
        'autoplaySpeed' => '5000',    
    ] // Provide the Slick.js configs as PHP array or include an array file from anywhere of your project.
]
```

Finally run the `./vendor/bin/luya import` command to make the Slick slider block available in the admin UI.


## Collaboration

[![StyleCI](https://styleci.io/repos/115734060/shield?branch=master&style=flat)](https://styleci.io/repos/115734060)

If you would like to contribute any thing, e.g. translations, you are very welcome.

For usage of this repo inside your [LUYA env dev](https://github.com/luyadev/luya-env-dev) please keep in mind that `picturefill` and `slick-carousel` are needed dependencies inside your `vendor/bower` folder, simply add them to your `composer.json` inside the luya-env-dev root directory by running:

```bash
composer require bower-asset/slick-carousel:~1.8.0
composer require bower-asset/picturefill:~3.0.0
```

## Roadmap

- add module functionality
- adding all slick js options to admin UI
- create admin UI block view
