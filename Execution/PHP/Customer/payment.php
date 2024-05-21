<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Replace these placeholders with your actual sandbox credentials
$clientId = 'AVERPVeJXC7_LWnHvkTfzDoU2a6zDsjyMCKUQ-I1SZgvaq3I91Vk6LXPP3tXgafXz3a7s_GU4_4vWmVh';
$clientSecret = 'ENgAzWIBnMvtAem3GGvxTOK2Fco9IElqPeAm2dtBQc51BczmNTyjHiKfnNpCWSlQ7tRIBE5J83eK4AT3';
 // Assuming 'order_id' is passed from the previous page

// Include connection file to the database
include("connection/connection.php");

// Function to make API call to PayPal
function makePayPalApiCall($apiEndpoint, $headers, $body) {
    $ch = curl_init($apiEndpoint . '/v1/payments/payment');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Set up the payment amount and currency
$amount = $_GET['total_price']; // Amount in pence or smallest currency unit
$currency = 'GBP'; // Currency code for pound sterling

// Set up your product details
$productName = "HudderFoods";
$productDescription = "Purchased " . $_GET["total_products"] . " Products From HudderFoods";

// Set up PayPal API endpoints for sandbox
$apiEndpoint = 'https://api.sandbox.paypal.com';
$redirectUrl = 'http://localhost/CommunityHarvest//Execution/PHP/Customer/homepage.php'; // Replace with your thank you page URL

// Set up PayPal API request headers
$headers = [
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode("$clientId:$clientSecret")
];

// Set up PayPal API request body
$body = [
    'intent' => 'sale',
    'payer' => [
        'payment_method' => 'paypal'
    ],
    'transactions' => [
        [
            'amount' => [
                'total' => number_format($amount / 100, 2),
                'currency' => $currency
            ],
            'description' => $productDescription
        ]
    ],
    'redirect_urls' => [
        'return_url' => $redirectUrl . '?success=true' . 
                        '&total_price=' . urlencode($_GET['total_price']) . 
                        '&total_products=' . urlencode($_GET['total_products']) . 
                        '&customer_id=' . urlencode($_GET['customer_id']),
        'cancel_url' => $redirectUrl . '?success=false'
    ]
];

// Make API call to PayPal
$payment = makePayPalApiCall($apiEndpoint, $headers, $body);

// Redirect user to PayPal for payment authorization
if(isset($payment['id'])) {
    $redirectUrl = $payment['links'][1]['href'];
    header('Location: ' . $redirectUrl); // Redirect to PayPal for payment authorization
    exit;
} else {
    echo "Payment failed. Please try again later.";
}
?>