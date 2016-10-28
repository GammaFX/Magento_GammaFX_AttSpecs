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
 * AttSpecs Block extend default getAdditionalAttributes
 *
 * @category 	GammaFX
 * @package 	GammaFX_AttSpecs
 * @author  	GammaFX Bohdan
 */
class GammaFX_AttSpecs_Block_Catalog_Attributes extends Mage_Catalog_Block_Product_View_Attributes {

	/**
	 * Specification data
	 * @var array
	 */
	protected $specs = array();

	/**
	 * @var GammaFX_AttSpecs_Helper_Featured
	 */
	protected $specHelper = null;

	/**
	 * GammaFX_AttSpecs_Block_Catalog_Attributes constructor.
	 */
	public function __construct()
	{
		$this->specHelper = Mage::helper('attspecs/featured');

		parent::__construct();
	}

	/**
	 * Append JS / CSS
	 * @return mixed
	 */
	protected function _prepareLayout()
	{
		if ($this->specHelper->isHint()) {
			$this->getLayout()->getBlock('head')->addCss('css/' . GammaFX_AttSpecs_Helper_Featured::SECTION_NAME . '/tooltip.css');
		}
		return parent::_prepareLayout();
	}

	/**
	 * $excludeAttr is optional array of attribute codes to
	 * exclude them from additional data array
	 *
	 * @param array $excludeAttr
	 * @return array
	 */
	public function getAdditionalData(array $excludeAttr = array())
	{
		$data = array();
		$product = $this->getProduct();
		$attributes = $product->getAttributes();
		foreach ($attributes as $attribute) {
//            if ($attribute->getIsVisibleOnFront() && $attribute->getIsUserDefined() && !in_array($attribute->getAttributeCode(), $excludeAttr)) {
			if ($attribute->getIsVisibleOnFront() && !in_array($attribute->getAttributeCode(), $excludeAttr)) {
				$value = $attribute->getFrontend()->getValue($product);

				if (!$product->hasData($attribute->getAttributeCode())) {
					$value = Mage::helper('catalog')->__('N/A');
				} elseif ((string)$value == '') {
					$value = Mage::helper('catalog')->__('No');
				} elseif ($attribute->getFrontendInput() == 'price' && is_string($value)) {
					$value = Mage::app()->getStore()->convertPrice($value, true);
				}

				if (is_string($value) && strlen($value)) {
					$data[$attribute->getAttributeCode()] = array(
						'label' => $attribute->getStoreLabel(),
						'value' => $value,
						'code'  => $attribute->getAttributeCode(),
					);

					/**
					 * AttSpecs extend default additional attribute information
					 */
					$data[$attribute->getAttributeCode()][GammaFX_AttSpecs_Helper_Featured::SECTION_NAME] = $this->addSpecs($attribute->getAttributeCode());
				}
			}
		}

		return $data;
	}

	/**
	 * @param string $code - attribute_code
	 * @param string $field - configured field name
	 *
	 * @return null|string|int
	 */
	private function getSpecsField($code, $field)
	{
		if (!$this->specs) {
			$this->specs = $this->specHelper->getSpecs();
		}

		if (!isset($this->specs[$code][$field])) {
			return null;
		}

		return  $this->specs[$code][$field];
	}

	/**
	 * Return array of needle fields
	 * @param string $code - attribute_code
	 *
	 * @return null|array
	 */
	protected function addSpecs($code)
	{
		$currentSpec = null;
		if (GammaFX_AttSpecs_Helper_Featured::$additionalFields) {
			foreach (GammaFX_AttSpecs_Helper_Featured::$additionalFields as $key) {
				if ($value = $this->getSpecsField($code, $key)) {
					$currentSpec[$key] = $value;
				}
			}
		}

		return $currentSpec;
	}
}