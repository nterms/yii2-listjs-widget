<?php
/**
* @copyright Copyright &copy; Saranga Abeykoon, nterms.com, 2014
* @package yii2-listjs-widget
* @version 1.0.0
*/
namespace nterms\listjs;


use yii\web\AssetBundle;

/**
 * @author Saranga Abeykoon <amisaranga@gmail.com>
 */
class ListJsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/nterms/yii2-listjs-widget/assets/';
    public $js = [
        'list.min.js',
		//'//cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js',
    ];
	public $css = [];
    public $depends = [];
}
