<?php
namespace Paysera\Magento2Paysera\Controller\Index;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Checkout\Model\Session;
use Paysera\Magento2Paysera\Helper\Data;
use WebToPay;

class Index extends \Magento\Framework\App\Action\Action
{
    const PAYSERA_PAYMENT  = 'payment/paysera';
    const PAYSERA_STATUS   = 'paysera_order_status';
    const ORDER_STATUS     = 'canceled_order_status';
    const SUCCESS_ADDRESS  = 'checkout/onepage/success?paysera';
    const CALLBACK_ADDRESS = 'paysera/index/callback';

    const PAYSERA_TYPE     = 'paysera_payment_type';
    const REDIRECT         = 'pageRedirectUrl';

    protected $_pageFactory;
    protected $_checkoutSession;
    protected $_scopeConfig;
    protected $_storeManager;
    protected $_helper;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        Session $checkoutSession,
        Data $helper
    ) {
        $this->_pageFactory     = $pageFactory;
        $this->_scopeConfig     = $scopeConfig;
        $this->_storeManager    = $storeManager;
        $this->_checkoutSession = $checkoutSession;
        $this->_helper          = $helper;
        return parent::__construct($context);
    }

    public function execute()
    {
        $order = $this->_checkoutSession->getLastRealOrder();

        $paysera_config = $this->_scopeConfig->getValue(
            $this::PAYSERA_PAYMENT,
            ScopeInterface::SCOPE_STORE
        );

        $order->setStatus(
            $paysera_config[$this::PAYSERA_STATUS][$this::ORDER_STATUS]
        )->save();

        $payment = $this->getDataFromSession($this::PAYSERA_TYPE);

        print_r($this->buildRedirectLink(
            $this->getPayseraPaymentUrl($payment)
        ));
    }

    protected function buildRedirectLink($link)
    {
        $parameter = ['url' => $link,];

        return json_encode($parameter);
    }

    protected function getDataFromSession($name)
    {
        return $this->_helper->getSessionData($name);
    }

    protected function getBasePage()
    {
        return $this->_helper->getPageBaseUrl();
    }

    protected function getPayseraPaymentUrl($payment)
    {
        $order = $this->_checkoutSession->getLastRealOrder();

        $paysera_config = $this->_scopeConfig->getValue(
            $this::PAYSERA_PAYMENT,
            ScopeInterface::SCOPE_STORE
        );

        $buildParameters = [
            'projectid'     => $paysera_config['projectid'],
            'sign_password' => $paysera_config['sign_password'],

            'orderid'       => $order->getId(),
            'amount'        => $order->getGrandTotal() * 100,
            'currency'      => $order->getOrderCurrencyCode(),

            'accepturl'     => $this->getBasePage() . $this::SUCCESS_ADDRESS,
            'callbackurl'   => $this->getBasePage() . $this::CALLBACK_ADDRESS,
            'cancelurl'     => $this->getBasePage(),

            'p_firstname'   => $order->getBillingAddress()->getFirstname(),
            'p_lastname'    => $order->getBillingAddress()->getLastname(),
            'p_email'       => $order->getBillingAddress()->getEmail(),
            'p_street'      => $order->getBillingAddress()->getStreet()[0],
            'p_city'        => $order->getBillingAddress()->getCity(),
            'p_state'       => substr($order->getBillingAddress()->getRegion(), 0, 20),
            'p_zip'         => $order->getBillingAddress()->getPostcode(),
            'p_countrycode' => $order->getBillingAddress()->getCountryId(),

            'payment'       => $payment,

            'test'          => $paysera_config['test'],
        ];

        $request = WebToPay::buildRequest($buildParameters);

        $redirectUrl = WebToPay::PAY_URL . '?' . http_build_query($request);

        $redirectUrlResult = preg_replace(
            '/[\r\n]+/is',
            '',
            $redirectUrl
        );

        return $redirectUrlResult;
    }
}
