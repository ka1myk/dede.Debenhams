<?php
namespace Paysera\Magento2Paysera\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use WebToPay;
use Exception;

class Callback extends \Magento\Framework\App\Action\Action
{
    const PAYSERA_PAYMENT = 'payment/paysera';
    const ERROR_AMMOUNT   = 'Amounts do not match';
    const ERROR_CURRENCY  = 'Currencies do not match';

    protected $_scopeConfig;
    protected $_orderRepository;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->_scopeConfig     = $scopeConfig;
        $this->_orderRepository = $orderRepository;
        return parent::__construct($context);
    }

    public function execute()
    {
        $paysera_config = $this->_scopeConfig->getValue(
            $this::PAYSERA_PAYMENT,
            ScopeInterface::SCOPE_STORE
        );

        switch (filter_input(INPUT_SERVER, 'REQUEST_METHOD')) {
            case 'POST':
                $requestData = filter_input_array(INPUT_POST);
                break;
            case 'GET':
                $requestData = filter_input_array(INPUT_GET);
                break;
        }

        try {
            $response = WebToPay::validateAndParseData(
                $requestData,
                $paysera_config['projectid'],
                $paysera_config['sign_password']
            );

            if ($response['status'] == 1) {
                $order = $this->_orderRepository->get($response['orderid']);

                $orderTotalCents = $order->getGrandTotal() * 100;

                $money = array(
                    'amount'   => $orderTotalCents,
                    'currency' => $order->getOrderCurrencyCode()
                );

                $isPaymentCorrect = $this->checkPayment($money, $response);

                if($isPaymentCorrect) {
                    $order->setStatus(
                        $paysera_config['paysera_order_status']['order_status']
                    )->save();

                    print_r('OK');
                }
            }
        } catch (Exception $e) {
            $msg = get_class($e) . ': ' . $e->getMessage();

            print_r($msg);
        }
    }

    public function checkPayment($orderMoney, $response)
    {
        $checkConvert   = array_key_exists('payamount', $response);
        $orderAmount    = $orderMoney['amount'];
        $orderCurrency  = $orderMoney['currency'];

        if($response['amount'] != $orderAmount || ($checkConvert && $response['payamount'] != $orderAmount)) {
            throw new LocalizedException(__($this::ERROR_AMMOUNT));
        }

        if($response['currency'] != $orderCurrency || ($checkConvert && $response['paycurrency'] != $orderCurrency)) {
            throw new LocalizedException(__($this::ERROR_CURRENCY));
        }

        return true;
    }
}
