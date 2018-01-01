<?php
/**
 * SliderBlock.
 *
 * @author Silvan Hahn <silvan@dev7.ch>
 */

namespace dev7ch\slick\blocks;

use dev7ch\slick\BaseSlickBlock;
use dev7ch\slick\Module;
use luya\cms\frontend\blockgroups\ProjectGroup;
use luya\cms\helpers\BlockHelper;

class SlickBlock extends BaseSlickBlock
{
    /**
     * @var bool Choose whether a block can be cached trough the caching component. Be carefull with caching container blocks.
     */
    public $cacheEnabled = false;
    /**
     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true
     */
    public $cacheExpiration = 3600;

    /**
     * {@inheritdoc}
     */
    public function blockGroup()
    {
        return ProjectGroup::class;
    }

    /**
     * {@inheritdoc}
     */
    public function name()
    {
        return 'Slick Slider';
    }

    /**
     * {@inheritdoc}
     */
    public function icon()
    {
        return 'burst_mode'; // see the list of icons on: https://design.google.com/icons/
    }

    /**
     * {@inheritdoc}
     */
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'images', 'label' => Module::t('block_slick_item'), 'type' => self::TYPE_MULTIPLE_INPUTS, 'options' => [
                    ['var' => 'image', 'label' => Module::t('block_slick_image'), 'type' => self::TYPE_IMAGEUPLOAD, 'options' => ['no_filter' => false]],
                    ['var' => 'alt', 'label' => Module::t('block_slick_image_alt'), 'type' => self::TYPE_TEXT],
                    ['var' => 'title', 'label' => Module::t('block_slick_image_title'), 'type' => self::TYPE_TEXT],
                    ['var' => 'link', 'label' => Module::t('block_slick_image_link'), 'type' => self::TYPE_LINK],
                    ['var' => 'responsive_images', 'label' => Module::t('block_slick_adaptive'), 'type' => self::TYPE_MULTIPLE_INPUTS, 'options' => [
                        ['var' => 'image', 'label' => Module::t('block_slick_adaptive_image'), 'type' => self::TYPE_IMAGEUPLOAD, 'options' => ['no_filter' => true]],
                        ['var' => 'breakpoint', 'label' => Module::t('block_slick_adaptive_breakpoint'), 'type' => self::TYPE_TEXT, 'options' => ['placeholder' => Module::t('block_slick_adaptive_breakpoint_info')]],
                        ['var' => 'image_hd', 'label' => Module::t('block_slick_adaptive_image_hd'), 'type' => self::TYPE_IMAGEUPLOAD, 'options' => ['no_filter' => true]],
                        ['var' => 'orientation', 'label' => Module::t('block_slick_adaptive_orientation'), 'type' => self::TYPE_SELECT, 'options' => BlockHelper::selectArrayOption(
                            [
                                'landscape' => Module::t('block_slick_adaptive_orientation_landscape'),
                                'portrait'  => Module::t('block_slick_adaptive_orientation_portrait'),
                            ]
                        )],
                    ]],
                ]],
            ],
            'cfgs' => [
                // in progress
                ['var' => 'cssBackground', 'label' => 'Bild via CSS darstellen', 'type' => self::TYPE_CHECKBOX],
                ['var' => 'positionTop', 'label' => 'Position vertikal', 'type' => self::TYPE_TEXT, 'placeholder' => '50'],
                ['var' => 'positionLeft', 'label' => 'Position horizontal', 'type' => self::TYPE_TEXT, 'placeholder' => '50'],
                ['var' => 'sliderConfig', 'label' => 'Slider options', 'type' => self::TYPE_MULTIPLE_INPUTS, 'options' => [
                    ['var' => 'option', 'label' => 'Option', 'type' => self::TYPE_TEXT],
                    ['var' => 'config', 'label' => 'Config', 'type' => self::TYPE_TEXT, 'options' => ['initValue' => 'true']],
                ]],
            ],
        ];
    }

    public function responsiveImages($parent)
    {
        $respImagesInput = $parent['responsive_images'];
        $respImages = [];
        foreach ($respImagesInput as $item) {
            $respImages[] = [
                'breakpoint'  => isset($item['breakpoint']) ? $item['breakpoint'] : '0',
                'orientation' => isset($item['orientation']) ? $item['orientation'] : 'portrait',
                'image'       => isset($item['image']) ? BlockHelper::imageUpload($item['image'], false, true) : null,
                'imageHD'     => isset($item['image_hd']) ? BlockHelper::imageUpload($item['image_hd'], false, true) : null,
            ];
        }

        return $respImages;
    }

    public function images($image = null)
    {
        $imagesInput = $image != null ? $image : $this->getVarValue('images', []);
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

    /**
     * {@inheritdoc}
     */
    public function extraVars()
    {
        return [
            'images' => $this->images(),
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @param {{extras.image}}
     * @param {{vars.image}}
     * @param {{vars.isPublished}}
     * @param {{vars.link}}
     * @param {{vars.title}}
     */
    public function admin()
    {
        return 'Slider Admin View';
    }
}
