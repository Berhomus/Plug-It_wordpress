<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : references.php => Plug-it
*********************************************************-->

<?php
	if(!isset($_GET['mode']))
	{
		$_GET['mode'] = 'view';
	}

	require_once('./connexionbddplugit.class.php');

	
	switch($_GET['mode'])
	{
	
		case 'view':
			echo'<div style="margin:auto;width:900px;">
				<h2>Ils nous font confiance</h2>';
				
				try{
					$retour = connexionbddplugit::getInstance()->query("SELECT * FROM ref ORDER BY ordre");
				
					if(isset($_SESSION['id']))
					{
						echo '<br/><div style="margin:auto;" class="menuverti" onclick="location.href=\'index.php?page=admin_ref\'">Ajouter une r&eacutef&eacuterence</div>';
					}
					
						$i=1; //délimite les colonnes
						$j=1; //délimite les lignes
						
						echo '<table cellspacing="20" callpadding="0">';
						while ($donnees = $retour->fetch())
							{
							
								if($i == 1)
									echo '<tr>';
								
								echo '<td>
								<div class="blockref">';
								
								if(isset($_SESSION['id']))
								{
									echo'
									<span style="margin-left:10%;"><a class="bt" href="index.php?page=admin_ref&id='.$donnees['id'].'">Modifier</a> - 
									<a class="bt" href="traitement/trt_ref.php?mode=delete&id='.$donnees['id'].'">Supprimer</a></span>';
								}
								
								echo'	
									<a href="'.$donnees['lien'].'" ><img src="'.$donnees['image'].'" style="width:100%;" width="220" height="161"/></a><br/>
									<h4>'.$donnees['titre'].'</h4>
									'.$donnees['sous_titre'].'
								</div></td>';
								
								$i++;
								if($i > 4)
								{
									$i=1;
									$j++;
									echo '</tr>';
								}
							}
						echo '</table>
					</div>';
				} catch ( Exception $e ) {
					echo "Une erreur est survenue : ".$e->getMessage();
				}	
		break;
			
		default:
		break;
	}
	
	
