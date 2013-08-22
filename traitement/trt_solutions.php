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
						try{
							$rq = $bdd->prepare("DELETE FROM solutions WHERE id=?");
							$rq->execute(array($_GET['id']));
							
							$rq = $bdd->prepare("DELETE FROM sousmenu WHERE ref=?");
							$rq->execute(array($_GET['id']));
									
							echo ('<h2 style="color:green;">Solution Supprimée !</h2>');
						} catch ( Exception $e ) {
							echo "Une erreur est survenue : ".$e->getMessage();
							echo ('<h2 style="color:red;">Solution Non-Supprimée !</h2>');
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
								$ordre = (!empty($_POST['ordre'])) ? $_POST['ordre']:$array['ordre'];	
								$menu = $_POST['menu_c'];
								$couleur = $_POST['color'];
								
								try{
									$rq = $bdd->prepare("UPDATE solutions SET ordre=?, image_sol=?, image_car=?, titre=?, description=?, corps=?,couleur=?,menu=? WHERE id=?");
									$rq->execute(array($ordre,$path,$path2,$titre,$desc,$corps,$couleur,$menu,$_GET['id']));
									
									$rq2 = $bdd->prepare("SELECT id FROM menu WHERE baseName=?");//id MENU via basename
									$rq2->execute(array($menu));
									$ar2 = $rq2->fetch();	
									
									$lien = "index.php?page=".$menu."&mode=viewone&id=".$_GET['id'];
									
									$rq = $bdd->prepare("UPDATE sousmenu SET nom=?,position=?,menu=? WHERE ref=?");
									$rq->execute(array($titre,$ordre,$ar2['id'],$_GET['id']));
									
									echo ('<h2 style="color:green;">Solution Modifiée !</h2>');
								} catch ( Exception $e ) {
									echo "Une erreur est survenue : ".$e->getMessage();
									echo ('<h2 style="color:red;">Solution Non-Modifiée !</h2>');
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
										<input type="hidden" name="couleur" value="<?php echo $_POST['color'];?>"/>
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
										<input type="hidden" name="couleur" value="<?php echo $_POST['color'];?>"/>
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
							
							$path2 = make_img($path2,$titre,$desc);
							$path = make_limg($path);
							$menu = $_POST['menu_c'];
							$couleur = $_POST['color'];
							
							try{
								$rq = $bdd->prepare("INSERT INTO solutions VALUES (Null,?,?,?,?,?,Null,?,?,?)");
								$rq->execute(array($titre,$corps,$path2,$path,$desc,$ordre,$couleur,$menu));
								$rq = $bdd->prepare("SELECT id,menu FROM solutions ORDER BY id LIMIT 0,1");
								$rq->execute();
								$ar = $rq->fetch();		
								
								$rq2 = $bdd->prepare("SELECT id FROM menu WHERE baseName=?");
								$rq2->execute(array($ar['menu']));
								$ar2 = $rq2->fetch();	
								
								$lien = "index.php?page=".$ar['menu']."&mode=viewone&id=".$ar['id'];
																
								$rq = $bdd->prepare("INSERT INTO sousmenu VALUES (Null,?,?,?,?,?,?)");
								$rq->execute(array($titre,1,$lien,$ordre,$ar2['id'],$ar['id']));
								echo ('<h2 style="color:green;">Solution Créé !</h2>');
							} catch ( Exception $e ) {
								$error = 1;
								echo "Une erreur est survenue : ".$e->getMessage();
								echo ('<h2 style="color:red;">Solution Non-Créé !</h2>');
							}
						}
						else
						{
							?>
								<form method="POST" action="../index.php?page=admin_solutions">
									<input type="hidden" name="nomsolu" value="<?php echo htmlspecialchars($_POST['nomsolu']);?>"/>
									<input type="hidden" name="desc" value="<?php echo htmlspecialchars($_POST['desc']);?>"/>
									<input type="hidden" name="corps" value="<?php echo htmlspecialchars($_POST['corps']);?>"/>
									<input type="hidden" name="couleur" value="<?php echo $_POST['color'];?>"/>
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
								<input type="hidden" name="couleur" value="<?php echo $_POST['color'];?>"/>
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
	
	
	
	echo ('<center><a href="../index.php?page=accueil">Retour</a></center>');
?>
</div>
