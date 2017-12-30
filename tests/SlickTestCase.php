<?php

namespace dev7ch\slick\tests;

use luya\base\Boot;
use luya\testsuite\cases\CmsBlockTestCase;

abstract class SlickTestCase extends CmsBlockTestCase
{
    public function getConfigArray()
    {
        return [
            'id'           => 'slicktestblock',
            'basePath'     => dirname(__DIR__),
            'siteTitle'    => 'LUYA slick slider test',
            'remoteToken'  => 'testtoken',
            'defaultRoute' => 'admin',
            'aliases'      => [
                '@runtime' => dirname(__DIR__).'/runtime',
                '@module'  => dirname(__DIR__).'/src',
            ],

            'language'   => 'en',
            'components' => [
                'storage' => [
                    'class'       => 'luya\admin\filesystem\LocalFileSystem',
                    'filesArray'  => [],
                    'imagesArray' => [],
                ],
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn'   => 'sqlite::memory:',
                ],
                'menu' => [
                    'class' => 'luya\cms\Menu',
                ],
            ],
            'modules' => [
                'slick' => [
                    'class' => 'dev7ch\slick\Module',
                ],
                'CmsUnitModule' => 'dev7ch\slick\tests\data\modules\CmsUnitModule',
            ],
        ];
    }

    public function afterSetup()
    {
        parent::afterSetup();

        $this->app->menu->setLanguageContainer('en', [
            1 => [
                'id'               => '1',
                'nav_id'           => '1',
                'lang'             => 'en',
                'link'             => '/luya/envs/dev/public_html/',
                'title'            => 'Homepage',
                'alias'            => 'home',
                'description'      => '',
                'keywords'         => null,
                'create_user_id'   => '1',
                'update_user_id'   => '1',
                'timestamp_create' => '1457091369',
                'timestamp_update' => '1483367249',
                'is_home'          => '0',
                'parent_nav_id'    => '0',
                'sort_index'       => '1',
                'is_hidden'        => '0',
                'type'             => '1',
                'nav_item_type_id' => '1',
                'redirect'         => false,
                'module_name'      => false,
                'container'        => 'default',
                'depth'            => 1,
            ],
        ]);
    }

    public function bootApplication(Boot $boot)
    {
        $boot->applicationWeb();
    }
}
