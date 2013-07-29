
<h2>Paiement en Ligne</h2>
<script type="text/javascript" src="js/fct_de_trt_txt.js"></script>

<?php
if(isset($_POST) and !empty($_POST))//si info client déjà connu => facture
{
	if((!isset($_POST['type_paiement'])) or ((isset($_SESSION['caddieTot'])) and $_SESSION['caddieTot'] > 0))//si pas boutique ou alors panier non vide
	{
		$_POST['societe'] = (!empty($_POST['societe'])) ? $_POST['societe']:"/";
		$_POST['commentaire'] = (!empty($_POST['commentaire'])) ? $_POST['commentaire']:"/";
		
	?>		
		<h2 class="titre">Récapitulatif</h2>
		<table border="0" cellspacing="20" cellpadding="5" style="margin:auto;">
			<tr>	
				<td><b>Nom du client</b></td>
				<td><?php echo $_POST['nom']; ?></td>
			</tr>
			<tr>	
				<td><b>Société</b></td>
				<td><?php echo $_POST['societe']; ?></td>
			</tr>
			<tr>	
				<td><b>Courriel</b></td>
				<td><?php echo $_POST['courriel']; ?></td>
			</tr>
			
			
			<?php
				$commande = '';
				if(isset($_POST['type_paiement']))
				{
					echo '<tr>	
							<td><b>Reférence</b></td>
							<td><b>Non</b></td>
							<td><b>Quantité</b></td>
							<td><b>Prix Unitaire</b></td>
						</tr>';
					foreach($_SESSION['caddie'] as $article)
					{
						echo '
						<tr>	
							<td>'.$article['id'].'</td>
							<td>'.$article['nom'].'</td>
							<td>x'.$article['qte'].'</td>
							<td>'.$article['prix'].'€</td>
						</tr>
						';
						$commande .= $article['id'].' : '.$article['nom'].' x.'.$article['qte'].' => '.$article['prix'].'€
';
					}
				}
				else
				{
					echo '<tr>	
							<td><b>N°Facture</b></td>
							<td><b>Date</b></td>
							<td><b>Montant</b></td>
						</tr>';
						
					for($i=1;$i<=$_POST['nbr_fac'];$i++)
					{
						echo '
							<tr>	
								<td>'.$_POST['num'.$i].'</td>
								<td>'.$_POST['date'.$i].'</td>
								<td>'.$_POST['montant'.$i].'€</td>
							</tr>
						';
						$commande .= $_POST['num'.$i].' : '.$_POST['date'.$i].' => '.$_POST['montant'.$i].'€
';
					}
				}
			?>
			<tr>
				<td><b>Montant Total</b></td>
				<td></td>
				<td><?php echo (isset($_POST['type_paiement'])) ? $_SESSION['caddieTot']:$_POST['montanttot']; ?>€</td>
			</tr>
			
			<tr>	
				<td><b>Commentaire</b></td>
				<td><?php echo $_POST['commentaire']; ?></td>
			</tr>
				
		</table>
	
<?php
		$total = (isset($_POST['type_paiement'])) ? $_SESSION['caddieTot']:str_replace('.',"",$_POST['montanttot']);
		include("include/webaffaires/call_request.php");
	}
	else
	{
		echo '<p>Panier vide</p>';
	}
}
else // sinon il les remplis => boutique
{
?>
	<form method="post" action="index.php?page=paiement_final">
		<table border="0" cellspacing="20" cellpadding="5" style="margin:auto;" width="930px">
				<tr>
					<td colspan="6"><hr/></td>
				</tr>
				<tr>
					<td style="text-align:center;" colspan="6"><b>Vos coordonnées</b></td>
				</tr>
				<tr>
					<td colspan="6"><hr/></td>
				</tr>

				<tr>
					<td width="150px"><label class="lab" for="nom"><b>Nom du client <span class="red">* </span></b><br/><small id="lim_nom">(Max 50 caractères)</small></label></td>
					<td><input class="lab" style="text-align:right;"type="text" name="nom" id="nom" onblur="textLimit(this,50, lim_nom);" required/></td>
				</tr>
				
				<tr>
					<td><label class="lab" for="societe"><b>Société </b><br/><small id="lim_soc">(Max 50 caractères)</small></label></td>
					<td><input class="lab" style="text-align:right;" type="text" name="societe" id="societe" onblur="textLimit(this,50, lim_soc);" /></td>
				</tr>
				<tr>
					<td><label class="lab" for="courriel" id="email"><b>Courriel <span class="red">* </span></b></label>
					<td><input class="lab" style="text-align:right;" type="text" name="courriel" id="courriel" onblur="isEmail(this,email);" required/>
				</tr>
				<tr>
					<td><b>Commentaire </b><br/><small>(facultatif)</small></td>
					<td><label class="lab" for="commentaire"><textarea class="lab" name="commentaire" id="commentaire" rows="10" cols="40" style="resize:none" ></textarea></label></td>
				</tr>
				<tr>
					<td><input type="submit" name="envoyer" value="Suivant" style="width:100px; height:30px;"/></td>
					<input type="hidden" name="type_paiement" value="boutique"/>
				<tr>
		</table>
	</form>	
<?php
}
?>	