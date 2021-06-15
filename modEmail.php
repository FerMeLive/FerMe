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
    <title>FerMe | Modifica Email</title>
</head>
<body>
    <?php
		$conn = connect();
		session_start();
		elemento1();
		elemento2($conn);
	?>
	<div id="Main">
		<div class="divFloat" >
			<h3 style="text-align: center;">Cambiamento Email</h3><br>
			<form action="modEmail.php" method="POST">
				<h4>Inserite la vostra password</h4><br>
				<input class="inputTemplate" type="password" name="password" required> <br>
				<h4>Inserite la nuova email</h4><br>
				<input class="inputTemplate" type="email" name="email" required><br><br>
				<div class="center">
					<input class="buttonTemplate" type="submit" value="Invia">
					<a class="buttonTemplate" href="/profile.php">annulla</a>
				</div>
			</form>
		</div>
	</div>
    <div id="Main">
		<div class="divFloat">
			<?php
				
				//recupero informazioni
				$email = san($conn, $_POST['email']);
				$password = hash('sha256', san($conn, $_POST['password']));
				session_start();
				$id = $_SESSION["user"];
				
				$query = mysqli_query($conn, "SELECT password FROM `utenti` WHERE user_id='$id'");
				$fromObj = mysqli_fetch_assoc($query);  
				$queryVar = $fromObj["password"];
				
				if ($queryVar == $password) {
					$sql = "UPDATE utenti SET email = '$email' WHERE user_id = '$id'";
					
					//validazione email
					$valid = true;
					if (strlen($email) > 70) {
						$valid = false;
						echo '<br>L\'email e\' troppo lungo';
					}
				
					if (strlen($email) < 5) {
						$valid = false;
						echo '<br>Inserite un email vero';
					}
					
					if ($valid){
						if ($conn->query($sql) === TRUE) {
							echo "email cambiato con successo <br><br>";
							echo 'Proseguite <a class="buttonTemplate" href="/profile.php">qui</a>';
						}
					} else echo '<br><a class="buttonTemplate" href="/modEmail.php">ricarica</a>';
				} elseif($email != NULL) echo 'Password sbagliato, <a class="buttonTemplate" href="/modEmail.php" >ricarica</a>';
			?>
	</div>
    </div>
    <?php elemento3(); ?>
</body>
</html>
