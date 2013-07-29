<?php
if(isset($_SESSION['id']))
{
?>

<script>
	/*function spoil(){
		var div = document.getElementById('conteneur');
		
		if(div.style.display == 'none')
		{
			div.style.display = 'block';
		}
		else
		{
			div.style.display = 'none';
		}
	}*/
	
	function popup()
    {
    window.open('./include/admin/conseil.html','Pop-up','toolbar=0,location=0,directories=0,menuBar=0,resizable=0,scrollbars=yes,width=470,height=430,left=75,top=60');
    }

</script>

<h2>Gestion du référencement</h2>
<br/>
	<p><a href="javascript:popup()" style="margin:auto;" class="boutprod">Conseils</a></p>

<?php

	require_once('./connexionbddplugit.class.php');

	try{
		$rq = connexionbddplugit::getInstance()->query("SELECT * FROM menu ORDER BY position");
		$i=1;
		
		echo '<form action="./traitement/trt_gest_meta.php" method="POST">';
		echo '<table border="0" cellspacing="20" cellpadding="5" style="margin:auto;">';
		while ($donnees = $rq->fetch())
		{
			echo '<tr><td>La description pour <b>'.$donnees['nom'].'</b></td>';
			echo '<td><textarea name="meta'.$i.'" rows="4" cols="60" style="resize:none">'.$donnees['meta'].'</textarea></td></tr>';
			$i++;
		}
		echo '<tr><td><input type="submit" value="Valider"/></td></tr>';
		echo '</table></form>';
	} catch ( Exception $e ) {
		echo "Une erreur est survenue : ".$e->getMessage();
	}
?>
	
<?php
}
else
{
	echo '<h2 style="color:red">Access Forbidden !</h2>';
}
?>
