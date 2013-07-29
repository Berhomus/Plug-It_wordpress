<?php

	require_once('./connexionbddplugit.class.php');

	
	if(isset($_POST)&& !empty($_POST))
	{
		$i=1;
		foreach($_POST AS $meta)
		{
			$meta = htmlspecialchars($meta);
			$meta = mysql_real_escape_string($meta);
			try{
				connexionbddplugit::getInstance()->query("UPDATE menu SET meta='$meta' WHERE position='$i'");
			} catch ( Exception $e ) {
				echo "Une erreur est survenue : ".$e->getMessage();
			}
			$i++;
		}
	}
	
	echo '<center><h2>Modification des META</h2>';
	echo '<p style="color:green;">Les modifications ont bien été faite</p>';
	echo '<a href="../index.php?page=admin_gest_menu"><--</a></center>';
	
	
?>