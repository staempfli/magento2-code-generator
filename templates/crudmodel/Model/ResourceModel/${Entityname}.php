<?php

/**
 * ${Entityname}.php
 *
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
 */
namespace ${Vendorname}\${Modulename}\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ${Entityname} extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('${vendorname}_${modulename}_${entityname}', '${database_field_id}');
    }
}
