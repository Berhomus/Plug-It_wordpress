<?php

if(isset($_POST['DATA']))
{
	include("include/webaffaires/call_response.php");
	
	if(isset($response_code))//si transaction trt ?
	{
	
	}
}
else
	echo '<h2>Page Unreachable</h2>';
	
?>