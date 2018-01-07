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
    public $slickConfigFile;


    private function slickConfigFile() {

        $file = dirname(__DIR__, 3) . '/' . $this->slickConfigFile;
        $type = pathinfo($file);

        if ($type['extension'] == 'php') {
            $config = include $file;

        } elseif ($type['extension'] == 'json') {
            $json = file_get_contents($file);
            $config = json_decode($json, true);
        }

        else {

            throw new \luya\Exception('The file type .'. $type['extension'] . ' is currently not supported. Please use .php or .json files array for custom configuration of Slick.js.');
        }

        return $this->slickConfigFile = $config;
    }


    public function init()
    {
        PicturefillAsset::register($this->getView());
        SlickAsset::register($this->getView());
        ResourcesAsset::register($this->getView());

        if ($this->slickConfigFile != null) {

            $this->slickConfig = $this->slickConfigFile();

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
