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

use Yii;
use yii\helpers\Json;

/**
 * Js helper class for php
 */
class JsHelper
{

    /**
     * initVar function
     *
     * @param string $name
     * @param object|string $value . Object type: \yii\web\JsExpression
     * @return string
     */
    public static function initVar(string $name, string $value)
    {
        return "var {$name} = {$value}";
    }

    /**
     * addString function
     *
     * @param string $value
     * @return string
     */
    public static function addString(string $value)
    {
        return "\"{$value}\"";
    }

    /**
     * newJsObject function
     *
     * @param string $instanceName
     * @param array $params
     * @return string \yii\web\JsExpression. See https://www.yiiframework.com/doc/api/2.0/yii-web-jsexpression for more information about it.
     */
    public static function newJsObject(string $instanceName, $params = [])
    {
        $params = implode(",", $params);
        return new \yii\web\JsExpression("new {$instanceName}({$params})");
    }


}