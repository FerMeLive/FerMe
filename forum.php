<?php require_once'elementi.php';?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/cssFolder/forum.css">
    <link rel="shortcut icon" type="image/png" href="/imagesFolder/faviconImg.png">
    <title>FerMe | Forum</title>
</head>
<body>
	<?php
		session_start();
		
		//entrata nel forum
		if(isset($_POST['forum'])){
			//recupero input html
			$forum = $_POST['forum'];
			//implementazione della sessione
			$_SESSION['forum'] = $forum;
			header('Location: /forumChat.php');
		}
		
		$conn = connect();
		elemento1();
		elemento2($conn);
		
		//recupero del numero di messaggi inviati nei forum
		$sql="select count(*) as total from anime";
		$result=@mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$anime = $data['total'];
		
		$sql="select count(*) as total from arte";
		$result=@mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$arte = $data['total'];
		
		$sql="select count(*) as total from cinema";
		$result=@mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$cinema = $data['total'];
		
		$sql="select count(*) as total from compiti";
		$result=@mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$compiti = $data['total'];
		
		$sql="select count(*) as total from cucina";
		$result=@mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$cucina = $data['total'];
		
		$sql="select count(*) as total from gaming";
		$result=@mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$gaming = $data['total'];
		
		$sql="select count(*) as total from hobby";
		$result=@mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$hobby = $data['total'];
		
		$sql="select count(*) as total from informatica";
		$result=@mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$informatica = $data['total'];
		
		$sql="select count(*) as total from musica";
		$result=@mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$musica = $data['total'];
		
		$sql="select count(*) as total from sport";
		$result=@mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$sport = $data['total'];
		
		$sql="select count(*) as total from altro";
		$result=@mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
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
		
		//recupero del numero di segnalazioni
		$sql="select count(*) as total from segnalazioni where forum = 'anime'";
		$result=mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$segnalazioniAnime = $data['total'];
		
		$sql="select count(*) as total from segnalazioni where forum = 'arte'";
		$result=mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$segnalazioniArte = $data['total'];
		
		$sql="select count(*) as total from segnalazioni where forum = 'cinema'";
		$result=mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$segnalazioniCinema = $data['total'];
		
		$sql="select count(*) as total from segnalazioni where forum = 'compiti'";
		$result=mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$segnalazioniCompiti = $data['total'];
		
		$sql="select count(*) as total from segnalazioni where forum = 'cucina'";
		$result=mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$segnalazioniCucina = $data['total'];
		
		$sql="select count(*) as total from segnalazioni where forum = 'gaming'";
		$result=mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$segnalazioniGaming = $data['total'];
		
		$sql="select count(*) as total from segnalazioni where forum = 'hobby'";
		$result=mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$segnalazioniHobby = $data['total'];
		
		$sql="select count(*) as total from segnalazioni where forum = 'informatica'";
		$result=mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$segnalazioniInformatica = $data['total'];
		
		$sql="select count(*) as total from segnalazioni where forum = 'musica'";
		$result=mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$segnalazioniMusica = $data['total'];
		
		$sql="select count(*) as total from segnalazioni where forum = 'sport'";
		$result=mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$segnalazioniSport = $data['total'];
		
		$sql="select count(*) as total from segnalazioni where forum = 'altro'";
		$result=mysqli_query($conn,$sql);
		$data=@mysqli_fetch_assoc($result);
		$segnalazioniAltro = $data['total'];
	?>

    <div class="mainContent">
        <div class="welcomeBlock">
            <h1>Forum</h1>
            <p>Scegli di cosa vuoi parlare, clicca e... Ready Player One!</p>
        </div>
        <div class="forumChatLinks">
            <form method="POST">
                <label for="informaticaInput">
                    <input id="informaticaInput" name="forum" value="informatica" type="submit">
                    <div class="chatLink">
                        <h3>Informatica</h3><br>
                        <p class="descTxt">Immergetevi tra i geek</p><br>
                        <p class="numMessaggi"><?php echo $informatica;?> Messaggi(<?php echo $informaticaPercent;?>%)</p>
                    </div>
                    <?php
						if($segnalazioniInformatica != 0){
							echo "$segnalazioniInformatica segnalazioni in questo forum";
						}
                    ?>
                </label>
                <label for="cucinaInput">
                    <input id="cucinaInput" name="forum" value="cucina" type="submit">
                    <div class="chatLink">
                        <h3>Cucina</h3><br>
                        <p class="descTxt">Non fatemi venire l'acquolina</p><br>
                        <p class="numMessaggi"><?php echo $cucina;?> Messaggi(<?php echo $cucinaPercent;?>%)</p>
                    </div>
                    <?php
						if($segnalazioniCucina != 0){
							echo "$segnalazioniCucina segnalazioni in questo forum";
						}
                    ?>
                </label>
                <label for="sportInput">
                    <input id="sportInput" name="forum" value="sport" type="submit">
                    <div class="chatLink">
                        <h3>Sport</h3><br>
                        <p class="descTxt">È il momento di sudare!</p><br>
                        <p class="numMessaggi"><?php echo $sport;?> Messaggi(<?php echo $sportPercent;?>%)</p>
                    </div>
                    <?php
						if($segnalazioniSport != 0){
							echo "$segnalazioniSport segnalazioni in questo forum";
						}
                    ?>
                </label>
                <label for="animeInput">
                    <input id="animeInput" name="forum" value="anime" type="submit">
                    <div class="chatLink">
                        <h3>Anime</h3><br>
                        <p class="descTxt">Andiamo a vedere 700 episodi animati</p><br>
                        <p class="numMessaggi"><?php echo $anime;?> Messaggi(<?php echo $animePercent;?>%)</p>
                    </div>
                    <?php
						if($segnalazioniAnime != 0){
							echo "$segnalazioniAnime segnalazioni in questo forum";
						}
                    ?>
                </label>
                <label for="arteInput">
                    <input id="arteInput" name="forum" value="arte" type="submit">
                    <div class="chatLink">
                        <h3>Arte</h3><br>
                        <p class="descTxt">Fatemi vedere il pensiero dell'anima</p><br>
                        <p class="numMessaggi"><?php echo $arte;?> Messaggi(<?php echo $artePercent;?>%)</p>
                    </div>
                    <?php
						if($segnalazioniArte != 0){
							echo "$segnalazioniArte segnalazioni in questo forum";
						}
                    ?>
                </label>
                <label for="cinemaInput">
                    <input id="cinemaInput" name="forum" value="cinema" type="submit">
                    <div class="chatLink">
                        <h3>Cinema</h3><br>
                        <p class="descTxt">Perché non parlare di un film?</p><br>
                        <p class="numMessaggi"><?php echo $cinema;?> Messaggi(<?php echo $cinemaPercent;?>%)</p>
                    </div>
                    <?php
						if($segnalazioniCinema != 0){
							echo "$segnalazioniCinema segnalazioni in questo forum";
						}
                    ?>
                </label>
                <label for="compitiInput">
                    <input id="compitiInput" name="forum" value="compiti" type="submit">
                    <div class="chatLink">
                        <h3>Compiti</h3><br>
                        <p class="descTxt">Hai bisogno d'aiuto?</p><br>
                        <p class="numMessaggi"><?php echo $compiti;?> Messaggi(<?php echo $compitiPercent;?>%)</p>
                    </div>
                    <?php
						if($segnalazioniCompiti != 0){
							echo "$segnalazioniCompiti segnalazioni in questo forum";
						}
                    ?>
                </label>
                <label for="gamingInput">
                    <input id="gamingInput" name="forum" value="gaming" type="submit">
                    <div class="chatLink">
                        <h3>Gaming</h3><br>
                        <p class="descTxt">Divertiamoci con xonotic</p><br>
                        <p class="numMessaggi"><?php echo $gaming;?> Messaggi(<?php echo $gamingPercent;?>%)</p>
                    </div>
                    <?php
						if($segnalazioniGaming != 0){
							echo "$segnalazioniGaming segnalazioni in questo forum";
						}
                    ?>
                </label>
                <label for="hobbyInput">
                    <input id="hobbyInput" name="forum" value="hobby" type="submit">
                    <div class="chatLink">
                        <h3>Hobby</h3><br>
                        <p class="descTxt">Come sprecate il vostro tempo libero?</p><br>
                        <p class="numMessaggi"><?php echo $hobby;?> Messaggi(<?php echo $hobbyPercent;?>%)</p>
                    </div>
                    <?php
						if($segnalazioniHobby != 0){
							echo "$segnalazioniHobby segnalazioni in questo forum";
						}
                    ?>
                </label>
                <label for="musicaInput">
                    <input id="musicaInput" name="forum" value="musica" type="submit">
                    <div class="chatLink">
                        <h3>Musica</h3><br>
                        <p class="descTxt">Cosa cantate sotto la doccia?</p><br>
                        <p class="numMessaggi"><?php echo $musica;?> Messaggi(<?php echo $musicaPercent;?>%)</p>
                    </div>
                    <?php
						if($segnalazioniMusica != 0){
							echo "$segnalazioniMusica segnalazioni in questo forum";
						}
                    ?>
                </label>
                <label for="altroInput">
                    <input id="altroInput" name="forum" value="altro" type="submit">
                    <div class="chatLink">
                        <h3>Altro</h3><br>
                        <p class="descTxt">Hai altro da dire?</p><br>
                        <p class="numMessaggi"><?php echo $altro;?> Messaggi(<?php echo $altroPercent;?>%)</p>
                    </div>
                    <?php
						if($segnalazioniAltro != 0){
							echo "$segnalazioniAltro segnalazioni in questo forum";
						}
                    ?>
                </label>
            </form>
        </div>
    </div>
	<?php elemento3();?>
</body>
</html>
