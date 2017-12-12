<?php
/**
 * DataProvider
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */
namespace ${Vendorname}\${Modulename}\Ui\Component\Form\${Entityname};

use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\FilterPool;
use Magento\Ui\DataProvider\AbstractDataProvider;
use ${Vendorname}\${Modulename}\Model\${Entityname};
use ${Vendorname}\${Modulename}\Model\${Entityname}\Attribute\Backend\ImageFactory;
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
     * @var RequestInterface
     */
    protected $request;

    /**
     * Construct
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param Collection $collection
     * @param FilterPool $filterPool
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $collection,
        FilterPool $filterPool,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collection;
        $this->filterPool = $filterPool;
        $this->request = $request;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (!$this->loadedData) {
            $storeId = (int)$this->request->getParam('store');
            $${entityname} = $this->collection
                ->setStoreId($storeId)
                ->addAttributeToSelect('*')
                ->getFirstItem();
            $${entityname}->setStoreId($storeId);
            $${entityname}->addData($this->${entityname}ImagesData($${entityname}));
            $this->loadedData[$${entityname}->getId()] = $${entityname}->getData();
        }
        return $this->loadedData;
    }

    private function ${entityname}ImagesData(${Entityname} $${entityname}): array
    {
        $imagesData = [];
        $imageAttributeCodes = array_keys(ImageFactory::IMAGE_ATTRIBUTE_CODES);
        foreach ($imageAttributeCodes as $imageAttrCode) {
            if ($${entityname}->getData($imageAttrCode)) {
                $imagesData[$imageAttrCode] = $${entityname}->getImageValueForForm($imageAttrCode);
            }
        }
        return $imagesData;
    }
}
