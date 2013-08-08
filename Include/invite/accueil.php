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
			<script type="text/javascript" src="js/raphael-min.js"></script>
			<script type="text/javascript" src="js/jquery.easing.js"></script>
			<script src="js/iview.js"></script>
		
			<script>
				$(document).ready(function(){
					$('#iview').iView({
						pauseTime: 3000,
						directionNav: false,
						controlNav: true,
						tooltipY: -15
					});
				});
			</script>

			<div style="background-color:#f9bd1a; height:556px; width:100%; padding-top:1%;">
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
					d'une demande spécifique auprès de Plug-It.<br/>
					<br/>
				</p>
			</div>
<?php
		break;
		
		default:
			echo '<h1>404 Page Introuvable</h1>';
		break;
	}
?>