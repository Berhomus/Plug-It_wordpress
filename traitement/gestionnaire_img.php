<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 27/06/2013
Name : admin.php => Plug-it
*********************************************************-->

<script type="text/javascript">

function GereChkbox(conteneur) {

var Chckbox = document.getElementById('supprimer1');
var i=1;
	while (Chckbox!=null) {
		Chckbox.checked = true;
		Chckbox = document.getElementById('supprimer'+i);
		i++;
	}
}

</script>

<?php
if(isset($_SESSION['id']))
{
?>
<h2>Gestionnaire d'images</h2>

<div style="text-align:center;">
<?php
	if(isset($_FILES) and !empty($_FILES))
	{
		include("function/upload.php");
		upload('images/',1024*1024*2,array('.png','.jpg','.bmp','.gif','.jpeg'),'fichier');
	}
	
	if(isset($_POST))
	{
		while($_POST)
		{
			if(file_exists($_POST['supprimer'.$position]))
			{
				unlink($pathfile);
				echo '<center style="color:green;">Suppression(s) Réussie(s)</center>';
			}
			else
			{
				echo '<center style="color:red;">Suppression(s) Impossible(s)</center>';
			}
		}
	}
?>

</div>

<br/>
<br/>
<center>
	<form action="index.php?page=gestionnaire_img" method="POST" enctype="multipart/form-data" id="form-demo">
	<input type="hidden" name="upload" />
		<label for="fichier">Upload image : </label><input type="file" name="fichier" id="fichier" />
		<input type="submit" value="Valider"/>
		<br/>
		<small>(Max 2Mo)</small>
		<br/>
	</form>
<br/>
<?php
function mkmap($dir){

echo '<form action="index.php?page=gestionnaire_img" method="POST" id="form_supp">';
	echo '<input type="hidden" name="supp" />';
    echo '<table cellspacing=20>';  
	
	echo '<tr><td colspan=5><hr/></td></tr>';
	?>
	<tr style='text-align:center;'>
		<td colspan=5>
			<input style='margin-left:15px;' type='submit' name='supprimer' value='Supprimer' />
			<input style='margin-left:15px;'type="button" name='ttselec' value='Tout Sélectionner' onClick="GereChkbox('div_chck');" />
			<input style='margin-left:15px;' type='reset' name='ttdeselec' value='Tout Déselectionner' onClick="GereChkbox('div_chck');"/>
		</td>
	</tr>";
	<?php
	echo '<tr><td colspan=5><hr/></td></tr>';
		
    $folder = opendir ($dir);
    $cpt=0;
	$position=0;
	
	echo '<div id="div_chck">';
	
    while ($file = readdir ($folder)) {  
		$pathfile = $dir.'/'.$file; 
        if ($file != "." && $file != ".." && filetype($pathfile) != 'dir') {           
			
			$position++;
			
			if($cpt==0)
			{
				echo'<tr>';
			}
			
			$fichier = basename($pathfile);
			$extension = strrchr($pathfile, '.'); 
			
			echo '<td><input type="checkbox" name="supprimer'.$position.'" id="supprimer'.$position.'" /><img src="'.$pathfile.'" alt="'.$file.'" style="vertical-align:top; max-width:150px; max-height:150px;" /></td>';
			echo '<input type="hidden" value="'.$pathfile.'" name="supprimer'.$position.'_path" />';
			$cpt++;
			
			if($cpt>4)
			{
				echo'</tr>';
				$cpt=0;
			}
        }       
    }
    closedir ($folder);
	echo '</div>';
    echo '</table>';
	echo '</form>';
}

?>
<?php mkmap('./images'); ?>
</center>

<?php
}
else
{
	echo '<h2 style="color:red">Access Forbidden !</h2>';
}
?>