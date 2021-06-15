<?php session_start();
	//connessione al database
	require_once 'elementi.php';
	$conn = connect();

	//recupero della sessione
	$idMittente = $_SESSION['user'];
	$idDestinatario = $_SESSION['descrizione'];
	
	//invio alla pagina di descrizione
	if(isset($_POST['descrizione'])){
		//recupero input html
		$descrizione = $_POST['descrizione'];
		//implementazione della sessione
		$_SESSION['descrizione'] = $descrizione;
		header('Location: /descrizione.php');
	}
	
	//azione di blocco
	if(isset($_POST['blocca'])){
		$query = mysqli_query($conn, "SELECT numeratore FROM `bloccati` WHERE id1 = '$idMittente' and id2 = '$idDestinatario");
		$fromObj = @mysqli_fetch_assoc($query);
		$controllo = $fromObj["numeratore"];
		if(@count($controllo) == 0){
			$sql = "INSERT INTO bloccati (id1, id2) VALUES ('$idMittente', '$idDestinatario')";
			if ($conn->query($sql) === TRUE) {
				echo "Contatto bloccato con successo!<br>";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
	}

	//controllo se l'utente è bloccatto
	$query = mysqli_query($conn, "SELECT MAX(numeratore) AS maxBlock FROM `bloccati`");
	$fromObj = mysqli_fetch_assoc($query);
	$maxBlock = $fromObj["maxBlock"];
	$counter = 1;
	while($counter <= $maxBlock and $blocco == 0){
		$query = mysqli_query($conn, "SELECT id1, id2 FROM `bloccati` WHERE numeratore = '$counter'");
		$fromObj = mysqli_fetch_assoc($query);
		$id1 = $fromObj["id1"];
		$id2 = $fromObj["id2"];
		$numBlock = $counter;
		if($id1 == $idMittente){
			$blocco = 1;
		}else if($id1 == $idDestinatario){
			$blocco = 2;
		} else {
			$blocco = 0;
		}
		$counter++;
	}
	
	//azione di sblocco
	if(isset($_POST['sblocca'])){
		$sql = "DELETE FROM `bloccati` WHERE numeratore = '$numBlock'";
		if ($conn->query($sql) === TRUE) {
			echo "<br>Utente sbloccato con successo";
			$blocco = 0;
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
?>

<html>
	<body>
		<form method="post">
			<input type="submit" name="more" class="button" value="Cliccate qui per vedere tutti i messaggi"><br>
			<textarea name="messaggio" rows="12" cols="120" maxlength="1024" placeholder="Potete inserire al massimo 1024 caratteri."></textarea>
			<br><input type="submit" value="Invia">
			<?php
				if($blocco == 0){
					echo '<input name="blocca" value="Blocca Utente" type="submit">';
				} else if($blocco == 1){
					echo '<input name="sblocca" value="Sblocca Utente" type="submit">';
				} else if($blocco == 2){
					echo '<h1>L\'utente ti ha bloccato</h1>';
				}
			?>
		<br>
		  <a href="/descrizione.php"> Torna alla descrizione </a>
		</form>
	</body>
</html>

<?php
	//recupero input html
	$messaggio = san($conn, $_POST['messaggio']);
	
	//inserzione del messaggio nella tabella
	if($idMittente == 0){
	    echo'
	    <h2> Mi spiace, ma prima di partecipare alle discussioni dovrete accedere al sito con il vostro account </h2>
	    <h2> Cliccate <a /signin.html">qui</a> per accedere oppure <a href="/signup.html">qua</a> per creare un nuovo account.<h2>
	    <h2> Tornate presto con noi! </h2>';
	} else {
		if($messaggio != NULL){
			if($messaggio != $_SESSION['messaggio']){
				$sql = "INSERT INTO messaggi (idMittente, idDestinatario, messaggi) VALUES ('$idMittente', '$idDestinatario', '$messaggio')";
				if ($conn->query($sql) === TRUE) {
					echo "Pronto per inviare un altro messaggio!<br>";
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			} else {
				echo '<h3>Per favore evitate di spammare!</h3>';
			}
		} else {
			echo '<h2> Ricorda di inserire il testo nei messaggi che invii. </h2>';
		}
	}
	
	//resa impossibile dello spamming ed evitazione dell'invio di messaggi ad ogni ricarica di pagina
	$_SESSION['messaggio'] = $messaggio;
	
	//printaggio dei messaggi inviati all'utente
	$query = mysqli_query($conn, "SELECT MAX(numeratore) AS MaxNumeratore FROM messaggi");
	$fromObj = mysqli_fetch_array($query);
	$max = $fromObj["MaxNumeratore"];

	if($blocco == 0){
		//stampaggio dei messaggi
		while($max >= 1){
			$query = mysqli_query($conn, "SELECT idDestinatario, idMittente FROM `messaggi` WHERE numeratore = '$max'");
			$fromObj = mysqli_fetch_assoc($query);
			$Destinatario = $fromObj["idDestinatario"];
			$Mittente = $fromObj["idMittente"];
			if(($Destinatario == $idMittente and $Mittente == $idDestinatario) or ($Mittente == $idMittente and $Destinatario == $idDestinatario)){
				$query = mysqli_query($conn, "SELECT messaggi, data FROM `messaggi` WHERE numeratore = '$max'");
				$fromObj = mysqli_fetch_assoc($query);
				$data = $fromObj["data"];
				$messaggio = $fromObj["messaggi"];
				$query = mysqli_query($conn, "SELECT username, picture FROM `utenti` WHERE user_id = '$Mittente'");
				$fromObj = mysqli_fetch_assoc($query);
				$username = $fromObj["username"];
				$pic = $fromObj["picture"];
				echo "<img src=/profili/im$pic.jpg>";
				echo "<h3><form method='post'></form><input type='submit' name='descrizione' value='$Mittente'>$username</input></form> $data</h3>";
				if($Mittente == $idMittente){
					$query = mysqli_query($conn, "SELECT username FROM `utenti` WHERE user_id = '$Destinatario'");
					$fromObj = mysqli_fetch_assoc($query);
					$username = $fromObj["username"];
					echo "<h3>a $username</h3>";
				}
				echo "<h4>$messaggio</h4>";
			}
			$max--;
		}
	}
?>

<h3 style="margin-top:100px; text-align="center;"">Questa funzionalita' sara' implementata tra poco, per ora, <a href="/index.php" style="color:#11c8d8">tornate al sito</a></h3>
