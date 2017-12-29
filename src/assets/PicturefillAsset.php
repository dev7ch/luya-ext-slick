<?php

namespace dev7ch\slick\assets;

use luya\web\Asset;

class PicturefillAsset extends Asset
{
    public $sourcePath = '@bower/picturefill';

    public $js = [
        'dist/picturefill.min.js',
    ];
    public $jsOptions = [
        'position' => \luya\web\View::POS_HEAD,

    ];
}
