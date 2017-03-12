<?php
/**
 * Collection.php
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */
namespace ${Vendorname}\${Modulename}\Model\ResourceModel\${Entityname};

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

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
