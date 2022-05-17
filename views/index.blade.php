<?php
$curl = curl_init();
$date = new DateTime();
$timestamp = $date->getTimestamp();
$privateKey = 'fcf58285b20f61a14cd6d2f64f588595596a8ed1'; //'your private key'
$publicKey = '9916c245133cfcbabcb8ea332ed65108'; //'your public key'
$keys = $privateKey . $publicKey;

$string = $timestamp . $keys;
$md5 = hash('md5', $string);

curl_setopt($curl, CURLOPT_URL, "https://gateway.marvel.com:443/v1/public/characters?ts=$timestamp&limit=25&apikey=$publicKey&hash=$md5");
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept:application/json , content-type:application/json'));

$result = curl_exec($curl);
curl_close($curl);

$result = json_decode($result, true);

//var_export($result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Marvel API Example</title>
</head>

<body>
  <div class="container">
    <div class="row">

      <?php foreach ($result['data']['results'] as $key => $value) : ?>
        <?php foreach ($value as $key => $value) : ?>
          <?php if ($key == 'name') {
            $heroName = $value;
          } ?>
          <?php if ($key == 'thumbnail') : ?>
            <div class="card" style='margin-top:10px ; margin-left:10px;'>
              <img src="<?= $value['path'] . '.' . $value['extension'] ?>" style="width: 200px; height: 200px; " class="card-img-top rounded">
              <div class="card-body">
                <p class="card-text"> <?= $heroName ?> </p>
              </div>
            </div>
          <?php endif ?>

        <?php endforeach ?>
      <?php endforeach ?>


    </div>
  </div>
</body>

</html>