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
	
	if(isset($_POST) and !empty($_POST))
	{
		$id= (isset($_GET['id'])) ? $_GET['id']:0;
		$ville=$_POST['ville'];
		$courriel=$_POST['courriel'];
		$corps=$_POST['corps'];
		$latitude=$_POST['latitude'];
		$longitude=$_POST['longitude'];
	}
	else if(isset($_GET['id']))
	{
		require_once('./connexionbddplugit.class.php');
		$bdd = connexionbddplugit::getInstance();
		
		try
		{
			$rq = $bdd->prepare("SELECT * FROM contact WHERE id=?");
			$rq->execute(array($_GET['id']));
			$array=$rq->fetch();
		} catch ( Exception $e ) {
			echo "Une erreur est survenue : ".$e->getMessage();
		}
		
		$id=$array['id'];
		$ville=$array['ville'];
		$courriel=$array['courriel'];
		$coordonnees=$array['coordonnees'];
		$latitude=$array['latitude'];
		$longitude=$array['longitude'];
		$require="";
	}
?>


		<form method="post" enctype="multipart/form-data" action="#">
			<table border="0" cellspacing="20" cellpadding="5" style="margin:auto;">				
					<tr>
						<td><label for="ville"><b>Ville <span class="red">*</span></b><br/><small id="lim_ville">(Max 40 caractères)</small></label></td>
						<td><input size="40" type="text" name="ville" id="ville" value="<?php echo $ville; ?>" <?php echo $require; ?> onblur="textLimit(this, 40, lim_ville);"/></td>
					</tr>
					
					<tr>
						<td><label for="courriel"><b>Courriel <span class="red">*</span></b><br/><small id="lim_courriel">(Max 40 caractères)</small></label></td>
						<td><input size="40" type="text" name="courriel" id="courriel" value="<?php echo $courriel; ?>" <?php echo $require; ?> onblur="textLimit(this, 40, lim_courriel);"/></td>
					</tr>
						
					<tr>
						<td><label for="coordonnees"><b>Coordonnées <span class="red">*</span></b><br/></label></td>
						<td><div style="height: 200px; width:300px; overflow:scroll; margin-top:20px;" id="coordonnees" contenteditable="true" <?php echo $require; ?>><?php echo nl2br($coordonnees); ?></div></td>
					</tr>

					<tr>
						<td style="text-align:right;"><input type="submit" name="envoyer" value="Envoyer" /></td>
					</tr>	
			</table>
		</form>
			
		<form action="#" onsubmit="showAddress(this.address.value); return false">
		<center><p>        
		  <input type="text" size="60" name="address" value="36 bis, rue Saint-Fuscien 80000 Amiens" />
		  <input type="submit" value="Chercher" />
		</p></center>
		</form>
		<center>
		  <table  bgcolor="#FFFFCC" width="300">
			<tr>
			  <td><b>Latitude</b></td>
			  <td><b>Longitude</b></td>
			</tr>
			<tr>
			  <td id="lat"></td>
			  <td id="lng"></td>
			</tr>
		  </table>
		</center>
		<br/>
		  <div align="center" id="map" style="width: 700px; height: 500px; margin:auto;"><br/></div>

    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAgrj58PbXr2YriiRDqbnL1RSqrCjdkglBijPNIIYrqkVvD1R4QxRl47Yh2D_0C1l5KXQJGrbkSDvXFA"
      type="text/javascript"></script>
    <script type="text/javascript">
load();
 function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        var center = new GLatLng(49.8853893, 2.3037014);
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