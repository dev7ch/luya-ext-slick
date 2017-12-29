<?php
namespace cmstests\src\frontend\blocks;

use dev7ch\slick\tests\SlickTestCase;
use dev7ch\slick\SlickWidget;
use Yii;

class SlickBlockTest extends  SlickTestCase
{
    public $blockClass = 'dev7ch\slick\blocks\SlickBlock';


    public function testEmpty()
    {
        $this->assertSame('<div class="slider slick-slider" itemscope itemtype="http://schema.org/ImageGallery"></div>', $this->renderFrontendNoSpace());
    }

    public function files_are_equal($a, $b)
    {
        // Check if file size is different
        if(filesize($a) !== filesize($b))
            return false;

        // Check if content is different
        $ah = fopen($a, 'rb');
        $bh = fopen($b, 'rb');

        $result = true;
        while(!feof($ah))
        {
            if(fread($ah, 8192) != fread($bh, 8192))
            {
                $result = false;
                break;
            }
        }

        fclose($ah);
        fclose($bh);

        return $result;
    }

    public function testWidgetView() {


        $is = SlickWidget::widget([
            'images'            => [],
            'slickConfigWidget' => [
                'infinite'       => 'true',
                'slidesToShow'   => '1',
                'slidesToScroll' => '1',
                'autoplay'       => 'true',
                'autoplaySpeed'  => '5000',
            ],
        ]);

        $should = $is;
        $this->assertSame($is, $should);

    }

}