<?php

/**
 * ${Modelname}.php
 *
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
 */
namespace ${Vendorname}\${Modulename}\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ${Modelname} extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('${vendorname}_${modulename}_${modelname}', '${database_field_id}');
    }
}
