<?php
/**
 * This file is part of the Compos Mentis Inc.
 * PHP version 7+ (c) 2017 CMI
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 *
 * @category Class
 * @package  Asiapay
 * @author   Joussyd Calupig <joussydmcalupig@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
namespace Redscript\AsiaPay;

/**
 * Factory Class
 *
 * PHP version 7+
 *
 * @category Class
 * @author   Joussyd Calupig <joussydmcalupig@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
class Order extends Factory
{
    /* Constant Properties
    -------------------------------*/
    /* Protected Properties
    -------------------------------*/
    protected $payref = null;
    /* Private Properties
    -------------------------------*/
    /* Get
    -------------------------------*/
    /* Magic
    -------------------------------*/
    /* Public Methods
    -------------------------------*/
    /* Protected Methods
    -------------------------------*/
    /* Public Methods
    -------------------------------*/
    /**
     * 
     * @param string $clientId      The Merchant ID
     * @param string $payRef        Payment Reference Number
     * @param string $amount        Transaction Amount
     * @return string
     */
    public function __construct($merchantId, $loginId, $password, $payRef, $amount)
    {
        $this->merchantId = $merchantId;
        $this->loginId    = $loginId;
        $this->password   = $password;
        $this->payRef     = $payRef;
        $this->amount     = $amount;
    }

    /**
     * Merchant API
     *
     * @param string $actioonType   Action Type(Capture,VoidRefundRequest,Query)
     * @param string $live          Request Type(*live or testing)
     * @return string
     */
    public function api($actionType, $live = false)
    {
        // set api URL
        if($live) {
            $url = self::API_PROD_URL;
        }else{
            $url = self::API_TEST_URL;
        }

        // build params array
        $params = array(
            'merchantId' => $this->merchantId,
            'loginId'    => $this->loginId,
            'password'   => $this->password,
            'actionType' => $actionType,
            'payRef'     => $this->payRef,
            'amount'     => $this->amount,
        );

        // build query
        $postData = http_build_query($params);

        // set headers
        $httpHeader = array(
            "cache-control: no-cache",
            "content-type: application/x-www-form-urlencoded"
        );

        // create settings
        $settings = array(
            'url'        => $url,
            'postData'   => $postData,
            'httpHeader' => $httpHeader
        );
        // send request
        $response = $this->sendRequest($settings);

        return $response;
    }
}