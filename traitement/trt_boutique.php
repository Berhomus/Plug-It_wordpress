<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : trt_Produit.php => Plug-it
*********************************************************-->

<div style="margin:auto;width:400px;">
<?php
	
	include("../function/upload.php");
	include("../function/trt_image.php");

	require_once('../connexionbddplugit.class.php');
	
	if(isset($_GET['mode']))
	{
		switch($_GET['mode'])
		{
			case 'delete':
				echo ('<h2>Suppression Produit</h2>');
				if(isset($_GET['id']))
				{
					try{
						$rq=connexionbddplugit::getInstance()->query("SELECT COUNT(id) as cpt FROM produit WHERE id='".$_GET['id']."'");
						$array=$rq->fetch();
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}
					
					if($array['cpt'])
					{
						try{
							$rq = connexionbddplugit::getInstance()->query("SELECT ordre FROM produit WHERE id='".$_GET['id']."'")or die("fail ".$i. " => Erreur SQL !<br />".mysql_error());
							$ar = $rq->fetch();
						} catch ( Exception $e ) {
							echo "Une erreur est survenue : ".$e->getMessage();
						}

						try{
							connexionbddplugit::getInstance()->query("DELETE FROM produit WHERE id='".$_GET['id']."'");
						} catch ( Exception $e ) {
							echo "Une erreur est survenue : ".$e->getMessage();
						}
						echo ('<h2 style="color:green;">Produit Supprimée !</h2>');
					}
					else
					{
						echo ('<h2 style="color:red;">Produit inexistante !</h2>');
					}
				}
				else
				{
					echo ('<h2 style="color:red;">Produit non spécifiée !</h2>');
				}
			break;
			
			case 'modif':
				echo ('<h2>Modification Produit</h2>');
				if(isset($_GET['id']))
				{
					$rq=connexionbddplugit::getInstance()->query("SELECT COUNT(id) as cpt FROM produit WHERE id='".$_GET['id']."'");
					$array=$rq->fetch();

					if($array['cpt'])
					{
						if(empty($_FILES['logoprod']['name'])or ($path = upload('../images/',100000,array('.png', '.gif', '.jpg', '.jpeg','.bmp'),'logosolu')) != '')
						{
								$rq=connexionbddplugit::getInstance()->query("SELECT * FROM produit WHERE id='".$_GET['id']."'");
								$array=$rq->fetch();
								
								$prix = $_POST['prix'];
								$categorie = $_POST['categorie'];
								$titre = (!empty($_POST['titre'])) ? $_POST['titre']:$array['nom'];
								$corps = (!empty($_POST['corps'])) ? $_POST['corps']:$array['corps'];
								$path = (isset($path)) ? make_img_prod($path):$array['images'];
								$ordre = $_POST['ordre'];
								
								$titre = htmlspecialchars($titre);
								
								$titre = mysql_real_escape_string($titre);
								$corps = mysql_real_escape_string($corps);							
								
								try{
									connexionbddplugit::getInstance()->query("UPDATE produit SET priorite='$ordre', categorie='$categorie', prix='$prix',priorite='$ordre', images='$path', nom='$titre', desc='$corps' WHERE id='".$_GET['id']."'");
								} catch ( Exception $e ) {
									echo "Une erreur est survenue : ".$e->getMessage();
								}
								echo ('<h2 style="color:green;">Produit Modifiée !</h2>');
							}
							else
							{
							?>
								
									<form method="POST" action="../index.php?page=admin_boutique&id=<?php echo $_GET['id']?>">
										<input type="hidden" name="nom" value="<?php echo htmlspecialchars($_POST['titre']);?>"/>
										<input type="hidden" name="corps" value="<?php echo htmlspecialchars($_POST['corps']);?>"/>
										<input type="hidden" name="ordre" value="<?php echo $_POST['ordre'];?>"/>
										<input type="hidden" name="categorie" value="<?php echo $_POST['categorie'];?>"/>
										<input type="hidden" name="prix" value="<?php echo $_POST['prix'];?>"/>
										<input type="submit" value="Retour Formulaire"/>
									</form>
							<?php
							}
					}
					else
					{
						echo ('<h2 style="color:red;">Produit inexistante !</h2>');
					}
				}
				else
				{
					echo ('<h2 style="color:red;">Produit non spécifiée !</h2>');
				}
			break;
			
			case 'create':
				echo ('<h2>Création Produit</h2>');
				if(isset($_POST) and !empty($_POST))
				{	
					
					if(($path = upload('../images/',100000,array('.png', '.gif', '.jpg', '.jpeg','.bmp'),'logoprod')) != '')
					{
							$titre = htmlspecialchars($_POST['titre']);
							$prix = $_POST['prix'];
							$categorie = $_POST['categorie'];
							
							$titre = mysql_real_escape_string($titre);
							$corps = mysql_real_escape_string($_POST['corps']);
							$ordre = $_POST['ordre'];
							
							//$path = make_img_prod($path);
							try{
								connexionbddplugit::getInstance()->query("INSERT INTO produit VALUES (Null,'$titre','$path','$corps',Null,'$prix','$categorie','$ordre')");
							} catch ( Exception $e ) {
								echo "Une erreur est survenue : ".$e->getMessage();
							}
							echo ('<h2 style="color:green;">Produit Créée !</h2>');
						}
						else
						{
							?>
								<form method="POST" action="../index.php?page=admin_boutique">
									<input type="hidden" name="nomsolu" value="<?php echo htmlspecialchars($_POST['titre']);?>"/>
									<input type="hidden" name="corps" value="<?php echo htmlspecialchars($_POST['corps']);?>"/>
									<input type="hidden" name="ordre" value="<?php echo $_POST['ordre'];?>"/>
									<input type="hidden" name="categorie" value="<?php echo $_POST['categorie'];?>"/>
									<input type="hidden" name="prix" value="<?php echo $_POST['prix'];?>"/>
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
	
	echo ('<center><a href="../index.php?page=boutique">Retour Produit</a></center>');
?>
</div>
