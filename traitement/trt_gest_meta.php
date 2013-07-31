<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php

	require_once('../connexionbddplugit.class.php');

	$bdd = connexionbddplugit::getInstance();
	
	if(isset($_POST)&& !empty($_POST))
	{
		$i=1;
		foreach($_POST AS $meta)
		{
			
			try{
				$rq = $bdd->prepare("UPDATE menu SET meta=? WHERE position=?");
				$rq->execute(array($meta,$i));
			} catch ( Exception $e ) {
				echo "Une erreur est survenue : ".$e->getMessage()."<br/>";
			}
			$i++;
		}
	}
	
	echo '<center><h2>Modification des META</h2>';
	echo '<p style="color:green;">Les modifications ont bien été faite</p>';
	echo '<a href="../index.php?page=admin_gest_menu"><--</a></center>';
	
	
?>