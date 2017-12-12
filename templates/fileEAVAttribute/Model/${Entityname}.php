<?php

/**
 * ${Entityname}.php
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Registry;
use ${Vendorname}\${Modulename}\Model\${Entityname}\Attribute\Backend\${Fileattributename}Factory;

class ${Entityname} extends AbstractModel implements IdentityInterface
{
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = '${vendorname}_${modulename}_${entityname}';

    /**
     * @var string
     */
    protected $_cacheTag = '${vendorname}_${modulename}_${entityname}';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = '${vendorname}_${modulename}_${entityname}';

    /**
     * @var ${Fileattributename}Factory
     */
    private $${fileattributename}Factory;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('${Vendorname}\${Modulename}\Model\ResourceModel\${Entityname}');
    }

    /**
     * Reference constructor.
     * @param ${Fileattributename}Factory $${fileattributename}Factory
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        ${Fileattributename}Factory $${fileattributename}Factory,
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
        $this->${fileattributename}Factory = $${fileattributename}Factory;
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Save from collection data
     *
     * @param array $data
     * @return $this|bool
     */
    public function saveCollection(array $data)
    {
        if (isset($data[$this->getId()])) {
            $this->addData($data[$this->getId()]);
            $this->getResource()->save($this);
        }
        return $this;
    }

    /**
     * Get ${Fileattributename} in right format to edit in admin form
     *
     * @return array
     */
    public function get${Fileattributename}ValueForForm()
    {
        $${fileattributename} = $this->${fileattributename}Factory->create();
        return $${fileattributename}->getFileValueForForm($this);
    }

    /**
     * Get ${Fileattributename} Src to display in frontend
     *
     * @return mixed
     */
    public function get${Fileattributename}Src()
    {
        $${fileattributename} = $this->${fileattributename}Factory->create();
        return $${fileattributename}->getFileInfo($this)->getUrl();
    }

}
