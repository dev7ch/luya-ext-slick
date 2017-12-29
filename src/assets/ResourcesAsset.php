<?php

namespace dev7ch\slick\assets;

use luya\web\Asset;

class ResourcesAsset extends Asset
{
    public $sourcePath = '@resources';

    public $css = [
        'slick-custom-style.css',
    ];

    public $js = [];

    public $depends = [
        'dev7ch\slick\assets\SlickAsset',
    ];
}
