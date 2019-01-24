<?php
namespace Paysera\Magento2Paysera\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Paysera\Magento2Paysera\Helper\Data;
use WebToPay;

class PayseraConfigProvider implements ConfigProviderInterface
{
    const EMPTY_CODE           = '';
    const DELIMETER            = ',';

    const EXTRA_CONF           = 'paysera_extra';
    const PAY_TITLE            = 'title';
    const PAY_DESCRIPTION      = 'description';
    const PAY_ALL_COUNTRIES    = 'allowspecific';
    const PAY_SELECT_COUNTRIES = 'specificcountry';
    const PAY_GRID             = 'grid';
    const PAY_LIST             = 'payment_list';
    const REDIRECT             = 'payseraRedirectUrl';

    const COUNTRY_SELECT_MIN   = 1;
    const LOGO_URL             = 'https://www.paysera.lt/f/logotipas_internetui.png';
    const LINE_BREAK           = '<div style="clear:both"><br /></div>';

    protected $_helper;

    public function __construct(Data $helper)
    {
        $this->_helper = $helper;
    }

    public function getConfig()
    {
        $config = [
            'payment' => [
                'paysera' => [
                    'title' => $this->getExtraConfig(
                        $this::EXTRA_CONF,
                        $this::PAY_TITLE
                    ),
                    'logo'            => $this::LOGO_URL,
                    'countries'       => $this->getPayseraPayments(),
                    'pageBaseUrl'     => $this->getPageUrl(),
                ]
            ]
        ];
        return $config;
    }

    protected function getPageUrl()
    {
        $url = $this->_helper->getPageBaseUrl();

        return $url;
    }

    protected function getOrderAmmount()
    {
        $total = $this->_helper->getTotalAmmount() * 100;

        return $total;
    }

    protected function getOrderCurrency()
    {
        $currencyCode = $this->_helper->getOrderCurrencyCode();

        return $currencyCode;
    }

    protected function getOrderCountryCode()
    {
        $countryCode = $this->_helper->getOrderCountryCode();

        return $countryCode;
    }

    protected function getStoreLang()
    {
        $languageCode = $this->_helper->getStoreLangCode();

        return $languageCode;
    }

    protected function getExtraConfig($group, $name)
    {
        return $this->_helper->getExtraConf($group, $name);
    }

    protected function getPayseraCountries($project, $currency, $lang)
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

        $showSelectedCountries = $this->getExtraConfig(
            $this::EXTRA_CONF,
            $this::PAY_ALL_COUNTRIES
        );

        $selectedCountriesList = $this->getExtraConfig(
            $this::EXTRA_CONF,
            $this::PAY_SELECT_COUNTRIES
        );

        $selectedCountriesCodes = explode(
            $this::DELIMETER,
            $selectedCountriesList
        );

        foreach ($countries as $country) {
            if (!(bool)$showSelectedCountries
                || in_array($country->getCode(), $selectedCountriesCodes)
            ) {
                $countriesList[] = [
                    'code'   => $country->getCode(),
                    'title'  => $country->getTitle(),
                    'groups' => $country->getGroups()
                ];
            }
        }

        return $countriesList;
    }

    protected function getPayseraPayments()
    {
        $buildHtml = new BuildHtmlCode();

        $billingCountryCode = $this->getOrderCountryCode();

        $displayGridView = $this->getExtraConfig(
            $this::EXTRA_CONF,
            $this::PAY_GRID
        );

        $showInPage = $this->getExtraConfig(
            $this::EXTRA_CONF,
            $this::PAY_LIST
        );

        if ((bool)$showInPage) {
            $payseraCountries = $this->getPayseraCountries(
                $this->getOrderAmmount(),
                $this->getOrderCurrency(),
                $this->getStoreLang()
            );

            $countries = $this->getCountriesList($payseraCountries);

            if (count($countries) > $this::COUNTRY_SELECT_MIN) {
                $paymentsHtml = $buildHtml->buildCountriesList(
                    $countries,
                    $billingCountryCode
                );
                $paymentsHtml .= $this::LINE_BREAK;
            } else {
                $paymentsHtml = $this::EMPTY_CODE;
            }

            $paymentsHtml .= $buildHtml->buildPaymentsList(
                $countries,
                $displayGridView,
                $billingCountryCode
            );
            $paymentsHtml .= $this::LINE_BREAK;
        } else {
            $paymentsHtml = $this->getExtraConfig(
                $this::EXTRA_CONF,
                $this::PAY_DESCRIPTION
            );
        }

        return $paymentsHtml;
    }
}
