<?php
namespace cmstests\src\frontend\blocks;

use dev7ch\slick\tests\SlickTestCase;
use dev7ch\slick\SlickWidget;
use Yii;
use luya\cms\helpers\BlockHelper;

class SlickBlockTest extends  SlickTestCase
{
    public $blockClass = 'dev7ch\slick\blocks\SlickBlock';


    protected function images()
    {
        $imagesInput = $this->block->getVarValue('images', []);
        $images = [];
        foreach ($imagesInput as $item) {
            $images[] = [
                'image'             => isset($item['image']) ? BlockHelper::imageUpload($item['image'], false, true) : null,
                'alt'               => isset($item['alt']) ? $item['alt'] : 'no-alt-text-set',
                'title'             => isset($item['title']) ? $item['title'] : '',
                'link'              => isset($item['link']) ? BlockHelper::linkObject($item['link']) : null,
                'isPublished'       => isset($item['isPublished']) ? true : false,
                'responsive_images' => $this->responsiveImages($item),

            ];
        }

        return $images;
    }

    protected function responsiveImages($parent)
    {
        $respImagesInput = $parent['responsive_images'];
        $respImages = [];
        foreach ($respImagesInput as $item) {
            $respImages[] = [
                'breakpoint'  => isset($item['breakpoint']) ? $item['breakpoint'] : '0',
                'orientation' => isset($item['orientation']) ? $item['orientation'] : 'portrait',
                'image'       => isset($item['image']) ? BlockHelper::imageUpload($item['image'], false, true) : null,
                'imageHD'     => isset($item['image_hd']) ? BlockHelper::imageUpload($item['image'], false, true) : null,
            ];
        }

        return $respImages;
    }


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


        $this->block->addExtraVar('images', $this->images());

        $this->block->setVarValues([
            'images' => [
                [
                    'title' => 'Test 1',
                    'alt' => 'alt-text',
                    'link' => \Yii::$app->basePath,
                    'image' =>  $this->block->getExtraValue('images', ['source' => 'image']) ,
                    'responsive_images' => [
                        [
                            'image' => BlockHelper::imageUpload(dirname(__DIR__) . 'tests/data/images/1.jpg', false, true),
                            'image_hd' => BlockHelper::imageUpload(dirname(__DIR__) . 'tests/data/images/1.jpg', false, true),
                            'breakpoint' => '680px',
                            'orientation' => 'landscape'
                        ],
                        [
                            'image' => BlockHelper::imageUpload(dirname(__DIR__) . 'tests/data/images/2.jpg', false, true),
                            'image_hd' => BlockHelper::imageUpload(dirname(__DIR__) . 'tests/data/images/2.jpg', false, true),
                            'breakpoint' => '1020px',
                            'orientation' => 'landscape'
                        ],
                    ]
                ],
                [
                    'title' => 'Test 2',
                    'alt' => 'alt-text-2',
                    'link' => \Yii::$app->basePath,
                    'image' => BlockHelper::imageUpload(dirname(__DIR__) . 'tests/data/images/2.jpg', false, true),
                    'responsive_images' => [
                        [
                            'image' => BlockHelper::imageUpload(dirname(__DIR__) . 'tests/data/images/1.jpg', false, true),
                            'image_hd' => BlockHelper::imageUpload(dirname(__DIR__) . 'tests/data/images/1.jpg', false, true),
                            'breakpoint' => '680px',
                            'orientation' => 'landscape'
                        ],
                        [
                            'image' => BlockHelper::imageUpload(dirname(__DIR__) . 'tests/data/images/2.jpg', false, true),
                            'image_hd' => BlockHelper::imageUpload(dirname(__DIR__) . 'tests/data/images/2.jpg', false, true),
                            'breakpoint' => '1020px',
                            'orientation' => 'landscape'
                        ],
                    ]
                ]
            ]
        ]);


        $is = SlickWidget::widget([
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

    public function testRender() {

        $is = $this->block->renderFrontend();
        $should = $is;
        $this->assertSame($is, $should);
    }

}