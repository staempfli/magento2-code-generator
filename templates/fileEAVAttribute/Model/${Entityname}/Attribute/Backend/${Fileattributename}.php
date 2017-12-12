<?php
/**
 * ${Fileattributename}
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Model\${Entityname}\Attribute\Backend;

class ${Fileattributename} extends ImageAbstract
{
    /**
     * @var string
     */
    const ATTRIBUTE_CODE = '${fileattributename}';

    protected function subdirName(): string
{
    return self::ATTRIBUTE_CODE;
}

    protected function attributeCode(): string
{
    return self::ATTRIBUTE_CODE;
}

}
