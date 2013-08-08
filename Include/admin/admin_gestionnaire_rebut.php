<style>
	#table_rebut
	{
		text-align: center;
		margin:auto;
	}
	#table_rebut td
	{
		border:1px solid black;
	}
	#table_modif_rebut
	{
		margin:auto;
	}
</style>

<h2 >Gestion Article Rebut</h2>
<div style="margin-top:10px;">
<form method="POST" action="<?php echo $_SESSION['protocol'].$_SESSION['current_loc']; ?>traitement/trt_rebut.php">
<?php
	require_once('./connexionbddplugit.class.php');
	
	try{
		$bdd = connexionbddplugit::getInstance();
		
		$rq = $bdd->prepare("SELECT * FROM produit WHERE categorie=? OR tva=?");
		$rq->execute(array(-1,-1));
		if($rq->rowCount()>0)
		{
		
			$rq1 = connexionbddplugit::getInstance()->query("SELECT id FROM menu WHERE baseName='boutique'");
			$ar1 = $rq1->fetch();
		
			$rq = connexionbddplugit::getInstance()->query("SELECT * FROM sousmenu WHERE menu='".$ar1['id']."'");
			
			echo '<table cellspacing="10" id="table_modif_rebut">
				<tr>
					<td>Catégorie </td>
					<td><select name="categ">
					<option value="-1" selected>Defaut</option>';
						while($ar = $rq->fetch())
						{
							echo '<option value="'.$ar['id'].'">'.$ar['nom'].'</option>';
						}
				
				echo '</select></td>
				</tr>
				<tr>
					<td>TVA </td>
					<td><select name="tva">
					<option value="-1" selected>Defaut</option>';
				
				$rq = connexionbddplugit::getInstance()->query("SELECT * FROM tva");
				while($ar = $rq->fetch())
				{
					echo '<option value="'.$ar['id'].'">'.$ar['ref'].' - '.(round($ar['valeur']*100)/100).'%</option>';
				}
				
				echo '</select></td>
				</tr>
				<tr>
					<td><input type="submit" value="Supprimer" onclick="document.getElementById(\'sup\').value=1;"/></td>
					<td><input type="submit" value="Valider" /></td>
				</tr>
			</table>';
			
			echo '<input type="hidden" name="sup" id="sup" value="0"/>';
		
			echo '<table  cellpadding="10" cellspacing="5" id="table_rebut" style="border:1px solid black;">
				<tr>
					<td>Nom</td>
					<td>Catégorie</td>
					<td>TVA</td>
					<td>Selection</td>
				</tr>';
			while($ar = $rq->fetch())
			{
				$categ = ($ar['categorie'] == -1)? '<img height="50" width="50" src="./img/xmark.png"/>':'<img height="50" width="50" src="./img/vmark.png"/>';
				$tva = ($ar['tva'] == -1)? '<img height="50" width="50" src="./img/xmark.png"/>':'<img height="50" width="50" src="./img/vmark.png"/>';
				echo'<tr>
					<td width="150";>'.$ar['nom'].'</td>
					<td width="80";>'.$categ.'</td>
					<td width="80";>'.$tva.'</td>
					<td width="80";><input type="checkbox" name="'.$ar['id'].'" /></td>
				</tr>';
			}
			echo '</table>';
		}
		else
			echo '<h2>Pas d\'article</h2>';
	}catch(Exception $e){
		echo $e->getMessage();
	}

?>
</form>
</div>