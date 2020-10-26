<?php

/**
 * @package yii2-extention
 * @license BSD-3-Clause
 * @copyright Copyright (C) 2012-2020 Sergio coderius <coderius>
 * @contacts sunrise4fun@gmail.com - Have suggestions, contact me :)
 * @link https://github.com/coderius - My github
 */

namespace coderius\swiperslider;

use Yii;
use yii\web\AssetBundle;
/**
 * Asset bundle SwiperSlider
 */
class SwiperSliderAsset extends AssetBundle
{
    public $sourcePath = '@npm/swiper';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setupAssets('css', ['swiper-bundle']);
        $this->setupAssets('js', ['swiper-bundle']);
        parent::init();
    }
    

    /**
     * Create cdn url like base path to assets
     *
     * @param string $cdn
     * @return void
     */
    public function fromCdn(string $cdn)
    {
        $this->sourcePath = false;
        $this->baseUrl = $cdn;
    }

    /**
     * Set js or css props to AssetBundle
     * @see yii\web\AssetBundle
     *
     * @param string $ext
     * @param array $paths
     * @return void
     */
    protected function setupAssets(string $ext, array $paths)
    {
        $allowedExts = ['css', 'js'];
        $fullFiles = [];
        $minFiles = [];

        if(!in_array($ext, $allowedExts)){
            throw new \InvalidArgumentException("Extention {$ext} not allowed");
        }

        foreach($paths as $path){
            $fullFiles[] = "{$path}.{$ext}";
            $minFiles[] = "{$path}.min.{$ext}";
        }

        $this->$ext = YII_DEBUG  ? $fullFiles : $minFiles;
    }

    /**
     * Registers this asset bundle with a view.
     * @param View $view the view to be registered with
     * @return static the registered asset bundle instance
     */
    public static function register($view, $cdn = false)
    {
        //code hire ...
        return parent::register($view);
    }

}

