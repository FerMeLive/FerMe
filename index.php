<?php require_once 'elementi.php';?>
<!DOCTYPE html>
<!--Benvenuti nel codice schifoso creato da leo -->
<!-- sul fatto che sia schifoso sono daccordo -->
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/cssFolder/index.css" media="all">
    <link rel="shortcut icon" type="image/png" href="/imagesFolder/faviconImg.png">
    <title>FerMe</title>
    <!-- Il tag style serve per non rendere strani gli elementi su schermi piccoli con le media queries -->
</head>
<body>
	<?php
		$conn = connect();
		session_start();
		elemento1();
		elemento2($conn);
	?>
    <!-- Parte principale del sito -->
    <div class="mainContent">
        <div class="initialBlock">
            <h1>Benvenuto a FerMe</h1>
            <p>il sito in cui conoscere, comunicare e fare amicizie con studenti di altre classi</p>
            <div class="mainImgBlock">
                <img src="/imagesFolder/homeImg.svg">
            </div>
        </div>
        <div class="infoBlock">
            <h1>Da studenti per studenti</h1>
        </div>
    </div>
</body>
</html>
<?php elemento3();?>
