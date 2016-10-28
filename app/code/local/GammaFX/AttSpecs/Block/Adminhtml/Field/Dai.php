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
 * AttSpecs Select for Display as Icon column
 *
 * @category 	GammaFX
 * @package 	GammaFX_AttSpecs
 * @author  	GammaFX Bohdan
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