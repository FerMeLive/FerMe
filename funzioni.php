<?php
	//QUESTO FILE CONTIENTE PAROLACCIE PER IL FILTRO, VEDERE A PROPRIO RISCHIO
	//funzione per verificare se del testo contiene parolacce
	function linguaggioScurile($controlMess){
		if(strpos($controlMess, 'putta') and strpos($controlMess, 'nazi') and strpos($controlMess, 'fascis') and strpos($controlMess, 'cazz') and strpos($controlMess, 'merd') and strpos($controlMess, 'tette') and strpos($controlMess, 'fic') and strpos($controlMess, 'figa') and strpos($controlMess, 'troia') and strpos($controlMess, 'dio') and strpos($controlMess, 'fott') and strpos($controlMess, 'minchi') and strpos($controlMess, 'ebre') and strpos($controlMess, 'scopar')){
			return FALSE;
		} else {
			return TRUE;
		}
	}
?>
