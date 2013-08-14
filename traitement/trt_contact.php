<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : trt_contact.php => Plug-it
*********************************************************-->
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<div style="margin:auto;width:400px;">
<?php

	require_once('../connexionbddplugit.class.php');
	
	$bdd = connexionbddplugit::getInstance();
	
	if(isset($_GET['mode']))
	{
		switch($_GET['mode'])
		{
			case 'delete':
				echo ('<h2>Suppression Contact</h2>');
				if(isset($_GET['id']))
				{
					try{
						$rq=$bdd->prepare("SELECT COUNT(id) as cpt FROM contact WHERE id=?");
						$rq->execute(array($_GET['id']));
						$array=$rq->fetch();
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}
					
					if($array['cpt'])
					{
						try{
							$rq=$bdd->prepare("DELETE FROM contact WHERE id=?");
							$rq->execute(array($_GET['id']));
						} catch ( Exception $e ) {
							echo "Une erreur est survenue : ".$e->getMessage();
						}
						echo ('<h2 style="color:green;">Contact Supprimé !</h2>');
					}
					else
					{
						echo ('<h2 style="color:red;">Contact inexistant !</h2>');
					}
				}
				else
				{
					echo ('<h2 style="color:red;">Contact non spécifié !</h2>');
				}
			break;
			
			case 'modif':
				echo ('<h2>Modification contact</h2>');
				if(isset($_GET['id']))
				{
					$rq=$bdd->prepare("SELECT COUNT(id) as cpt FROM contact WHERE id=?");
					$rq->execute(array($_GET['id']));
					$array=$rq->fetch();

					if($array['cpt'])
					{
						$rq=connexionbddplugit::getInstance()->query("SELECT * FROM contact WHERE id='".$_GET['id']."'");
						$array=$rq->fetch();
						
						$ville = (!empty($_POST['ville'])) ? $_POST['ville']:$array['ville'];
						$courriel = (!empty($_POST['courriel'])) ? $_POST['courriel']:$array['courriel'];
						$coordonnees = (!empty($_POST['coordonnees'])) ? $_POST['coordonnees']:$array['coordonnees'];
						$longitude = (!empty($_POST['longitude'])) ? $_POST['longitude']:$array['longitude'];
						$latitude = (!empty($_POST['latitude'])) ? $_POST['latitude']:$array['latitude'];
						
						
						try{
							$rq=$bdd->prepare("UPDATE contact SET ville=?, courriel=?, coordonnees=?, longitude=?, latitude=? WHERE id=?");
							$rq->execute(array($ville,$courriel,$coordonnees,$longitude,$latitude,$_GET['id']));
						} catch ( Exception $e ) {
							echo "Une erreur est survenue : ".$e->getMessage();
						}
						echo ('<h2 style="color:green;">Contact Modifié !</h2>');
					}
					else
					{
						echo ('<h2 style="color:red;">Contact inexistant !</h2>');
					}
				}
				else
				{
					echo ('<h2 style="color:red;">Contact non spécifié !</h2>');
				}
			break;
			
			case 'create':
				echo ('<h2>Création contact</h2>');
				if(isset($_POST) and !empty($_POST))
				{	
					
					$ville = $_POST['ville'];
					$courriel = $_POST['courriel'];
					$coordonnees = $_POST['coordonnees'];
					$longitude = $_POST['longitude'];
					$latitude = $_POST['latitude'];
					
					try{
						$rq=$bdd->prepare("INSERT INTO contact VALUES (Null,?,?,?,?,?)");
						$rq->execute(array($ville,$courriel,$coordonnees,$latitude,$longitude));
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}
					echo ('<h2 style="color:green;">contact Créé !</h2>');
						
				}
				else
				{
					echo ('<h2 style="color:red;">Donnée inexistant !</h2>');
				}
			break;
			
			default:
				echo ('<h2 style="color:red;">404 Page Introuvable !</h2>');
			break;
		}
	}
	else
	{
		echo ('<h2 style="color:red;">Mode Non spécifié !</h2>');
	}
	
	echo ('<center><a href="../index.php?page=contact">Retour contact</a></center>');
?>
</div>
