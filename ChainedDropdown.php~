<?php
/**
 * DependentSelect class file.
 *
 * @author Maarten van Vliet
 * @license BSD
 */

/**
 * DependentSelect creates a dropdown dependent on the value of another dropdown using jQuery
 *
 */
class ChainedDropdown extends CInputWidget
{

	/**
	 * @var string the URL that returns the options of the dropdown, enter array to have normalizeUrl 
	 * have a go at it
	 * A 'value' GET parameter will be sent with the URL which contains the value of the master dropdown
	 * The url should return a Json object with 'value/name' pairs 
	 * @see data
 	 */
	public $url='';

	/**
	 * @var string the jQuery selector statement of the master dropdown
	 */
	public $onChangeSelector;

	/**
	 * @var the data that should be in the dropdown by default
	 */	
	public $defaultData=array();

	/**
	 * @var ajax load the data on the loading of the page (overrides defaultData)
	 */		
	public $loadDependentOnInit=true;
	
	/**
	 * Position of the javascript in the file
	 * see http://www.yiiframework.com/doc/api/CClientScript#registerScript
	 */
	public $scriptPosition=CClientScript::POS_READY;
	
	/**
	 * Initializes the widget.
	 * This method registers all needed client scripts and renders
	 * the dropdown input.
	 */
	public function init()
	{
		list($name,$id)=$this->resolveNameID();
		$this->htmlOptions['id']=$id;

		$cs=Yii::app()->getClientScript();

		$url=CJavaScript::encode(CHtml::normalizeUrl($this->url));

		$script="function generateSelect(value){ var o = ''; for(key in value)	{ o += '<option value=\"' + key + '\">' + value[key] + '</option>';} if(o!=''){ jQuery(o).prependTo(\"#{$id}\"); }} 	
function getData(value)	{ jQuery(\"#{$id}\").empty(); jQuery.getJSON(".$url.", { value: value }, generateSelect);}
		jQuery(\"#".$this->onChangeSelector."\").change(function () { getData(this.value); });";
		
		if($this->loadDependentOnInit)
			$script.="var n=jQuery(\"#".$this->onChangeSelector."\").attr('value'); getData(n);";

		$cs->registerScript('jQChainedSelect#'.$id,$script,$this->scriptPosition);

		if($this->hasModel())
			echo CHtml::activeDropDownList($this->model,$this->attribute,$this->defaultData,$this->htmlOptions);
		else
			echo CHtml::dropDownList($name,'',$this->defaultData,$this->htmlOptions);
		
	}

}
