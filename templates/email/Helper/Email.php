<?php
/**
 * Email
 *
 * @copyright Copyright (c) ${commentsYear} ${CommentsCompanyName}
 * @author    ${commentsUserEmail}
 */
namespace ${Vendorname}\${Modulename}\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Backend\App\Area\FrontNameResolver;
use Magento\Framework\DataObject;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\Store;

class Email extends AbstractHelper
{
    const XML_PATH_EMAIL_SENDER = '${vendorname}_${modulename}/email/sender_identity';
    const XML_PATH_EMAIL_TEMPLATE = '${vendorname}_${modulename}/email/${emailname}_template';

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;
    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * Email constructor.
     * @param Context $context
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     */
    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation
    ) {
        parent::__construct($context);
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
    }

    /**
     * @param array $data
     * @param string $areaCode
     * @param int $storeId
     * @return bool
     */
    public function sendTransactional(
        array $data,
        string $recipient,
        string $areaCode = FrontNameResolver::AREA_CODE,
        int $storeId = Store::DEFAULT_STORE_ID
    ) {
        try {
            $this->inlineTranslation->suspend();
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($this->scopeConfig->getValue(self::XML_PATH_EMAIL_TEMPLATE, ScopeInterface::SCOPE_STORE))
                ->setTemplateOptions(['area' => $areaCode, 'store' => $storeId])
                ->setTemplateVars(['data' => new DataObject($data)])
                ->setFrom($this->scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER, ScopeInterface::SCOPE_STORE))
                ->setReplyTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER, ScopeInterface::SCOPE_STORE))
                ->addTo($recipient)
                ->getTransport();
            $transport->sendMessage();
        } catch (\Exception $e) {
            $this->_logger->error(sprintf('Error sending ${modulename} ${emailname} email \n %s', $e->getMessage()));
            return false;
        } finally {
            $this->inlineTranslation->resume();
        }
        return true;
    }
}
