<?php
/**
 * Save
 *
 * @copyright Copyright © ${commentsYear} ${CommentsCompanyName}. All rights reserved.
 * @author    ${commentsUserEmail}
 */
namespace ${Vendorname}\${Modulename}\Controller\Adminhtml\${Entityname};

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use ${Vendorname}\${Modulename}\Model\${Entityname}Factory;

class Save extends Action
{
    /** @var ${Entityname}Factory $objectFactory */
    protected $objectFactory;

    /**
     * @param Context $context
     * @param ${Entityname}Factory $objectFactory
     */
    public function __construct(
        Context $context,
        ${Entityname}Factory $objectFactory
    ) {
        $this->objectFactory = $objectFactory;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('${Vendorname}_${Modulename}::${entityname}');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $params = [];
            $objectInstance = $this->objectFactory->create();
            $idField = $objectInstance->getIdFieldName();
            if (empty($data[$idField])) {
                $data[$idField] = null;
            } else {
                $objectInstance->load($data[$idField]);
                $params[$idField] = $data[$idField];
            }
            $objectInstance->addData($data);

            $this->_eventManager->dispatch(
                '${vendorname}_${modulename}_${entityname}_prepare_save',
                ['object' => $this->objectFactory, 'request' => $this->getRequest()]
            );

            try {

                if($objectInstance->getData('identifier') == null)
                    $objectInstance->setIdentifier($this->generateRandomString());

                $objectInstance->save();
                $this->messageManager->addSuccessMessage(__('You saved this record.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $params = [$idField => $objectInstance->getId(), '_current' => true];
                    return $resultRedirect->setPath('*/*/edit', $params);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the record.'));
            }

            $this->_getSession()->setFormData($this->getRequest()->getPostValue());
            return $resultRedirect->setPath('*/*/edit', $params);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
