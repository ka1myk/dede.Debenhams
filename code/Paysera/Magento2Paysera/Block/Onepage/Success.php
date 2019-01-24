<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Paysera\Magento2Paysera\Block\Onepage;

use Magento\Store\Model\ScopeInterface;

class Success extends \Magento\Framework\View\Element\Template
{
    const PAYSERA_PAYMENT  = 'payment/paysera';

    protected $_checkoutSession;
    protected $_orderConfig;
    protected $httpContext;
    protected $_scopeConfig;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Sales\Model\Order\Config $orderConfig,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Http\Context $httpContext,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_checkoutSession = $checkoutSession;
        $this->_orderConfig     = $orderConfig;
        $this->_scopeConfig     = $scopeConfig;
        $this->_isScopePrivate  = true;
        $this->httpContext      = $httpContext;
    }

    /**
     * Render additional order information lines and return result html
     *
     * @return string
     */
    public function getAdditionalInfoHtml()
    {
        return $this->_layout->renderElement('order.success.additional.info');
    }

    /**
     * Initialize data and prepare it for output
     *
     * @return string
     */
    protected function _beforeToHtml()
    {
        $this->prepareBlockData();
        return parent::_beforeToHtml();
    }

    /**
     * Prepares block data
     *
     * @return void
     */
    protected function prepareBlockData()
    {
        $isPaysera = $this->getRequest()->getParam('paysera');

        if(!is_null($isPaysera)) {
            $paysera_config = $this->_scopeConfig->getValue(
                $this::PAYSERA_PAYMENT,
                ScopeInterface::SCOPE_STORE
            );

            $order = $this->_checkoutSession->getLastRealOrder();

            $order->setStatus(
                $paysera_config['paysera_order_status']['new_order_status']
            )->save();
        }
    }
}
