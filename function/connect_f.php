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

		$bdd= connexionbddplugit::getInstance();
		
		$login = $_POST["login"];
		try{
			$rq = $bdd->prepare("SELECT COUNT(login) AS cpt FROM admin WHERE login =?");//selection données
			$rq->execute(array($login));
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
				$rq = $bdd->prepare("SELECT * FROM admin WHERE login =?");//selection données
				$rq->execute(array($login));
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