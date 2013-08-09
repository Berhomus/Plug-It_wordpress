<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : trt_Produit.php => Plug-it
*********************************************************-->
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<div style="margin:auto;width:400px;">
<?php
	
	include("../function/upload.php");
	include("../function/trt_image.php");

	require_once('../connexionbddplugit.class.php');
	
	$bdd = connexionbddplugit::getInstance();
	
	if(isset($_GET['mode']))
	{
		switch($_GET['mode'])
		{
			case 'delete':
				echo ('<h2>Suppression Produit</h2>');
				if(isset($_GET['id']))
				{
					try{
						$rq=$bdd->prepare("SELECT COUNT(id) as cpt FROM produit WHERE id=?");
						$rq->execute(array($_GET['id']));
						$array=$rq->fetch();
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}
					
					if($array['cpt'])
					{
						try{
							$rq=$bdd->prepare("DELETE FROM produit WHERE id=?");
							$rq->execute(array($_GET['id']));
						} catch ( Exception $e ) {
							echo "Une erreur est survenue : ".$e->getMessage();
						}
						echo ('<h2 style="color:green;">Produit Supprimé !</h2>');
					}
					else
					{
						echo ('<h2 style="color:red;">Produit inexistant !</h2>');
					}
				}
				else
				{
					echo ('<h2 style="color:red;">Produit non spécifié !</h2>');
				}
			break;
			
			case 'modif':
				echo ('<h2>Modification Produit</h2>');
				if(isset($_GET['id']))
				{
					$rq=$bdd->prepare("SELECT COUNT(id) as cpt FROM produit WHERE id=?");
					$rq->execute(array($_GET['id']));
					$array=$rq->fetch();

					if($array['cpt'])
					{
						if(empty($_FILES['logoprod']['name'])or ($path = upload('../images/',100000,array('.png', '.gif', '.jpg', '.jpeg','.bmp'),'logoprod')) != '')
						{
								$rq=connexionbddplugit::getInstance()->query("SELECT * FROM produit WHERE id='".$_GET['id']."'");
								$array=$rq->fetch();
								$prix = (!empty($_POST['prix'])) ? round($_POST['prix']*100)/100:$array['prix'];
								$categorie = $_POST['categorie'];
								$titre = (!empty($_POST['titre'])) ? $_POST['titre']:$array['nom'];
								$corps = (!empty($_POST['corps'])) ? $_POST['corps']:$array['description'];
								$tva = $_POST['tva'];
								$path = (isset($path)) ? make_img_prod($path):$array['images'];
								$ordre = $_POST['ordre'];	
								$delai = (!empty($_POST['delai'])) ? $_POST['delai']:$array['delai'];
								
								try{
									$rq=$bdd->prepare("UPDATE produit SET priorite=?, categorie=?, prix=?, images=?, nom=?, description=?, tva=?, delai=? WHERE id=?");
									$rq->execute(array($ordre,$categorie,$prix,$path,$titre,$corps,$tva,$_GET['id'],$delai));
								} catch ( Exception $e ) {
									echo "Une erreur est survenue : ".$e->getMessage();
								}
								echo ('<h2 style="color:green;">Produit Modifié !</h2>');
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
										<input type="hidden" name="tva" value="<?php echo $_POST['tva'];?>"/>
										<input type="submit" value="Retour Formulaire"/>
									</form>
							<?php
							}
					}
					else
					{
						echo ('<h2 style="color:red;">Produit inexistant !</h2>');
					}
				}
				else
				{
					echo ('<h2 style="color:red;">Produit non spécifié !</h2>');
				}
			break;
			
			case 'create':
				echo ('<h2>Création Produit</h2>');
				if(isset($_POST) and !empty($_POST))
				{	
					
					if(($path = upload('../images/',100000,array('.png', '.gif', '.jpg', '.jpeg','.bmp'),'logoprod')) != '')
					{
							$titre = $_POST['titre'];
							$prix = round($_POST['prix']*100)/100;
							$categorie = $_POST['categorie'];
		
							$corps = $_POST['corps'];
							$ordre = $_POST['ordre'];
							$tva = $_POST['tva'];
							$delai = $_POST['delai'];
							
							//$path = make_img_prod($path);
							try{
								$rq=$bdd->prepare("INSERT INTO produit VALUES (Null,?,?,?,Null,?,?,?,?,?)");
								$rq->execute(array($titre,$path,$corps,$prix,$categorie,$tva,$ordre,$delai));
							} catch ( Exception $e ) {
								echo "Une erreur est survenue : ".$e->getMessage();
							}
							echo ('<h2 style="color:green;">Produit Créé !</h2>');
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
									<input type="hidden" name="tva" value="<?php echo $_POST['tva'];?>"/>
									<input type="submit" value="Retour Formulaire"/>
								</form>
							<?php
						}
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
	
	if(isset($_GET['categ']))
		$idcateg = $_GET['categ'];
	else
		$idcateg = $_POST['categorie'];
		
	
	
	if($idcateg == -1)
	{
		echo ('<center><a href="../index.php?page=admin_gestionnaire_rebut>Retour Rebut</a></center>');
	}
	else
	{
		$rq=$bdd->prepare("SELECT nom FROM sousmenu WHERE id=?");
		$rq->execute(array($idcateg));
		$ar = $rq->fetch();
		echo ('<center><a href="../index.php?page=boutique&categ='.$ar['nom'].'">Retour Produit</a></center>');
	}
	
?>
</div>
