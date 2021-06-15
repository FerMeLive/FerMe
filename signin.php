<?php
	function redirect () {
		echo "<meta http-equiv = \"refresh\" content = \"0; url = https://ferme.live/index.php\" />";
	}
	require_once 'elementi.php';
	session_start();
?>

<!DOCTYPE html>
<html lang="it">
<head>
	<!--Meta-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cssFolder/signin.css">
    <link rel="stylesheet" href="/cssFolder/index.css">
    <link rel="shortcut icon" type="image/png" href="/imagesFolder/faviconImg.png">
    <title>FerMe | Accedi</title>
</head>
<body>
	<?php $conn = connect(); elemento1(); elemento2($conn);?>
    <!--Form-->
    <div class="mainContent">
        <div class="welcomeBlock">
            <h1>Accedi</h1>
            <p>Accedi all'account che hai creato qui sotto</p>
            <form action="signin.php" method="POST">
                <input class="inp" type="email" name="email" placeholder="Email" required><br>
                <input class="inp" type="password" name="password" placeholder="Password" required><br>
                <input class="inviaBtn" type="submit" value="Invia">
            </form> 
            <?php
				if (isset($_POST['email'])) {
					//recupero input da signin.html
					$email = $_POST['email'];
					$password = hash('sha256', san($conn, $_POST['password']));
					$query = mysqli_query($conn, "SELECT password FROM utenti WHERE email='$email'") or die ("Ricontrollate l'email inserito");
					$fromObj = mysqli_fetch_assoc($query);  
					$queryVar = $fromObj["password"];
					
					if ($queryVar == $password) {
						$query = mysqli_query($conn, "SELECT user_id FROM `utenti` WHERE email='$email'");
						$fromObj = mysqli_fetch_assoc($query);
						$sessionVar = $fromObj['user_id'];
						$_SESSION["user"] = $sessionVar;
						redirect();
					} elseif ($email != NULL) {echo '<br><div style="text-align:center"> <a class="regBtn" href="/signin.php">ricarica</a></div>';}
				}
			?>
        </div>
    </div>
</body>
</html>
<?php elemento3();?>
