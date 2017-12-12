<?php
/**
 * Uploader
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */
namespace ${Vendorname}\${Modulename}\Controller\Adminhtml\File;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use ${Vendorname}\${Modulename}\Helper\FileProcessor;

class Uploader extends Action
{
    /**
     * @var array
     */
    protected $fixedFilesArray;

    /**
     * @var FileProcessor
     */
    protected $fileProcessor;

    /**
     * @param Context $context
     * @param FileProcessor $fileProcessor
     */
    public function __construct(
        Context $context,
        FileProcessor $fileProcessor
    ) {
        parent::__construct($context);
        $this->fileProcessor = $fileProcessor;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $this->fixFile();
        $files = $this->getRequest()->getFiles();
        $result = $this->fileProcessor->saveToTmp(key($files));
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }

    /**
     * Fix $_FILES value with a right format.
     *
     * - Somehow Magento creates a weird format when using dynamic file fields on frontend,
     * We need to fix this format to a right one for later use in Magento uploader classes.
     */
    protected function fixFile()
    {
        $this->fixedFilesArray = [];
        $files = $this->getRequest()->getFiles();
        $fileKey = key($files);
        $current = current($files);
        foreach ($current as $key => $value) {
            if (is_array($value)) {
                array_walk_recursive($value, [$this, 'getNonArrayValue']);
            } else {
                $this->fixedFilesArray[$key] = $value;
            }
        }

        // This is the only way to overwrite $_FILES with a right format for later use in Magento file uploader
        $_FILES[$fileKey] = $this->fixedFilesArray; //@codingStandardsIgnoreLine
    }

    /**
     * @param $item
     * @param $key
     */
    public function getNonArrayValue($item, $key)
    {
        $this->fixedFilesArray[$key] = $item;
    }
}
