<?php
/**
 * Created on Tue Oct 27 2020
 * 
 * @package yii2-extentions
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @copyright Copyright (c) 2010 - 2020 Sergey Coderius
 *
 * @author Sergey Coderius <sunrise4fun@gmail.com>
 * @link https://github.com/coderius - My github. See more my packages here...
 * @link https://coderius.biz.ua/ - My dev. blog
 * 
 * Contact email: sunrise4fun@gmail.com - Have suggestions, contact me |:=)
 */

namespace coderius\swiperslider;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use Closure;
use coderius\swiperslider\JsHelper;

class SwiperSlider extends Widget
{
    const WIDGET_NAME = "swiper";
    const JS_PLUGIN_NAME = "Swiper";

    const CONTAINER = 'container';
    const WRAPPER = 'wrapper';
    const SLIDE = 'slide';
    const PAGINATION = 'pagination';
    const BUTTON_PREV = 'button-prev';
    const BUTTON_NEXT = 'button-next';
    const SCROLLBAR = 'scrollbar';

    /**
     * Generate css class name for item
     *
     * @param string $itemName
     * @return string
     */
    protected function getItemCssClass(string $itemName)
    {
        return self::WIDGET_NAME . "-" . $itemName;
    }
  
    /**
     * Options in js plugin instance
     *
     * @var array
     */
    public $clientOptions = [];

    /**
     * And if we need scrollbar
     *
     * @var boolean
     */
    public $showScrollbar = false;

    /**
     * If we need pagination
     *
     * @var boolean
     */
    public $showPagination = true;

    /**
     * If is allowed cdn base url to assets
     *
     * @var boolean
     */
    public $cdn = false;

    /**
     * Sliders
     *
     * @var array
     */
    public $slides = [];

    /**
     * Inline styles
     *
     * @var array
     */
    public $inlineStyles = [];

    /**
     * Uniq widget name
     *
     * @var string
     */
    protected $widgetId;

    /**
     * Cdn base url
     *
     * @var string
     */
    protected $cdnBaseUrl = "https://unpkg.com/swiper";
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->widgetId = $this->getId() . '-' . static::WIDGET_NAME;
        

        if ($this->slides === null || empty($this->slides)) {
            throw new InvalidConfigException("The 'slides' option is required");
        }
    }    
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerAssets();
        $this->registerPluginJs();
        echo $this->makeHtml();
    }
    
    /**
     * Processed registration all needed assets to widget
     *
     * @return void
     */
    protected function registerAssets(){
        $view = $this->getView();
        $bundle = SwiperSliderAsset::register($view);
        false === $this->cdn ? : $bundle->fromCdn($this->cdnBaseUrl);
        // $view->registerJs($plugin);
    }

    /**
     * Create html elements for widget
     *
     * @return void
     */
    protected function makeHtml(){

        //Slides
        $slides = [];
        foreach($this->slides as $slide){
            $slides[] = $this->getHtmlElem(static::SLIDE, [], $slide);
        }
        $slides = "\n\t\t" . implode("\n\t\t", $slides) . "\n\t";

        //Slides wrapper
        $wrapper = $this->getHtmlElem(static::WRAPPER, [], $slides);

        //Pagination
        $pagination = $this->getHtmlElem(static::PAGINATION);

        //Navigation buttons
        $buttonPrev = $this->getHtmlElem(static::BUTTON_PREV);
        $buttonNext = $this->getHtmlElem(static::BUTTON_NEXT);

        //Scrollbar
        $scrollbar = $this->getHtmlElem(static::SCROLLBAR);

        //Collect all content
        $content = [];
        $content[] = $wrapper;

        // And if we need pagination
        if($this->showPagination){
            $content[] = $pagination;
        }

        $content[] = $buttonPrev;
        $content[] = $buttonNext;

        // And if we need scrollbar
        if($this->showScrollbar){
            $content[] = $scrollbar;
        }
        
        $content = "\n\t" . implode("\n\t", $content) . "\n";

        //Common container
        $container = "\n";
        $container .= "<!-- ***Swiper slider widget id: {$this->widgetId}*** -->";
        $container .= "\n";
        $container .= $this->getHtmlElem(static::CONTAINER, ['id' => $this->widgetId], $content);
        $container .= "\n<!-- ///Swiper slider widget id: {$this->widgetId}/// -->";
        return  $container;
    }

    /**
     * getHtmlElem function help create html element and add custom inline css styles
     *
     * @param string $itemName
     * @param array $options
     * @param string $content
     * @param string $tag
     * @return string
     */
    protected function getHtmlElem(string $itemName, $options = [], $content = '', $tag = 'div')
    {
        $options = ArrayHelper::merge(['class' => $this->getItemCssClass($itemName)], $options);
        $style = !empty($this->inlineStyles[$itemName]) ? $this->inlineStyles[$itemName] : null;
        Html::addCssStyle($options, $style);
        return Html::tag($tag, $content, $options);
    }

    /**
     * registerPluginJs function
     *
     * @return void
     */
    protected function registerPluginJs(){
        $view = $this->getView();
        $pluginParams = [];
        $pluginParams[] = JsHelper::addString("#" . $this->widgetId);
        $defaultOptions = [
            "loop" => true,
            "pagination" => ["el" => "." . $this->getItemCssClass(static::PAGINATION)],
            "navigation" => [
                    "nextEl" => "." . $this->getItemCssClass(static::BUTTON_NEXT),
                    "prevEl" => "." . $this->getItemCssClass(static::BUTTON_PREV),
            ],
        ];
        $clientOptions = ArrayHelper::merge($defaultOptions, $this->clientOptions);
        $pluginParams[] = JsHelper::literalObject($clientOptions);
        $pluginInstance = JsHelper::newJsObject(static::JS_PLUGIN_NAME, $pluginParams);
        $jsVar = JsHelper::initVar("mySwiper", $pluginInstance);

        $view->registerJs($jsVar, \yii\web\View::POS_END);
    }

    

    

}