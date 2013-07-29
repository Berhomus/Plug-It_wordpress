/*####FONCTION AJOUT DE FACTURES####*/

var nbr_fac = 0;


    function creerElement(ID)
    {
		  var Conteneur = document.createElement('tr');
		  Conteneur.setAttribute('id', 'element' + ID);
		  
		  var td1 = document.createElement('td')
		  var label_num = document.createElement('label');
		  label_num.setAttribute('for', 'num'+ID);
		  label_num.setAttribute('id', 'label_num'+ID);
		  label_num.innerHTML = '<b>Numéro de facture <span class="red">*</span></b><br/><small id="lim_num'+ID+'">(10 caractères)</small>';
		  
		  var td2 = document.createElement('td')
		  var Input_num = document.createElement('input');
		  Input_num.setAttribute('type', 'text');
		  Input_num.setAttribute('name', 'num' + ID);
		  Input_num.setAttribute('id', 'num' + ID);
		  Input_num.setAttribute('onblur', 'textLimit2(this,10, lim_num'+ID+');');
		  Input_num.setAttribute('required', '');
		  Input_num.style.textAlign = "right";

		  var td3 = document.createElement('td')
		  var label_date = document.createElement('label');
		  label_date.setAttribute('for', 'date'+ID);
		  label_date.setAttribute('id', 'label_date'+ID);
		  label_date.innerHTML = '<b>Date <span class="red">*</span></b><br/><small id="lim_date'+ID+'">(JJ/MM/AAAA)</small>';
		  
		  var td4 = document.createElement('td')
		  var Input_date = document.createElement('input');
		  Input_date.setAttribute('type', 'text');
		  Input_date.setAttribute('name', 'date' + ID);
		  Input_date.setAttribute('id', 'date' + ID);
		  Input_date.setAttribute('onblur', 'verif(this, lim_date'+ID+');');
		  Input_date.setAttribute('required', '');
		  Input_date.style.textAlign = "right";
		  
		  var td5 = document.createElement('td')
		  var label_montant = document.createElement('label');
		  label_montant.setAttribute('for', 'montant'+ID);
		  label_montant.setAttribute('id', 'lim_montant'+ID);
		  label_montant.innerHTML = '<b>Montant TTC <span class="red">*</span></b>';
		  
		  var td6 = document.createElement('td')
		  var Input_montant = document.createElement('input');
		  Input_montant.setAttribute('type', 'text');
		  Input_montant.setAttribute('name', 'montant' + ID);
		  Input_montant.setAttribute('id', 'montant' + ID);
		  Input_montant.setAttribute('onblur', 'isNumber(this,lim_montant'+ID+');add_total();');
		  Input_montant.setAttribute('required', '');
		  Input_montant.style.textAlign = "right";

		  td1.appendChild(label_num);
		  td2.appendChild(Input_num);
		  td3.appendChild(label_date);
		  td4.appendChild(Input_date);
		  td5.appendChild(label_montant);
		  td6.appendChild(Input_montant);
		  
		  Conteneur.appendChild(td1);
		  Conteneur.appendChild(td2);
		  Conteneur.appendChild(td3);
		  Conteneur.appendChild(td4);
		  Conteneur.appendChild(td5);
		  Conteneur.appendChild(td6);
		  
		   if(nbr_fac >1)
			{
				var td = document.createElement('td')
				var Delete = document.createElement('input');
				Delete.setAttribute('type', 'button');
				Delete.setAttribute('value', 'X');
				Delete.setAttribute('id', 'delete' + ID);
				Delete.onclick = supprimerElement;
				td.appendChild(Delete);
				Conteneur.appendChild(td);
			}
		  
		  return Conteneur;
    }

	function dernierElement()
    {
		  var Conteneur = document.getElementById('conteneur'), n = 0;
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
					var elementPattern=new RegExp("element([0-9]*)","g");
				  elementNo = parseInt(elementID.replace(elementPattern, '$1'));
				  if(!isNaN(elementNo) && elementNo > n)
				  {
					n = elementNo;
				  }
				}
			  }
			}
		  }
		  return n;
    }

	function ajouterElement()
    {
            var Conteneur = document.getElementById('conteneur');
            if(Conteneur)
            {	
					nbr_fac++;
					document.getElementById('nbr_fac').value = nbr_fac;
                    Conteneur.appendChild(creerElement(dernierElement() + 1))
					
					del = (document.getElementById('delete1')) ? document.getElementById('delete1') : false;
					if(del == false && nbr_fac == 2)
					{
						//ajout supp 1er lign
						var td = document.createElement('td')
						var Delete = document.createElement('input');
						Delete.setAttribute('type', 'button');
						Delete.setAttribute('value', 'X');
						Delete.setAttribute('id', 'delete1');
						Delete.onclick = supprimerElement;
						td.appendChild(Delete);
						document.getElementById('element1').appendChild(td);
					}
            }
    }

    function supprimerElement()
    {
	  var deletePattern=new RegExp("delete([0-9]*)","g");
      var Conteneur = document.getElementById('conteneur');
      var n = parseInt(this.id.replace(deletePattern, '$1'));
      if(Conteneur && !isNaN(n))
      {
        var elementID, elementNo;
        if(Conteneur.childNodes.length > 0)
        {
          for(var i = 0; i < Conteneur.childNodes.length; i++)
          {
            elementID = (Conteneur.childNodes[i].getAttribute) ? Conteneur.childNodes[i].getAttribute('id') : false;
            if(elementID)
            {
				var elementPattern=new RegExp("element([0-9]*)","g");
              elementNo = parseInt(elementID.replace(elementPattern, '$1'));
              if(!isNaN(elementNo) && elementNo  == n)
              {
                Conteneur.removeChild(Conteneur.childNodes[i]);
				nbr_fac--;
				
				document.getElementById('nbr_fac').value = nbr_fac;
				
                updateElements();
				add_total();
                return;
              }
            }
          }
        }
      }  
    }

	
	function updateElements()
    {
		var Conteneur = document.getElementById('conteneur'), n = 0;
		if(Conteneur)
		{
			var elementID, elementNo;
			if(Conteneur.childNodes.length > 0)
			{
				for(var i = 0; i < Conteneur.childNodes.length; i++)
				{
					elementID = (Conteneur.childNodes[i].getAttribute) ? Conteneur.childNodes[i].getAttribute('id') : false;
					if(elementID)
					{
						var elementPattern=new RegExp("element([0-9]*)","g");
						elementNo = parseInt(elementID.replace(elementPattern, '$1'));
						if(!isNaN(elementNo))
						{
							n++
							Conteneur.childNodes[i].setAttribute('id', 'element' + n);
							
							document.getElementById('label_num'+elementNo).setAttribute('for','num'+n);
							document.getElementById('label_num'+elementNo).setAttribute('id','label_num'+n);
							
							
							document.getElementById('num'+elementNo).setAttribute('name','num'+n);
							document.getElementById('num'+elementNo).setAttribute('id','num'+n);
							document.getElementById('lim_num'+elementNo).setAttribute('id','lim_num'+n);
							
							
							document.getElementById('label_date'+elementNo).setAttribute('for','date'+n);
							document.getElementById('label_date'+elementNo).setAttribute('id','label_date'+n);
							document.getElementById('lim_date'+elementNo).setAttribute('id','lim_date'+n);
							
							
							document.getElementById('date'+elementNo).setAttribute('name','date'+n);
							document.getElementById('date'+elementNo).setAttribute('id','date'+n);
							
							
							document.getElementById('lim_montant'+elementNo).setAttribute('for','montant'+n);
							document.getElementById('lim_montant'+elementNo).setAttribute('id','lim_montant'+n);
							
							
							document.getElementById('montant'+elementNo).setAttribute('name','montant'+n);
							document.getElementById('montant'+elementNo).setAttribute('id','montant'+n);
							
							
							if(nbr_fac >1)
							{
								del = (document.getElementById('delete'+elementNo)) ? document.getElementById('delete'+elementNo) : false;
								if(del)
								{
									document.getElementById('delete'+elementNo).setAttribute('id','delete'+n);
								}
								else
								{
									var td = document.createElement('td')
									var Delete = document.createElement('input');
									Delete.setAttribute('type', 'button');
									Delete.setAttribute('value', 'X');
									Delete.setAttribute('id', 'delete' + n);
									Delete.onclick = supprimerElement;
									td.appendChild(Delete);
									Conteneur.childNodes[i].appendChild(td);
								}
							}
							else
							{
								del = (document.getElementById('delete'+elementNo)) ? document.getElementById('delete'+elementNo) : false;
								if(del)
								{
									del.parentNode.parentNode.removeChild(del.parentNode);
									delete(del);
								}
							}
						}
					}
				}
			}
		}
	}

