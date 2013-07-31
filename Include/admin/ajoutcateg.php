<?php
	if(isset($_POST['categ']))
	{
		require_once('../../connexionbddplugit.class.php');
		
		try{
			$bdd = connexionbddplugit::getInstance();
			$rq = $bdd->prepare("INSERT INTO categorie VALUE ('',?,'1')");
			$rq->execute(array($_POST['categ']));
			echo 'success';
		}catch(Exception $e){
				echo 'Erreur SQL :'.$e->getMessage();
		}
	}
?>