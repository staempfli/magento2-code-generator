<?php
/**
 * Save
 *
 * @project  ${Modulename}
 * @copyright Copyright (c) 2016 Staempfli AG (http://www.staempfli.com)
 * @author    juan.alonso@staempfli.com
 */
namespace ${Vendorname}\${Modulename}\Controller\Adminhtml\${Type};

use Magento\Backend\App\Action\Context;
use ${Vendorname}\${Modulename}\Model\${Type}Factory;

class Save extends \Magento\Backend\App\Action
{
    /** @var ${Type}Factory $objectFactory */
    protected $objectFactory;

    /**
     * @param Context $context
     * @param ${Type}Factory $objectFactory
     */
    public function __construct(
        Context $context,
        ${Type}Factory $objectFactory
    ) {
        $this->objectFactory = $objectFactory;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('${Vendorname}_${Modulename}::${type}');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getParam('main_fieldset', []);
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $params = [];
            $objectInstance = $this->objectFactory->create();
            if (isset($data['${database_field_id_name}'])) {
                $objectInstance->load($data['${database_field_id_name}']);
                $params['${database_field_id_name}'] = $data['${database_field_id_name}'];
            }
            $objectInstance->addData($data);

            $this->_eventManager->dispatch(
                '${vendorname}_${modulename}_${type}_prepare_save',
                ['object' => $this->objectFactory, 'request' => $this->getRequest()]
            );

            try {
                $objectInstance->save();
                $this->messageManager->addSuccessMessage(__('You saved this record.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $params = ['${database_field_id_name}' => $objectInstance->getId(), '_current' => true];
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
