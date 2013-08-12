 <!--<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/themes/smoothness/jquery-ui.css" />
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>-->

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link type="text/css" rel="stylesheet" href="./styles/index.css"/>

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
 
<script type="text/javascript" src="./js/fct_de_trt_txt.js"></script>
<script type="text/javascript" src="./js/ajout_fact.js"></script>
<script type="text/javascript" src="./js/jscolor/jscolor.js"></script>
 
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
 
 <?php
if(isset($_SESSION['id']))
{
	require_once('./connexionbddplugit.class.php');
	//TO DO
	//Ecart quand ouverture menu
	//pb deslection ap drop
	//valider ++ trt
	//modfier avec rechargement 
	//upload
?>
 
<style>

	/*global*/
	#contain{
		border: black solid 2px;
	}
	
	/*boite outils*/
	#outil{
		text-align:center;
		width:180px;
		padding:10px;
		border:red solid 2px;
		z-index:100;
	}
	
	/*dialogue*/
	#info_artc{
		display:none;
	}
	
	#info_artc .tips{
		text-align:center;
	}
	
	#info_artc input,textarea{
		border-radius:5px;
	}
	
	/*Ajout element*/
	#ajout_elem_dialog{
		display:none;
	}
	
	
	/*divers*/
	.help{
		border : 1px solid #1877D5;
		background : #84BEFD;
		opacity : 0.3;
	}
</style>

