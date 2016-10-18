<?php
/**
 * Index
 *
 * @copyright Copyright (c) ${commentsYear} ${CommentsCompanyName}
 * @author    ${commentsUserEmail}
 */
 
namespace ${Vendorname}\${Modulename}\Controller\Ajax;

use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

class ${Actionname} extends Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(Context $context, PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    /**
     * Index Action
     * 
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        if ($this->getRequest()->isAjax()) {
            /** @var \Magento\Framework\View\Result\Page $resultPage */
            $resultPage = $this->pageFactory->create();
            return $resultPage;
        }
    }
}
