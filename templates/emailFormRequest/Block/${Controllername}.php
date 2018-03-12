<?php
/**
 * ${Controllername}
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */

namespace ${Vendorname}\${Modulename}\Block;

use Magento\Framework\View\Element\Template;

class ${Controllername} extends Template
{
    /**
     * @var string $_template
     */
    protected $_template = "${Vendorname}_${Modulename}::${controllername}.phtml";

    /**
     * Returns action url for contact form
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('${vendorname}_${modulename}/${controllername}/post', ['_secure' => true]);
    }
}