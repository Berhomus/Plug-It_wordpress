<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : trt_solutions.php => Plug-it
*********************************************************-->

<div style="margin:auto;width:400px;">
<?php
	
	include("../function/upload.php");
	include("../function/update_ordre.php");
	include("../function/trt_image.php");
	
	require_once('./connexionbddplugit.class.php');
	
	if(isset($_GET['mode']))
	{
		switch($_GET['mode'])
		{
			case 'delete':
				echo ('<h2>Suppression Solution</h2>');
				if(isset($_GET['id']))
				{
					try{
						$rq=connexionbddplugit::getInstance()->query("SELECT COUNT(id) as cpt FROM solutions WHERE id='".$_GET['id']."'");
						$array=$rq->fetch();
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}
			
					if($array['cpt'])
					{
						try{
							$rq = connexionbddplugit::getInstance()->query("SELECT ordre FROM solutions WHERE id='".$_GET['id']."'");
							$ar = $rq->fetch();
						} catch ( Exception $e ) {
							echo "Une erreur est survenue : ".$e->getMessage();
						}
						update_ordre($ar['ordre'],0,-1,'solutions');
						try{
							connexionbddplugit::getInstance()->query("DELETE FROM solutions WHERE id='".$_GET['id']."'");
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
						$rq=connexionbddplugit::getInstance()->query("SELECT COUNT(id) as cpt FROM solutions WHERE id='".$_GET['id']."'");
						$array=$rq->fetch();
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}

					if($array['cpt'])
					{
						if(empty($_FILES['logosolu']['name'])or ($path = upload('../images/',100000,array('.png', '.gif', '.jpg', '.jpeg','.bmp'),'logosolu')) != '')
						{
						
							if(empty($_FILES['grandeimg']['name'])or ($path2 = upload('../images/',300*1024,array('.png', '.gif', '.jpg', '.jpeg','.bmp','.avi','.mp4'),'grandeimg')) != '')
							{
								try{
									$rq=connexionbddplugit::getInstance()->query("SELECT * FROM solutions WHERE id='".$_GET['id']."'");
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
								
								$titre = htmlspecialchars($titre);
								
								$titre = mysql_real_escape_string($titre);
								$desc = mysql_real_escape_string($desc);
								$corps = mysql_real_escape_string($corps);							
								
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
									connexionbddplugit::getInstance()->query("UPDATE solutions SET ordre='$ordre', image_sol='$path', image_car='$path2', titre='$titre', description='$desc', corps='$corps' WHERE id='".$_GET['id']."'");
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
							$titre = htmlspecialchars($_POST['nomsolu']);

							
							$titre = mysql_real_escape_string($titre);
							$desc = mysql_real_escape_string($_POST['desc']);
							$corps = mysql_real_escape_string($_POST['corps']);
							$ordre = $_POST['ordre'];
							
							update_ordre($ordre,0,1,'solutions');
							$path2 = make_img($path2,$titre,$desc);
							$path = make_limg($path);
							
							try{
								connexionbddplugit::getInstance()->query("INSERT INTO solutions VALUES (Null,'$titre','$corps','$path2','$path','$desc',Null,'$ordre')");
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
