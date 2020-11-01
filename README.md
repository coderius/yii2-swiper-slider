# Yii2 swiper slider widget



## About
This is yii2 extention widget renders slider [Swiper](https://github.com/nolimits4web/swiper).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

First download extention. Run the command in the terminal:
```
composer require "coderius/yii2-swiper-slider"
```

or add in composer.json
```
"coderius/yii2-swiper-slider": "^1.0"
```
and run `composer update`

## Usage

### Widger with minimum options

You can only specify content for slides. This parameter is required.

In view file render widget:
```
            <?php
                echo SwiperSlider::widget([
                    'slides' => [
                        'one',
                        'two',
                        'three',
                        '<img src="https://swiperjs.com/demos/images/nature-1.jpg">',
                        '<img src="https://swiperjs.com/demos/images/nature-2.jpg">'
                    ],
                ]);
            ?>
```
### Widget with more options:

You can customize the parameters of the widget

In view file render widget:
```
            <?php
                echo SwiperSlider::widget([
                    // 'on ' . SwiperSlider::EVENT_AFTER_REGISTER_DEFAULT_ASSET => function(){
                    //     CustomAsset::register($view);
                    // },
                    'showScrollbar' => true,
                    'slides' => [
                        [
                            'value' => 'ggg',
                            'options' => [
                                'style' => ["background-image" => "url(https://swiperjs.com/demos/images/nature-1.jpg)"]
                            ]
                        ],
                        '<img src="https://swiperjs.com/demos/images/nature-2.jpg">',
                        'one',
                        'two',
                        'three',
                        'fore',
                        'five'
                    ],
                    // 'assetFromCdn' => true,
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
            ?>
```

### Widget options

__Events__:
* EVENT_BEFORE_REGISTER_DEFAULT_ASSET
* EVENT_AFTER_REGISTER_DEFAULT_ASSET

Usage in widget:
```
echo SwiperSlider::widget([
    ...
'on ' . SwiperSlider::EVENT_AFTER_REGISTER_DEFAULT_ASSET => function(){
        CustomAsset::register($view);
},
```
__showScrollbar__: true | false. Default is false

__showPagination__: true | false. Default is true

__slides__: string | array | . Contents slides content like <img> or any string. Or array with keys: *value*, *options*. *value* maybe like 
string or Closure (function($tag, $index, $self){}). Example:
```
'slides' => [
        [
            'value' => 'ggg',
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
...
```
__clientOptions__: array. This options is pasted when initialize Swiper js (new Swiper('options here')).
Please, remember that if you are required to add javascript to the configuration of the js plugin and is required to be 
plain JS, make use of `JsExpression`. That class was made by Yii for that specific purpose. For example:
```
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
```
__options__: array. This options is pasted when rendered dom elements. Various attributes for html elements are set here.
This params allowed only for all template items:
```
//Global styles to elements. If create styles for all slides
'options' => [
    'styles' => [
        SwiperSlider::CONTAINER => ["height" => "100px"],
        SwiperSlider::SLIDE => ["text-align" => "center"],
    ],
    'class' => [SwiperSlider::CONTAINER => ["myClass"],]
],

```

It is best to use constants to specify template elements:
* CONTAINER = 'container';
* WRAPPER = 'wrapper';
* SLIDE = 'slide';
* PAGINATION = 'pagination';
* BUTTON_PREV = 'button-prev';
* BUTTON_NEXT = 'button-next';
* SCROLLBAR = 'scrollbar';

## Testing

Run tests in extention folder.

```bash
$ ./vendor/bin/phpunit
```

Note! 
For running all tests needed upload all dependencies by composer. If tested single extention, then run command from root directory where located extention:
```
composer update
```

When all dependencies downloaded run all tests in terminal from root folder:
```
./vendor/bin/phpunit tests
```
Or for only unit:
```
./vendor/bin/phpunit --testsuite Unit
```

If extention tested in app, then set correct path to phpunit and run some commands.

## Credits

- [Sergio Coderius](https://github.com/coderius)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.