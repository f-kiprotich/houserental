<?php
require 'vendor/autoload.php'; // Ensure Composer's autoload is included

use GuzzleHttp\Client;

function getAccessToken($consumerKey, $consumerSecret) {
    $client = new Client();
    $response = $client->request('GET', 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials', [
        'auth' => [$consumerKey, $consumerSecret]
    ]);
    $body = json_decode($response->getBody(), true);
    return $body['access_token'];
}

function initiateStkPush($accessToken, $businessShortCode, $passkey, $amount, $phoneNumber, $callbackUrl, $accountReference, $transactionDesc) {
    $client = new Client();
    $timestamp = date('YmdHis');
    $password = base64_encode($businessShortCode . $passkey . $timestamp);

    $response = $client->request('POST', 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', [
        'headers' => [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json'
        ],
        'json' => [
            'BusinessShortCode' => $businessShortCode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phoneNumber,
            'PartyB' => $businessShortCode,
            'PhoneNumber' => $phoneNumber,
            'CallBackURL' => $callbackUrl,
            'AccountReference' => $accountReference,
            'TransactionDesc' => $transactionDesc
        ]
    ]);

    return json_decode($response->getBody(), true);
}

// Replace these values with your own
$consumerKey = '5r8XLXL62ltrBWtjfbUcayXqla1NLsYnga1CAqTCF7lIvyQG';
$consumerSecret = 'EMfG6QQeGaNu2ftGcKczg3ep5tDlvRcUOxuM6nATgKLhf6KZ3GbaK35JFVAanVZJ';
$businessShortCode = 'YOUR_BUSINESS_SHORT_CODE';
$passkey = '600984';
$callbackUrl = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl'; // Must be a publicly accessible URL
$accountReference = 'RENTAL_PAYMENT';
$transactionDesc = 'Rental payment';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $phoneNumber = $_POST['phone'];

    try {
        $accessToken = getAccessToken($consumerKey, $consumerSecret);
        $response = initiateStkPush($accessToken, $businessShortCode, $passkey, $amount, $phoneNumber, $callbackUrl, $accountReference, $transactionDesc);

        echo "<pre>";
        print_r($response);
        echo "</pre>";
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
