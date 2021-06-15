<?php
	require_once'elementi.php';
	$conn = connect();
	session_start();
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
    <title>FerMe | Cancella account</title>
</head>
<body>
    <?php
		elemento1();
		elemento2($conn);
	?>
	<div id="Main">
		<div class="divFloat">
			<!--codice php-->
			<h3 class="center">Se volete veramente distruggere il vostro account, inserite la vostra password</h3>
			<br>
			<form action="accDel.php" method="POST">
				<input type="password" name="password" class="inputTemplate"><br><br>
				<div class="center">
					<input type="submit" value="Invia" class="buttonTemplate">
					&emsp;&emsp;&emsp;
					<a class="buttonTemplate" href="/profile.php">annulla</a>
				</div>
			</form>
		</div>
	</div>
    <div id="Main">
		<div class="divFloat">
			<?php
				$id = $_SESSION["user"];
				
				//recupero informazioni
				$password = hash('sha256', $_POST['password']);				
				$query = mysqli_query($conn, "SELECT password FROM `utenti` WHERE user_id='$id'");
				$fromObj = mysqli_fetch_assoc($query);  
				$queryVar = $fromObj["password"];
				
				if ($password == $queryVar) {
					$sql = "DELETE FROM utenti WHERE user_id='$id'";
					
					if ($conn->query($sql) === TRUE) {
						echo "<br>Account cancellato con successo<br>";
						echo '<br><a href="/index.php" class="buttonTemplate">Torna al sito</a>';
					} else {
						echo "Error: " . $sql . "<br>" . $conn->error;
					}
				} elseif ($password != NULL) {
					echo 'Ricontrollate la password, <a href="/accDel.php" class="buttonTemplate">ricarica</a>';
				}
			
			?>

		</div>
	</div>
    </div>
    <?php elemento3(); ?>
</body>
</html>
