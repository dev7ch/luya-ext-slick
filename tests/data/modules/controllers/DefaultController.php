<?php

namespace dev7ch\slick\tests\data\modules\controllers;

use luya\web\Controller;
use luya\cms\Exception;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        /*
        $this->registerAsset('dev7ch\slick\assets\PicturefillAsset');
        $this->registerAsset('dev7ch\slick\assets\SlickAsset');
        $this->registerAsset('luya\web\ResourceAsset');
        */

        return 'cmsunitmodule/default/index';
    }
    
    public function actionWithArgs($param)
    {
        return $param;
    }
    
    public function actionException()
    {
        throw new Exception();
    }
}
