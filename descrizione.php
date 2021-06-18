<?php require_once'elementi.php';?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cssFolder/index.css">
    <link rel="stylesheet" href="/cssFolder/pageStyle.css">
    <link rel="shortcut icon" type="image/png" href="/imagesFolder/faviconImg.png">
    <title>FerMe | Visualizza utente</title>
</head>
<body>
	<!--php che prende dati e tutto quanto-->
	<?php
		$conn = connect();
		session_start();
		elemento1();
		elemento2($conn);
		//avvio della sessione
		$idDestinatario = $_SESSION['descrizione'];
		$id = $_SESSION['user'];
		
		//recupero dati dalla tabella
		$query = mysqli_query($conn, "SELECT username, email, picture, description FROM utenti WHERE user_id='$idDestinatario'");
		$fromObj = mysqli_fetch_assoc($query);
		$username = $fromObj['username'];
		$mail = $fromObj['email'];
		$pic = $fromObj['picture'];
		$description = $fromObj['description'];
		
		//recupero del numero di messaggi inviati nei forum
		$sql="select count(*) as total from anime where id='$idDestinatario'";
		$result=mysqli_query($conn,$sql);
		$data=mysqli_fetch_assoc($result);
		$anime = $data['total'];
		
		$sql="select count(*) as total from arte where id='$idDestinatario'";
		$result=mysqli_query($conn,$sql);
		$data=mysqli_fetch_assoc($result);
		$arte = $data['total'];
		
		$sql="select count(*) as total from cinema where id='$idDestinatario'";
		$result=mysqli_query($conn,$sql);
		$data=mysqli_fetch_assoc($result);
		$cinema = $data['total'];
		
		$sql="select count(*) as total from compiti where id='$idDestinatario'";
		$result=mysqli_query($conn,$sql);
		$data=mysqli_fetch_assoc($result);
		$compiti = $data['total'];
		
		$sql="select count(*) as total from cucina where id='$idDestinatario'";
		$result=mysqli_query($conn,$sql);
		$data=mysqli_fetch_assoc($result);
		$cucina = $data['total'];
		
		$sql="select count(*) as total from gaming where id='$idDestinatario'";
		$result=mysqli_query($conn,$sql);
		$data=mysqli_fetch_assoc($result);
		$gaming = $data['total'];
		
		$sql="select count(*) as total from hobby where id='$idDestinatario'";
		$result=mysqli_query($conn,$sql);
		$data=mysqli_fetch_assoc($result);
		$hobby = $data['total'];
		
		$sql="select count(*) as total from informatica where id='$idDestinatario'";
		$result=mysqli_query($conn,$sql);
		$data=mysqli_fetch_assoc($result);
		$informatica = $data['total'];
		
		$sql="select count(*) as total from musica where id='$idDestinatario'";
		$result=mysqli_query($conn,$sql);
		$data=mysqli_fetch_assoc($result);
		$musica = $data['total'];
		
		$sql="select count(*) as total from sport where id='$idDestinatario'";
		$result=mysqli_query($conn,$sql);
		$data=mysqli_fetch_assoc($result);
		$sport = $data['total'];
		
		$sql="select count(*) as total from altro where id='$idDestinatario'";
		$result=mysqli_query($conn,$sql);
		$data=mysqli_fetch_assoc($result);
		$altro = $data['total'];
		
		$tot = $anime + $arte + $cinema + $compiti + $cucina + $gaming + $hobby + $informatica + $musica + $sport + $altro;
		function percent($var, $tot){
			if($var == 0){
				$result = 0;
			} else {
				round($result = $var * 100 / $tot, 2);
			}
			return $result;
		}
		
		$animePercent = round(@percent($anime, $tot));
		$artePercent = round(@percent($arte, $tot));
		$cinemaPercent = round(@percent($cinema, $tot));
		$compitiPercent = round(@percent($compiti, $tot));
		$cucinaPercent = round(@percent($cucina, $tot));
		$gamingPercent = round(@percent($gaming, $tot));
		$hobbyPercent = round(@percent($hobby, $tot));
		$informaticaPercent = round(@percent($informatica, $tot));
		$musicaPercent = round(@percent($musica, $tot));
		$sportPercent = round(@percent($sport, $tot));
		$altroPercent = round(@percent($altro, $tot));
		
		if(isset($_POST['descrizione'])){
			//recupero input html
			$descrizione = $_POST['descrizione'];
			//implementazione della sessione
			$_SESSION['descrizione'] = $descrizione;
			header('Location: /descrizione.php');
		}
		
	?>
	<!--display informazioni, qua giu anche div per farlo bello-->
	<div id="Main">
		<div class="divFloat">
			<!--Informazioni generali-->
			<h3 class="center">Info</h3><br>
			
			<!--profile box-->
			<div class="profileBox">
				<div class="center">
					<?php echo "<img class=\"profileImg\" src=\"/profili/im$pic.jpg\">";?><br><br>
					<h4><strong>Nome Utente:</strong> <?php echo $username;?></h4>
				</div>
			</div>
			<br>
			
			<!--cose amicizie-->
			<div class="amBox" class="center">
				<!--<a href="/messaggi.php" class="buttonTemplate"> Messaggiate Privatamente </a>-->
				<?php
					//amicizia
					if($id != 0){
						//ricezione input
						if(isset($_POST['eliminaAmicizia1'])){
							$sql = "DELETE FROM amici WHERE id2 = '$idDestinatario' AND id1 = '$id'";	
							if ($conn->query($sql) === TRUE) {
								echo 'Amicizia eliminata con successo';
							} else {
								echo 'Errore nell\'eliminazione dell\'amicizia';
							}
						}
						if(isset($_POST['eliminaAmicizia2'])){
							$sql = "DELETE FROM amici WHERE id1 = '$idDestinatario' AND id2 = '$id'";	
							if ($conn->query($sql) === TRUE) {
								echo 'Amicizia eliminata con successo';
							} else {
								echo 'Errore nell\'eliminazione dell\'amicizia';
							}
						}
						if(isset($_POST['richiestaAmicizia'])){
							$query = mysqli_query($conn, "SELECT pending FROM amici WHERE id1 = '$id' AND id2 = '$idDestinatario'");
							$fromObj = mysqli_fetch_array($query);
							if(@count($fromObj) < 1){
								$sql = "INSERT INTO amici (id1, id2, pending) VALUES ('$id', '$idDestinatario', 1)";
								if ($conn->query($sql) === TRUE) {
									//echo "Errore nell'invio della richiesta di amicizia<br>";
								} else {
									echo "Error: " . $sql . "<br>" . $conn->error;
								}
							}
						}
						if(isset($_POST['accettaAmicizia'])){
							$sql = "UPDATE amici SET pending = 0 WHERE id2 = '$id' AND id1 = '$idDestinatario'";
							if ($conn->query($sql) === TRUE) {
								echo "Amicizia accettata con successo<br>";
							} else {
								echo "Error: " . $sql . "<br>" . $conn->error;
							}
						}
						
						//creazione input
						$query = mysqli_query($conn, "SELECT pending FROM amici WHERE id1 = '$id' AND id2 = '$idDestinatario'");
						$fromObj = mysqli_fetch_array($query);
						if(@count($fromObj) > 0){
							$pending = $fromObj['pending'];
							if($pending == 1){
								echo "<form method='post'><input class=\"buttonTemplate\" type='submit' name='eliminaAmicizia1' value='Anulla Richiesta di Amicizia'></form>";
							} else {
								echo "<form method='post'><input class=\"buttonTemplate\" type='submit' name='eliminaAmicizia2' value='Elimina Amicizia'></form>";
							}
						} else {
							$query = mysqli_query($conn, "SELECT pending FROM amici WHERE id1 = '$idDestinatario' AND id2 = '$id'");
							$fromObj = mysqli_fetch_array($query);
							if(@count($fromObj) < 1){
								echo "<form method='post'><input class=\"buttonTemplate\" type='submit' name='richiestaAmicizia' value='Richiedi Amicizia'></form>";
							} else {
								$pending = $fromObj['pending'];
								if($pending == 1){
									echo "<form method='post'><input class=\"buttonTemplate\" type='submit' name='accettaAmicizia' value='Accetta Amicizia'></form>";
								} else {
									echo "<form method='post'><input class=\"buttonTemplate\" type='submit' name='eliminaAmicizia1' value='Elimina Amicizia'></form>";
								}
							}
						}
					}
				?>
			</div>
			<br>
			
			<h4 class="center">Statistiche</h4><br>
			<div class="center"><strong><?php echo $tot; ?> messaggi inviati</strong><br><br></div>
			<div class="statBox"><b>anime</b><br><?php echo $animePercent; ?>%</div><br><br>
			<div class="statBox"><b>cinema</b><br><?php echo $cinemaPercent; ?>%</div><br><br>
			<div class="statBox"><b>compiti</b><br><?php echo $compitiPercent; ?>%</div><br><br>
			<div class="statBox"><b>cucina</b><br><?php echo $cucinaPercent; ?>%</div><br><br>
			<div class="statBox"><b>gaming</b><br><?php echo $gamingPercent; ?>%</div><br><br>
			<div class="statBox"><b>hobby</b><br><?php echo $hobbyPercent; ?>%</div><br><br>
			<div class="statBox"><b>informatica</b><br><?php echo $informaticaPercent; ?>%</div><br><br>
			<div class="statBox"><b>musica</b><br><?php echo $musicaPercent; ?>%</div><br><br>
			<div class="statBox"><b>sport</b><br><?php echo $sportPercent; ?>%</div><br><br>
			
					
			<!--Descrizione-->
			<div class="descBox">
				<h4 class="center"><strong>Descrizione:</strong></h4>
				<br>
				<pre style= font-size: 18px;  text-align: center; font-family: "Avenir, Verdana, sans-serif";>
				<?php echo $description;?>
				</pre>
				<br>
			</div>
			<br>
		</div>
	</div>
	<?php elemento3();?>
</body>
</html>
