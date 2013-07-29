<h2>Boutique en Ligne</h2>

<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript">

//Amélio => évité calcul montant total via parcour=> récupérer var session ?
	
		function scroll () {
			document.getElementById('accordeon').style.marginTop=50+window.pageYOffset+"px";	
		}
		
		
		function dernierElement2()
		{
			  var Conteneur = document.getElementById('contenu'), n = 0;
			  if(Conteneur)
			  {
				var elementID = '', elementNo;
				if(Conteneur.childNodes.length > 0)
				{
					var i = 0;
				  while(elementID != 'foot_panier')
				    {
					// Ici, on vérifie qu'on peut récupérer les attributs, si ce n'est pas possible, on renvoit false, sinon l'attribut
						elementID = (Conteneur.childNodes[i].getAttribute) ? Conteneur.childNodes[i].getAttribute('id') : false;
						i++;
					}
				  }
				}
			  return i-1;
		}
		
		function alreadyIn(idprod){
			var Conteneur = document.getElementById('contenu'), n = 0;
			  if(Conteneur)
			  {
				var elementID, elementNo;
				if(Conteneur.childNodes.length > 0)
				{
				  for(var i = 0; i < Conteneur.childNodes.length; i++)
				  {
					// Ici, on vérifie qu'on peut récupérer les attributs, si ce n'est pas possible, on renvoit false, sinon l'attribut
					elementID = (Conteneur.childNodes[i].getAttribute) ? Conteneur.childNodes[i].getAttribute('id') : false;
					if(elementID == ("panier_elem_"+idprod))
					{
						return i;
					}
				  }
				}
			  }
			  return -1;
		}
		
		function suppElem(idprod){
			var elem = document.getElementById('panier_elem_'+idprod);
			elem.parentNode.removeChild(elem);
			calTotal();
			xhr = getXMLHttpRequest();
			xhr.open("POST", "include/invite/modifpanier.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("id="+idprod);
		}
		
		function calTotal(){
			var Conteneur = document.getElementById('contenu'),somme = 0.00;
			if(Conteneur)
			  {
				var elementID, elementNo;
				
				if(Conteneur.childNodes.length > 0)
				{
				  for(var i = 0; i < Conteneur.childNodes.length; i++)
				  {
					// Ici, on vérifie qu'on peut récupérer les attributs, si ce n'est pas possible, on renvoit false, sinon l'attribut
					elementID = (Conteneur.childNodes[i].getAttribute) ? Conteneur.childNodes[i].getAttribute('id') : false;
					if(elementID)
					{
						var elementPattern=new RegExp("panier_elem_([0-9]*)","g");
						elementNo = parseInt(elementID.replace(elementPattern, '$1'));
						if(!isNaN(elementNo))
						{
							somme += parseFloat(document.getElementById('panier_elem_prix_'+elementNo).innerHTML.replace("€",""))*parseInt(document.getElementById('panier_elem_qte_'+elementNo).innerHTML.replace("x",""));
						}
					}
				  }
				}
			  }
			  document.getElementById('prix_tt_panier').innerHTML = Math.round(somme*100)/100;
		}
		
		function ajoutpanier(idprod) {
			var isIn = alreadyIn(idprod);
			var cont = document.getElementById('contenu');
			
			if(isIn == -1)
			{
				var nouvelem = document.createElement('div');
				var last = dernierElement2();
				var foot = cont.childNodes[last];
				
				cont.removeChild(cont.childNodes[last]);
				
				var prix = document.getElementById('prix'+idprod).value;
				var nom = document.getElementById('name'+idprod).value;
				var qte = document.getElementById('qte'+idprod).value;
				
				document.getElementById('qte'+idprod).value = qte;
				
				nouvelem.setAttribute('id','panier_elem_'+idprod);
				nouvelem.innerHTML = '<table style="width:100%"><tr><td colspan="2" id="panier_elem_nom_'+idprod+'">'+nom+'</td><td id="panier_elem_qte_'+idprod+'">x'+qte+'</td><td id="panier_elem_prix_'+idprod+'">'+prix+'€</td><td onclick="suppElem('+idprod+');" style="color:red;cursor: pointer;" id="panier_elem_supp_'+idprod+'">X</td></tr></table>';
				
				cont.appendChild(nouvelem);
				
				cont.appendChild(foot);
			}
			else//elem deja existant
			{
				var elem = cont.childNodes[isIn];
				var qte = parseInt(document.getElementById('panier_elem_qte_'+idprod).innerHTML.replace("x","")) + parseInt(document.getElementById('qte'+idprod).value);
				var prix = parseFloat(document.getElementById('panier_elem_prix_'+idprod).innerHTML.replace("€",""));
				var nom= document.getElementById('panier_elem_nom_'+idprod).innerHTML;

				document.getElementById('qte_h'+idprod).value = qte;
				elem.innerHTML = '<table style="width:100%"><tr><td colspan="2" id="panier_elem_nom_'+idprod+'">'+nom+'</td><td style="float:left; margin-left:30px;" id="panier_elem_qte_'+idprod+'">x'+qte+'</td><td style="float:right; margin-right:15px;" id="panier_elem_prix_'+idprod+'">'+prix+'€</td><td onclick="suppElem('+idprod+');" style="color:red;cursor: pointer;" id="panier_elem_supp_'+idprod+'">X</td></tr></table>';
			}
			
			calTotal();
			$( "#accordeon" ).accordion( "option", "active", 0 );
			
			xhr = getXMLHttpRequest();
			
			xhr.open("POST", "include/invite/modifpanier.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("id="+idprod+"&nom="+nom+"&prix="+prix+"&qte="+qte);
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
		
		function viderPanier(){
			var Conteneur = document.getElementById('contenu');
			if(Conteneur)
			  {
				var elementID, elementNo;
				
				if(Conteneur.childNodes.length > 0)
				{
				  for(var i = 0; i < Conteneur.childNodes.length; i++)
				  {
					// Ici, on vérifie qu'on peut récupérer les attributs, si ce n'est pas possible, on renvoit false, sinon l'attribut
					elementID = (Conteneur.childNodes[i].getAttribute) ? Conteneur.childNodes[i].getAttribute('id') : false;
					if(elementID)
					{
						var elementPattern=new RegExp("panier_elem_([0-9]*)","g");
						elementNo = parseInt(elementID.replace(elementPattern, '$1'));
						if(!isNaN(elementNo))
						{
							suppElem(elementNo);
						}
					}
				  }
				}
			  }
			document.getElementById('prix_tt_panier').innerHTML = '0.00';
		}
	</script>
<?php
	if(!isset($_GET['mode']))
	{
		$_GET['mode'] = 'view';
	}

	require_once('./connexionbddplugit.class.php');
	
	switch($_GET['mode'])
	{	
		case 'view' :
		
			if(!isset($_GET['categ']))
			{
				$rq = connexionbddplugit::getInstance()->query("SELECT nom FROM categorie");
				$rq = $rq->fetch();
				$_GET['categ'] = $rq['nom'];
			}
			
			$nomcateg = $_GET['categ'];

			try{
				$rq = connexionbddplugit::getInstance()->query("SELECT COUNT(nom) AS nombre FROM categorie WHERE nom = '$nomcateg'");
				$rq = $rq->fetch();
			} catch ( Exception $e ) {
				echo "Une erreur est survenue : ".$e->getMessage();
			}

			if($rq['nombre'] >= 1)
			{
				try{
					$rq = connexionbddplugit::getInstance()->query("SELECT * FROM produit WHERE categorie = '$nomcateg' ORDER BY priorite DESC");
					$ar=$rq->fetch();
				} catch ( Exception $e ) 
				{
					echo "Une erreur est survenue : ".$e->getMessage();
				}

			
				echo '<h4>'.strtoupper($_GET['categ']).'</h4>'

			?>
				
				
				<div id="accordeon"> <!-- Bloc principal, sur lequel nous appellerons le plugin PANIER-->
					<h3><img src="./images/e_commerce_caddie.gif" style="width:20px; height:20px; vertical-align:-18%;"/>Panier</h3>
					<div id="contenu">
						<div id="top_panier"><table style="width:100%"><tr><td colspan="2">Nom</td><td style="float:left; margin-left:60px;">Qté</td><td style="float:right; margin-right:30px;">Prix Unitaire</td></tr></table></div>
						<div id="div_panier"><hr/></div>
						<?php
						
						if(isset($_SESSION['caddie']))
						{
							foreach($_SESSION['caddie'] as $article)
							{
								echo '<div id="panier_elem_'.$article['id'].'"><table style="width:100%"><tr><td colspan="2" id="panier_elem_nom_'.$article['id'].'">'.$article['nom'].'</td><td style="float:left; margin-left:30px;" id="panier_elem_qte_'.$article['id'].'">x'.$article['qte'].'</td><td style="float:right; margin-right:15px;" id="panier_elem_prix_'.$article['id'].'">'.$article['prix'].'€</td><td onclick="suppElem('.$article['id'].');" style="color:red;cursor: pointer;" id="panier_elem_supp_'.$article['id'].'">X</td></tr></table></div>';
							}
						}	
						
						?>
						<div id="foot_panier"><span style="float:left; margin-left:5px;">Montant total : 
							<span id="prix_tt_panier">
								<?php
									echo (isset($_SESSION['caddieTot'])) ? $_SESSION['caddieTot']:'0.00';		
								?>
								</span>
							€</span>
							
							<div style="float:right; margin-right:5px;">
								<span class="bt" onclick="viderPanier();" style="cursor:pointer;">Vider</span>
								-
								<a class="bt" href="index.php?page=paiement_final">Payer</a>
							</div>
						</div>
					</div>
				</div>
				
				 <script>
					//calTotal();
					$(function(){
						$('#accordeon').accordion(); // appel du plugin	
						$('#accordeon').accordion({
							event : 'click',
							collapsible : true,
							active : 1
						});
					});
		
					window.onscroll = scroll;
				 </script>
			<?php
				
				$i=1; //délimite les colonnes
				$j=1; //délimite les lignes
				
				echo'<div style="margin:auto;width:1000px;">';
					
				if(isset($_SESSION['id']))
				{
					echo '<br/><div style="margin-left:auto; margin-right:auto;" class="menuverti" onclick="location.href=\'index.php?page=admin_boutique\'">Ajouter un produit</div>';
				}
				
				if(!empty($ar))
				{
					try
					{
						$rq = connexionbddplugit::getInstance()->query("SELECT * FROM produit WHERE categorie = '$nomcateg' ORDER BY priorite DESC");

						echo '<table cellspacing="20">';
						while($ar=$rq->fetch())
						{
							
							if($i == 1)
								echo '<tr>';
								
								echo '<td>
								<div class="blockproduit" onclick="location.href=\'index.php?page=boutique&mode=viewone&id='.$ar['id'].'\'"> '; 
								
								if(isset($_SESSION['id']))
								{
									echo'
									<span style="margin-left:10%;"><a class="bt" href="index.php?page=admin_boutique&mode=modifier&id='.$ar['id'].'">Modifier</a> - 
									<a class="bt" href="traitement/trt_boutique.php?mode=delete&id='.$ar['id'].'">Supprimer</a></span>';
								}
								
								echo'
									<img src="'.$ar['images'].'" style="margin-left:5%;width:90%;" width="280" height="170"/>
								</div><span id="'.$ar['id'].'" class="boutprod" style="float:left;" onclick="ajoutpanier('.$ar['id'].');">Ajouter au panier </span><span class="boutprod2" style="float:left;"><select name="qte'.$ar['id'].'" id="qte'.$ar['id'].'">';
								
								for($k=1;$k<=10;$k++)
								{
									echo '<option value='.$k.'>'.$k.'</option>';
								}
								echo '</span>';
								
								echo '<input type="hidden" id="name'.$ar['id'].'" value="'.$ar['nom'].'"/>
								<input type="hidden" id="qte_h'.$ar['id'].'" value="0"/>
								<input type="hidden" id="prix'.$ar['id'].'" value="'.$ar['prix'].'"/>';
								
								echo '</td>';
								
								$i++;
								if($i > 2)
								{
									$i=1;
									$j++;
									echo '</tr>';
								}
						}

						echo '</table>';
						
					} 
					catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}
				}
				else
				{
					echo '<br/><span style="font-weight:bold; font-size:20px; width:300px; margin:auto;">Aucun produit existant</span>';
				}
				echo '</div>';
			}
			else
			{
				echo '<h1>Catégorie Inexistante</h1>';
			}
		break;
		
		case 'viewone' :
		if(isset($_GET['id']))
			{
				try{
					$retour = connexionbddplugit::getInstance()->query("SELECT count(id) as cpt FROM produit WHERE id='".$_GET["id"]."'");
					$donnees = $retour->fetch();
				} catch ( Exception $e ) {
					echo "Une erreur est survenue : ".$e->getMessage();
				}
				if($donnees['cpt'] == 1)
				{
					//affichage
					try{
						$retour = connexionbddplugit::getInstance()->query("SELECT * FROM produit WHERE id='".$_GET['id']."'") ;
						$donnees = $retour->fetch();
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}
			
					echo '<div style="margin:auto;width:70%;">
							<h2>'.$donnees['nom'].'</h2>
							<hr/>
							<img src="'.$donnees['images'].'" style="float:right;" width="280" height="170" />
							'.nl2br($donnees['desc']);
							
					$j=mb_substr_count(nl2br($donnees['desc']),'<br />');

					for($i=15-$j;$i>0;$i--)
					{
						echo '<br/>';
					}
					
					
					echo '</div>';
					
				}
				else
					echo '<p>Erreur</p>';
			}
			else
				echo '<p>Erreur</p>';	
		break;
		
		default :
		echo '<h2>Page inexistante</h2>';
		break;
	}
	
?>