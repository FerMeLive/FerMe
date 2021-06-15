<?php
	//popup cookie
	function elemento1(){
		echo '
		<!-- Varie checkbox per non inserire varie form -->
		<input type="checkbox" id="showMenu">
		<!-- Popup cookie-->
		<div class="cookiePopup">
			<img class="cookieImg" src="imagesFolder/cookieIcon.png" width="80px" height="80px">
			<div class="content">
				<h3>Cookie</h3>
				<p>Usiamo i cookie per permettervi di avere un\'esperienza<br> individualmente propria al\'interno di FerMe.
				Ti ricordiamo che questo sito è <strong>OPEN SOURCE</strong> e puoi controllare come gestiamo i tuoi dati nella nostra pagina GitHub. In alternativa puoi guardare la nostra Privacy Policy.</p>
				<button type="button" class="popupBtn">OK</button><br>
				<a href="/privacyPolicy.php" target="_blank" rel="noopener noreferrer" class="linkPrivacyPolicy">Privacy policy</a><a href="https://github.com/FerMeLive/FerMe" class="linkGithub" target="_blank" rel="noopener noreferrer">Github</a>
			</div>
		</div>
		'
		;
	}
	
	//header e sidebar
	function elemento2 ($conn) {
		$id = $_SESSION['user'];
		if($id == NULL){
			echo '<div class="header">
					<label for="showMenu" class="showMenuBtn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 18c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3zm0-9c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3zm0-9c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3z"/></svg></label>
					<img class="fermeLogo" src="/imagesFolder/fermeLogo.png" width="50px" height="50px">
					<a type="button" href="/signup.php" target="_blank" rel="noopener noreferrer" class="regBtn">Registrati</a>
				</div>';
		} else {
			$query = mysqli_query($conn, "SELECT username FROM `utenti` WHERE user_id = $id");
			$fromObj = mysqli_fetch_assoc($query);
			$username = $fromObj["username"];
			echo "<div class=\"header\">
					<label for=\"showMenu\" class=\"showMenuBtn\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\"><path d=\"M12 18c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3zm0-9c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3zm0-9c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3z\"/></svg></label>
					<img class=\"fermeLogo\" src=\"/imagesFolder/fermeLogo.png\" width=\"50px\" height=\"50px\">
					<div class=\"navInfoBtn\">
						<strong><p>Benvenuto, $username</p></strong>
					</div>
				</div>";
		}
		
		echo '
		<!-- Barra laterale  -->
		<div class="sidebar">
			<ul>
				<li>
					<a href="/index.php">
						<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M21 13v10h-6v-6h-6v6h-6v-10h-3l12-12 12 12h-3zm-1-5.907v-5.093h-3v2.093l3 3z"/></svg>
						<span>Home</span>
					</a>
				</li>
				<li>
					<a href="/incontri.php">
						<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M17.997 18h-11.995l-.002-.623c0-1.259.1-1.986 1.588-2.33 1.684-.389 3.344-.736 2.545-2.209-2.366-4.363-.674-6.838 1.866-6.838 2.491 0 4.226 2.383 1.866 6.839-.775 1.464.826 1.812 2.545 2.209 1.49.344 1.589 1.072 1.589 2.333l-.002.619zm4.811-2.214c-1.29-.298-2.49-.559-1.909-1.657 1.769-3.342.469-5.129-1.4-5.129-1.265 0-2.248.817-2.248 2.324 0 3.903 2.268 1.77 2.246 6.676h4.501l.002-.463c0-.946-.074-1.493-1.192-1.751zm-22.806 2.214h4.501c-.021-4.906 2.246-2.772 2.246-6.676 0-1.507-.983-2.324-2.248-2.324-1.869 0-3.169 1.787-1.399 5.129.581 1.099-.619 1.359-1.909 1.657-1.119.258-1.193.805-1.193 1.751l.002.463z"/></svg>
						<span>Incontri</span>
					</a>
				</li>
				<li>
					<a href="/forum.php">
						<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M12 1c-6.338 0-12 4.226-12 10.007 0 2.05.738 4.063 2.047 5.625.055 1.83-1.023 4.456-1.993 6.368 2.602-.47 6.301-1.508 7.978-2.536 9.236 2.247 15.968-3.405 15.968-9.457 0-5.812-5.701-10.007-12-10.007zm0 14h-6v-1h6v1zm6-3h-12v-1h12v1zm0-3h-12v-1h12v1z"/></svg>
						<span>Forum</span>
					</a>
				</li>
				<li>
					<a href="/profile.php">
						<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm7.753 18.305c-.261-.586-.789-.991-1.871-1.241-2.293-.529-4.428-.993-3.393-2.945 3.145-5.942.833-9.119-2.489-9.119-3.388 0-5.644 3.299-2.489 9.119 1.066 1.964-1.148 2.427-3.393 2.945-1.084.25-1.608.658-1.867 1.246-1.405-1.723-2.251-3.919-2.251-6.31 0-5.514 4.486-10 10-10s10 4.486 10 10c0 2.389-.845 4.583-2.247 6.305z"/></svg>
						<span>Profilo</span>
					</a>
				</li>
				<li>
					<a href="/progettiEsterni.php">
						<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M7 16h10v1h-10v-1zm0-1h10v-1h-10v1zm15-13v22h-20v-22h3c1.229 0 2.18-1.084 3-2h8c.82.916 1.771 2 3 2h3zm-11 1c0 .552.448 1 1 1s1-.448 1-1-.448-1-1-1-1 .448-1 1zm9 1h-4l-2 2h-3.898l-2.102-2h-4v18h16v-18zm-13 9h10v-1h-10v1zm0-2h10v-1h-10v1z"/></svg>
						<span>Progetti esterni</span>
					</a>
				</li>
				<li>
					<a href="/privacyPolicy.php">
						<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M17 19h4v2h-4v-2zm4-9v2h-5v10h5v2h-18v-14h3v-4c0-3.313 2.687-6 6-6s6 2.687 6 6v4h3zm-5 0v-4c0-2.206-1.795-4-4-4s-4 1.794-4 4v4h8zm1 8h4v-2h-4v2zm0-3h4v-2h-4v2z"/></svg>
						<span>Privacy Policy</span>
					</a>
				</li>
			</ul>
			<a id="darkmodeBtn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 10.999c1.437.438 2.562 1.564 2.999 3.001.44-1.437 1.565-2.562 3.001-3-1.436-.439-2.561-1.563-3.001-3-.437 1.436-1.562 2.561-2.999 2.999zm8.001.001c.958.293 1.707 1.042 2 2.001.291-.959 1.042-1.709 1.999-2.001-.957-.292-1.707-1.042-2-2-.293.958-1.042 1.708-1.999 2zm-1-9c-.437 1.437-1.563 2.562-2.998 3.001 1.438.44 2.561 1.564 3.001 3.002.437-1.438 1.563-2.563 2.996-3.002-1.433-.437-2.559-1.564-2.999-3.001zm-7.001 22c-6.617 0-12-5.383-12-12s5.383-12 12-12c1.894 0 3.63.497 5.37 1.179-2.948.504-9.37 3.266-9.37 10.821 0 7.454 5.917 10.208 9.37 10.821-1.5.846-3.476 1.179-5.37 1.179z"/></svg></a>
			<a class="accBtn" href="/signin.php">Accedi</a>
		</div>
		';	
	}
	
	//cose javascript
	function elemento3 () {
		echo '
			<script type="text/javascript">
				var darkmodeBtn = document.getElementById("darkmodeBtn");
				darkmodeBtn.onclick = function(){
					document.body.classList.toggle("darkMode");
				}
			</script>
			
			<script type="text/javascript">
				const cookiePopup = document.querySelector(".cookiePopup");
				popupBtn = cookiePopup.querySelector(".content button");

				popupBtn.onclick = () => {
					document.cookie = "FerMe";
					if(document.cookie){
						// If cookie is there
						cookiePopup.classList.add("hide");
					}else{
						alert("Il cookie non può essere creato!");
					}
				}
				
				// This function will hide the cookie popup is there is the cookie
				
				let ifCookie = document.cookie.indexOf("FerMe");
				
				// If the string can\'t be found on the cookies of the user, return -1
				
				ifCookie != -1 ? cookiePopup.classList.add("hide") : cookiePopup.classList.remove("hide");
				
			</script>'
		;
	}
	
	//funzione sanificazione
	function san ($conn, $string) {
		return htmlentities(mysql_fix_string($conn, $string));
	}
	
	function mysql_fix_string($conn, $string) {
		if (get_magic_quotes_gpc()) $string = stripslashes ($string);
		return $conn->real_escape_string($string);
	}
	
	//connect
	function connect () {
		//connessione al database
		$conn = new mysqli(':)', ':)', ':)', ':)');
		if ($conn->connect_error) {
			die("Errore di connessione!!");
		}
		return $conn;
	}
	
	//funzone per censurare parolacce
	function censura($messaggio){
		$parolacce = array("merd", "MERD", "m3RD", "M3rd", "M3RD", "m3rd", "Cazz", "cazz", "c4zz", "C4zz", "C4ZZ", "Putta", "putta", "Puta", "puta", "PUTA", "Pu7a", "Pu77a", "pu7a", "pu77a", "PUTTA", "PU77A", "dio", "Dio", " culo", "fanculo", "FANCULO", "fancullo", "F4NCULO", "FANCULLO", "F4NCULLO", "DIO",  " fica", " FICA", "coglion", "COGLION", "colion", "COLION", "Colion", "Coglion", "C0glion", "c0glion", "C0GLION", "C0lion", "c0lion", "C0LION", "sperm", "Sperm", "SPERM", "sp3rm", "Sp3rm", "SP3RM", "fott", "FOTT", "Fott", "fo77", "FO77", "Fo77", "d10", "di0", "d1o", "D10", "DI0", "D1O"); //lista di parole da evitare
		$contatore = 0;
		$stato = TRUE;
		while($contatore < sizeof($parolacce)){
			if(strpos($messaggio, $parolacce[$contatore]) !== FALSE){
				$stato = FALSE;
			}
			$contatore++;
		}
		return $stato;
		/*usare un array con un ciclo non è il metodo più veloce ma è il più facile da modificare*/
	}
?>
