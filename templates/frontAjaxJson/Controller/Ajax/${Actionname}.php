<?php
/**
 * ${Actionname}
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */
 
namespace ${Vendorname}\${Modulename}\Controller\Ajax;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class ${Actionname} extends Action
{
    /**
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * Ajax request
     *
     * @return void
     */
    public function execute()
    {
        if ($this->getRequest()->isAjax()) {
            try {
                // Do something here
                $result = 'Return what you need here';
                $this->getResponse()->representJson(json_encode(['success' => $result, 'error' => '']));
            } catch (\Exception $e) {
                $this->getResponse()->representJson(json_encode(['success' => '', 'error' => $e->getMessage()]));
            }
        }
    }
}
