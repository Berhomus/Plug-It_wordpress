<script type="text/javascript" src="js/fct_de_trt_txt.js"></script>
<script type="text/javascript" src="js/ajout_fact.js"></script>

<script>
function titre()
{	
	document.execCommand('bold', false, '');
	document.execCommand('FontSize', false, '3');
	document.getElementById('ortf').focus(); 
}


</script>

<?php
if(isset($_SESSION['id']))
{

?>

<?php
	require_once('./connexionbddplugit.class.php');

	$bdd = connexionbddplugit::getInstance();
	
	$id=0;
	$titre="";
	$corps="";
	$logoprod="";
	$prix = 0.00;
	$ordre=0;
	$categorie = 0;
	$tva = 0;
	$delai = 0;
	
	$rq = $bdd->prepare("SELECT valeur FROM tva WHERE id='1'");
	$rq->execute();
	$ar = $rq->fetch();
	$tva = $ar['valeur'];
	
	if(isset($_POST) and !empty($_POST))
	{
		$id= (isset($_GET['id'])) ? $_GET['id']:0;
		$titre=$_POST['nom'];
		$prix =$_POST['prix'];
		$corps=$_POST['corps'];
		$ordre=$_POST['ordre'];
		$categorie = $_POST['categorie'];
		$tva = $_POST['tva'];
		$delai = $_POST['delai'];
	}
	else if(isset($_GET['id']))
	{		
		$rq=connexionbddplugit::getInstance()->query("SELECT COUNT(id) as cpt FROM produit WHERE id='".$_GET['id']."'");
		$array=$rq->fetch();
		
		if($array['cpt']==1)
		{
			$rq=connexionbddplugit::getInstance()->query("SELECT * FROM produit WHERE id='".$_GET['id']."'");
			$array=$rq->fetch();
			
			$id=$array['id'];
			$titre=$array['nom'];
			$corps=$array['description'];
			$logoprod=$array['images'];
			$prix =$array['prix'];
			$ordre=$array['priorite'];
			$categorie = $array['categorie'];
			$tva = $array['tva'];
			$delai = $array['delai'];
		}
		else
		{
			echo '<center><font color=red>Erreur référence introuvable</font></center><br/>';
		}
	}
	
	if($id!=0)
	{
		echo '<h2>Modification d\'un Produit</h2>
			<br/><center>Tout champ vide ne sera pas modifié</center>';
		$require = "";
		$type = "modif&id=".$id;
	}
	else
	{
		echo '<h2>Ajout d\'un Produit</h2>';
		$require = "required";
		$type = "create";
	}
	
?>

<form method="post" enctype="multipart/form-data" action="<?php echo $_SESSION['protocol'].$_SESSION['current_loc']; ?>traitement/trt_boutique.php?mode=<?php echo $type; ?>">
	<table border="0" cellspacing="20" cellpadding="5" style="margin:auto;">				
			<tr>
				<td><label for="titre"><b>Nom du produit <span class="red">*</span></b><br/><small id="lim_nom">(Max 50 caractères)</small></label></td>
				<td><input size="40" type="text" name="titre" id="titre" value="<?php echo $titre; ?>" <?php echo $require; ?> onblur="textLimit(this,50, lim_nom);"/></td>
			</tr>
			
			<tr>
				<td><label for="logoprod"><b>Logo du produit <span class="red">*</span></b><br/><small>(Max 100Ko et uniquement jpg, png, gif et bmp)<br/>(Taille conseillée 280x157)</small></label></td>
				<td><input size="50" type="file" name="logoprod" id="logoprod" value="<?php echo $logoprod; ?>" <?php echo $require; ?>/></td>
			</tr>
			
			<tr>
				<td><label for="ordre"><b>Priorité</b><br/><small>(Bas 1/5 Haut)</small></label></td>
				<td>
					<select name="ordre" id="ordre">
						<?php
							$selected ="";
							for($i=1;$i<=5;$i++)
							{
								$selected = ($ordre==$i) ? "selected":"";
								echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
							}

						?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td><label for="prix" id="prix_label"><b>Prix du produit <span class="red">*</span></b><br/><small id="lim_prix">(Chiffre en €)</small></label></td>
				<td><input size="10" style="text-align:right;" type="text" name="prix" id="prix" value="<?php echo $prix; ?>" <?php echo $require; ?> onblur="isNumber(this, lim_prix);"/>€</td>
			</tr>
			
			<tr>
				<td><label for="tva" id="tva_label"><b>TVA <span class="red">*</span></b><br/><small id="lim_prix">(Chiffre en %)</small></label></td>
				<td>
					<select name="tva" id="tva">
						<option value="-1">Rebut</option>
							<?php
								$rq = connexionbddplugit::getInstance()->query("SELECT * FROM tva");
								$selected ="";
								while($ar = $rq->fetch())
								{
									$selected = ($ar['id']==$tva) ? "selected":"";
									echo '<option value="'.$ar['id'].'" '.$selected.'>'.$ar['ref'].' - '.(round($ar['valeur']*100)/100).'%</option>';
								}

							?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td><label for="categorie"><b>Catégorie du produit <span class="red">*</span></b><br/></label></td>
				<td>
					<select name="categorie" id="categorie">
						<option value="-1">Rebut</option>
							<?php
								$rq1 = connexionbddplugit::getInstance()->query("SELECT id FROM menu WHERE baseName='boutique'");
								$ar1 = $rq1->fetch();
							
								$rq = connexionbddplugit::getInstance()->query("SELECT * FROM sousmenu WHERE menu='".$ar1['id']."'");
								$selected ="";
								while($ar = $rq->fetch())
								{
									$selected = ($ar['id']==$categorie) ? "selected":"";
									echo '<option value="'.$ar['id'].'" '.$selected.'>'.$ar['nom'].'</option>';
								}

							?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td><label for="delai"><b>Delai Livraison <span class="red">*</span></b><br/><small id="lim_delay">(En Heure)</small></label></td>
				<td><input size="10" type="text" name="delai" id="delai" value="<?php echo $delai; ?>" <?php echo $require; ?> style="text-align:right;" onblur="isNumber2(delai,lim_delay);"/></td>
			</tr>
			
			<tr>
				<td colspan="2">
					<div style="margin-bottom:5px;">
						<p>
							<b>Description du produit <span class="red">*</span></b>
							<br/>
							<br/>
							<input type="button" value="G" onclick="document.getElementById('ortf').focus(); document.execCommand('bold', false, '');" />
							<input type="button" value="I" onclick="document.getElementById('ortf').focus(); document.execCommand('italic', false, '');" />
							<input type="button" value="S" onclick="document.getElementById('ortf').focus(); document.execCommand('underline', false, '');" />
							<input type="button" value="Lien" onclick="document.getElementById('ortf').focus(); lien();" />
							<input type="button" value="Image" onclick="document.getElementById('ortf').focus(); img();" />
							<input type="button" value="Titre" onclick="document.getElementById('ortf').focus(); titre();" />
							<img src="images/fleche.png" alt="fleche" onclick="document.getElementById('ortf').focus(); document.execCommand('insertImage', false, 'images/fleche.png');" />
						</p>
						
					</div>
					
					<select name="cmbpolice" onchange="document.getElementById('ortf').focus(); document.execCommand('FontName', false ,this.value)">
						<option selected="" value="Arial">Police par défaut</option>
						<option value="Arial">Arial</option>
						<option value="Verdana">Verdana</option>
						<option value="Courier New">Courier New</option>
						<option value="Time New Roman">Time New Roman</option>
						<option value="Comic Sans MS">Comic Sans MS</option>
					</select>

					<select name="cmbtaille" onchange="document.getElementById('ortf').focus(); document.execCommand('FontSize',false,this.value)">
						<option selected="" value="3">Taille par défaut</option>
						<option value="1">1 (petite)</option>
						<option value="2">2</option>
						<option value="3">3 (normale)</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7 (grande)</option>
					</select>
								
					<select name="cmbcouleur" onchange="document.getElementById('ortf').focus(); document.execCommand('ForeColor',false,this.value)">
						<option selected="" value="555555">Couleur par défaut</option>
						<option value="ff0000">Rouge</option>
						<option value="0000ff">Bleu</option>
						<option value="00ff00">Vert</option>
						<option value="000000">Noir</option>
						<option value="FFFF00">Jaune</option>
						<option value="666666">Gris</option>
						<option value="FF6600">Orange</option>
					</select>
					
					<div style="height: 500px; width:800px; overflow:scroll; margin-top:20px;" id="ortf" contenteditable="true" onblur="document.getElementById('corps').value=this.innerHTML">
					<?php
						echo nl2br($corps);
					?>
					</div>
					
					<input type="hidden" value="" id="corps" name="corps" />
					 
				</td>
			</tr>
			
			<tr>
				<td style="text-align:right;"><input type="submit" name="envoyer" value="Envoyer" /></td>
			</tr>		
	</table>
	</form>	
	
<?php
}
else
{
	echo '<h2 style="color:red">Access Forbidden !</h2>';
}
?>