<?php
/**
 * ${Attributename}
 *
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
 */

namespace ${Vendorname}\${Modulename}\Model\${Entityname}\Attribute\Backend;

use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\DataObject;
use ${Vendorname}\${Modulename}\Helper\FileProcessor;

class ${Attributename} extends AbstractBackend
{
    /**
     * @var string
     */
    const FILES_SUBDIR = '${attributename}';

    /**
     * @var FileProcessor
     */
    protected $fileProcessor;

    /**
     * @param FileProcessor $fileProcessor
     */
    public function __construct(FileProcessor $fileProcessor)
    {
        $this->fileProcessor = $fileProcessor;
    }

    /**
     * Prepare File data before saving object
     *
     * @param \Magento\Framework\DataObject $object
     *
     * @return $this
     * @throws \Exception
     */
    public function beforeSave($object) //@codingStandardsIgnoreLine
    {
        parent::beforeSave($object);
        $file = $object->get${Attributename}();
        if (!is_array($file)) {
            $object->setSkipSave${Attributename}(true);
            return $this;
        }

        if (isset($file['delete'])) {
            $object->set${Attributename}(null);
            return $this;
        }

        $file = reset($file) ?: [];
        if (!isset($file['file'])) {
            throw new LocalizedException(
                __('${Attributename} does not contain field \'file\'')
            );
        }
        // Add file related data to object
        $object->set${Attributename}($file['file']);
        $object->setFileExists(isset($file['exists']));

        return $this;
    }

    /**
     * Save uploaded file and remove temporary file after saving object
     *
     * @param \Magento\Framework\DataObject $object
     *
     * @return $this
     * @throws \Exception
     */
    public function afterSave($object) //@codingStandardsIgnoreLine
    {
        parent::afterSave($object);
        // if file already exists we do not need to save any new file
        if ($object->getFileExists() || $object->getSkipSave${Attributename}()) {
            return $this;
        }

        // Delete old file if new one has changed
        if ($object->getOrigData('${attributename}') && $object->get${Attributename}() != $object->getOrigData('${attributename}')) {
            $this->fileProcessor->delete($this->getFileSubDir($object), $object->getOrigData('${attributename}'));
        }

        if ($object->get${Attributename}()) {
            if (!$this->fileProcessor->saveFileFromTmp($object->get${Attributename}(), $this->getFileSubDir($object))) {
                throw new \Exception('There was an error saving the file');
            }
        }
    }

    /**
     * Subdir where files are stored
     *
     * @param \Magento\Framework\DataObject $object
     * @return string
     */
    protected function getFileSubDir($object)
    {
        return self::FILES_SUBDIR . '/' . $object->getId();
    }

    /**
     * Delete media file before an ${attributename} row in database is removed
     * @param \Magento\Framework\DataObject $object
     * @return $this
     */
    public function beforeDelete($object) //@codingStandardsIgnoreLine
    {
        parent::beforeDelete($object);
        // Delete file from disk before the object is deleted from database
        if ($object->get${Attributename}()) {
            $this->fileProcessor->delete($this->getFileSubDir($object), $object->get${Attributename}());
        }
        return $this;
    }

    /**
     * Get full info from file
     *
     * @param \Magento\Framework\DataObject $object
     * @return DataObject
     */
    public function getFileInfo($object)
    {
        if (!$object->getData('file_info') && $object->get${Attributename}()) {
            $fileInfoObject = new DataObject();
            $fileInfo = $this->fileProcessor->getFileInfo($object->get${Attributename}(), $this->getFileSubDir($object));
            if ($fileInfo) {
                $fileInfoObject->setData($fileInfo);
            }
            $object->setFileInfo($fileInfoObject);
        }

        return $object->getData('file_info');
    }

    /**
     * Return file info in a format valid for ui form fields
     *
     * @param \Magento\Framework\DataObject $object
     * @return array
     */
    public function getFileValueForForm($object)
    {
        if ($this->getFileInfo($object)->getFile()) {
            return [$this->getFileInfo($object)->getData()];
        }
        return [];
    }
}
