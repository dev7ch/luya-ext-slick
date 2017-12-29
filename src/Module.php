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
     * @param string $message
     * @param array  $params
     * @return string
     */

    public static function t($message, array $params = [])
    {
        return parent::baseT('slick', $message, $params);
    }

    /**
     * Loading and parsing of json config array.
     *
     * @param $file
     * @return string
     * @throws \luya\Exception
     * @internal param string $message
     * @internal param array $params
     */

    private static function jsonLoad($file)
    {
        if (file_exists(\Yii::$app->getWebroot() . '/' . $file)) {
            file_get_contents(\Yii::$app->getWebroot() . '/' . $file);
            return  json_decode($file, true);
        }
        else {
            throw new  \luya\Exception('Slick.js configs:' .\Yii::$app->getWebroot() . '/' . $file . ' was not found.');
        }
    }

    /**
     * Load Slick.js options via LUYA configs as $params.
     *
     * @return string | array | bool
     * @internal param array $params
     *
     */

    public static function slickConfig() {

        $params = self::getInstance()->params;

        if (array_key_exists( 'slickConfig', $params) && $params['slickConfig'] === true) {

            return self::jsonLoad('slick-config.json');
        }

        if (array_key_exists( 'slickConfig', $params) && is_string($params['slickConfig']) ) {
            return self::jsonLoad($params['slickConfig']);
        }

        if (array_key_exists( 'slickConfig', $params) && is_array($params['slickConfig'])) {
            return $params['slickConfig'];
        }

        if (array_key_exists( 'slickConfig', $params) && $params['slickConfig'] === false) {
            return null;
        }

        /*
         * Configure your slider as needed, see http://kenwheeler.github.io/slick/#settings
         *
         * 'slickConfig' supports php arrays and path to public config file in json format.
         *
         * 'slickConfig => bool | string | array
         *
         */

        return false;
    }
}
