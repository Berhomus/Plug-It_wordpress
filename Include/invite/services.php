<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : services.php => Plug-it
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
			echo'<div style="margin:auto;width:980px;">
				<h2>DéCOUVREZ L\'ENSEMBLE DE NOS SERVICES INFORMATIQUES LES PLUS POINTUS</h2>';
				
					if(isset($_SESSION['id']))
					{
						echo '<br/><div style="margin:auto;" class="menuverti" onclick="location.href=\'index.php?page=admin_services\'">Ajouter un service</div>';
					}
					
					try{
						$retour = connexionbddplugit::getInstance()->query('SELECT * FROM services ORDER BY ordre');
						$i=1; //délimite les colonnes
						$j=1; //délimite les lignes
						
						echo '<table cellspacing="20">';
						while ($donnees = $retour->fetch())
							{
							
								if($i == 1)
									echo '<tr>';
								
								echo '<td>
								<div class="blockservice" onclick="location.href=\'index.php?page=services&mode=viewone&id='.$donnees['id'].'\'">';
								
								if(isset($_SESSION['id']))
								{
									echo'
									<span style="margin-left:10%;"><a class="bt" href="index.php?page=admin_services&mode=modifier&id='.$donnees['id'].'">Modifier</a> - 
									<a class="bt" href="traitement/trt_services.php?mode=delete&id='.$donnees['id'].'">Supprimer</a></span>';
								}
									
									
								echo'	
									<img src="'.$donnees['image'].'"  width="280" height="157" style="margin-left:5%;width:90%;"/><br/>
									<h3 style="font-size:18px;">'.$donnees['titre'].'</h3>
									
								</div></td>';
								
								$i++;
								if($i > 3)
								{
									$i=1;
									$j++;
									echo '</tr>';
								}
							}
						echo '</table>';
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}
				echo '</div>';
		break;
			
		case 'viewone':
			if(isset($_GET['id']))//verif existence id
			{
				try{
					$bdd = connexionbddplugit::getInstance();
					$retour = $bdd->prepare("SELECT count(id) as cpt FROM services WHERE id=?");
					$retour->execute(array($_GET['id']));
					$donnees = $retour->fetch();
				} catch ( Exception $e ) {
					echo "Une erreur est survenue : ".$e->getMessage();
				}
				
				if($donnees['cpt'] == 1)
				{
					//affichage 
					try{
						$bdd = connexionbddplugit::getInstance();
						$retour = $bdd->prepare("SELECT * FROM services WHERE id=?"); 
						$retour->execute(array($_GET['id']));
						$donnees = $retour->fetch();
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}
					
					echo '<div style="margin:auto;width:70%;">
						<table>
							<tr>
								<td><img src="'.$donnees['image'].'" style="width:60%;"/></td>
								<td><h2>'.$donnees['titre'].'</h2></td>
							</tr>
						</table>
						<hr/>
						<br/>
						'.nl2br($donnees['corps']).'
						</div>';
						
					
					//affichage autres liens					
					try{
						$bdd = connexionbddplugit::getInstance();
						$retour = $bdd->prepare("SELECT * FROM services WHERE id<>? ORDER BY ordre LIMIT 10");
						$retour->execute(array($_GET['id']));
					
						$i=1; //délimite les colonnes
						$j=1; //délimite les lignes
						
						echo'<div style="margin:auto;width:70%;margin-top:20px;">
						<table cellspacing="10">';
						while ($donnees = $retour->fetch())
							{
							
								if($i == 1)
									echo '<tr>';
								
								echo '<td>
								<div class="blocklink" onclick="location.href=\'index.php?page=services&mode=viewone&id='.$donnees['id'].'\'">
									<p style="text-align:center;position:relative;top:30%;">
										<img src="images/fleche.png" style="vertical-align:middle;"/> <span style="font-size:13px;font-weight:bold;margin-left:5px;text-transform:uppercase;">'.$donnees['subtitre'].'</span>
									</p>
								</div></td>';
								
								$i++;
								if($i > 4)
								{
									$i=1;
									$j++;
									echo '</tr>';
								}
							}
						echo '</table></div>';
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}
				}
				else
					echo '<p>Erreur</p>';
			}
			else
				echo '<p>Erreur</p>';
		break;
			
		default:
		break;
	}
	
	
