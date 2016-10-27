<?php
/**
 * Created by PhpStorm.
 * User: bodyanuk
 * Date: 10/20/16
 * Time: 21:02
 */

class GammaFX_AttSpecs_Helper_Featured extends Mage_Core_Helper_Abstract {

	const SECTION_NAME = 'attspecs';

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
	 * @return array|null
	 */
	public function getSpecs()
	{
		if (!$this->specs) {
			if (isset($this->getConfig()['featured']['specs']) && $serialized = $this->getConfig()['featured']['specs']) {
				$specData = unserialize($serialized);
				$structuredData = null;

				foreach ($specData as $key => $value) {
					$structuredData[(int) $value['attribute_id']] = $value;
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
					'attribute_id', array('in' => array_keys($this->getSpecs()))
				);

			foreach ($attributes as $key => $value) {
				$this->attributesData[$key] = $value->getData();
			}
		}
		return $this->attributesData;
	}
}