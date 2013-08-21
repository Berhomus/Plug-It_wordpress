<!--<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />-->
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
 

<script type="text/javascript">

//Amélio => évité calcul montant total via parcour=> récupérer var session ?
	
		function scroll () {
			document.getElementById('accordeon').style.marginTop=25+window.pageYOffset+"px";	
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
				
				if(!isNaN(qte))
				{
					document.getElementById('qte'+idprod).value = qte;
					
					nouvelem.setAttribute('id','panier_elem_'+idprod);
					nouvelem.innerHTML = '<table style="width:100%"><tr><td style="width:110px;" id="panier_elem_nom_'+idprod+'"><a class="bt" href="index.php?page=boutique&mode=viewone&id='+idprod+'">'+nom.substr(0,13)+'</a></td><td style="width:40px;" id="panier_elem_qte_'+idprod+'">x'+qte+'</td><td style="width:75px;float:right;" id="panier_elem_prix_'+idprod+'">'+prix+'€</td><td onclick="suppElem('+idprod+');" style="color:red;cursor: pointer;" id="panier_elem_supp_'+idprod+'">X</td></tr></table>';
					
					cont.appendChild(nouvelem);
					
					cont.appendChild(foot);
				}
				else
				{
					document.getElementById('qte'+idprod).value = 1;
					var error =1;
				}
			}
			else//elem deja existant
			{
				var elem = cont.childNodes[isIn];
				var qte_toadd = parseInt(document.getElementById('qte'+idprod).value);
				if(!isNaN(qte_toadd))
				{
					var qte_act = parseInt(document.getElementById('panier_elem_qte_'+idprod).innerHTML.replace("x",""));
					var prix = parseFloat(document.getElementById('panier_elem_prix_'+idprod).innerHTML.replace("€",""));
					var nom = document.getElementById('name'+idprod).value;
					var qte = (qte_act + qte_toadd);
					elem.innerHTML = '<table style="width:100%"><tr><td style="width:110px;" id="panier_elem_nom_'+idprod+'"><a class="bt" href="index.php?page=boutique&mode=viewone&id='+idprod+'">'+nom.substr(0,13)+'</a></td><td style="float:left; width:40px;" id="panier_elem_qte_'+idprod+'">x'+qte+'</td><td style="float:right; width:75px;" id="panier_elem_prix_'+idprod+'">'+prix+'€</td><td onclick="suppElem('+idprod+');" style="color:red;cursor: pointer;" id="panier_elem_supp_'+idprod+'">X</td></tr></table>';
				}
				else
				{
					document.getElementById('qte'+idprod).value = 1;
					var error =1;
				}
			}
			
			if(error != 1)
			{
				calTotal();
				$( "#accordeon" ).accordion( "option", "active", 0 );
				
				xhr = getXMLHttpRequest();
				
				xhr.open("POST", "include/invite/modifpanier.php", true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.send("id="+idprod+"&nom="+nom+"&prix="+prix+"&qte="+qte);
			}
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
		
		
		function checkpanier(link){
			if(parseFloat(document.getElementById('prix_tt_panier').innerHTML) <= 0.009)
			{
				alert("Panier Vide !");
				link.href="#";
			}
			else
			{
				link.href="index.php?page=paiement_final";
			}
		}
		
		$(function() {

		  var elementID, elementNo;
		  var liste = document.getElementsByTagName('input');
		  for (var i = 0; i < liste.length; i++) { 
			elementID = (liste[i].getAttribute) ? liste[i].getAttribute('id') : false;
			if(elementID)
			{
				var elementPattern=new RegExp("qte([0-9]*)","g");
				elementNo = parseInt(elementID.replace(elementPattern, '$1'));
				if(!isNaN(elementNo))
				{
					$( "#qte"+elementNo ).spinner({ min: 1 });
				}
			}
		  }
		});
	</script>
<?php

	function lignelimit($text, $nbre)
	{
		$text = nl2br($text);
		$nbre_ligne = preg_split("<<br */?>>",$text );
		$n="";
		$i;
		for($i=0;$i<$nbre;$i++)
		{
			$n.=($nbre_ligne[$i]."<br/>");
		}

		if(count($nbre_ligne)>$nbre)
			return ($n." ...Lire La Suite...");
		else
			return $n;
	}

	if(!isset($_GET['mode']))
	{
		$_GET['mode'] = 'view';
	}

	require_once('./connexionbddplugit.class.php');
	$bdd=connexionbddplugit::getInstance();
	switch($_GET['mode'])
	{	
		case 'view' :
			echo '<h2>Boutique en Ligne</h2>';
			$rq1 = connexionbddplugit::getInstance()->query("SELECT id FROM menu WHERE baseName='boutique'");
			$ar1 = $rq1->fetch();
			
			if(!isset($_GET['categ']))
			{	
				$rq2 = connexionbddplugit::getInstance()->query("SELECT nom FROM sousmenu WHERE menu='".$ar1['id']."' ORDER BY position DESC LIMIT 0,1");
				$ar2 = $rq2->fetch();
				$_GET['categ'] = $ar2['nom'];
			}
			
			$nomcateg = strtoupper($_GET['categ']);

			try{
				$rq3 = $bdd->prepare("SELECT * FROM sousmenu WHERE upper(nom) = ? AND menu=?");
				$rq3->execute(array($nomcateg,$ar1['id']));
				$ar3 = $rq3->fetch();
				$idcateg = $ar3['id'];
			} catch ( Exception $e ) {
				echo "Une erreur est survenue : ".$e->getMessage();
			}

			if($rq3->rowCount() >= 1)
			{
				try{
					$rq = $bdd->prepare("SELECT * FROM produit WHERE categorie = ? ORDER BY priorite DESC");
					$rq->execute(array($idcateg));
					$ar=$rq->fetch();
				} catch ( Exception $e ) 
				{
					echo "Une erreur est survenue : ".$e->getMessage();
				}

			
				echo '<p style="margin-bottom:10px; margin-top:10px; font-weight:bold; text-align:center;">'.$ar3['nom'].'</p>'

			?>
				<div id="accordeon"> <!-- Bloc principal, sur lequel nous appellerons le plugin PANIER-->
					<h3><img src="./images/e_commerce_caddie.gif" style="width:20px; height:20px; vertical-align:-18%;"/>Panier</h3>
					<div id="contenu">
						<div id="top_panier"><table style="width:100%"><tr><td style="width:110px;">Nom</td><td style="float:left; width:40px;">Qté</td><td style="float:right; width:90px;">Prix Unitaire</td></tr></table></div>
						<div id="div_panier"><hr/></div>
						<?php
						
						if(isset($_SESSION['caddie']))
						{
							$articlechange = 0;
							foreach($_SESSION['caddie'] as $article)
							{
							
								try{
									$rq = $bdd->prepare("SELECT * FROM produit WHERE id=?");
									$rq->execute(array($article['id']));
									$ar=$rq->fetch();
									
									
									if($rq->rowCount() == 1)
									{
										if($ar['tva'] == -1 or $ar['categorie'] == -1)//si rebut
										{
											$_SESSION['caddieTot'] -= $_SESSION['caddie'][$article['id']]['prix']*$_SESSION['caddie'][$article['id']]['qte'];
											unset($_SESSION['caddie'][$article['id']]);
											$articlechange = 2;
										}
										else
										{
											$rqtva = $bdd->prepare("SELECT * FROM tva WHERE id=?");
											$rqtva->execute(array($ar['tva']));
											$artva=$rqtva->fetch();
											if(abs($article['prix']-(round($ar['prix']*(($artva['valeur']/100)+1)*100)/100)) > 0.009)//si prix changé
											{
												echo '<div id="panier_elem_'.$article['id'].'"><table style="width:100%"><tr><td style="width:110px;" id="panier_elem_nom_'.$article['id'].'"><a class="bt" href="index.php?page=boutique&mode=viewone&id='.$article['id'].'">'.substr($article['nom'],0,13).'</a></td><td style="float:left; width:40px;" id="panier_elem_qte_'.$article['id'].'">x'.$article['qte'].'</td><td style="float:right; width:75px;color:red;font-weight:bold;" id="panier_elem_prix_'.$article['id'].'" >'.(round($ar['prix']*(($artva['valeur']/100)+1)*100)/100) .'€</td><td onclick="suppElem('.$article['id'].');" style="color:red;cursor: pointer;" id="panier_elem_supp_'.$article['id'].'">X</td></tr></table></div>';
												
												//redef panier
												$_SESSION['caddieTot'] -= $_SESSION['caddie'][$article['id']]['prix']*$_SESSION['caddie'][$article['id']]['qte'];
												$_SESSION['caddie'][$article['id']]['prix'] = (round($ar['prix']*(($artva['valeur']/100)+1)*100)/100);
												$_SESSION['caddieTot'] += $_SESSION['caddie'][$article['id']]['prix']*$_SESSION['caddie'][$article['id']]['qte'];
												
												
												if($articlechange == 2)
													$articlechange = 3;
												else if($articlechange == 0)
													$articlechange = 1;
											}
											else
											{
												echo '<div id="panier_elem_'.$article['id'].'"><table style="width:100%"><tr><td style="width:110px;" id="panier_elem_nom_'.$article['id'].'"><a class="bt" href="index.php?page=boutique&mode=viewone&id='.$article['id'].'">'.substr($article['nom'],0,13).'</a></td><td style="float:left; width:40px;" id="panier_elem_qte_'.$article['id'].'">x'.$article['qte'].'</td><td style="float:right; width:75px;" id="panier_elem_prix_'.$article['id'].'" >'.round($article['prix']*100)/100 .'€</td><td onclick="suppElem('.$article['id'].');" style="color:red;cursor: pointer;" id="panier_elem_supp_'.$article['id'].'">X</td></tr></table></div>';
											}
										}
									}	
									else//si article inexistant
									{
										//enlever panier
										$_SESSION['caddieTot'] -= $_SESSION['caddie'][$article['id']]['prix']*$_SESSION['caddie'][$article['id']]['qte'];
										unset($_SESSION['caddie'][$article['id']]);
										
										if($articlechange == 1)
											$articlechange = 3;
										else if($articlechange == 0)
											$articlechange = 2;
									}
								} catch ( Exception $e ) 
								{
									echo "Une erreur est survenue : ".$e->getMessage();
								}
														
							}
							
							if($articlechange == 1)
							{
								echo '<script>
										alert("Attention le prix de certains articles ont changé !");
									</script>';
							}
							else if($articlechange == 2)
							{
								echo '<script>
										alert("Attention certains articles ne sont pas disponible !");
									</script>';
							}
							else if($articlechange == 3)
							{
								echo '<script>
										alert("Attention certains articles n\'existe plus et d\'autres ont changé de prix !");
									</script>';
							}
						}	
						
						?>
						<div id="foot_panier"><span style="float:left; margin-left:5px;">Montant total : 
							<span id="prix_tt_panier">
								<?php
									$tot = (isset($_SESSION['caddieTot'])) ? $_SESSION['caddieTot']:'0.00';	
									echo round($tot*100)/100;
								?>
								</span>
							€</span>
							
							<div style="float:right; margin-right:5px;">
								<a class="bt" onclick="checkpanier(this);" href="index.php?page=paiement_final">Payer</a>
							</div>
						</div>
					</div>
				</div>
				
				 
			<?php
				
				$i=1; //délimite les colonnes
				$j=1; //délimite les lignes
				
				echo'<div style="margin:auto; margin-bottom:20px; width:990px; border:4px solid;border-radius:15px; border-color:#DCDCDC #696969 #696969 #DCDCDC;">';
					
				if(isset($_SESSION['id']))
				{
					echo '<br/><div style="margin-left:auto; margin-right:auto;" class="menuverti" onclick="location.href=\''.$_SESSION['protocol'].$_SESSION['current_loc'].'index.php?page=admin_boutique\'">Ajouter un produit</div>';
				}
				
				try
				{
					$rq = $bdd->prepare("SELECT * FROM produit WHERE categorie = ? AND tva <> ? ORDER BY priorite DESC");
					$rq->execute(array($idcateg,-1));
				} catch ( Exception $e ) {
					echo "Une erreur est survenue : ".$e->getMessage();
				}
					
				if($rq->rowCount()>0)
				{
					
						
	
					echo '<table id="liste_article" cellspacing="20">';
					while($ar=$rq->fetch())
					{
						$rq2 = $bdd->prepare("SELECT valeur FROM tva WHERE id=?");
						$rq2->execute(array($ar['tva']));
						$tva = $rq2->fetch();
						
						if($i == 1)
							echo '<tr>';
							
							echo '<td style="padding-bottom:10px;">
							<div class="blockproduit" onclick="location.href=\'index.php?page=boutique&mode=viewone&id='.$ar['id'].'\'"> '; 
							echo '<table style="margin-left:4px; margin-right:4px;">
									<tr>
										<td style="width:325px;"></td>
										<td style="width:325px;"><span style="text-decoration:underline; font-weight:bold;">'.substr($ar['nom'],0,35).'</span></td>
									</tr>';
							if(isset($_SESSION['id']))
							{
								echo'
								<tr>
									<td style="width:325px;"><span style="margin-left:18px;"><a class="bt" href="'.$_SESSION['protocol'].$_SESSION['current_loc'].'index.php?page=admin_boutique&mode=modifier&id='.$ar['id'].'">Modifier</a> - 
									<a class="bt" href="'.$_SESSION['protocol'].$_SESSION['current_loc'].'traitement/trt_boutique.php?mode=delete&id='.$ar['id'].'&categ='.$idcateg.'">Supprimer</a></span></td>
								</tr>';
							}
							
							echo'
							<tr>
								<td style="width:325px; height:210px;"><img src="'.$ar['images'].'" style="margin-left:18px; max-height:100%; width:auto; max-width:210px;"/></td>
								<td style="width:325px; height:210px;">'.(lignelimit($ar['description'],10)).'</td>
							</tr>
							
							<tr>
								<td style="width:325px;"><span style="margin-left:18px;"><b>Livraison sous <span style="color:green;">'.$ar['delai'].' heures</span></b></span></td>
								<td style="width:325px;"><b> Hors Taxes : <span style="color:#111;">'.(round($ar['prix']*100)/100).'</span> € </b></td>
							</tr>
							
							</table>
							</div>
							
							<div style="margin-left:10px;">
								<span id="'.$ar['id'].'" class="style" style="float:left; width:450px; border-radius: 0px 0px 0px 50px;" onclick="ajoutpanier('.$ar['id'].');">Ajouter au panier </span>
								<span class="style" style="float:left; width:172px; border-radius: 0px 0px 50px 0px;"><input size="2" name="qte'.$ar['id'].'" id="qte'.$ar['id'].'" value="1"/></span>
							</div>';
							
							echo '<input type="hidden" id="name'.$ar['id'].'" value="'.$ar['nom'].'"/>
							<input type="hidden" id="prix'.$ar['id'].'" value="'.(round($ar['prix']*(($tva['valeur']/100)+1)*100)/100).'"/>';
							
							echo '</td>';
							
							$i++;
							if($i > 1)
							{
								$i=1;
								$j++;
								echo '</tr>';
							}
					}

					echo '</table>';
				}
				else
				{
					echo '<br/><span style="font-weight:bold; font-size:20px; width:300px; margin-left:50px;">Aucun produit existant</span>';
				}
				echo '</div>';
			}
			else
			{
				echo '<h1>Catégorie Inexistante</h1>';
			}
		?>

		<?php
		break;
		
		case 'viewone' :
		
		$rqtva = $bdd->prepare("SELECT * FROM tva WHERE id=?");
		$rqtva->execute(array($ar['tva']));
		$artva=$rqtva->fetch();
		
		if(isset($_GET['id']))
			{
				try{
					$retour = $bdd->prepare("SELECT count(id) as cpt FROM produit WHERE id=? AND categorie <> ? AND tva <> ?");
					$retour->execute(array($_GET['id'],-1,-1));
					$donnees = $retour->fetch();
				} catch ( Exception $e ) {
					echo "Une erreur est survenue : ".$e->getMessage();
				}
				if($donnees['cpt'] == 1)
				{
					//affichage
					try{
						$retour = $bdd->prepare("SELECT * FROM produit WHERE id=?");
						$retour->execute(array($_GET['id']));
						$donnees = $retour->fetch();
					} catch ( Exception $e ) {
						echo "Une erreur est survenue : ".$e->getMessage();
					}
			
					echo '<p class="grdtitre" style="width:990px; height:30px; font-weight:bold; text-align:center; line-height:30px; margin-bottom:20px; border-radius:40px;">'.$donnees['nom'].'</p>
						<div style="margin:auto; padding-top:15px; padding-bottom:15px; width:990px; border:4px solid;border-radius:15px; border-color:#DCDCDC #696969 #696969 #DCDCDC;">';
							?>
								<div id="accordeon" style=""> <!-- Bloc principal, sur lequel nous appellerons le plugin PANIER-->
									<h3><img src="./images/e_commerce_caddie.gif" style="width:20px; height:20px; vertical-align:-18%;"/>Panier</h3>
									<div id="contenu">
										<div id="top_panier"><table style="width:100%"><tr><td style="width:110px;">Nom</td><td style="float:left; width:40px;">Qté</td><td style="float:right; width:90px;">Prix Unitaire</td></tr></table></div>
										<div id="div_panier"><hr/></div>
										<?php
										
										if(isset($_SESSION['caddie']))
										{
											$articlechange = 0;
											foreach($_SESSION['caddie'] as $article)
											{
											
												try{
													$rq = $bdd->prepare("SELECT * FROM produit WHERE id=?");
													$rq->execute(array($article['id']));
													$ar=$rq->fetch();
													
													
													if($rq->rowCount() == 1)
													{
														if($ar['tva'] == -1 or $ar['categorie'] == -1)//si rebut
														{
															$_SESSION['caddieTot'] -= $_SESSION['caddie'][$article['id']]['prix']*$_SESSION['caddie'][$article['id']]['qte'];
															unset($_SESSION['caddie'][$article['id']]);
															$articlechange = 2;
														}
														else
														{
															$rqtva = $bdd->prepare("SELECT * FROM tva WHERE id=?");
															$rqtva->execute(array($ar['tva']));
															$artva=$rqtva->fetch();
															if(abs($article['prix']-(round($ar['prix']*(($artva['valeur']/100)+1)*100)/100)) > 0.009)//si prix changé
															{
																echo '<div id="panier_elem_'.$article['id'].'"><table style="width:100%"><tr><td style="width:110px;" id="panier_elem_nom_'.$article['id'].'"><a class="bt" href="index.php?page=boutique&mode=viewone&id='.$article['id'].'">'.substr($article['nom'],0,13).'</a></td><td style="float:left; width:40px;" id="panier_elem_qte_'.$article['id'].'">x'.$article['qte'].'</td><td style="float:right; width:75px;color:red;font-weight:bold;" id="panier_elem_prix_'.$article['id'].'" >'.(round($ar['prix']*(($artva['valeur']/100)+1)*100)/100) .'€</td><td onclick="suppElem('.$article['id'].');" style="color:red;cursor: pointer;" id="panier_elem_supp_'.$article['id'].'">X</td></tr></table></div>';
																
																//redef panier
																$_SESSION['caddieTot'] -= $_SESSION['caddie'][$article['id']]['prix']*$_SESSION['caddie'][$article['id']]['qte'];
																$_SESSION['caddie'][$article['id']]['prix'] = (round($ar['prix']*(($artva['valeur']/100)+1)*100)/100);
																$_SESSION['caddieTot'] += $_SESSION['caddie'][$article['id']]['prix']*$_SESSION['caddie'][$article['id']]['qte'];
																
																
																if($articlechange == 2)
																	$articlechange = 3;
																else if($articlechange == 0)
																	$articlechange = 1;
															}
															else
															{
																echo '<div id="panier_elem_'.$article['id'].'"><table style="width:100%"><tr><td style="width:110px;" id="panier_elem_nom_'.$article['id'].'"><a class="bt" href="index.php?page=boutique&mode=viewone&id='.$article['id'].'">'.substr($article['nom'],0,13).'</a></td><td style="float:left; width:40px;" id="panier_elem_qte_'.$article['id'].'">x'.$article['qte'].'</td><td style="float:right; width:75px;" id="panier_elem_prix_'.$article['id'].'" >'.round($article['prix']*100)/100 .'€</td><td onclick="suppElem('.$article['id'].');" style="color:red;cursor: pointer;" id="panier_elem_supp_'.$article['id'].'">X</td></tr></table></div>';
															}
														}
													}	
													else//si article inexistant
													{
														//enlever panier
														$_SESSION['caddieTot'] -= $_SESSION['caddie'][$article['id']]['prix']*$_SESSION['caddie'][$article['id']]['qte'];
														unset($_SESSION['caddie'][$article['id']]);
														
														if($articlechange == 1)
															$articlechange = 3;
														else if($articlechange == 0)
															$articlechange = 2;
													}
												} catch ( Exception $e ) 
												{
													echo "Une erreur est survenue : ".$e->getMessage();
												}
																		
											}
											
											if($articlechange == 1)
											{
												echo '<script>
														alert("Attention le prix de certains articles ont changé !");
													</script>';
											}
											else if($articlechange == 2)
											{
												echo '<script>
														alert("Attention certains articles ne sont pas disponible !");
													</script>';
											}
											else if($articlechange == 3)
											{
												echo '<script>
														alert("Attention certains articles n\'existe plus et d\'autres ont changé de prix !");
													</script>';
											}
										}	
										
										?>
										<div id="foot_panier"><span style="float:left; margin-left:5px;">Montant total : 
											<span id="prix_tt_panier">
												<?php
													$tot = (isset($_SESSION['caddieTot'])) ? $_SESSION['caddieTot']:'0.00';	
													echo round($tot*100)/100;
												?>
												</span>
											€</span>
											
											<div style="float:right; margin-right:5px;">
												<a class="bt" onclick="checkpanier(this);" href="index.php?page=paiement_final">Payer</a>
											</div>
										</div>
									</div>
								</div>
							<div style="margin:auto;width:90%;">
							<?php
							$rqtva = $bdd->prepare("SELECT * FROM tva WHERE id=?");
							$rqtva->execute(array($donnees['tva']));
							$artva=$rqtva->fetch();
								echo '<table>
										<tr>
											<td style="width:250px;"><img src="'.$donnees['images'].'" style="max-height:100%; width:auto; max-width:250px;" /></td>
											<td style="width:15px;"></td>
											<td>'.nl2br($donnees['description']).'</td>
										</tr>';
								echo '
									<tr>
										<td style="width:250px;"><b>Livraison sous <span style="color:green;">'.$donnees['delai'].' heures</span></b></td>
										<td style="width:15px;"></td>';
								echo '	<td><b> Hors Taxes : <span style="color:#111;">'.(round($donnees['prix']*100)/100).'</span> € </b></td>
									</tr>';
								?>								
							<?php
							echo '<tr style="height:80px;">
									<td><span id="'.$donnees['id'].'" class="style" onclick="ajoutpanier('.$donnees['id'].');">Ajouter au panier </span></td>
									<td><span class="style" style="width:70px;"><input size="1" name="qte'.$donnees['id'].'" id="qte'.$donnees['id'].'" value="1"/></span></td>
									<td><a href="javascript:history.back()" class="style" style="width:200px;">Retour</a></td>
								</tr>';
							echo '</table>';
							echo '<input type="hidden" id="name'.$donnees['id'].'" value="'.$donnees['nom'].'"/>
							<input type="hidden" id="prix'.$donnees['id'].'" value="'.(round($donnees['prix']*(($artva['valeur']/100)+1)*100)/100).'"/>';
							?>
							</div>
						</div>
				<?php	
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
