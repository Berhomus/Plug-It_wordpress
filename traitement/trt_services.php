<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : trt_services.php => Plug-it
*********************************************************-->

<div style="margin:auto;width:400px;">
<?php
	
	include("../function/upload.php");
	include("../function/update_ordre.php");
	
	require_once('./connexionbddplugit.class.php');


	if(isset($_GET['mode']))
	{
		switch($_GET['mode'])
		{
			case 'delete':
				echo '<h2>Suppression Service</h2>';
				if(isset($_GET['id']))
				{
					try{
						$rq=connexionbddplugit::getInstance()->query("SELECT COUNT(id) as cpt FROM services WHERE id='".$_GET['id']."'");
						$array=$rq->fetch();
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}
					
					if($array['cpt'])
					{
						try{
							$rq = connexionbddplugit::getInstance()->query("SELECT ordre FROM services WHERE id='".$_GET['id']."'");
							$ar = $rq->fetch();
						} catch ( Exception $e ) {
							echo "Une erreur est survenue : ".$e->getMessage();
						}
						
						update_ordre($ar['ordre'],0,-1,'services');
						try{
							connexionbddplugit::getInstance()->query("DELETE FROM services WHERE id='".$_GET['id']."'");
						} catch ( Exception $e ) {
							echo "Une erreur est survenue : ".$e->getMessage();
						}
						echo ('<h2 style="color:green;">Service Supprimé !</h2>');
					}
					else
					{
						echo ('<h2 style="color:red;">Service inexistante !</h2>');
					}
				}
				else
				{
					echo ('<h2 style="color:red;">Service non spécifié !</h2>');
				}
			break;
			
			case 'modif':
				echo '<h2>Modification Service</h2>';
				if(isset($_GET['id']))
				{
					try{
						$rq=connexionbddplugit::getInstance()->query("SELECT COUNT(id) as cpt FROM services WHERE id='".$_GET['id']."'");
						$array=$rq->fetch();
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}

					if($array['cpt'])
					{
						if(empty($_FILES['logoserv']['name']) or ($path = upload('../images/',100000,array('.png', '.gif', '.jpg', '.jpeg','.bmp'),'logoserv')) != '')
						{
							try{
								$rq=connexionbddplugit::getInstance()->query("SELECT * FROM services WHERE id='".$_GET['id']."'");
								$array=$rq->fetch();
							} catch ( Exception $e ) {
								echo "Une erreur est survenue : ".$e->getMessage();
							}
							
							$titre = (!empty($_POST['nomserv'])) ? $_POST['nomserv']:$array['titre'];
							$soustitre = (!empty($_POST['soustitre'])) ? $_POST['soustitre']:$array['subtitre'];
							$corps = (!empty($_POST['corps'])) ? $_POST['corps']:$array['corps'];
							$path = (isset($path)) ? $path:$array['image'];
							$ordre = $_POST['ordre'];
							
							$titre = htmlspecialchars($titre);
							$soustitre = htmlspecialchars($soustitre);
							
							$titre = mysql_real_escape_string($titre);
							$soustitre = mysql_real_escape_string($soustitre);
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
								update_ordre($array['ordre']-$pas,$ordre,$pas,'services');
							try{
								connexionbddplugit::getInstance()->query("UPDATE services SET ordre='$ordre', image='$path', titre='$titre', subtitre='$soustitre', corps='$corps' WHERE id='".$_GET['id']."'");
							} catch ( Exception $e ) {
								echo "Une erreur est survenue : ".$e->getMessage();
							}
							echo ('<h2 style="color:green;">Service Modifié !</h2>');
						}
						else
						{	
							?>		
									<form method="POST" action="../index.php?page=admin_services&id=<?php echo $_GET['id'];?>">
										<input type="hidden" name="nomserv" value="<?php echo htmlspecialchars($_POST['nomserv']);?>"/>
										<input type="hidden" name="soustitre" value="<?php echo htmlspecialchars($_POST['soustitre']);?>"/>
										<input type="hidden" name="corps" value="<?php echo htmlspecialchars($_POST['corps']);?>"/>
										<input type="hidden" name="ordre" value="<?php echo $_POST['ordre'];?>"/>
										<input type="submit" value="Retour Formulaire"/>
									</form>
							<?php
						}
					}
					else
					{
						echo ('<h2 style="color:red;">Service inexistante !</h2>');
					}
				}
				else
				{
					echo ('<h2 style="color:red;">Service non spécifié !</h2>');
				}
			break;
			
			case 'create':
				echo ('<h2>Création Service</h2>');
				if(isset($_POST) and !empty($_POST))
				{	
					
					if(($path = upload('../images/',100000,array('.png', '.gif', '.jpg', '.jpeg','.bmp'),'logoserv')) != '')
					{
						$titre = htmlspecialchars($_POST['nomserv']);
						$soustitre = htmlspecialchars($_POST['soustitre']);
						
						$titre = mysql_real_escape_string($titre);
						$soustitre = mysql_real_escape_string($soustitre);
						$corps = mysql_real_escape_string($_POST['corps']);
						$ordre = $_POST['ordre'];
						
						update_ordre($ordre,0,1,'services');
						try{
							connexionbddplugit::getInstance()->query("INSERT INTO services VALUES (Null,'$titre','$corps','$path','$soustitre',Null,'$ordre')");
						} catch ( Exception $e ) {
							echo "Une erreur est survenue : ".$e->getMessage();
						}
						echo ('<h2 style="color:green;">Service Créé !</h2>');
					}
					else
					{
						?>
								
									<form method="POST" action="../index.php?page=admin_services">
										<input type="hidden" name="nomserv" value="<?php echo htmlspecialchars($_POST['nomserv']);?>"/>
										<input type="hidden" name="soustitre" value="<?php echo htmlspecialchars($_POST['soustitre']);?>"/>
										<input type="hidden" name="corps" value="<?php echo htmlspecialchars($_POST['corps']);?>"/>
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
	
	
	
	echo ('<center><a href="../index.php?page=services">Retour Services</a></center>');
?>
</div>
