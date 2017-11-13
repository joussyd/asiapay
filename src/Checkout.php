<?php
/**
 * This file is part of the Compos Mentis Inc.
 * PHP version 7+ (c) 2017 CMI
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 *
 * @category Class
 * @package  Auth
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
 * @author   Joussyd Calupig <joussydmcalupig@get_magic_quotes_gpc()l.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
class Checkout extends Factory
{
    /* Constant Properties
    -------------------------------*/
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
     * @param string $clientSecret  The Secure Hash Secret provided by AsiaPay
     * @param string $live          Request Type
     * @return string
     */
    public function __construct($merchantId, $secureHashSecret, $live)
    {
        $this->merchantId       = $merchantId;
        $this->secureHashSecret = $secureHashSecret;
        $this->live             = $live;
    }

    /**
     * Generate Form
     * 
     * @param 
     *
     * @return 
     */
    public function generateForm()
    {
        echo $this->merchantId;
        echo $this->merchantReference;
        echo $this->currencyCode;
        echo $this->amount;
        echo $this->paymentMethod;
        echo $this->secureHash;
        exit;
    }

    /* Protected Properties
    -------------------------------*/
    /**
     * Set Amount
     *
     * @param float $amount The total amount you want to charge the customer
     *                      for the provided currency 
     * @return 
     */
    protected function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Set Order Reference
     * 
     * @param string $orderRef Merchant‘s Order Reference Number
     * @return 
     */
    protected function setOrderReference($orderRef)
    {
        $this->orderRef = $orderRef;

        return $this;
    }

    /**
     * Set Currency Code
     * 
     * @param int $currCode Transaction Currency
     * @return 
     */
    protected function setCurrencyCode($currCode)
    {
        $this->currCode = $currCode;

        return $this;
    }

    /**
     * Set Multi-Currency Processing Service Mode
     * 
     * @param string $mpsMode Transaction Currency
     * @return 
     */
    protected function setMpsMode($mpsMode)
    {
        $this->mpsMode = $mpsMode;

        return $this;
    }

    /**
     * Set Success URL
     * 
     * @param string $successUrl  A Web page address to redirect upon 
     *                            the transaction being accepted by asiapay
     * @return 
     */
    protected function setSuccessUrl($successUrl)
    {
        $this->successUrl = $successUrl;

        return $this;
    }

    /**
     * Set Failed URL
     * 
     * @param string $failUrl  A Web page address to redirect upon 
     *                         the transaction being rejected by asiapay
     * @return 
     */
    protected function setFailUrl($failUrl)
    {
        $this->failUrl = $failUrl;

        return $this;
    }

    /**
     * Set Cancel URL
     * 
     * @param string $cancelUrl  A Web page address to redirect upon 
     *                           the transaction being cancelled by customer
     * @return 
     */
    protected function setCancelUrl($cancelUrl)
    {
        $this->cancelUrl = $cancelUrl;

        return $this;
    }

    /**
     * Set Payment Type
     * 
     * @param string $paymentType  Payment Type
     *
     * @return 
     */
    protected function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Set Languange
     * 
     * @param string $languange  The languange of the payment page
     *
     * @return 
     */
    protected function setLanguange($languange)
    {
        $this->languange = $languange;

        return $this;
    }

    /**
     * Set Payment Method
     * 
     * @param string $paymentMethod The Payment Method
     *
     * @return 
     */
    protected function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }
}