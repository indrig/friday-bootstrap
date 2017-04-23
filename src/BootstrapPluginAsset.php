<?php
namespace Friday\Bootstrap;

use Friday\Web\AssetBundle;
/**
 * Asset bundle for the Twitter bootstrap javascript files.
 */
class BootstrapPluginAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@composer/bootstrap/dist';

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
        'Friday\Web\JqueryAsset',
        'Friday\Bootstrap\BootstrapAsset',
    ];
}