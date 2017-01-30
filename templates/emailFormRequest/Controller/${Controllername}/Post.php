<?php
/**
 * Post
 *
 * @copyright Copyright (c) ${commentsYear} ${CommentsCompanyName}
 * @author    ${commentsUserEmail}
 */
 
namespace ${Vendorname}\${Modulename}\Controller\${Controllername};

use ${Vendorname}\${Modulename}\Helper\Email;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Post extends Action
{
    /**
     * @var Email
     */
    protected $emailHelper;

    /**
     * Post constructor.
     * @param Context $context
     * @param Email $emailHelper
     */
    public function __construct(Context $context, Email $emailHelper)
    {
        parent::__construct($context);
        $this->emailHelper = $emailHelper;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        if (!$post) {
            return $this->_redirect('*/*/');
        }
        try {
            $this->validate($post);
        } catch (\Exception $e) {
            return $this->redirectWithErrorMessage($e->getMessage());
        }
        $result = $this->emailHelper->sendTransactional($post, $post['email']);
        if (!$result) {
            return $this->redirectWithErrorMessage('We can\'t process your request right now. Sorry, that\'s all we know.');
        }
        $this->messageManager->addSuccessMessage(__('Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.'));
        return $this->_redirect('${vendorname}_${modulename}/${controllername}');
    }

    /**
     * @param array $post
     * @throws \Exception
     */
    protected function validate(array $post)
    {
        if (!\Zend_Validate::is(trim($post['name']), 'NotEmpty')) {
            throw new \Exception('Name cannot be empty');
        }
        if ($post['email'] && !\Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
            throw new \Exception('Email format is not valid');
        }
        if (\Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
            throw new \Exception('Hidden field cannot be empty');
        }
        // More validations here...
    }

    /**
     * @param string $message
     * @return \Magento\Framework\App\ResponseInterface
     */
    protected function redirectWithErrorMessage(string $message)
    {
        $this->messageManager->addErrorMessage(__($message));
        return $this->_redirect('${vendorname}_${modulename}/${controllername}');
    }
}
