<h2 class="grdtitre">Gestion des Pages Contact</h2>

<?php
if(isset($_SESSION['id']))
{
	require_once('./connexionbddplugit.class.php');
	$bdd = connexionbddplugit::getInstance();
?>

<script type="text/javascript" src="js/fct_de_trt_txt.js"></script>

<?php
	$id=0;
	$ville="";
	$courriel="";
	$coordonnees="";
	$latitude=0;
	$longitude=0;
	$require="required";
	$address="";
	$modif = "create";
	
	if(isset($_GET['id']))
	{
		require_once('./connexionbddplugit.class.php');
		$bdd = connexionbddplugit::getInstance();
		
		try
		{
			$rq = $bdd->prepare("SELECT * FROM contact WHERE id=?");
			$rq->execute(array($_GET['id']));
			$array=$rq->fetch();
			$id=$array['id'];
			$ville=$array['ville'];
			$courriel=$array['courriel'];
			$coordonnees=$array['coordonnees'];
			$latitude=$array['latitude'];
			$longitude=$array['longitude'];
			$require="";
			$modif = "modif&id=".$id;
		} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
		}	
	}
?>

	<div style="padding-bottom:30px;">
		<form method="post" action="traitement/trt_contact.php?mode=<?php echo $modif; ?>" onSubmit="document.getElementById('latitude').value = document.getElementById('lat').innerHTML; document.getElementById('longitude').value = document.getElementById('lng').innerHTML;">
			<table border="0" cellspacing="20" cellpadding="5" style="width:450px; margin-top:30px; float:left;">				
					<tr style="height:40px;">
						<td><label for="ville"><b>Ville <span class="red">*</span></b><br/><small id="lim_ville">(Max 40 caractères)</small></label></td>
						<td><input size="40" type="text" name="ville" id="ville" value="<?php echo $ville; ?>" <?php echo $require; ?> onblur="textLimit(this, 40, lim_ville);"/></td>
					</tr>
					
					<tr style="height:40px;">
						<td><label for="courriel"><b>Courriel <span class="red">*</span></b><br/><small id="lim_courriel">(Max 40 caractères)</small></label></td>
						<td><input size="40" type="text" name="courriel" id="courriel" value="<?php echo $courriel; ?>" <?php echo $require; ?> onblur="textLimit(this, 40, lim_courriel);"/></td>
					</tr>
						
					<tr style="height:40px;">
						<td><label for="coordonnees"><b>Coordonnées <span class="red">*</span></b><br/></label></td>
						<td><textarea col="20" rows="4" style="height: 200px; width:300px; overflow:scroll; margin-top:20px; resize:none;" name="coordonnees" id="coordonnees" <?php echo $require; ?>><?php echo $coordonnees; ?></textarea></td>
					</tr>

					<tr style="height:40px;">
						<td style="text-align:right;"><input type="submit" name="envoyer" value="Envoyer" /></td>
					</tr>
					<?php
					echo '
					<input type="hidden" id="latitude" name="latitude" value="'.$latitude.'" />
					<input type="hidden" id="longitude" name="longitude" value="'.$longitude.'" />';
					?>
			</table>
		</form>
	
		<form action="#" onsubmit="showAddress(this.address.value); return false">
			<table style="width:450px; float:right; margin-top:30px; margin-bot:30px;">
				<tr style="height:40px;">
					<td colspan="2">        
						<?php echo '<input type="text" size="60" name="address" value="'.$address.'" />'; ?>
					</td>
					<td>
						<input type="submit" value="Chercher" />
					</td>
				</tr>
		<tr style="height:40px;">
			<td colspan="4"><table  bgcolor="#FFFFCC" width="300">
			<tr>
			  <td><b>Latitude</b></td>
			  <td><b>Longitude</b></td>
			</tr>
			<tr>
			<?php
			echo '
			  <td id="lat" >'.$latitude.'</td>
			  <td id="lng" >'.$longitude.'</td>';
			?>
			</tr>
		  </table></td>
		</tr>
		<tr>
		  <td colspan="4"><div align="center" id="map" style="width: 450px; height: 450px;"></div></td>
		</tr>
		</table>
		</form>
	</div>
	
	
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAgrj58PbXr2YriiRDqbnL1RSqrCjdkglBijPNIIYrqkVvD1R4QxRl47Yh2D_0C1l5KXQJGrbkSDvXFA"
      type="text/javascript"></script>
    <script type="text/javascript">
	load();
 function load() {
      if (GBrowserIsCompatible()) {
		
        var map = new GMap2(document.getElementById("map"));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
		var lati = document.getElementById('lat').innerHTML;
		var lngi = document.getElementById('lng').innerHTML;

        var center = new GLatLng(lati, lngi);
        map.setCenter(center, 15);
        geocoder = new GClientGeocoder();
        var marker = new GMarker(center, {draggable: true});  
        map.addOverlay(marker);
        document.getElementById("lat").innerHTML = center.lat().toFixed(7);
        document.getElementById("lng").innerHTML = center.lng().toFixed(7);

   GEvent.addListener(marker, "dragend", function() {
       var point = marker.getPoint();
       map.panTo(point);
       document.getElementById("lat").innerHTML = point.lat().toFixed(7);
       document.getElementById("lng").innerHTML = point.lng().toFixed(7);

        });


  GEvent.addListener(map, "moveend", function() {
    map.clearOverlays();
    var center = map.getCenter();
    var marker = new GMarker(center, {draggable: true});
    map.addOverlay(marker);
    document.getElementById("lat").innerHTML = center.lat().toFixed(7);
    document.getElementById("lng").innerHTML = center.lng().toFixed(7);


  GEvent.addListener(marker, "dragend", function() {
      var point =marker.getPoint();
      map.panTo(point);
      document.getElementById("lat").innerHTML = point.lat().toFixed(7);
      document.getElementById("lng").innerHTML = point.lng().toFixed(7);

        });
 
        });

      }
    }

    function showAddress(address) {
    var map = new GMap2(document.getElementById("map"));
       map.addControl(new GSmallMapControl());
       map.addControl(new GMapTypeControl());
       if (geocoder) {
        geocoder.getLatLng(
          address,
          function(point) {
            if (!point) {
              alert(address + " not found");
            } else {
    document.getElementById("lat").innerHTML = point.lat().toFixed(7);
    document.getElementById("lng").innerHTML = point.lng().toFixed(7);
   map.clearOverlays()
   map.setCenter(point, 14);
   var marker = new GMarker(point, {draggable: true});  
   map.addOverlay(marker);

  GEvent.addListener(marker, "dragend", function() {
      var pt = marker.getPoint();
      map.panTo(pt);
      document.getElementById("lat").innerHTML = pt.lat().toFixed(7);
      document.getElementById("lng").innerHTML = pt.lng().toFixed(7);
        });


  GEvent.addListener(map, "moveend", function() {
    map.clearOverlays();
    var center = map.getCenter();
    var marker = new GMarker(center, {draggable: true});
    map.addOverlay(marker);
    document.getElementById("lat").innerHTML = center.lat().toFixed(7);
    document.getElementById("lng").innerHTML = center.lng().toFixed(7);

  GEvent.addListener(marker, "dragend", function() {
     var pt = marker.getPoint();
     map.panTo(pt);
    document.getElementById("lat").innerHTML = pt.lat().toFixed(7);
    document.getElementById("lng").innerHTML = pt.lng().toFixed(7);
        });
 
        });

            }
          }
        );
      }
    }
    </script>
  <script type="text/javascript">
//<![CDATA[
var gs_d=new Date,DoW=gs_d.getDay();gs_d.setDate(gs_d.getDate()-(DoW+6)%7+3);
var ms=gs_d.valueOf();gs_d.setMonth(0);gs_d.setDate(4);
var gs_r=(Math.round((ms-gs_d.valueOf())/6048E5)+1)*gs_d.getFullYear();
var gs_p = (("https:" == document.location.protocol) ? "https://" : "http://");
document.write(unescape("%3Cscript src='" + gs_p + "s.gstat.orange.fr/lib/gs.js?"+gs_r+"' type='text/javascript'%3E%3C/script%3E"));
//]]>
</script>

<div style="height:40px;">
</div>
<?php
}
else
{
	echo '<h2 style="color:red">Access Forbidden !</h2>';
}
?>