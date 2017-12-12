<?php
/**
 * ImageAbstract
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Model\${Entityname}\Attribute\Backend;

use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;
use Magento\Framework\DataObject;
use ${Vendorname}\${Modulename}\Helper\FileProcessor;

abstract class ImageAbstract extends AbstractBackend
{
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
     * Dir name where the image will be saved
     *
     * @return string
     */
    abstract protected function subdirName(): string;

    /**
     * Attribute code to get image path from object
     *
     * @return string
     */
    abstract protected function attributeCode(): string;

    private function skipSaveAttributeCode(): string
    {
        return 'skip_save_'.$this->attributeCode();
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
        $file = $object->getData($this->attributeCode());
        if (!is_array($file)) {
            $object->setData($this->skipSaveAttributeCode(), true);
            return $this;
        }
        if (isset($file['delete'])) {
            $object->setData($this->attributeCode(), null);
            return $this;
        }
        $file = reset($file) ?: [];
        if (!isset($file['file'])) {
            throw new \Exception(
                __('Image "%1" does not contain field \'file\'', [$this->attributeCode()])
            );
        }
        $object->setData($this->attributeCode(), $file['file']);
        if (isset($file['exists'])) {
            $object->setData($this->skipSaveAttributeCode(), true);
        }
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

        if (true == $object->getData($this->skipSaveAttributeCode())) {
            return $this;
        }

        $oldFilename = $object->getOrigData($this->attributeCode());
        $newFilename = $object->getData($this->attributeCode());
        if ($oldFilename && $oldFilename != $newFilename) {
            $this->fileProcessor->delete($this->getFileSubDir($object), $oldFilename);
        }

        if ($newFilename) {
            if (!$this->fileProcessor->saveFileFromTmp($newFilename, $this->getFileSubDir($object))) {
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
        return $this->subdirName() . '/' . $object->getId();
    }

    /**
     * Delete media file before the attribute value in table is removed
     *
     * @param \Magento\Framework\DataObject $object
     * @return $this
     */
    public function beforeDelete($object) //@codingStandardsIgnoreLine
    {
        parent::beforeDelete($object);
        $filename = $object->getData($this->attributeCode());
        if ($filename) {
            $this->fileProcessor->delete($this->getFileSubDir($object), $filename);
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
        $fileInfoObject = new DataObject();
        $filename = $object->getData($this->attributeCode());
        $fileInfo = $this->fileProcessor->getFileInfo($filename, $this->getFileSubDir($object));
        if ($fileInfo) {
            $fileInfoObject->setData($fileInfo);
        }
        return $fileInfoObject;
    }

    /**
     * Return file info in a format valid for ui form fields
     *
     * @param \Magento\Framework\DataObject $object
     * @return array
     */
    public function getFileValueForForm($object)
    {
        $fileInfo = $this->getFileInfo($object);
        if ($fileInfo->getFile()) {
            return [$fileInfo->getData()];
        }
        return [];
    }
}
