<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : admin_solutions.php => Plug-it
*********************************************************-->


<?php
if(isset($_SESSION['id']))
{
	echo '<h2>Edition Menu</h2>';
	
	require_once('./connexionbddplugit.class.php');

	try{
		$rq = connexionbddplugit::getInstance()->query("SELECT * FROM menu ORDER BY position");
	
		echo'<div style="margin:auto;width:900px;margin-top:5%;">';

		$i=1; //délimite les colonnes
		
		echo '<table cellspacing="20" cellpadding="20" class="menu">';
		echo '<tr>';
		while ($donnees = $rq->fetch())
			{
				echo '<td class="menu_change" id="zonedrop">
				<div class="block_ma" id="zonedrag'.$i.'">';				
					
				echo'	
					<p style="font-size:18px;">'.$donnees['nom'].'</p>	
				</div></td>';
				
				$i++;
			}
		echo '</tr>
		</table>
		</div>';
		} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
		}
?>	

	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
	<script>
		 $(function(){
			var i;
			for(i=1;i<=7;i++)
			{
				$('#zonedrag'+i).draggable();
				$('#zonedrop'+i).draggable();
				
				$('#zonedrag'+i).draggable({
				revert: 'invalid'
			});
			}
			
		 });
	</script>
	
<?php	
	
}
else
{
	echo '<h2 style="color:red">Access Forbidden !</h2>';
}
?>
