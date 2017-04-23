<?php
namespace Friday\Bootstrap\Asset;

use Friday\Web\AssetBundle;
/**
 * Asset bundle for the Twitter bootstrap javascript files.
 */
class BootstrapPluginAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/twbs/bootstrap/dist';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->js[] = FRIDAY_DEBUG ? 'js/bootstrap.js' : 'js/bootstrap.min.js';
    }

    /**
     * @inheritdoc
     */
    public $depends = [
        'Friday\Asset\JqueryAsset',
        'Friday\Bootstrap\Asset\BootstrapAsset',
        'Friday\Bootstrap\Asset\TetherAsset',
    ];
}