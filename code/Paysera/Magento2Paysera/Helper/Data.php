<?php
namespace Paysera\Magento2Paysera\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Checkout\Model\Session;
use Magento\Framework\Locale\Resolver;

class Data extends AbstractHelper
{
    const LANGUAGE_CODE_SPLITER = '_';
    const PAYSERA_PAYMENT = 'payment/paysera';

    protected $_pageFactory;
    protected $_scopeConfig;
    protected $_checkoutSession;
    protected $_storeManager;
    protected $_locale;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        Session $session,
        Resolver $locale
    ) {
        parent::__construct($context);
        $this->_pageFactory     = $pageFactory;
        $this->_scopeConfig     = $scopeConfig;
        $this->_storeManager    = $storeManager;
        $this->_checkoutSession = $session;
        $this->_locale          = $locale;
    }

    public function getTotalAmmount()
    {
        $quote = $this->_checkoutSession->getQuote();

        return $quote->getGrandTotal();
    }

    public function getOrderCurrencyCode()
    {
        $quote = $this->_checkoutSession->getQuote();

        return $quote->getBaseCurrencyCode();
    }

    public function getOrderCountryCode()
    {
        $quote = $this->_checkoutSession->getQuote();

        $countryCode = $quote->getShippingAddress()->getCountryId();

        return strtolower($countryCode);
    }

    public function getStoreLangCode()
    {
        $lang = $this->_locale->getLocale();

        return strstr($lang, $this::LANGUAGE_CODE_SPLITER, true);
    }

    public function getExtraConf($group, $name)
    {
        $paysera_config = $this->_scopeConfig->getValue(
            $this::PAYSERA_PAYMENT,
            ScopeInterface::SCOPE_STORE
        );

        if (empty($name)) {
            $option = $paysera_config[$group];
        } else {
            $option = $paysera_config[$group][$name];
        }

        return $option;
    }

    public function getPageBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    public function setSessionData($key, $value)
    {
        return $this->_checkoutSession->setData($key, $value);
    }

    public function getSessionData($key, $remove = false)
    {
        return $this->_checkoutSession->getData($key, $remove);
    }
}
