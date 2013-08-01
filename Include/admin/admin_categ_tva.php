<script type="text/javascript" src="js/fct_de_trt_txt.js"></script>
<script type="text/javascript" src="js/ajout_fact.js"></script>

<script>
	function getXMLHttpRequest() {
		var xhr = null;
		 
		if (window.XMLHttpRequest || window.ActiveXObject) {
			if (window.ActiveXObject) {
				try {
					xhr = new ActiveXObject("Msxml2.XMLHTTP");
				} catch(e) {
					xhr = new ActiveXObject("Microsoft.XMLHTTP");
				}
			} else {
				xhr = new XMLHttpRequest();
			}
		} else {
			alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
			return null;
		}
		 
		return xhr;
	}

	function addCategorie(field){
		xhr = getXMLHttpRequest();
		
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				var success;
				if(xhr.responseText == 'success')
				{
					var option = document.createElement('option');
					option.setAttribute("value",document.getElementById("new_categorie").value);
					option.setAttribute("selected","");
					option.innerHTML=document.getElementById("new_categorie").value;
					document.getElementById("categorie").appendChild(option);
					document.getElementById("new_categorie").value = "";
					success = '<small style="color:green;">Ajout Réussi !</small>';
				}
				else
				{
					success = '<small style="color:red;">Ajout Echoué !</small>';
				}
				document.getElementById("new_categ_td").innerHTML = '<label for="new_categorie"><b>Nouvelle Catégorie <span class="red">*</span></b><br/><small id="lim_new_categorie">(Max 50 caractères)</small><br/>'+success+'</label>';
			}
		};
		
		var categ = field.value;
		xhr.open("POST", "include/admin/ajoutcateg.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("categ="+categ);
	}
	
	function selection(field,nom){
		
	}
</script>

<?php
if(isset($_SESSION['id']))
{

?>
<h2 class="grdtitre">Gestion des Catégories de la Boutique et des taux de TVA</h2>
<?php

require_once('./connexionbddplugit.class.php');

	$bdd = connexionbddplugit::getInstance();
	
	$rq = $bdd->prepare("SELECT valeur FROM tva WHERE id='1'");
	$rq->execute();
	$ar = $rq->fetch();
	$tva = $ar['valeur'];
	
	$require="";

?>
<!--Catégorie-->
<div style="margin-top:5px;width:491px; height:250px; border:4px solid;border-radius:15px; border-color:#DCDCDC #696969 #696969 #DCDCDC; float:left;">
	<form method="post" enctype="multipart/form-data" action="#">
		<table border="0" cellspacing="20" cellpadding="5" style="margin:auto; margin-top:20px;">				
		
				<tr>
					<td><label for="categorie"><b>Catégorie du produit </b><br/></label></td>
					<td>
						<select name="categorie" id="categorie">
							<option value="ajout_categ">Ajouter une catégorie</option>
								<?php
									$rq = connexionbddplugit::getInstance()->query("SELECT nom FROM categorie");
									$selected ="";
									while($ar = $rq->fetch())
									{
										echo '<option value="'.$ar['nom'].'" '.$selected.'>'.$ar['nom'].'</option>';
									}

								?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td><label for="categ"><b>Nom de la catégorie</b><br/><small id="lim_desc">(Max 50 caractères)</small></label></td>
					<td><input size="22" type="text" name="categ" id="categ" value="<?php echo $ar['nom']; ?>" <?php echo $require; ?> onblur="textLimit(this, 50,lim_desc);"/></td>
				</tr>
				
				<tr>
					<td style="text-align:right;"><input type="submit" name="envoyer" value="Envoyer" /></td>
				</tr>		
		</table>
	</form>	
</div>

<!--TVA-->
<div style="margin-top:5px;width:491px; height:250px; border:4px solid;border-radius:15px; border-color:#DCDCDC #696969 #696969 #DCDCDC; float:left;">
	<form method="post" enctype="multipart/form-data" action="#">
		<table border="0" cellspacing="20" cellpadding="5" style="margin:auto; margin-top:20px;">				
		
				<tr>
					<td><label for="categorie"><b>Référence de la TVA</b><br/></label></td>
					<td>
						<select name="categorie" id="categorie">
							<option value="ajout_categ">Ajouter une TVA</option>
								<?php
									$rq = connexionbddplugit::getInstance()->query("SELECT ref FROM tva");
									$selected ="";
									while($ar = $rq->fetch())
									{
										echo '<option value="'.$ar['ref'].'" '.$selected.'>'.$ar['ref'].'</option>';
									}

								?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td><label for="ref"><b>Nom de la référence TVA</b><br/><small id="lim_desc">(Max 50 caractères)</small></label></td>
					<td><input size="22" type="text" name="ref" id="ref" value="<?php echo $ar['ref']; ?>" <?php echo $require; ?> onblur="textLimit(this, 50,lim_desc);"/></td>
				</tr>
				
				<tr>
					<td><label for="tva"><b>Taux de la TVA (en %)</b><br/><small id="lim_desc">(Exemple : 19.6)</small></label></td>
					<td><input size="22" type="text" name="tva" id="tva" value="<?php echo $ar['valeur']; ?>" <?php echo $require; ?> onblur="isNumber(this,tva);"/></td>
				</tr>
				
				
				<tr>
					<td style="text-align:right;"><input type="submit" name="envoyer" value="Envoyer" /></td>
				</tr>		
		</table>
	</form>	
</div>

<?php
}
else
{
	echo '<h2 style="color:red">Access Forbidden !</h2>';
}
?>