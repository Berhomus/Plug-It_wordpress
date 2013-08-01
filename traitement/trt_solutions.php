<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : trt_solutions.php => Plug-it
*********************************************************-->
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<div style="margin:auto;width:400px;">
<?php
	
	include("../function/upload.php");
	include("../function/update_ordre.php");
	include("../function/trt_image.php");
	
	require_once('../connexionbddplugit.class.php');
	
	$bdd = connexionbddplugit::getInstance();
	
	if(isset($_GET['mode']))
	{
		switch($_GET['mode'])
		{
			case 'delete':
				echo ('<h2>Suppression Solution</h2>');
				if(isset($_GET['id']))
				{
					try{
						$rq=$bdd->prepare("SELECT COUNT(id) as cpt FROM solutions WHERE id=?");
						$rq->execute(array($_GET['id']));
						$array=$rq->fetch();
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}
			
					if($array['cpt'])
					{
						try{
							$rq = $bdd->prepare("SELECT ordre FROM solutions WHERE id=?");
							$rq->execute(array($_GET['id']));
							$ar = $rq->fetch();
						} catch ( Exception $e ) {
							echo "Une erreur est survenue : ".$e->getMessage();
						}
						update_ordre($ar['ordre'],0,-1,'solutions');
						try{
							$rq = $bdd->prepare("DELETE FROM solutions WHERE id=?");
							$rq->execute(array($_GET['id']));
						} catch ( Exception $e ) {
							echo "Une erreur est survenue : ".$e->getMessage();
						}
						echo ('<h2 style="color:green;">Solution Supprimée !</h2>');
					}
					else
					{
						echo ('<h2 style="color:red;">Solution inexistante !</h2>');
					}
				}
				else
				{
					echo ('<h2 style="color:red;">Solution non spécifiée !</h2>');
				}
			break;
			
			case 'modif':
				echo ('<h2>Modification Solution</h2>');
				if(isset($_GET['id']))
				{
					try{
						$rq=$bdd->prepare("SELECT COUNT(id) as cpt FROM solutions WHERE id=?");
						$rq->execute(array($_GET['id']));
						$array=$rq->fetch();
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}

					if($array['cpt'])
					{
						if(empty($_FILES['logosolu']['name'])or ($path = upload('../images/',100000,array('.png', '.gif', '.jpg', '.jpeg','.bmp'),'logosolu')) != '')
						{
						
							if(empty($_FILES['grandeimg']['name'])or ($path2 = upload('../images/',300*1024,array('.png', '.gif', '.jpg', '.jpeg','.bmp'),'grandeimg')) != '')
							{
								try{
									$rq=$bdd->prepare("SELECT * FROM solutions WHERE id=?");
									$rq->execute(array($_GET['id']));
									$array=$rq->fetch();
								} catch ( Exception $e ) {
									echo "Une erreur est survenue : ".$e->getMessage();
								}
								
								$titre = (!empty($_POST['nomsolu'])) ? $_POST['nomsolu']:$array['titre'];
								$desc = (!empty($_POST['desc'])) ? $_POST['desc']:$array['description'];
								$corps = (!empty($_POST['corps'])) ? $_POST['corps']:$array['corps'];
								$path = (isset($path)) ? make_limg($path):$array['image_sol'];
								$path2 = (isset($path2)) ? make_img($path2,$titre,$desc):$array['image_car'];
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
									update_ordre($array['ordre']-$pas,$ordre,$pas,'solutions');
								
								try{
									$rq = $bdd->prepare("UPDATE solutions SET ordre=?, image_sol=?, image_car=?, titre=?, description=?, corps=? WHERE id=?");
									$rq->execute(array($ordre,$path,$path2,$titre,$desc,$corps,$_GET['id']));
								} catch ( Exception $e ) {
									echo "Une erreur est survenue : ".$e->getMessage();
								}
								echo ('<h2 style="color:green;">Solution Modifiée !</h2>');
							}
							else
							{
							?>
								
									<form method="POST" action="../index.php?page=admin_solutions&id=<?php echo $_GET['id']?>">
										<input type="hidden" name="nomsolu" value="<?php echo htmlspecialchars($_POST['nomsolu']);?>"/>
										<input type="hidden" name="desc" value="<?php echo htmlspecialchars($_POST['desc']);?>"/>
										<input type="hidden" name="corps" value="<?php echo htmlspecialchars($_POST['corps']);?>"/>
										<input type="hidden" name="ordre" value="<?php echo $_POST['ordre'];?>"/>
										<input type="submit" value="Retour Formulaire"/>
									</form>
							<?php
							}
						}
						else
						{
							?>
								
									<form method="POST" action="../index.php?page=admin_solutions&id=<?php echo $_GET['id']?>">
										<input type="hidden" name="nomsolu" value="<?php echo htmlspecialchars($_POST['nomsolu']);?>"/>
										<input type="hidden" name="desc" value="<?php echo htmlspecialchars($_POST['desc']);?>"/>
										<input type="hidden" name="corps" value="<?php echo htmlspecialchars($_POST['corps']);?>"/>
										<input type="hidden" name="ordre" value="<?php echo $_POST['ordre'];?>"/>
										<input type="submit" value="Retour Formulaire"/>
									</form>
							<?php
						}
					}
					else
					{
						echo ('<h2 style="color:red;">Solution inexistante !</h2>');
					}
				}
				else
				{
					echo ('<h2 style="color:red;">Solution non spécifiée !</h2>');
				}
			break;
			
			case 'create':
				echo ('<h2>Création Solution</h2>');
				if(isset($_POST) and !empty($_POST))
				{	
					
					if(($path = upload('../images/',100000,array('.png', '.gif', '.jpg', '.jpeg','.bmp'),'logosolu')) != '')
					{
						if(($path2 = upload('../images/',300*1024,array('.png', '.gif', '.jpg', '.jpeg','.bmp','.avi','.mp4'),'grandeimg')) != '')
						{
							$ordre = $_POST['ordre'];
							$titre = $_POST['nomsolu'];
							$corps = $_POST['corps'];
							$desc = $_POST['desc'];
							update_ordre($ordre,0,1,'solutions');
							$path2 = make_img($path2,$titre,$desc);
							$path = make_limg($path);
							
							try{
								$rq = $bdd->prepare("INSERT INTO solutions VALUES (Null,?,?,?,?,?,Null,?)");
								$rq->execute(array($titre,$corps,$path2,$path,$desc,$ordre));
							} catch ( Exception $e ) {
								echo "Une erreur est survenue : ".$e->getMessage();
							}
							echo ('<h2 style="color:green;">Solution Créée !</h2>');
						}
						else
						{
							?>
								<form method="POST" action="../index.php?page=admin_solutions">
									<input type="hidden" name="nomsolu" value="<?php echo htmlspecialchars($_POST['nomsolu']);?>"/>
									<input type="hidden" name="desc" value="<?php echo htmlspecialchars($_POST['desc']);?>"/>
									<input type="hidden" name="corps" value="<?php echo htmlspecialchars($_POST['corps']);?>"/>
									<input type="submit" value="Retour Formulaire"/>
								</form>
							<?php
						}
					}
					else
					{
						?>	
							<form method="POST" action="../index.php?page=admin_solutions">
								<input type="hidden" name="nomsolu" value="<?php echo htmlspecialchars($_POST['nomsolu']);?>"/>
								<input type="hidden" name="desc" value="<?php echo htmlspecialchars($_POST['desc']);?>"/>
								<input type="hidden" name="corps" value="<?php echo htmlspecialchars($_POST['corps']);?>"/>
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
	
	
	
	echo ('<center><a href="../index.php?page=solutions">Retour Solution</a></center>');
?>
</div>
