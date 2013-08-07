<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : Index.php => Plug-it
*********************************************************-->

<?php
	session_start();
	
	include("function/disconnect_f.php");
	
	disconnect();
	
	
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<link rel="icon" type="image/png" href="./images/favicon.png">
		<link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico">
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />

		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		
		<?php 
		
			$protocol = "http://";
			$protocol_safe = "https://";
			$current_loc = "127.0.0.1/plug-it_wordpress/";
			
			$link_unsafe = $protocol.$current_loc;
			$link_safe = $protocol_safe.$current_loc;
		
			require_once('./connexionbddplugit.class.php');
			
			$bdd = connexionbddplugit::getInstance();
			
			if(!isset($_GET['page']))
				$page = 'accueil';
			else
				$page=$_GET['page'];
			
			try{
				$rq = $bdd->prepare("SELECT count(id) as nbr FROM menu WHERE baseName = ?");
				$rq->execute(array($page));
				$ar = $rq->fetch();
				if($ar['nbr'] == 1)
				{
					$rq = $bdd->prepare("SELECT * FROM menu WHERE baseName = ?");
					$rq->execute(array($page));
					$ar = $rq->fetch();
					$s = $ar['nom'];
					$p = $ar['meta'];
				}
			}catch(Exception $e){
				echo "Une erreur est survenue : ".$e->getMessage();
			}
		?>
		
		<title>Plug-it
			<?php if(isset($s))
				echo " - ".$s;
			?>
		</title>
		<?php
			if(isset($s))
				echo '<meta name="description" content="'.$p.'" />';
		?>
	
		<link rel="stylesheet" href="css/iview.css" />
		<link rel="stylesheet" href="css/skin 1/style.css" />
		<link rel="stylesheet" href="css/styles.css" />
		<link type="text/css" rel="stylesheet" href="styles/index.css"/>
		
		<script src="js/jquery-1.7.1.min.js"></script>
		
		<script type="text/javascript" src="js/raphael-min.js"></script>
		<script type="text/javascript" src="js/jquery.easing.js"></script>
		
		<script src="js/iview.js"></script>
		
		<script>
			$(document).ready(function(){
				$('#iview').iView({
					pauseTime: 3000,
					directionNav: false,
					controlNav: true,
					tooltipY: -15
				});
			});
		</script>
		
		
		
	</head>
	<body>
		<div class="Banniere" id="head">
			<?php
				INCLUDE("include/common/banniere.php");
			?>
		</div>
		
		<div class="Corps" id="content"
		<?php
			if((isset($_GET['page']) and $_GET['page'] != 'accueil')or(isset($_GET['sub']) and $_GET['sub'] != 'main'))
				echo 'style="padding-top:5%;width:1000px;margin:auto;"';
			else
				echo 'style="min-width:1350px; width:100%;"';
		?>
		>
			<?php
				INCLUDE("include/common/corps.php");
			?>
		</div>
		
		<div class="Pied" id="footer">
			<?php
				INCLUDE("include/common/pied.php");
			?>
		</div>
	</body>
	

</html>