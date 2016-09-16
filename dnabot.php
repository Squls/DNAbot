<?php

//create image dimensions and strand size
$x1 = 0;
$y1 = 0;
$x2 = 15.7142857143;
$y2 = 44;
$width = 440;
$height = 220;

$img  = imagecreate($width, $height);
$bgcolor = imagecolorallocate($img,0,0,0);
$white = imagecolorallocate($img,255,255,255);

//generate random string using ACGT 140 characters long
function generateRandomString($length = 140) {
    $characters = 'ACGT';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
};

$dna = generateRandomString();

//drawimage
for( $i = 0; $i < 140; $i++ ) {

if ($dna[$i] == 'A') {
    $color = imagecolorallocate($img,0,255,0);
} else if ($dna[$i] == 'T') {
    $color = imagecolorallocate($img,255,0,0);
} else if ($dna[$i] == 'C') {
    $color = imagecolorallocate($img,0,0,255);
} else if ($dna[$i] == 'G') {
    $color = imagecolorallocate($img,0,0,0);
};

imagefilledrectangle($img,$x1,$y1,$x2,$y2,$color);

if ($x1 > $width - 31.4285714286 ) {
  $x1 = 0;
  $x2 = 15.7142857143;
} else {
  $x1 += 15.7142857142;
  $x2 += 15.7142857143;
};

if ($i < 28) {
  $y1 = 0;
  $y2 = 44;
} else if ($i > 28 && $i <= 56) {
  $y1 = 44;
  $y2 = 88;
} else if ($i > 56 && $i <= 84) {
  $y1 = 88;
  $y2 = 132;
} else if ($i > 84 && $i <= 112) {
  $y1 = 132;
  $y2 = 176;
} else if ($i > 112 && $i <= 140) {
  $y1 = 176;
  $y2 = 220;
};

};


//save image
imagejpeg($img,"img.jpg");

//twitter message using codebird
 function tweet($message,$image) {

    // add the codebird library
    require_once('codebird.php');

    // note: consumerKey, consumerSecret, accessToken, and accessTokenSecret all come from your twitter app at https://apps.twitter.com/
    \Codebird\Codebird::setConsumerKey("consumerKey", "consumerSecret");
    $cb = \Codebird\Codebird::getInstance();
    $cb->setToken("accessToken", "accessTokenSecret");

    //build an array of images to send to twitter
    $reply = $cb->media_upload(array(
        'media' => $image
    ));
    //upload the file to your twitter account
    $mediaID = $reply->media_id_string;

    //build the data needed to send to twitter, including the tweet and the image id
    $params = array(
        'status' => $message,
        'media_ids' => $mediaID
    );
    //post the tweet with codebird
    $reply = $cb->statuses_update($params);

}

tweet("message","url to image");


?>
