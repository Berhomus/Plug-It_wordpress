<?php
	require_once('../../connexionbddplugit.class.php');
	
	
	if(isset($_POST["rq"]))
	{
		try{
				$rq = connexionbddplugit::getInstance()->query($_POST["rq"]);
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