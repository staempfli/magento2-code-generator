<?php
/**
 * Collection.php
 *
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
 */
namespace ${Vendorname}\${Modulename}\Model\ResourceModel\${Entityname};

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
        $this->_init('${Vendorname}\${Modulename}\Model\${Entityname}', '${Vendorname}\${Modulename}\Model\ResourceModel\${Entityname}');
    }
}
