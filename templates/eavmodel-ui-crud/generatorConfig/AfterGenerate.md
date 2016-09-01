
0. ${Vendorname}/${Modulename}/Setup/InstallSchema.php
    // Add more static attributes here...
 
0. ${Vendorname}/${Modulename}/Setup/${Entityname}Setup.php
    // Add your entity attributes here...
    
0. ${Vendorname}/${Modulename}/view/adminhtml/ui_component/${vendorname}_${modulename}_${entityname}_form.xml
    <!-- Add your fields here -->

0. ${Vendorname}/${Modulename}/view/adminhtml/ui_component/${vendorname}_${modulename}_${entityname}_listing.xml
    <!-- Add your columns here -->

0. ${Vendorname}\${Modulename}\Controller\Adminhtml\${Entityname}\Validate:

    /**
     * Check if required fields is not empty
     *
     * @param array $data
     */
    public function validateRequireEntries(array $data)
    {
        $requiredFields = [
            'identifier' => __('${Entityname} Identifier'),
        ];
        
        //...
    }
    
0. ${Vendorname}/${Modulename}/etc/adminhtml/menu.xml

0. ${Vendorname}\${Modulename}\Ui\Component\Listing\DataProvider

    /**
     * @param SearchResultInterface $searchResult
     * @return array
     */
    protected function searchResultToOutput(SearchResultInterface $searchResult)
    {
        $searchResult->setStoreId($this->request->getParam('store', 0))
            ->addAttributeToSelect([]); // Add here needed EAV attributes to display on grid

        return parent::searchResultToOutput($searchResult);
    }