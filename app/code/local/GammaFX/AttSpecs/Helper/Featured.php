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
 * AttSpecs main Handler
 *
 * @category 	GammaFX
 * @package 	GammaFX_AttSpecs
 * @author  	GammaFX Bohdan
 */
class GammaFX_AttSpecs_Helper_Featured extends Mage_Core_Helper_Abstract {

	/**
	 * The name of section in system.xml
	 */
	const SECTION_NAME = 'attspecs';

	/**
	 * Fields will add to $_product->getAdditionalData()
	 * @var array
	 */
	public static $additionalFields = array(
		'description',
	    'class',
	    'dai',
	    'icon'
	);

	/**
	 * All config data in SECTION_NAME
	 * @var array
	 */
	protected $config = null;

	/**
	 * All config from specification table
	 * @var array
	 */
	protected $specs = null;

	/**
	 * @var int
	 */
	protected $storeId = null;

	/**
	 * Unserialized specs data
	 * @var array
	 */
	protected $attributesData = null;

	/**
	 * Is current scope metric?
	 * @var boolean
	 */
	protected $isMetric = null;

	/**
	 * Display hint?
	 * @var null
	 */
	protected $isHint = null;

	/**
	 * If user called this helper - load config information
	 * GammaFX_AttSpecs_Helper_Featured constructor.
	 */
	public function __construct()
	{
		$this->getConfig();
	}

	/**
	 * @param int $storeId
	 *
	 * @return $this
	 */
	public function setStoreId($storeId)
	{
		$this->storeId = (int) $storeId;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getStoreId()
	{
		if (!$this->storeId) {
			$this->storeId = Mage::app()->getStore()->getStoreId();
		}
		return $this->storeId;
	}

	/**
	 * @return array|mixed
	 */
	public function getConfig()
	{
		if (!$this->config) {
			if ($serializedData = Mage::getStoreConfig(self::SECTION_NAME, $this->getStoreId())) {
				if (is_array($serializedData)) {
					$this->config = $serializedData;
				}
			}
		}

		return $this->config;
	}

	/**
	 * @return bool|null
	 */
	public function isMetric()
	{
		if ($this->isMetric === null) {
			if (isset($this->getConfig()['general']['is_metric'])) {
				$this->isMetric = (boolean)$this->getConfig()['general']['is_metric'];
			}
		}

		return $this->isMetric;
	}

	/**
	 * @return bool|null
	 */
	public function isHint()
	{
		if ($this->isHint === null) {
			if (isset($this->getConfig()['general']['is_hint'])) {
				$this->isHint = (boolean)$this->getConfig()['general']['is_hint'];
			}
		}

		return $this->isHint;
	}

	/**
	 * @return array|null
	 */
	public function getSpecs()
	{
		if (!$this->specs) {
			if (isset($this->getConfig()['featured']['specs']) && $serialized = $this->getConfig()['featured']['specs']) {
				$specData = unserialize($serialized);
				$structuredData = null;

				foreach ($specData as $key => $value) {
					$structuredData[$value['attribute_code']] = $value;
				}

				$this->specs = $structuredData;
			} else {
				Mage::log('The config data of ' . self::SECTION_NAME . '/featured/specs" empty or not found!');
			}

		}
		return $this->specs;
	}

	/**
	 * @return null
	 */
	public function getAttributesData()
	{
		if (!$this->attributesData) {
			$attributes = Mage::getModel('eav/entity_attribute')
				->getCollection()
				->addFieldToFilter(
					'attribute_code', array('in' => array_keys($this->getSpecs()))
				);

			foreach ($attributes as $key => $value) {
				$this->attributesData[$key] = $value->getData();
			}
		}
		return $this->attributesData;
	}

	/**
	 * Load styles if hint is switched on
	 * @return bool|string
	 */
	public function setCanLoadTooltip()
	{
		if ($this->isHint()) {
			return 'css/attspecs/tooltip.css';
		}

		return false;
	}
}