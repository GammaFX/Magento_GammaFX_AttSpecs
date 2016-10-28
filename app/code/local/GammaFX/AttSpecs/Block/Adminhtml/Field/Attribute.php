<?php
/**
 * GammaFX
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GammaFX.com license that is
 * available through the world-wide-web at this URL:
 * http://www.gammafx.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category 	GammaFX
 * @package 	GammaFX_AttSpecs
 * @copyright 	Copyright (c) 2012 GammaFX (http://www.gammafx.com/)
 * @license 	http://www.gammafx.com/license-agreement.html
 */

/**
 * AttSpecs Select with attributes
 *
 * @category 	GammaFX
 * @package 	GammaFX_AttSpecs
 * @author  	GammaFX Bohdan
 */
class GammaFX_AttSpecs_Block_Adminhtml_Field_Attribute extends Mage_Core_Block_Html_Select
{
	/**
	 * @return mixed
	 */
	public function _toHtml()
	{
		$options = Mage::getModel('attspecs/system_config_source_attributes')->toOptionArray(false);

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