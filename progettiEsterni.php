<?php require_once'elementi.php'?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cssFolder/progettiEsterni.css">
    <link rel="shortcut icon" type="image/png" href="/imagesFolder/faviconImg.png">
    <title>FerMe | Progetti Esterni</title>
</head>
<body>
	<?php
		$conn = connect();
		session_start();
		elemento1();
		elemento2($conn);
	?>
    <div class="mainContent">
        <h1>Progetti esterni</h1>
        <p>Esplorate iniziative scolastiche e progetti personali dei vostri compagni</p>
        <a class="netiquetteBtn" href="/netiquette.html">Netiquette</a>
    </div>

    <?php elemento3();?>
</body>
</html>
