
<h2>Paiement en Ligne</h2>
<script type="text/javascript" src="js/fct_de_trt_txt.js"></script>
<script>
	function isTel(field,id)
	{
		var regTel = new RegExp("^0[1-9]([-. ]?[0-9]{2}){4}$");

		if(regTel.test(tel.value))
		{
		id.style.color='green';
		}
		else
		{
		id.style.color='red';
		tel.value='';
		alert('Téléphone Invalide');
		}
	}
</script>

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
			
			<tr>	
				<td><b>Adresse Facturation</b></td>
				<td><?php echo $_POST['adressefacturation']; ?></td>
			</tr>
			
			<tr>	
				<td><b>Code Postal Facturation</b></td>
				<td><?php echo $_POST['codepostalfacturation']; ?></td>
			</tr>
			
			<tr>	
				<td><b>Adresse de Livraison</b></td>
				<td><?php echo $_POST['adresselivraison']; ?></td>
			</tr>
			
			<tr>	
				<td><b>Code Postal de Livraison</b></td>
				<td><?php echo $_POST['codepostallivraison']; ?></td>
			</tr>
			
			<tr>	
				<td><b>N° de Téléphone</b></td>
				<td><?php echo $_POST['telephone']; ?></td>
			</tr>
			
			
			<?php
				$commande = '';
				if(isset($_POST['type_paiement']))
				{
					echo '<tr>	
							<td><b>Reférence</b></td>
							<td><b>Nom</b></td>
							<td><b>Quantité</b></td>
							<td><b>Prix Unitaire TTC</b></td>
							<td><b>Prix Total</b></td>
						</tr>';
					foreach($_SESSION['caddie'] as $article)
					{
						echo '
						<tr>	
							<td>'.$article['id'].'</td>
							<td>'.$article['nom'].'</td>
							<td>x'.$article['qte'].'</td>
							<td>'.round($article['prix']*100)/100 .'€</td>
							<td>'.(round($article['prix']*100)/100)*$article['qte'].'€</td>
						</tr>';
						$commande .= $article['id'].' : '.$article['nom'].' x.'.$article['qte'].' => '.$article['prix'].'€';
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
				
				$_POST['montanttot'] = round(((isset($_POST['type_paiement'])) ? $_SESSION['caddieTot']:$_POST['montanttot'])*100)/100;
			?>
			<tr>
				<td colspan="3"><b>Montant Total</b></td>
				<td></td>
				<td><?php echo $_POST['montanttot']  ?>€</td>
			</tr>
			
			<tr>	
				<td><b>Commentaire</b></td>
				<td><?php echo $_POST['commentaire']; ?></td>
			</tr>
				
		</table>
	
<?php
		$total = (isset($_POST['type_paiement'])) ? round($_SESSION['caddieTot']*100):str_replace('.',"",$_POST['montanttot']);
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
					<td><label class="lab" for="adressefact" id="email"><b>Adresse Facturation <span class="red">* </span></b><br/><small>(N° - Voie - Code Postal - Ville)</small></label></td>
					<td><input class="lab" style="text-align:right;" size="40" type="text" name="adressefact" id="adressefact" required/></td>
				</tr>
				
				<tr>	
					<td><label class="lab" for="adresselivr" id="email"><b>Adresse de Livraison <span class="red">* </span></b><br/><small>Uniquement en France Métropolitaine</small></label></td>
					<td><input class="lab" style="text-align:right;" size="40" type="text" name="adresselivr" id="adresselivr" required/></td>
				</tr>
				
				<tr>	
					<td><label class="lab" for="tel" id="email"><b id="numtel">N° de Téléphone <span class="red">* </span></b></label></td>
					<td><input class="lab" style="text-align:right;" type="text" name="tel" id="tel" onblur="isTel(this,numtel);" required/></td>
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