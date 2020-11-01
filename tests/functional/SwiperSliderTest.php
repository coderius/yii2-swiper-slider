<?php
/**
 * Created on Sun Nov 01 2020
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

class SwiperSliderTest extends \tests\TestCase
{

    protected function setUp()
    {
        parent::setUp();
        SwiperSlider::$counter = 0;
    }    

    public function testRenderMinimumOptions()
    {
        $out = SwiperSlider::widget([
            'slides' => [
                'one',
                'two',
                'three',
                'fore',
                'five'
            ],
        ]);

        $expected = file_get_contents(__DIR__ . '/../data/swiper-widget.bin');
        $this->assertEqualsWithoutLE($expected, $out);
    }

    public function testRenderWithOutSlidesTrowExeption()
    {
        $this->expectException('\yii\base\InvalidConfigException');
        SwiperSlider::widget([]);

    }

    public function testRenderWithOptions()
    {
        $out = SwiperSlider::widget([
            'showScrollbar' => true,
            'slides' => [
                [
                    'value' => 'some value',
                    'options' => [
                        'style' => ["background-image" => "url(https://swiperjs.com/demos/images/nature-1.jpg)"]
                    ]
                ],
                [
                    'value' => function($tag, $index, $self){ 
                        return "some value {$index}";
                    },
                    'options' => [
                        'style' => ["color" => "green"]
                    ]
                ],
                'one',
                'two',
                'three',
                'fore',
                'five'
            ],
            'clientOptions' => [
                'slidesPerView' => 4,
                'spaceBetween'=> 30,
                'centeredSlides'=> true,
                'pagination' => [
                    'clickable' => true,
                    'renderBullet' => new \yii\web\JsExpression("function (index, className) {
                            return '<span class=\"' + className + '\">' + (index + 1) + '</span>';
                        },
                    "),
                    ],
                    "scrollbar" => [
                        "el" => SwiperSlider::getItemCssClass(SwiperSlider::SCROLLBAR),
                        "hide" => true,
                    ],
            ],

            //Global styles to elements. If create styles for all slides
            'options' => [
                'styles' => [
                    SwiperSlider::CONTAINER => ["height" => "100px"],
                    SwiperSlider::SLIDE => ["text-align" => "center"],
                ],
            ],
        ]);

        $expected = file_get_contents(__DIR__ . '/../data/swiper-widget-options.bin');
        $this->assertEqualsWithoutLE($expected, $out);
    }

    // public function testRenderWithOptions()
    // {
    //     $out = SwiperSlider::widget([
    //         'showScrollbar' => true,
    //         'slides' => [
    //             [
    //                 'value' => 'ggg',
    //                 'options' => [
    //                     'style' => ["background-image" => "url(https://swiperjs.com/demos/images/nature-1.jpg)"]
    //                 ]
    //             ],
    //             'one',
    //             'two',
    //             'three',
    //             'fore',
    //             'five'
    //         ],
    //         // 'assetFromCdn' => true,
    //         'clientOptions' => [
    //             'slidesPerView' => 4,
    //             'spaceBetween'=> 30,
    //             'centeredSlides'=> true,
    //             'pagination' => [
    //                 'clickable' => true,
    //                 'renderBullet' => new \yii\web\JsExpression("function (index, className) {
    //                         return '<span class=\"' + className + '\">' + (index + 1) + '</span>';
    //                     },
    //                 "),
    //                 ],
    //                 "scrollbar" => [
    //                     "el" => SwiperSlider::getItemCssClass(SwiperSlider::SCROLLBAR),
    //                     "hide" => true,
    //                 ],
    //         ],

    //         //Global styles to elements. If create styles for all slides
    //         'options' => [
    //             'styles' => [
    //                 SwiperSlider::CONTAINER => ["height" => "100px"],
    //                 SwiperSlider::SLIDE => ["text-align" => "center"],
    //             ],
    //         ],
    //     ]);

    //     $expected = '<textarea id="test" name="test-editor-name">test-editor-value</textarea>';
    //     $this->assertEqualsWithoutLE($expected, $out);
    // }

 
 }