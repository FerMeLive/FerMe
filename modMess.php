<?php require_once'elementi.php';?>
<html>
	<head>
		<title>FerMe | Modifica Messaggio</title>
		<link rel="stylesheet" href="/cssFolder/index.css">
		<link rel="stylesheet" href="/cssFolder/pageStyle.css">
	</head>
	<body>
		<?php
			$conn = connect();
			session_start();
			elemento1();
			elemento2($conn);
			//recupero della sessione
			$modifica = $_SESSION['modifica'];
			$forum = $_SESSION['forum'];
			$query = mysqli_query($conn, "SELECT messaggi FROM $forum WHERE numeratore = $modifica");
			$fromObj = mysqli_fetch_assoc($query);
		?>
		
		<div id="Main">
			<div id="divFloat">
				<h3 class="center">Modificare Messaggio</h3><br>
				<form method="post">
					<textarea class="center" name="messaggio" rows="12" cols="120" maxlength="1024" placeholder="Potete inserire al massimo 1024 caratteri."><?php echo $messaggio;?></textarea>
					<br><br>
					<div class="center">
						<input type="submit" value="Invia" class="buttonTemplate">
						<a href="/forumChat.php" class="buttonTemplate"> anulla </a><br>
					</div>
				</form>
				
				<?php
				
					//inserimento del messaggio nella tabella
					if (isset($_POST['messaggio'])) {
						$messaggio = $_POST['messaggio'];
						if(censura($messaggio)){
							$messaggioUpdate = san($conn, $messaggio);
							$sql = "UPDATE $forum SET messaggi = '$messaggioUpdate' WHERE numeratore = $modifica";
							
							if ($conn->query($sql) === TRUE) {
								echo '<h4 class="center"><br>Messaggio modificato correttamente&emsp;<a href="/forumChat.php" class="buttonTemplate"> torna </a></h4>';
							} else {
								echo "Error: " . $sql . "<br>" . $conn->error;
							}
						}
					}
					
					//metto sto pezzo di codice dopo l'inserimento nella tabella perché così si possono vedere in tempo reale i cambiamenti effettuati senza dover ricaricare la pagina
					$query = mysqli_query($conn, "SELECT messaggi FROM $forum WHERE numeratore = $modifica");
					$fromObj = mysqli_fetch_assoc($query);
					$messaggio = $fromObj['messaggi'];
				?>
			</div>
		</div>
		<?php elemento3();?>
	</body>
</html>
