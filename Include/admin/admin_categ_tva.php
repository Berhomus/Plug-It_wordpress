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

	function ajoutmodifcateg(id){
	
		var select = document.getElementById(id);
		var categ = document.getElementById('categ');
		var cb = document.getElementById('visible');

		xhr = getXMLHttpRequest();
		
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				var success;
				var n = xhr.responseText.split("_");
				if(n[0]=='reussit')
				{
					success = '<small style="color:green;">Opération Réussie !</small>';
					
					if(n[4]=='ajout')
					{
						var option = document.createElement('option');
						option.setAttribute("id","opt_"+n[3]);
						option.setAttribute("value",n[1]+'_'+n[2]);
						option.innerHTML = n[1];
						select.appendChild(option);
						option.setAttribute("selected","");
					}
					else
					{
						document.getElementById('opt_'+n[3]).innerHTML = n[1];
						document.getElementById('opt_'+n[3]).value = n[1]+'_'+n[2]+'_'+n[3];
					}
					
				}
				else
				{
					success = '<small style="color:red;">Opération Echouée !</small>';
				}
				document.getElementById("result_categ").innerHTML = success;
			}
		};
		
		var n = select.value.split("_");
		
		if(select.value == '')
		{
			//Ajout
			if(categ.value != '')
			{
				var rq = "INSERT INTO categorie VALUES (null,?,?)";
				if(cb.checked)
					var t = 1;
				else
					var t = 0;
				var array = categ.value+','+t;
				var type = 'ajout';
			}
		}
		else
		{
			// Modif
			if(categ.value != '' && (categ.value!=n[0] || cb.getAttribute("checked")!=n[1]))
			{
				var rq = "UPDATE categorie SET nom=?, visible=? WHERE id=?";
				if(cb.checked)
					var t = 1;
				else
					var t = 0;
				var array = categ.value+','+t+','+n[2];
				var type = 'modif';
			}
		}
		
		xhr.open("POST", "include/admin/requete_article.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("rq="+rq+"&type="+type+"&array="+array);
	}
	
		function ajoutmodiftva(id){
	
		var select = document.getElementById(id);
		var ref = document.getElementById('ref');
		var tva = document.getElementById('tva');

		xhr = getXMLHttpRequest();
		
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				var success;
				var n = xhr.responseText.split("_");
				if(n[0]=='reussit')
				{
					success = '<small style="color:green;">Opération Réussie !</small>';
					
					if(n[4]=='ajout')
					{
						var option = document.createElement('option');
						option.setAttribute("id","opttva_"+n[3]);
						option.setAttribute("value",n[1]+'_'+n[2]);
						option.innerHTML = n[1];
						select.appendChild(option);
						option.setAttribute("selected","");
					}
					else
					{
						document.getElementById('opttva_'+n[3]).innerHTML = n[1];
						document.getElementById('opttva_'+n[3]).value = n[1]+'_'+n[2]+'_'+n[3];
					}
					
				}
				else
				{
					success = '<small style="color:red;">Opération Echouée !</small>';
				}
				document.getElementById("result_tva").innerHTML = success;
			}
		};
		
		var n = select.value.split("_");
		
		if(select.value == '')
		{
			//Ajout tva
			if(ref.value != '')
			{
				var rq = "INSERT INTO tva VALUES (null,?,?)";
				var array = ref.value+','+tva.value;
				var type = 'ajouttva';
			}
		}
		else
		{
			// Modif tva
			if(ref.value != '' && (ref.value!=n[0] || tva.value!=n[1]))
			{
				var rq = "UPDATE tva SET ref=?, valeur=? WHERE id=?";
				var array = ref.value+','+tva.value+','+n[2];
				var type = 'modiftva';
			}
		}
		
		xhr.open("POST", "include/admin/requete_article.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("rq="+rq+"&type="+type+"&array="+array);
	}
	
	function supprimcateg(id){
		var select = document.getElementById(id);
		var categ = document.getElementById('categ');
		
		
	}
	
	function selection_update_tva(id,field1,field2){
			var n = id.value.split("_");
			document.getElementById(field1).value = Math.round(n[1]*100)/100;
			document.getElementById(field2).value = n[0];
	}
	
	function selection_update_categ(id,field1,field2){
			var n = id.value.split("_");
			document.getElementById(field1).value = n[0];
			if(n[1]==1)
			{
				document.getElementById(field2).checked = true ;
			}
			else
			{
				document.getElementById(field2).checked = false ;
			}
	}
