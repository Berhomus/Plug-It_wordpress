<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 26/06/2013
Name : connect_f.php => Plug-it
*********************************************************-->

<?php
function connect()
{	
	if(isset($_POST['login']) and isset($_POST['pass']))
	{
		require_once('./connexionbddplugit.class.php');

		
		$_POST['login'] = htmlspecialchars($_POST['login']);
		$_POST['pass'] = htmlspecialchars($_POST['pass']); 
		//securité
		$_POST['login'] = mysql_real_escape_string($_POST['login']);
		$_POST['pass'] = mysql_real_escape_string($_POST['pass']); 
		
		
		$login = $_POST["login"];
		try{
			$rq = connexionbddplugit::getInstance()->query("SELECT COUNT(login) AS cpt FROM admin WHERE login ='$login'");//selection données
			$array = $rq->fetch();
		} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
		}
			
		if($array['cpt'] == 0) 
		{
			return -1;//pas de pseudo
		}
		else
		{
			try{
				$rq = connexionbddplugit::getInstance()->query("SELECT * FROM admin WHERE login ='$login'");
				$array = $rq->fetch();
			} catch ( Exception $e ) {
				echo "Une erreur est survenue : ".$e->getMessage();
			}
			if(MD5($_POST['pass']) == $array['mdp_md5'])//verification password
			{
				$_SESSION['id'] = $array['id'];
				$_SESSION['login'] = $array['login'];		
				
				return 0;//ok
			}
			else
			{
				return -2;//mauvais pass
			}
		}
		
	}
}
?>