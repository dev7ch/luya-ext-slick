<?php

namespace dev7ch\slick;


/**
 * Slick.js slider LUYA module.
 *
 * @author Silvan Hahn <silvan@dev7.ch>
 */
class Module extends \luya\base\Module
{
    /**
     * {@inheritdoc}
     */
    public static function onLoad()
    {
        self::registerTranslation('slick*', static::staticBasePath().'/messages', [
            'fileMap' => [
                'slick' => 'slick.php',
            ],
        ]);
    }

    /**
     * Translations.
     *
     * @param string|\luya\base\unknown $message
     * @param array  $params
     * @param string|\luya\base\unknown $category
     *
     * @internal param unknown $language
     *
     * @return string|\luya\base\unknown
     */
    public static function t($message, array $params = [], $category = 'slick')
    {
        return parent::baseT($category, $message, $params);
    }
}
