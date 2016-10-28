# Magento_GammaFX_AttSpecs
Exntesion, that add some fields for attributes

If you want to get attributes, you shoud use the helper attspecs/featured.

Examples:
1) Get specifications for another store
```php
Mage::helper('attspecs/featured')->setStoreId(5)->getSpecs();
```

2) Is scope metric? 
```php
Mage::helper('attspecs/featured')->isMetric(); // return true or false for current scope
```

3) Load all information about attributes from specs table:
```php
Mage::helper('attspecs/featured')->getAttributesData();
```

4) If you want to activate description hint on attribute hover - just activate option in CP. 

5) You can use deafult magento method $_product->getAdditionalData(), this method will return default attribute data + specs data.
Example with specs:
```php
return [
	'code' => 'warranty',
	'label' => 'Warranty',
	'value' => '3.5',
	'attspecs' => [
		'description' => 'Some desc for current scope',
		'class' => 'attspecs att',
		'dai' => 1,
		'icon' => 'get/image/by/media/someicon.png'
	]
];
```

Example without specs:
```php
return [
	'code' => 'warranty',
	'label' => 'Warranty',
	'value' => '3.5',
	'attspecs' => null
];
```

6) This is example of integration in template:
View: app/design/frontend/vanguard/default/template/catalog/product/view/attributes.phtml
Parts of code:
```php
<?php $isHint = Mage::helper('attspecs/featured')->isHint(); ?>
<?php $_additional = $this->getAdditionalData(); ?>
<?php foreach ($_additional as $_data): ?>
	<?php if($_product->getData($_data['code'])){ ?>
            <tr>
                <th class="label">
	                <?php if ($isHint === false) : ?>
		                <?php echo $this->escapeHtml($this->__($_data['label'])) ?>
                    <?php else: // is hint === true ?>
	                    <?php if (isset($_data['attspecs']['description']) && $description = $_data['attspecs']['description']) : ?>
	                         <span class="tooltip" data-tooltip="<?php echo $description; ?>">
		                        <?php echo $this->escapeHtml($this->__($_data['label'])) ?>
	                         </span>
	                    <?php else: // is description === false ?>
			                <?php echo $this->escapeHtml($this->__($_data['label'])) ?>
						<?php endif; // is description?>
	                <?php endif; // end is hint ?>
			        </th>
                <td class="data">
                	<?php echo str_replace(array('.00', Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol()),array('',''),$_helper->productAttribute($_product, $_data['value'], $_data['code']))				
				 	?>
				 </td>
            </tr>
        	<?php } ?>
<?php endforeach; ?>
```

