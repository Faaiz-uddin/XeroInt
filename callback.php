<?php

$client_id = '';
$client_secret = '';
$redirect_uri = 'http://localhost/Learing_Project/xerointegration/callback.php'; // Must match the redirect URI used during authorization

$authorization_code = isset($_GET['code']) ? $_GET['code'] : null;

if (!$authorization_code) {
    die('Authorization code not found.');
}

$token_url = 'https://identity.xero.com/connect/token';

$data = [
    'grant_type' => 'authorization_code',
    'code' => $authorization_code,
    'redirect_uri' => $redirect_uri,
    'client_id' => $client_id,
    'client_secret' => $client_secret
];

$ch = curl_init($token_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

$response = curl_exec($ch);
if ($response === false) {
    die('cURL Error: ' . curl_error($ch));
}
curl_close($ch);

$response_data = json_decode($response, true);

if (isset($response_data['access_token'])) {
    $access_token = $response_data['access_token'];
    $refresh_token = $response_data['refresh_token'];
    $expires_in = $response_data['expires_in'];
    $token_type = $response_data['token_type'];

    // Output for debugging (remove in production)
    echo "Authorization successful!<br>";
    echo "Access Token: " . htmlspecialchars($access_token) . "<br>";
    echo "Refresh Token: " . htmlspecialchars($refresh_token) . "<br>";
    echo "Expires In: " . htmlspecialchars($expires_in) . " seconds<br>";
    echo "Token Type: " . htmlspecialchars($token_type) . "<br>";

    setcookie('access_token', $access_token, time() + $expires_in, '/'); 
    setcookie('refresh_token', $refresh_token, time() + (60 * 60 * 24 * 30), '/'); // Set for 30 days, adjust as needed

    // Fetch connections
    $connections_url = 'https://api.xero.com/connections';
    $ch = curl_init($connections_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $access_token"
    ]);

    $response = curl_exec($ch);
    if ($response === false) {
        die('cURL Error: ' . curl_error($ch));
    }
    curl_close($ch);

    $connections_data = json_decode($response, true);

    // Example: Print tenant IDs
    echo "<pre>";
    print_r($connections_data);
    echo "</pre>";

    // Extract the tenant ID
    if (isset($connections_data[0]['tenantId'])) {
        $tenant_id = $connections_data[0]['tenantId'];

        // Fetch employees
        $employees_url = "https://api.xero.com/payroll.xro/1.0/employees";
        $ch = curl_init($employees_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $access_token",
            "x-tenant-id: $tenant_id"
        ]);

        $response = curl_exec($ch);
        if ($response === false) {
            die('cURL Error: ' . curl_error($ch));
        }
        curl_close($ch);

        $employees_data = json_decode($response, true);

        // Example: Print employee data
        echo "<pre>";
        print_r($employees_data);
        echo "</pre>";

    } else {
        echo "Tenant ID not found.";
    }
} else {
    echo "Error: " . htmlspecialchars($response_data['error_description']);
}


