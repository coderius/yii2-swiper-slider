<?php
/**
 * SwiperSliderAssetTest.php
 * Created on Thu Oct 29 2020
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

namespace tests\functional;

use Yii;
use coderius\swiperslider\SwiperSliderAsset;
use coderius\swiperslider\SwiperSlider;
use yii\web\AssetBundle;

 class SwiperSliderAssetTest extends \tests\TestCase
 {
    
    public function testRegisterFromSorce()
    {
        $view = $this->getView();
        $this->assertEmpty($view->assetBundles);
        $dafaultAsset = SwiperSlider::ASSET_DEFAULT;
        $dafaultAsset::register($view);
        $this->assertEquals(1, count($view->assetBundles));
        $this->assertTrue($view->assetBundles['coderius\\swiperslider\\SwiperSliderAsset'] instanceof AssetBundle);
        $content = $view->renderFile('@tests/views/layouts/rawlayout.php');
        $this->assertContains('swiper-bundle.js', $content);
        $this->assertContains('swiper-bundle.css', $content);
    }

    public function testRegisterFromCdn()
    {
        $cdnBaseUrl = SwiperSlider::CDN_BASE_URL;
        $view = $this->getView();
        $this->assertEmpty($view->assetBundles);
        $dafaultAsset = SwiperSlider::ASSET_DEFAULT;
        $bundle = $dafaultAsset::register($view);
        $bundle->fromCdn($cdnBaseUrl);
        $this->assertEquals(1, count($view->assetBundles));
        $this->assertTrue($view->assetBundles['coderius\\swiperslider\\SwiperSliderAsset'] instanceof AssetBundle);
        $content = $view->renderFile('@tests/views/layouts/rawlayout.php');
        $this->assertContains($cdnBaseUrl . '/swiper-bundle.js', $content);
        $this->assertContains($cdnBaseUrl . '/swiper-bundle.css', $content);
    }

    public function testRegisterFromCdnByStaticFunctionRegister()
    {
        $cdnBaseUrl = SwiperSlider::CDN_BASE_URL;
        $view = $this->getView();
        $this->assertEmpty($view->assetBundles);
        $dafaultAsset = SwiperSlider::ASSET_DEFAULT;
        $dafaultAsset::register($view, $cdnBaseUrl);
        $this->assertEquals(1, count($view->assetBundles));
        $this->assertTrue($view->assetBundles['coderius\\swiperslider\\SwiperSliderAsset'] instanceof AssetBundle);
        $content = $view->renderFile('@tests/views/layouts/rawlayout.php');
        $this->assertContains($cdnBaseUrl . '/swiper-bundle.js', $content);
        $this->assertContains($cdnBaseUrl . '/swiper-bundle.css', $content);
    }

    public function testMakePathAssets()
    {
        // $this->expectException('\InvalidArgumentException');
        $view = $this->getView();
        $dafaultAsset = SwiperSlider::ASSET_DEFAULT;
        $path = $dafaultAsset::makePathAssets('css', ['swiper-bundle'], 'min');
        $this->assertEquals('swiper-bundle.min.css', $path[0]);
    }

    public function testSetupAssetsTrowExeption()
    {
        $this->expectException('\InvalidArgumentException');
        $notAllowedExt = 'php';
        $view = $this->getView();
        $dafaultAsset = SwiperSlider::ASSET_DEFAULT;
        $bundle = $dafaultAsset::register($view);
        $bundle->setupAssets($notAllowedExt, ['swiper-bundle']);
    }

 }