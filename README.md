# Magento_GammaFX_AttSpecs
Exntesion, that add some fields for attributes

If you want to get attributes, you shoud use helper attspecs/featured.

Examples:
1) Get specifications for another store 
Mage::helper('attspecs/featured')->setStoreId(5)->getSpecs();

2) Is scope metric? 
Mage::helper('attspecs/featured')->isMetric(); // return true or false for current scope

3) Load all information about attributes from specs table:
Mage::helper('attspecs/featured')->getAttributesData();

4) If you need to combine specs data and attributes data, you can use this example:
$helper = Mage::helper('attspecs/featured')->setStoreId(5);
$specs = $helper->getSpecs();
$attributes = $helper->getAttributesData();

$combinedData = null;
foreach ($specs as $id => $data) {
  $combinedData[$id] = [
    'specs' => $data,
    'attributes' => (isset($attributes[$id])) ? $attributes[$id] : null
  ];
}
