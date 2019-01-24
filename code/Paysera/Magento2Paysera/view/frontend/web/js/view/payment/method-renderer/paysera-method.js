/*browser:true*/
/*global define*/
define(
    [
        'jquery',
        'Magento_Checkout/js/view/payment/default',
        'Magento_Checkout/js/action/place-order',
        'Magento_Checkout/js/action/select-payment-method',
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/checkout-data',
        'Magento_Checkout/js/model/payment/additional-validators',
        'mage/url',
    ],
    function (
        $,
        Component,
        placeOrderAction,
        selectPaymentMethodAction,
        customer,
        checkoutData,
        additionalValidators,
        url
    ) {
        'use strict';

        var countryId;
        $(document).on('change', '#paysera_country' ,function () {
            countryId = $('#paysera_country').val();
            $('.payment-countries').css('display', 'none');
            $('#'+countryId).css('display', 'block');
        });

        $(window).bind('hashchange', function () {
            var hash = window.location.hash.slice(1);
            if(hash === "payment") {
                updatePayerCountry();
            }
        });

        updatePayerCountry();

        var paymentId;
        $(document).on('click', '.payment' ,function () {
            paymentId = this.id;
        });

        var data;

        function updatePayerCountry() {
            var selectedCountryId, payseraCountriesOption, otherCountryId, possibleCountries, selector;

            selectedCountryId = $('select[name="country_id"]').find(':selected').val();
            payseraCountriesOption = $('#paysera_country option');
            otherCountryId = "other";

            possibleCountries = $.map(payseraCountriesOption, function (option) {
                return option.value;
            });

            selectedCountryId = selectedCountryId.toLowerCase();

            selector = $.inArray(selectedCountryId, possibleCountries) === -1 ?
                ($.inArray(otherCountryId, possibleCountries) === -1 ? possibleCountries[0] : otherCountryId) :
                selectedCountryId
            ;

            $('#paysera_country option[value="' + selector + '"]').prop('selected', true);
            $('.payment-countries').css('display', 'none');
            $('#' + selector).css('display', 'block');
        }

        return Component.extend({
            defaults: {
                template: 'Paysera_Magento2Paysera/paysera'
            },

            getTitle: function () {
                return window.checkoutConfig.payment.paysera.title;
            },

            getData: function () {
                data = {
                    'method': this.getCode(),
                    'additional_data': {
                        'paysera_payment_method': paymentId
                    }
                };

                return data;
            },

            placeOrder: function (data, event) {
                if (event) {
                    event.preventDefault();
                }
                var self = this,
                    placeOrder,
                    emailValidationResult = customer.isLoggedIn(),
                    loginFormSelector = 'form[data-role=email-with-possible-login]';
                if (!customer.isLoggedIn()) {
                    $(loginFormSelector).validation();
                    emailValidationResult = Boolean($(loginFormSelector + ' input[name=username]').valid());
                }
                if (emailValidationResult && this.validate() && additionalValidators.validate()) {
                    this.isPlaceOrderActionAllowed(false);
                    placeOrder = placeOrderAction(this.getData(), false, this.messageContainer);

                    $.when(placeOrder).fail(function () {
                        self.isPlaceOrderActionAllowed(true);
                    }).done(this.afterPlaceOrder.bind(this));
                    return true;
                }
                return false;
            },

            selectPaymentMethod: function () {
                selectPaymentMethodAction(this.getData());
                checkoutData.setSelectedPaymentMethod(this.item.method);
                return true;
            },

            afterPlaceOrder: function () {
                var xmlhttp = new XMLHttpRequest();
                var url = window.checkoutConfig.payment.paysera.pageBaseUrl+"/paysera";

                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        var response = JSON.parse(xmlhttp.responseText);
                        window.location.href = response['url'];
                    }
                };
                xmlhttp.open("GET", url, true);
                xmlhttp.send();
            },

            getPaymentMarkSrc: function () {
                return window.checkoutConfig.payment.paysera.logo;
            },

            getCountriesSelection: function () {
                return window.checkoutConfig.payment.paysera.countries;
            }
        });
    }
);