/*####FONCTION MODIF PRIX TOTAL####*/

function add_total(){
	
	var i;
	var somme = 0.00;
	
	for(i=1;i<=nbr_fac;i++)
	{
		
		somme += (document.getElementById('montant'+i).value != "") ? parseFloat(document.getElementById('montant'+i).value):0;
	}
	somme=Math.round(somme*100)/100;
	document.getElementById('montanttot').value = somme;
	format_number(document.getElementById('montanttot'));
}

function isNumber(field,id){
	var regNbr = new RegExp('^[0-9]*([\.,][0-9]{0,2})?$','i');

	if (!regNbr.test(field.value) || field.value.length == 0) //cas où la valeur n'est pas du tout un nombre
	{
		field.value = ""; // la valeur devient nulle    
		id.style.color = "red";
	}
	else
	{
		id.style.color = "green";

		format_number(field);
	}
} 
	
function format_number(field)
{
    var value = field.value.replace(",",".");
    
    var entiere = parseInt(value);
    var decimale = field.value.substring(value.lastIndexOf("."));
    if(decimale != entiere)
    {
      var i;
      for(i = decimale.length;i<3;i++)
        value += "0";
    }
    else
    {
      value += ".00";
    }
    
    field.value = value;
} 	
	
/*####VERFICATION DU FORMAT DATE####*/

function verif(valeur, soustitre){
    var date_pas_sure = valeur.value;
    var format = /^(\d{1,2}\/){2}\d{4}$/;
    if(!format.test(date_pas_sure))
	{
		valeur.value='';
		soustitre.style.color='red';
	}
    else
	{
        var date_temp = date_pas_sure.split('/');
        date_temp[1] -=1;
        var ma_date = new Date();
        ma_date.setFullYear(date_temp[2]);
        ma_date.setMonth(date_temp[1]);
        ma_date.setDate(date_temp[0]);
        if(ma_date.getFullYear()==date_temp[2] && ma_date.getMonth()==date_temp[1] && ma_date.getDate()==date_temp[0])
		{
			soustitre.style.color='green';
        }
        else
		{
			valeur.value='';
			soustitre.style.color='red';
        }
    }
}