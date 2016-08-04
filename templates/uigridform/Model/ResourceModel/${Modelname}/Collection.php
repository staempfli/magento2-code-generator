<?php

/**
 * Collection.php
 *
 * @package  ${Modulename}
 * @copyright Copyright (c) 2016 Staempfli AG (http://www.staempfli.com)
 * @author    juan.alonso@staempfli.com
 */

namespace ${Vendorname}\${Modulename}\Model\ResourceModel\${Modelname};

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = '${database_field_id}';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('${Vendorname}\${Modulename}\Model\${Modelname}', '${Vendorname}\${Modulename}\Model\ResourceModel\${Modelname}');
    }
}
