<?php require_once'elementi.php'?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cssFolder/index.css">
    <link rel="stylesheet" href="/cssFolder/pageStyle.css">
    <link rel="shortcut icon" type="image/png" href="/imagesFolder/faviconImg.png">
    <title>FerMe | Modifica Password</title>
</head>
<body>
	<?php
		$conn = connect();
		session_start();
		elemento1();
		elemento2($conn);
	?>
	<div id="Main">
		<div class="divFloat">
			<h3>Cambiamento Password</h3><br>
			<form action="modPass.php" method="POST">
			<h4>Inserite la vostra password corrente </h4><br>
			<input class="inputTemplate" type="password" name="Cpassword" required> <br>
			<h4>Inserite la nuova password</h4><br>
			<input class="inputTemplate" type="password" name="modPass" required><br>
			<h4>Confermate la nuova passwords</h4><br>
			<input class="inputTemplate" type="password" name="modPassConf" required><br><br>
			<div class="center">
				<input type="submit" value="Invia" class="buttonTemplate">
				<a href="/profile.php" class="buttonTemplate">annulla</a>
			</div>
			</form>		
		</div>
	</div>
    <div id="Main">
		<div class="divFloat">
			<?php
				
				//recupero informazioni
				$password = hash('sha256', $_POST['Cpassword']);
				session_start();
				$id = $_SESSION["user"];
				
				$query = mysqli_query($conn, "SELECT password FROM `utenti` WHERE user_id='$id'");
				$fromObj = mysqli_fetch_assoc($query);  
				$queryVar = $fromObj["password"];
				
				if ($queryVar == $password) {
					
					$passwordMod = $_POST['modPass'];
					$passwordModConf = $_POST['modPassConf'];
					
					if ($passwordMod == $passwordModConf) {
						
						//validazione password
						$valid = true;	
						if (strlen($passwordMod) > 250) {
							$valid = false;
							echo 'Il password e\' troppo lungo';
						}
					
						if (strlen($passwordMod) < 6) {
							$valid = false;
							echo 'Il password e\' troppo corto, scegliete uno piu\' potente';
						}
						
						
						$password = hash('sha256', $passwordMod);
						$sql = "UPDATE utenti SET password = '$password' WHERE user_id = '$id'";
						
						if ($valid) {
							if ($conn->query($sql) === TRUE) {
								echo "password cambiato con successo <br><br>";
								echo 'Proseguite <a class="buttonTemplate" href="profile.php">qui</a>';
							}
						} else echo '<br><br><a class="buttonTemplate" href="modPass.php">ricarica</a>';
						
					} else echo 'Le due password non corrispondono <a class="buttonTemplate" href="modPass.php">ricarica</a> <br>';
					
				} elseif ($passwordMod != NULL)echo 'Password attuale sbagliata, <a class="buttonTemplate" href="modPass.php">ricarica</a>';
			?>

		</div>
	</div>
    </div>
    <?php elemento3();?>
</body>
</html>
