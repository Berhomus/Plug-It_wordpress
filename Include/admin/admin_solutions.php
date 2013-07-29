
<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : admin_solutions.php => Plug-it
*********************************************************-->
<script>
/*####FONCTION PERMETTANT DE FAIRE DES REQUETES HTTP POUR RECUPERER DONNEES AU FORMAT XML####*/
	
function getXMLHttpRequest() 
{
    var xhr = null;
     
    if (window.XMLHttpRequest || window.ActiveXObject) 
	{
        if (window.ActiveXObject) 
		{
            try 
			{
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } 
			catch(e) 
			{
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } 
		else 
		{
            xhr = new XMLHttpRequest();
        }
    } 
	else 
	{
        alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
        return null;
    }
     
    return xhr;
}
/*####FONCTION DE VISUALISATION (IMAGE)####*/

/*function view(){
	
	var fileInput = document.querySelector("#grandeimg");
    var xhr = getXMLHttpRequest();
     
    if (xhr && xhr.readyState != 0) {
        xhr.abort();
        delete xhr;
    }
	
     xhr.onreadystatechange = function() {
		 if (xhr.readyState == 4) 
		{
			if(xhr.status == 200)
			{
				document.getElementById('preview').innerHTML = xhr.responseText;
			}
			else
				dump("Error loading page\n");
		}
	}

    xhr.open("POST", "include/admin/view.php", true);
    //xhr.setRequestHeader("Content-Type", "image/gif");
	var form = new FormData();
	form.append('file', fileInput.files[0]);
	xhr.send(form);
	
	var desc = document.getElementById('desc').innerHTML;
	var name = document.getElementById('nomsolu').value;
	
	
	//xhr.send("name=" + name);
	//xhr.send("desc=" + desc);
	
}*/
</script>

<?php
if(isset($_SESSION['id']))
{
?>
<script type="text/javascript" src="js/fct_de_trt_txt.js"></script><?php	$id=0;	$nomsolu="";	$corps="";	$logosolu="";	$grandeimg="";	$desc="";
	$desc_origin="";
	$ordre=0;		if(isset($_POST) and !empty($_POST))	{		$id= (isset($_GET['id'])) ? $_GET['id']:0;		$nomsolu=$_POST['nomsolu'];		$desc=$_POST['desc'];		$corps=$_POST['corps'];
		$ordre=$_POST['ordre'];
		$desc_origin=$_POST['desc'];	}	if(isset($_GET['id']))	{		require_once('./connexionbddplugit.class.php');
		try{			$rq=connexionbddplugit::getInstance()->query("SELECT COUNT(id) as cpt FROM solutions WHERE id='".$_GET['id']."'");			$array=$rq->fetch();
		} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
		}				if($array['cpt']==1)		{
		try{			$rq=connexionbddplugit::getInstance()->query("SELECT * FROM solutions WHERE id='".$_GET['id']."'");			$array=$rq->fetch();
		} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
		}						$id=$array['id'];			$nomsolu=$array['titre'];			$corps=$array['corps'];			$logosolu=$array['image_sol'];			$desc=$array['description'];			$grandeimg=$array['image_car'];
			$ordre=$array['ordre'];
			$desc_origin=$array['description'];		}		else		{			echo '<center><font color=red>Erreur solutions introuvable</font></center><br/>';		}					}		if($id!=0)	{		echo '<h2>Modification d\'une solution</h2>			<br/><center>Tout champ vide ne sera pas modifié</center>';		$require = "";		$type = "modif&id=".$id;	}	else	{		echo '<h2>Ajout d\'une solution</h2>';		$require = "required";		$type = "create";	}	?><form method="post" enctype="multipart/form-data" action="traitement/trt_solutions.php?mode=<?php echo $type; ?>" name="sol">	<table border="0" cellspacing="20" cellpadding="5" style="margin:auto;">							<tr>				<td><label for="nomsolu"><b>Nom de la solution <span class="red">*</span></b><br/><small id="lim_nom">(Max 20 caractères)</small></label></td>				<td><input size="50" type="text" name="nomsolu" id="nomsolu" value="<?php echo $nomsolu; ?>" <?php echo $require; ?> onblur="textLimit(this, 20, lim_nom);"/></td>			</tr>						<tr>				<td><label for="logosolu"><b>Logo de la solution <span class="red">*</span></b><br/><small>(Max 100Ko et uniquement jpg, png, gif et bmp<br/>(Taille conseillée 280x170)</small></label></td>				<td><input size="50" type="file" name="logosolu" id="logosolu" value="<?php echo $logosolu; ?>" <?php echo $require; ?>/></td>			</tr>						<tr>				<td><label for="grandeimg" id="grdimg"><b>Contenu pour l'accueil <span class="red">*</span></b><br/><small>(Uniquement jpg, png, gif, bmp, avi et mp4)<br/>([Max 300Ko Image] Taille conseillée 940x387)</small></label></td>				<td><input size="50" type="file" name="grandeimg" id="grandeimg" value="<?php echo $grandeimg; ?>" <?php echo $require; ?> /></td>			</tr>
			
			<tr>
				<td></td>
				<td><div id="preview"></div></td>
			</tr>						<tr>				<td><label for="description"><b>Résumé de la solution <span class="red">*</span></b><br/><small id="lim_resu">(Max 3 Lignes)</small></label></td>				<td><div style="height: 100px; width:400px; overflow:scroll; margin-top:20px;" id="description" contenteditable="true" <?php echo $require; ?> onblur="textLimit3(this, lim_resu);required(this,grdimg,grandeimg);document.getElementById('desc').value = this.innerHTML;"><?php echo nl2br($desc); ?></div></td>			</tr>
			
			<tr>
				<td><label for="ordre"><b>Position</b><br/><small>(1ere position par défaut)</small></label></td>
				<td>
					<select name="ordre" id="ordre">
						<?php
							require_once('./connexionbddplugit.class.php');
							try{
								$rq=connexionbddplugit::getInstance()->query("SELECT COUNT(id) AS nombre FROM solutions");
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
			</tr>						<tr>				<td colspan="2">					<div>						<p>							<input type="button" value="G" onclick="document.getElementById('ortf').focus(); document.execCommand('bold', false, '');" />
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
					<input type="hidden" value="" id="corps" name="corps" />					<input type="hidden" value="" id="desc" name="desc" />
				</td>			</tr>						<tr>				<td style="text-align:right;"><input type="submit" name="envoyer" value="Envoyer" /></td>			</tr>			</table></form>	

<script>
//preview
function createThumbnail(file) {
	 
	var reader = new FileReader();
	 
	reader.onload = function() {
		 
		imgType = file.name.split('.');
		imgType = imgType[imgType.length - 1];
		imgType.toLowerCase();	
		 
		if(vid.indexOf(imgType))
		{
			var imgElement = document.createElement('video');
			imgElement.setAttribute('controls',"");
			imgElement.style.maxWidth = '400px';
			imgElement.style.maxHeight = '400px';
		}
		else
		{
			var imgElement = document.createElement('img');
			imgElement.style.maxWidth = '150px';
			imgElement.style.maxHeight = '150px';
		}
		
		
		imgElement.setAttribute("id","img_prev");
		imgElement.src = this.result;
		
		if(document.getElementById("img_prev"))
			prev.removeChild(document.getElementById("img_prev"));
			
		prev.appendChild(imgElement);
		 
	};
	 
	reader.readAsDataURL(file);
	 
}
   //*modif limite taille poyur vid*//  
var allowedTypes = ['png', 'jpg', 'jpeg', 'gif', 'mp4', 'avi'],
	fileInput = document.querySelector('#grandeimg'),
	prev = document.querySelector('#preview');
var vid = ['avi','mp4'];
 
fileInput.onchange = function() {
   
	var files = this.files,
		filesLen = files.length,
		imgType;
		
	imgType = files[0].name.split('.');
	imgType = imgType[imgType.length - 1];
	imgType.toLowerCase();	

	//si video on ignore limite taille
	if(!vid.indexOf(imgType) && imgTypefiles[0].size > 300*1024)
	{
		alert('Image trop lourde');
		this.value='';
		if(document.getElementById("img_prev"))
			prev.removeChild(document.getElementById("img_prev"));
	}
	else
	{
		for (var i = 0 ; i < filesLen ; i++) {
			 
			if(allowedTypes.indexOf(imgType) != -1) {
				createThumbnail(files[i]);
			}
			else
			{
				alert('Format incorrect');
				this.value='';
			}
			 
		}
	}
};

</script>

	<?php
	}
	else
	{
		echo '<h2 style="color:red">Access Forbidden !</h2>';
	}
	?>

