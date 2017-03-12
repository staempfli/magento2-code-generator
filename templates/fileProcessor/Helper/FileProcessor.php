<?php
/**
 * FileProcessor
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */
namespace ${Vendorname}\${Modulename}\Helper;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Config\Model\Config\Backend\File;

class FileProcessor
{
    /**
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * Media Directory object (writable).
     *
     * @var WriteInterface
     */
    protected $mediaDirectory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var File
     */
    protected $backendFile;

    /**
     * @var array $allowedExtensions
     */
    protected $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];

    /**
     * @var string
     */
    const FILE_DIR = '${vendorname}_${modulename}/files';

    /**
     * @var string
     */
    const TMP_SUBDIR = 'tmp';

    /**
     * @param UploaderFactory $uploaderFactory
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @param File $backendFile
     */
    public function __construct(
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager,
        File $backendFile
    )
    {
        $this->uploaderFactory = $uploaderFactory;
        $this->storeManager = $storeManager;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->backendFile = $backendFile;
    }

    /**
     * Save file to temp media directory
     *
     * @param  string $fileId
     * @return array
     * @throws LocalizedException
     */
    public function saveToTmp($fileId)
    {
        try {
            $result = $this->save($fileId, $this->getAbsoluteMediaPath(self::TMP_SUBDIR));
            $result['url'] = $this->getMediaUrl($result['file'], self::TMP_SUBDIR);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $result;
    }

    /**
     * Get Path where the files will be saved
     *
     * @param string $subdir
     * @param string $filename
     * @return string
     */
    protected function getPath($subdir = null, $filename = null)
    {
        $path = $this->mediaDirectory->getRelativePath(self::FILE_DIR);
        if ($subdir) {
            $path .= '/' . $subdir;
        }
        if ($filename) {
            $path .= '/' . $this->prepareFile($filename);
        }
        return $path;
    }

    /**
     * @param null $subdir
     * @return string
     */
    protected function getAbsoluteMediaPath($subdir = null)
    {
        return $this->mediaDirectory->getAbsolutePath($this->getPath($subdir));
    }

    /**
     * @param $filename
     * @param null $subdir
     * @return string
     */
    protected function getMediaUrl($filename, $subdir = null)
    {
        return $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $this->getPath($subdir, $filename);
    }

    /**
     * Prepare file
     *
     * @param string $filename
     * @return string
     */
    protected function prepareFile($filename)
    {
        return ltrim(str_replace('\\', '/', $filename), '/');
    }

    /**
     * Save file
     *
     * @param string $fileId
     * @param string $destination
     * @return array
     * @throws LocalizedException
     */
    protected function save($fileId, $destination)
    {
        $result = ['file' => '', 'size' => ''];
        /** @var File $backendModel */
        $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
        $uploader->setAllowRenameFiles(true);
        $uploader->setFilesDispersion(false);
        $uploader->setAllowedExtensions($this->allowedExtensions);
        $uploader->addValidateCallback('size', $this->backendFile, 'validateMaxSize');
        return array_intersect_key($uploader->save($destination), $result);
    }

    /**
     * Save file in disk from tmp directory
     *
     * @param $filename
     * @param null $subdirToSave
     * @return bool
     */
    public function saveFileFromTmp($filename, $subdirToSave = null)
    {
        $result = $this->mediaDirectory->copyFile(
            $this->getPath(self::TMP_SUBDIR, $filename),
            $this->getPath($subdirToSave, $filename)
        );
        if ($result) {
            $this->mediaDirectory->delete($this->getPath(self::TMP_SUBDIR, $filename));
            return true;
        }

        return false;
    }

    /**
     * Delete files from disk
     * @param string $subdir
     * @param string $filename
     * @return bool
     */
    public function delete($subdir, $filename)
    {
        return $this->mediaDirectory->delete($this->getPath($subdir, $filename));
    }

    /**
     * Get file info from filename
     *
     * @param $filename
     * @param null $subdir
     * @return array|bool
     */
    public function getFileInfo($filename, $subdir = null)
    {
        $filePath = $this->getPath($subdir, $filename);
        if ($this->mediaDirectory->isExist($filePath)) {
            $stat = $this->mediaDirectory->stat($filePath);
            $url = $this->getMediaUrl($filename, $subdir);
            $fileInfo = [
                'url' => $url,
                'file' => $filename,
                'name' => $filename,
                'size' => is_array($stat) ? $stat['size'] : 0,
                'exists' => true
            ];
            return $fileInfo;
        }
        return false;
    }
}
