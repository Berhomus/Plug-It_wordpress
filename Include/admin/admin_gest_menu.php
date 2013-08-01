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

<h2 class="grdtitre">Gestion du référencement</h2>
<br/>
<div style="margin-bottom:20px;width:990px; border:4px solid;border-radius:15px; border-color:#DCDCDC #696969 #696969 #DCDCDC;">
	<p><a href="javascript:popup()" style="margin:auto;" class="menuverti">Conseils</a></p>

<?php

	require_once('./connexionbddplugit.class.php');

	try{
		$rq = connexionbddplugit::getInstance()->query("SELECT * FROM menu ORDER BY position");
		$i=1;
		
		echo '<form action="./traitement/trt_gest_meta.php" method="POST">';
		echo '<table border="0" cellspacing="20" cellpadding="5" style="margin:auto;">';
		while ($donnees = $rq->fetch())
		{
			echo '<tr><td style="display:block;
							width:200px;
							background-color:#333333;
							color:white;
							text-decoration:none;
							text-align:center;
							padding:5px;
							border:2px solid;
							border-color:#DCDCDC #696969 #696969 #DCDCDC;
							list-style: none;
							background: #111;
							background: -moz-linear-gradient(#444, #111);
							background: -webkit-gradient(linear,left bottom,left top,color-stop(0, #111),color-stop(1, #444));
							background: -webkit-linear-gradient(#444, #111);
							background: -o-linear-gradient(#444, #111);
							background: -ms-linear-gradient(#444, #111);
							background: linear-gradient(#444, #111);
							-moz-border-radius: 50px;
							-moz-box-shadow: 0 2px 1px #9c9c9c;
							-webkit-box-shadow: 0 2px 1px #9c9c9c;
	box-shadow: 0 2px 1px #9c9c9c;">La description pour <b>'.$donnees['nom'].'</b></td>';
			echo '<td><textarea name="meta'.$i.'" rows="4" cols="60" style="resize:none">'.$donnees['meta'].'</textarea></td></tr>';
			$i++;
		}
		echo '<tr><td><input type="submit" value="Valider"/></td></tr>';
		echo '</table></form>';
	} catch ( Exception $e ) {
		echo "Une erreur est survenue : ".$e->getMessage();
	}
?>
</div>	
<?php
}
else
{
	echo '<h2 style="color:red">Access Forbidden !</h2>';
}
?>
