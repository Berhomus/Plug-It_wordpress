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
<script type="text/javascript">		
		function patate(id,position)
		{
			var ssmenu = document.getElementById('li_sousmenu'+id);
			ssmenu.style.marginLeft=40+position*60+window.pageYOffset+"px";
			ssmenu.style.marginTop=40+window.pageXOffset+"px";
			if(ssmenu.style.display != 'block')
			{
				ssmenu.style.display = 'block';
			}
			else
			{
				ssmenu.style.display = 'none';
			}
		}
</script>


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
					<li id="li" onmouseout="patate('.$ar['id'].')" onmouseover="patate('.$ar['id'].','.$position.')"><a href="'.$ar['lien'].'"';
					echo '>'.$ar['nom'].'</a></li>';
					
					$sm = connexionbddplugit::getInstance()->query("SELECT * FROM sousmenu WHERE menu='".$ar['id']."' ORDER BY position");
					
					echo '<ul onmouseout="patate('.$ar['id'].')" onmouseover="patate('.$ar['id'].','.$position.')" id="li_sousmenu'.$ar['id'].'">';
					
					while($sm1=$sm->fetch())
					{
						if($sm1['active'] == true)
						{
							echo '
							<li id="li"><a href="'.$sm1['lien'].'"';
							echo '>'.$sm1['nom'].'</a></li>';
						}
					}
					
					echo '</ul>';
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

