<?php
/**
 * ${Entityname}.php
 *
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
 */
namespace ${Vendorname}\${Modulename}\Model;

use Magento\Framework\DataObject;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Registry;
use ${Vendorname}\${Modulename}\Helper\FileProcessor;

class ${Entityname} extends AbstractModel implements IdentityInterface
{
    /**
     * @var string
     */
    const FILES_SUBDIR = '${entityname}';

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
     * @var FileProcessor
     */
    protected $fileProcessor;

    /**
     * @var ${Entityname}Factory
     */
    protected $${entityname}Factory;

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
     * @param FileProcessor $fileProcessor
     * @param ${Entityname}Factory $${entityname}Factory
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        FileProcessor $fileProcessor,
        ${Entityname}Factory $${entityname}Factory,
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

        $this->fileProcessor = $fileProcessor;
        $this->${entityname}Factory = $${entityname}Factory;
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
     * Prepare File data before saving object
     *
     * @return $this
     * @throws \Exception
     */
    public function beforeSave() //@codingStandardsIgnoreLine
    {
        parent::beforeSave();
        $file = $this->get${Form_field_name}();
        if (!is_array($file)) {
            $this->isSaveAllowed(false);
            return $this;
        }

        $file = reset($file) ?: [];
        if (!isset($file['file'])) {
            throw new LocalizedException(
                __('Image does not contain field \'file\'')
            );
        }
        // Add file related data to object
        $this->setFilename($file['file']);
        $this->setFileExists(isset($file['exists']));

        return $this;
    }

    /**
     * Save uploaded file and remove temporary file after saving object
     *
     * @return $this
     * @throws \Exception
     */
    public function afterSave() //@codingStandardsIgnoreLine
    {
        parent::afterSave();
        // if file already exists we do not need to save any new file
        if ($this->getFileExists()) {
            return $this;
        }

        // Delete old file if new one has changed
        if ($this->getOrigData('filename') && $this->getFilename() != $this->getOrigData('filename')) {
            $this->fileProcessor->delete($this->getFileSubDir(), $this->getOrigData('filename'));
        }

        if (!$this->fileProcessor->saveFileFromTmp($this->getFilename(), $this->getFileSubDir())) {
            throw new \Exception('There was an error saving the file');
        }
    }

    /**
     * Subdir where files are stored
     *
     * @return string
     */
    protected function getFileSubDir()
    {
        return self::FILES_SUBDIR . '/' . $this->getId();
    }

    /**
     * Delete media file before an image row in database is removed
     *
     * @return $this
     */
    public function beforeDelete() //@codingStandardsIgnoreLine
    {
        parent::beforeDelete();
        // Delete file from disk before the object is deleted from database
        if ($this->getFilename()) {
            $this->fileProcessor->delete($this->getFileSubDir(), $this->getFilename());
        }
        return $this;
    }

    /**
     * Save multiple files with format from Dynamic ui form fields
     *
     * @param array $files
     * @param array $data -> custom data to add on every image. i.e: a foreign id to another object
     */
    public function saveDynamicFieldFiles(array $files, array $data = [])
    {
        $idField = $this->getIdFieldName();
        $fileIds = array_column($files, $idField);
        $collection = $this->getCollection();
        $collection->addFieldToFilter($idField, array('in' => $fileIds));
        $items = $collection->getItems();
        foreach ($files as $file) {
            if (isset($file[$idField]) && !$file[$idField]) {
                unset($file[$idField]);
            }
            $fileObject = $this->${entityname}Factory->create()->addData($file);
            if ($fileObject->getDelete() || !$fileObject->get${Form_field_name}()) {
                $fileObject->isDeleted(true);
            }
            if (isset($items[$fileObject->getId()])) {
                $collection->removeItemByKey($fileObject->getId());
                $items[$fileObject->getId()]->isDeleted($fileObject->isDeleted());
                $fileObject = $items[$fileObject->getId()]->addData($fileObject->getData());
            }
            if ($data) {
                $fileObject->addData($data);
            }
            $collection->addItem($fileObject);
        }
        $collection->save();
    }

    /**
     * Get full info from file
     *
     * @return DataObject
     */
    public function getFileInfo()
    {
        if (!$this->getData('file_info') && $this->getFilename()) {
            $fileInfoObject = new DataObject();
            $fileInfo = $this->fileProcessor->getFileInfo($this->getFilename(), $this->getFileSubDir());
            if ($fileInfo) {
                $fileInfoObject->setData($fileInfo);
            }
            $this->setFileInfo($fileInfoObject);
        }

        return $this->getData('file_info');
    }

    /**
     * Return file info in a format valid for ui form fields
     *
     * @return array
     */
    public function getFileValueForForm()
    {
        if ($this->getFileInfo()->getFile()) {
            return [$this->getFileInfo()->getData()];
        }
        return [];
    }
}
