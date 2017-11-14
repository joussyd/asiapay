<?php
/**
 * This file is part of the Compos Mentis Inc.
 * PHP version 7+ (c) 2017 CMI
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 *
 * @category Class
 * @package  AsiaPay
 * @author   Joussyd Calupig <joussydmcalupig@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

namespace Redscript\AsiaPay;
use Redscript\AsiaPay\Checkout;
use Redscript\AsiaPay\Order;

/**
 * Factory Class
 *
 * PHP version 7+
 *
 * @category Factory
 * @author   Joussyd Calupig <joussydmcalupig@get_magic_quotes_gpc()l.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
class Factory extends Base
{
    /* Constants
    -------------------------------*/
    const TEST_PAYMENT_URL = 'https://test.pesopay.com/b2cDemo/eng/payment/payForm.jsp';
    const PROD_PAYMENT_URL = 'https://www.pesopay.com/b2c2/eng/payment/payForm.jsp';
    const API_TEST_URL     = 'https://test.pesopay.com/b2cDemo/eng/merchant/api/orderApi.jsp';
    const API_PROD_URL     = 'https://www.pesopay.com/b2c2/eng/merchant/api/orderApi.jsp';
    /* Private Properties
    -------------------------------*/
    /* Get
    -------------------------------*/
    /* Magic
    -------------------------------*/
    /* Protected Methods
    -------------------------------*/
    /* Protected Properties
    -------------------------------*/
    /* Public Methods
    -------------------------------*/
     /**
     * Checkout Method
     *
     * @param string $merchantId       Merchant's ID
     * @param string $secureHashSecret Hash secret provided by asiapay
     * @param string $live             live or testing
     * @return Checkout class
     */
    public function checkout($merchantId, $secureHashSecret, $live = false)
    {
        return new Checkout($merchantId, $secureHashSecret, $live);
    }

    /**
     * Generate Hash
     *
     * @param string $merchantId        Merchant's ID
     * @param string $merchantReference Merchant's Reference or Order Reference
     * @param string $currencyCode      Currency Code of the payment
     * @param string $amount            Amount based on the indicated currency
     * @param string $paymentType       Payment Type
     * @param string $secureHashSecret  Secure Hash secret provided by asia pay on merchants
     * @return secureHash
     */
    public function generateHash(
        $merchantId, $merchantReference,
        $currencyCode, $amount,
        $paymentType, $secureHashSecret
    )
    {
        // arrange hash generation parameters
        $params = array(
            'merchantId'        => $merchantId,
            'merchantReference' => $merchantReference,
            'currencyCode'      => $currencyCode,
            'amount'            => $amount,
            'paymentType'       => $paymentType,
            'secureHashSecret'  => $secureHashSecret
        );

        // convert array to pipe "|" delimited string
        $signingData = implode('|', $params);

        // sign the data using sha-1
        $secureHash = sha1($signingData);

        return $secureHash;
    }

    /**
     * 
     * @param string $merchantId    The Merchant ID
     * @param string $loginId       api login id provided by asiapay
     * @param string $password      api password provided by asiapay
     * @param string $payRef        Payment Reference from the datafeed
     * @param string $amount        Transaction Amount
     * @return Order class
     */
    public function order($merchantId, $loginId, $password, $payRef, $amount)
    {
        return new Order($merchantId, $loginId, $password, $payRef, $amount);
    }

    /**
     * Send Curl Request
     *
     * @param  array $settings The request's URL,Post Data and or Http Header
     * @return json
     */
    public function sendRequest($settings)
    {
        // initiate  request
        $curl = curl_init($settings['url']);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS,10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $settings['postData']);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $settings['httpHeader']);

        // send request then decode the returned json string
        $response = curl_exec($curl);

        // close the connection
        curl_close($curl);

        return $response; 
    }
}