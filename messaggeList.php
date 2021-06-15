<?php
	//connessione al database
	require_once 'elementi.php';
	connect();
	
	//recupero della sessione
	$id = $_SESSION['user'];

	//recupero del numero totale di messaggi privati dalla tabella
	$query = mysqli_query($conn, "SELECT MAX(numeratore) AS maxNumeratore FROM messaggi");
	$fromObj = mysqli_fetch_array($query);
	$max = $fromObj["maxNumeratore"];
	
	//prelievo e riordino degli ultimi messaggi ricevuti
	$personeGiàViste = array($id); //inserirò gli id degli utenti di cui si ha già printato l'ultimo messaggio in questo array per evitare di ripeterli
	while($max > 0){
		//recupero del mittente e del destinatario dei messaggi
		$query = mysqli_query($conn, "SELECT idDestinatario, idMittente FROM messaggi WHERE numeratore = '$max'");
		$fromObj = mysqli_fetch_assoc($query);
		$destinatario = $fromObj["idDestinatario"];
		$mittente = $fromObj["idMittente"];
		if($destinatario == $id AND !in_array($mittente, $personeGiàViste)){
			//recupero di informazioni sull'utente
			$query = mysqli_query($conn, "SELECT username, description, picture, ruolo FROM utenti WHERE user_id='$mittente'");
			$fromObj = mysqli_fetch_assoc($query);
			$username = $fromObj['username'];
			$pic = $fromObj['picture'];
			$description = $fromObj['description'];
			$ruolo = $fromObj['ruolo'];
			if($ruolo == 1){
				$ruolo = 'Donatore';
			} else if($ruolo == 2){
				$ruolo = 'Sviluppatore';
			} else if($ruolo == 3){
				$ruolo = 'Moderatore';
			}
			$pic = $fromObj["picture"];
			
			//recupero del contenuto del messaggio
			$query = mysqli_query($conn, "SELECT messaggi, data FROM `messaggi` WHERE numeratore = '$max'");
			$fromObj = mysqli_fetch_assoc($query);
			$data = $fromObj["data"];
			$messaggio = $fromObj["messaggi"];
				
			//printaggio
			echo "<img src=/profili/im$pic.jpg>";
			echo "<h3><form method='post'></form><input type='submit' name='descrizione' value='$Mittente'>$username</input></form> $data</h3>";
			echo "<h4>$messaggio</h4>";
			
			array_push($personeGiàViste, $destinatario);
		}
		$max--;
	}
?>
