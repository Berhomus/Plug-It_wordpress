<!--********************************************************
Made by : AS Amiens - Bovin Antoine/Bensaid Borhane/Villain Benoit
Last Update : 12/07/2013
Name : Pied.php => Plug-it
*********************************************************-->

<!--<span style="position:absolute;top:40%;left:10%;">Plug-It &copy; 2013 <!-- AddThis Follow BEGIN</span> -->
<div style="margin-left:auto; width:950px; margin-right:auto">
<table style="position:absolute; top:40%;">
	<tr>
		<td>
		Plug-It &copy; 2013
		</td>

		<td>
			<div class="addthis_toolbox addthis_default_style">
				<a class="addthis_button_facebook_follow" addthis:userid="picardie.plugit"></a>
				<!--<a class="addthis_button_linkedin_follow" addthis:userid="plugit" addthis:usertype="company"></a>-->
				<a class="addthis_button_google_follow" addthis:userid="u/0/b/106356585896171032564/106356585896171032564/about"></a>
			</div>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-51e9453d6639bc8c"></script>
				<!-- AddThis Follow END -->
		</td>
	</tr>
</table>
<table style="position:relative; float:right; top:0px; height:40px" cellspacing="0">
	<tr>
		<?php
		if(isset($_SESSION['id']))
		{
			echo '<td class="boutbout" onclick="location.href=\'index.php?page=accueil&dc=1\'">
				Deconnexion
			</td>';
		}
		?>
		<td>
		
		
		</td>
		
		<td class="boutbout" onclick="location.href='index.php?page=admin'">
			Administration
		</td>
		
		<td class="boutbout" onclick="location.href='index.php?page=accueil&sub=mentions'" >
			MENTIONS LEGALES
		</td>
		
		<td class="boutbout" onclick="location.href='http://www.rhinocerose.fr/'" >
			Design - Rhinoc&eacuterose
		</td>
	</tr>

</table>
</div>