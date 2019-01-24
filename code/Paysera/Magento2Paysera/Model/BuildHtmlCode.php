<?php
namespace Paysera\Magento2Paysera\Model;

class BuildHtmlCode
{
    const EMPTY_CODE     = '';
    const DELIMETER      = ',';
    const FIELD_SELECTED = 'selected';
    const CODE_OTHER     = 'other';

    protected function getDefaultLangCode(
        $countries,
        $countryCode
    ) {
        $countryCodes = [];

        foreach ($countries as $country) {
            $countryCodes[] = $country['code'];
        }

        if (in_array($countryCode, $countryCodes)) {
            $defaultLang = $countryCode;
        } elseif (in_array($this::CODE_OTHER, $countryCodes)) {
            $defaultLang = $this::CODE_OTHER;
        } else {
            $defaultLang = reset($countries)['code'];
        }

        return $defaultLang;
    }

    public function buildCountriesList(
        $countries,
        $billingCountryCode
    ) {
        $defaultLangCode = $this->getDefaultLangCode(
            $countries,
            $billingCountryCode
        );

        $selectionField      = '<select id="paysera_country" 
                                   class="payment-country-select" >';

        foreach ($countries as $country) {
            if ($country['code'] == $defaultLangCode) {
                $selected = $this::FIELD_SELECTED;
            } else {
                $selected = $this::EMPTY_CODE;
            }

            $selectionField .= '<option value="'
                . $country['code'] . '" '
                . $selected
                . '>';
            $selectionField .= $country['title'];
            $selectionField .= '</option>';
        }

        $selectionField     .= '</select>';

        return $selectionField;
    }

    public function buildMethodsList(
        $methods,
        $countryCode
    ) {
        $paymentMethodCode = $this::EMPTY_CODE;

        foreach ($methods as $method) {
            $paymentMethodCode .= '<div id="' . $method->getKey() . '" ';
            $paymentMethodCode .= 'class="payment" style="margin-bottom:15px">';

            $paymentMethodCode .= '<label>';
            $paymentMethodCode .= '<input class="rd_pay" ';
            $paymentMethodCode .= 'type="radio" ';
            $paymentMethodCode .= 'rel="r' . $countryCode . $method->getKey() . '" ';
            $paymentMethodCode .= 'name="payment[pay_type]" ';
            $paymentMethodCode .= 'value="' . $method->getKey() . '" /> &nbsp;';

            $paymentMethodCode .= '<span class="paysera-image">';
            $paymentMethodCode .= '<img src="' . $method->getLogoUrl() . '" ';
            $paymentMethodCode .= 'alt="' . $method->getTitle() . '" ';
            $paymentMethodCode .= 'style="margin-right:10px;" />';
            $paymentMethodCode .= '</span>';

            $paymentMethodCode .= '<span class="paysera-text">';
            $paymentMethodCode .= $method->getTitle();
            $paymentMethodCode .= '</span>';

            $paymentMethodCode .= '</label>';
            $paymentMethodCode .= '</div>';
        }

        return $paymentMethodCode;
    }

    public function buildGroupList(
        $groups,
        $countryCode
    ) {
        $paymentGroupCode = $this::EMPTY_CODE;

        foreach ($groups as $group) {
            $paymentGroupCode .= '<div class="payment-group-wrapper">';

            $paymentGroupCode .= '<div class="payment-group-title" ';
            $paymentGroupCode .= 'style="font-weight:bold; margin-bottom:15px;">';
            $paymentGroupCode .= $group->getTitle();
            $paymentGroupCode .= '</div>';

            $paymentGroupCode .= $this->buildMethodsList(
                $group->getPaymentMethods(),
                $countryCode
            );
            $paymentGroupCode .= '</div>';
        }

        return $paymentGroupCode;
    }

    public function buildPaymentsList(
        $countries,
        $gridViewIsActive,
        $billingCountryCode
    ) {
        $paymentsCode = $this::EMPTY_CODE;

        if ((bool)$gridViewIsActive) {
            $paymentsCode .= $this->buildGridStyle();
        }

        $defaultLangCode = $this->getDefaultLangCode(
            $countries,
            $billingCountryCode
        );

        foreach ($countries as $country) {
            $paymentsCode     .= '<div id="' . $country['code'] . '" ';
            $paymentsCode     .= 'class="payment-countries paysera-payments"';
            $paymentsCode     .= 'style="display:';
            if (($country['code'] == $defaultLangCode)) {
                $paymentsCode .= 'block';
            } else {
                $paymentsCode .= 'none';
            }
            $paymentsCode     .= '">';

            $paymentsCode     .= $this->buildGroupList(
                                     $country['groups'],
                                     $country['code']
                                 );

            $paymentsCode     .= '</div>';
        }

        return $paymentsCode;
    }

    public function buildGridStyle()
    {
        $style = '<style>';

        $style .= 'div.paysera-payments input[type="radio"],
                div.paysera-payments span.paysera-text,
                div.paysera-payments .payment-group-wrapper br {
                    display:none;
                }';

        $style .= 'div.payment-group-title{
                    clear:both;
                }';

        $style .= 'div.paysera-payments span.paysera-image{
                    float:left;
                    border: 2px  outset  transparent;
                    padding:12px 10px 6px 10px;
                }';

        $style .= 'div.paysera-payments div.payment{
                    float:left;
                }';

        $style .= 'div.paysera-payments input[type="radio"]:hover
                + span.paysera-image img {
                    cursor:pointer;
                }';

        $style .= 'div.paysera-payments input[type="radio"]:checked
                + span.paysera-image {
                    border: 2px  outset  silver;
                }';

        $style .= '</style>';

        return $style;
    }
}
