<?php
require_once 'config.php';
 
$state = substr(str_shuffle("0123456789abcHGFRlki"), 0, 10);
$url = "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=".CLIENT_ID."&redirect_uri=".REDIRECT_URI."&scope=".SCOPES."&state=".$state;
?>
 
<a href="<?php echo $url; ?>">Login with LinkedIn</a>