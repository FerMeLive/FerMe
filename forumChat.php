<?php
	require_once 'elementi.php';
	$conn = connect();
	
	//recupero sessione
	session_start();
	$id = $_SESSION['user'];
	$forum = $_SESSION['forum'];
	$visualizzaLoStesso = $_SESSION['visualizzaLoStesso'];
	$query = mysqli_query($conn, "SELECT ruolo FROM `utenti` WHERE user_id = '$id'");
	$fromObj = mysqli_fetch_assoc($query);
	if($fromObj['ruolo'] == 3){
		$moderatore = TRUE;
	}
	
	//assegnazione ai moderatori del potere di cancellare un messaggio
	if(isset($_POST['delete'])){
		$messaggioDaCancellare = $_POST['delete'];
		$sql = "DELETE FROM `$forum` WHERE numeratore='$messaggioDaCancellare'";
		
		if ($conn->query($sql) === TRUE) {
			//echo "<br>Messaggio cancellato con successo";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		//cancellazione anche delle segnalazioni
		$sql = "DELETE FROM `segnalazioni` WHERE messaggio='$messaggioDaCancellare' AND forum='$forum'";
		
		if ($conn->query($sql) === TRUE) {
			//echo "<br>Messaggio cancellato con successo";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	
	//passaggio alla pagina di descrizione di un utente
	if(isset($_POST['descrizione'])){
		//recupero input html
		$descrizione = $_POST['descrizione'];
		//implementazione della sessione
		$_SESSION['descrizione'] = $descrizione;
		header('Location: /descrizione.php');
	}
	
	//assegnazione ai moderatori del potere di modificare un messaggio
	if(isset($_POST['modifica'])){
		$_SESSION['modifica'] = $_POST['modifica'];
		header('Location: /modMess.php');
	}
	
	//assegnazione agli utenti della possibilità di segnalare
	if(isset($_POST['segnala'])){
		$messaggio = $_POST['segnala'];
		
		$query = mysqli_query($conn, "SELECT * FROM `segnalazioni` WHERE messaggio = '$messaggio' AND idSegnalatore = '$id' AND forum = '$forum'");
		$fromObj = mysqli_fetch_assoc($query);
		if(@count($fromObj) == 0){
			$sql = "INSERT INTO segnalazioni(messaggio, idSegnalatore, forum) VALUES ('$messaggio', '$id', '$forum')";
			
			if ($conn->query($sql) === TRUE) {
				//echo "<br>Segnalazione registrata con successo";
			} else {
				//echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
	}
	
	//assegnazione agli utenti della possibilità di anullare le segnalazioni
	if(isset($_POST['annullaSegnalazione'])){
		$messaggio = $_POST['annullaSegnalazione'];
		$sql = "DELETE FROM segnalazioni WHERE messaggio = '$messaggio' AND idSegnalatore = '$id' AND forum = '$forum'";
		
		if ($conn->query($sql) === TRUE) {
			//echo "<br>Segnalazione annullata con successo";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	
	//assegnazione ai moderatori del potere di togliere tutte le segnalazioni relative ad un messaggio
	if(isset($_POST['cancellaTutteLeSegnalazioni'])){
		$messaggio = $_POST['cancellaTutteLeSegnalazioni'];
		$sql = "DELETE FROM segnalazioni WHERE messaggio = '$messaggio' AND forum = '$forum'";
		
		if ($conn->query($sql) === TRUE) {
			//echo "<br>Segnalazione annullata con successo";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	
	//assegnazione agli utenti della possibilità di visualizzare un messaggio segnalato
	if(isset($_POST['visualizzaLoStesso'])){
		$messaggio = $_POST['visualizzaLoStesso'];
		if(!in_array($messaggio, $visualizzaLoStesso)){
			if($visualizzaLoStesso == NULL){
				$visualizzaLoStesso = array($messaggio);
			} else {
				array_push($visualizzaLoStesso, $messaggio);
			}
			$_SESSION['visualizzaLoStesso'] = $visualizzaLoStesso;
		}
	}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cssFolder/forumChat.css">
    <link rel="shortcut icon" type="image/png" href="/imagesFolder/faviconImg.png">
    <title>Chat | FerMe</title>
    <style>
        @media screen and (max-width: 800px){
            .mainContent .welcomeBlock{
                margin-left: 20px;
            }
            .messaggio{
                margin-left: 20px;
                min-width: 90%;
            }
            #primaChattarePopup{
                max-width: 500px;
                min-width: 350px;
            }
            .cookiePopup{
                max-width: 500px;
                min-width: 330px;
            }
            .delMsgForm{
                margin-left: 25px;
            }
            .modMsgForm{
                margin-left: 50px;
            }
            #primaChattarePopup{
                max-width: 500px;
                min-width: 330px;
            }
            .scriviBox form{
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <input type="checkbox" id="showScriviBox">
    
    <?php
		elemento1();
		elemento2($conn);
	?>
    <label id="showScriviBoxBtn" for="showScriviBox"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M19.769 9.923l-12.642 12.639-7.127 1.438 1.438-7.128 12.641-12.64 5.69 5.691zm1.414-1.414l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z"/></svg>Scrivi un messaggio</label>

    <div class="mainContent">
    	<div class="welcomeBlock">
            <h1><?php echo $forum; ?></h1>
            <a class="forumBackBtn" href="/forum.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M0 12l9-8v6h15v4h-15v6z"/></svg>Torna alla lista dei forum</a>
        </div>
        
        <div class="scriviBox">
            <form method="post">
                <textarea required="true" name="messaggio" rows="12" cols="120" maxlength="1024" placeholder="Massimo 1024 caratteri. Ricordatevi di accedere con un account prima di chattare"></textarea><br>
                <div>
                    <input class="inviaBtn" name="invia" type="submit" value="Invia">
                    <label for="showScriviBox" class="closeBtn">Chiudi</label>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        var loginChatPopup = document.getElementById("primaChattarePopup");
        var closeBtn = document.getElementById("closeBtn");

        closeBtn.onclick = () => {
            loginChatPopup.classList.add("closeLoginChatPopup");
        }
    </script>
	<?php
		elemento3();
		if(isset($_POST['invia'])){
			if($id == 0){
				echo'
					<script type="text/javascript">
						var loginChatPopup = document.getElementById("primaChattarePopup");
						var closeBtn = document.getElementById("closeBtn");

						closeBtn.onclick = () => {
							loginChatPopup.classList.add("closeLoginChatPopup");
						}
					</script>';
			} else {
				//ricezione delle informazioni da html
				$messaggio = san($conn, $_POST['messaggio']);
				//inserimento del messaggio nella tabella
				if(censura($messaggio) and $messaggio != NULL){
					if($messaggio != $_SESSION['messaggio']){
						$sql = "INSERT INTO $forum (id, messaggi) VALUES ('$id', '$messaggio')";
						if ($conn->query($sql) === TRUE) {
							// ishoshndos
						} else {
							echo "Error: " . $sql . "<br>" . $conn->error;
						}
					}
				}
			}
		}
		
		//resa impossibile dello spamming ed evitazione dell'invio di messaggi ad ogni ricarica di pagina
		$_SESSION['messaggio'] = $messaggio;
		
		//selezione degli ultimi 50 messaggi inviati
		$query = mysqli_query($conn, "SELECT MAX(numeratore) AS MaxNumeratore FROM $forum");
		$fromObj = @mysqli_fetch_array($query);
		$max = $fromObj["MaxNumeratore"];
		if(isset($_POST['more'])){
			$contatore = 1;
		} else {
			$contatore = $max - 50;
		}
		
		//ciclo di printaggio dei messaggi
		while($max >= $contatore){
			$query = mysqli_query($conn, "SELECT id, messaggi, data FROM `$forum` WHERE numeratore = '$max'");
			$fromObj = mysqli_fetch_assoc($query);
			$idMittente = $fromObj["id"];
			if($idMittente != 0){
				//recupero di varie informazioni per printare un bel messaggio
				$orario = $fromObj["data"];
				$messaggio = $fromObj["messaggi"];
				$query = mysqli_query($conn, "SELECT username, picture, ruolo FROM `utenti` WHERE user_id = '$idMittente'");
				$fromObj = mysqli_fetch_assoc($query);
				$username = $fromObj["username"];
				$ruolo = $fromObj['ruolo'];
				if($ruolo == 1){
					$ruolo = 'Donatore';
				} else if($ruolo == 2){
					$ruolo = 'Sviluppatore';
				} else if($ruolo == 3){
					$ruolo = 'Moderatore';
				}
				$pic = $fromObj["picture"];
				
				//recupero del numero di segnalazioni
				$sql="select count(*) as total from segnalazioni where forum = '$forum' and messaggio = '$max'";
				$result=mysqli_query($conn,$sql);
				$data=@mysqli_fetch_assoc($result);
				$segnalazioni = $data['total'];
				
				//printaggio del messaggio
				echo "<div class='messaggio'>
					<div class='topBlock'><img src=/profili/im$pic.jpg width='80' height='80'><div class='userInfoBlock'><form method='post'><button type='submit' name='descrizione' value='$idMittente'>$username</button><p class='ruoloTxt'>$ruolo</p><p class='dataTxt'>$orario</p></form></div></div><h4 class='messaggioTxt'>";
				//censurazione in caso di segnalazioni
				if($segnalazioni == 0){
					echo $messaggio;
				} else {
					//controllo se questo messaggio può essere visualizzato lo stesso per volontà dell'utente
					$contatore1 = 0;
					$stato = FALSE;
					while($contatore1 < sizeof($visualizzaLoStesso)){
						if($visualizzaLoStesso[$contatore1] == $max){
							$stato = TRUE;
						}
						$contatore1++;
					}
					if($stato){
						echo $messaggio;
					} else {
						echo "$segnalazioni utenti hanno ritenuto questo messaggio offensivo.<br><form method=post><button class='visualizzaBtn' type='submit' style='position:relative;
	border: none;
	border-radius: 20px;
	background: #d9d9d9;
	padding:6px;' name='visualizzaLoStesso' value='$max'>visualizza lo stesso</button></form>";
					}
				}
				echo"</h4></div>";
				if($moderatore == TRUE or $idMittente == $id){
					echo "<form class='delMsgForm' method='post'><button type='submit' name='delete' value='$max'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24'><path d='M3 6v18h18v-18h-18zm5 14c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4-18v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712z'/></svg></button></form>";
					echo "<form class='modMsgForm' method='post'><button style='position:relative; top:-0.35em;' type='submit' name='modifica' value='$max'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24'><path d='M19.769 9.923l-12.642 12.639-7.127 1.438 1.438-7.128 12.641-12.64 5.69 5.691zm1.414-1.414l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z'/></svg></button></form>";
				}
				
				//controllo se questo messaggio è già stato segnalato dall'utente
				$query = mysqli_query($conn, "SELECT * FROM segnalazioni WHERE messaggio = '$max' AND idSegnalatore = '$id' AND forum = '$forum'");
				$fromObj = mysqli_fetch_assoc($query);
				if(@count($fromObj) == 0){
					echo "<form class='segnalaMsgForm' method=\"post\"><button style='position:relative; right: -1em;' type='submit' class='segnala' name='segnala' value='$max'><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" viewBox=\"0 0 24 24\"><path d=\"M4 24h-2v-24h2v24zm18-22h-16v12h16l-4-5.969 4-6.031z\"/></svg>Segnala</button></form>";
				} else {
					echo "<form method=post><button type='submit' style='position:relative;
	border: none;
	border-radius: 20px;
	background: #d9d9d9;
	padding:6px;' name='annullaSegnalazione' value='$max'>annulla segnalazione</button></form>";
				}
				if($moderatore == TRUE AND $segnalazioni != 0){
					echo "<form method=post><button type='submit' name='cancellaTutteLeSegnalazioni' value='$max'>cancella tutte le segnalazioni</button></form>";
				}
			}
			$max--;
		}
	?>
	<br><form style="margin:auto; width:95%"><input style="border-width: 0"class="forumBackBtn" type="submit" name="more" value="voglio vedere tutti i messaggi  "></form>
</body>
</html>
