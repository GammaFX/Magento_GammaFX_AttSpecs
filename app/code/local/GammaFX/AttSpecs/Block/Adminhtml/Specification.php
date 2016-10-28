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
 * AttSpecs Featured table creator
 *
 * @category 	GammaFX
 * @package 	GammaFX_AttSpecs
 * @author  	GammaFX Bohdan
 */
class GammaFX_AttSpecs_Block_Adminhtml_Specification extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
	/**
	 * @var GammaFX_AttSpecs_Block_Adminhtml_Field_Attribute
	 */
	protected $_specificationRenderer;

	/**
	 * @var GammaFX_AttSpecs_Block_Adminhtml_Field_Dai
	 */
	protected $_daiRender;

	/**
	 * Set table columns
	 */
	public function _prepareToRender()
	{
		$this->addColumn('attribute_code', array(
			'label' => Mage::helper('attspecs')->__('Attributes'),
			'renderer' => $this->_getRendererSpecification(),
		));
		$this->addColumn('description', array(
			'label' => Mage::helper('attspecs')->__('Description'),
			'style' => 'width:200px',
		));
		$this->addColumn('class', array(
			'label' => Mage::helper('attspecs')->__('CSS class'),
			'style' => 'width:100px',
		));
		$this->addColumn('dai', array(
			'label' => Mage::helper('attspecs')->__('Is Icon?'),
			'renderer' => $this->_getRendererDai(),
		));
		$this->addColumn('icon', array(
			'label' => Mage::helper('attspecs')->__('Icon'),
			'style' => 'width:200px',
		));

		$this->_addAfter = false;
		$this->_addButtonLabel = Mage::helper('attspecs')->__('Add');
	}

	/**
	 * @return mixed
	 */
	protected function _getRendererDai()
	{
		if (!$this->_daiRender) {
			$this->_daiRender = $this->getLayout()->createBlock(
				'attspecs/adminhtml_field_dai',
				'',
				array('is_render_to_js_template' => true)
			)->setExtraParams('style="width: 50px"');
		}

		return $this->_daiRender;
	}

	/**
	 * @return mixed
	 */
	protected function  _getRendererSpecification()
	{
		if (!$this->_specificationRenderer) {
			$this->_specificationRenderer = $this->getLayout()->createBlock(
				'attspecs/adminhtml_field_attribute',
				'',
				array('is_render_to_js_template' => true)
			);
		}

		return $this->_specificationRenderer;
	}

	/**
	 * @param Varien_Object $row
	 */
	protected function _prepareArrayRow(Varien_Object $row)
	{
		$row->setData(
			'option_extra_attr_' . $this->_getRendererSpecification()
				->calcOptionHash($row->getData('attribute_code')),
			'selected="selected"'
		);

		$row->setData(
			'option_extra_attr_' . $this->_getRendererDai()
				->calcOptionHash($row->getData('dai')),
			'selected="selected"'
		);
	}

}