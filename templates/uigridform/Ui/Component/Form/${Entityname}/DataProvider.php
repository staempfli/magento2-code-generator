<?php
/**
 * DataProvider
 *
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
 */
namespace ${Vendorname}\${Modulename}\Ui\Component\Form\${Entityname};

use Magento\Framework\View\Element\UiComponent\DataProvider\FilterPool;
use Magento\Ui\DataProvider\AbstractDataProvider;
use ${Vendorname}\${Modulename}\Model\ResourceModel\${Entityname}\Collection;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;
    
    /**
     * @var FilterPool
     */
    protected $filterPool;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Construct
     *
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param Collection $collection
     * @param FilterPool $filterPool
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $collection,
        FilterPool $filterPool,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collection;
        $this->filterPool = $filterPool;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (!$this->loadedData) {
            $items = $this->collection->getItems();
            $result = array();
            foreach ($items as $item) {
                $result['main_fieldset'] = $item->getData();
                $this->loadedData[$item->getId()] = $result;
                break;
            }
        }
        return $this->loadedData;
    }
}
