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

/*####FONCTION LIMITATION DE CARACTERES####*/

function textLimit(field, maxlen, idlimite) 
{
   if (field.value.length > maxlen)
   {
      field.value = field.value.substring(0, maxlen);
      alert('Dépassement de la limite de caractères');
	  idlimite.style.color='red';
	  setTimeout(function(){idlimite.style.color='green';},2000);
   }
   else if((maxlen > field.value.length) && (field.value.length > 0))
   {
	  setTimeout(function(){idlimite.style.color='green';},2000);
   }
   
}

function textLimit2(field, maxlen, idlimite) {
	if (field.value.length != maxlen) {
		field.value = "";
		idlimite.style.color='red';
	}
	else
	{
		idlimite.style.color='green';
	}
} 

function textLimit3(field, idlimite) 
{
	var nbr_ligne = field.innerHTML.split("<br>" ).length 
	var n = "";
   if (nbr_ligne > 3)
   {
      var ligne =  field.innerHTML.split("<br>" );
	  var i;
	  n = ligne[0];
	  for(i=1;i<3;i++)
	  {
		 n += "<br>" + ligne[i];
	  }
	  field.innerHTML = n;
      alert('Dépassement de la limite ligne');
	  idlimite.style.color='red';
	  setTimeout(function(){idlimite.style.color='green';},2000);
   }
}


/*####FONCTION LIEN####*/

function lien()
{
 // Pas de sélection, donc on demande l'URL et le libelle
		var URL = prompt("Quelle est l'url ?") || "";
		var label = prompt("Quel est le libellé du lien ?") || "";
		document.execCommand('insertHTML', false, '<a class="mail" href="'+URL+'">'+label+'</a>');
		document.getElementById('ortf').focus();
}

/*####FONCTION TITRE####*/

function titre()
{	
	document.execCommand('bold', false, '');
	document.execCommand('FontSize', false, '3');
	document.getElementById('ortf').focus(); 
}

/*####FONCTION IMAGE####*/

function img()
{
	var img = prompt("Quel est le chemin de l'image ?\nExemple : /images/nom_de_l_image.png\nPour les images en locales, sinon chemin absolu.");
	document.execCommand('insertHTML', false, '<img src="'+img+'" />');
	document.getElementById('ortf').focus();
}

/*####SERT A ACTIVER LES BALISES HTML POUR LA BDD####*/

/*try {
	Editor.execCommand("styleWithCSS", 0, false);
} catch (e) {
	try {
		Editor.execCommand("useCSS", 0, true);
	} catch (e) {
		try {
			Editor.execCommand('styleWithCSS', false, false);
		}
		catch (e) {
		}
	}
}*/

/*####FONCTION VERIF MAIL####*/

function isEmail(adr, id){
     // étape consistant à définir l'expression régulière d'une adresse email
     var regEmail = new RegExp('^[0-9a-z._-]+@{1}[0-9a-z.-]{2,}[.]{1}[a-z]{2,5}$','i');

     if(regEmail.test(adr.value))
	 {
		id.style.color='green';
	 }
	 else
	 {
		id.style.color='red';
		adr.value='';
		alert('Mail Invalide');
	 }
   }
   
 function required(field,photo_label,photo){

	if(field.innerHTML.length > 0)
	{
		if(photo.value == '')
			photo_label.style.color = "red";
			
		photo.setAttribute("required", true);
	}
 }