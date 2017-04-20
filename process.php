<?php
/**
 * Payment Request
 */
require 'config/config.php';
require 'vendor/autoload.php';

use Sips\HttpClient;
use Sips\Passphrase;
use Sips\PaymentRequest;
use Sips\ShaComposer\AllParametersShaComposer;

if (isset($_POST)) {

    // Post
    $amount = intval($_POST['amount']) * 100; // cent
    $currency = $_POST['currency'];
    $normalReturnUrl = $_POST['normalReturnUrl'];
    $transactionReference = $_POST['transactionReference'];
    $keyVersion = $_POST['keyVersion'];
    $merchantId = $_POST['merchantId'];
    $paymentBrand = $_POST['paymentBrand'];

    // passphrase
    $passphrase = new Passphrase($sips_config['secretKey']);
    $shaComposer = new AllParametersShaComposer($passphrase);

    $paymentRequest = new PaymentRequest($shaComposer);

    // Optionally set Sips uri, defaults to TEST account
    $paymentRequest->setSipsUri($sips_config['sipsUri']);

    // Set various params:
    $paymentRequest->setMerchantId($merchantId);
    $paymentRequest->setKeyVersion($keyVersion);
    $paymentRequest->setTransactionReference($transactionReference);
    $paymentRequest->setAmount($amount);
    $paymentRequest->setCurrency($currency);
    $paymentRequest->setNormalReturnUrl($normalReturnUrl);
    $paymentRequest->setAutomaticResponseUrl($sips_config['sipsResponseUrl']);
    $paymentRequest->setLanguage('fr');
    $paymentRequest->setPaymentBrand($paymentBrand);
    $paymentRequest->validate();

    // Create Http client to send the paymentRequest
    $client = new HttpClient($paymentRequest->getSipsUri());
    $client->setHeader("Content-Type", "application/x-www-form-urlencoded");
    $client->post("/paymentInit", array(
        'Data' => $paymentRequest->toParameterString(),
        'InterfaceVersion' => 'HP_2.3',
        'Seal' => $paymentRequest->getShaSign()
    ));

    echo utf8_decode($client->getBody()); // Just print the response body
    exit();
}
