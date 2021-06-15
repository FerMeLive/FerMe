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
    <title>FerMe | Modifica Foto</title>
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
			<?php
				//recupero della sessione
				$id = $_SESSION['user'];
				$query = mysqli_query($conn, "SELECT ruolo FROM `utenti` WHERE user_id = '$id'");
				$fromObj = mysqli_fetch_assoc($query);
				$ruolo = $fromObj['ruolo'];
			?>
				<h3>Scegli un immagine per il foto profilo:</h3><br>
				<form method="POST" class="z">
					<div style="transform: translate(37%)" style="position:relative">
						<label class="labl">
							<input type="radio" name="immagini" id="1" value="1">
							<div>
								<img class="circle" src="/profili/im1.jpg"><br>
							</div>	
						</label>
						<label class="labl"> 
							<input type="radio" name="immagini" id="2" value="2">
							<div>
								<img class="circle" src="/profili/im2.jpg"><br>
							</div>
						</label>
						<label class="labl"> 
							<input type="radio" name="immagini" id="3" value="3">
							<div>
								<img class="circle" src="/profili/im3.jpg"><br>
							</div>
						</label>
						<label class="labl">
							<input type="radio" name="immagini" id="4" value="4">
							<div>
								<img class="circle" src="/profili/im4.jpg"><br>
							</div>
						</label>
						<label class="labl">
							<input type="radio" name="immagini" id="5" value="5">
							<div>
								<img class="circle" src="/profili/im5.jpg"><br>
							</div>
						</label>
						<label class="labl">
							<input type="radio" name="immagini" id="6" value="6">
							<div>
								<img class="circle" src="/profili/im6.jpg"><br>
							</div>
						</label>
						<label class="labl">
							<input type="radio" name="immagini" id="7" value="7">
							<div>
								<img class="circle" src="/profili/im7.jpg"><br>
							</div>
						</label>
						<label class="labl">
							<input type="radio" name="immagini" id="8" value="8">
							<div>
								<img class="circle" src="/profili/im8.jpg"><br>
							</div>
						</label>
					<?php
						/*if($ruolo == 2){
							echo"<label class='labl'>
								<input type='radio' name='immagini' id='9' value='9'>
								<div>
									<h2>Solo per sviluppatori:</h2>
									<img class='circle' src='/profili/im9.jpg'><br>
								</div>
							</label>";
						}*/
					?>
					</div>
					<div class="center">
						<input class="buttonTemplate" type="submit" value="Invia">
						&emsp;&emsp;&emsp;
						<a class="buttonTemplate" href="/profile.php">anulla</a>
					</div>
				   </form>
			<?php
				$userID = $_SESSION["user"];
				$im = $_POST["immagini"];
				$set = $im;
				$sql = "UPDATE utenti SET picture = '$im' WHERE user_id = '$userID'";
					
				if ($conn->query($sql) === TRUE) {
					if (isset($set)) {
						echo "<br><h4 class=\"center\">immagine profilo cambiato con successo </h4><br>";
						echo '<br><h4 class="center">proseguite qui: <a class="buttonTemplate" href="profile.php">Profilo</a></h4>';
					} 
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			?>
	</div>
    </div>
    <?php elemento3();?>
</body>
</html>
