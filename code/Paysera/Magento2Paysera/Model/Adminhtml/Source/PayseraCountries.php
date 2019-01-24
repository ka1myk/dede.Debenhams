<?php
namespace Paysera\Magento2Paysera\Model\Adminhtml\Source;

use WebToPay;

class PayseraCountries
{
    const PAYSERA_AMMOUNT  = '1000';
    const PAYSERA_CURRENCY = 'EUR';
    const PAYSERA_LANG     = 'en';

    public function getPayseraCountries($project, $currency, $lang)
    {
        $countries = WebToPay::getPaymentMethodList(
            $project,
            $currency
        )->setDefaultLanguage(
            $lang
        )->getCountries();

        return $countries;
    }

    public function getCountriesList($countries)
    {
        $countriesList = [];

        foreach ($countries as $country) {
            $countriesList[] = [
                'value' => $country->getCode(),
                'label' => $country->getTitle()
            ];
        }

        return $countriesList;
    }

    public function toOptionArray()
    {
        $payseraCountries = $this->getPayseraCountries(
            $this::PAYSERA_AMMOUNT,
            $this::PAYSERA_CURRENCY,
            $this::PAYSERA_LANG
        );

        $options = $this->getCountriesList($payseraCountries);

        return $options;
    }
}
