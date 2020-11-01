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

namespace tests;

use Yii;
use yii\base\Action;
use yii\base\Module;
use yii\di\Container;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * This is the base class for all yii framework unit tests.
 */
abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->mockWebApplication();
    }
    /**
     * Clean up after test.
     * By default the application created with [[mockApplication]] will be destroyed.
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->destroyApplication();
    }
    /**
     * @param array $config
     * @param string $appClass
     */
    protected function mockWebApplication($config = [], $appClass = '\yii\web\Application')
    {
        new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => dirname(__DIR__) . '/vendor',
            'aliases' => [
                '@bower' => '@vendor/bower-asset',
                    '@npm' => '@vendor/npm-asset',
            ],
            'components' => [
                'request' => [
                    'cookieValidationKey' => 'wefJDF8sfdsfSDefwqdxj9oq',
                    'hostInfo' => 'http://domain.com',
                    'scriptUrl' => 'index.php',
                ],
                'assetManager' => [
                    'class' => 'tests\AssetManager',
                    'basePath' => '@tests/assets',
                    'baseUrl' => '/',
                ]
            ],
            
        ], $config));
    }
    /**
     * Mocks controller action with parameters
     *
     * @param string $controllerId
     * @param string $actionID
     * @param string $moduleID
     * @param array $params
     */
    protected function mockAction($controllerId, $actionID, $moduleID = null, $params = [])
    {
        Yii::$app->controller = $controller = new Controller($controllerId, Yii::$app);
        $controller->actionParams = $params;
        $controller->action = new Action($actionID, $controller);
        if ($moduleID !== null) {
            $controller->module = new Module($moduleID);
        }
    }
    /**
     * Removes controller
     */
    protected function removeMockedAction()
    {
        Yii::$app->controller = null;
    }
    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyApplication()
    {
        Yii::$app = null;
        Yii::$container = new Container();
    }
    /**
     * Asserting two strings equality ignoring line endings
     *
     * @param string $expected
     * @param string $actual
     */
    public function assertEqualsWithoutLE($expected, $actual)
    {
        $expected = str_replace("\r\n", "\n", $expected);
        $actual = str_replace("\r\n", "\n", $actual);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Creates a view for testing purposes
     *
     * @return View
     */
    protected function getView()
    {
        $view = new View();
        $view->setAssetManager(
            new AssetManager(
                [
                    'basePath' => '@tests/assets',
                    'baseUrl' => '/',
                ]
            )
        );
        return $view;
    }

    /**
     * @return string vendor path
     */
    protected function getVendorPath()
    {
        return dirname(__DIR__) . '/vendor';
    }

    
}