<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : Contact.php => Plug-it
*********************************************************-->

<script type="text/javascript" src="js/fct_de_trt_txt.js"></script>

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
			
			 if(mail('contact@plug-it.com', $objet,$message))
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

<div style="width:60%;float:left;">

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
					<td><textarea name="message" id="message" rows="15" cols="40" style="resize:none" required></textarea></td>
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

<div style="float:left; margin-left:2%;">
	<h2>Notre agence</h2>
	<br/>
	<p><b>
		Plug-It
		<br/>
		36 bis, rue Saint-Fuscien
		<br/>
		80000 Amiens
	
	</b></p>
	<br/>
	<p>
	Tél. : 03 22 22 10 90
	<br/>
	Fax : 03 22 80 76 52
	<br/>
	<a class="mail" href="mailto:contact@plug-it.com">contact@plug-it.com</a>
	</p>
	<br/>
	
	<!--Carte google API-->
			
	<div id="div_carte"></div>		
			
</div>

</div>