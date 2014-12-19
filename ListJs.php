<?php
/**
* @copyright Copyright &copy; Saranga Abeykoon, nterms.com, 2014
* @package yii2-mediaelement-widget
* @version 1.0.0
*/

namespace nterms\listjs;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\base\Widget;

class ListJs extends Widget
{
	/**
	 * @var array the HTML attributes (name-value pairs) for the container tag.
	 * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
	 */
	public $options = [];
	
	/**
	 * @var array list.js options. Read [this](http://www.listjs.com/docs/options) for list of options.
	 */
	public $clientOptions = [];
	
	/**
	 * @var string HTML content, preferably a list or table. 
	 * If the widget is used in content capturing mode this will be ignored.
	 */
	public $content = '';
	
	/**
	 * @var string name of the view file to render the content. 
	 * If the widget is used in content capturing mode or a string is assigned to [[content]] property this will be ignored.
	 */
	public $view;
	
	/**
	 * @var array parameters to be passed to [[view]] when it is being rendered.
	 * This property is used only when [[view]] is rendered to generate the content of the widget.
	 */
	public $viewParams = [];
	
	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();
		
		if(!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
		
		if(!isset($this->clientOptions['id'])) {
            $this->clientOptions['id'] = $this->options['id'];
        }
		
		ob_start();
	}
	
	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$content = ob_get_clean();
	
		$view = $this->getView();
		
		ListJsAsset::register($view);
		
		$js = "var yii2lj" . ucfirst(strtolower(str_replace('-', '', $this->clientOptions['id']))) . " = new List('" . $this->clientOptions['id'] . "', " . json_encode($this->clientOptions) . ");";
		
		$view->registerJs($js, $view::POS_READY);
		
		if(empty($content)) {
			if(empty($this->content)) {
				$content = $this->content;
			} elseif($this->view != null && is_string($this->view)) {
				$content = $view->render($this->view, $this->viewParams);
			}
		}
		
		echo Html::tag('div', $content, $this->options);
	}
}