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
<div>
	<div style="min-width:1350px;"><a href="index.php?page=accueil"><img src="images/logotype_plug_it(transparence).png" style="float:left; margin:13px 50px 13px 13px;"/></a>
	<ul id="menu">
		<?php
		require_once('./connexionbddplugit.class.php');
		$position=1;
		try
		{
			$rq = connexionbddplugit::getInstance()->query("SELECT * FROM menu ORDER BY position");
				
			while($ar=$rq->fetch())
			{
				if($ar['active'] == true)
				{
					echo '
					<li id="li_'.$ar['id'].'"><a href="'.$ar['lien'].'"';
					echo '>'.$ar['nom'].'</a>';
					
					$sm = connexionbddplugit::getInstance()->query("SELECT * FROM sousmenu WHERE menu='".$ar['id']."' ORDER BY position");
					
					/*sous menu*/
					echo '<ul id="li_sousmenu'.$ar['id'].'">';

					while($sm1=$sm->fetch())
					{
						if($sm1['active'] == true)
						{
							echo '
							<li id="li"><a href="'.$sm1['lien'].'"';
							echo '>'.$sm1['nom'].'</a></li>';
						}
					}
					
					echo '</ul></li>';
				}
			$position++;
			}
		} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
		}
		
		?>
	</ul>
	</div>
</div>

