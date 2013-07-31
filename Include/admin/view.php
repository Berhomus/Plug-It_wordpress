<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : view.php => Plug-it
*********************************************************-->



<?php
 
 header("Content-Type: image/gif" ); 
 
//incrustage slider

function make_img($src,$title,$desc){
	echo "titre:".$src;
	if(file_exists("../".$src))
	{
		$extension=strrchr($src,'.');
		
		if($extension == ".png")
			$destination = imagecreatefrompng($src);
		else
			$destination = imagecreatefromjpeg($src);
			
		$dossier = imagecreatefrompng("../../images/dossier_g.png");
		$border = imagecreatefrompng("../../images/border_g.png");
		$add = imagecreatefrompng("../../images/add11.png");

		$largeur_dossier = imagesx($dossier);
		$hauteur_dossier = imagesy($dossier);
		$largeur_border = imagesx($border);
		$hauteur_border = imagesy($border);
		$largeur_destination = imagesx($destination);
		$hauteur_destination = imagesy($destination);
		$largeur_add = imagesx($add);
		$hauteur_add = imagesy($add);
		
		$d = imagecreatetruecolor(940, 387);			 
		imagecopyresampled($d, $destination, 0, 0, 0, 0, 940, 387, $largeur_destination, $hauteur_destination);	
		 
		 // On veut placer le logo en bas à droite, on calcule les coordonnées où on doit placer le logo sur la photo
		$destination_x = 50;
		$destination_y =  140;
		$noir = imagecolorallocate($destination, 52, 52, 52);
		$orange = imagecolorallocate($destination, 242, 200, 78);
		 
		imagecopymerge($d, $border, $destination_x, $destination_y, 0, 0, $largeur_border, $hauteur_border, 90);
		 
		// On veut placer le logo en bas à droite, on calcule les coordonnées où on doit placer le logo sur la photo
		$destination_x = 115;
		$destination_y =  150;

		imagecopymerge($d, $dossier, $destination_x, $destination_y, 0, 0, $largeur_dossier, $hauteur_dossier, 100);

		
		/*calcul morceaux a ajouter*/
		
		$label_t = array();
		$label_t = preg_split("/<br>/",$desc);

		$nbr_add_needed = 0;
		$max = 0;
		for($i=0;$i<count($label_t);$i++)
		{//taille tt - marge - taille ligne
			$nbr_add_needed = (330 - 80 - (strlen($label_t[$i])*7.2));
			if($nbr_add_needed < $max)
				$max = $nbr_add_needed; 
		}
		
		if($max<0)
		{
			$max=ceil(($max*-1)/11);
			/*ajout morceaux*/
			$destination_x = 383;
			$destination_y =  238;
			for($i=0;$i<$max;$i++)
			{
				imagecopymerge($d, $add, $destination_x, $destination_y, 0, 0, $largeur_add, $hauteur_add, 90);
				$destination_x += 11;
			}
		}
		
		//blit texte
		
		$label_t = $title; 
		$labelfont = 25;

		ImageTTFText($d, $labelfont, 0, 90, 305, $noir, 'c:/windows/fonts/arialbd.ttf', 
					 $label_t);

		$label_t = array();
		$label_t = preg_split("/<br>/",$desc);
		$labelfont = 11;

		for($i=0;$i<count($label_t);$i++)
		{
			ImageTTFText($d, $labelfont, 0, 90, 335 +$i*($labelfont+6), $noir, 'c:/windows/fonts/arialbd.ttf', 
					 $label_t[$i]);
		}
		
			
		$name = array();
		$name = preg_split("/[\.]+/",$src);

		imagejpeg($d);
		
	}
	else
		echo "Echec Création Image !";
	return "Echec Création Image !";
}

//incrustage mini image
function make_limg($src){	
	if(file_exists("../".$src))
	{ 
		$extension=strrchr($src,'.');
		
		if($extension == ".png")
			$destination = imagecreatefrompng("../".$src);
		else
			$destination = imagecreatefromjpeg("../".$src);
			
		$dossier = imagecreatefrompng("../images/dossier.png");
		$border = imagecreatefrompng("../images/border.png");

		$largeur_dossier = imagesx($dossier);
		$hauteur_dossier = imagesy($dossier);
		$largeur_border = imagesx($border);
		$hauteur_border = imagesy($border);
		$largeur_destination = imagesx($destination);
		$hauteur_destination = imagesy($destination);
		 
		$d = imagecreatetruecolor(280, 170);			 
		imagecopyresampled($d, $destination, 0, 0, 0, 0, 280, 170, $largeur_destination, $hauteur_destination);	
		 
		 // On veut placer le logo en bas à droite, on calcule les coordonnées où on doit placer le logo sur la photo
		$destination_x = 0;
		$destination_y =  121;
		 
		imagecopymerge($d, $border, $destination_x, $destination_y, 0, 0, $largeur_border, $hauteur_border, 70);
		 
		// On veut placer le logo en bas à droite, on calcule les coordonnées où on doit placer le logo sur la photo
		$destination_x = 39;
		$destination_y =  122;

		imagecopymerge($d, $dossier, $destination_x, $destination_y, 0, 0, $largeur_dossier, $hauteur_dossier, 100);	

		$name = array();
		$name = preg_split("/[\.]+/",$src);

		imagejpeg($d);
		
	}
	else
		return "Echec Création Image !";
	return "Echec Création Image !";
}

if(isset($_FILES) and !empty($_FILES))
{	var_dump($_FILES);
	make_img($_FILES['file']['tmp_name'],"nya","yup");
}


?>