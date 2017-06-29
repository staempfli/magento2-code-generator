<?php
/**
 * MappingConfig
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Config;

use Magento\Framework\Config\CacheInterface;
use Magento\Framework\Config\Data as ConfigData;
use Magento\Framework\Config\Reader\FilesystemFactory as ConfigReaderFactory;

class MappingConfig extends ConfigData
{
    /**
     * @var \Magento\Framework\Config\Data
     */
    protected $mappingConfigData;

    public function __construct(
        $fileName,
        Processor\ConverterConfigProcessor $converterConfigProcessor,
        Processor\SchemaLocatorConfigProcessor $schemaLocatorConfigProcessor,
        ConfigReaderFactory $configReaderFactory,
        CacheInterface $cache
    ) {
    
        $reader = $configReaderFactory->create([
            'converter' => $converterConfigProcessor,
            'schemaLocator' => $schemaLocatorConfigProcessor,
            'fileName' => $fileName
        ]);
        $cacheId = $this->getConfigFileWithoutExtension($fileName);
        parent::__construct($reader, $cache, $cacheId);
    }

    protected function getConfigFileWithoutExtension(string $configFile): string
    {
        return substr($configFile, 0, (strpos($configFile, '.xml')));
    }

    public function getConfigData()
    {
        return $this->get('${main_element_name}_list');
    }

}
