<?php
require_once 'config.php';
require_once 'vendor/autoload.php';
use GuzzleHttp\Client;
 
try {
    $client = new Client(['base_uri' => 'https://www.linkedin.com']);
    $response = $client->request('POST', '/oauth/v2/accessToken', [
        'form_params' => [
                "grant_type" => "authorization_code",
                "code" => $_GET['code'],
                "redirect_uri" => REDIRECT_URI,
                "client_id" => CLIENT_ID,
                "client_secret" => CLIENT_SECRET,
        ],
    ]);
    $data = json_decode($response->getBody()->getContents(), true);
    $access_token = $data['access_token']; // store this token somewhere
    
        $myfile = fopen("access_token.txt", "w") or die("Unable to open file!");
        $txt = "$access_token";
        fwrite($myfile, $txt);
        fclose($myfile);
        
} catch(Exception $e) {
    echo $e->getMessage();
}