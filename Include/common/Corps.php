<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : Corps.php => Plug-it
*********************************************************-->


<?php
	if(!isset($_GET['page']))
	{
		$_GET['page'] = 'accueil';
	}
?>	

<?php	

	function checkUp($nom){
		require_once('./connexionbddplugit.class.php');

		try{
			$bdd = connexionbddplugit::getInstance();
			$rq = $bdd->prepare("SELECT * FROM menu WHERE baseName = ?");
			$rq->execute(array($nom));
			$ar= $rq->fetch();
		} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
		}
		
		return $ar['active'];	
	}

	switch ($_GET['page'])
	{	
		case 'accueil':
		if(checkUp('accueil'))
			INCLUDE("include/invite/accueil.php");
		else
			echo '<h2>Page Inaccessible</h2>';
		break;
		
		case 'solutions':
		if(checkUp('solutions'))
			INCLUDE("include/invite/solutions.php");
		else
			echo '<h2>Page Inaccessible</h2>';
		break;
		
		case 'references':
		if(checkUp('references'))
			INCLUDE("include/invite/references.php");
		else
			echo '<h2>Page Inaccessible</h2>';
		break;
		
		case 'contact':
		if(checkUp('contact'))
			INCLUDE("include/invite/contact.php");
		else
			echo '<h2>Page Inaccessible</h2>';
		break;
		
		case 'support':
		if(checkUp('support'))
			INCLUDE("include/invite/support.php");
		else
			echo '<h2>Page Inaccessible</h2>';
		break;
		
		case 'reglement':
		if(checkUp('reglement'))
			INCLUDE("include/invite/reglement.php");
		else
			echo '<h2>Page Inaccessible</h2>';
		break;

		
		
		case 'boutique':
		if(checkUp('boutique'))
			INCLUDE("include/invite/boutique.php");
		else
			echo '<h2>Page Inaccessible</h2>';
		break;
		
		
		//autre
		case 'services':
		INCLUDE("include/invite/services.php");
		break;
		
		case 'paiement_final':
		INCLUDE("include/invite/paiement.php");
		break;
		
		//api paiement 
		case 'trt_paiement':
		if(isset($_POST['DATA']))
		{
			INCLUDE("include/invite/trt_paiement.php");
		}
		else
			echo '<h2>Page Unreachable</h2>';
		break;
		
		//admin
		
		case 'admin':
		INCLUDE("include/admin/admin.php");
		break;
		
		case 'admin_solutions':
		if(isset($_SESSION['id']))
		{
			INCLUDE("include/admin/admin_solutions.php");
		}
		else
			echo '<h2>Access Forbidden</h2>';
		break;
		
		case 'admin_report':
		if(isset($_SESSION['id']))
		{
			INCLUDE("include/admin/admin_report.php");
		}
		else
			echo '<h2>Access Forbidden</h2>';
		break;
		
		case 'admin_boutique':
		if(isset($_SESSION['id']))
		{
			INCLUDE("include/admin/admin_boutique.php");
		}
		else
			echo '<h2>Access Forbidden</h2>';
		break;
		
		case 'admin_menu':
		if(isset($_SESSION['id']))
		{
			INCLUDE("include/admin/admin_menu.php");
		}
		else
			echo '<h2>Access Forbidden</h2>';
		break;
		
		case 'admin_gest_menu':
		if(isset($_SESSION['id']))
		{
			INCLUDE("include/admin/admin_gest_menu.php");
		}
		else
			echo '<h2>Access Forbidden</h2>';
		break;
		
		case 'admin_services':
		if(isset($_SESSION['id']))
		{
			INCLUDE("include/admin/admin_services.php");
		}
		else
			echo '<h2>Access Forbidden</h2>';
		break;
		
		case 'admin_ref':
		if(isset($_SESSION['id']))
		{
			INCLUDE("include/admin/admin_ref.php");
		}
		else
			echo '<h2>Access Forbidden</h2>';
		break;
		
		case 'gestionnaire_img':
		if(isset($_SESSION['id']))
		{
			INCLUDE("traitement/gestionnaire_img.php");
		}
		else
			echo '<h2>Access Forbidden</h2>';
		break;
		
		case 'backup':
		if(isset($_SESSION['id']))
		{
			INCLUDE("traitement/backup.php");
		}
		else
			echo '<h2>Access Forbidden</h2>';
		break;
		
		case 'mass_mailing':
		if(isset($_SESSION['id']))
		{
			INCLUDE("include/admin/mass_mail.php");
		}
		else
			echo '<h2>Access Forbidden</h2>';
		break;
		
		default :
		echo '<h2>Page Inexistante</h2>';
		break;
	}

?>
