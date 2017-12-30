<?php

namespace cmstests\src\frontend\blocks;

use dev7ch\slick\SlickWidget;
use dev7ch\slick\tests\SlickTestCase;

class SlickBlockTest extends SlickTestCase
{
    public $blockClass = 'dev7ch\slick\blocks\SlickBlock';

    public function testEmpty()
    {
        $this->assertSame('<div class="slider slick-slider" itemscope itemtype="http://schema.org/ImageGallery"></div>', $this->renderFrontendNoSpace());
    }

    public function files_are_equal($a, $b)
    {
        // Check if file size is different
        if (filesize($a) !== filesize($b)) {
            return false;
        }

        // Check if content is different
        $ah = fopen($a, 'rb');
        $bh = fopen($b, 'rb');

        $result = true;
        while (!feof($ah)) {
            if (fread($ah, 8192) != fread($bh, 8192)) {
                $result = false;
                break;
            }
        }

        fclose($ah);
        fclose($bh);

        return $result;
    }

    public function testWidgetView()
    {
        $image_1 = (object) ['source' => dirname(__DIR__).'tests/data/images/1.jpg'];
        $image_2 = (object) ['source' => dirname(__DIR__).'tests/data/images/2.jpg'];
        $image_3 = (object) ['source' => dirname(__DIR__).'tests/data/images/3.jpg'];
        $link = (object) ['link' => 'test'];

        $images = ['images' => [
                'title'             => 'Test 1',
                'alt'               => 'alt-text',
                'link'              => $link,
                'image'             => $image_1,
                'responsive_images' => [
                    [
                        'image'       => $image_1,
                        'imageHD'     => $image_2,
                        'breakpoint'  => '1020px',
                        'orientation' => 'landscape',
                    ],
                ],
            ],
            [
                'title'             => 'Test 2',
                'alt'               => 'alt-text-2',
                'link'              => $link,
                'image'             => $image_2,
                'responsive_images' => [
                    [
                        'image'       => $image_3,
                        'imageHD'     => $image_3,
                        'breakpoint'  => '680px',
                        'orientation' => 'landscape',
                    ],
                ],
            ],
        ];

        $this->block->addExtraVar('images', $images);

        $is =
            SlickWidget::widget([
            'images'            => $this->block->getExtraValue('images'),
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

    public function testRender()
    {
        $is = $this->block->renderFrontend();
        $should = $is;
        $this->assertSame($is, $should);
    }
}
