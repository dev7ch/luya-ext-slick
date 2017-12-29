<?php

namespace dev7ch\slick\assets;

use luya\web\Asset;

class SlickAsset extends Asset
{
    public $sourcePath = '@slick';

    public $css = [
        'slick/slick.css',
        'slick/slick-theme.css',
    ];

    public $js = [
        'slick/slick.min.js',
    ];

    public $depends = [
      'yii\web\JqueryAsset',
    ];
}
