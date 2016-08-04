<?php
/**
 * Save
 *
 * @copyright Copyright (c) ${generator.time.year} ${comments.company.name}
 * @author    ${comments.user.mail}
 */
namespace ${Vendorname}\${Modulename}\Controller\Adminhtml\${Modelname};

use Magento\Backend\App\Action\Context;
use ${Vendorname}\${Modulename}\Model\${Modelname}Factory;

class Save extends \Magento\Backend\App\Action
{
    /** @var ${Modelname}Factory $objectFactory */
    protected $objectFactory;

    /**
     * @param Context $context
     * @param ${Modelname}Factory $objectFactory
     */
    public function __construct(
        Context $context,
        ${Modelname}Factory $objectFactory
    ) {
        $this->objectFactory = $objectFactory;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('${Vendorname}_${Modulename}::${modelname}');
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
            if (isset($data['${database_field_id}'])) {
                $objectInstance->load($data['${database_field_id}']);
                $params['${database_field_id}'] = $data['${database_field_id}'];
            }
            $objectInstance->addData($data);

            $this->_eventManager->dispatch(
                '${vendorname}_${modulename}_${modelname}_prepare_save',
                ['object' => $this->objectFactory, 'request' => $this->getRequest()]
            );

            try {
                $objectInstance->save();
                $this->messageManager->addSuccessMessage(__('You saved this record.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $params = ['${database_field_id}' => $objectInstance->getId(), '_current' => true];
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
