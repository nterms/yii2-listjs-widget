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
	 * @var boolean whether to show the search field
	 */
	public $search;
	
	/**
	 * @var array HTML attributes (name-value pairs) for the search input tag.
	 */
	public $searchOptions = [];
	
	/**
	 * @var array list of name-value pairs for rendering the sorting buttons list. 
	 * Value being the HTML attributes for the button. Special parameter `label` is used
	 * as the button text
	 * ```
	 * ...
	 * 'sort' => [
	 *     'name' => [
	 *         'class' => 'sort',
	 *         'label' => Yii::t('app', 'Sort by name'),
	 *     ],
	 * ],
	 * ...
	 * ```
	 */
	public $sort = [];
	
	/**
	 * @var string name of the view file to render the content. 
	 * If the widget is used in content capturing mode or a string is assigned to [[content]] property this will be ignored.
	 */
	public $layout = "{search}\n{sort}\n{content}";
	
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
		
		if(empty($this->clientOptions['valueNames'])) {
			throw new InvalidConfigException('The "valueNames" property of "clientOptions" should be set.');
		}
		
		ob_start();
	}
	
	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$content = ob_get_clean();
		$search = '';
		$sort = [];
	
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
		
		if($this->search) {
			$search = Html::tag('input', '', array_merge([
				'class' => 'form-control search', 
				'placeholder' => 'Search',
			], $this->searchOptions));
		}
		
		if(!empty($this->sort)) {
			foreach($this->sort as $key => $field) {
				if(is_string($field) && in_array($field, $this->clientOptions['valueNames'])) {
					$sort[] = Html::button($field, ['class' => 'btn btn-default sort', 'data-sort' => $field]);
				} elseif(is_array($field) && in_array($key, $this->clientOptions['valueNames'])) {
					$label = isset($field['label']) ? $field['label'] : $key;
					$sort[] = Html::button($label, array_merge([
						'class' => 'btn btn-default sort',
						'data-sort' => $key,
					], $field));
				}
			}
		}
		
		$html = str_replace(['{search}', '{sort}', '{content}'], [$search, implode(' ', $sort), $content], $this->layout);
		
		echo Html::tag('div', $html, $this->options);
	}
}