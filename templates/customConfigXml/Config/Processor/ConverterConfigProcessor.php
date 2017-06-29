<?php
/**
 * ConverterConfigProcessor
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */
namespace ${Vendorname}\${Modulename}\Config\Processor;

use Magento\Framework\Config\ConverterInterface;

class ConverterConfigProcessor implements ConverterInterface
{
    const DEFAULT_SOURCE_TYPE = 'column';

    public function convert($source)
    {
        $xmlEntries = [];
        foreach ($source->getElementsByTagName('${main_element_name}') as $attribute) {
            $data = [];
            foreach ($attribute->childNodes as $childNode) {
                if ($childNode->nodeType == XML_TEXT_NODE) {
                    continue;
                }
                $data[$childNode->nodeName] = $childNode->nodeValue;
            }
            $xmlEntries[] = $data;
        }
        return ['${main_element_name}_list' => $xmlEntries];
    }
}
