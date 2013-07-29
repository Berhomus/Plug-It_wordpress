<?php

class connexionbddplugit
{
	private static $connexion = null;
	
	private function connexionbddplugit () {}
	
	public static function getInstance ()
	{
		if (is_null(self::$connexion))
		{
			try
			{
				$connexion = new PDO('mysql:host=localhost;dbname=plugit','root','');
			} catch ( Exception $e ) 
			{
			echo "Connection à MySQL impossible : ", $e->getMessage();
			die();
			}
			$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$connexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$connexion->exec("SET CHARACTER SET utf8");
		}
		
		return $connexion;
	}
}

?>