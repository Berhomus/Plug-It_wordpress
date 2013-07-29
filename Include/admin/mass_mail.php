<script type="text/javascript" src="js/fct_de_trt_txt.js"></script>

<?php

if(isset($_SESSION['id']))
{
	echo '<h2>E-Mail de Masse</h2>';
?>
	
		<form method="post" action="#">
		<table border="0" cellspacing="20" cellpadding="5" style="margin:auto;">				
				<tr>
					<td><label for="titre"><b>Titre <span class="red">*</span></b><br/><small id="lim_nom">(Max 20 caractères)</small></label></td>
					<td><input size="50" type="text" name="titre" id="titre" required="" onblur="textLimit(this, 20, lim_nom);"/></td>
				</tr>
				
				<tr>
					<td><label for="objet"><b>Objet <span class="red">*</span></b></label></td>
					<td><input size="50" type="text" name="objet" id="objet" required/></td>
				</tr>
				
				<tr>
					<td colspan="2">
						<div>
							<p>
								<input type="button" value="G" onclick="document.getElementById('ortf').focus(); document.execCommand('bold', false, '');" />
								<input type="button" value="I" onclick="document.getElementById('ortf').focus(); document.execCommand('italic', false, '');" />
								<input type="button" value="S" onclick="document.getElementById('ortf').focus(); document.execCommand('underline', false, '');" />
								<input type="button" value="Lien" onclick="document.getElementById('ortf').focus(); lien();" />
								<input type="button" value="Image" onclick="document.getElementById('ortf').focus(); img();" />
								<input type="button" value="Titre" onclick="document.getElementById('ortf').focus(); document.execCommand('bold', false, '');document.execCommand('FontSize', false, '3');" />
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
	echo '<h2>Access Forbidden</h2>';
}

?>