<?php

/**
 * ${Entityname}Actions.php
 *
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
 */
namespace ${Vendorname}\${Modulename}\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class ${Entityname}Actions extends Column
{
    /**
     * Url path
     */
    const URL_PATH_EDIT = '${vendorname}_${modulename}/${entityname}/edit';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $storeId = $this->context->getFilterParam('store_id');

            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['entity_id'])) {
                    $item[$this->getData('name')]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(
                            self::URL_PATH_EDIT,
                            ['entity_id' => $item['entity_id'], 'store' => $storeId]
                        ),
                        'label' => __('Edit'),
                        'hidden' => false,
                    ];
                }
            }
        }

        return $dataSource;
    }
}
