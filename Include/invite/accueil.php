<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : accueil.php => Plug-it
*********************************************************-->
	
<?php
	if(!isset($_GET['sub']))
	{
		$_GET['sub'] = 'main';
	}

	switch($_GET['sub'])
	{
		case 'main':
		
?>
			<div style="background-color:#f9bd1a; height:475px; width:100%; padding-top:1%;">
				<div id="iview">
				<?php
				
					require_once('./connexionbddplugit.class.php');

					
					$img = array('.png', '.gif', '.jpg', '.jpeg','.bmp','.avi','.mp4');
					$video = array('.avi','.mp4');
					
					try{
						$rq=connexionbddplugit::getInstance()->query("SELECT COUNT(id) as nombreslides FROM solutions"); 
						$array = $rq->fetch();
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage;
					}	
					$max= max(10,$array['nombreslides']);
					
					try{
						$rq=connexionbddplugit::getInstance()->query("SELECT * FROM solutions ORDER by date DESC LIMIT ".$max."");
										
						$effet = array('slice-top-fade,slice-right-fade','zigzag-drop-top,zigzag-drop-bottom','strip-right-fade,strip-left-fade','');
						$i=0;
						
						while($array=$rq->fetch())
						{	
							$ext = strtolower(strrchr($array['image_car'], '.')); 
							if(in_array($ext,$video))
								echo '<div data-iview:image="images/slide_08.jpg" data-iview:type="video" data-iview:transition="'.$effet[$i].'">
									<iframe src="http://127.0.0.1/plug-it/include/invite/viewvid.php?vid=../../'.$array['image_car'].'" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
									<div class="iview-caption caption1" data-x="80" data-y="200">'.$array['titre'].'</sup></div>
									<div class="iview-caption" data-x="80" data-y="275" data-transition="wipeRight">'.$array['description'].'</div>
									</div>';
							else
								echo '<div data-iview:image="'.$array['image_car'].'" data-iview:transition="'.$effet[$i].'"></div>';
							
							$i++;
							if($i > 3)
								$i =0;
						}
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage;
					}
				?>
				
						
				</div>
			</div>

			<div style="margin-top:40px; margin-left:auto; margin-right:auto; width:1200px;">
				<table class="table_accueil" border="0" cellspacing="10" cellpadding="10">
					<tr>
						<td>
							<h2>L'écoute, le conseil</h2>
							<hr style="color:#dedede"/>
						</td>
						
						<td>
							<h2>Les solutions dédiées</h2>
							<hr style="color:#dedede"/>
						</td>
						
						<td>
							<h2>Nos services</h2>
							<hr style="color:#dedede"/>
						</td>
					</tr>
					
					<tr>
						<td>
							Depuis 15 ans au service des entreprises,
							notre équipe commerciale est principalement
							issue du milieu technique et rompue aux
							nouvelles technologies de l'informatique.
						</td>
						
						<td>
							Première et unique solution de Cloud Computing locale,
							nos solutions sont différenciées en packs d'abonnement mensuel ou annuel.
						</td>
						
						<td>
						
						<?php
							require_once('./connexionbddplugit.class.php');
							
							connexionbddplugit::getInstance()->query("UPDATE services SET corps = replace(corps, '<br/>', '')");
							$retour = connexionbddplugit::getInstance()->query('SELECT * FROM services ORDER BY ordre');
							echo '<table style="margin-left:auto; margin-right:auto; width:80%;">';
							while ($donnees = $retour->fetch())
							{
								echo'<tr>
									<td><img style="margin-right:10px;" src="images/fleche.png" /><a class="mail" href="index.php?page=services&mode=viewone&id='.$donnees['id'].'">'.$donnees['subtitre'].'</a></td>
								</tr>';
							}
							echo '</table>';
							
						?>
							
						</td>
					</tr>
					
					<tr>
						<td onclick="location.href='index.php?page=accueil&sub=conseil'" style="cursor:pointer;">
							<p class="bouton">Lire la suite</p>
						</td>
							
						<td onclick="location.href='index.php?page=accueil&sub=sol'" style="cursor:pointer;">
							<p class="bouton">Lire la suite</p>
						</td>
						
						<td>
							
						</td>
					</tr>
				</table>
			</div>
<?php
		break;
	
		case 'sol':
?>
			<div style="margin-left:auto; margin-right:auto; width:95%;">	
				<img src="images/solutions_dediees.png" style="float:left;"/>

				<div style="float:left; margin-left:20px;">

					<p style="text-align: justify;">
							
							<h4 style="text-transform:uppercase;"><img src="images/fleche.png"/>
							Première et unique solution de Cloud Computing locale,nos solutions <br/>
							sont différenciées en packs d'abonnement mensuel ou annuel.
							</h4>
							<br/>
							On y trouve en premier lieu notre solution de bureau virtuel sous serveurs Microsoft© Windows 2008 et <br/>
							suites Microsoft© Office Pro 2010 mais aussi des boites aux lettres Microsoft© Exchange avec toutes <br/>
							ses fonctionnalités de partage, du filtrage antispam, de la sauvegarde en ligne,de la Gestion <br/>
							commerciale, des logiciels de comptabilité, etc.
							<br/>
							<br/>
							Le travail coopératif n'est pas en reste avec notre offre Wanashare<br/>
							où nous mettons en œuvre Microsoft© Sharepoint 2010.
					</p>
				</div>
			</div>
			
<?php
		break;
		
		case 'conseil':
?>
			<div style="margin-left:auto; margin-right:auto; width:95%;">	
				<img src="images/ecoute_conseil.png" style="float:left;"/>

				<div style="float:left; margin-left:20px;">

					<p style="text-align: justify;">
							
							<h4 style="text-transform:uppercase;"><img src="images/fleche.png"/>
							Depuis 15 ans au service des entreprises, notre équipe commerciale est <br/>
							principalement issue du milieu technique et rompue aux nouvelles <br/>
							technologies de l'informatique.
							</h4>
							<br/>
							Cette particularité a pour avantage de mieux traduire les besoins exprimés par nos clients et ainsi de <br/>
							naturellement d'effectuer une parfaite transmission des besoins à notre service technique.<br/>
							Nous sommes à même de proposer notre expertise en matière d'audit et de conseils en informatique et <br/>
							d'œvrer en tant que maître d'œuvre.
							<br/>
							<br/>
							De la rédaction de vos cahiers des charges au suivi de la réalisation et à la recette de l'ensemble.
					</p>
				</div>
			</div>
<?php
		break;
		
		case 'mentions':
?>
			<div style="text-align:justify; margin-left:auto; margin-right:auto; width:80%;"> 
				<h4 style="text-transform:uppercase;"><img src="images/fleche.png"/>
				Propriétaire du site Internet
				</h4>
				<br/>
				<p>
					<b>Plug-It</b> - 36 bis, rue Saint-Fuscien - 80000 AMIENS <br/>
					Tél. : 03 22 22 10 90 <br/>
					Fax : 03 22 80 76 52 <br/>
					Courriel : <a class="mail" href="mailto:contact@plug-it.com">contact@plug-it.com</a> <br/>
					SARL au capital de 201 000 € <br/>
					SIRET : 421 617 366 00032 <br/>
					TVA FR46421617366 <br/>
					NAF : 2620Z <br/>
				</p>
				
				<br/>
				<br/>
				<h4 style="text-transform:uppercase;"><img src="images/fleche.png"/>
				Directeur de la publication
				</h4>
				<br/>
				<p>
					<b>Thierry Bochard</b> - Directeur
				</p>
				
				<br/>
				<br/>
				<h4 style="text-transform:uppercase;"><img src="images/fleche.png"/>
				Conception du site Internet
				</h4>
				<br/>
				<p>
					<b>Design</b><br/>
					<b>Rhinocérose</b> - 20, rue Verlaine - 60800 CRÉPY-EN-VALOIS<br/>
					Tél. & fax : 03 44 94 28 40<br/>
					Courriel : <a class="mail" href="mailto:contact@rhinocerose.fr">contact@rhinocerose.fr</a><br/>
					Site internet : <a class="mail" href="http://www.rhinocerose.fr/">www.rhinocerose.fr</a><br/>
					<br/>
					<b>AS Informatique</b> - Antoine Bovin, Benoît Villain, Borhane Bensaid <br/>
					IUT Amiens
				</p>
				
				<br/>
				<br/>
				<h4 style="text-transform:uppercase;"><img src="images/fleche.png"/>
				Hébergeur du site Internet
				</h4>
				<br/>
				<p>
					<b>OVH</b> - 2, rue Kellermann - 59100 ROUBAIX
				</p>
				
				<br/>
				<br/>
				<h4 style="text-transform:uppercase;"><img src="images/fleche.png"/>
				Important
				</h4>
				<br/>
				<p>
					Toutes les informations présentes sur le site (textes, photographies, etc.) sont la propriété exclusive de Plug-It. 
					Toute reproduction, même partielle, doit faire l'objet <br/>
					d'une demande spécifique auprès de Plug-It.
				</p>
			</div>
<?php
		break;
		
		default:
			echo '<h1>404 Page Introuvable</h1>';
		break;
	}
?>