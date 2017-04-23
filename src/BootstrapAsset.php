<?php
namespace Fridat\Bootstrap;
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

        $this->js[] = FRIDAY_DEBUG ? 'css/bootstrap.css' : 'css/bootstrap.min.css';
    }

}