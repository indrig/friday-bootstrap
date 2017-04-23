<?php
namespace Friday\Bootstrap\Widget;

use Friday\Web\Widget as BaseWidget;

/**
 * Class Widget is the base class for all bootstrap widgets.
 * @package Friday\Bootstrap
 */
class Widget extends BaseWidget
{
    use BootstrapWidgetTrait;

    /**
     * @var array the HTML attributes for the widget container tag.
     * @see \Friday\Helper\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];
}