<script>

	var nb_block = 0;
	var current_selection = -1;
	var just_selected = -1;
	var just_dropped = -1;
	
	
	function selection(){
		if(current_selection != -1)
		{
			document.getElementById(current_selection).style.border = "none";
		}
		this.style.border= "red inset 2px";
		current_selection = this.id;
		just_selected = 1;
		/*if(just_dropped)
		{
			just_selected = -1;
			just_dropped = -1;
		}	*/	
	}
	
	function addBlock(color,plan,contenu,transp,type,img){
		var contain = document.getElementById("contain");
		var block = document.createElement( "dir" );
		nb_block++;
		if(type == 'texte')
		{
			if(transp)
				var t = 0;
			else
				var t = 1;
			
			block.setAttribute("id","block_"+nb_block);
			block.style.width="150px";
			block.style.height="150px";
			block.style.padding="0px";
			block.style.backgroundColor="rgba("+hexToRgb(color).r+","+hexToRgb(color).g+","+hexToRgb(color).b+","+t+")";
			block.style.zIndex=plan;
			block.style.overflow="hidden";
			block.addEventListener("click", selection, false);
			block.innerHTML = contenu.innerHTML;
		}
		else
		{
			block.setAttribute("id","block_"+nb_block);
			block.style.width="150px";
			block.style.height="150px";
			block.style.padding="0px";
			block.style.zIndex=plan;
			block.style.overflow="hidden";
			block.addEventListener("click", selection, false);
			block.innerHTML = '<img src='+img+' width="100%" height="100%"/>';
			alert(block.innerHTML);
		}
		
		contain.appendChild(block);
		
		$( "#block_"+nb_block ).draggable({
			revert : 'invalid'
		});
		$( "#block_"+nb_block ).resizable({
		});	
	}
	
	function hexToRgb(hex) {
		var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		return result ? {
			r: parseInt(result[1], 16),
			g: parseInt(result[2], 16),
			b: parseInt(result[3], 16)
		} : null;
	}
	
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

	function findPosition(field){
		xhr = getXMLHttpRequest();
		
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				var rs = '<option value="base">Début</option>'+xhr.responseText;

				document.getElementById("position").innerHTML = rs;
			}
		};
		
		
		
		var rq = "";
		if(field.value != 'base')
		{
			rq = "SELECT * FROM sousmenu WHERE menu=?";
			var array = field.value;
			
		}
		else
		{
			rq = "SELECT * FROM menu";
			array = ""
		}
		
		xhr.open("POST", "./include/admin/requete_article.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send("rq="+rq+"&type=getposi&array="+array);
	}
	
	function deleteBlock(){
		if(current_selection != -1)
		{
			var contain = document.getElementById("contain");
			var block = document.getElementById(current_selection);
			contain.removeChild(block);
			current_selection = -1;
			just_selected = -1;
		}
		else
		{
			alert("Pas d'élément selectionné !");
		}
	}

	 $(function() {

		$( "#outil" ).draggable({
			revert : 'invalid'
		});
		
		$('#contain').droppable({
			 drop : function(){
				just_dropped = 1;
			}
		});

		$( "input[type=button]" )
		.button()
		.click(function( event ) {
			event.preventDefault();
		});
		
		 $( "#open_artc" )
		.button()
		.click(function() {
			$('#info_artc').dialog("open");
		})
		.next().button({
			text: false,
			icons: {
				primary: "ui-icon-triangle-1-s"
			}
		})
		.click(function() {
				var menu = $( this ).parent().next().show().position({
				my: "left top",
				at: "left bottom",
				of: this
				});
			
			$( document ).one( "click", function() {
				menu.hide();
			});
			return false;
		})
		.parent()
		.buttonset()
		.next()
		.hide()
		.menu();
		
		
		$('#info_artc').dialog({
			minWidth:360,
			minHeight:510,
			autoOpen: true,
			width: 360,
			modal: true,
			buttons: {
				"Valider": function() {
						var col = $("#color").val();
						 $("#contain").css("background-color","#"+col);
						$( this ).dialog( "close" );
					},
				"Annuler": function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
		$('#ajout_elem_dialog').dialog({
			minWidth:600,
			minHeight:510,
			autoOpen: false,
			width: 600,
			modal: true,
			buttons: {
				"Valider": function() {
						addBlock($("#color_elem").val(),$("#spinner").spinner( "value"),
						document.getElementById('ortf'),document.getElementById('transp').checked,
						document.getElementById('type').value,document.getElementById('l_image').value);
						$( this ).dialog( "close" );
					},
				"Annuler": function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
		$( "#spinner" ).spinner();
		
	});
	
	document.addEventListener("click", 
	function() {
		if(current_selection != -1 && just_selected == -1)
		{
			document.getElementById(current_selection).style.border = "none";
			current_selection = -1;
		}
		just_selected = -1;
	},false);
	
	function changecontent(id){
		var img = document.getElementById("img_new_elem");
		var txt = document.getElementById("texte_new_elem");
		var plan = document.getElementById("plan_new_elem");
		var color = document.getElementById("color_new_elem");
		var trs = document.getElementById("trs_new_elem");
		if(id.value == 'texte')
		{
			txt.style.display = "block";
			img.style.display = "none";
			trs.style.display = "block";
			color.style.display = "block";
		}
		else
		{
			txt.style.display = "none";
			trs.style.display = "none";
			color.style.display = "none";
			img.style.display = "block";
		}
		plan.style.display="block";
	}
	
	function valider(){
		var contain = document.getElementById("contain");
		var html = document.createElement('div');
		var main = document.createElement('div');
		main.setAttribute("style","background-color:"+$("#contain").css("background-color")+";");
		html.appendChild(main);
		
		var node;
		
		if(contain)
		{
			var elementID, elementNo;
			if(contain.childNodes.length > 0)
			{
			  for(var i = 0; i < contain.childNodes.length; i++)
			  {
				// Ici, on vérifie qu'on peut récupérer les attributs, si ce n'est pas possible, on renvoit false, sinon l'attribut
				elementID = (contain.childNodes[i].getAttribute) ? contain.childNodes[i].getAttribute('id') : false;
				if(elementID)
				{
					var elementPattern=new RegExp("block_[0-9]*","g");
					if(elementPattern.test(elementID))
					{
						node = contain.childNodes[i].cloneNode(true);
						node.setAttribute("class","");
						main.appendChild(node);
					}
				}
			  }
			  alert(html.innerHTML);
			}
		}
	}
	
</script>

<div id="info_artc" title="Information Article">
	<p class="tips">Tout les champs sont requis !</p>
	<form>
		<table style="margin:auto;" cellspacing="10">
			<tr>
				<td><label for="name">Nom </label></td>
				<td><input size="20" type="text" id="name" name="name"/></td>
			</tr>
			<tr>
				<td><label for="meta">Meta </label></td>
				<td><textarea name="meta" id="meta" rows="5" cols="18"></textarea></td>
			</tr>
			<tr>
				<td><label for="origin">Origine </label></td>
				<td>
					<select name="origin" id="origin" onchange="findPosition(this);">
						<option value="base">Début</option>
						<?php		
							try{
								$rq = connexionbddplugit::getInstance()->query("SELECT * FROM menu");
								while($ar = $rq->fetch())
								{
									echo '<option value="'.$ar['id'].'">'.$ar['nom'].'</option>';
								}
							}catch(Exception $e){
								echo "Une erreur est survenue : ".$e->getMessage();
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="position">Position<br/><small>Après</small></label></td>
				<td>
					<select id="position" name="position">
						
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="color">Couleur </label></td>
				<td><input type="text" class="color" id="color" name="color"/></td>
			</tr>
		</table>
	</form>
</div>

<div id="ajout_elem_dialog" title="Ajout Elément">
	<p class="tips"><center>Choisissez votre élément !</center></p>
		<table style="margin:auto;width:100%;" cellspacing="10">
			<tr>
				<td><label for="type">Contenu </label></td>
				<td> 
					<select name="type" id="type" onchange="changecontent(this);">
						<option value="texte" selected>Texte</option>
						<option value="image">Image</option>
					</select>
				</td>
			</tr>
			<tr id="img_new_elem" style="display:none;">
				<td><label for="image">Image </label></td>
				<td> 
					<input type="file" name="image" id="image"/>
					<input type="text" name="l_image" id="l_image" value="http://"/>
				</td>
			</tr>
			<tr id="texte_new_elem">
				<td colspan="2">
					<p>Texte</p>
					<div style="margin-bottom:5px;">
						<p>
							<input type="button" value="G" onclick="document.getElementById('ortf').focus(); document.execCommand('bold', false, '');" />
							<input type="button" value="I" onclick="document.getElementById('ortf').focus(); document.execCommand('italic', false, '');" />
							<input type="button" value="S" onclick="document.getElementById('ortf').focus(); document.execCommand('underline', false, '');" />
							<input type="button" value="Lien" onclick="document.getElementById('ortf').focus(); lien();" />
							<input type="button" value="Image" onclick="document.getElementById('ortf').focus(); img();" />
							<input type="button" value="Titre" onclick="document.getElementById('ortf').focus(); titre();" />
							<img src="./images/fleche.png" alt="fleche" onclick="document.getElementById('ortf').focus(); document.execCommand('insertImage', false, './images/fleche.png');" />
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
					
					<div style="height: 200px; width:500px; overflow:scroll; margin-top:20px;" id="ortf" contenteditable="true">
					</div>

				</td>
			</tr>
			
			<tr id="color_new_elem">
				<td><label for="color">Couleur </label></td>
				<td><input type="text" class="color" id="color_elem" name="color"/></td>
			</tr>
			<tr id="trs_new_elem">
				<td><label for="color">Transparence </label></td>
				<td><input type="Checkbox" id="transp" name="transp"/></td>
			</tr>
			<tr id="plan_new_elem">
				<td><label for="spinner">Plan </label></td>
				<td><input id="spinner" name="value" /></td>
			</tr>
		</table>
</div>



<div id="contain">
	
	<div id="outil">
		<div>
			<button id="open_artc">Info Article</button>
			<button id="select">Choix Action</button>
		</div>
		<ul>
			<li><a onClick="$('#ajout_elem_dialog').dialog('open');">Ajouter</a></li>
			<li><a onClick="$('#ajout_elem_dialog').dialog('open');">Modifier</a></li>
			<li><a onClick="deleteBlock();">Supprimer</a></li>
			<li><a onClick="valider();">Valider</a></li>
		</ul>
	</div>

</div>

<script>
//set contain size at page
	document.getElementById("contain").style.width = (document.body.clientWidth-2)+"px";
	document.getElementById("contain").style.height = (document.body.clientHeight-137)+"px";
//set margin corps
	document.getElementById("content").style.margin = "0px";
	document.getElementById("content").style.padding = "0px";
</script>

<?php
}
else
{
	echo '<h2>Access Forbidden</h2>';
}
?>
