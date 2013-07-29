<?php
	if(isset($_POST['categ']))
	{
		require_once('../../connexionbddplugit.class.php');
		
		try{
			connexionbddplugit::getInstance()->query("INSERT INTO categorie VALUE ('','".$_POST['categ']."','1')");
			echo 'success';
		}catch(Exception $e){
				echo 'Erreur SQL :'.$e->getMessage();
		}
	}
?>