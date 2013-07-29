<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 01/07/2013
Name : reglement.php => Plug-it
*********************************************************-->

<script type="text/javascript" src="js/fct_de_trt_txt.js"></script>
<script type="text/javascript" src="js/ajout_fact.js"></script>

<h2 class="titre">Paiement en ligne</h2>

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
		</table>
		
		<table border="0" cellspacing="20" cellpadding="5" style="margin:auto;" width="930px">	
			<tr>
				<td colspan="6"><hr/></td>
			</tr>
			<tr>
				<td style="text-align:center;" colspan="6"><b>Vos factures</b></td>
			</tr>
			<tr>
				<td colspan="6"><hr/></td>
			</tr>
		</table>
		
		<table border="0" cellspacing="10" cellpadding="5" style="margin:auto;" id="conteneur" width="900px">
				
		</table>

		<table border="0" cellspacing="0" cellpadding="5" style="margin:auto;" width="900px">		
			<tr>
				<td><input style="margin:10px;" type="button" value="+" id="plus" onclick="ajouterElement();"/></td>
			</tr>
			
			<tr>
				<td width="610px"></td>
				<td width="110px" ><label class="lab" for="montanttot" ><b>Montant Total</b></label></td>
				<td width="100px"><input class="lab" style="text-align:right;" type="text" name="montanttot" id="montanttot" value="0.00" readonly /></td>
				<td> €</td>
			</tr>
		</table>
			
		<table border="0" cellspacing="20" cellpadding="5" style="margin:auto;" width="930px">
			<tr>
				<td colspan="6"><hr/></td>
			</tr>
			<tr>
				<td style="text-align:center;" colspan="6"><b>Informations complémentaires</b></td>
			</tr>
			<tr>
				<td colspan="6"><hr/></td>
			</tr>
			
			<tr>
				<td><b>Commentaire </b><br/><small>(facultatif)</small></td>
				<td><label class="lab" for="commentaire"><textarea class="lab" name="commentaire" id="commentaire" rows="10" cols="40" style="resize:none" ></textarea></label></td>
			</tr>
			
			<tr>
				<td colspan="6" style="text-align:right;"><input type="submit" name="envoyer" value="Suivant" style="width:100px; height:30px;"/></td>
			</tr>
		</table>

		
		<input type="hidden" name="nbr_fac" value="0" id="nbr_fac" />
		
	</form>	

<script>

	ajouterElement();
	
</script>
