<?php

if(isset($_POST) and !empty($_POST))
{
	require_once('../connexionbddplugit.class.php');

	$bdd = connexionbddplugit::getInstance();
	if($_POST['sup'] == 1)
	{
		foreach($_POST as $idprod => $val)
		{
			if(is_numeric($idprod) and $val == true)
			{	
				try{
					$rq = $bdd->prepare("DELETE FROM produit WHERE id=?");
					$rq->execute(array($idprod));
					echo '<h2 style="color:green;">Suppression '.$idprod.' Réussite !</h2>';
				}
				catch(Exception $e){
					echo '<h2 color:red;>Suppression '.$idprod.' Echoué !</h2>';
				}
			}
		}
	}
	else
	{
		$complement = '';

		if($_POST['tva'] != -1 and $_POST['categ'] != -1)
		{
			$complement = 'tva=?, categorie=?';
			$valeur = array($_POST['tva'],$_POST['categ']);
		}
		else if($_POST['tva'] != -1)
		{
			$complement = 'tva=?';
			$valeur = array($_POST['tva']);
		}
		else if($_POST['categ'] != -1)
		{
			$complement = 'categorie=?';
			$valeur = array($_POST['categorie'],);
		}
		
		if($complement != '')
		{
			foreach($_POST as $idprod => $val)
			{
				if(is_numeric($idprod) and $val == true)
				{	
					try{
						$rq = $bdd->prepare("UPDATE produit SET ".$complement." WHERE id=?");
						$rq->execute(array_merge($valeur,array($idprod)));
						echo '<h2 style="color:green;">Modification '.$idprod.' Réussite !</h2>';
					}
					catch(Exception $e){
						echo '<h2 color:red;>Modification '.$idprod.' Echoué !</h2>';
						echo $e->getMessage();
					}
				}
			}
		}
		else
		{
			echo '<h2 color:red;>Rien à Modifier !</h2>';
		}
	}
}

echo '<center><a href="../index.php?page=admin_gestionnaire_rebut"><-</a><center>';
?>