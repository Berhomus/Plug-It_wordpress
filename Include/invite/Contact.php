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
<link rel="stylesheet" href="./styles/contact.css" />

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

<?php
	$rq2 = $bdd->prepare("SELECT COUNT(id) AS nbre FROM contact");
	$rq2->execute(array());

	$ar2 = $rq2->fetch();

	$rq = $bdd->prepare("SELECT * FROM contact");
	$rq->execute(array());


	$error_contact = 0;
	if(isset($_POST) && !empty($_POST))
	{
		if(preg_match("`[a-zA-Z1-9.-_]*@[a-zA-Z]*.[a-zA-Z]*`",$_POST['courriel']))
		{
			$message = "";
			$societe = (isset($_POST['societe'])) ? $_POST['societe']:"";
			$objet = (isset($_POST['objet'])) ? $_POST['objet']:"";

			$message = $_POST['liste'] ." ". $_POST['nom'] ." ". $_POST['prenom'] ."\n".$societe."-".$_POST['courriel']."\n".$_POST['message'];

			if(mail($_POST['courriel'], $objet,$message))
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

	echo '<div id="tabs">
	<ul>'; 

	$i=0;	
	while($ar = $rq->fetch())
	{
		echo '<li><a href="#tabs-'.$i.'">'.$ar['ville'].'</a></li>';
		$i++;
	}
	echo '</ul>';
	$i=0;

	$rq = $bdd->prepare("SELECT * FROM contact");
	$rq->execute(array());
	
	while($ar = $rq->fetch())
	{
		echo '
			<div id="tabs-'.$i.'">
			<input type="hidden" id="mail" name="mail" value="'.$ar['courriel'].'"/>
			<input type="hidden" id="lat_'.$i.'" name="lat" value="'.$ar['latitude'].'"/>
			<input type="hidden" id="longi_'.$i.'" name="longi" value="'.$ar['longitude'].'"/>';

?>

<div style="overflow:hidden;">

	<div style="float:left;">
		<?php
		if(isset($_SESSION['id']))
		{
			echo'
			<span style="margin-left:40px;"><a class="bt" href="'.$_SESSION['protocol'].$_SESSION['current_loc'].'index.php?page=admin_contact&mode=modifier&id='.$ar['id'].'">Modifier</a> - 
			<a class="bt" href="'.$_SESSION['protocol'].$_SESSION['current_loc'].'traitement/trt_contact.php?mode=delete&id='.$ar['id'].'">Supprimer</a></span>';
		}
		?>
		<div style="float:left;">

		<h2 class="titre">Contactez-nous</h2>

		<form method="post" action="#">
			<table border="0" cellspacing="20" cellpadding="5" style="margin:auto; margin-right:150px;">
				<tr style="height:40px;">
					<td><b>Civilité <span class="red">*</span></b></td>
					<td><select name="liste" required>
							<option></option>
							<option value="M">M.</option>
							<option value="Mme">Mme</option>
						</select>
					</td>
				</tr>

				<tr style="height:40px;">
					<td><label for="nom"><b>Nom <span class="red">*</span></b></label></td>
					<td><input type="text" name="nom" id="nom" required/></td>
				</tr>

				<tr style="height:40px;">
					<td><label for="prenom"><b>Prénom <span class="red">*</span></b></label></td>
					<td><input type="text" name="prenom" id="prenom" required/></td>
				</tr>

				<tr style="height:40px;">
					<td><label for="societe"><b>Société </b></label></td>
					<td><input type="text" name="societe" id="societe" /></td>
				</tr>

				<tr style="height:40px;">
					<td><label for="courriel" id="email"><b>Courriel <span class="red">*</span></b></label></td>
					<td><input type="text" name="courriel" id="courriel" onblur="isEmail(this,email);" required/></td>
				</tr>

				<tr style="height:40px;">	
					<td><label for="objet"><b>Objet </b></label></td>
					<td><input type="text" name="objet" id="objet" /></td>
				</tr>

				<tr>
					<td><label for="message"><b>Message <span class="red">*</span></b></label></td>
					<td><textarea name="message" id="message" rows="15" cols="40" style="resize:none;" required></textarea></td>
				</tr>

				<tr style="height:40px;">
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
			<hr class="separation"/>
		</div>
		<?php
			echo '<div style="float:left; margin-top:40px; margin-left:40px">
				<h2>Notre agence</h2>
				<br/>';
			echo nl2br($ar['coordonnees']);  
			echo '<br/>
				<a class="mail" href="mailto:'.$ar['courriel'].'">'.$ar['courriel'].'</a>
				<br/><br/>';

			/*Carte google API*/

			// echo '<div id="div_carte'.$i.'"></div>';
			
			echo '<iframe width="300" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.fr/maps?f=q&amp;source=s_q&amp;hl=fr&amp;geocode=&amp;q=12+bis+rue+raymond+joly+levignen&amp;aq=&amp;sll='.$ar['latitude'].','.$ar['longitude'].'&amp;t=m&amp;ie=UTF8&amp;hq=&amp;&amp;z=17&amp;output=embed"></iframe><br /><small><a href="https://maps.google.fr/maps?f=q&amp;source=embed&amp;hl=fr&amp;geocode=&amp;q=12+bis+rue+raymond+joly+levignen&amp;aq=&amp;sll=49.968972,2.291351&amp;sspn=0.860327,2.688904&amp;t=h&amp;ie=UTF8&amp;hq=&amp;hnear=12+Rue+Raymond+Joly,+60800+L%C3%A9vignen,+Oise,+Picardie&amp;z=14&amp;ll=49.195012,2.912469" style="color:#0000FF;text-align:left">Agrandir le plan</a></small>';
			
			echo '</div>';
		?>
	</div>
	
	<?php
	echo '</div></div>';
	$i++;
	}
	
	echo '<input type="hidden" value="'.($i-1).'" id="nbr_ville"/>';
	?>
</div>
<div style="padding-bottom:40px;">
</div>

<script type="text/javascript">
	
	/*####ONGLETS####*/
	$(function() {
	$( "#tabs" ).tabs();
	});
</script>