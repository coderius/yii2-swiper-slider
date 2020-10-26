<?php

/**
 * @package yii2-extentions
 * @license BSD-3-Clause
 * @copyright Copyright (C) 2012-2020 Sergio coderius <coderius>
 * @contacts sunrise4fun@gmail.com - Have suggestions, contact me :) 
 * @link https://github.com/coderius - My github
 */
namespace coderius\swiperslider;

use yii\base\Widget;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use Closure;

class SwiperSlider extends Widget
{
    /**
     * If is allowed cdn base url to assets
     *
     * @var boolean
     */
    public $cdn = false;

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
        //code
    }    
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerAssets();
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


}