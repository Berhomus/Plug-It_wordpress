<!--#########################################################
#                                                           #
#                PARTIE DE TEST (JS, PHP)                   #
#                                                           #
##########################################################-->

<script TYPE="text/javascript">

/*####INFERIEUR OU SUPERIEUR####*/	

	function PpouPg(Min, Max, Nbcoups, valeur)
	{	
		while((reponse < Min)||(reponse > Max))
		{
			reponse = Prompt("Valeur comprise entre "+Min+" et "+Max+"");
		}
		if(reponse < valeur)
		{
			Prompt("Plus Grand");
			Min = reponse;
			Nbcoups++;
			PpouPg(Min, Max, Nbcoups, valeur);
		} 
		else if (reponse > valeur)
			{
				Prompt("Plus Petit");
				Max = reponse;
				Nbcoups++;
				PpouPg(Min, Max, Nbcoups, valeur);
			}
			else
			{
				Prompt("Valeur Correct");
			}
			
	}
	
	function debutPpouPg()
	{
		var Min = Prompt("Entrer le Minimum");
		var Max = Prompt("Entrer le Maximum");
		
		var Nbcoups = 1;
		
		NbreCoupsMoy = (Max - Min) / Math.Pow(4,((Max - Min) / 4);
		
		
		PpouPg(Min, Max, Nbcoups, valeur);
		
		Prompt("Valeur trouvée en "+Nbcoups+", la moyenne est de "+NbreCoupsMoy+"");
	}
	
/*####FONCTION D'INSERTION DE BALISES####*/	
	
	function insertTag(startTag, endTag, corpsId, tagType) 
	{
		var field  = document.getElementById(corpsId); 
		var scroll = field.scrollTop; // On met en mémoire la position du scroll
		field.focus(); // On remet le focus sur la zone de texte, suivant les navigateurs, on perd le focus en appelant la fonction. 
	 
		 /* === Partie 1 : on récupère la sélection === */
		if (window.ActiveXObject) 
		{
				var textRange = document.selection.createRange();           
				var currentSelection = textRange.text;
		} 
		else 
		{
				var startSelection   = field.value.substring(0, field.selectionStart);
				var currentSelection = field.value.substring(field.selectionStart, field.selectionEnd);
				var endSelection     = field.value.substring(field.selectionEnd);              
		}
		 
		/* === Partie 2 : on analyse le tagType === */
		if (tagType) 
		{
				switch (tagType) 
				{
						case "lien":
								endTag = "</a>";
								if (currentSelection) 
								{ // Il y a une sélection
										if (currentSelection.indexOf("http://") == 0 || currentSelection.indexOf("https://") == 0 || currentSelection.indexOf("ftp://") == 0 || currentSelection.indexOf("www.") == 0) 
										{
												// La sélection semble être un lien. On demande alors le libellé
												var label = prompt("Quel est le libellé du lien ?") || "";
												startTag = "<a class=\"mail\" href=\"" + currentSelection + "\">";
												currentSelection = label;
										} 
										else 
										{
												// La sélection n'est pas un lien, donc c'est le libelle. On demande alors l'URL
												var URL = prompt("Quelle est l'url ?");
												startTag = "<a class=\"mail\" href=\"" + URL + "\">";
										}
								} 
								else 
								{ // Pas de sélection, donc on demande l'URL et le libelle
										var URL = prompt("Quelle est l'url ?") || "";
										var label = prompt("Quel est le libellé du lien ?") || "";
										startTag = "<a class=\"mail\" href=\"" + URL + "\">";
										currentSelection = label;                    
								}
						break;
						
						case "image":
								endTag = "";
								if (currentSelection) 
								{ // Il y a une sélection
									startTag = "<img src=\"" + currentSelection + "\"/>";
								}
								else 
								{ // Pas de sélection, donc on demande l'URL et le libelle
										var URL = prompt("Quelle est le chemin de l'image ?\n (si elle est en local, exemple : images/nom_de_l_image.png)") || "";
										startTag = "<img src=\"" + URL + "\"/>";
										currentSelection = "";                    
								}
						break;
				}
		}
		 
		/* === Partie 3 : on insère le tout === */
		if (window.ActiveXObject) 
		{
				textRange.text = startTag + currentSelection + endTag;
				textRange.moveStart("character", -endTag.length - currentSelection.length);
				textRange.moveEnd("character", -endTag.length);
				textRange.select();    
		} 
		else 
		{
				field.value = startSelection + startTag + currentSelection + endTag + endSelection;
				field.focus();
				field.setSelectionRange(startSelection.length + startTag.length, startSelection.length + startTag.length + currentSelection.length);
		}

		field.scrollTop = scroll;     
	}

/*####FONCTION PERMETTANT DE FAIRE DES REQUETES HTTP POUR RECUPERER DONNEES AU FORMAT XML####*/
	
function getXMLHttpRequest() 
{
    var xhr = null;
     
    if (window.XMLHttpRequest || window.ActiveXObject)
	{
        if (window.ActiveXObject) 
		{
            try
			{
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            }
			catch(e) 
			{
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        }
		else 
		{
            xhr = new XMLHttpRequest();
        }
    } 
	else 
	{
        alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
        return null;
    }
     
    return xhr;
}

/*####FONCTION DE VISUALISATION####*/

function view(textareaId, viewDiv)
{
    var content = encodeURIComponent(document.getElementById(textareaId).value);
    var xhr = getXMLHttpRequest();
     
    if (xhr && xhr.readyState != 0) 
	{
        xhr.abort();
        delete xhr;
    }
     
    xhr.onreadystatechange = function()
	{
        if (xhr.readyState == 4 && xhr.status == 200)
		{
            document.getElementById(viewDiv).innerHTML = xhr.responseText;
        } 
		else if (xhr.readyState == 3)
		{
            document.getElementById(viewDiv).innerHTML = "<div style=\"text-align: center;\">Chargement en cours...</div>";
        }
    }
     
    xhr.open("POST", "include/admin/view.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("string=" + content);
	
}

/*####FONCTION EXTERNALISATION####*/
/*Secondaire*/

function extern(field,Idcorps)
{
	var cpt=0;
	
	if(field.value != this)
	{
		xhr.send("Area = " + content);
	}
	xhr.onreadystatechange = function()
	{
		if (window.ActiveXObject) 
		{
            try
			{
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            }
			catch(e) 
			{
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        }
		else 
		{
            xhr = new XMLHttpRequest();
        }
	}
	while(Idcorps != this.value)
	{
		this.value=this.value -> next;
		cpt++;
	}
	for(i=1;i<cpt;i++)
	{
		Idcorps.field = "<table class=\"tableau\"><tr><td>"+xhr.send("Area = ", content)+"</td></tr>";
		xhr = new ActiveXObject("Msxml2.XMLHTTP");
		
		try
		{
			delete xhr;
		}
		catch(e)
		{
			Alert("Impossible de supprimer");
		}
	}
	var visual = '<div id="visu">'+contenu+'</div>';
}

/*####FONCTION LIMITATION DE CARACTERES####*/

function textLimit(field, maxlen, idlimite)
 {
   if (field.value.length > maxlen)
   {
      field.value = field.value.substring(0, maxlen);
      alert('Dépassement de la limite de caracteres');
	  idlimite.style.color='red';
	  setTimeout(function(){idlimite.style.color='green';},2000);
   }
   else if(maxlen > field.value.length > 0)
   {
	  setTimeout(function(){idlimite.style.color='grey';},2000);
   }
}

/*####FONCTION LIEN####*/

function lien()
{
 // Pas de sélection, donc on demande l'URL et le libelle
		var URL = prompt("Quelle est l'url ?") || "";
		var label = prompt("Quel est le libellé du lien ?") || "";
		document.execCommand('insertHTML', false, '<a class="mail" href="'+URL+'">'+label+'</a>');
		document.getElementById('ortf').focus();
}

/*####FONCTION TITRE####*/

function titre()
{
	document.execCommand('bold', false, '');
	document.execCommand('FontSize', false, '3');
	document.getElementById('ortf').focus(); 
}

/*####FONCTION IMAGE####*/

function img()
{
	var img = prompt("Quel est le chemin de l'image ?\nExemple : /images/nom_de_l_image.png\nPour les images en locales, sinon chemin absolu.");
	document.execCommand('insertHTML', false, '<img src="'+img+'" />');
	document.getElementById('ortf').focus();
}

 try {
	Editor.execCommand("styleWithCSS", 0, false);
} catch (e) {
	try {
		Editor.execCommand("useCSS", 0, true);
	} catch (e) {
		try {
			Editor.execCommand('styleWithCSS', false, false);
		}
		catch (e) {
		}
	}
}

/*####FONCTION DE VERIFICATION DE MAIL####*/

function isEmail(adr, id)
{
    // étape consistant à définir l'expression régulière d'une adresse email
    var regEmail = new RegExp('^[0-9a-z._-]+@{1}[0-9a-z.-]{2,}[.]{1}[a-z]{2,5}$','i');

    if(regEmail.test(adr.value))
	{
		id.style.color='green';
	}
	else
	{
		id.style.color='red';
		adr.value='';
		alert('Mail Invalide');
	}
}

</script>
<html>
	<head>Menu</head>
	<body>
		<p>
		<img src="images/fleche.png"/><h2>WanaShare est une plateforme de gestion de l'information et de <br/>
		collaboration professionnelle basée sur le produit Microsoft© SharePoint <br/>
		2010 qui vous aide à améliorer votre productivité et à gérer votre contenu, <br/>
		en utilisant un navigateur Internet.<br/></h2>
		<br/>
		Les fonctionnalités intégrées de WanaShare, optimisées par des technologies d'indexation et de <br/>
		recherche, vous permettent de vous adapter rapidement à l'évolution de vos besoins métier.<br/>
		Vous pouvez ainsi prendre des décisions fondées sur des données métier consolidées et déployer des <br/>
		applications métiers de façon rapide et sécurisée afin de renforcer la collaboration dans et hors de votre <br/>
		entreprise.<br/>
		<br/>
		<img src="images/fleche.png"/><h2>WanaShare, pour quels usages ? WanaShare vous permet d'accroître la productivité via un ensemble intégré de <br/>
		fonctionnalités innovantes. Parmi elles, on peut citer :<br/></h2>
		<br/>
		- Accessibilité.<br/>
		- Affichage d'informations.<br/>
		- Prise en main de WSS 3.0.<br/>
		- Conservation de plusieurs versions de fichiers et d'éléments.<br/>
		- Création de sites, de listes et de bibliothèques.<br/>
		- Formules et fonctions.<br/>
		- Gestion de sites et de paramètres.<br/>
		- Intégration du courrier électronique aux sites, listes et bibliothèques.<br/>
		- Organisation de réunions.<br/>
		- Partage de fichiers et de documents.<br/>
		- Partage d'informations.<br/>
		- Personnalisation de sites, de pages, de listes et de bibliothèques.<br/>
		- Utilisation des environnements internationaux.<br/>
		- Utilisation des flux de travail pour gérer les processus.<br/>
		<br/>
		</p>
	</body>
</html>

<?php
/* Informations du client */
$_SESSION['USER_ID']       = "1";
$_SESSION['USER_NOM']      = "Godin";
$_SESSION['USER_PRENOM']   = "Thierry";
$_SESSION['USER_COMPANY']  = "N1bus-Expériences";
$_SESSION['USER_ADRESSE']  = "1, rue Henri Desgranges";
$_SESSION['USER_VILLE']    = "La Rochelle";
$_SESSION['USER_ZIP']      = "17000";
$_SESSION['USER_PAYS']     = "France";
$_SESSION['USER_TEL']      = "33(0) 123 456 789";
$_SESSION['USER_EMAIL']    = "xxxx@xxxx.com";

/* Caddie */
$_SESSION['CADDIE_ID']          = "1";
$_SESSION['CADDIE_LOG_NOM']     = "PlanningFacile";
$_SESSION['CADDIE_LOG_VERSION'] = "1.1.0.0";
$_SESSION['CADDIE_AMOUNT']      = "3000"; //montant en euro sans séparateur = 30,00 euros

// on construit le tableau du caddie en récupérant les variables de la session
$TheCaddie = array();

// les infos du client
$TheCaddie[] =  $_SESSION['USER_ID'];
$TheCaddie[] =  $_SESSION['USER_NOM'];
$TheCaddie[] =  $_SESSION['USER_PRENOM'];
$TheCaddie[] =  $_SESSION['USER_COMPANY'];
$TheCaddie[] =  $_SESSION['USER_ADRESSE'];
$TheCaddie[] =  $_SESSION['USER_VILLE'];
$TheCaddie[] =  $_SESSION['USER_ZIP'];
$TheCaddie[] =  $_SESSION['USER_PAYS'];
$TheCaddie[] =  $_SESSION['USER_TEL'];
$TheCaddie[] =  $_SESSION['USER_EMAIL'];

//le contenu du caddie
$TheCaddie[] =  $_SESSION['CADDIE_ID'];
$TheCaddie[] =  $_SESSION['CADDIE_LOG_NOM'];
$TheCaddie[] =  $_SESSION['CADDIE_LOG_VERSION'];
$TheCaddie[] =  $_SESSION['CADDIE_AMOUNT'];

//on crée un numéro de commande pour le fun
$NumCmd      = "CMD-" . date("YmdHis");
$TheCaddie[] =  $NumCmd ;

//pour envoyer le caddie à e-transaction sans probleme
//on serialize le tableau pour en faire 1 string et on le base64_encode()
//car certains caractères sont interdits dans la valeur du parm caddie

$xCaddie = base64_encode(serialize($TheCaddie));

//Identifiant commerçant
//Nous en sommes pour l'instant à la phase d'installation,
//Nous utiliserons donc l'identifiant commerçant de test.
//Lorsque nous passerons en pré-production, il faudra alors mettre ici
//l'identifiant commerçant que votre fournisseur vous aura délivré
$parm = "merchant_id=013044876511111";

//Chemin du fichier pathfile + executable request
$parm .= " pathfile=/srv/www/htdocs/monsiteweb/xpay/pathfile";
$path_bin = "/srv/www/htdocs/empty/request_2.6.9_3.4.2";

//Pays du commerçant
$parm .= " merchant_country=fr";

//Langage de l'interface de paiement
//Si votre site comporte plusieurs langages, vous pouvez préciser dynamiquement ici
//le langage utilisé par le client
//cf : Dictionnaire des données
$parm .= " language=fr";

//Le montant de la transaction
//Cette valeur ne doit pas comporter de ponctuation. Chiffres uniquement !
//Par exemple, le montant du caddie est de 30,00 euros, vous devez mettre 3000
$parm .= " amount=" .$_SESSION['CADDIE_AMOUNT'];

//Monnaie
//Ici c'est l'euro
//Si vous proposez le paiement en plusieurs monnaies,
//vous pouvez changer dynamiquement cette valeur selon la monnaie
//choisie par le client
//cf : Dictionnaire des données
$parm .= " currency_code=978";

//Id de la transaction (6chiffres)
//Vous pouvez ne pas utiliser ce paramètre, auquel cas, le serveur du fournisseur
//créera un id de transaction automatiquement.
//Pour ma part, je pense qu'il peut être utile de le définir ici, notamment
//si on souhaite mettre à jour notre base de données en ajoutant l'id de transaction au caddie enregistré
//avant de procéder à la transaction.
$parm .= " transaction_id=" . date ("His");

//Label sur le reçu de paiement
//Lorsque le paiement a été accepté par le fournisseur, un ticket est affiché à l'écran.
//Vous pouvez ici rajouter un commentaire pour que le ticket affiche au moins le nom de
//votre boutique et le produit acheté.
//Ce paramètre est limité à 3072 caractères et ne doit pas contenir d'espace
//( vous les remplacez par leur équivalent html : &nbsp;)
$Produit = "<tr><td>CHEZN1BUS&nbsp;:&nbsp;&nbsp;LOGICIEL&nbsp;PLANNINGFACILE</td></tr>";
$parm .= " receipt_complement=" . $Produit;

//Email client (no comment)
$parm .= " customer_email=" . $_SESSION['USER_EMAIL'];

//IP client
//Je ne vous mets pas le code pour récupérer l'ip du client
//mais vous saurez trouver ce qu'il vous faut sur developpez.com
$parm .= " customer_ip_address=" . $IP;

//caddie
//On retrouve ici notre fameux caddie que nous avons préparé dans la section précédente.
//Ce champ est limité à 2048 caractères
$parm .= " caddie=" . $xCaddie ;


//Nous pouvons utiliser les paramètres ci-dessous si nous avons besoin de passer des paramètres dans l'url.
//Ici par exemple, nous transmettons l'id de session pour que le client puisse retourner sur son compte au
//retour de la transaction.
//Si vous définissez ces paramètres ici, il est préférable de passer les url en commentaire
//dans le fichier parmcom du commerçant en ajoutant un dièse devant (#)

//url en cas d'annulation
$SUPERID = session_id();
$parm .= " cancel_return_url=http://www.plug-it.com/response.php?SUPERID=" . $SUPERID;

// url réponse automatique
$parm .= " automatic_response_url=http://www.plug-it.com/call_autoresponse.php";

//url de retour du client après le paiement
$parm .= " normal_return_url=http://www.plug-it.com/response.php?SUPERID=" . $SUPERID;


//et enfin, vous pouvez préciser ici le template que vous souhaitez utiliser
//Voir la section plus bas pour la création du Template
$parm .= " templatefile=le_template_de_mon_site";

//Appel du binaire request
$result = exec("$path_bin $parm");

//On separe les differents champs et on les met dans un  tableau
$tableau = explode ("!", "$result");

//Récupération des paramètres
$code    = $tableau[1];
$error   = $tableau[2];
$message = $tableau[3];

//Analyse du code retour

if (( $code == "" ) && ( $error == "" ) )
{
	//Si nous n'obtenons aucun retour de l'API c'est qu'il n'a pas été exécuté (CQFD)
	//Il s'agit la plupart du temps d'un problème dans le chemin vers le binaire request
	//Il peut s'agir d'un problème de droits : vérifiez qu'il ait bien les droits d'exécution

	print ("<center><h1>Erreur appel request</h1></center>");
	print ("<p>&nbsp;</p>");
	print ("Executable request non trouve : $path_bin");
}


else if ($code != 0){

	//Erreur, affiche le message d'erreur
	//Ici le binaire request a bien été exécuté mais un ou plusieurs paramètres ne sont pas valides
	//En cas de doute, n'hésitez pas à consulter le Dictionnaire des données
    
	print ("<center><h1>Erreur appel API de paiement.</h1></center>");
	print ("<p>&nbsp;</p>");
	print ("<p>Message erreur : $error </p>");
}

else {

	//Ici, tout est OK, on affiche les cartes bancaires
	//Comme on est des programmeurs consciencieux, on va également afficher
	//quelques infos supplémentaire pour que le client se sente en confiance
	//en lui rappellant le montant de la transaction et le numéro de commande
	//ainsi qu'un lien de retour au cas où celui-ci changerait d'avis

	print ("<p>&nbsp;</p>");
	print ("$message");
	print ("<p>&nbsp;</p>");
	print("<p align='center'><strong>Montant à payer : </strong> ".
	substr($_SESSION['CADDIE_AMOUNT'],0,-2).",".substr($_SESSION['CADDIE_AMOUNT'] ,-2) . " Euros  - ");
	print("<strong>Num&eacute;ro de commande : </strong> " . $NumCmd  ."</p>");
	print("<p align='center'><a href='javascript:history.go(-1)'>RETOUR</a></p>");

	//Ici on peut vérifier le contenu du parm caddie que l'on va envoyer
	//pour nous assurer que nous envoyons bien tout ce dont nous aurons besoin au retour
	//de la transaction 
	//Décommentez les lignes ci-dessous pendant les tests
	//n'oubliez pas de les repasser en commentaire ou de les effacer ensuite

	/*
	$arrayCaddie = unserialize(base64_decode($xCaddie));
	for($i = 0 ; $i < count($arrayCaddie); $i++){
	echo $arrayCaddie[$i] . "<br />";
	} 
	*/

}

//Récupération du caddie
$TheCaddie = array();

$TheCaddie[] =  $_SESSION['USER_ID'];
$TheCaddie[] =  $_SESSION['USER_NOM'];
$TheCaddie[] =  $_SESSION['USER_PRENOM'];
$TheCaddie[] =  $_SESSION['USER_COMPANY'];
$TheCaddie[] =  $_SESSION['USER_ADRESSE'];
$TheCaddie[] =  $_SESSION['USER_VILLE'];
$TheCaddie[] =  $_SESSION['USER_ZIP'];
$TheCaddie[] =  $_SESSION['USER_PAYS'];
$TheCaddie[] =  $_SESSION['USER_TEL'];
$TheCaddie[] =  $_SESSION['USER_EMAIL'];

$TheCaddie[] =  $_SESSION['CADDIE_ID'];
$TheCaddie[] =  $_SESSION['CADDIE_LOG_NOM'];
$TheCaddie[] =  $_SESSION['CADDIE_LOG_VERSION'];
$TheCaddie[] =  $_SESSION['CADDIE_AMOUNT'];

//Numéro de commande
$NumCmd      = "CMD-" . date("YmdHis");
$TheCaddie[] =  $NumCmd ;

$xCaddie = base64_encode(serialize($TheCaddie));

//Identifiant du commerçant (TEST)
$parm = "merchant_id=013044876511111";

//Chemins binaire + pathfile
$parm .= " pathfile=/srv/www/htdocs/plug-it/xpay/pathfile";
$path_bin = "/srv/www/htdocs/empty/request_2.6.9_3.4.2";

//Langages
$parm .= " merchant_country=fr";
$parm .= " language=fr";

//Montant du caddie
$parm .= " amount=" .$_SESSION['CADDIE_AMOUNT'];

//Euro
$parm .= " currency_code=978";

//Numéro de transaction
$parm .= " transaction_id=" . date ("His");

//Complément du reçu
$Produit = "<tr><td>CHEZN1BUS&nbsp;:&nbsp;&nbsp;LOGICIEL&nbsp;PLANNINGFACILE</td></tr>";
$parm .= " receipt_complement=" . $Produit;

//Email du client
$parm .= " customer_email=" . $_SESSION['USER_EMAIL'];

//IP client
$parm .= " customer_ip_address=" . $IP;

//caddie
$parm .= " caddie=" . $xCaddie ;

//url en cas d'annulation
$SUPERID = session_id();
$parm .= " cancel_return_url=http://www.plug-it.com/response.php?SUPERID=" . $SUPERID;

// url réponse automatique
$parm .= " automatic_response_url=http://www.plug-it.com/call_autoresponse.php";

//url de retour du client après le paiement
$parm .= " normal_return_url=http://www.plug-it.com/response.php?SUPERID=" . $SUPERID;

//Template
$parm .= " templatefile=le_template_de_mon_site";


//Appel du binaire request
$result  = exec("$path_bin $parm");
$tableau = explode ("!", "$result");

//Récupération des paramètres
$code    = $tableau[1];
$error   = $tableau[2];
$message = $tableau[3];

//Analyse du code retour

if (( $code == "" ) && ( $error == "" ) )
{
	//Erreur chemin ou droits
	print ("<center><h1>Erreur appel request</h1></center>");
	print ("<p>&nbsp;</p>");
	print ("<p>Executable request non trouve : $path_bin</p>");
}


else if ($code != 0){

	//Erreur paramètres
	print ("<center><h1>Erreur appel API de paiement.</h1></center>");
	print ("<p>&nbsp;</p>");
	print ("<p>Message erreur : $error </p>");
}


else {

	//OK, on affiche les cartes bancaires
	print ("<p>&nbsp;</p>");
	print ("$message");
	print ("<p>&nbsp;</p>");
	print("<p align='center'><strong>Montant à payer : </strong> ".
	substr($_SESSION['CADDIE_AMOUNT'],0,-2).",".substr($_SESSION['CADDIE_AMOUNT'] ,-2) . " Euros  - ");
	print("<strong>Num&eacute;ro de commande : </strong> " . $NumCmd  ."</p>");
	print("<p align='center'><a href='javascript:history.go(-1)'>RETOUR</a></p>");

	//Vérifier le contenu du parm caddie que l'on va envoyer

	/*
	$arrayCaddie = unserialize(base64_decode($xCaddie));
	for($i = 0 ; $i < count($arrayCaddie); $i++){
	echo $arrayCaddie[$i] . "<br />";
	}
	*/

}

//Récupération de la variable DATA en provenance du serveur du fournisseur.
//La réponse de la transaction est contenue dans cette variable dans son intégralité
//Evidemment toutes ces données sont chiffrées : c'est le binaire response qui fera tout le travail.
$message = "message=" . escapeshellcmd($_POST['DATA']);


// Initialisation du chemin du fichier pathfile
$pathfile = "pathfile=/srv/www/htdocs/plug-it/xpay/pathfile";

//Initialisation du chemin de l'executable response
$path_bin = "/srv/www/htdocs/empty/response_2.6.9_3.4.2";

//Appel du binaire response
$result = exec("$path_bin $pathfile $message");


//On separe les differents champs et on les met dans une variable tableau
//Puis on récupère toutes les valeurs.

$tableau = explode ("!", $result);

$code                = $tableau[1];
$error               = $tableau[2];
$merchant_id         = $tableau[3];
$merchant_country    = $tableau[4];
$amount              = $tableau[5];
$transaction_id      = $tableau[6];
$payment_means       = $tableau[7];
$transmission_date   = $tableau[8];
$payment_time        = $tableau[9];
$payment_date        = $tableau[10];
$response_code       = $tableau[11];
$payment_certificate = $tableau[12];
$authorisation_id    = $tableau[13];
$currency_code       = $tableau[14];
$card_number         = $tableau[15];
$cvv_flag            = $tableau[16];
$cvv_response_code   = $tableau[17];
$bank_response_code  = $tableau[18];
$complementary_code  = $tableau[19];
$complementary_info  = $tableau[20];
$return_context      = $tableau[21];
$caddie              = $tableau[22];
$receipt_complement  = $tableau[23];
$merchant_language   = $tableau[24];
$language            = $tableau[25];
$customer_id         = $tableau[26];
$order_id            = $tableau[27];
$customer_email      = $tableau[28];
$customer_ip_address = $tableau[29];
$capture_day         = $tableau[30];
$capture_mode        = $tableau[31];
$data                = $tableau[32];


//Initialisation du chemin du fichier de log que nous avions mis dans le même
//répertoire que les fichiers du système de paiement
$logfile = "/srv/www/htdocs/plug-it/xpay/log.txt";

//Ouverture du fichier de log en append
$fp = fopen($logfile, "a");

//Analyse du code retour

if (( $code == "" ) && ( $error == "" ) )
{
	//Si nous n'obtenons aucun retour de l'API c'est qu'il n'a pas été exécuté
	//Il s'agit la plupart du temps d'un problème dans le chemin vers le binaire response
	//Il peut s'agir d'un problème de droits : vérifiez qu'il ait bien les droits d'exécution
	//Rappellez-vous que ce fichier ne génére aucune sortie HTML
	//Vous ne verrez donc pas de message d'erreur à l'écran

	fwrite($fp, "#======= Le : " . date("d/m/Y H:i:s") . " ========#\n");
	fwrite($fp, "Erreur appel response\n");
	fwrite($fp, "Executable response non trouvé : $path_bin \n");
	fwrite($fp, "-------------------------------------------\n");
}


else if ( $code != 0 ){

	//Erreur,
	//Ici le binaire response a bien été exécuté mais un ou plusieurs paramètres ne sont pas valides
	//En cas de doute, n'hésitez pas à consulter le Dictionnaire des données

	fwrite($fp, "#======= Le : " . date("d/m/Y H:i:s") . " ========#\n");
	fwrite($fp, "Erreur appel API de paiement.\n");
	fwrite($fp, "Message erreur :  $error \n");
	fwrite($fp, "-------------------------------------------\n");
}
else {

	//OK
	//Ici, la transaction s'est bien déroulée, mais cela ne veut pas dire pour autant que
	//le paiement a été accepté !

	//Paiement accepté = '00'
	//Référez-vous au Dictionnaire des données pour les numéros de réponse
	if($bank_response_code == "00"){


		//Caddie
		//Ici nous retrouvons tout notre caddie que nous remmettons dans un tableau
		$arrayCaddie = unserialize(base64_decode($caddie));

		//Date (ymd) / Heure (His) de paiement en français
		$DatePay = substr($payment_date, 6, 2) . "/" . substr($payment_date, 4, 2) . "/"
		. substr($payment_date, 0, 4) ;

		$HeurePay = substr($payment_time, 0, 2) . "h " . substr($payment_time, 2, 2) . ":"
		. substr($payment_time, 4, 2) ;

		//Le reçu de la transaction que nous allons envoyer pour confirmation
		$Sujet = "Confirmation de votre paiement en ligne [PLUG-IT.COM]";

		$Msg.= "### CECI EST UN MESSAGE AUTOMATIQUE . MERCI DE NE PAS Y RÉPONDRE ###\n\n";
		$Msg.= "Bonjour,\n";
		$Msg.= "Veuillez trouver ci-dessous le reçu de votre paiement en ligne sur PLUG-IT.COM \n\n";
		$Msg.= "Prenez soin d'imprimer ce message et de le joindre à votre facture.\n";
		$Msg.= "Ces documents vous seront indispensables en cas de réclamation.\n\n";

		$Msg.= "DÉTAIL DE VOTRE COMMANDE \n";
		$Msg.= "------------------------------------------------------------\n\n";
		$Msg.= "NUMÉRO DE COMMANDE             = " . $arrayCaddie[14] . " \n";
		
		$Msg.= "DATE DE LA TRANSACTION         = $DatePay à $HeurePay \n";
		$Msg.= "ADRESSE WEB DU COMMERCANT      = WWW.PLUG-IT.COM \n";
		$Msg.= "IDENTIFIANT COMMERCANT         = $merchant_id \n";
		$Msg.= "REFERENCE DE LA TRANSACTION    = $transaction_id \n";
		$Msg.= "MONTANT DE LA TRANSACTION      = " . substr($amount,0,-2) . "," . substr($amount ,-2)
		. " euros \n";
		$Msg.= "NUMERO DE CARTE                = $card_number  \n";
		$Msg.= "AUTORISATION                   = $authorisation_id \n";
		$Msg.= "CERTIFICAT DE LA TRANSACTION   = $payment_certificate \n\n";

		$Msg.= "NOM                            = " . $arrayCaddie[1] . " \n";
		$Msg.= "PRÉNOM                         = " . $arrayCaddie[2] . " \n";
		$Msg.= "SOCIÉTÉ                        = " . $arrayCaddie[3] . " \n";
		$Msg.= "ADRESSE                        = " . $arrayCaddie[4] . " \n";
		$Msg.= "VILLE                          = " . $arrayCaddie[5] . " \n";
		$Msg.= "CODE POSTAL                    = " . $arrayCaddie[6] . " \n";
		$Msg.= "PAYS                           = " . $arrayCaddie[7] . " \n";
		$Msg.= "TÉLÉPHONE                      = " . $arrayCaddie[8] . " \n\n";

		$Msg.= "LOGICIEL                       = " . $arrayCaddie[11] . " \n";
		$Msg.= "VERSION                        = " . $arrayCaddie[12] . " \n";
		$Msg.= "------------------------------------------------------------\n\n";
		
		$Msg.= "http://www.plug-it.com\n\n";

		$Msg.= "Merci de votre confiance \n";
		
		// inutile
		$Msg = "<table><tr><td>".$data."</td>/tr></table>";
		$receipt_complement = "<h2><b>En Cours</b></h2>";
		
		//Envoi du message au client
		mail($customer_email , $Sujet, $Msg, 'From: www.plug-it.com');

		//le reçu
		mail('contact@plug-it.fr' , $Sujet, $Msg, 'From: www.plug-it.com');

		// Mise à jour de la base de données
		// la transaction a réussie et le paiement a été accepté

	}

	//--------------------------------------------------------------------------------


	//La transaction a réussi.
	//Quelque soit le résultat (paiement accepté ou refusé) , nous enregistrerons toutes les données
	//Ceci nous fait une sécurité de plus en cas de panne ou de litige avec le client
	//ou si aucun email n'a été reçu ( ou message envoyé dans le dossier SPAM du logiciel de messagerie)
	// Si votre boutique débite pas mal, ce que je vous souhaite, vous penserez à vider
	// régulièrement votre fichier de logs pour ne pas encombrer votre espace disque.
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
	
	//ici on dépiote le caddie
	fwrite( $fp, "caddie : \n");
	fwrite( $fp, "----------- \n");
	
	// echo '<img src="./images/fleche.png"/><a class="mail" href="www.plug-it.com">PLUG-IT</a>';

	for($i = 0 ; $i < count($arrayCaddie); $i++){
		fwrite( $fp, $arrayCaddie[$i] . "\n");
	}
	fwrite( $fp, "-------------------------------- \n");

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
	fwrite( $fp, "---------------------------------------------------------\n\n");

}

fclose($fp);

//Récupération de la variable DATA en provenance du serveur du fournisseur.
//La réponse de la transaction est contenue dans cette variable dans son intégralité
//Evidemment toutes ces données sont chiffrées : c'est le binaire response qui fera tout le travail.
$message = "message=" . escapeshellcmd($_POST['DATA']);


// Initialisation du chemin du fichier pathfile
$pathfile = "pathfile=/srv/www/htdocs/monsiteweb/xpay/pathfile";

//Initialisation du chemin de l'executable response
$path_bin = "/srv/www/htdocs/empty/response_2.6.9_3.4.2";

//Appel du binaire response
$result = exec("$path_bin $pathfile $message");


//On separe les differents champs et on les met dans une variable tableau
//Puis on récupère toutes les valeurs.
//En vérité nous n'avons besoin ici que de quelques variables
//mais ceci vous permet d'identifier les différentes valeurs du tableau

$tableau = explode ("!", $result);

$code                = $tableau[1];
$error               = $tableau[2];
$merchant_id         = $tableau[3];
$merchant_country    = $tableau[4];
$amount              = $tableau[5];
$transaction_id      = $tableau[6];
$payment_means       = $tableau[7];
$transmission_date   = $tableau[8];
$payment_time        = $tableau[9];
$payment_date        = $tableau[10];
$response_code       = $tableau[11];
$payment_certificate = $tableau[12];
$authorisation_id    = $tableau[13];
$currency_code       = $tableau[14];
$card_number         = $tableau[15];
$cvv_flag            = $tableau[16];
$cvv_response_code   = $tableau[17];
$bank_response_code  = $tableau[18];
$complementary_code  = $tableau[19];
$complementary_info  = $tableau[20];
$return_context      = $tableau[21];
$caddie              = $tableau[22];
$receipt_complement  = $tableau[23];
$merchant_language   = $tableau[24];
$language            = $tableau[25];
$customer_id         = $tableau[26];
$order_id            = $tableau[27];
$customer_email      = $tableau[28];
$customer_ip_address = $tableau[29];
$capture_day         = $tableau[30];
$capture_mode        = $tableau[31];
$data                = $tableau[32];


//Analyse du code retour

if (( $code == "" ) && ( $error == "" ) ){

	//Si nous n'obtenons aucun retour de l'API c'est qu'il n'a pas été exécuté 
	//Il s'agit la plupart du temps d'un problème dans le chemin vers le binaire response
	//Il peut s'agir d'un problème de droits : vérifiez qu'il ait bien les droits d'exécution

	print ("<center><h1>Erreur appel response</h1></center>");
	print ("<p>Executable response non trouve : $path_bin </p>");
}

else if ( $code != 0 ){

	//Erreur,
	//Ici le binaire response a bien été exécuté mais un ou plusieurs paramètres ne sont pas valides
	//En cas de doute, n'hésitez pas à consulter le Dictionnaire des données

	print ("<center><h1>Erreur appel API de paiement.</h1></center>");
	print ("<p>Message erreur : $error </p>");


}

else {

	//OK
	//Ici, la transaction s'est bien déroulée, mais cela ne veut pas dire pour autant que
	//le paiement a été accepté

	//Paiement accepté = '00'
	//Référez-vous au Dictionnaire des données pour les numéros de réponse
	if($bank_response_code == "00"){

		print("<center><h1>Merci</h1></center>");
		print("<p>Votre paiement a été accepté par notre établissement bancaire</p>");
		print("<p>Un message électronique vous a été envoyé <br />");
		print("il contient le reçu de la transaction et le détail de votre commande</p>");
		print("<p>Merci de votre confiance</p>");
	}

	//Paiement refusé
	else{

		print("<center><h1>Votre paiement a été refusé par notre établissement bancaire</h1></center>");

	}

	//Ici nous affichons un message dans le cas où l'internaute aurait cliqué
	//sur le bouton ANNULATION
	if($response_code == "17"){

		print("<center><h1>Transaction annulée par l'utilisateur</h1></center>");

	}
}

switch($bank_response_code){

	case "00" :
		print("<p>Votre paiement a été accepté par votre établissement bancaire</p>");
		break;

	case "05" :
		print("<p>Votre paiement a été refusé par votre établissement bancaire</p>");
		break;

	case "33" :
		print("<p>La date de validité de votre carte bancaire est dépassée</p>");
		break;
	
	default : print("<p>La transaction n'a pu aboutir suite à un problème technique</p>");

}
?>