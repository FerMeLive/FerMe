<?php
	//connessione al database
	require_once 'elementi.php';
	$conn = connect();
	session_start();
	
	$id = $_SESSION["user"];
	
	if (!isset($id)){
		header("Location:signin.php");
	}
	
	//ricezione input
	if(isset($_POST['eliminaAmicizia1'])){
		$idDestinatario = $_POST['eliminaAmicizia1'];
		$sql = "DELETE FROM amici WHERE id2 = '$idDestinatario' AND id1 = '$id'";	
		if ($conn->query($sql) === TRUE) {
			echo 'Amicizia eliminata con successo';
		} else {
			echo 'Errore nell\'eliminazione dell\'amicizia';
		}
	}
	if(isset($_POST['eliminaAmicizia2'])){
		$idDestinatario = $_POST['eliminaAmicizia2'];
		$sql = "DELETE FROM amici WHERE id1 = '$idDestinatario' AND id2 = '$id'";	
		if ($conn->query($sql) === TRUE) {
			echo 'Amicizia eliminata con successo';
		} else {
			echo 'Errore nell\'eliminazione dell\'amicizia';
		}
	}
	if(isset($_POST['accettaAmicizia'])){
		$idDestinatario = $_POST['accettaAmicizia'];
		$sql = "UPDATE amici SET pending = 0 WHERE id2 = '$id' AND id1 = '$idDestinatario'";
		if ($conn->query($sql) === TRUE) {
			echo "Amicizia accettata con successo<br>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	
	//recupero del numero di messaggi inviati nei forum
	$sql="select count(*) as total from anime where id='$id'";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$anime = $data['total'];
	
	$sql="select count(*) as total from arte where id='$id'";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$arte = $data['total'];
	
	$sql="select count(*) as total from cinema where id='$id'";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$cinema = $data['total'];
	
	$sql="select count(*) as total from compiti where id='$id'";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$compiti = $data['total'];
	
	$sql="select count(*) as total from cucina where id='$id'";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$cucina = $data['total'];
	
	$sql="select count(*) as total from gaming where id='$id'";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$gaming = $data['total'];
	
	$sql="select count(*) as total from hobby where id='$id'";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$hobby = $data['total'];
	
	$sql="select count(*) as total from informatica where id='$id'";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$informatica = $data['total'];
	
	$sql="select count(*) as total from musica where id='$id'";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$musica = $data['total'];
	
	$sql="select count(*) as total from sport where id='$id'";
	$result=mysqli_query($conn,$sql);
	$data=mysqli_fetch_assoc($result);
	$sport = $data['total'];
	
	$sql="select count(*) as total from altro where id='$id'";
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
	
	$animePercent = @percent($anime, $tot);
	$artePercent = @percent($arte, $tot);
	$cinemaPercent = @percent($cinema, $tot);
	$compitiPercent = @percent($compiti, $tot);
	$cucinaPercent = @percent($cucina, $tot);
	$gamingPercent = @percent($gaming, $tot);
	$hobbyPercent = @percent($hobby, $tot);
	$informaticaPercent = @percent($informatica, $tot);
	$musicaPercent = @percent($musica, $tot);
	$sportPercent = @percent($sport, $tot);
	$altroPercent = @percent($altro, $tot);
?>

<!DOCTYPE html>
<!-- Benvenuti nel codice schifoso scritto da leo -->
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cssFolder/profile.css">
	<!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="/imagesFolder/faviconImg.png">
    <title>FerMe | Profilo</title>
	<!-- Questo tag in basso serve per rendere il sito "normale" su telefono -->
    <style>
        @media screen and (max-width: 800px){
			.mainContent .welcomeBlock{
				margin-left: 30px;
			}
			.initialProfileBlock{
				margin-left: 30px;
			}
			.mainProfileBlock{
				min-width: 100%;
				display: flex;
				flex-direction: column;
			}
			.profileBlock .rightProfileBlock{
				width: 90%;
				height: 550px;
				margin-left: 30px;
			}
			.modProfileBlock{
				width: 90%;
				margin-left: 30px;
			}
			.mainContent .amicizieBlock{
				margin-left: 30px;
				width: 90%;
			}
			.amicizieBlock{
				margin-left: 30px;
			}
		}
    </style>
</head>
<body>
	<?php
		elemento1();
		elemento2($conn);
		$query = mysqli_query($conn, "SELECT username, password, email, picture, description FROM utenti WHERE user_id='$id'");
		$fromObj = mysqli_fetch_assoc($query);
	?>
    <div class="mainContent">
        <div class="welcomeBlock">
            <h1>Profilo</h1>
            <p>In questa pagina puoi cambiare le impostazioni, foto profilo e altro del tuo account.</p>
        </div>

        <div class="profileBlock">
            <div>
                <div class="initialProfileBlock">
                    <?php $pic = $fromObj['picture']; echo "<img width=\"100\" height=\"100\" class=\"profileImg\" src=\"/profili/im$pic.jpg\">";?>
                    <h3 class="ciaoTxt"><?php echo $fromObj['username']; ?></h3>
                </div>
                <div class="mainProfileBlock">
                    <div class="rightProfileBlock">
                        <p class="emailTxt">Email: <?php echo $fromObj['email'];?></p>
                        <p class="descrizioneTxt">Descrizione: <pre><?php echo $fromObj['description'];?></pre></p>
                        <h3 class="titleTxt">Statistiche</h3>
                        <p class="statisticheTxt">
                            Finora hai inviato:<br>
                            - <?php echo $tot; ?> messaggi in <b>totale</b> su FerMe.<br>
                            - <?php echo $anime; ?> messaggi nel forum sugli <b>anime</b>(<?php echo $animePercent; ?>%).<br>
                            - <?php echo $arte; ?> messaggi nel forum sull'<b>arte</b>(<?php echo $artePercent; ?>%).<br>
                            - <?php echo $cinema; ?> messaggi nel forum sul <b>cinema</b>(<?php echo $cinemaPercent; ?>%).<br>
                            - <?php echo $compiti; ?> messaggi nel forum sui <b>compiti</b>(<?php echo $compitiPercent; ?>%).<br>
                            - <?php echo $cucina; ?> messaggi nel forum sulla <b>cucina</b>(<?php echo $cucinaPercent; ?>%).<br>
                            - <?php echo $gaming; ?> messaggi nel forum sul <b>gaming</b>(<?php echo $gamingPercent; ?>%).<br>
                            - <?php echo $hobby; ?> messaggi nel forum sugli <b>hobby</b>(<?php echo $hobbyPercent; ?>%).<br>
                            - <?php echo $informatica; ?> messaggi nel forum sull'<b>informatica</b>(<?php echo $informaticaPercent; ?>%).<br>
                            - <?php echo $musica; ?> messaggi nel forum sulla <b>musica</b>(<?php echo $musicaPercent; ?>%).<br>
                            - <?php echo $sport; ?> messaggi nel forum sullo <b>sport</b>(<?php echo $sportPercent; ?>%).<br>
                            - <?php echo $altro; ?> messaggi nel forum su <b>altro</b>(<?php echo $altroPercent; ?>%).<br>
                        </p>
                    </div>
                    <div class="modProfileBlock">
                        <h3 class="titleTxt">Account</h3>
                        <a class="modBtn modemailBtn" href="/modEmail.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M24 0l-6 22-8.129-7.239 7.802-8.234-10.458 7.227-7.215-1.754 24-12zm-15 16.668v7.332l3.258-4.431-3.258-2.901z"/></svg>Modifica email</a><br>
                        <a class="modBtn modpicsBtn" href="/profilePics.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M20.822 18.096c-3.439-.794-6.64-1.49-5.09-4.418 4.72-8.912 1.251-13.678-3.732-13.678-5.082 0-8.464 4.949-3.732 13.678 1.597 2.945-1.725 3.641-5.09 4.418-3.073.71-3.188 2.236-3.178 4.904l.004 1h23.99l.004-.969c.012-2.688-.092-4.222-3.176-4.935z"/></svg>Modifica foto profilo</a><br>
                        <a class="modBtn modpassBtn" href="/modPass.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M12.451 17.337l-2.451 2.663h-2v2h-2v2h-6v-1.293l7.06-7.06c-.214-.26-.413-.533-.599-.815l-6.461 6.461v-2.293l6.865-6.949c1.08 2.424 3.095 4.336 5.586 5.286zm11.549-9.337c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zm-3-3c0-1.104-.896-2-2-2s-2 .896-2 2 .896 2 2 2 2-.896 2-2z"/></svg>Modifica password</a><br>
                        <a class="modBtn moddescBtn" href="/modDesc.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M0 3v18h24v-18h-24zm13 14h-10v-.417c-.004-1.112.044-1.747 1.324-2.043 1.403-.324 2.787-.613 2.122-1.841-1.973-3.637-.563-5.699 1.554-5.699 2.077 0 3.521 1.985 1.556 5.699-.647 1.22.688 1.51 2.121 1.841 1.284.297 1.328.936 1.323 2.057v.403zm8 0h-6v-2h6v2zm0-4h-6v-2h6v2zm0-4h-6v-2h6v2z"/></svg>Modifica la descrizione</a><br>
                        <a class="modBtn esciBtn" href="/logout.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M16 9v-4l8 7-8 7v-4h-8v-6h8zm-16-7v20h14v-2h-12v-16h12v-2h-14z"/></svg>Esci</a><br>
                        <a class="modBtn delBtn" href="/accDel.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M3 6v18h18v-18h-18zm5 14c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4-18v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712z"/></svg>Elimina Account</a>
                    </div>
            </div>
                <div class="amicizieBlock">
					<h3 class="titleTxt">Amicizie</h3>
					<h4 class="subtitleTxt">Richieste di amicizie inviate</h4>
					<div class="amicizieBlocks">
					<?php
						//amicizie
						$contatore = 1;
						$query = mysqli_query($conn, "SELECT MAX(numeratore) AS MaxNumeratore FROM amici");
						$fromObj = mysqli_fetch_array($query);
						$max = $fromObj["MaxNumeratore"];
						
						while($contatore <= $max){
							$query = mysqli_query($conn, "SELECT id1, id2, pending FROM amici WHERE numeratore = '$contatore'");
							$fromObj = mysqli_fetch_array($query);
							$id1 = $fromObj["id1"];
							$id2 = $fromObj["id2"];
							$pending = $fromObj["pending"];
							$contatore++;
							if($id1 == $id and $pending == 1){
								$query = mysqli_query($conn, "SELECT username, picture, ruolo FROM `utenti` WHERE user_id = '$id2'");
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
								echo "<div class='richiestaInviataBox'>
									<img class='profileImg' src=/profili/im$pic.jpg>
									<form method='post'>
									<button class='nameBtn' type='submit' name='descrizione' value='$id2'>$username</button>
									</form>
									<form method='post'><button class='delBtn' type='submit' name='anullaRichiesta' value='$id2'>Elimina richiesta</button></form>
								</div>";
							}
						}
					?>

					</div>
					<h4 class="subtitleTxt">Richieste di amicizie</h4>
					<div class="amicizieBlocks">
						<?php
							$contatore = 1;
							$query = mysqli_query($conn, "SELECT MAX(numeratore) AS MaxNumeratore FROM amici");
							$fromObj = mysqli_fetch_array($query);
							$max = $fromObj["MaxNumeratore"];
							while($contatore <= $max){
								$query = mysqli_query($conn, "SELECT id1, id2, pending FROM amici WHERE numeratore = '$contatore'");
								$fromObj = mysqli_fetch_array($query);
								$id1 = $fromObj["id1"];
								$id2 = $fromObj["id2"];
								$pending = $fromObj["pending"];
								$contatore++;
								if($id2 == $id and $pending == 1){
									$query = mysqli_query($conn, "SELECT username, picture, ruolo FROM `utenti` WHERE user_id = '$id1'");
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
									echo "<div class='richiestaInviataBox'>
										<img class='profileImg' src=/profili/im$pic.jpg>
										<form method='post'>
										<button class='nameBtn' type='submit' name='descrizione' value='$id1'>$username</button>
										</form>
										<form method='post'><button class='delBtn' type='submit' name='accettaAmicizia' value='$id1'>Accetta</button></form>
									</div>";
								}
							}
						?>
					</div>

					<h4 class="subtitleTxt">Amici</h4>
					<div class="amicizieBlocks">
						<?php
							$contatore = 1;
							$query = mysqli_query($conn, "SELECT MAX(numeratore) AS MaxNumeratore FROM amici");
							$fromObj = mysqli_fetch_array($query);
							$max = $fromObj["MaxNumeratore"];
							while($contatore <= $max){
								$query = mysqli_query($conn, "SELECT id1, id2, pending FROM amici WHERE numeratore = '$contatore'");
								$fromObj = mysqli_fetch_array($query);
								$id1 = $fromObj["id1"];
								$id2 = $fromObj["id2"];
								$pending = $fromObj["pending"];
								$contatore++;
								if($id2 == $id and $pending == 0){
									$query = mysqli_query($conn, "SELECT username, picture, ruolo FROM `utenti` WHERE user_id = '$id1'");
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
									echo "<div class='richiestaInviataBox'>
										<img class='profileImg' src=/profili/im$pic.jpg>
										<form method='post'>
										<button class='nameBtn' type='submit' name='descrizione' value='$id1'>$username</button>
										</form>
										<form method='post'><button class='delBtn' type='submit' name='eliminaAmicizia2' value='$id1'>Elimina</button></form>
									</div>";
								}
							}

							$contatore = 1;
							while($contatore <= $max){
								$query = mysqli_query($conn, "SELECT id1, id2, pending FROM amici WHERE numeratore = '$contatore'");
								$fromObj = mysqli_fetch_array($query);
								$id1 = $fromObj["id1"];
								$id2 = $fromObj["id2"];
								$pending = $fromObj["pending"];
								$contatore++;
								if($id1 == $id and $pending == 0){
									$query = mysqli_query($conn, "SELECT username, picture, ruolo FROM `utenti` WHERE user_id = '$id2'");
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
									echo "<div class='richiestaInviataBox'>
										<img class='profileImg' src=/profili/im$pic.jpg>
										<form method='post'>
										<button class='nameBtn' type='submit' name='descrizione' value='$id2'>$username</button>
										</form>
										<form method='post'><button class='delBtn' type='submit' name='eliminaAmicizia1' value='$id2'>Elimina amicizia</button></form>
									</div>";
								}
							}
						?>
					</div>
                </div>
            </div>
        </div>
    </div>

	<?php elemento3(); ?>
</body>
</html>
