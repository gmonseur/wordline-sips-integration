<?php

namespace Sips;

use \InvalidArgumentException;
use Sips\ShaComposer\ShaComposer;

class PaymentResponse
{
    /** @var string */
    const SHASIGN_FIELD = "SEAL";

    /** @var string */
    const DATA_FIELD = "DATA";

    private $sipsFields = array(
        "captureDay", "captureMode", "currencyCode", "merchantId",
        "orderChannel", "responseCode", "transactionDateTime", "transactionReference",
        "keyVersion", "acquirerResponseCode", "amount", "authorisationId",
        "guaranteeIndicator", "cardCSCResultCode", "panExpiryDate", "paymentMeanBrand",
        "paymentMeanType", "complementaryCode", "complementaryInfo", "customerIpAddress",
        "maskedPan", "merchantTransactionDateTime", "scoreValue", "scoreColor", "scoreInfo",
        "scoreProfile", "scoreThreshold", "holderAuthentRelegation", "holderAuthentStatus",
        "transactionOrigin", "paymentPattern","customerMobilePhone","mandateAuthentMethod",
        "mandateUsage","transactionActors", "mandateId","captureLimitDate","dccStatus",
        "dccResponseCode","dccAmount","dccCurrencyCode","dccExchangeRate", "dccExchangeRateValidity",
        "dccProvider","statementReference","panEntryMode","walletType","holderAuthentMethod"
    );

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var string
     */
    private $shaSign;

    private $dataString;

    /**
     * @param array $httpRequest Typically $_REQUEST
     * @throws \InvalidArgumentException
     */
    public function __construct(array $httpRequest)
    {
        // use lowercase internally
        $httpRequest = array_change_key_case($httpRequest, CASE_UPPER);

        // set sha sign
        $this->shaSign = $this->extractShaSign($httpRequest);

        // filter request for Sips parameters
        $this->parameters = $this->filterRequestParameters($httpRequest);
    }

    /**
     * Filter http request parameters
     * @param array $requestParameters
     */
    private function filterRequestParameters(array $httpRequest)
    {
        //filter request for Sips parameters
        if (!array_key_exists(self::DATA_FIELD, $httpRequest) || $httpRequest[self::DATA_FIELD] == '') {
            throw new InvalidArgumentException('Data parameter not present in parameters.');
        }
        $parameters = array();
        $dataString = $httpRequest[self::DATA_FIELD];
        $this->dataString = $dataString;
        $dataParams = explode('|', $dataString);
        foreach ($dataParams as $dataParamString) {
            $dataKeyValue = explode('=', $dataParamString, 2);
            $parameters[$dataKeyValue[0]] = $dataKeyValue[1];
        }

        return $parameters;
    }

    public function getSeal()
    {
        return $this->shaSign;
    }

    private function extractShaSign(array $parameters)
    {
        if (!array_key_exists(self::SHASIGN_FIELD, $parameters) || $parameters[self::SHASIGN_FIELD] == '') {
            print_r($parameters);
            //throw new InvalidArgumentException('SHASIGN parameter not present in parameters.');
        }
        return $parameters[self::SHASIGN_FIELD];
    }

    /**
     * Checks if the response is valid
     * @param ShaComposer $shaComposer
     * @return bool
     */
    public function isValid(ShaComposer $shaComposer)
    {
        return $shaComposer->compose($this->parameters) == $this->shaSign;
    }

    /**
     * Retrieves a response parameter
     * @param string $param
     * @throws \InvalidArgumentException
     */
    public function getParam($key)
    {
        if (method_exists($this, 'get'.$key)) {
            return $this->{'get'.$key}();
        }

        // always use uppercase
        $key = strtoupper($key);
        $parameters = array_change_key_case($this->parameters, CASE_UPPER);
        if (!array_key_exists($key, $parameters)) {
            throw new InvalidArgumentException('Parameter ' . $key . ' does not exist.');
        }

        return $parameters[$key];
    }

    /**
     * @return int Amount in cents
     */
    public function getAmount()
    {
        $value = trim($this->parameters['amount']);
        return (int) ($value);
    }

    /**
     * @return string
     */
    public function getResponseMsg()
    {

        if($this->getParam('RESPONSECODE') == "00"){
            $message = '(Code 00) Authorisation accepted';
        }else if($this->getParam('RESPONSECODE') == "02"){
            $message = '(Code 02) Authorisation request to be performed via telephone with the issuer, as the card authorisation threshold has been exceeded, if the forcing is authorised for the merchant';
        }else if($this->getParam('RESPONSECODE') == "03"){
            $message = '(Code 03) Invalid distance selling contract';
        }else if($this->getParam('RESPONSECODE') == "05"){
            $message = '(Code 05) Authorisation refused';
        }else if($this->getParam('RESPONSECODE') == "12"){
            $message = '(Code 12) Invalid transaction, verify the parameters transferred in the request.';
        }else if($this->getParam('RESPONSECODE') == "14"){
            $message = '(Code 14) invalid bank details or card security code';
        }else if($this->getParam('RESPONSECODE') == "17"){
            $message = '(Code 17) Buyer cancellation';
        }else if($this->getParam('RESPONSECODE') == "24"){
            $message = '(Code 24) Operation impossible. The operation the merchant wishes to perform is not compatible with the status of the transaction.';
        }else if($this->getParam('RESPONSECODE') == "25"){
            $message = '(Code 25) Transaction not found in the Sips database';
        }else if($this->getParam('RESPONSECODE') == "30"){
            $message = '(Code 30) Format error';
        }else if($this->getParam('RESPONSECODE') == "34"){
            $message = '(Code 34) Suspicion of fraud';
        }else if($this->getParam('RESPONSECODE') == "40"){
            $message = '(Code 40) Function not supported: the operation that the merchant would like to perform is not part of the list of operations for which the merchant is authorised';
        }else if($this->getParam('RESPONSECODE') == "51"){
            $message = '(Code 51) Amount too high';
        }else if($this->getParam('RESPONSECODE') == "54"){
            $message = '(Code 54) Card is past expiry date';
        }else if($this->getParam('RESPONSECODE') == "60"){
            $message = '(Code 60) Transaction pending';
        }else if($this->getParam('RESPONSECODE') == "63"){
            $message = '(Code 63) Security rules not observed, transaction stopped';
        }else if($this->getParam('RESPONSECODE') == "75"){
            $message = '(Code 75) Number of attempts at entering the card number exceeded';
        }else if($this->getParam('RESPONSECODE') == "90"){
            $message = '(Code 90) Service temporarily unavailable';
        }else if($this->getParam('RESPONSECODE') == "94"){
            $message = '(Code 94) Duplicated transaction: for a given day, the TransactionReference has already been used';
        }else if($this->getParam('RESPONSECODE') == "97"){
            $message = '(Code 97) Timeframe exceeded, transaction refused';
        }else if($this->getParam('RESPONSECODE') == "99"){
            $message = '(Code 99) Temporary problem at the Sips Office Server level';
        }else{
            $message = '('.$this->getParam('RESPONSECODE').') Code unknown';
        }

        return $message;
    }

    public function isSuccessful()
    {
        return in_array($this->getParam('RESPONSECODE'), array("00", "60"));
    }

    public function toArray()
    {
        return $this->parameters;
    }

    public function getDataString()
    {
        return $this->dataString;
    }
}
