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
     * @param $message
     * @param array $params
     * @param $category
     *
     * @internal param unknown $language
     *
     * @return string
     */
    public static function t($message, array $params = [], $category = 'slick')
    {
        return parent::baseT($category, $message, $params);
    }

    /**
     * Loading and parsing of json config array.
     *
     * @param $file
     *
     * @throws \luya\Exception
     *
     * @return string
     *
     * @internal param string $message
     * @internal param array $params
     */
    private static function jsonLoad($file)
    {
        if (file_exists(\Yii::$app->getWebroot().'/'.$file)) {
            file_get_contents(\Yii::$app->getWebroot().'/'.$file);

            return  json_decode($file, true);
        } else {
            throw new  \luya\Exception('Slick.js configs:'.\Yii::$app->getWebroot().'/'.$file.' was not found.');
        }
    }

    /**
     * Load Slick.js options via LUYA configs as $params.
     *
     * @return bool | string | array
     *
     * @internal param array $params
     */
    public static function slickConfig()
    {
        $params = self::getInstance()->params;

        if (array_key_exists('slickConfig', $params) && $params['slickConfig'] === true) {
            return self::jsonLoad('slick-config.json');
        }

        if (array_key_exists('slickConfig', $params) && is_string($params['slickConfig'])) {
            return self::jsonLoad($params['slickConfig']);
        }

        if (array_key_exists('slickConfig', $params) && is_array($params['slickConfig'])) {
            return $params['slickConfig'];
        }

        if (array_key_exists('slickConfig', $params) && is_bool($params['slickConfig'] === false)) {
            return false;
        }

        return false;
    }
}
