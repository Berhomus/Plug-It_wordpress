<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 05/07/2013
Name : update_ordre.php => Plug-it
*********************************************************-->

<?php
	function update_ordre($deb,$fin,$pas,$bdd)
	{
		if($fin==0)
		{
			try{
				$rq=connexionbddplugit::getInstance()->query("SELECT COUNT(id) AS nbre FROM ".$bdd."");
				$rq=$rq->fetch();
			} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
			}
			$fin=$rq['nbre'];
		}
		
		if($pas<0)
		{
			$swap=$fin;
			$fin=max($deb,$fin);
			$deb=min($deb,$swap);
			for($i=$deb;$i<=$fin;$i=$i-$pas)
			{
				try{
					$rq = connexionbddplugit::getInstance()->query("SELECT id FROM ".$bdd." WHERE ordre='".$i."'");
					$ar = $rq->fetch();
				} catch ( Exception $e ) {
					echo "Une erreur est survenue : ".$e->getMessage();
				}
				try{	
				connexionbddplugit::getInstance()->query("UPDATE ".$bdd." SET ordre='".($i+$pas)."' WHERE id='".$ar['id']."'");
				} catch ( Exception $e ) {
					echo "Une erreur est survenue : ".$e->getMessage();
				}
			}
		}
		else
		{
			$swap=$fin;
			$fin=min($deb,$fin);
			$deb=max($deb,$swap);
			for($i=$deb;$i>=$fin;$i=$i-$pas)
			{
				try{
					$rq = connexionbddplugit::getInstance()->query("SELECT id FROM ".$bdd." WHERE ordre='".$i."'");
					$ar = $rq->fetch();
				} catch ( Exception $e ) {
					echo "Une erreur est survenue : ".$e->getMessage();
				}
				
				try{
					connexionbddplugit::getInstance()->query("UPDATE ".$bdd." SET ordre='".($i+$pas)."' WHERE id='".$ar['id']."'");
				} catch ( Exception $e ) {
					echo "Une erreur est survenue : ".$e->getMessage();
				}
			}
		}
		
	}
?>