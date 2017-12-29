<?php

namespace dev7ch\slick;

use luya\cms\base\PhpBlock;

/**
 * Base block for slider extension.
 *
 * @author Silvan Hahn <silvan@dev7.ch>
 */
abstract class BaseSlickBlock extends PhpBlock
{
    /**
     * {@inheritdoc}
     */
    public function getViewPath()
    {
        return  dirname(__DIR__).'/src/views/blocks';
    }
}
