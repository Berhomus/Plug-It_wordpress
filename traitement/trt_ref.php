<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : trt_ref.php => Plug-it
*********************************************************-->
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<div style="margin:auto;width:80%;">
<?php
	
	include("../function/upload.php");
	include("../function/update_ordre.php");
	
	require_once('../connexionbddplugit.class.php');
	
	$bdd = connexionbddplugit::getInstance();

	if(isset($_GET['mode']))
	{
		switch($_GET['mode'])
		{
			case 'delete':
				echo ('<h2>Suppression Référence</h2>');
				if(isset($_GET['id']))
				{
					$ordre = $_POST['ordre'];
					try{
						$rq=$bdd->prepare("SELECT COUNT(id) as cpt FROM ref WHERE id=?");
						$rq->execute(array($_GET['id']));
						$array=$rq->fetch();
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}
					
					if($array['cpt'])
					{
						try{
							$rq = $bdd->prepare("SELECT ordre FROM ref WHERE id=?");
							$rq->execute(array($_GET['id']));
							$ar = $rq->fetch();
						} catch ( Exception $e ) {
							echo "Une erreur est survenue : ".$e->getMessage();
						}	
							
						update_ordre($ar['ordre'],0,-1,'ref');
						try{
							$rq = $bdd->prepare("DELETE FROM ref WHERE id=?");
							$rq->execute(array($_GET['id']));
						} catch ( Exception $e ) {
							echo "Une erreur est survenue : ".$e->getMessage();
						}
						echo ('<h2 style="color:green;">Référence Supprimée !</h2>');
					}
					else
					{
						echo ('<h2 style="color:red;">Référence inexistante !</h2>');
					}
				}
				else
				{
					echo ('<h2 style="color:red;">Référence non spécifiée !</h2>');
				}
			break;
			
			case 'modif':
				echo ('<h2>Modification Référence</h2>');
				if(isset($_GET['id']))
				{
					try{
						$rq=$bdd->prepare("SELECT COUNT(id) as cpt FROM ref WHERE id=?");
						$rq->execute(array($_GET['id']));
						$array=$rq->fetch();
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}

					if($array['cpt'])
					{
						if(empty($_FILES['logo']['name']) or ($path = upload('../images/',100000,array('.png', '.gif', '.jpg', '.jpeg','bmp'),'logo')) != '')
						{
							try{
								$rq=$bdd->prepare("SELECT * FROM ref WHERE id=?");
								$rq->execute(array($_GET['id']));
								$array=$rq->fetch();
							} catch ( Exception $e ) {
								echo "Une erreur est survenue : ".$e->getMessage();
							}
							
							$titre = (!empty($_POST['nomcli'])) ? $_POST['nomcli']:$array['titre'];
							$soustitre = (!empty($_POST['soustitre'])) ? $_POST['soustitre']:$array['sous_titre'];
							$lien = (!empty($_POST['lien'])) ? $_POST['lien']:$array['lien'];
							$path = (isset($path)) ? $path:$array['image'];
							$ordre = $_POST['ordre'];
							
							if($ordre>$array['ordre'])
							{
								$pas=-1;
							}
							else
							{
								$pas=1;
							}
							
							if($ordre!=$array['ordre'])
								update_ordre($array['ordre']-$pas,$ordre,$pas,'ref');
							
							try{
								$rq = $bdd->prepare("UPDATE ref SET ordre=?, image=?, titre=?, sous_titre=?, lien=? WHERE id=?");
								$rq->execute(array($ordre,$path,$titre,$soustitre,$lien,$_GET['id']));
							} catch ( Exception $e ) {
								echo "Une erreur est survenue : ".$e->getMessage();
							}	
							echo ('<h2 style="color:green;">Référence Modifiée !</h2>');
						}
						else
						{
							?>
								<form method="POST" action="../index.php?page=admin_ref&id=<?php echo $_GET['id']?>">
									<input type="hidden" name="nomsolu" value="<?php echo htmlspecialchars($_POST['nomcli']);?>"/>
									<input type="hidden" name="desc" value="<?php echo htmlspecialchars($_POST['soustitre']);?>"/>
									<input type="hidden" name="corps" value="<?php echo htmlspecialchars($_POST['lien']);?>"/>
									<input type="hidden" name="ordre" value="<?php echo $_POST['ordre'];?>"/>
									<input type="submit" value="Retour Formulaire"/>
								</form>
							<?php
						}
					}
					else
					{
						echo ('<h2 style="color:red;">Référence inexistante !</h2>');
					}
				}
				else
				{
					echo ('<h2 style="color:red;">Référence non spécifiée !</h2>');
				}
			break;
			
			case 'create':
				echo ('<h2>Création Référence</h2>');
				if(isset($_POST) and !empty($_POST))
				{	
					
					if(($path = upload('../images/',100000,array('.png', '.gif', '.jpg', '.jpeg'),'logo','.bmp')) != '')
					{
						$titre = htmlspecialchars($_POST['nomcli']);
						$soustitre = htmlspecialchars($_POST['soustitre']);
						$lien = htmlspecialchars($_POST['lien']);
						$ordre = $_POST['ordre'];
						
						update_ordre($ordre,0,1,'ref');
						try{
							$rq = $bdd->prepare("INSERT INTO ref VALUES (Null,?,?,?,?,Null,?)");
							$rq->execute(array($path,$titre,$lien,$soustitre,$ordre));
						} catch ( Exception $e ) {
							echo "Une erreur est survenue : ".$e->getMessage();
						}
						echo ('<h2 style="color:green;">Référence Créée !</h2>');
					}
					else
					{
						?>
							<form method="POST" action="../index.php?page=admin_ref">
								<input type="hidden" name="nomsolu" value="<?php echo htmlspecialchars($_POST['nomcli']);?>"/>
								<input type="hidden" name="desc" value="<?php echo htmlspecialchars($_POST['soustitre']);?>"/>
								<input type="hidden" name="corps" value="<?php echo htmlspecialchars($_POST['lien']);?>"/>
								<input type="hidden" name="ordre" value="<?php echo $_POST['ordre'];?>"/>
								<input type="submit" value="Retour Formulaire"/>
							</form>
						<?php
					}
				}
				else
				{
					echo ('<h2 style="color:red;">Donnée inexistante !</h2>');
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
	
	
	
	echo ('<center><a href="../index.php?page=references">Retour Référence</a></center>');
?>
</div>
