<?php
/**
 * Created by PhpStorm.
 * User: bodyanuk
 * Date: 10/18/16
 * Time: 22:29
 */

/**
 * Select with attributes
 * Class GammaFX_AttSpecs_Block_Adminhtml_Field_Attribute
 */
class GammaFX_AttSpecs_Block_Adminhtml_Field_Attribute extends Mage_Core_Block_Html_Select
{
	/**
	 * @return mixed
	 */
	public function _toHtml()
	{
		$options = Mage::getModel('attspecs/system_config_source_attributes')->toOptionArray();
		//$options = Mage::getSingleton('adminhtml/system_config_source_country')->toOptionArray();

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