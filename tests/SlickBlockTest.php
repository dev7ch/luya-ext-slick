<?php
namespace cmstests\src\frontend\blocks;

use dev7ch\slick\tests\SlickTestCase;
use Yii;

class SlickBlockTest extends  SlickTestCase
{
    public $blockClass = 'dev7ch\slick\blocks\SlickBlock';


    public function testEmpty()
    {
        $this->assertSame('<div class="container"><div class="slider slick-slider" itemscope itemtype="http://schema.org/ImageGallery"></div></div>', $this->renderFrontendNoSpace());
    }

    public function files_are_equal($a, $b)
    {
        // Check if filesize is different
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


        $is = ['view' => fopen(dirname(__FILE__, 2) . '/src/views/SlickSlider.php', 'rb')];
        $should = [ 'view' => fopen(dirname(__FILE__) . '/data/views/SlickSlider.php', 'rb')];
        $this->assertSameSize($is,$should);

    }

}