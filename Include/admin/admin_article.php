 <!--<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/themes/smoothness/jquery-ui.css" />
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>-->

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
 
<script type="text/javascript" src="../../js/jscolor/jscolor.js"></script>
 
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
 
 <?php
	require_once('../../connexionbddplugit.class.php');
?>
 
<style>

	/*global*/
	#contain{
		width: 100%;
		height: 100%;
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
		this.style.border= "red inset 5px";
		current_selection = this.id;
		just_selected = 1;
		if(just_dropped)
		{
			document.click();
			just_dropped = -1;
		}		
	}
	
	function addBlock(color,plan){
		var contain = document.getElementById("contain");
		var block = document.createElement( "dir" );
		nb_block++;
		block.setAttribute("id","block_"+nb_block);
		block.style.width="150px";
		block.style.height="150px";
		block.style.backgroundColor=color;
		block.style.zIndex=plan;
		block.addEventListener("click", selection, false);
		contain.appendChild(block);
		
		$( "#block_"+nb_block ).draggable({
			revert : 'invalid'
		});
		$( "#block_"+nb_block ).resizable({
		});

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
		
		xhr.open("POST", "requete_article.php", true);
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
						 $("#contain").css("background-color",$("#color").val());
						$( this ).dialog( "close" );
					},
				"Annuler": function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
		$('#ajout_elem_dialog').dialog({
			minWidth:360,
			minHeight:510,
			autoOpen: false,
			width: 360,
			modal: true,
			buttons: {
				"Valider": function() {
						addBlock($("#color_elem").val(),$("#spinner").spinner( "value") );
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
	<p class="tips">Choisissez votre élément !</p>
	<form>
		<table style="margin:auto;" cellspacing="10">
			<tr>
				<td><label for="type">Type </label></td>
				<td></td>
			</tr>
			<tr>
				<td><label for="spinner">Plan </label></td>
				<td><input id="spinner" name="value" /></td>
			</tr>
			<tr>
				<td><label for="color">Couleur </label></td>
				<td><input type="text" class="color" id="color_elem" name="color"/></td>
			</tr>
		</table>
	</form>
</div>



<div id="contain">
	
	<div id="outil">
		<div>
			<button id="open_artc">Info Article</button>
			<button id="select">Choix Action</button>
		</div>
		<ul>
			<li><a onClick="$('#ajout_elem_dialog').dialog('open');">Ajouter</a></li>
			<li><a onClick="deleteBlock();">Supprimer</a></li>
			<li><a>Valider</a></li>
		</ul>
	</div>

</div>

