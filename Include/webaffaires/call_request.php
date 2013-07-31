<!--
-------------------------------------------------------------
 Version : P617

-------------------------------------------------------------
-->

<!--	Affichage du header html	-->
 <?php
	//		Affectation des paramètres obligatoires

if(isset($_POST) and !empty($_POST))	
{	

	$TheCaddie = array();

	$TheCaddie[] =  $_POST['nom'];
	$TheCaddie[] =  $_POST['societe'];
	$TheCaddie[] =  $_POST['courriel'];
	$TheCaddie[] =  $_POST['commentaire'];

	$TheCaddie[] =  $_POST['montanttot'];
	$TheCaddie[] =  $commande;

	$xCaddie = base64_encode(serialize($TheCaddie));

	$parm="merchant_id=042161736600032";
	$parm="$parm merchant_country=fr";
	$parm="$parm amount=".$total;
	$parm="$parm currency_code=978";

	// Initialisation du chemin du fichier pathfile (à modifier)
	    //   ex :
	    //    -> Windows : $parm="$parm pathfile=c:/repertoire/pathfile";
	    //    -> Unix    : $parm="$parm pathfile=/home/repertoire/pathfile";
	    
	$parm="$parm pathfile=C:/wamp/www/Plug-It/include/webaffaires/param/pathfile";

	//		Si aucun transaction_id n'est affecté, request en génère
	//		un automatiquement à partir de heure/minutes/secondes
	//		Référez vous au Guide du Programmeur pour
	//		les réserves émises sur cette fonctionnalité
	//
	//		$parm="$parm transaction_id=123456";



	//		Affectation dynamique des autres paramètres
	// 		Les valeurs proposées ne sont que des exemples
	// 		Les champs et leur utilisation sont expliqués dans le Dictionnaire des données
	//
	 		$parm="$parm normal_return_url=http://127.0.0.1/index.php?page=trt_paiement";
			$parm="$parm cancel_return_url=http://127.0.0.1/index.php?page=trt_paiement";
			$parm="$parm automatic_response_url=http://127.0.0.1/include/webaffaires/call_autoresponse.php";
			$parm="$parm language=fr";
			$parm="$parm payment_means=CB,2,VISA,2,MASTERCARD,2";
	//		$parm="$parm header_flag=no";
	//		$parm="$parm capture_day=";
	//		$parm="$parm capture_mode=";
	//		$parm="$parm bgcolor=";
	//		$parm="$parm block_align=";
	//		$parm="$parm block_order=";
	//		$parm="$parm textcolor=";
	//		$parm="$parm receipt_complement=";
			$parm="$parm caddie=".$xCaddie;
	//		$parm="$parm customer_id=";
			$parm="$parm customer_email=".$TheCaddie[2];
	//		$parm="$parm customer_ip_address=";
	//		$parm="$parm data=";
	//		$parm="$parm return_context=";
	//		$parm="$parm target=";
	//		$parm="$parm order_id=";
	//		$parm="$parm customer_title=";
			$parm="$parm customer_name=".$TheCaddie[0];
	//		$parm="$parm customer_firstname=";
	//		$parm="$parm customer_birthdate=";
	//		$parm="$parm customer_phone=";
	//		$parm="$parm customer_mobile_phone=";
	//		$parm="$parm customer_nationality_country=";
	//		$parm="$parm customer_birth_zipcode=";
	//		$parm="$parm customer_birth_city=";
	//		$parm="$parm home_city=";
	//		$parm="$parm home_streetnumber=";
	//		$parm="$parm home_street=";
	//		$parm="$parm home_zipcode=";

	//		Les valeurs suivantes ne sont utilisables qu'en pré-production
	//		Elles nécessitent l'installation de vos fichiers sur le serveur de paiement
	//
	// 		$parm="$parm normal_return_logo=";
	// 		$parm="$parm cancel_return_logo=";
	// 		$parm="$parm submit_logo=";
	// 		$parm="$parm logo_id=";
	// 		$parm="$parm logo_id2=";
	// 		$parm="$parm advert=";
	// 		$parm="$parm background_id=";
	// 		$parm="$parm templatefile=tmp/merchant_template";


	//		insertion de la commande en base de données (optionnel)
	//		A développer en fonction de votre système d'information

	// Initialisation du chemin de l'executable request (à modifier)
	// ex :
	// -> Windows : $path_bin = "c:/repertoire/bin/request";
	// -> Unix    : $path_bin = "/home/repertoire/bin/request";
	//

	$path_bin = "C:/wamp/www/Plug-It/include/webaffaires/bin/request.exe";


	//	Appel du binaire request
	// La fonction escapeshellcmd() est incompatible avec certaines options avancées
  	// comme le paiement en plusieurs fois qui nécessite  des caractères spéciaux 
  	// dans le paramètre data de la requête de paiement.
  	// Dans ce cas particulier, il est préférable d.exécuter la fonction escapeshellcmd()
  	// sur chacun des paramètres que l.on veut passer à l.exécutable sauf sur le paramètre data.
	$parm = escapeshellcmd($parm);	
	$result=exec("$path_bin $parm");

	//	sortie de la fonction : $result=!code!error!buffer!
	//	    - code=0	: la fonction génère une page html contenue dans la variable buffer
	//	    - code=-1 	: La fonction retourne un message d'erreur dans la variable error

	//On separe les differents champs et on les met dans une variable tableau

	$tableau = explode ("!", "$result");

	//	récupération des paramètres

	$code = $tableau[1];
	$error = $tableau[2];
	$message = $tableau[3];

	//  analyse du code retour

  if (( $code == "" ) && ( $error == "" ) )
 	{
  	print ("<BR><CENTER>erreur appel request</CENTER><BR>");
  	print ("executable request non trouve $path_bin");
 	}

	//	Erreur, affiche le message d'erreur

	else if ($code != 0){
		print ("<center><b><h2>Erreur appel API de paiement.</h2></center></b>");
		print ("<br><br><br>");
		print (" message erreur : $error <br>");
	}

	//	OK, affiche le formulaire HTML
	else {
		print ("<br><br>");
		
		# OK, affichage du mode DEBUG si activé
		print (" $error <br>");
		
		print ("  $message <br>");
	}

}
?>
