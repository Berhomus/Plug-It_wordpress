
<script type="text/javascript" src="js/fct_de_trt_txt.js"></script>

<?php
	$ordre=0;
		$ordre=$_POST['ordre'];
		try{
		} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
		}
		
			try{
			} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
			}
			$ordre=$array['ordre'];
			<tr>
				<td><label for="ordre"><b>Position</b><br/><small>(1ere position par défaut)</small></label></td>
				<td>
					<select name="ordre" id="ordre">
						<?php
						
							require_once('./connexionbddplugit.class.php');
							try{
								$rq=connexionbddplugit::getInstance()->query("SELECT COUNT(id) AS nombre FROM services");
								$rq=$rq->fetch();
							} catch ( Exception $e ) {
								echo "Une erreur est survenue : ".$e->getMessage();
							}
							
							$var=($type=='create') ? $rq['nombre']+1 : $rq['nombre'];
							for($i=1;$i<=$var;$i++)
							{
								if(($ordre==0 && $i==1)|| $ordre==$i)
								{
									echo '<option value="'.$i.'" Selected="">'.$i.'</option>';
								}
								else
								{
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
							}
							
						?>
					</select>
				</td>
			</tr>
			