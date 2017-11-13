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
    protected $merchantId    = null;
    protected $amount        = null;
    protected $orderRef      = null;
    protected $currCode      = null;
    protected $mpsMode       = null;
    protected $successUrl    = null;
    protected $failedUrl     = null;
    protected $cancelUrl     = null;
    protected $paymentType   = 'N';
    protected $languange     = 'E';
    protected $paymentMethod = 'ALL';
    protected $secureHash    = null;

    /* Public Methods
    -------------------------------*/
     /**
     * Checkout Method
     *
     * @param string $merchantId Merchant's ID
     * @param string $live       
     * @return Auth class
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
            'paymentType'       => $paymentMethod,
            'secureHashSecret'  => $secureHash
        );

        // convert array to pipe "|" delimited string
        $signingData = implode('|', $params);

        // sign the data using sha-1
        $secureHash = sha1($signingData);

        return $secureHash;
    }
}