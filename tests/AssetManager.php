<?php
/**
 * Created on Fri Oct 30 2020.
 *
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @copyright Copyright (c) 2010 - 2020 Sergey Coderius
 * @author Sergey Coderius <sunrise4fun@gmail.com>
 *
 * @see https://github.com/coderius - My github. See more my packages here...
 * @see https://coderius.biz.ua/ - My dev. blog
 *
 * Contact email: sunrise4fun@gmail.com - Have suggestions, contact me |:=)
 */

namespace tests;

/**
 * AssetManager.
 */
class AssetManager extends \yii\web\AssetManager
{
    private $_hashes = [];
    private $_counter = 0;

    /**
     * {@inheritdoc}
     */
    public function hash($path)
    {
        if (!isset($this->_hashes[$path])) {
            $this->_hashes[$path] = $this->_counter++;
        }

        return $this->_hashes[$path];
    }
}
