<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : Contact.php => Plug-it
*********************************************************-->
<?php
	require_once('./connexionbddplugit.class.php');
	$bdd=connexionbddplugit::getInstance();	
?>

<script type="text/javascript" src="js/fct_de_trt_txt.js"></script>

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

<?php
	$rq2 = $bdd->prepare("SELECT COUNT(id) AS nbre FROM contact");
	$rq2->execute(array());
	
	$ar2 = $rq2->fetch();
	
	$rq = $bdd->prepare("SELECT * FROM contact");
	$rq->execute(array());
		
	$i=1;	
	while($ar = $rq->fetch())
	{
?>
		<div id="tabs">
			<ul>
			<li><a href="#tabs-<?phpecho $i;?>"><?phpecho $ar['ville'];?></a></li>
			</ul>
			<div id="tabs-<?phpecho $i;?>">
				<input type="hidden" id="lat" name="lat" value="<?phpecho $ar['latitude'];?>"/>
				<input type="hidden" id="longi" name="longi" value="<?phpecho $ar['longitude'];?>"/>
				<?php

				$error_contact = 0;
				if(isset($_POST) && !empty($_POST))
				{
					if(preg_match("`[a-zA-Z1-9.-_]*@[a-zA-Z]*.[a-zA-Z]*`",$_POST['courriel']))
					{
						$message = "";
						$societe = (isset($_POST['societe'])) ? $_POST['societe']:"";
						$objet = (isset($_POST['objet'])) ? $_POST['objet']:"";
						
						$message = $_POST['liste'] ." ". $_POST['nom'] ." ". $_POST['prenom'] ."\n".$societe."-".$_POST['courriel']."\n".$_POST['message'];
						
						 if(mail($ar['courriel'], $objet,$message))
						 {
							$error_contact = 2;
						 }
						 else
						 {
							$error_contact = 3;
						 }
					
						$error_contact = 2;
					}
					else
						$error_contact = 1;
				}
				?>

				<div style="overflow:hidden;">

					<div style="width:62%;float:left;">

						<h2 class="titre">Contactez-nous</h2>

						<form method="post" action="#">
							<table border="0" cellspacing="20" cellpadding="5" style="margin:auto; margin-right:150px;">
								<tr>
									<td><b>Civilité <span class="red">*</span></b></td>
									<td><select name="liste" required>
										<option></option>
										<option value="M">M.</option>
										<option value="Mme">Mme</option>
										</select>
									</td>
								</tr>
								
								<tr>
									<td><label for="nom"><b>Nom <span class="red">*</span></b></label></td>
									<td><input type="text" name="nom" id="nom" required/></td>
								</tr>
								
								<tr>
									<td><label for="prenom"><b>Prénom <span class="red">*</span></b></label></td>
									<td><input type="text" name="prenom" id="prenom" required/></td>
								</tr>
								
								<tr>
									<td><label for="societe"><b>Société </b></label></td>
									<td><input type="text" name="societe" id="societe" /></td>
								</tr>
								
								<tr>
									<td><label for="courriel" id="email"><b>Courriel <span class="red">*</span></b></label></td>
									<td><input type="text" name="courriel" id="courriel" onblur="isEmail(this,email);" required/></td>
								</tr>
								
								<tr>	
									<td><label for="objet"><b>Objet </b></label></td>
									<td><input type="text" name="objet" id="objet" /></td>
								</tr>
								
								<tr>
									<td><label for="message"><b>Message <span class="red">*</span></b></label></td>
									<td><textarea name="message" id="message" rows="15" cols="40" style="resize:none;" required></textarea></td>
								</tr>
								
								<tr>
									<td>
									<?php
										if($error_contact != 0)
										{
											switch($error_contact)
											{
												case 1:
													echo '<h2 style="color:red;">Email invalide !</h2>';
												break;
												case 2:
													echo '<h2 style="color:green;">Message Envoyé !</h2>';
												break;
												case 3:
													echo '<h2 style="color:red;">Message Non-Envoyé !</h2>';
												break;
											}	
										}
									?>
									</td>
									<td style="text-align:right;"><input type="submit" name="envoyer" value="Envoyer" /></td>
								</tr>		
							</table>
						</form>	
					</div>

					<div style="float:left;">
					<hr class="separation" />
					</div>

					<?php
					echo '<div style="float:left; margin-left:2%;">
						<h2>Notre agence</h2>
						<br/>';
							echo nl2br($ar['coordonnees']);	
						echo '<br/>
						<a class="mail" href="mailto:'.$ar['courriel'].'">'.$ar['courriel'].'</a>
						<br/><br/>';
						
						/*Carte google API*/
								
						echo '<div id="div_carte"></div>	
								
					</div>';
					?>

				</div>
			
			</div>
		<?php
		$i++;
		?>
		</div>
	<?php
	}
	?>
<script type="text/javascript">
	var lat = document.getElementById('lat').value;
	var longi = document.getElementById('longi').value;
	
	var pos = new google.maps.LatLng(lat, longi);
	function initCarte()
	{
		// création de la carte
		var oMap = new google.maps.Map( document.getElementById( 'div_carte'),
		{
		'center' : pos,
		'zoom' : 17,
		'mapTypeId' : google.maps.MapTypeId.ROADMAP
		});
		
		var myMarker = new google.maps.Marker({
			// Coordonnées du site
			position: pos,
			map: oMap,
			title: "Plug-it"
		});
		
		var myWindowOptions = {
			content:
			'<h6>Plug-it</h6>'
		};
		var myInfoWindow = new google.maps.InfoWindow(myWindowOptions);
	}
	// init lorsque la page est chargée
	google.maps.event.addDomListener( window, 'load', initCarte);
		
	/*####ONGLETS####*/
	
	 $(function() {
		$( "#tabs" ).tabs();
	});
	
</script>