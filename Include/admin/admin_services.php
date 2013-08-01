
<script type="text/javascript" src="js/fct_de_trt_txt.js"></script>

<?phpif(isset($_SESSION['id'])){?><?php	$id=0;	$nomserv="";	$corps="";	$logoserv="";	$soustitre="";
	$ordre=0;		if(isset($_POST) and !empty($_POST))	{		$id= (isset($_GET['id'])) ? $_GET['id']:0;		$nomserv=$_POST['nomserv'];		$soustitre=$_POST['soustitre'];		$corps=$_POST['corps'];
		$ordre=$_POST['ordre'];	}	else if(isset($_GET['id']))	{		require_once('./connexionbddplugit.class.php');
		$bdd = connexionbddplugit::getInstance();
		
		try{			$rq=$bdd->prepare("SELECT COUNT(id) as cpt FROM services WHERE id=?");
			$rq->execute(array($_GET['id']));			$array=$rq->fetch();
		} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
		}		
				if($array['cpt']==1)		{
			try{				$rq=$bdd->prepare("SELECT * FROM services WHERE id=?");
				$rq->execute(array($_GET['id']));				$array=$rq->fetch();
			} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
			}						$id=$array['id'];			$nomserv=$array['titre'];			$corps=$array['corps'];			$logoserv=$array['image'];			$soustitre=$array['subtitre'];
			$ordre=$array['ordre'];		}		else		{			echo '<center><font color=red>Erreur référence introuvable</font></center><br/>';		}					}		if($id!=0)	{		echo '<h2>Modification d\'un service</h2>			<br/><center>Tout champ vide ne sera pas modifié</center>';		$require = "";		$type = "modif&id=".$id;	}	else	{		echo '<h2>Ajout d\'un service</h2>';		$require = "required";		$type = "create";	}	?><form method="post" enctype="multipart/form-data" action="traitement/trt_services.php?mode=<?php echo $type; ?>">	<table border="0" cellspacing="20" cellpadding="5" style="margin:auto;">							<tr>				<td><label for="nomserv"><b>Nom du service <span class="red">*</span></b><br/><small id="lim_nom">(Max 70 caractères)</small></label></td>				<td><input size="50" type="text" name="nomserv" id="nomserv" value="<?php echo $nomserv; ?>" <?php echo $require; ?> onblur="textLimit(this,70, lim_nom);"/></td>			</tr>						<tr>				<td><label for="logoserv"><b>Logo du service <span class="red">*</span></b><br/><small>(Max 100Ko et uniquement jpg, png, gif et bmp)<br/>(Taille conseillée 280x157)</small></label></td>				<td><input size="50" type="file" name="logoserv" id="logoserv" value="<?php echo $logoserv; ?>" <?php echo $require; ?>/></td>			</tr>						<tr>				<td><label for="soustitre"><b>Sous-titre <span class="red">*</span></b><br/><small id="sous_titre">(Max 25 caractères)</small></label></td>				<td><input size="50" type="text" name="soustitre" id="soustitre" value="<?php echo $soustitre; ?>" <?php echo $require; ?> onblur="textLimit(this, 25, sous_titre);"/></td>			</tr>			
			<tr>
				<td><label for="ordre"><b>Position</b><br/><small>(1ere position par défaut)</small></label></td>
				<td>
					<select name="ordre" id="ordre">
						<?php
						
							require_once('./connexionbddplugit.class.php');
							try{
								$rq=connexionbddplugit::getInstance()->query("SELECT COUNT(id) AS nombre FROM services");
								$rq=$rq->fetch();
							} catch ( Exception $e ) {
								echo "Une erreur est survenue : ".$e->getMessage();
							}
							
							$var=($type=='create') ? $rq['nombre']+1 : $rq['nombre'];
							for($i=1;$i<=$var;$i++)
							{
								if(($ordre==0 && $i==1)|| $ordre==$i)
								{
									echo '<option value="'.$i.'" Selected="">'.$i.'</option>';
								}
								else
								{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
							}
							
						?>
					</select>
				</td>
			</tr>
						<tr>				<td colspan="2">					<div style="margin-bottom:5px;">						<p>							<b>Description du service <span class="red">*</span></b>							<br/>							<br/>							<input type="button" value="G" onclick="document.getElementById('ortf').focus(); document.execCommand('bold', false, '');" />							<input type="button" value="I" onclick="document.getElementById('ortf').focus(); document.execCommand('italic', false, '');" />							<input type="button" value="S" onclick="document.getElementById('ortf').focus(); document.execCommand('underline', false, '');" />							<input type="button" value="Lien" onclick="document.getElementById('ortf').focus(); lien();" />							<input type="button" value="Image" onclick="document.getElementById('ortf').focus(); img();" />							<input type="button" value="Titre" onclick="document.getElementById('ortf').focus(); titre();" />							<img src="images/fleche.png" alt="fleche" onclick="document.getElementById('ortf').focus(); document.execCommand('insertImage', false, 'images/fleche.png');" />						</p>											</div>										<select name="cmbpolice" onchange="document.getElementById('ortf').focus(); document.execCommand('FontName', false ,this.value)">						<option selected="" value="Arial">Police par défaut</option>						<option value="Arial">Arial</option>						<option value="Verdana">Verdana</option>						<option value="Courier New">Courier New</option>						<option value="Time New Roman">Time New Roman</option>						<option value="Comic Sans MS">Comic Sans MS</option>					</select>					<select name="cmbtaille" onchange="document.getElementById('ortf').focus(); document.execCommand('FontSize',false,this.value)">						<option selected="" value="3">Taille par défaut</option>						<option value="1">1 (petite)</option>						<option value="2">2</option>						<option value="3">3 (normale)</option>						<option value="4">4</option>						<option value="5">5</option>						<option value="6">6</option>						<option value="7">7 (grande)</option>					</select>													<select name="cmbcouleur" onchange="document.getElementById('ortf').focus(); document.execCommand('ForeColor',false,this.value)">						<option selected="" value="555555">Couleur par défaut</option>						<option value="ff0000">Rouge</option>						<option value="0000ff">Bleu</option>						<option value="00ff00">Vert</option>						<option value="000000">Noir</option>						<option value="FFFF00">Jaune</option>						<option value="666666">Gris</option>						<option value="FF6600">Orange</option>					</select>										<div style="height: 500px; width:800px; overflow:scroll; margin-top:20px;" id="ortf" contenteditable="true" onblur="document.getElementById('corps').value=this.innerHTML">					<?php						echo nl2br($corps);					?>					</div>										<input type="hidden" value="" id="corps" name="corps" />					 				</td>			</tr>						<tr>				<td style="text-align:right;"><input type="submit" name="envoyer" value="Envoyer" /></td>			</tr>			</table>	</form>		<?php}else{	echo '<h2 style="color:red">Access Forbidden !</h2>';}?>