</script>

<?php
if(isset($_SESSION['id']))
{

?>
<h2 class="grdtitre">Gestion des Catégories de la Boutique et des taux de TVA</h2>
<?php

	require_once('./connexionbddplugit.class.php');
?>
<!--Catégorie-->
<div style="margin-top:5px;width:491px; height:250px; border:4px solid;border-radius:15px; border-color:#DCDCDC #696969 #696969 #DCDCDC; float:left;">
		<table border="0" cellspacing="20" cellpadding="5" style="margin:auto; margin-top:20px;">				
				<tr>
					<td><label for="categorie"><b>Catégorie des produits </b></label></td>
					<td>
						<select name="categorie" id="categorie" onChange="selection_update_categ(this,'categ','visible')">
							<option value="" selected>Ajouter une catégorie</option>
								<?php
									$rq = connexionbddplugit::getInstance()->query("SELECT * FROM categorie");
									while($ar = $rq->fetch())
									{
										echo '<option id="opt_'.$ar['id'].'" value="'.$ar['nom'].'_'.$ar['visible'].'_'.$ar['id'].'" >'.$ar['nom'].'</option>';
									}
								?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td><label for="categ"><b>Nom de la catégorie</b><br/><small id="lim_desc">(Max 50 caractères)</small></label></td>
					<td><input size="22" type="text" name="categ" id="categ"  onblur="textLimit(this, 50,lim_desc);"/></td>
				</tr>
				
				<tr>
					<td><label for="visible"><b>Visible</b></label></td>
					<td><input type="checkbox" name="visible" id="visible"/></td>
				</tr>
				
				<tr>
					<td style="text-align:right;"><input type="button" name="valider" value="Valider" onClick="ajoutmodifcateg('categorie')"/><input type="button" name="supprimer" value="Supprimer" onClick="supprimcateg('categorie')"/></td>
					<td id="result_categ"></td>
				</tr>
		</table>
</div>

<!--TVA-->
<div style="margin-top:5px;width:491px; height:250px; border:4px solid;border-radius:15px; border-color:#DCDCDC #696969 #696969 #DCDCDC; float:left;">
		<table border="0" cellspacing="20" cellpadding="5" style="margin:auto; margin-top:20px;">				
		
				<tr>
					<td><label for="reftva"><b>Référence de la TVA</b><br/></label></td>
					<td>
						<select name="reftva" id="reftva" onChange="selection_update_tva(this,'tva','ref');">
							<option value="" selected>Ajouter une TVA</option>
								<?php
									$rq = connexionbddplugit::getInstance()->query("SELECT * FROM tva");
									while($ar = $rq->fetch())
									{
										echo '<option id="opttva_'.$ar['id'].'" value="'.$ar['ref'].'_'.$ar['valeur'].'_'.$ar['id'].'" >'.$ar['ref'].'</option>';

									}

								?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td><label for="ref"><b>Nom de la référence TVA</b><br/><small id="lim_desc">(Max 50 caractères)</small></label></td>
					<td><input size="22" type="text" name="ref" id="ref"  onblur="textLimit(this, 50,lim_desc);"/></td>
				</tr>
				
				<tr>
					<td><label for="tva"><b>Taux de la TVA (en %)</b><br/><small id="lim_desctva">(Exemple : 19.6)</small></label></td>
					<td><input size="22" type="text" name="tva" id="tva" onblur="isNumber(this,lim_desctva);"/></td>
				</tr>
				
				
				<tr>
					<td style="text-align:right;"><input type="button" name="valider" value="Valider" onClick="ajoutmodiftva('reftva')"/><input type="button" name="supprimer" value="Supprimer" onClick="supprimcateg('reftva')"/></td>
					<td id="result_tva"></td>
				</tr>		
		</table>
</div>

<?php
}
else
{
	echo '<h2 style="color:red">Access Forbidden !</h2>';
}
?>