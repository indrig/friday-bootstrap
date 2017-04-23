<?php
namespace Friday\Bootstrap\Asset;

use Friday\Web\AssetBundle;
/**
 * Asset bundle for the Twitter bootstrap css files.
 */
class BootstrapAsset extends AssetBundle
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

        $this->css[] = FRIDAY_DEBUG ? 'css/bootstrap.css' : 'css/bootstrap.min.css';
    }

}