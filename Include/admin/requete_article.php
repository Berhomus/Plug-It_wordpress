<?php
	require_once('../../connexionbddplugit.class.php');
	$bdd =connexionbddplugit::getInstance();
	
	if(isset($_POST["rq"]))
	{
		try{
				$param = array();
				if(isset($_POST['array']) && !empty($_POST['array']))
				{
					$_POST['array'] = str_replace('↓','&',$_POST['array']);
					$param = preg_split("/,/",$_POST['array']);
				}
				
				// var_dump($param);
				
				$rq = $bdd->prepare($_POST["rq"]);
				$rq->execute($param);

				switch($_POST["type"])
				{
					case 'getposi':
						$texte = "";
						while($ar = $rq->fetch())
						{
							$texte .= '<option value='.$ar['id'].'>'.$ar['nom'].'</option>';
						}
						echo $texte;
					break;
					
					case 'ajout' :
						$rq = $bdd->query("SELECT id FROM sousmenu ORDER BY id DESC LIMIT 0,1");
						$rq = $rq->fetch();
						echo 'reussit_'.$param[0].'_'.$param[1].'_'.$rq['id'].'_'.$_POST["type"];
					break;
					
					case 'modif_default' ://mis a defaut des produits
						$rq = $bdd->prepare("UPDATE produit SET categorie=? WHERE categorie=?");
						$rq->execute(array($param[3],-1));
						echo 'reussit_'.$param[0].'_'.$param[1].'_'.$param[3].'_'.$_POST["type"];
					break;
					
					case 'modif_produit' ://produit même catégorie
						echo 'reussit_'.$param[0].'_'.$param[1].'_'.$param[3].'_'.$_POST["type"];
					break;
					
					case 'ajouttva' :
						$rq = $bdd->query("SELECT id FROM tva ORDER BY id DESC LIMIT 0,1");
						$rq = $rq->fetch();
						echo 'reussit_'.$param[0].'_'.$param[1].'_'.$rq['id'].'_'.$_POST["type"];
					break;
					
					case 'modiftva_default' ://mis a defaut des produits
						$rq = $bdd->prepare("UPDATE produit SET tva=? WHERE tva=?");
						$rq->execute(array(-1,$param[2]));
						echo 'reussit_'.$param[0].'_'.$param[1].'_'.$param[2].'_'.$_POST["type"];
					break;
					
					case 'modiftva_produit' ://produit même catégorie
						echo 'reussit_'.$param[0].'_'.$param[1].'_'.$param[2].'_'.$_POST["type"];
					break;
					
					case 'suppcateg_default' ://mis a defaut des produits
						$rq = $bdd->prepare("UPDATE produit SET categorie=? WHERE categorie=?");
						$rq->execute(array(-1,$param[0]));
						echo 'reussit_'.$param[0];
					break;
					
					case 'suppcateg_produit' ://supression des produits
						$rq = $bdd->prepare("DELETE FROM produit WHERE categorie=?");
						$rq->execute(array($param[0]));
						echo 'reussit_'.$param[0];
					break;
					
					case 'supptva_default' ://mis a defaut des produits
						$rq = $bdd->prepare("UPDATE produit SET tva=? WHERE tva=?");
						$rq->execute(array(-1,$param[0]));
						echo 'reussit_'.$param[0];
					break;
					
					case 'supptva_produit' ://supression des produits
						$rq = $bdd->prepare("DELETE FROM produit WHERE tva=?");
						$rq->execute(array($param[0]));
						echo 'reussit_'.$param[0];
					break;
				}
				
			}catch(Exception $e){
				echo "Echec Requête ! ".$e->getMessage();
			}
	}
?>