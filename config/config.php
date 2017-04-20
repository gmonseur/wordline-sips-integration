<?php
/**
 * Sips config 
 */

$sips_mode = 'TEST'; // TEST or PRODUCTION

// CFG Sips
$sips_config = array(
    'TEST' => array(
        'sipsUri' => 'https://payment-webinit.test.sips-atos.com/paymentInit',
        'sipsResponseUrl' => 'http://YOUR_TEST_URL/notify.php',
        'merchantId' => '037107704346091',
        'keyVersion' => 2,
        'secretKey' => 'CcDeXSiX2CY0mgbuB_MJxXqXYyJaINZixX2KZgY770o'
    ),
    'PRODUCTION' => array(
        'sipsUri' => 'https://payment-webinit.sips-atos.com/paymentInit',
        'sipsResponseUrl' => 'http://YOUR_PRODUCTION_URL/notify.php',
        'merchantId' => 'YOUR MERCHANT ID',
        'keyVersion' => 2,
        'secretKey' => 'YOUR SECRET KEY'
    )
);

$sips_config = $sips_config[$sips_mode];