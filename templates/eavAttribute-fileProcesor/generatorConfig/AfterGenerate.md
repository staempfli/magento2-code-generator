0. ${Vendorname}/${Modulename}/Setup/${Entityname}Setup.php

```
$attributes['${attributename}'] = [
            'type' => 'varchar',
            'label' => '${Attributename}',
            'input' => 'image',
            'backend' => '${Vendorname}\${Modulename}\Model\${Entityname}\Attribute\Backend\${Attributename}',
            'required' => false,
            'sort_order' => 99,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'group' => 'General',
        ];

```

0. ${Vendorname}/${Modulename}/Controller/Adminhtml/${Entityname}/Save.php:

```
    /**
     * ${Attributename} data preprocessing
     *
     * @param array $data
     *
     * @return array
     */
    public function ${attributename}Preprocessing($data)
    {
        if (empty($data['${attributename}'])) {
            unset($data['${attributename}']);
            $data['${attributename}']['delete'] = true;
        }
        return $data;
    }
```
    
0. ${Vendorname}/${Modulename}/Model/${Entityname}.php

```
        use ${Vendorname}\${Modulename}\Model\${Entityname}\Attribute\Backend\${Attributename}Factory;

        /**
         * Get ${Attributename} in right format to edit in admin form
         *
         * @return array
         */
        public function get${Attributename}ValueForForm()
        {
            $${attributename} = $this->${attributename}Factory->create();
            return $${attributename}->getFileValueForForm($this);
        }
    
        /**
         * Get ${Attributename} Src to display in frontend
         *
         * @return mixed
         */
        public function get${Attributename}Src()
        {
            $${attributename} = $this->${attributename}Factory->create();
            return $${attributename}->getFileInfo($this)->getUrl();
        }
```
        
0. ${Vendorname}/${Modulename}/Ui/Component/Form/${Entityname}/DataProvider.php

```
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        // ...
            foreach ($items as $item) {
                if ($item->get${Attributename}()) {
                    $item->set${Attributename}($item->get${Attributename}ValueForForm());
                }
                $item->setStoreId($storeId);
                $this->loadedData[$item->getId()] = $item->getData();
                break;
            }
        }
        return $this->loadedData;
    }
```

0. view/adminhtml/ui_component/${vendorname}_${modulename}_${entityname}_form.xml:

```
<field name="${attributename}">
    <argument name="data" xsi:type="array">
        <item name="config" xsi:type="array">
            <item name="label" xsi:type="string">${Attributename}</item>
            <item name="formElement" xsi:type="string">fileUploader</item>
            <item name="componentType" xsi:type="string">fileUploader</item>
            <item name="notice" xsi:type="string" translate="true">Allowed file types: jpeg, gif, png</item>
            <item name="maxFileSize" xsi:type="number">2097152</item>
            <item name="allowedExtensions" xsi:type="string">jpg jpeg gif png</item>
            <item name="uploaderConfig" xsi:type="array">
                <item name="url" xsi:type="string">${vendorname}_${modulename}/file/uploader</item>
            </item>
            <item name="sortOrder" xsi:type="string">99</item>
            <item name="scopeLabel" xsi:type="string">[GLOBAL]</item>
        </item>
    </argument>
</field>
```