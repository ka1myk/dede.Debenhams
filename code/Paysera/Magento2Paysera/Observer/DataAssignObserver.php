<?php
namespace Paysera\Magento2Paysera\Observer;

use Magento\Framework\DataObject;
use Magento\Framework\Event\Observer;
use Magento\Framework\Exception\LocalizedException;
use Magento\Payment\Observer\AbstractDataAssignObserver;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Payment\Model\InfoInterface;
use Paysera\Magento2Paysera\Helper\Data;

class DataAssignObserver extends AbstractDataAssignObserver
{
    const PAYSERA_PAYMENT_METHOD = 'paysera_payment_method';
    const PAYSERA_TYPE           = 'paysera_payment_type';

    protected $_helper;

    public function __construct(
        Data $helper
    ) {
        $this->_helper = $helper;
    }

    public function execute(Observer $observer)
    {
        $data = $this->readDataArgument($observer);

        $additionalData = $data->getData(
            PaymentInterface::KEY_ADDITIONAL_DATA
        );

        if (!is_array($additionalData)) {
            return;
        }

        $additionalDataObject = new DataObject($additionalData);
        $paymentMethod = $this->readMethodArgument($observer);

        $payment = $observer->getPaymentModel();
        if (!$payment instanceof InfoInterface) {
            $payment = $paymentMethod->getInfoInstance();
        }

        if (!$payment instanceof InfoInterface) {
            throw new LocalizedException(__('Payment model does not provided.'));
        }

        $paymentType = $additionalDataObject->getData(
            $this::PAYSERA_PAYMENT_METHOD
        );

        $this->setSelectedData($this::PAYSERA_TYPE, $paymentType);
    }

    protected function setSelectedData($key, $value)
    {
        return $this->_helper->setSessionData($key, $value);
    }
}
