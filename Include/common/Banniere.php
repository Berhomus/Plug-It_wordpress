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

<script>

function display_menu(id,pos){
	 var menu = document.getElementById("menu_der_"+id);
	 menu.style.display = "block";
	 menu.style.position = "absolute";
	 var w = document.body.clientWidth;
	 var taille = (w-950+window.pageXOffset)/2+(7-pos)*100;
	 menu.style.right=taille+"px";
	 document.getElementById("menu_"+id).className = "menu_unselected_hover";
}

function undisplay_menu(id){
	 var menu = document.getElementById("menu_der_"+id);
	 menu.style.display = "none";
	 document.getElementById("menu_"+id).className = "menu_unselected";
}
</script>

<div>
	<div style="margin-left:auto; width:950px; margin-right:auto"><a style="text-decoration:none;border:none;" href="index.php?page=accueil"><img src="images/logotype_plug_it.png" style="position:absolute; float:left; bottom:25%; "/></a>
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
					echo '<td onclick="location.href=\''.$ar['lien'].'\'"';
					
					$bdd = connexionbddplugit::getInstance();
					$rq2 = $bdd->prepare("SELECT count(id) as nbr FROM sousmenu WHERE menu=?");
					$rq2->execute(array($ar['id']));
				
					$ar2=$rq2->fetch();
					if($ar2['nbr'] > 0)
					{
						echo 'onmouseover="display_menu('.$ar['id'].','.$ar['position'].');" onmouseout="undisplay_menu('.$ar['id'].');"';
					}
					
						if($ar['interne'] and $_GET['page'] == $ar['baseName'])
							echo 'class="menu_selected"';
						else
							echo 'class="menu_unselected"';
					echo ' id="menu_'.$ar['id'].'" >'.$ar['nom'].'</td>';
				}
			}
			
		} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
		}
		
		?>
		</tr>
	</table></div>
</div>

<?php
$rq = connexionbddplugit::getInstance()->query("SELECT * FROM menu ORDER BY position");
				
		while($ar=$rq->fetch())
		{
			$bdd = connexionbddplugit::getInstance();
			$rq2 = $bdd->prepare("SELECT count(id) as nbr FROM sousmenu WHERE menu=?");
			$rq2->execute(array($ar['id']));
					
				$ar2=$rq2->fetch();
				if($ar2['nbr'] > 0)
				{
					$bdd = connexionbddplugit::getInstance();
					$rq2 = $bdd->prepare("SELECT * FROM sousmenu WHERE menu=? ORDER BY position");
					$rq2->execute(array($ar['id']));
					
					echo '<div onmouseover="display_menu('.$ar['id'].','.$ar['position'].')" onmouseout="undisplay_menu('.$ar['id'].')" style="display:none;" id="menu_der_'.$ar['id'].'">
							<ul class="sousmenu">';
					while($ar2=$rq2->fetch())
					{
						echo '<li class="sousmenu_elem" onclick="location.href=\''.$ar2['lien'].'\'">'.$ar2['nom'].'</li>';
					}
					echo '</ul>
					</div>';
				}
		}

?>

