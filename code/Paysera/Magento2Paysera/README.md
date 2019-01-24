magento-2.x-paysera-1-6
=======================

Version: 3.0.2

Contributors: Paysera

Tags: online payment, payment, payment gateway, SMS payments, international payments, mobile payment, sms pay, payment by sms, billing system, payment institution, macro payments, micro payments, sms bank

Requires at least: 2.1

Tested up to: 2.2.6

Requirements: Magento

License: GPLv3

License URL: http://www.gnu.org/licenses/gpl-3.0.html


Description
-----------

Collecting payments with Paysera is simple, fast and secure. It is enough to open Paysera account, install the plug-in to your store and you will be able to use all of the most popular ways of payment collection in one place.
No need for complicated programming or integration work. With Paysera you will receive real time notifications about successful transactions in your online store, and the money will reach you sooner.
No monthly, registration or connection fee.

It is simple to use and administer payment collection, and you can monitor movement of funds in your smartphone.
Client services and consultation takes place 7 days a week, from 8:00 till 20:00 (EET)
Payments are made in real time.

Paysera applies the lowest fees on the market, and payments from foreign banks and systems are converted at best possible rates.

To use this plugin, register at paysera.com and create your project. You will get your project ID and signature, which should be written in this plugin settings.


Installation
------------	

-= Installation by FTP =-

1. Download Paysera module zip.

2. Connect to server and go to Magento base directory.

3. Go to folder:
    /app/code
	
    If folder 'code' doesn't exsists, create it.	

4. Create folder 'Paysera' and open it;

5. Extract content of Paysera plugin zip file.

6. Open Terminal and go do to base directory of Magento and enter this commands:

    composer require "webtopay/libwebtopay":"1.6.*"
    
    php bin/magento setup:upgrade
    
    php bin/magento setup:di:compile	
	
7. Connect to Magento Admin panel.

8. Configure Paysera module in Magento Admin panel:
    Stores -> Configuration -> Sales -> Payment Methods -> Paysera
 
9. Save changes.


Version history
---------------

Version 3.0.2   - 2018-11-08

    * Code fixes

Version 3.0.1   - 2017-10-23

    * Code fixes

Version 3.0.0   - 2017-10-16

    * Initial release


Support
-------

For any questions, please look for the answers at https://support.paysera.com or contact customer support center by email  support@paysera.com or by phone +44 20 80996963 | +370 700 17217.

For technical documentation visit: https://developers.paysera.com/
