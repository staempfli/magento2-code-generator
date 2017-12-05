<?php
/**
 * ${ApiClassName}
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */
namespace ${Vendorname}\${Modulename}\Model;

use ${Vendorname}\${Modulename}\Api\${ApiClassName}Interface;

class ${ApiClassName} implements ${ApiClassName}Interface
{
    public function ${actionname}()
    {
        // Do something
        $result = ['success' => 'Here comes the result'];

        return json_encode($result);
    }
}
