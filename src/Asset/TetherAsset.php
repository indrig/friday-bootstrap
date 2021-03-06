<?php
namespace Friday\Bootstrap\Asset;

use Friday\Web\AssetBundle;
/**
 * Asset bundle for the Twitter bootstrap css files.
 */
class TetherAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/indrig/friday-bootstrap/asset/tether';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->js[] = FRIDAY_DEBUG ? 'js/tether.js' : 'js/tether.min.js';
        $this->css[] = FRIDAY_DEBUG ? 'css/tether.css' : 'css/tether.min.css';
    }

}