<!DOCTYPE html>
<?php


	if(isset($_POST['username']) )
	{
		if(isset($_POST['username'])){ $name = $_POST['username']; } 
		if(isset($_POST['h1'])){ $lat = $_POST['h1']; } 
		if(isset($_POST['h2'])){ $lng = $_POST['h2']; } 
		
			$con=mysql_connect("localhost","root","");
			mysql_select_db("mapsdb",$con);
			
			
			mysql_real_escape_string($name);
			mysql_real_escape_string($lat);
			mysql_real_escape_string($lng);
			
			// Check connection
			if (mysqli_connect_errno($con))
			  {
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			  }

			$query = "INSERT INTO tutors (Name, Lat, Lng)VALUES ('$name','$lat' ,'$lng')";
		                       
		
		$result = mysql_query($query)or die(mysql_error());;
		
		if(! $result )
		{
		  die('Could not enter data: ' . mysql_error());
		}
		echo "Entered data successfully\n";
		

		mysql_close($con);
	}
?>

<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
    #map-canvas 
	{
		height: 600px;
		width:100%;
		padding: 0;
    }
	input[type="text"] 
	{
		width: 600px;
	}
		
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
var geocoder = new google.maps.Geocoder();
var map;
var icon1 = "imageA.png";
var marker;

function geocodePosition(pos) {geocoder.geocode({latLng: pos}, function(responses) {

		if (responses && responses.length > 0) 
		{
		  updateMarkerAddress(responses[0].formatted_address);
		} 
		else 
		{
		  updateMarkerAddress('Cannot determine address at this location.');
		}
  });
}

function getcodeAddress(address){geocoder.geocode({address: address}, function(responses) {

	
	});
}


function codeAddress() {
  var address = document.getElementById('address').value;
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
	  marker.setPosition(results[0].geometry.location);
	  map.setCenter(results[0].geometry.location);
    } else {
      alert('Geocode was not successful. Please try again');
    }
  });
}

function updateMarkerStatus(str) {
  document.getElementById('markerStatus').innerHTML = str;
}

function updateMarkerPosition(latLng) {
  document.getElementById('info').innerHTML = [
    latLng.lat(),
    latLng.lng()
  ].join(', ');
  
  updateHiddenFeild(latLng);
}

function updateMarkerAddress(str) {
  document.getElementById('address').value = str;
}

function updateHiddenFeild(latLng) {
  document.getElementById('h1').value = latLng.lat();
  document.getElementById('h2').value = latLng.lng();
}

function initialize() 
{
  var mapOptions = {
    zoom: 18,
    center: new google.maps.LatLng(19.435388, -99.135907),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
	  
	  //Initialize the default location 
	  //karachi 24.89338 , 67.02806
	  var myLatlng = new google.maps.LatLng(19.435388,-99.135907);

	marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'hi',
	  draggable: true
	  // icon: icon1
  });
  
	//update shit 
	updateHiddenFeild(myLatlng);
    geocodePosition(myLatlng);
	
	
	//listeners
	google.maps.event.addListener(marker, 'mouseover', function() {
		marker.setIcon(icon1);
	});
  
  	google.maps.event.addListener(marker, 'mouseout', function() {
		marker.setIcon();
	});
  
	google.maps.event.addListener(marker, 'drag', function() {
		updateHiddenFeild(marker.getPosition());
	
	});
  
	google.maps.event.addListener(marker, 'dragend', function() {
		geocodePosition(marker.getPosition());
	});
  
	  
}

google.maps.event.addDomListener(window, 'load', initialize);


 </script>
  </head>
  <body>
  <div id="map-canvas"></div>

	<div id="form">
	
		<form name="input" action="index.php" method="post">
		Username :  <input type="text" name ="name"id = "name" > <br>
		Address: <input type="text" name ="address" id = "address"><input type="button" onclick="codeAddress()" value="search" /><br>
		<input type="hidden" name = "h1" id = "h1" >
		<input type="hidden" name = "h2" id = "h2" >
		<br>
		<input type="submit" value="Save">
		</form>
	</div>
	
  </body>
</html>