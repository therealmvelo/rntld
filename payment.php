<?php 

include 'config.php';

$ref = "hh";
$cname = "hello world";
$amount = 75;

$ref = $ref."_".generateRandomString(2); // generating two letters/numbers to make the referrence unique

$postData = array('SiteCode' => $siteCode,
                    'CountryCode' => 'ZA',
                    'CurrencyCode' => 'ZAR',
                    'Amount' => $amount,
                    'TransactionReference' => $ref,
                    'BankReference' => $ref,
                    'CancelUrl' => 'payment_not_success.php',
                    'ErrorUrl' => 'payment_not_success.php',
                    'SuccessUrl' => 'payment_success.php',
                    'NotifyUrl' => 'responsetest.php',
                    'IsTest' => $IsTest);

$hashString = strtolower(implode('', $postData) . $privateKey);
$hashCheck = hash('sha512', $hashString);
$postData['HashCheck'] = $hashCheck;
$ozowResult = getPaymentLinkModel($postData, $ApiKey);


if (!empty($ozowResult->errorMessage)) {
    die($ozowResult->errorMessage);
}

header('Location:'. $ozowResult->url, true);
die();

function getPaymentLinkModel($postData, $ApiKey)
{
    $jsonRequest = json_encode($postData);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'ApiKey:' . $ApiKey,
        'Content-Type: application/json'
    ));

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonRequest);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, 'https://api.ozow.com/postpaymentrequest');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $requestResult = curl_exec($ch);

    if ($requestResult === false) {
        die('<h5>Error generating Ozow URL: curl error</h5>');
    }

    return json_decode($requestResult);

}
?>