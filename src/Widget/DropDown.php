<?php
namespace Friday\Bootstrap\Widget;

use ArrayAccess;
use Friday;
use Friday\Base\Exception\InvalidConfigException;
use Friday\Bootstrap\Asset\BootstrapPluginAsset;
use Friday\Helper\ArrayHelper;
use Friday\Helper\Html;

/**
 * Dropdown renders a Bootstrap dropdown menu component.
 *
 * For example,
 *
 * ```php
 * <div class="dropdown">
 *     <a href="#" data-toggle="dropdown" class="dropdown-toggle">Label <b class="caret"></b></a>
 *     <?php
 *         echo Dropdown::widget([
 *             'items' => [
 *                 ['label' => 'HeaderA'],
 *                 ['label' => 'DropdownA', 'url' => '/'],
 *                 ['label' => 'DropdownB', 'url' => '#'],
 *                 null,
 *                 ['label' => 'DropdownC', 'url' => ['/index/help']],
 *                 ['label' => 'DropdownD', 'url' => '#'],
 *             ],
 *         ]);
 *     ?>
 * </div>
 * ```
 */
class DropDown extends AbstractWidget
{
    /**
     * @var array list of menu items in the dropdown. Each array element can be either an HTML string,
     * or an array representing a single menu with the following structure:
     *
     * - label: string, required, the label of the item link
     * - url: string|array, optional, the url of the item link. This will be processed by [[Url::to()]].
     *   If not set, the item will be treated as a menu header when the item has no sub-menu.
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item link.
     * - options: array, optional, the HTML attributes of the item.
     * - items: array, optional, the submenu items. The structure is the same as this property.
     *   Note that Bootstrap doesn't support dropdown submenu. You have to add your own CSS styles to support it.
     * - submenuOptions: array, optional, the HTML attributes for sub-menu container tag. If specified it will be
     *   merged with [[submenuOptions]].
     *
     * To insert divider use `<li role="presentation" class="divider"></li>`.
     */
    public $items = [];
    /**
     * @var boolean whether the labels for header items should be HTML-encoded.
     */
    public $encodeLabels = true;
    /**
     * @var array|null the HTML attributes for sub-menu container tags.
     * If not set - [[options]] value will be used for it.
     */
    public $submenuOptions;


    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        if ($this->submenuOptions === null) {
            // copying of [[options]] kept for BC
            // @todo separate [[submenuOptions]] from [[options]] completely before 2.1 release
            $this->submenuOptions = $this->options;
            unset($this->submenuOptions['id']);
        }
        parent::init();
        Html::addCssClass($this->options, ['widget' => 'dropdown-menu']);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        BootstrapPluginAsset::register($this->getView());
        $this->registerClientEvents();
        return $this->renderItems($this->items, $this->options);
    }

    /**
     * Renders menu items.
     * @param array $items the menu items to be rendered
     * @param array $options the container HTML attributes
     * @return string the rendering result.
     * @throws InvalidConfigException if the label option is not specified in one of the items.
     */
    protected function renderItems($items, $options = [])
    {
        $lines = [];
        foreach ($items as $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            if (is_string($item)) {
                $lines[] = $item;
                continue;
            } elseif (is_null($item)){
                $lines[] = Html::tag('div', '', ['class' => 'dropdown-divider']);
                continue;
            } elseif (is_object($item)){
                if($item instanceof ArrayAccess){

                } elseif(method_exists($item,'toArray')){
                    $item = $item->toArray();
                } else {
                    Friday::warning('Menu item is object "' . get_class($item) . '", but not array compatibility. Need has to array method or ArrayAccess instance.');
                    continue;
                }
            } elseif(!is_array($item)) {
                Friday::warning('Incorrect menu item type: ' . gettype($item));
                continue;
            }


            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $encodeLabel    = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $label          = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $itemOptions    = ArrayHelper::getValue($item, 'options', []);


            $url = array_key_exists('url', $item) ? $item['url'] : null;
            if (empty($item['items'])) {
                if ($url === null) {
                    Html::addCssClass($itemOptions, ['widget' => 'dropdown-header']);
                    $lines[] = Html::tag('h6', $label, $itemOptions);
                } else {
                    Html::addCssClass($itemOptions, 'dropdown-item');
                    $lines[] =  Html::a($label, $url, $itemOptions);
                }
            } else {
                /*$submenuOptions = $this->submenuOptions;
                if (isset($item['submenuOptions'])) {
                    $submenuOptions = array_merge($submenuOptions, $item['submenuOptions']);
                }
                $content = Html::a($label, $url === null ? '#' : $url, $itemOptions)
                    . $this->renderItems($item['items'], $submenuOptions);
                Html::addCssClass($itemOptions, ['widget' => 'dropdown-submenu']);*/
            }

        }

        return Html::tag('div', implode("\n", $lines), $options);
    }
}
