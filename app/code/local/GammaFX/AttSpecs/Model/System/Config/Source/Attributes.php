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
 * AttSpecs gather all attributes
 *
 * @category 	GammaFX
 * @package 	GammaFX_AttSpecs
 * @author  	GammaFX Bohdan
 */
class GammaFX_AttSpecs_Model_System_Config_Source_Attributes
{

	/**
	 * Retrieve an option array of results
	 *
	 * @return array
	 */
	public function toOptionArray($includeEmpty = true)
	{
		$options = array();
		$attributes = Mage::getSingleton('eav/config')
			->getEntityType(Mage_Catalog_Model_Product::ENTITY)
			->getAttributeCollection()
			->addFieldToFilter('is_user_defined', 1)
			->addSetInfo();

		foreach($attributes as $attribute) {
			$options[] = array(
				'value' => $attribute->getAttributeCode(),
				'label' => $attribute->getFrontendLabel().' - '.$attribute->getAttributeCode(),
			);
		}
		
		if ($includeEmpty) {
			array_unshift($options, array('value' => '', 'label' => Mage::helper('adminhtml')->__('-- Please Select --')));
			
		}

		return (array) $options;
	}
	
}
