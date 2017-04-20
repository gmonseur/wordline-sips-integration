<?php
/**
 * Payment Response
 * Automatic response send by Sips server
 * Tips: Debug or show $_REQUEST with "echo http_build_query($_REQUEST);"
 */

require 'config/config.php';
require 'vendor/autoload.php';
require 'helper/debug.php';

use Sips\Passphrase;
use Sips\PaymentResponse;
use Sips\ShaComposer\AllParametersShaComposer;

// Log cfg
$path = 'logs/sips_notify.log';

// Payment return
$paymentResponse = new PaymentResponse($_REQUEST);
$passphrase = new Passphrase($sips_config['secretKey']);
$shaComposer = new AllParametersShaComposer($passphrase);

if ($paymentResponse->isValid($shaComposer) && $paymentResponse->isSuccessful()) {
    // handle payment confirmation
    $message = 'Success => '.$paymentResponse->getResponseMsg();


} else {
    // perform logic when the validation fails
    $message = 'Error => '.$paymentResponse->getResponseMsg();

}

// Log response
write_log($path, $message);