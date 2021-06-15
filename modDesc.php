<?php
	require_once'elementi.php';
	$conn = connect();
	
	//reupero della descrizione
	session_start();
	$id = $_SESSION['user'];
	$query = mysqli_query($conn, "SELECT description FROM `utenti` WHERE user_id = $id");
	$fromObj = @mysqli_fetch_assoc($query);
	$descrizione = $fromObj["description"];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cssFolder/index.css">
    <link rel="stylesheet" href="/cssFolder/pageStyle.css">
    <link rel="shortcut icon" type="image/png" href="/imagesFolder/faviconImg.png">
    <title>FerMe | Modifica descrizione</title>
</head>
<body>
    <?php
		elemento1();
		elemento2($conn);
	?>
	<div id="Main">
		<div class="divFloat">
			<form action="modDesc.php" method="POST">
				<textarea id="desc" name="desc" rows="12" cols="62" maxlength="750" placeholder="limite di 750 caratteri"><?php echo $descrizione;?></textarea>
				<br><br><br>
				<div class="center">
					<input type="submit" value="Invia" class="buttonTemplate">
					<a class="buttonTemplate" href="/profile.php">annulla</a>
				</div>
			</form>
		</div>
	</div>
    <div id="Main">
		<div class="divFloat">
			<?php
				$conn->query('SET NAMES utf8');
				$desc = san($conn, $_POST['desc']);
				$id = $_SESSION["user"];
				
				if ($desc != NULL) {
					$sql = "UPDATE utenti SET description = '$desc' WHERE user_id = '$id'";
					
					if ($conn->query($sql) === TRUE) {
					
						echo "Descrizione cambiata con successo <br><br>";
						echo 'tornate qui: <a class="buttonTemplate" href="profile.php">Profilo</a>';
						
					} else {
						echo "Error: " . $sql . "<br>" . $conn->error;
					}	
				}
			?>

		</div>
	</div>
    </div>
    <?php elemento3(); ?>
</body>
</html>
