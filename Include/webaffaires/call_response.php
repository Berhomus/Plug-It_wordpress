<!--
-------------------------------------------------------------
 Topic		: Exemple PHP traitement de la r�ponse de paiement
 Version 	: P617

	Dans cet exemple, les donn�es de la transaction	sont
	d�crypt�es et affich�es sur le navigateur de l'internaute.

-------------------------------------------------------------
-->


<!--	Affichage du header html -->

<?php
if(isset($_POST['DATA']))
{
	// R�cup�ration de la variable crypt�e DATA
	$message="message=$_POST[DATA]";
	
	// Initialisation du chemin du fichier pathfile (à modifier)
    //   ex :
    //    -> Windows : $pathfile="pathfile=c:/repertoire/pathfile";
    //    -> Unix    : $pathfile="pathfile=/home/repertoire/pathfile";
   
   $pathfile="pathfile=/homez.527/plugit/www/include/webaffaires/param/pathfile";

	// Initialisation du chemin de l'executable response (à modifier)
	// ex :
	// -> Windows : $path_bin = "c:/repertoire/bin/response";
	// -> Unix    : $path_bin = "/home/repertoire/bin/response";
	//

	$path_bin = "/homez.527/plugit/www/include/webaffaires/bin/static/response";

	// Appel du binaire response
  	$message = escapeshellcmd($message);
	$result=exec("$path_bin $pathfile $message");


	//	Sortie de la fonction : !code!error!v1!v2!v3!...!v29
	//		- code=0	: la fonction retourne les donn�es de la transaction dans les variables v1, v2, ...
	//				: Ces variables sont d�crites dans le GUIDE DU PROGRAMMEUR
	//		- code=-1 	: La fonction retourne un message d'erreur dans la variable error


	//	on separe les differents champs et on les met dans une variable tableau

	$tableau = explode ("!", $result);

	//	R�cup�ration des donn�es de la r�ponse

	$code = $tableau[1];
	$error = $tableau[2];
	$merchant_id = $tableau[3];
	$merchant_country = $tableau[4];
	$amount = $tableau[5];
	$transaction_id = $tableau[6];
	$payment_means = $tableau[7];
	$transmission_date= $tableau[8];
	$payment_time = $tableau[9];
	$payment_date = $tableau[10];
	$response_code = $tableau[11];
	$payment_certificate = $tableau[12];
	$authorisation_id = $tableau[13];
	$currency_code = $tableau[14];
	$card_number = $tableau[15];
	$cvv_flag = $tableau[16];
	$cvv_response_code = $tableau[17];
	$bank_response_code = $tableau[18];
	$complementary_code = $tableau[19];
	$complementary_info = $tableau[20];
	$return_context = $tableau[21];
	$caddie = $tableau[22];
	$receipt_complement = $tableau[23];
	$merchant_language = $tableau[24];
	$language = $tableau[25];
	$customer_id = $tableau[26];
	$order_id = $tableau[27];
	$customer_email = $tableau[28];
	$customer_ip_address = $tableau[29];
	$capture_day = $tableau[30];
	$capture_mode = $tableau[31];
	$data = $tableau[32];
	$order_validity = $tableau[33];  
	$transaction_condition = $tableau[34];
	$statement_reference = $tableau[35];
	$card_validity = $tableau[36];
	$score_value = $tableau[37];
	$score_color = $tableau[38];
	$score_info = $tableau[39];
	$score_threshold = $tableau[40];
	$score_profile = $tableau[41];
	$threed_ls_code = $tableau[43];
	$threed_relegation_code = $tableau[44];

	$arrayCaddie = unserialize(base64_decode($caddie));

	//  analyse du code retour

  if (( $code == "" ) && ( $error == "" ) )
 	{
  	print ("<BR><CENTER>erreur appel response</CENTER><BR>");
  	print ("executable response non trouve $path_bin");
 	}

	//	Erreur, affiche le message d'erreur

	else if ( $code != 0 ){
		print ("<center><b><h2>Erreur appel API de paiement.</h2></center></b>");
		print ("<br><br><br>");
		print (" message erreur : $error <br>");
	}

	// OK, affichage des champs de la r�ponse
	else {
		
		# OK, affichage du mode DEBUG si activ�
		print (" $error <br>");
		

		print("<H3>Paiement en ligne</H3>\n");

		
		if($bank_response_code == "00"){

			print("<center><h1>Merci</h1>");
			print("<p>Votre paiement a été accepté par notre établissement bancaire</p>");
			print("<p>Un message électronique vous a été envoyé <br />");
			print("il contient le reçu de la transaction et le détail de votre commande</p>");
			print("<p>Merci de votre confiance</p></center>");
		}
		else{

			print("<center><h1>Votre paiement a été refusé par notre établissement bancaire</h1></center>");

		}
		
		if($response_code == "17"){

			print("<center><h1>Transaction annulé par l'utilisateur</h1></center>");

		}
		
		/*print("<b><h4>\n");
		print("<br><hr>\n");
		print("<br>merchant_id : $merchant_id\n");
		print("<br>merchant_country : $merchant_country\n");
		print("<br>amount : $amount\n");
		print("<br>transaction_id : $transaction_id\n");
		print("<br>transmission_date: $transmission_date\n");
		print("<br>payment_means: $payment_means\n");
		print("<br>payment_time : $payment_time\n");
		print("<br>payment_date : $payment_date\n");
		print("<br>response_code : $response_code\n");
		print("<br>payment_certificate : $payment_certificate\n");
		print("<br>authorisation_id : $authorisation_id\n");
		print("<br>currency_code : $currency_code\n");
		print("<br>card_number : $card_number\n");
		print("<br>cvv_flag: $cvv_flag\n");
		print("<br>cvv_response_code: $cvv_response_code\n");
		print("<br>bank_response_code: $bank_response_code\n");
		print("<br>complementary_code: $complementary_code\n");
		print("<br>complementary_info: $complementary_info\n");
		print("<br>return_context: $return_context\n");
		print("<br>caddie : $caddie\n");
		print("<br>receipt_complement: $receipt_complement\n");
		print("<br>merchant_language: $merchant_language\n");
		print("<br>language: $language\n");
		print("<br>customer_id: $customer_id\n");
		print("<br>order_id: $order_id\n");
		print("<br>customer_email: $customer_email\n");
		print("<br>customer_ip_address: $customer_ip_address\n");
		print("<br>capture_day: $capture_day\n");
		print("<br>capture_mode: $capture_mode\n");
		print("<br>data: $data\n");
		print("<br>order_validity: $order_validity\n");
		print("<br>transaction_condition: $transaction_condition\n");
		print("<br>statement_reference: $statement_reference\n");
		print("<br>card_validity: $card_validity\n");
		print("<br>score_value: $score_value\n");
		print("<br>score_color: $score_color\n");
		print("<br>score_info: $score_info\n");
		print("<br>score_threshold: $score_threshold\n");
		print("<br>score_profile: $score_profile\n");
		print("<br>threed_ls_code: $threed_ls_code\n");
		print("<br>threed_relegation_code: $threed_relegation_code\n");
		print("<br><br><hr></b></h4>");*/
	}
}

?>
