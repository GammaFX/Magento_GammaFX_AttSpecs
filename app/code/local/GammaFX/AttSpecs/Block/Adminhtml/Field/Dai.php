<?php
/**
 * Created by PhpStorm.
 * User: bodyanuk
 * Date: 10/18/16
 * Time: 23:08
 */

/**
 * Select for Display as Icon column
 * Class GammaFX_AttSpecs_Block_Adminhtml_Field_Dai
 */
class GammaFX_AttSpecs_Block_Adminhtml_Field_Dai extends Mage_Core_Block_Html_Select
{
	/**
	 * @return mixed
	 */
	public function _toHtml()
	{
		$this->setClass('dai-selector');

		$options = array(
			array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Yes')),
			array('value' => 0, 'label'=>Mage::helper('adminhtml')->__('No')),
		);

		foreach ($options as $option) {
			$this->addOption($option['value'], $option['label']);
		}

		return parent::_toHtml();
	}

	/**
	 * @param $value
	 *
	 * @return mixed
	 */
	public function setInputName($value)
	{
		return $this->setName($value);
	}
}