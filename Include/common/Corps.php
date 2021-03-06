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

	function checkUp($nom,$nbdd){
		require_once('./connexionbddplugit.class.php');
		$bdd=connexionbddplugit::getInstance();

		try{
			if($nbdd == 'menu')
				$rq = $bdd->prepare("SELECT * FROM menu WHERE upper(baseName) = ?");
			else
				$rq = $bdd->prepare("SELECT * FROM sousmenu WHERE upper(nom) = ?");
			$rq->execute(array(strtoupper($nom)));
			$ar= $rq->fetch();
		} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
		}
		
		return $ar['active'];	
	}

	switch ($_GET['page'])
	{	
		case 'accueil':
		if(checkUp('accueil','menu'))
			INCLUDE("include/invite/accueil.php");
		else
			echo '<h2>Page Inaccessible</h2>';
		break;
		
		case 'support':
		if(checkUp('support','menu'))
			INCLUDE("include/invite/support.php");
		else
			echo '<h2>Page Inaccessible</h2>';
		break;
		
		case 'reglement':
		if(checkUp('reglement','menu'))
			INCLUDE("include/invite/reglement.php");
		else
			echo '<h2>Page Inaccessible</h2>';
		break;
		
		case 'boutique':
		if(checkUp('boutique','menu'))
			INCLUDE("include/invite/boutique.php");
		else
			echo '<h2>Page Inaccessible</h2>';
		break;
		
		case 'cloud':
		if(checkUp('cloud','menu'))
			INCLUDE("include/invite/solutions.php");
		else
			echo '<h2>Page Inaccessible</h2>';
		break;

		case 'photocopieur':
		if(checkUp('photocopieur','menu'))
			INCLUDE("include/invite/solutions.php");
		else
			echo '<h2>Page Inaccessible</h2>';
		break;
		
		case 'webapps':
		if(checkUp('webapps','menu'))
			INCLUDE("include/invite/solutions.php");
		else
			echo '<h2>Page Inaccessible</h2>';
		break;
		
		case 'telephonie':
		if(checkUp('telephonie','menu'))
			INCLUDE("include/invite/solutions.php");
		else
			echo '<h2>Page Inaccessible</h2>';
		break;
		
		case 'references':
			INCLUDE("include/invite/references.php");
		break;
		
		case 'contact':
			INCLUDE("include/invite/contact.php");
		break;		
		
		//autre
		case 'services':
		if(checkUp('services','menu'))
			INCLUDE("include/invite/services.php");
		else
			echo '<h2>Page Inaccessible</h2>';
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

		case 'admin_reporting':
		if(isset($_SESSION['id']))
		{
			INCLUDE("include/admin/admin_report.php");
		}
		else
			echo '<h2>Access Forbidden</h2>';
		break;
		
		case 'admin_gestionnaire_rebut':
		if(isset($_SESSION['id']))
		{
			INCLUDE("include/admin/admin_gestionnaire_rebut.php");
		}
		else
			echo '<h2>Access Forbidden</h2>';
		break;
		
		case 'admin_article':
		if(isset($_SESSION['id']))
		{
			INCLUDE("include/admin/admin_article.php");
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
		
		case 'admin_categ_tva':
		if(isset($_SESSION['id']))
		{
			INCLUDE("include/admin/admin_categ_tva.php");
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
		
		case 'gestionnaire_rebut':
		if(isset($_SESSION['id']))
		{
			INCLUDE("include/admin/admin_gestionnaire_rebut.php");
		}
		else
			echo '<h2>Access Forbidden</h2>';
		break;
		
		case 'admin_contact':
		if(isset($_SESSION['id']))
		{
			INCLUDE("include/admin/admin_contact.php");
		}
		else
			echo '<h2>Access Forbidden</h2>';
		break;
		
		default :
		echo '<h2>Page Inexistante</h2>';
		break;
	}

?>
