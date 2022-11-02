<?php

if (isset($_POST['submit']) && $_POST['submit']) {
    $name   = $_POST['name'];
    $token  = $_POST['token'];
    $action = $_POST['action'];
    
    $curlData = array(
        'secret' => '6LdFbm4dAAAAACPSsoNEemn-_FJZP8czITr-lGd7',
        'response' => $token
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($curlData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $curlResponse = curl_exec($ch);
    
    $captchaResponse = json_decode($curlResponse, true);
    print_r($captchaResponse);exit;
    
    if ($captchaResponse['success'] == '1' && $captchaResponse['action'] == $action && $captchaResponse['score'] >= 0.5 && $captchaResponse['hostname'] == $_SERVER['SERVER_NAME']) {
        echo 'Form Submitted Successfully';
    } else {
        echo 'You are not a human';
    }
}
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Google Recaptcha V3</title>
   </head>
   <body>
      <h1>Google Recaptcha V3</h1>
      <form action="" method="post">
         <label>Name</label>
         <input type="text" name="name" id="name">
         <input type="hidden" name="token" id="token" /> 
         <input type="hidden" name="action" id="action" />
         <input type="submit" name="submit">
      </form>
      <script src="https://www.google.com/recaptcha/api.js?render=6LdFbm4dAAAAALzgL14UCaVqdZsxqOjN751a0YUh"></script>
      <script  src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
      <script type="text/javascript">
         $(document).ready(function(){
          //setInterval(function(){
          grecaptcha.ready(function() {
               //put your site key here
              grecaptcha.execute('6LdFbm4dAAAAALzgL14UCaVqdZsxqOjN751a0YUh', {action: 'application_form'}).then(function(token) {
                $('#token').val(token);
                $('#action').val('application_form');
              });
          });
          }, 3000);
         //});
         
      </script>
   </body>
</html>