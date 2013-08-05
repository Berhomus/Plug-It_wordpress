<?php
	require_once('../../connexionbddplugit.class.php');
	$bdd =connexionbddplugit::getInstance();
	
	if(isset($_POST["rq"]))
	{
		try{
				$param = array();
				if(isset($_POST['array']) && !empty($_POST['array']))
					$param = preg_split("/,/",$_POST['array']);
				
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
						$rq = $bdd->query("SELECT id FROM categorie ORDER BY id DESC LIMIT 0,1");
						$rq = $rq->fetch();
						echo 'reussit_'.$param[0].'_'.$param[1].'_'.$rq['id'].'_'.$_POST["type"];
					break;
					
					case 'modif' :
						echo 'reussit_'.$param[0].'_'.$param[1].'_'.$param[2].'_'.$_POST["type"];
					break;
					
					case 'ajouttva' :
						$rq = $bdd->query("SELECT id FROM tva ORDER BY id DESC LIMIT 0,1");
						$rq = $rq->fetch();
						echo 'reussit_'.$param[0].'_'.$param[1].'_'.$rq['id'].'_'.$_POST["type"];
					break;
					
					case 'modiftva' :
						echo 'reussit_'.$param[0].'_'.$param[1].'_'.$param[2].'_'.$_POST["type"];
					break;
					
					case 'suppcateg' :
						echo 'reussit_'.$param[0];
					break;
				}
				
			}catch(Exception $e){
				echo "Echec Requête ! ".$e->getMessage();
			}
	}
?>