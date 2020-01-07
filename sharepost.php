<?php
require_once 'config.php';
require_once 'vendor/autoload.php';
use GuzzleHttp\Client;


$myfile = fopen("access_token.txt", "r") or die("Unable to open file!");
 $access_token =  fread($myfile,filesize("access_token.txt"));
fclose($myfile); 


try {
    $client = new Client(['base_uri' => 'https://api.linkedin.com']);
    $response = $client->request('GET', '/v2/me', [
        'headers' => [
            "Authorization" => "Bearer " . $access_token,
        ],
    ]);
    $data = json_decode($response->getBody()->getContents(), true);
    $linkedin_profile_id = $data['id']; // store this id somewhere
        $linkedin_profile_id;
        $myfile = fopen("id.txt", "w") or die("Unable to open file!");
        $txt = "$linkedin_profile_id";
        fwrite($myfile, $txt);
        fclose($myfile);

        $myfile = fopen("id.txt", "r") or die("Unable to open file!");
        $linkedin_id =  fread($myfile,filesize("id.txt"));
        fclose($myfile);
        
        $link = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $body = new \stdClass();
        $body->content = new \stdClass();
        $body->content->contentEntities[0] = new \stdClass();
        $body->text = new \stdClass();
        $body->content->contentEntities[0]->thumbnails[0] = new \stdClass();
        $body->content->contentEntities[0]->entityLocation = $link;
        $body->content->contentEntities[0]->thumbnails[0]->resolvedUrl = "linke image";
        $body->content->title = 'text';
        $body->owner = 'urn:li:person:'.$linkedin_id;
        $body->text->text = 'text';
        $body_json = json_encode($body, true);
         
        try {
            
            $myfile = fopen("access_token.txt", "r") or die("Unable to open file!");
             $access_token =  fread($myfile,filesize("access_token.txt"));
            fclose($myfile); 

            $client = new Client(['base_uri' => 'https://api.linkedin.com']);
            $response = $client->request('POST', '/v2/shares', [
                'headers' => [
                    "Authorization" => "Bearer " . $access_token,
                    "Content-Type"  => "application/json",
                    "x-li-format"   => "json"
                ],
                'body' => $body_json,
            ]);
         
            if ($response->getStatusCode() !== 201) {
                echo 'Error: '. $response->getLastBody()->errors[0]->message;
            }
         
            echo 'Post is shared on LinkedIn successfully';
        } catch(Exception $e) {
            echo $e->getMessage(). ' for link '. $link;
        }
    
    
    
    
    
} catch(Exception $e) {
    echo $e->getMessage();
}


