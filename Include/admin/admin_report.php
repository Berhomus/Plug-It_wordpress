<?php
if(isset($_SESSION['id']))
{	
?>
	<script type="text/javascript" src="js/fct_de_trt_txt.js"></script>
	<script type="text/javascript" src="js/ajout_fact.js"></script>
	
<?php
	echo '<h2 style="margin-bot:10px;">Bug Report</h2>';
	if(isset($_POST) and !empty($_POST))
	{
		require_once('./connexionbddplugit.class.php');
	
		$bdd = connexionbddplugit::getInstance();
		try{
			$rq = $bdd->prepare("INSERT INTO bugreport VALUES (Null,?,?,?,?,Null,0)");
			$rq->execute(array($_POST['titre'],$_POST['sug'],$_POST['bug'],$_POST['ordre']));
			$message = $_POST['bug'].'\n';
			$message .= 'prio: '.$_POST['ordre'].'\n';
			$message .= 'sug: '.$_POST['sug'].'\n';
			$message .= 'date: '. date("d/m/Y");
			if(mail('villain.benoit.dev@gmail.com', "bug site report : ".$_POST['titre'],$message))
				echo '<center>Mail Envoyé !</center>';
			else
				echo '<center>Echec Envoie Mail !</center>';
		}catch(Exception $e){
			echo $e->getMessage();
		}
		echo ('<h2 style="color:green;">Bug Rapporté !</h2>
		<center><a href="index.php?page=admin_report"><-</a></center>');
	}
	else
	{
?>	
	<form method="post" action="#">
	<table border="0" cellspacing="20" cellpadding="5" style="margin:auto;">				
			<tr>
				<td><label for="titre"><b>Nom du Bug<span class="red">*</span></b><br/><small id="lim_nom">(Max 50 caractères)</small></label></td>
				<td><input size="30" type="text" name="titre" id="titre" required onblur="textLimit(this,50, lim_nom);"/></td>
			</tr>

			<tr>
				<td><label for="titre"><b>Suggestion ?</b></td>
				<td><input type="checkbox" name="sug" value="yes"/></td>
			</tr>
			
			<tr>
				<td><label for="ordre"><b>Priorité</b><br/><small>(Bas 1/5 Haut)</small></label></td>
				<td>
					<select name="ordre" id="ordre">
						<?php
							for($i=1;$i<=5;$i++)
							{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}

						?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td><label for="bug" id="bug_label" ><b>Description Bug <span class="red">*</span></b></label></td>
				<td>
					<textarea style="resize:none;" name="bug" required rows="15" cols="50"></textarea> 
				</td>
			</tr>
			
			<tr>
				<td style="text-align:right;"><input type="submit" name="envoyer" value="Envoyer" /></td>
			</tr>		
	</table>
	</form>	
<?php
	}
}
else
{
	echo '<h2>Access Forbidden</h2>';
}
?>