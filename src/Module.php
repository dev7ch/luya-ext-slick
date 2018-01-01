<?php

namespace dev7ch\slick;


/**
 * Slick.js slider block and widget extension for LUYA.
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
     * @param string $message
     * @param array  $params
     * @param string $category
     *
     * @internal param string $language
     *
     * @return string
     */
    public static function t($message, array $params = [], $category = 'slick')
    {
        return parent::baseT($category, $message, $params);
    }
}
