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
				}
				
			}catch(Exception $e){
				echo "Echec Requête !";
			}
	}
?>