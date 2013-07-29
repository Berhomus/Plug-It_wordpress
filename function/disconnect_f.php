<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 26/06/2013
Name : disconnect_f.php => Plug-it
*********************************************************-->

<?php
	function disconnect()
	{
		if(isset($_GET['dc']) and $_GET['dc'] == 1)
		{
			session_destroy();
			session_start();
		}
	}
?>