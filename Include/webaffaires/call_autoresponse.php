<!--
-------------------------------------------------------------
 Topic	 : Exemple PHP traitement de l'autoréponse de paiement
 Version : P617

 		Dans cet exemple, les données de la transaction	sont
		décryptées et sauvegardées dans un fichier log.

-------------------------------------------------------------
-->

<?php
if(isset($_POST['DATA']))
{

	
		
		// Récupération de la variable cryptée DATA
			$message="message=$_POST[DATA]";

		// Initialisation du chemin du fichier pathfile (à modifier)
			//   ex :
			//    -> Windows : $pathfile="pathfile=c:/repertoire/pathfile"
			//    -> Unix    : $pathfile="pathfile=/home/repertoire/pathfile"
			
		$pathfile="pathfile=C:/wamp/www/Plug-It/include/webaffaires/param/pathfile";

		//Initialisation du chemin de l'executable response (à modifier)
		//ex :
		//-> Windows : $path_bin = "c:/repertoire/bin/response"
		//-> Unix    : $path_bin = "/home/repertoire/bin/response"
		//

		$path_bin = "C:/wamp/www/Plug-It/include/webaffaires/bin/static/response";

		// Appel du binaire response
		$message = escapeshellcmd($message);
		$result=exec("$path_bin $pathfile $message");
		//	Sortie de la fonction : !code!error!v1!v2!v3!...!v29
		//		- code=0	: la fonction retourne les données de la transaction dans les variables v1, v2, ...
		//				: Ces variables sont décrites dans le GUIDE DU PROGRAMMEUR
		//		- code=-1 	: La fonction retourne un message d'erreur dans la variable error


		//	on separe les differents champs et on les met dans une variable tableau

		$tableau = explode ("!", $result);

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
		$complementary_info= $tableau[20];
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

		// Initialisation du chemin du fichier de log (à modifier)
		//   ex :
		//    -> Windows : $logfile="c:\\repertoire\\log\\logfile.txt";
		//    -> Unix    : $logfile="/home/repertoire/log/logfile.txt";
		//

		$logfile="C:/wamp/www/Plug-It/log_paiement.txt";
		$fp=fopen($logfile,'a');
		
		//  analyse du code retour

	  if (( $code == "" ) && ( $error == "" ) )
		{
		fwrite($fp, "erreur appel response\n");
		print ("executable response non trouve $path_bin\n");
		}

		//	Erreur, sauvegarde le message d'erreur

		else if ( $code != 0 ){
			fwrite($fp, " API call error.\n");
			fwrite($fp, "Error message :  $error\n");
			print ("$error\n");
		}
		else {

		// OK, Sauvegarde des champs de la réponse

			if($bank_response_code == "00"){
				
				$arrayCaddie = unserialize(base64_decode($caddie));

				//Date (ymd) / Heure (His) de paiement en français
				$DatePay = substr($payment_date, 6, 2) . "/" . substr($payment_date, 4, 2) . "/"
				. substr($payment_date, 0, 4) ;

				$HeurePay = substr($payment_time, 0, 2) . "h " . substr($payment_time, 2, 2) . ":"
				. substr($payment_time, 4, 2) ;

				//Le reçu de la transaction que nous allons envoyer pour confirmation
				$Sujet = "Confirmation de votre paiement en ligne [Plug-it.fr]";

				$Msg = "### CECI EST UN MESSAGE AUTOMATIQUE . MERCI DE NE PAS Y RÉPONDRE ###\n\n";
				$Msg.= "Bonjour,\n";
				$Msg.= "Veuillez trouver ci-dessous le reçu de votre paiement en ligne sur Plug-it.fr \n\n";
				$Msg.= "Prenez soin d'imprimer ce message et de le joindre à votre facture.\n";
				$Msg.= "Ces documents vous seront indispensables en cas de réclamation.\n\n";
				
				$Msg.= "DÉTAIL DE VOTRE COMMANDE \n";
				$Msg.= "------------------------------------------------------------\n\n";

				$Msg.= "DATE DE LA TRANSACTION         = $DatePay à $HeurePay \n";
				$Msg.= "ADRESSE WEB DU COMMERCANT      = WWW.PLUG-IT.FR \n";
				$Msg.= "IDENTIFIANT COMMERCANT         = $merchant_id \n";
				$Msg.= "REFERENCE DE LA TRANSACTION    = $transaction_id \n";
				$Msg.= "MONTANT DE LA TRANSACTION      = " . substr($amount,0,-2) . "," . substr($amount ,-2)
				. " euros \n";
				$Msg.= "NUMERO DE CARTE                = $card_number  \n";
				$Msg.= "AUTORISATION                   = $authorisation_id \n";
				$Msg.= "CERTIFICAT DE LA TRANSACTION   = $payment_certificate \n\n";
				$Msg.= "------------------------------------------------------------\n\n";
				$Msg.= "Nom = ".$arrayCaddie[0]."\n\n";
				$Msg.= "Commande = ".$arrayCaddie[5]."\n\n";

				$Msg.= "http://www.Plug-it.com\n";
				
				$Msg.= "Merci de votre confiance \n";
				
				mail($customer_email , $Sujet, $Msg, 'From: shop@plug-it.com');
				
				//On en profite pour s'envoyer également le reçu
				mail('shop@plug-it.com' , $Sujet, $Msg, 'From: shop@plug-it.com');
				
				//ajout BDD
				
				connexionbddplugit::getInstance()->query("INSERT INTO transaction VALUES ('','$transaction_id','".$arrayCaddie[0]."','$customer_email','$amount','".$arrayCaddie[1]."','".$arrayCaddie[5]."','".$arrayCaddie[3]."','$payment_date',$bank_response_code)")or die("Erreur SQL");

			}
		
			fwrite( $fp, "#======================== Le : " . date("d/m/Y H:i:s") . " ====================#\n");
			fwrite( $fp, "merchant_id : $merchant_id\n");
			fwrite( $fp, "merchant_country : $merchant_country\n");
			fwrite( $fp, "amount : $amount\n");
			fwrite( $fp, "transaction_id : $transaction_id\n");
			fwrite( $fp, "transmission_date: $transmission_date\n");
			fwrite( $fp, "payment_means: $payment_means\n");
			fwrite( $fp, "payment_time : $payment_time\n");
			fwrite( $fp, "payment_date : $payment_date\n");
			fwrite( $fp, "response_code : $response_code\n");
			fwrite( $fp, "payment_certificate : $payment_certificate\n");
			fwrite( $fp, "authorisation_id : $authorisation_id\n");
			fwrite( $fp, "currency_code : $currency_code\n");
			fwrite( $fp, "card_number : $card_number\n");
			fwrite( $fp, "cvv_flag: $cvv_flag\n");
			fwrite( $fp, "cvv_response_code: $cvv_response_code\n");
			fwrite( $fp, "bank_response_code: $bank_response_code\n");
			fwrite( $fp, "complementary_code: $complementary_code\n");
			fwrite( $fp, "complementary_info: $complementary_info\n");
			fwrite( $fp, "return_context: $return_context\n");
			fwrite( $fp, "caddie : $caddie\n");
			fwrite( $fp, "receipt_complement: $receipt_complement\n");
			fwrite( $fp, "merchant_language: $merchant_language\n");
			fwrite( $fp, "language: $language\n");
			fwrite( $fp, "customer_id: $customer_id\n");
			fwrite( $fp, "order_id: $order_id\n");
			fwrite( $fp, "customer_email: $customer_email\n");
			fwrite( $fp, "customer_ip_address: $customer_ip_address\n");
			fwrite( $fp, "capture_day: $capture_day\n");
			fwrite( $fp, "capture_mode: $capture_mode\n");
			fwrite( $fp, "data: $data\n");
			fwrite( $fp, "order_validity: $order_validity\n");
			fwrite( $fp, "transaction_condition: $transaction_condition\n");
			fwrite( $fp, "statement_reference: $statement_reference\n");
			fwrite( $fp, "card_validity: $card_validity\n");
			fwrite( $fp, "score_value: $score_value\n");
			fwrite( $fp, "score_color: $score_color\n");
			fwrite( $fp, "score_info: $score_info\n");
			fwrite( $fp, "score_threshold: $score_threshold\n");
			fwrite( $fp, "score_profile: $score_profile\n");
			fwrite( $fp, "threed_ls_code: $threed_ls_code\n");
			fwrite( $fp, "threed_relegation_code: $threed_relegation_code\n");
			fwrite( $fp, "-------------------------------------------\n");
		}

		fclose ($fp);
}

?>
