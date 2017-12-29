<?php

namespace dev7ch\slick;

use dev7ch\slick\assets\PicturefillAsset;
use dev7ch\slick\assets\ResourcesAsset;
use dev7ch\slick\assets\SlickAsset;

\Yii::setAlias('@slick', '@bower/slick-carousel');
\Yii::setAlias('@resources', dirname(__DIR__).'/src/resources');

class SlickWidget extends \luya\base\Widget
{
    public $baseUrl;
    public $images;
    public $slickConfig = [];
    public $slickConfigWidget;

    public function init()
    {
        PicturefillAsset::register($this->getView());
        SlickAsset::register($this->getView());
        ResourcesAsset::register($this->getView());

        if (Module::slickConfig() !== false) {
            $this->slickConfig = Module::slickConfig();
        } else {
            $this->slickConfig = $this->slickConfigWidget;
        }

        $this->view->registerJs(
            "var slickSlider = $('.slick-slider').slick({"
                .implode(', ',
                    array_map(
                        function ($config, $option) {
                            return sprintf('%s:%s', $option, $config);
                        },
                        $this->slickConfig, array_keys($this->slickConfig)
                    )
                ).
            '});',
            \luya\web\View::POS_READY,
            'slickSlider'
        );

        parent::init();
    }

    public function run()
    {
        return $this->render('SlickSlider', ['widget' => $this]);
    }
}
