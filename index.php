<?php
/**
 * Wordline Sips Payment
 * Author : gmonseur
 * Source : https://github.com/worldline/Sips-International-non-FR-PHPlibrary
 */

require 'config/config.php';
require 'vendor/autoload.php';
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Wordline Test</title>
    <link rel="stylesheet" href="css/milligram.min.css" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="column">
                <h1>Wordline Sips Test</h1>

                <div class="column column-50">

                    <form method="post" action="process.php">
                        <label for="amount">amount</label>
                        <input type="text" value="55" name="amount" id="amount" />

                        <label for="currency">currency</label>
                        <input type="text" value="EUR" name="currency" id="currency" />

                        <label for="merchantId">merchantId</label>
                        <input type="text" value="<?php echo $sips_config['merchantId']?>" name="merchantId" id="merchantId" />

                        <label for="normalReturnUrl">normalReturnUrl</label>
                        <input type="text" value="http://sips.pixfactory.pro/confirmation.php" name="normalReturnUrl" id="normalReturnUrl" />

                        <label for="transactionReference">transactionReference</label>
                        <input type="text" value="<?php echo rand(); ?>" name="transactionReference" id="transactionReference" />

                        <label for="keyVersion">keyVersion</label>
                        <input type="text" value="<?php echo $sips_config['keyVersion']; ?>" name="keyVersion" id="keyVersion" />

                        <label for="paymentBrand">Payment Brand</label>
                        <small>It is possible to test VISA, Mastercard transactions only in Test Mode</small>
                        <select name="paymentBrand" id="paymentBrand">
                            <option value="MASTERCARD">MASTERCARD</option>
                            <option value="VISA">VISA</option>
                        </select>

                        <input type="submit" value="Proceed to payment">
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

</html>
