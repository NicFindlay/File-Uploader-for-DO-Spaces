<?php

// Included aws/aws-sdk-php via Composer's autoloader
require 'vendor/autoload.php';
use Aws\S3\S3Client;


if(isset($_FILES['file'])){
    $file_name = $_FILES['file']['name'];   
    $temp_file_location = $_FILES['file']['tmp_name']; 

    //If file_name is empty then give it a no name
    if( strlen($file_name) == 0){
      $file_name = "no-name-brand.epub";
    }

    // Configure a client using Spaces
    $client = new Aws\S3\S3Client([
            'version' => 'latest',
            'region'  => 'ams3',
            'endpoint' => 'https://ams3.digitaloceanspaces.com',
            'credentials' => [
                    'key'    => 'YOUR ACCESS KEY',  //Change this
                    'secret' => 'YOUR SECRET KEY',  //Change this
                ],
            'http'    => [
                'verify' => 'LOCATION OF YOUR CA CERTIFICATE'
            ]
    ]);

    // Upload a file to the Space
    $insert = $client->putObject([
         'Bucket' => 'YOUR BUCKET NAME',    //Change this
         'Key'    => $file_name,
         'Body'   => 'The contents of the file'
    ]);

    //Post Success redirection
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      header("Location: /dollarbooks/upload/success.html");
    }
    else{
      header("Location: /dollarbooks/upload/failure.html");
    }
}
?>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Uploader</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>

    <img src="http://logo.clearbit.com/spotify.com" width="300"/>

    <br><br>
    <p>Select your file and click submit.</p>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">         
            <input type="file" name="file" />
            <input type="submit"/>
        </form>  

        <br><br>
    <a href="#">Go Back?</a>

</body>
</html>    


