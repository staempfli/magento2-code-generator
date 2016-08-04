<?php

/**
 * ${Type}.php
 *
 * @package  ${Modulename}
 * @copyright Copyright (c) 2016 Staempfli AG (http://www.staempfli.com)
 * @author    juan.alonso@staempfli.com
 */

namespace ${Vendorname}\${Modulename}\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ${Type} extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('${vendorname}_${modulename}_${type}', '${database_field_id_name}');
    }
}
