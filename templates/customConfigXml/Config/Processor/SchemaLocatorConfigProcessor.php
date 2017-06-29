<?php
/**
 * SchemaLocatorConfigProcessor
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Config\Processor;

use Magento\Framework\Config\SchemaLocatorInterface;
use Magento\Framework\Module\Dir;
use Magento\Framework\Module\Dir\Reader;

class SchemaLocatorConfigProcessor implements SchemaLocatorInterface
{
    protected $_schema = null;

    /**
     * @param Reader $moduleReader
     */
    public function __construct(Reader $moduleReader)
    {
        $etcDir = $moduleReader->getModuleDir(Dir::MODULE_ETC_DIR, '${Vendorname}_${Modulename}');
        $this->_schema = $etcDir . '/${vendorname}_${modulename}_${configfile_name}.xsd';
    }

    /**
     * @inheritdoc
     */
    public function getSchema()
    {
        return $this->_schema;
    }

    /**
     * @inheritdoc
     */
    public function getPerFileSchema()
    {
        return $this->_schema;
    }
}
