
<!--********************************************************Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain BenoitLast Update : 12/07/2013Name : admin_ref.php => Plug-it*********************************************************-->
<script type="text/javascript" src="js/fct_de_trt_txt.js"></script>
<?php
if(isset($_SESSION['id'])){
			
	require_once('./connexionbddplugit.class.php');
	$bdd = connexionbddplugit::getInstance();
		$id=0;	$nomcli="";	$soustitre="";	$lien="";	$img="";	$ordre=0;		if(isset($_POST) and !empty($_POST))	{		$id= (isset($_GET['id'])) ? $_GET['id']:0;		$nomcli=$_POST['nomcli'];		$soustitre=$_POST['soustitre'];		$lien=$_POST['lien'];		$ordre=$_POST['ordre'];	}	else if(isset($_GET['id']))	{				
		try{			$rq=$bdd->prepare("SELECT COUNT(id) as cpt FROM ref WHERE id=?");
			$rq->execute(array($_GET['id']));			$array=$rq->fetch();
		} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
		}				if($array['cpt']==1)		{			try{
				$rq=$bdd->prepare("SELECT * FROM ref WHERE id=?");
				$rq->execute(array($_GET['id']));				$array=$rq->fetch();
			} catch ( Exception $e ) {
				echo "Une erreur est survenue : ".$e->getMessage();
			}						$id=$array['id'];			$nomcli=$array['titre'];			$soustitre=$array['sous_titre'];			$lien=$array['lien'];			$ordre=$array['ordre'];		}		else		{			echo 'Erreur référence introuvable';		}					}		if($id!=0)	{		echo '<h2>Modification d\'une référence</h2>			<br/><center>Tout champ vide ne sera pas modifié</center>';		$require = "";		$type = "modif&id=".$id;	}	else	{		echo '<h2>Ajout d\'une référence</h2>';		$require = "required";		$type = "create";	}	?><form method="post" enctype="multipart/form-data" action="<?php echo $_SESSION['protocol'].$_SESSION['current_loc']; ?>traitement/trt_ref.php?mode=<?php echo $type; ?>">	<table border="0" cellspacing="20" cellpadding="5" style="margin:auto;">							<tr>				<td><label for="nomcli"><b>Nom du client <span class="red">*</span></b><br/><small id="lim_nom">(Max 40 caractères)</small></label></td>				<td><input size="50" type="text" name="nomcli" id="nomcli" value="<?php echo $nomcli; ?>" <?php echo $require; ?> onblur="textLimit(this, 40, lim_nom);"/></td>			</tr>						<tr>				<td><label for="soustitre"><b>Description rapide <span class="red">*</span></b><br/><small id="lim_desc">(Max 50 caractères)</small></label></td>				<td><input size="50" type="text" name="soustitre" id="soustitre" value="<?php echo $soustitre; ?>" <?php echo $require; ?> onblur="textLimit(this, 50,lim_desc);"/></td>			</tr>						<tr>				<td><label for="lien"><b>Lien vers le site du client <span class="red">*</span></b></label></td>				<td><input size="50" type="text" name="lien" id="lien" value="<?php echo $lien; ?>" <?php echo $require; ?>/></td>			</tr>						<tr>				<td><label for="logo"><b>Logo du client <span class="red">*</span></b><br/><small>(Max 100Ko et uniquement jpg, png, gif et bmp)<br/>(Taille conseillée 220x161)</small></label></td>				<td><input size="50" type="file" name="logo" id="logo" <?php echo $require; ?>/></td>			</tr>						<tr>				<td><label for="ordre"><b>Position</b><br/><small>(1ere position par défaut)</small></label></td>				<td>					<select name="ordre" id="ordre">						<?php													require_once('./connexionbddplugit.class.php');							try{								$rq=connexionbddplugit::getInstance()->query("SELECT COUNT(id) AS nombre FROM ref");								$rq=$rq->fetch();
							} catch ( Exception $e ) {
								echo "Une erreur est survenue : ".$e->getMessage();
							}														$var=($type=='create') ? $rq['nombre']+1 : $rq['nombre'];							for($i=1;$i<=$var;$i++)							{								if(($ordre==0 && $i==1)|| $ordre==$i)								{									echo '<option value="'.$i.'" Selected="">'.$i.'</option>';								}								else								{									echo '<option value="'.$i.'">'.$i.'</option>';								}							}						?>					</select>				</td>			</tr>						<tr>				<td style="text-align:right;"><input type="submit" name="envoyer" value="Envoyer" /></td>			</tr>			</table></form>	
<?php
}else{	echo '<h2 style="color:red">Access Forbidden !</h2>';}?>
