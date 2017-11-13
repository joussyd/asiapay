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
use DOMDocument;

/**
 * Factory Class
 *
 * PHP version 7+
 *
 * @category Class
 * @author   Joussyd Calupig <joussydmcalupig@gmail.com>
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
    protected $merchantId       = null;
    protected $secureHashSecret = null;
    protected $amount           = null;
    protected $orderRef         = null;
    protected $currCode         = null;
    protected $mpsMode          = null;
    protected $successUrl       = null;
    protected $failedUrl        = null;
    protected $cancelUrl        = null;
    protected $paymentType      = 'N';
    protected $languange        = 'E';
    protected $live             = false;
    protected $paymentMethod    = 'ALL';

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
     * Generate Form for submittion of checkout details
     * 
     *
     * @return html
     */
    public function generateForm($useButton = false)
    {
        // generate hash
        $secureHash = $this->generateHash(
                        $this->merchantId, $this->orderRef,
                        $this->currCode, $this->amount,
                        $this->paymentType, $this->secureHashSecret
                    );

        // get form values
        $formValues = array(
            'merchantId' => $this->merchantId,
            'amount'     => $this->amount,
            'orderRef'   => $this->orderRef,
            'currCode'   => $this->currCode,
            'mpsMode'    => $this->mpsMode,
            'successUrl' => $this->successUrl,
            'failUrl'    => $this->failUrl,
            'cancelUrl'  => $this->cancelUrl,
            'payType'    => $this->paymentType,
            'lang'       => $this->languange,
            'payMethod'  => $this->paymentMethod,
            'secureHash' => $secureHash
        );

        // check if the transaction is for testing or production
        if($this->live) {
            // set form action to production url
            $formAction = self::PROD_PAYMENT_URL;
        }else {
            // set form action to test url
            $formAction = self::TEST_PAYMENT_URL;
        }

        // create DOM
        $dom = new DOMDocument('1.0');
        // create form
        $form = $dom->createElement('form');

        // create a name attribute for the form
        $actionAttribute = $dom->createAttribute('action');
        // set name attribute value
        $actionAttribute->value = $formAction;

        // create a name attribute for the form
        $methodAttribute = $dom->createAttribute('method');
        // set name attribute value
        $methodAttribute->value = 'POST';

        // append action attribute to the form
        $form->appendChild($actionAttribute);
        $form->appendChild($methodAttribute);

        // loop through each key and value then create an input field
        foreach ($formValues as $key => $value) {

            // crete an input element
            $input = $dom->createElement('input');
            // create a name attribute

            $nameAttribute = $dom->createAttribute('name');
            // set name attribute value
            $nameAttribute->value = $key;

            // create a value attribute
            $valueAttribute = $dom->createAttribute('value');
            // set value attribute value
            $valueAttribute->value = $value;

            // create a value attribute
            $typeAttribute = $dom->createAttribute('type');
            // set value attribute value
            $typeAttribute->value = 'hidden';

            // append attributes in the input element
            $input->appendChild($nameAttribute);
            $input->appendChild($valueAttribute);
            $input->appendChild($typeAttribute);

            // append the input in the form
            $form->appendChild($input);
        }

        if($useButton) {
            // creqte submit button
            $submit = $dom->createElement('input');
            // create a name attribute

            $nameAttribute = $dom->createAttribute('name');
            // set name attribute value
            $nameAttribute->value = 'submit';
            // create a name attribute

            $typeAttribute = $dom->createAttribute('type');
            // set name attribute value
            $typeAttribute->value = 'submit';

            // append submit attributes
            $submit->appendChild($nameAttribute);
            $submit->appendChild($typeAttribute);

            // append submit to the form
            $form->appendChild($submit);
        }

        // append form in the created DOM
        $dom->appendChild($form);

        return $dom->saveHTML();
    }

    /* Protected Properties
    -------------------------------*/
    /**
     * Set Amount
     *
     * @param float $amount The total amount you want to charge the customer
     *                      for the provided currency 
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Set Order Reference
     * 
     * @param string $orderRef Merchant‘s Order Reference Number
     * @return $this
     */
    public function setOrderReference($orderRef)
    {
        $this->orderRef = $orderRef;

        return $this;
    }

    /**
     * Set Currency Code
     * 
     * @param int $currCode Transaction Currency
     * @return $this
     */
    public function setCurrencyCode($currCode)
    {
        $this->currCode = $currCode;

        return $this;
    }

    /**
     * Set Multi-Currency Processing Service Mode
     * 
     * @param string $mpsMode Transaction Currency
     * @return $this
     */
    public function setMpsMode($mpsMode)
    {
        $this->mpsMode = $mpsMode;

        return $this;
    }

    /**
     * Set Success URL
     * 
     * @param string $successUrl  A Web page address to redirect upon 
     *                            the transaction being accepted by asiapay
     * @return $this
     */
    public function setSuccessUrl($successUrl)
    {
        $this->successUrl = $successUrl;

        return $this;
    }

    /**
     * Set Failed URL
     * 
     * @param string $failUrl  A Web page address to redirect upon 
     *                         the transaction being rejected by asiapay
     * @return $this
     */
    public function setFailUrl($failUrl)
    {
        $this->failUrl = $failUrl;

        return $this;
    }

    /**
     * Set Cancel URL
     * 
     * @param string $cancelUrl  A Web page address to redirect upon 
     *                           the transaction being cancelled by customer
     * @return $this
     */
    public function setCancelUrl($cancelUrl)
    {
        $this->cancelUrl = $cancelUrl;

        return $this;
    }

    /**
     * Set Payment Type
     * 
     * @param string $paymentType  Payment Type
     *
     * @return $this
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Set Languange
     * 
     * @param string $languange  The languange of the payment page
     *
     * @return $this
     */
    public function setLanguange($languange)
    {
        $this->languange = $languange;

        return $this;
    }

    /**
     * Set Payment Method
     * 
     * @param string $paymentMethod The Payment Method
     *
     * @return $this
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }
}