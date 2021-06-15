<?php require_once 'elementi.php';?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cssFolder/signup.css">
    <link rel="stylesheet" href="/cssFolder/index.css">
    <link rel="shortcut icon" type="image/png" href="/imagesFolder/faviconImg.png">
    <title>FerMe | Registrati</title>
</head>
<body>
	<?php elemento1(); elemento2($conn); ?>

	<div class="mainContent">
        <div class="welcomeBlock">
            <h1>Registrati usando la mail istituzionale</h1>

            <form action="signup.php" method="POST">
                <input class="inp" type="text" name="username" placeholder="Nome" required><br>
                <input class="inp" type="email" name="email" placeholder="Email" required><br>
                <input class="inp" type="password" name="password" placeholder="Password" required><br>
                <input class="inp" type="password" name="passwordConf" placeholder="Conferma password" required><br>
                <input class="inviaBtn" type="submit" name="invia" value="Invia">  
             </form>
        </div>
    </div>
	<?php
		if (isset($_POST["invia"])) {
			//connessione al database
			$conn = connect();
			session_start();
			
			//$valid
			$valid = true;
			
			//ricezione delle informazioni da html
			$username = san($conn, $_POST['username']);
			
			$password = hash('sha256', san($conn, $_POST['password']));
			$passwordConf = hash('sha256', san($conn, $_POST['passwordConf']));
			
			$email = san($conn, $_POST['email']);
			
			//validazione username
			if (strlen($username) > 25) {
				$valid = false;
				echo '<div style="text-align:center"><br>Username troppo lungo</div>';
			}
			
			if (strlen($username) < 4) {
				$valid = false;
				echo '<div style="text-align:center"><br>Username troppo corto</div>';
			}
			
			if (strlen($password) < 6) {
				$valid = false;
				echo '<div style="text-align:center"><br>Il password e\' troppo corto, scegliete uno piu\' potente</div>';
			}
			
			if ($password !== $passwordConf) {
				$valid = false;
				echo '<div style="text-align:center"><br>Le password non corrispondono</div>';
			}
			
			//validazione email
			if (strlen($email) > 70) {
				$valid = false;
				echo '<div style="text-align:center"><br>L\'email e\' troppo lungo</div>';
			}
			
			if (strlen($email) < 5) {
				$valid = false;
				echo '<div style="text-align:center"><br>Inserite un email vero</div>';
			}
			
			//solo mail istituzionali
			if((strpos($email, "@liceofermipadova.edu.it") == FALSE) AND (strpos($email, "@studenti.liceofermipadova.it") == FALSE) AND (strpos($email, "@studenti.liceofermipadova.edu.it") == FALSE)){
				$valid = false;
				echo '<div style="text-align:center"><br>Sono permesse solo mail istituzionali</div>';
			}
			
			//inserimento nel database in mysql
			if ($valid) {
				$query = mysqli_query($conn, "SELECT username, password, email FROM utenti WHERE email='$email'");
				$fromObj = mysqli_fetch_assoc($query);
				if(@count($fromObj) > 0) {
					echo'<div style="text-align:center"><br>Email gia\' in utilizzo<br><br><a class="regBtn" href=\"http://ferme.eu5.org/signup.php\">ricarica</a></div>';
				} else {
					$sql = "INSERT INTO utenti (username, password, email) VALUES ('$username', '$password', '$email')";
					
					if ($conn->query($sql) === TRUE) {
						echo '<div style="text-align:center"><br>registrazione completata con successo</div>';
					} else {
						echo "Error: " . $sql . "<br>" . $conn->error;
					}
					
					//inizializzazione della sessione
					$query = mysqli_query($conn, "SELECT user_id FROM `utenti` WHERE email='$email'");
					$fromObj = mysqli_fetch_assoc($query);
					$sessionVar = $fromObj['user_id'];
					$_SESSION["user"] = $sessionVar;
				}
			} else {
				echo '<div style="text-align:center"><br><a class="regBtn" href="signup.php">ricarica</a><br></div>';
			}
			echo '<div style="text-align:center"><br>Se avete finito la registrazione, proseguite qui: <a class="regBtn" href="profilePics.php">cambia foto profilo</a></div>';
		}
		elemento3();
	?>
</body>
</html>

