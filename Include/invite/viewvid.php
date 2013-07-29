

<?php
	if(isset($_GET['vid']))
	{
		$path = $_GET['vid'];
		$name = basename($_GET['vid']);
		$pos1 = stripos($path, 'videos/');

		if($pos1 === false || file_exists($_GET['vid']))
		{
			
			/*mediaplayer*/
			//echo '<object type="application/x-mplayer2" style="width: 200px; height: 200px;" data="'.$path.'">
				//<param name="'.$name.'" value="'.$path.'"/>
				//</object>';
			/*RealAudio*/
			//echo '<embed type="audio/x-pn-realaudio-plugin" src="'.$path.'" controls="all" console="video"/>';
			
			/*Quick Time*/
			// echo '<object type="video/quicktime" style="width: 200px; height: 200px;" data="'.$path.'">
				// <param name="'.$path.'" value="'.$path.'"/>
				// </object>';		
		
			//HTML5

			echo'<video src="'.$path.'" controls style="width:100%;height:100%;margin:auto;" id="lecteur">
				Votre navigateur n\'est pas compatible avec le HTML 5, désolé.
			</video>';
		}
		else
			echo "Video Inexistante !";
	}
	else
		echo "Pas de Video !";
		