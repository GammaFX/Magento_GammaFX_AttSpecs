<?php

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
				'value' => $attribute->getAttributeId(),
				'label' => $attribute->getFrontendLabel().' - '.$attribute->getAttributeCode(),
			);
		}
		
		if ($includeEmpty) {
			array_unshift($options, array('value' => '', 'label' => Mage::helper('adminhtml')->__('-- Please Select --')));
			
		}

		return (array) $options;
	}
	
}
