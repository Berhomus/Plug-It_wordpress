<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : Banniere.php => Plug-it
*********************************************************-->

<?php
	if(!isset($_GET['page']))
		$_GET['page'] = 'accueil';
		
	header( 'content-type: text/html; charset=utf-8' );

?>


<div style="overflow:hidden;">
	<div style="margin-left:auto; width:950px; margin-right:auto"><a href="index.php?page=accueil"><img src="images/logotype_plug_it.png" style="position:absolute; float:left; bottom:25%; "/></a>
	<table style="position:relative; float:right; margin-left:10px;" height="137px" class="menu" cellspacing="0">
		<tr>
		<?php
		require_once('./connexionbddplugit.class.php');

		try
		{
			$rq = connexionbddplugit::getInstance()->query("SELECT * FROM menu ORDER BY position");
				
			while($ar=$rq->fetch())
			{
				if($ar['active'] == true)
				{
					if($ar['baseName'] == 'boutique')
					{
						$class='menuder';
					}
					else
					{
						$class='';
					}
					echo '
					<td class="'.$class.'"onclick="location.href=\''.$ar['lien'].'\'"';
						if($ar['interne'] and $_GET['page'] == $ar['baseName'])
							echo 'class="menu_selected"';
						else
							echo 'class="menu_unselected"';
					echo '>'.$ar['nom'].'</td>';
					if($ar['baseName'] == 'boutique')
					{
						
					}
				}
			}
		} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
		}
		
		?>
		</tr>
	</table></div>
</div>

